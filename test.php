<?php
// function &test(){
// static $b;
// return $b;
// }


// $a = & test();
// $a = 6;
// $a = 3;
// echo test();  

// function a()
// {
// 	echo 123;
// }

// class test {
// 	function __construct()
// 	{
// 		echo a();
// 	}

// 	function a()
// 	{
// 		echo 456;
// 	}
// }

// new test();

ob_start();
echo 'hello';//此处并不会在页面中输出
$a = ob_get_level();
$b = ob_get_contents();//获得缓存结果,赋予变量
ob_clean();
echo $a;