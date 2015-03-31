<?php

namespace Simplight;

/**
 * Model
 * データやビジネスロジックを管理するクラス 
 *
 * @author https://github.com/miyayamajun
 */
abstract class Model
{
    /**
     * クラス定数
     */
    const ACCESSOR_NAME = '';

    /**
     * クラス変数
     */
    protected static $_instance = array();

    /**
     * インスタンス変数
     */
    protected $_primary_key;
    protected $_data;
    protected $_diff_data;
    protected $_save_data;

    /**
     * インスタンスを生成するメソッド(詳細は小クラスにて定義)
     *
     * @return ModelObject
     */
    public static function create()
    {
        if  (!isset(static::$_instance[0])) {
            static::$_instance[0] = new static();
        }
        return static::$_instance[0];
    }

    /**
     * コンストラクタ
     * @param array $primary_key
     *
     * @return ModelObject
     */   
    protected function __construct($primary_key = array())
    {
        $this->_primary_key = $primary_key;   
    }

    /**
     * データが存在するかチェックする
     * @param mixed $key
     *
     * @return bool
     */
    public function isExists($key)
    {
        if (!$this->_isFieldKey($key)) {
            $this->_setData();
            return isset($this->_data[$key]);
        }
        return false;
    }

    /**
     * データを取得する
     * @param mixed $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if (!$this->_isFieldKey($key)) {
            $this->_setData();
            return isset($this->_data[$key]) ? $this->_data[$Key] : null;
        }
    }

    /**
     * データをセットする
     * @param mixed $key
     * @param mixed $value
     *
     * @return void
     */
    public function set($key, $value)
    {
        if ($this->_isFieldKey($key)) {
            $this->_setData();
            if ($this->_isDiffFieldKey($key)) {
                $diff = $value - $this->_data[$key];
                $this->_diff_data[$key] = $diff;
                $this->_data[$key] = $value;
            } else {
                $this->_data[$key] = $value;
            }
        }
    }

    /**
     * @todo
     */
    public function insert() {}

    /**
     * @todo
     */
    public function update() {}

    /**
     * @todo
     */
    public function save() {}

    /**
     * @todo
     */
    public function delete() {}

    /**
     * 保存用連想配列をセットする
     *
     * @return void
     */
    protected function _setSaveData()
    {
        $this->_save_data = $this->_data;

        // 差分保存データがある時は差し替え
        if (is_array($this->_diff_data) && !empty($this->_diff_data)) {
            foreach ($this->_diff_data as $key => $value) {
                $this->_save_data[$key] = $value;
            }
        }
    }

    /**
     * フィールドリストに登録されているキーか調べる
     * @param mixed $key
     *
     * @return bool
     */
    protected function _isFieldKey($key)
    {
        $field_list = $this->_getFieldList();
        return isset($field_list[$key]);
    }

    /**
     * フィールドリストを取得する
     *
     * @return array
     */
    protected function _getFieldList()
    {
        $accessor_name = static::ACCESSOR_NAME;
        return $accessor_name::$_field_list;
    }

    /**
     * 差分保存対象フィールドリストに登録されているキーか調べる
     * @param mixed $key
     *
     * @return bool
     */
    protected function _isDiffFieldKey($key)
    {
        $field_list = $this->_getDiffFieldList();
        return isset($field_list[$key]);
    }

    /**
     * 差分保存対象フィールドリストを取得する
     *
     * @return array
     */
    protected function _getDiffFieldList()
    {
        $accessor_name = static::ACCESSOR_NAME;
        return $accessor_name::$_diff_field_list;
    }

    /**
     * データソースからデータを取得してセットする
     *
     * @return void
     */
    protected function _setData()
    {
        if (!is_null($this->_data)) {
            return;
        }
        $accessor_name = static::ACCESSOR_NAME;
        $accessor      = $accessor_name::create();
        $this->_data   = $accessor->findAll($this->_primary_key);
    }
}
