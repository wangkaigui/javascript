<?php
//��������
function insertSort($arr) {
    $len=count($arr); 
    for($i=1, $i<$len; $i++) {
        $tmp = $arr[$i];
        //�ڲ�ѭ�����ƣ��Ƚϲ�����
        for($j=$i-1;$j>=0;$j--) {
            if($tmp < $arr[$j]) {
                //���ֲ����Ԫ��ҪС������λ�ã�����ߵ�Ԫ����ǰ���Ԫ�ػ���
                $arr[$j+1] = $arr[$j];
                $arr[$j] = $tmp;
            } else {
                //�����������Ҫ�ƶ���Ԫ�أ��������Ѿ�����������飬��ǰ��ľͲ���Ҫ�ٴαȽ��ˡ�
                break;
            }
        }
    }
    print_r($arr);
}
insertSort($arr=array(1,43,54,62,21,66,32,78,36,76,39));
?>