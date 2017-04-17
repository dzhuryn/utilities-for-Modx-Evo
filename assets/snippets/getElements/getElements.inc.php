<?php
$type = isset($types)?$types:'doc';
$parent = isset($parent)?$parent:0;
$key = isset($key)?$key:'id';
if($type=='doc'){
    $resp = $modx->runSnippet('DocLister',[
        'parents'=>$parent,
        'api'=>1,
        'showNoPublish'=>1,
        'addWhereList'=>'deleted = 0',
        'tvList'=>'pagetitle_ru,pagetitle_en,pagetitle_ua',
        'tvPrefix'=>''
    ]);
    $resp = json_decode($resp,true);
    $output[] = '==';
    if(is_array($resp)){
        foreach ($resp as $doc) {
            $title = $doc['pagetitle'];
            if(!empty($modx->config['_lang']) && !empty($doc['pagetitle_'.$modx->config['_lang']])){
                $title = $doc['pagetitle_'.$modx->config['_lang']];
            }
            $output[] = $title. '==' . $doc[$key];
        }
    }
    echo implode('||',$output);
}
