<?php

namespace Simplight\Controller;

use Simplight\Model;

/**
 * \Simplight\Controller\Root
 * @description / or /root アクセス時に処理するコントローラ 
 *
 * @author https://github.com/miyayamajun
 */
class Root extends \Simplight\Controller
{
    public function root()
    {
        $test = \Simplight\Accessor\UserAccount::create();
        $result = $test->findAll(array('user_id' => 200));

        foreach ($result as $key => $value) {
            dump($value);
        }
    }

    public function hoge()
    {
        var_dump($this->_get, $this->_post);
    }

    public function insert()
    {
        $test = \Simplight\Accessor\UserAccount::create();
        $args = array(
            'user_id' => 210,
            'email' => 'abcdefghij@bbb.com',
            'password_digest' => 'abcd',
            'memo' => 'a',
            'value' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        );
        $test->insert($args);
    }

    public function update()
    {
        $test = \Simplight\Accessor\UserAccount::create();
        $where = array(
            'user_id' => 200,
        );
        $data = array(
            'email' => 'bbbbbbbbbbbbbbbb@bbb.com',
            'password_digest' => 'abcdefge',
            'memo' => 'aaaaaaaa',
            'value_diff' => 3,
            'created_at' => time(),
            'updated_at' => time(),
        );
        $test->update($where, $data);
    }

    public function save()
    {
        $test = \Simplight\Accessor\UserAccount::create();
        $args = array(
            'user_id' => 204,
            'email' => 'aaabaaaa@bbb.com',
            'password_digest' => 'abcd',
            'memo' => 'a',
            'value_diff' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        );
        $test->save($args);
    }
    
    public function insertMulti()
    {
        $test = \Simplight\Accessor\UserAccount::create();
        $args = array(
            'user_id' => 300,
        );
        $data_list = array(
            array('user_id' => 300, 'email' => 'a@b.com', 'password_digest' => 'a', 'memo' => '', 'value' => 0, 'created_at' => time(), 'updated_at' => time()),
            array('user_id' => 301, 'email' => 'b@b.com', 'password_digest' => 'a', 'memo' => '', 'value' => 0, 'created_at' => time(), 'updated_at' => time()),
            array('user_id' => 302, 'email' => 'c@b.com', 'password_digest' => 'a', 'memo' => '', 'value' => 0, 'created_at' => time(), 'updated_at' => time()),
            array('user_id' => 303, 'email' => 'd@b.com', 'password_digest' => 'a', 'memo' => '', 'value' => 0, 'created_at' => time(), 'updated_at' => time()),
            array('user_id' => 304, 'email' => 'e@b.com', 'password_digest' => 'a', 'memo' => '', 'value' => 0, 'created_at' => time(), 'updated_at' => time()),
        );
        $test->insertMulti($args, $data_list);
    }
}



