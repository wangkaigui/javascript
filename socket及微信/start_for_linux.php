<?php
/**
 * run with command 
 * php start.php start
 */

use Workerman\Worker;
// composer 的 autoload 文件
include __DIR__ . '/shuipf/Core/Library/Vendor/onlinechat_for_linux/vendor/autoload.php';

if(strpos(strtolower(PHP_OS), 'win') === 0)
{
    exit("start.php not support windows, please use start_for_win.bat\n");
}

// 标记是全局启动
define('GLOBAL_START', 1);

// 加载IO 和 Web
require_once __DIR__ . '/shuipf/Core/Library/Vendor/onlinechat/start_io.php';
require_once __DIR__ . '/shuipf/Core/Library/Vendor/onlinechat/start_web.php';

// 运行所有服务
Worker::runAll();