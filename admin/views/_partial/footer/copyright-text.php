<?php
$str =  CommonHelper::getTechPartner(true);
$includeVesion = !empty($str) ? true : false;
echo CommonHelper::getCopyRight($siteLangId, true, $includeVesion);
