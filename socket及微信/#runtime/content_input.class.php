<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 处理数据，为入库前做数据处理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------
class content_input {

    //栏目ID
    public $catid = 0;
    //模型ID
    public $modelid = 0;
    //字段信息
    public $fields = array();
    //模型缓存
    public $model = array();
    //数据
    protected $data = array();
    //处理后的数据
    protected $infoData = array();
    //内容模型对象
    protected $ContentModel = NULL;
    //最近错误信息
    protected $error = '';
    // 数据表名（不包含表前缀）
    protected $tablename = '';

    /**
     * 构造函数
     * @param type $modelid 模型ID
     * @param type $Action 传入this
     */
    public function __construct($modelid) {
        $this->model = cache("Model");
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
     * 数据入库前处理
     * @param type $data
     * @param type $type 状态1插入数据，2更新数据，3包含以上两种
     * @return boolean|string 
     */
    public function get($data, $type = 3) {
        //数据
        $this->data = $data;
        //栏目id
        $this->catid = (int) $data['catid'];
        //获取内容模型对象
        $this->ContentModel = \Content\Model\ContentModel::getInstance($this->modelid);
        foreach ($this->fields as $fieldInfo) {
            $field = $fieldInfo['field'];
            //如果是更新状态下，没有数据的，跳过
            if ($type == 2) {
                if (!isset($this->data[$field])) {
                    continue;
                }
            }
            //字段内容
            $value = $this->data[$field];
            //字段别名
            $name = $fieldInfo['name'];
            //最小值
            $minlength = (int) $fieldInfo['minlength'];
            //最大值
            $maxlength = (int) $fieldInfo['maxlength'];
            //数据校验正则
            $pattern = $fieldInfo['pattern'];
            //数据校验未通过的提示信息
            $errortips = empty($fieldInfo['errortips']) ? $name . ' 不符合要求！' : $fieldInfo['errortips'];
            //配置
            $setting = unserialize($fieldInfo['setting']);
            //是否主表
            $issystem = $fieldInfo['issystem'] ? true : false;

            //验证条件
            if (in_array($type, array(1, 3))) {
                //新增时，必须验证
                $condition = 1;
            } else {
                //当存在值时验证
                $condition = 2;
            }
            //进行长度验证 
            if ($minlength) {
                $this->ContentModel->addValidate(array($field, 'require', $name . ' 不能为空！', $condition, 'regex', 3), $issystem);
                $this->ContentModel->addValidate(array($field, 'isMin', $name . ' 不得小于 ' . $minlength . "个字符！", $condition, 'function', 3, array($minlength)), $issystem);
            }
            if ($maxlength) {
                $this->ContentModel->addValidate(array($field, 'isMax', $name . ' 不得多于 ' . $maxlength . "个字符！", $condition, 'function', 3, array($maxlength)), $issystem);
            }
            //数据校验正则
            if ($pattern) {
                $this->ContentModel->addValidate(array($field, $pattern, $errortips, 2, 'regex', 3), $issystem);
            }
            //值唯一
            if ($fieldInfo['isunique']) {
                $this->ContentModel->addValidate(array($field, '', $name . " 该值必须不重复！", 2, 'unique', 3), $issystem);
            }

            //字段类型
            $func = $fieldInfo['formtype'];
            //检测对应字段方法是否存在，存在则执行此方法，并传入字段名和字段值
            if (method_exists($this, $func)) {
                $value = $this->$func($field, $value);
            }

            //字段扩展，可以对字段内容进行再次处理，类似ECMS字段处理函数
            if ($setting['backstagefun'] || $setting['frontfun']) {
                load("@.treatfun");
                $backstagefun = explode("###", $setting['backstagefun']);
                $usfun = $backstagefun[0];
                $usparam = $backstagefun[1];
                //前后台
                if (defined("IN_ADMIN") && IN_ADMIN) {
                    //检查方法是否存在
                    if (function_exists($usfun)) {
                        //判断是入库执行类型
                        if ((int) $setting['backstagefun_type'] == 1 || (int) $setting['backstagefun_type'] == 3) {
                            //调用自定义函数，参数传入：模型id，栏目ID，信息ID，字段内容，字段名，操作类型，附加参数
                            try {
                                $value = call_user_func($usfun, $this->modelid, $this->catid, 0, $value, $field, ACTION_NAME, $usparam);
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
                            if ((int) $setting['backstagefun_type'] == 1 || (int) $setting['backstagefun_type'] == 3) {
                                //调用自定义函数，参数传入：模型id，栏目ID，信息ID，字段内容，字段名，操作类型，附加参数
                                try {
                                    $value = call_user_func($usfun, $this->modelid, $this->catid, 0, $value, $field, ACTION_NAME, $usparam);
                                } catch (Exception $exc) {
                                    //记录日志
                                    \Think\Log::record("模型id:" . $this->modelid . ",错误信息：调用自定义函数" . $usfun . "出现错误！");
                                }
                            }
                        }
                    }
                }
            }

            //除去已经处理过的字段
            unset($data[$field]);
            //当没有返回时，或者为 null 时，等于空字符串，null有时会出现mysql 语法错误。
            if (is_null($value)) {
                continue;
            }
            //把系统字段和模型字段分开
            if ($issystem) {
                $this->infoData[$field] = $value;
            } else {
                $this->infoData[$this->ContentModel->getRelationName()][$field] = $value;
            }
        }
        //取得标题颜色
        if (isset($_POST['style_color'])) {
            //颜色选择为隐藏域 在这里进行取值
            $this->infoData['style'] = $_POST['style_color'] ? strip_tags($_POST['style_color']) : '';
            //标题加粗等样式
            if (isset($_POST['style_font_weight'])) {
                $this->infoData['style'] = $this->infoData['style'] . ($_POST['style_font_weight'] ? ';' : '') . strip_tags($_POST['style_font_weight']);
            }
        }
        //如果$data还有存在模型字段以外的值，进行合并
        if (!empty($data)) {
            $this->infoData = array_merge($data, $this->infoData);
        }
        //如果副表没有字段，加个关联ID字段。不然不会在副表插入一条记录
        if (!isset($this->infoData[$this->ContentModel->getRelationName()]) && $this->model[$this->modelid]['type'] == 0) {
            $this->infoData[$this->ContentModel->getRelationName()] = array('id' => 0);
        }
        return $this->infoData;
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
 * 多行文本框
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function textarea($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    if (!$setting['enablehtml']) {
        $value = strip_tags($value);
    }
    return $value;
}

/**
 * 编辑器获取内容
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function editor($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    $isadmin = 0;
    //是否保存远程图片
    $enablesaveimage = (int) $setting['enablesaveimage'];
    if (defined("IN_ADMIN") && IN_ADMIN) {
        $isadmin = 1;
    }
    if ($enablesaveimage) {
        $Attachment = service('Attachment', array(
            "module" => $this->catid ? 'Content' : MODULE_NAME,
            "catid" => $this->catid? : 0,
            "isadmin" => $isadmin,
        ));
        //下载远程图片
        $value = $Attachment->download($value);
    }
    return $value;
}


/**
 * 标题字段类型数据获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return int
 */
function title($field, $value) {
    return \Input::forTag($value);
}


/**
 * 选项字段类型获取数据
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return boolean|string 字段配置
 */
function box($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    if ($setting['boxtype'] == 'checkbox') {
        if (!is_array($value) || empty($value))
            return false;
        //删除添加的默认值
        array_shift($value);
        $value = implode(',', $value);
        return $value;
    } elseif ($setting['boxtype'] == 'multiple') {
        if (is_array($value) && count($value) > 0) {
            $value = implode(',', $value);
            return $value;
        }
    } else {
        return $value;
    }
}


/**
 * 获取图片内容处理
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function image($field, $value) {
    return trim($value);
}

/**
 * 多图片上传获取内容
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function images($field, $value) {
    //取得图片列表
    $pictures = $_POST[$field . '_url'];
    //取得图片说明
    $pictures_alt = isset($_POST[$field . '_alt']) ? $_POST[$field . '_alt'] : array();
    $array = $temp = array();
    if (!empty($pictures)) {
        foreach ($pictures as $key => $pic) {
            $temp['url'] = $pic;
            $temp['alt'] = $pictures_alt[$key];
            $array[$key] = $temp;
        }
    }
    $array = serialize($array);
    return $array;
}

/**
 * 数字字段类型数据获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return int
 */
function number($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    //小数位
    $decimaldigits = $setting['decimaldigits'];
    //取值范围
    $minnumber = $setting['minnumber'];
    if ($minnumber != '') {
        if ($value < $minnumber) {
            $value = $minnumber;
        }
    }
    $maxnumber = $setting['maxnumber'];
    if ($maxnumber != '') {
        if ($value > $maxnumber) {
            $value = $maxnumber;
        }
    }
    return $value;
}


/**
 * 日期时间字段类型 数据获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function datetime($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    if ($setting['fieldtype'] == 'int') {
        if (!is_numeric($value)) {
            $value = strtotime($value);
        }
    }
    return $value;
}

/**
 * 关键字字段类型数据获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return int
 */
function keyword($field, $value) {
    if ($value == '') {
        return $value;
    }
    return \Input::forTag($value);
}

/**
 * 获取Tags内容
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function tags($field, $value) {
    return trim($value);
}


/**
 * 作者字段类型表单获取数据处理
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return string 字段内容
 */
function author($field, $value) {
    return \Input::forTag($value);
}


/**
 * 获取字段来源处理
 * @param type $field
 * @param string $value
 * @return string
 */
function copyfrom($field, $value) {
    return \Input::forTag($value);
}


/**
 * 分页选择方式字段处理
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return int
 */
function pages($field, $value) {
    $this->infoData[$this->ContentModel->getRelationName()]['paginationtype'] = !isset($value['paginationtype']) ? 2 : $value['paginationtype'];
    $this->infoData[$this->ContentModel->getRelationName()]['maxcharperpage'] = empty($value['maxcharperpage']) ? 10000 : $value['maxcharperpage'];
    return $value;
}

/**
 * 推荐位字段类型数据获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return int
 */
function posid($field, $value) {
    if (empty($value) || !is_array($value)) {
        return 0;
    }
    $number = count($value);
    $value = $number == 1 ? 0 : 1;
    return $value;
}

/**
 * 获取单文件上传内容处理
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function downfile($field, $value) {
    return trim($value);
}

/**
 * 多文件上传获取数据处理
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function downfiles($field, $value) {
    $files = $_POST[$field . '_fileurl'];
    $files_alt = $_POST[$field . '_filename'];
    if (defined("IN_ADMIN") && IN_ADMIN && isModuleInstall('Member')) {
        $groupid = $_POST[$field . '_groupid'];
        $point = $_POST[$field . '_point'];
    } else {
        $groupid = array();
        $point = array();
    }
    $array = $temp = array();
    if (!empty($files)) {
        foreach ($files as $key => $file) {
            $temp['fileurl'] = $file;
            $temp['filename'] = $files_alt[$key];
            $temp['groupid'] = $groupid[$key] ? $groupid[$key] : 0;
            $temp['point'] = $point[$key] ? $point[$key] : 0;
            $array[$key] = $temp;
        }
    }
    $array = serialize($array);
    return $array;
}

/**
 * 万能字段字段类型数据获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return int
 */
function omnipotent($field, $value) {
    if (empty($value)) {
        return $value;
    }
    //字段配置
    $setting = unserialize($this->fields[$field]['setting']);
    if (in_array($setting['fieldtype'], array('text', 'mediumtext', 'longtext'))) {
        //如果值提交的是数组，进行序列化
        if ($value && is_array($value)) {
            $value = serialize($value);
        }
    }
    return $value;
}

}
