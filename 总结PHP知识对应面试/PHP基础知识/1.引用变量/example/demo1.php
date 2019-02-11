<?php 
//定义一个变量a
$a = range(0,1000);
var_dump(memory_get_usage());//内存使用情况

//定义变量b，将a变量的值赋值给b
//COW Copy On Write 有修改才会复制写入
$b = $a;
var_dump(memory_get_usage());//内存使用情况

//对a变量进行修改
$a = range(0,1000);
var_dump(memory_get_usage());//内存使用情况

