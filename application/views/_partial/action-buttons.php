<?php
defined('SYSTEM_INIT') or die('Invalid Usage');

$div = new HtmlElement('div', array('class' => 'd-flex'));
if (isset($htmlContent) && $htmlContent != '') {
    $div->appendElement('div', ["class" => 'dropdown custom-drag-drop mr-2'], $htmlContent, true);
}
$btnGrp = $div->appendElement('div', array("class" => "btn-group"));
$msg = isset($msg) ? $msg : '';
if ((!isset($statusButtons) || true === $statusButtons)) {
    $div->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-outline-brand btn-sm formActionBtn-js formActions-css', 'title' => Labels::getLabel('LBL_Publish', $siteLangId), "onclick" => "toggleBulkStatues(1, '" . $msg . "')"), '<i class="fas fa-eye"></i>', true);

    $div->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-outline-brand btn-sm formActionBtn-js formActions-css', 'title' => Labels::getLabel('LBL_Unpublish', $siteLangId), "onclick" => "toggleBulkStatues(0, '" . $msg . "')"), '<i class="fas fa-eye-slash"></i>', true);
}

if (!isset($deleteButton) || true === $deleteButton) {
    $div->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn btn-outline-brand btn-sm formActionBtn-js formActions-css', 'title' => Labels::getLabel('LBL_Delete', $siteLangId), "onclick" => "deleteSelected()"), '<i class="fas fa-trash"></i>', true);
}

if (isset($otherButtons) && is_array($otherButtons)) {
    foreach ($otherButtons as $attr) {
        $class = isset($attr['attr']['class']) ? $attr['attr']['class'] : '';
        $attr['attr']['class'] = 'btn btn-outline-brand btn-sm ' . $class;
        $btnGrp->appendElement('a', $attr['attr'], (string) $attr['label'], true);
    }
}
echo $div->getHtml();
?>
<script>
$('.dropdown-menu').on('click', function(e) {
    e.stopPropagation();
});
</script>