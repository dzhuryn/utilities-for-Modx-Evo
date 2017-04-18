<?php

$n = isset($n)?$n:0;
$lang = isset($lang) ? $lang : 'ru';
$text1 = isset($t1) ? $t1 : ' ';
$text2 = isset($t2) ? $t2 : ' ';
$text3 = isset($t3) ? $t3 : ' ';


if (in_array($lang,['ru','ua'])) {
    $plural = $n % 10 == 1 && $n % 100 != 11 ? $text1 : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $text2 : $text3);
} else {
    $plural = $n != 1 ? $text1 : $text2;
}
echo $plural;
