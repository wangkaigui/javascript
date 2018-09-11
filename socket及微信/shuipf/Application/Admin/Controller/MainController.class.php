<?php

// +-------------------------------------------
// | 后台框架首页
// +-------------------------------------------
// | Copyright (c) 2012-2014 
// +-------------------------------------------
// | Author:  jie
// +-------------------------------------------

namespace Admin\Controller;

use Common\Controller\AdminBase;

class MainController extends AdminBase {

    public function index() {
        //服务器信息
        $info = array(
            '操作系统' => PHP_OS,
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            'MYSQL版本' => mysql_get_server_info(),
            '产品名称' => '<font color="#FF0000">JBRCMS后台管理系统</font>' . "&nbsp;&nbsp;&nbsp; [<a href='http://www.jbr.net.cn/' target='_blank'>访问官网</a>]",
            //'用户类型' => '<font color="#FF0000" id="server_license">获取中...</font>',
            //'产品版本' => '<font color="#FF0000">' . SHUIPF_VERSION . '</font>，最新版本：<font id="server_version">获取中...</font>',
            //'产品流水号' => '<font color="#FF0000">' . SHUIPF_BUILD . '</font>，最新流水号：<font id="server_build">获取中...</font>',
            '上传附件限制' => ini_get('upload_max_filesize'),
            //'执行时间限制' => ini_get('max_execution_time') . "秒",
            //'剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        );
        //内容统计
        $con = M('article');
        $category = M(category);
        $category_num = $category->count();
        $content_num = $con->count();
        $statistics = array(
        		'文章统计' => $content_num,
        		'留言统计' => '',
        		'栏目分类' => $category_num,
        );
        //金百瑞公告
        
        $this->weather();
        $this->assign('statistics',$statistics);
        $this->assign('server_info', $info);
        $this->display();
    }

    public function public_license() {
        $license = S('server_license');
        if (empty($license)) {
            $license = $this->Cloud->data(array('domain' => $_SERVER['SERVER_NAME']))->act('get.license');
            if (empty($license)) {
                $license = array('name' => '非授权用户',);
            } else {
                S('server_license', $license, 3600);
            }
        }
        $this->ajaxReturn($license);
    }

    public function public_latestversion() {
        $latestversion = S('server_latestversion');
        if (empty($latestversion)) {
            $latestversion = $this->Cloud->act('get.latestversion');
            S('server_latestversion', $latestversion, 3600);
        }
        $this->ajaxReturn($latestversion);
    }
	
    public function public_notice() {
        $notice = S('server_notice');
        if (empty($notice)) {
            $notice = $this->Cloud->act('get.notice');
            S('server_notice', $notice, 3600);
        }
        if (empty($_COOKIE['notice_' . $notice['id']])) {
            $this->ajaxReturn($notice);
        }
    }
    
    //获取当前天气情况
    public function weather(){
    	$url = "http://www.baidu.com/s?wd=武汉天气"; //此为在百度里搜 北京天气 的返回地址
    	$content = file_get_contents($url);
    	preg_match_all('/<div id="weat">(.+?)<\/table>/si',$content,$temp);
    	preg_match_all('/<td>(.+?)<\/td>/si',$temp[1][0],$temp1);
    	return $temp1[1][0];
    }
}
