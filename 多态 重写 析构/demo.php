<?php
/**
多态是指在面向对象中能够根据使用类的上下文来重新定义或改变类的性质和行为。
教师类有一个drawPolygon()方法需要一个Polygon类，用来画多边形，此方法内部调用多边形的draw()方法，但由于弱类型，我们可以传入Circle类，就会调用Circle类的draw方法，这就事与愿违了。甚至可以传入阿猫、阿狗类，如果这些类没有draw()方法还会报错。
*/
class Teacher{
    //这样就限制了只能传入Polygon及其子类。
    function drawPolygon(Polygon,$polygon){ 
        $polygon->draw(); 
    }    
}

class Polygon{
    function draw(){
        echo "draw a polygon";
    }
}

class Circle{
    function draw(){
        echo "draw a circle";
    }
}



/**
构造函数在某一个类中，当这个类被实例化的时候就会自动调用，
而析构函数是在这个类的对象被销毁的时候自动调用，即是在程序执行结束时自动调用。
**/

class MyDestructableClass {
   function __construct() {
       print "In constructor\n";
       $this->name = "MyDestructableClass";
   }
    
   function test1(){
       echo '1111';
   }
    
   function __destruct() {
       print "Destroying " . $this->name . "\n";
   }
}

$obj = new MyDestructableClass();
unset($obj);//对象被销毁执行析构函数，1111后执行

echo 1111;