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
     * データが存在するかチェックする
     * @param mixed $key
     *
     * @return bool
     */
    public function isExists($key)
    {
        $accessor_name = static::ACCESSOR_NAME;
        if (isset($accessor_name::$_field_list[$key])) {
            $this->_setData();
        }
        return isset($this->_data[$key]);
    }

    /**
     * データを取得する
     * @param mixed $key
     *
     * @return mixed
     */
    public function get($key)
    {
        $accessor_name = static::ACCESSOR_NAME;
        if (isset($accessor_name::$_field_list[$key])) {
            $this->_setData();
        }
        if (isset($this->_data[$key])) {
            return $this->_data[$key];
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
        $accessor_name = static::ACCESSOR_NAME;
        if (isset($accessor_name::$_field_list[$key])) {
            $this->_setData();
            $this->_data[$key] = $value;
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
