<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 数据更新，也就是类似回调吧！
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------
class content_update {

    //信息ID
    public $id = 0;
    //栏目ID
    public $catid = 0;
    //模型ID
    public $modelid = 0;
    //字段信息
    public $fields = array();
    //模型缓存
    protected $model = array();
    //数据
    protected $data = array();
    //最近错误信息
    protected $error = '';
    // 数据表名（不包含表前缀）
    protected $tablename = '';

    public function __construct($modelid) {
        $this->model = cache('Model');
        if ($modelid) {
            $this->setModelid($modelid);
        }
    }

    /**
     * 初始化
     * @param type $modelid
     * @return boolean
     */
    public function setModelid($modelid) {
        if (empty($modelid)) {
            return false;
        }
        $this->modelid = $modelid;
        if (empty($this->model[$this->modelid])) {
            return false;
        }
        $modelField = cache('ModelField');
        $this->fields = $modelField[$this->modelid];
        $this->tablename = trim($this->model[$this->modelid]['tablename']);
    }

    /**
     * 魔术方法，获取配置
     * @param type $name
     * @return type
     */
    public function __get($name) {
        return isset($this->data[$name]) ? $this->data[$name] : (isset($this->$name) ? $this->$name : NULL);
    }

    /**
     *  魔术方法，设置options参数
     * @param type $name
     * @param type $value
     */
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * 执行更新操作
     * @param type $data
     */
    public function update($data) {
        $info = array();
        $this->data = $data;
        $this->id = (int) $data['id'];
        $this->catid = (int) $data['catid'];
        foreach ($this->fields as $fieldInfo) {
            $field = $fieldInfo['field'];
            if (empty($fieldInfo)) {
                continue;
            }
            if (!isset($this->data[$field])) {
                continue;
            }
            //字段类型
            $func = $fieldInfo['formtype'];
            //配置
            $setting = unserialize($fieldInfo['setting']);
            //字段值
            $value = method_exists($this, $func) ? $this->$func($field, $this->data[$field]) : $this->data[$field];
            //字段扩展，可以对字段内容进行再次处理，类似ECMS字段处理函数
            if ($setting['backstagefun'] || $setting['frontfun']) {
                load("@.treatfun");
                $backstagefun = explode("###", $setting['backstagefun']);
                $usfun = $backstagefun[0];
                $usparam = $backstagefun[1];
                //前后台
                if (defined('IN_ADMIN') && IN_ADMIN) {
                    //检查方法是否存在
                    if (function_exists($usfun)) {
                        //判断是入库执行类型
                        if ((int) $setting['backstagefun_type'] >= 2) {
                            //调用自定义函数，参数传入：模型id，栏目ID，信息ID，字段内容，字段名，操作类型，附加参数
                            try {
                                $value = call_user_func($usfun, $this->modelid, $this->catid, $this->id, $value, $field, ACTION_NAME, $usparam);
                            } catch (Exception $exc) {
                                //记录日志
                                \Think\Log::record("模型id:" . $this->modelid . ",错误信息：调用自定义函数" . $usfun . "出现错误！");
                            }
                        }
                    }
                } else {
                    //前台投稿处理自定义函数处理
                    //判断当前用户组是否拥有使用字段处理函数的权限，该功能暂时木有，以后加上
                    if (true) {
                        $backstagefun = explode("###", $setting['frontfun']);
                        $usfun = $backstagefun[0];
                        $usparam = $backstagefun[1];
                        //检查方法是否存在
                        if (function_exists($usfun)) {
                            //判断是入库执行类型
                            if ((int) $setting['backstagefun_type'] >= 2) {
                                //调用自定义函数，参数传入：模型id，栏目ID，信息ID，字段内容，字段名，操作类型，附加参数
                                try {
                                    $value = call_user_func($usfun, $this->modelid, $this->catid, $this->id, $value, $field, ACTION_NAME, $usparam);
                                } catch (Exception $exc) {
                                    //记录日志
                                    \Think\Log::record("模型id:" . $this->modelid . ",错误信息：调用自定义函数" . $usfun . "出现错误！");
                                }
                            }
                        }
                    }
                }
            }
            $info[$field] = $value;
        }
        return $info;
    }

