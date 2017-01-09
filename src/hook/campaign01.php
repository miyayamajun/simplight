<?php

namespace Simplight\Hook;

class Campaign01 extends \Simplight\HookBase
{   
    public static $target_action_list = array(
        'login_confirm',
    );
    public function execute()
    {
        if (!$this->_validate()) {
            return;
        }
        echo get_class($this);
    }
}
