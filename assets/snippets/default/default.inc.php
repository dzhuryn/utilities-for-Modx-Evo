<?php
$val = isset($val)?$val:'';
$name = isset($name)?$name:'';
$data = [];


if(empty($GLOBALS['default'][$name])){
    $T = $modx->getFullTableName('site_tmplvars');
    $tvName = $modx->db->escape($name);
    $data = $modx->db->getRow($modx->db->query("select * from ".$T." where `name` = '".$tvName."' "));
    if(empty($data)){
        return '';
    }
    $out = [];
    $element = $data['elements'];
    $tv_id = $data['id'];
    if (stristr($element, "@EVAL")) {
        $element = trim(substr($element, 6));
        $element = eval($element);
    }
    if ($element != '') {
        $tmp = explode("||", $element);
        foreach ($tmp as $v) {
            $tmp2 = explode("==", $v);
            $key = isset($tmp2[1]) && $tmp2[1] != '' ? $tmp2[1] : $tmp2[0];
            $value = $tmp2[0];
            if ($key != '') {
                $out[$key]= $value;
            }
        }
    }
    if (stristr($element, "@SELECT")) {
        $out = [];
        $element = str_replace(['@SELECT','[+PREFIX+]'],['SELECT',$modx->db->config['table_prefix']],$element);
        $resp = $modx->db->makeArray($modx->db->query($element));
        foreach ($resp as $el) {
            $keys = array_keys($el);
            $out[$el[$keys[1]]] = $el[$keys[0]];
        }
    }
    $GLOBALS['default'][$name] = $out;
    $data = $out;

}
else{
    $data = $GLOBALS['default'][$name];
}
$output = '';
if(!empty($data[$val])){
    $output = $data[$val];
}
echo $output;