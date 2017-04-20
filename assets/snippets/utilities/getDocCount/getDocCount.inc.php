<?php

$params = isset($params)?$params:['parents'=>$modx->documentIdentifier];
$params['api']=1;
//var_dump($params);

$resp = $modx->runSnippet('DocLister',$params);
$resp = json_decode($resp,true);
$count = count($resp);
if(isset($round)){
    $round = intval($round);
        $count  = ceil($count/pow(10,$round)) * pow(10,$round);;
}

echo $count;
