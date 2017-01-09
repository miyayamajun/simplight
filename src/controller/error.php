<?php

namespace Simplight\Controller;

/**
 * \Simplight\Controller\Error
 * @description /error アクセス時に処理されるコントローラ
 *
 * @author https://github.com/miyayamajun
 */
class Error extends \Simplight\Controller
{
    public function error($exception)
    {
        var_dump($exception);
    }
}
