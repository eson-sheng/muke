<?php
/**
 * 下列程序中请写出打印输出结果
 * <?php
 *
 * $a = 0;
 * $b = 0;
 *
 * if ( $a = 3 > 0 || $b = 3 > 0 ) {
 *      $a++;
 *      $b++;
 *      echo $a."\n";
 *      echo $b."\n";
 * }
 */
$a = 0;
$b = 0;
if ( $a = 3 > 0 || $b = 3 < 0 ) {
    $a++;
    $b++;
    echo $a."\n";
    echo $b."\n";
}