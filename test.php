<?php
function &test(){
static $b;
return $b;
}


$a = & test();
$a = 6;
$a = 3;
echo test();  