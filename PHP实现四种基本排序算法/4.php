<?php
//��������
function quickSort($arr) {
    //���ж��Ƿ���Ҫ��������
    $length = count($arr);
    if($length <= 1) {
        return $arr;
    }
    //ѡ���һ��Ԫ����Ϊ��׼
    $base_num = $arr[0];
    //�������˱���������Ԫ�أ����մ�С��ϵ��������������
    //��ʼ����������
    $left_array = array();  //С�ڻ�׼��
    $right_array = array();  //���ڻ�׼��
    for($i=1; $i<$length; $i++) {
        if($base_num > $arr[$i]) {
            //�����������
            $left_array[] = $arr[$i];
        } else {
            //�����ұ�
            $right_array[] = $arr[$i];
        }
    }
    //�ٷֱ����ߺ��ұߵ����������ͬ��������ʽ�ݹ�����������
    $left_array = quick_sort($left_array);
    $right_array = quick_sort($right_array);
    //�ϲ�
    return array_merge($left_array, array($base_num), $right_array);
}
quickSort($arr=array(1,43,54,62,21,66,32,78,36,76,39))

?>