<?php
//ð������
function numsort($arr)
{  
  $len=count($arr);
  //�ò�ѭ������ ��Ҫð�ݵ�����
  for($i=1;$i<$len;$i++)
  { //�ò�ѭ����������ÿ�� ð��һ���� ��Ҫ�ȽϵĴ���
    for($k=0;$k<$len-$i;$k++)
    {
       if($arr[$k]>$arr[$k+1])
        {
            $tmp=$arr[$k+1];
            $arr[$k+1]=$arr[$k];
            $arr[$k]=$tmp;
        }
    }
  }
   print_r($arr);
}
numsort($arr=array(1,43,54,62,21,66,32,78,36,76,39)); 
?>