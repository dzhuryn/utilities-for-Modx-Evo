<?php

$modx->regClientScript('/assets/snippets/utilities/evoSortBlock/evoSortBlock.js');

$ajax = isset($ajax)?$ajax:1;

//дание из формы
if(!empty($_REQUEST['sortDisplay'])){
    $_SESSION['sortDisplay'] = $_REQUEST['sortDisplay'];
}
if(!empty($_REQUEST['sortBy']) && !empty($_SESSION['sortBy']) &&$_REQUEST['sortBy']==$_SESSION['sortBy']){
    //меняем направление
    $_SESSION['sortOrder'] = $_SESSION['sortOrder']=='desc'?'asc':'desc';
}
if(!empty($_REQUEST['sortBy'])){
    $resp  = explode(':',$_REQUEST['sortBy']);
    $sortBy = $resp[0];
    $sortOrder = $resp[1];


    $_SESSION['sortBy'] = $sortBy;
    if(!empty($sortOrder)){
        $_SESSION['sortOrder']  = $sortOrder;
    }


}


//default
$displayDefault = isset($displayDefault)?$displayDefault : '20';
$sortFieldDefault = isset($sortFieldDefault)?$sortFieldDefault : 'pagetitle';
$sortOrderDefault = isset($sortOrderDefault)?$sortOrderDefault : 'desc';

//устанавливаемм значений и  сесию
if(empty($_SESSION['sortDisplay'])) $_SESSION['sortDisplay'] = $displayDefault;
if(empty($_SESSION['sortBy'])) $_SESSION['sortBy'] = $sortFieldDefault;
if(empty($_SESSION['sortOrder'])) $_SESSION['sortOrder'] = $sortOrderDefault;


//поточние значения
$currentDisplay = $_SESSION['sortDisplay'];
$currentSortField = $_SESSION['sortBy'];
$currentSortOrder = $_SESSION['sortOrder'];

$modx->setPlaceholder('sortDisplay',$currentDisplay);
$modx->setPlaceholder('sortBy',$currentSortField);
$modx->setPlaceholder('sortOrder',$currentSortOrder);

//конфиг
$displayConfig = isset($displayConfig)?$displayConfig:'20||30||40||все==all';
$sortConfig = isset($sortConfig)?$sortConfig:'По название==pagetitle||По индексу==menuindex';

//tpl
$ownerTpl = isset($ownerTpl)?$ownerTpl:'<div class="[+class+]">[+display.block+][+sort.block+]</div>';

$displayOwnerTpl  = isset($displayOwnerTpl)?$displayOwnerTpl:'<select class="[+class+]">[+wrapper+]</select>';
$displayRowTpl = isset($displayRowTpl)?$displayRowTpl:'<option value="[+value+]" [+selected+] [+data+] class="[+class+]">[+caption+]</option>';

$sortOwnerTpl = isset($sortOwnerTpl)?$sortOwnerTpl:'<ul>[+wrapper+]</ul>';
$sortRowTpl = isset($sortRowTpl)?$sortRowTpl: '<a class="[+class+]" [+data+] [+selected+] >[+caption+]</a>';


//class
$sortActiveClass = isset($sortActiveClass)?$sortActiveClass:'active';
$sortUpClass = isset($sortUpClass)?$sortUpClass:'up';
$sortDownClass = isset($sortDownClass)?$sortDownClass:'down';
$displayActiveClass = isset($displayActiveClass)?$displayActiveClass:'active';

$displayRow = '';
$display = explode('||',$displayConfig);
if(is_array($display)){
    foreach ($display as $el) {
        $resp = explode('==',$el);
        $caption = $resp[0];
        $value =empty($resp[1])?$resp[0]:$resp[1] ;
        $dataAttr = 'data-value = "'.$value.'"';

        $selected = '';
        $class = ' set-display-field';

        if($value==$currentDisplay){
            $class.=' '.$displayActiveClass;
            $selected = ' selected';
        }

        $data = [
            'value'=>$value,
            'caption'=>$caption,
            'selected'=>$selected,
            'data'=>$dataAttr,
            'class'=>$class,
        ];
        $displayRow .= $modx->parseText($displayRowTpl,$data);
    }
}
$data = [
    'class'=>' set-display-field',
    'wrapper'=>$displayRow
];
$displayOuter = $modx->parseText($displayOwnerTpl,$data);


$sortRow = '';
$sortField = explode('||',$sortConfig);
if(is_array($sortField)){
    foreach ($sortField as $el) {
        $resp = explode('==',$el);
        $caption = $resp[0];
        $resp  = empty($resp[1])?$resp[0]:$resp[1] ;
        $resp = explode(':',$resp);
        $value = $resp[0];
        if(!empty($resp[1])){
            $valueOrder = $resp[1];
        }
        else{
            $valueOrder = '';
        }


        $dataAttr = 'data-value = "'.$value.'"';

        $selected = '';
        $class = ' set-sort-field';

        if($value==$currentSortField && empty($valueOrder)){
            $class.=' '.$sortActiveClass;
            $selected = ' selected';
        }
        if(!empty($valueOrder) && $valueOrder==$currentSortOrder && $value==$currentSortField){
            $class.=' '.$sortActiveClass;
            $selected = ' selected';
        }

        if($currentSortOrder=='desc'){
            $class.=' '.$sortUpClass;
        }
        else{
            $class.=' '.$sortDownClass;
        }
        $data = [
            'value'=>$value,
            'caption'=>$caption,
            'selected'=>$selected,
            'data'=>$dataAttr,
            'class'=>$class,
        ];
        $sortRow .= $modx->parseText($sortRowTpl,$data);
    }
}

$data = [
    'class'=>' set-sort-field',
    'wrapper'=>$sortRow,

];
$sortOuter = $modx->parseText($sortOwnerTpl,$data);

$class = ' sort-wrap';
if($ajax==1){
    $class .= ' ajax';
}
$data = [
    'display.block'=>$displayOuter,
    'sort.block'=>$sortOuter,
    'class'=>$class
];
$output = $modx->parseText($ownerTpl,$data);

echo $output;
