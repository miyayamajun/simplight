<?php

/**
 * ディレクトリ
 */
define('ROOT_DIR',       preg_replace('/\/app$/', '', APP_DIR));
define('CORE_DIR',       APP_DIR .  '/core');
define('CONTROLLER_DIR', APP_DIR .  '/controller');
define('MODEL_DIR',      APP_DIR .  '/model');
define('ACCESSOR_DIR',   APP_DIR .  '/accessor');
define('JSON_DIR',       APP_DIR .  '/json');
define('TABLE_JSON_DIR', JSON_DIR . '/table');
define('HOOK_DIR',       APP_DIR .  '/hook');
define('LIB_DIR',        APP_DIR .  '/lib');
define('CACHE_DIR',      APP_DIR .  '/cache');
define('TEMPLATE_DIR',   APP_DIR .  '/view');

/**
 * ステータスコード
 */
define('STATUS_CODE_OK',        200);
define('STATUS_CODE_NOT_FOUND', 404);
define('STATUS_CODE_ERROR',     500);

define('DEV', 1);
// define('STG', 1);
// define('PROD', 1);

/**
 * memcached
 */
if (class_exists('Memcached')) {
    define('MEMCACHED_ENABLE', 1);
}

/**
 * URL
 */
if (isset($_SERVER['HTTP_HOST'])) {
    define('HTTP_ROOT_URL', "http://{$_SERVER['HTTP_HOST']}");
    define('HTTPS_ROOT_URL', "https://{$_SERVER['HTTP_HOST']}");
}

/**
 * その他
 */
define('DB_SAVE_RETRY_COUNT', 10); // DB保存のリトライ回数

