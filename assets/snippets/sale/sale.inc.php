<?php
$afterPoint = isset($afterPoint)?$afterPoint:1;
$price = isset($price)?$price:0;
$oldPrice = isset($oldPrice)?$oldPrice:0;
$percent = isset($percent)?$percent:0;

if(!empty($price) && !empty($oldPrice)){
    $sale  = 100 - ($price*100/$oldPrice);
    echo round($sale,0);
}
if(!empty($price) && !empty($percent)){

    $new =  $price - $price*($percent/100);
    echo round($new,$afterPoint);
}

