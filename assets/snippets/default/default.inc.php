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
    $GLOBALS['default'][$name] = $out;

    $data = $out;

}
else{
    $data = $GLOBALS['default'][$name];
}
if(!empty($data[$val])){
    $val = $data[$val];
}
return $val;