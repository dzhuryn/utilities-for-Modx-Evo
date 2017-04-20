<?php

require MODX_BASE_PATH.'assets/snippets/utilities/tvsList/class.tvsList.php';

$obj = new tvsList($modx,$params);
echo $obj->render();