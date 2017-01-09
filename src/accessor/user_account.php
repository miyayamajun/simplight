<?php

namespace Simplight\Accessor;

class UserAccount extends \Simplight\Accessor
{
    const CONFIG_JSON_PATH  = 'user_account.json';
    const DIVISION_KEY_NAME = 'user_id';
    
    protected static $_primary_key_list = array(
        'user_id',
    );

    protected static $_timestamp_field_list = array(
        'created_at',
        'updated_at',
    );

    protected static $_field_list = array(
        'user_id',        
        'email',          
        'password_digest',
        'memo',           
        'value',          
        'created_at',     
        'updated_at',     
    );
}

