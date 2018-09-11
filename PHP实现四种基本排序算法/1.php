<?php
//冒泡排序
function numsort($arr)
{  
  $len=count($arr);
  //该层循环控制 需要冒泡的轮数
  for($i=1;$i<$len;$i++)
  { //该层循环用来控制每轮 冒出一个数 需要比较的次数
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