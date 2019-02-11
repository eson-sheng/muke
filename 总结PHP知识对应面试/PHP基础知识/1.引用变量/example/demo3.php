<?php 
// zval变量容器
$a = range(0,3);
xdebug_debug_zval('a');

//定义变量b，将a变量的值赋值给b
$b = $a;
xdebug_debug_zval('a');

//对a变量进行修改
$a = range(0,3);
xdebug_debug_zval('a');