    /**
     * 错误信息
     * @param type $message 错误信息
     * @param type $fields 字段
     */
    public function error($message, $fields = false) {
        $this->error = $message;
    }

    /**
     * 获取错误信息
     * @return type
     */
    public function getError() {
        return $this->error;
    }

    

/**
 * Tags处理回调
 * @param type $field 字段名
 * @param type $value 字段值
 */
function tags($field, $value) {
    if (!empty($value)) {
        //添加时如果是未审核，直接不处理
        if (ACTION_NAME == 'add' && $this->data['status'] != 99) {
            return false;
        } else if (ACTION_NAME == 'edit' && $this->data['status'] != 99) {
            //如果是编辑状态，且未审核，直接清除已有的tags
            D('Content/Tags')->deleteAll($this->data['id'], $this->data['catid'], $this->modelid);
            return false;
        }
        if (strpos($value, ',') === false) {
            $keyword = explode(' ', $value);
        } else {
            $keyword = explode(',', $value);
        }
        $keyword = array_unique($keyword);
        //新增
        if (ACTION_NAME == 'add') {
            D('Content/Tags')->addTag($keyword, $this->id, $this->catid, $this->modelid, array(
                'url' => $this->data['url'],
                'title' => $this->data['title'],
            ));
        } else {
            D('Content/Tags')->updata($keyword, $this->id, $this->catid, $this->modelid, array(
                'url' => $this->data['url'],
                'title' => $this->data['title'],
            ));
        }
    } else {
        //删除全部tags信息
        D('Content/Tags')->deleteAll($this->id, $this->catid, $this->modelid);
    }
}


/**
 * 推荐位字段类型更新回调
 * @param type $field 字段名
 * @param type $value 字段内容
 */
function posid($field, $value) {
    if (!empty($value) && is_array($value)) {
        //新增
        if (ACTION_NAME == 'add') {
            $position_data_db = D('Content/Position');
            $textcontent = array();
            foreach ($this->fields AS $_key => $_value) {
                //判断字段是否入库到推荐位字段
                if ($_value['isposition']) {
                    $textcontent[$_key] = $this->data[$_key];
                }
            }
            //颜色选择为隐藏域 在这里进行取值
            $textcontent['style'] = $_POST['style_color'] ? strip_tags($_POST['style_color']) : '';
            if ($_POST['style_font_weight']) {
                $textcontent['style'] = $textcontent['style'] . ';' . strip_tags($_POST['style_font_weight']);
            }
            $posid = array();
            $catid = $this->data['catid'];
            foreach ($value as $r) {
                if ($r != '-1') {
                    $posid[] = $r;
                }
            }
            $position_data_db->positionUpdate($this->id, $this->modelid, $catid, $posid, $textcontent, 0, 1);
        } else {
            $posids = array();
            $catid = $this->data['catid'];
            $position_data_db = D('Content/Position');
            foreach ($value as $r) {
                if ($r != '-1'){
                    $posids[] = $r;
                }
            }
            $textcontent = array();
            foreach ($this->fields AS  $_value) {
                $field = $_value['field'];
                if ($_value['isposition']) {
                    $textcontent[$field] = $this->data[$field];
                }
            }
            //颜色选择为隐藏域 在这里进行取值
            $textcontent['style'] = $_POST['style_color'] ? strip_tags($_POST['style_color']) : '';
            if ($_POST['style_font_weight']) {
                $textcontent['style'] = $textcontent['style'] . ';' . strip_tags($_POST['style_font_weight']);
            }
            //颜色选择为隐藏域 在这里进行取值
            $position_data_db->positionUpdate($this->id, $this->modelid, $catid, $posids, $textcontent);
        }
    }
}

}
