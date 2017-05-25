<?php
$type = isset($types)?$types:'doc';
$parent = isset($parent)?$parent:0;
$key = isset($key)?$key:'id';

$showParent = isset($showParent)?$showParent:0;
$template =  isset($template)?$template:0;
$showNoPublish = isset($showNoPublish)?$showNoPublish:1;

if($type=='doc'){
    $params = [
        'parents'=>$parent,
        'api'=>1,
        'depth'=>2,
        'showParent'=>1,
        'showNoPublish'=>1,
        'addWhereList'=>'deleted = 0',
        'tvList'=>'pagetitle_ru,pagetitle_en,pagetitle_ua',
        'tvPrefix'=>'',
        'orderBy'=>'parent asc,pagetitle asc'
    ];
    if(!empty($template)){
        $params['addWhereList'] = 'deleted = 0 and template = '.$template;
    }


    $resp = $modx->runSnippet('DocLister',$params);
    $resp = json_decode($resp,true);
    $output[] = '==';
    if(is_array($resp)){
        foreach ($resp as $doc) {
            $title = $doc['pagetitle'];
            if($showParent == 1 && $doc['parent'] != 0){
                $title = $modx->runSnippet('DocInfo',['docid'=>$doc['parent']]).' - '. $doc['pagetitle'];
            }
            if(!empty($modx->config['_lang']) && !empty($doc['pagetitle_'.$modx->config['_lang']])){
                $title = $doc['pagetitle_'.$modx->config['_lang']];
            }
            $output[] = $title. '==' . $doc[$key];
        }
    }
    echo implode('||',$output);
}
