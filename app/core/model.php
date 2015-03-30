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
    protected static $_instance   = array();
    protected static $_field_list = array();

    /**
     * インスタンスメンバ
     */
    protected $_primary_key;
    protected $_data;

    /**
     * インスタンスを生成するメソッド(詳細は小クラスにて定義)
     *
     * @return ModelObject
     */
    public static function create()
    {
        return new static();
    }

    /**
     * コンストラクタ
     * @param array $primary_key
     *
     * @return ModelObject
     */   
    protected function __construct($primary_key = array())
    {
        $this->_setPrimaryKey($primary_key);
    }

    /**
     * データアクセス用のプライマリキーをセットする
     * @param array $primary_key
     *
     * @return void
     */
    protected function _setPrimaryKey($primary_key)
    {
        $this->_primary_key = $primary_key;   
    }

    /**
     * データを取得する
     * @param mixed $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if (isset(static::$_field_list[$key])) {
            $this->_setData();
        }
        if (isset($this->_data[$key])) {
            return $this->_data[$key];
        }
    }

    /**
     * データソースからデータを取得してセットする
     *
     * @return void
     */
    protected function _setData()
    {
        if (is_null($this->_data)) {
            return;
        }
        $accessor_name = static::ACCESSOR_NAME;
        $accessor      = $accessor_name::create();
        $this->_data   = $accessor->findAll($this->_primary_key);
    }
}
