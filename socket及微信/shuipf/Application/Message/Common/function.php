<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 微信自定义函数
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

function getUid($id){
	$user= D('user')->find($id);
	return $user['username'];
}

function getUserId($id){
	return '还没写代码';
	$user= D('user')->find($id);
	return $user['username'];
}