<?php
defined('SYSTEM_INIT') or die('Invalid Usage');
$pagination = '';
if ($pageCount < 1) {
    return $pagination;
}

/*Number of links to display*/
$linksToDisp = isset($linksToDisp) ? $linksToDisp : 2;

/* Current page number */
$pageNumber = $page;

/*arguments mixed(array/string(comma separated)) // function arguments*/
$arguments = (isset($arguments)) ? $arguments : null;

$pageSize = (isset($pageSize)) ? $pageSize : FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

/*padArgListTo boolean(T/F) // where to pad argument list (left/right) */
$padArgToLeft = (isset($padArgToLeft)) ? $padArgToLeft : true;

/*On clicking page link which js function need to call*/
$callBackJsFunc = isset($callBackJsFunc) ? $callBackJsFunc : 'goToSearchPage';

$setPageSizeJsFunc = isset($setPageSizeJsFunc) ? $setPageSizeJsFunc : 'setPageSize';
$setPageSizeJsFunc = $setPageSizeJsFunc . '(this.value)';

if (null != $arguments) {
    if (is_array($arguments)) {
        $args = implode(', ', $arguments);
    } elseif (is_string($arguments)) {
        $args = $arguments;
    }
    if ($padArgToLeft) {
        $callBackJsFunc = $callBackJsFunc . '(' . $args . ', xxpagexx);';
    } else {
        $callBackJsFunc = $callBackJsFunc . '(xxpagexx, ' . $args . ');';
    }
} else {
    $callBackJsFunc = $callBackJsFunc . '(xxpagexx);';
}

$pagination .=     FatUtility::getPageString(
    '<li><a href="javascript:void(0);" onclick="' . $callBackJsFunc . '">xxpagexx</a></li>',
    $pageCount,
    $pageNumber,
    ' <li class="selected"><a href="javascript:void(0);">xxpagexx</a></li>',
    ' <li><a href="javascript:void(0);">...</a></li> ',
    $linksToDisp,
    ' <li class="first"><a href="javascript:void(0);" onclick="' . $callBackJsFunc . '"></a></li>',
    ' <li class="last"><a href="javascript:void(0);" onclick="' . $callBackJsFunc . '"></a></li>',
    ' <li class="prev"><a href="javascript:void(0);" onclick="' . $callBackJsFunc . '"></a></li>',
    ' <li class="next"><a href="javascript:void(0);" onclick="' . $callBackJsFunc . '"></a></li>'
);
?>
<div class="row justify-content-between">
    <div class="col">
        <div class="data-length">
            <?php $pageSizeArr = applicationConstants::getPageSizeValues();
            if (!empty($pageSizeArr)) { ?>
                <select name="pageSize" id="pageSize" class="form-select data-length-select" onchange="<?php echo $setPageSizeJsFunc; ?>">
                    <?php foreach ($pageSizeArr as $val) { ?>
                        <option value="<?php echo $val; ?>" <?php echo ($pageSize == $val) ? 'selected' : ''; ?>><?php echo $val; ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
            <div class="data-length-info"></div>
            <?php if (1 < $pageCount) {               
                $startIdx = (($pageNumber - 1) * $pageSize) + 1;
                $str = Labels::getLabel('LBL_SHOWING', $adminLangId) . ' ';
                $str .= $startIdx;
                $str .= ' ' . Labels::getLabel('LBL_TO', $adminLangId) . ' ';
                $str .= ($recordCount < $startIdx + $pageSize - 1) ? $recordCount : $startIdx + $pageSize - 1;
                $str .= ' ' . Labels::getLabel('LBL_OF', $adminLangId);
                $str .= ' ' . $recordCount;
                $str .= ' ' . Labels::getLabel('LBL_RECORDS', $adminLangId);
                echo $str;
            } ?>
        </div>
    </div>
    <div class="col-auto">
        <?php
        $ul = new HtmlElement(
            'ul',
            array(
                'class' => 'pagination',
            ),
            $pagination,
            true
        );
        echo $ul->getHtml();
        ?> </div>
</div>