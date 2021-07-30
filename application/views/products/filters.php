<?php
if(isset($headerFormParamsAssocArr['vtype']) && $headerFormParamsAssocArr['vtype'] == 'map'){
    include_once 'filters-top.php';
}else{
    include_once 'filters-left.php';
}