<?php
$mode = isset($mode) ? $mode : 'return';
$num = isset($num) ? $num : 0;
$input = isset($input) ? $input : '';
$options = isset($options) ? $options : '';
$key = isset($key) ? $key : 'image';

if (!empty($input)) {
    $input = str_replace('&_PHX_INTERNAL_091_&', '[', $input);
    $input = str_replace('&_PHX_INTERNAL_093_&', ']', $input);
    $input = json_decode($input, true);
    $input = $input['fieldValue'];
}

if (empty($input[0][$key])) {
    return '';
}
if($num!=0 && !empty($input[$num][$key])){
    $image = $input[$num][$key];
}
else{
    $image = $input[0][$key];
}


if (!empty($options)) {
    $image = $modx->runSnippet('phpthumb', array(
        'input' => $image,
        'options' => $options
    ));
}
switch ($mode) {
    case 'echo':
        echo $image;
        break;
    default:
        return $image;
        break;

}
?>
