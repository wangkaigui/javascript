<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 数据读取，主要用于前台数据显示
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------
class content_output {

    //信息ID
    public $id = 0;
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
     * 数据处理
     * @param type $data
     * @return type
     */
    public function get($data) {
        $this->data = $data;
        $this->catid = $data['catid'];
        $this->id = $data['id'];
        $info = array();
        foreach ($this->fields as $fieldInfo) {
            $field = $fieldInfo['field'];
            if (!isset($this->data[$field])) {
                continue;
            }
            //字段类型
            $func = $fieldInfo['formtype'];
            //字段内容
            $value = $this->data[$field];
            $result = method_exists($this, $func) ? $this->$func($field, $value) : $value;
            if ($result !== false) {
                $info[$field] = $result;
            }
        }
        return array_merge($this->data, $info);
    }

    

/**
 * 选项字段类型内容获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return string
 */
function box($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    if ($setting['outputtype']) {
        return $value;
    } else {
        $options = explode("\n", $setting['options']);
        foreach ($options as $_k) {
            $v = explode("|", $_k);
            $k = trim($v[1]);
            $option[$k] = $v[0];
        }
        $string = '';
        switch ($setting['boxtype']) {
            case 'radio':
                $string = $option[$value];
                break;
            case 'checkbox':
                $value_arr = explode(',', $value);
                foreach ($value_arr as $_v) {
                    if ($_v)
                        $string .= $option[$_v] . ' 、';
                }
                break;
            case 'select':
                $string = $option[$value];
                break;
            case 'multiple':
                $value_arr = explode(',', $value);
                foreach ($value_arr as $_v) {
                    if ($_v)
                        $string .= $option[$_v] . ' 、';
                }
                break;
        }
        return $string;
    }
}

/**
 * 获取字段内容处理
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function images($field, $value) {
    return unserialize($value);
}

/**
 * 获取 日期时间字段类型 内容
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function datetime($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    if ($setting['fieldtype'] == 'date' || $setting['fieldtype'] == 'datetime') {
        return $value;
    } else {
        $format_txt = $setting['format'];
    }
    if (strlen($format_txt) < 6) {
        $isdatetime = 0;
    } else {
        $isdatetime = 1;
    }
    if (empty($value)) {
        $value = time();
    }
    $value = date($format_txt, $value);
    return $value;
}

/**
 * 关键字获取时处理
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return array 返回数组
 */
function keyword($field, $value) {
    if ($value == '') {
        return '';
    }
    //对关键字进行处理，返回数组
    if (strpos($value, ',') === false) {
        $value = explode(' ', $value);
    } else {
        $value = explode(',', $value);
    }
    return $value;
}


/**
 * 输出tags内容
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function tags($field, $value) {
    if (empty($value)) {
        return array();
    }
    //把Tags进行分割成数组
    $tags = strpos($value, ',') !== false ? explode(',', $value) : explode(' ', $value);
    $return = array();
    foreach ($tags as $k => $v) {
        $url = ShuipFCMS()->Url->tags($v);
        $return[$k] = array(
            'url' => $url['url'],
            'tag' => $v,
        );
    }
    return $return;
}


/**
 * 输出来源字段
 * @staticvar array $copyfrom_array
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return array
 */
function copyfrom($field, $value) {
    static $copyfrom_array;
    $copyfrom_array = array();
    if ($value && strpos($value, '|') !== false) {
        $arr = explode('|', $value);
        $value = $arr[0];
        $value_data = $arr[1];
    }
    if ($value_data) {
        $copyfrom_link = $copyfrom_array[$value_data];
        if (!empty($copyfrom_array)) {
            $imgstr = '';
            if ($value == '')
                $value = $copyfrom_link['siteurl'];
            if ($copyfrom_link['thumb'])
                $imgstr = "<a href='{$copyfrom_link['siteurl']}' target='_blank'><img src='{$copyfrom_link['thumb']}' height='15'></a> ";
            return $imgstr . "<a href='$value' target='_blank' style='color:#AAA'>{$copyfrom_link['sitename']}</a>";
        }
    } else {
        return $value;
    }
}

/**
 * 获取单文件上传字段内容
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function downfile($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    if ($setting['downloadlink']) {
        return U('Content/Download/index', array('catid' => $this->catid, 'id' => $this->id, 'f' => $field));
    } else {
        return $value;
    }
}

/**
 * 获取多文件上传内容
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function downfiles($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    $list_str = array();
    $file_list = unserialize($value);
    if (is_array($file_list)) {
        foreach ($file_list as $_k => $_v) {
            if ($_v['fileurl']) {
                if ($setting['downloadlink']) {
                    //链接到跳转页面
                    $fileurl = U('Content/Download/index', array('catid' => $this->catid, 'id' => $this->id, 'f' => $field, 'k' => $_k));
                } else {
                    $fileurl = $_v['fileurl'];
                }
                $filename = $_v['filename'] ? $_v['filename'] : "点击下载";
                $groupid = $_v['groupid'] ? $_v['groupid'] : 0;
                $point = $_v['point'] ? $_v['point'] : 0;
                $list_str[$_k]['fileurl'] = $fileurl;
                $list_str[$_k]['filename'] = $filename;
                $list_str[$_k]['groupid'] = $groupid;
                $list_str[$_k]['point'] = $point;
            }
        }
    }
    return $list_str;
}

/**
 * 万能字段字段类型内容获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return string
 */
function omnipotent($field, $value) {
    if (empty($value)) {
        return $value;
    }
    //字段配置
    $setting = unserialize($this->fields[$field]['setting']);
    if (in_array($setting['fieldtype'], array('text', 'mediumtext', 'longtext'))) {
        $_value = unserialize($value);
        if ($value && $_value) {
            $value = $_value;
        }
    }
    return $value;
}

}
