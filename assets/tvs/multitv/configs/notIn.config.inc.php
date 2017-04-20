<?php
$settings['display'] = 'vertical';
$settings['fields'] = array(

    'tv' => array(
        'caption' => 'TV',
        'type' => 'dropdown',
        'elements' => '@SELECT caption,name FROM [+PREFIX+]site_tmplvars  ORDER BY caption ASC'
    ),

);
