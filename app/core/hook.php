<?php

namespace Simplight;

/**
 * \Simplight\Hook
 * @description コントローラ処理前に指定したページにて処理を実行するクラス
 *
 * @author https://github.com/miyayamajun
 */
final class Hook
{
    private $_hook_list;
    private $_app;

    public function __construct($app)
    {
        if (!$app instanceof \Simplight\App) {
            throw new \Exception('Appインスタンス以外からの呼出に対応していません', STATUS_CODE_ERROR);
        }
        $this->_app = $app;
        $this->_setup();
    }

    /**
     * _hook_listに登録されたHookを処理する
     */
    public function execute()
    {
        foreach ($this->_hook_list as $hook) {
            $hook->execute();
        }
    } 

    /**
     * _hook_listをセットする
     */
    private function _setup()
    {
        $this->_hook_list = $this->_getHookList();
    }

    /**
     * jsonから実行可能なHookをリストに登録する
     * @return array Hookを継承したオブジェクトのリスト
     */
    private function _getHookList()
    {
        $tmp_json         = file_get_contents(JSON_DIR . '/hook.json');
        $json             = mb_convert_encoding($tmp_json, 'utf8');
        $config_list      = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true);
        $active_hook_list = array();

        foreach ($config_list as $map) {
            if ($this->_app->getTimestamp() < strtotime($map['open_date'])) {
                continue;
            }
            if ($this->_app->getTimestamp() > strtotime($map['close_date'])) {
                continue;
            }
            $hook_class_name = '\\Simplight\\Hook\\' . ucfirst($map['name']);
            $active_hook_list[]  = new $hook_class_name($this->_app);
        }
        return $active_hook_list;
    }
}

/**
 * \Simplight\HookBase
 * @description Hookの根幹クラス
 *
 * @author https://github.com/miyayamajun
 */
class HookBase
{
    /**
     * 処理を実行するコントローラ名とアクション名を _ (アンダースコア) で繋ぐ
     * 全てが対象の時は * (アスタリスクを指定する)
     */
    public static $target_action_list = array(
        '*_*',
    );

    private $_app;

    public function __construct($app)
    {
        $this->_app = $app;
    }

    /**
     * target_action_listをもとに実行可能かチェックする
     */
    protected function _validate()
    {
        $request_controller_name = $this->_app->request->getControllerName();
        $request_action_name     = $this->_app->request->getActionName();
        $target_action_list      = static::$target_action_list;

        foreach ($target_action_list as $target_action) {
            $target_list            = explode('_', $target_action);
            $target_controller_name = $target_list[0];
            $target_action_name     = $target_list[1];

            $controller_valid = '*' === $target_controller_name || $request_controller_name === $target_controller_name;
            $action_valid     = '*' === $target_action_name || $request_action_name === $target_action_name;
            if ($controller_valid && $action_valid) {
                return true;
            }
        }

        return false;
    }

    /**
     * Hookの実行処理本体。子クラスで処理を記述する
     */
    public function execute()
    {
        if (!$this->_validate()) {
            return;
        }
    }
}
