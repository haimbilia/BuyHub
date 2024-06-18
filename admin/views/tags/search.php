<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
$page = $page ?? 0;
$pageSize = $pageSize ?? 0;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $selProdId => $row) {
    $serialNo++;
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    foreach ($fields as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', [], $serialNo);
                break;
            case 'tags':
                $productTags = Product::getProductTags($row['product_id'], $langId, false, array('tag_id as id', 'tag_name as value'));
                $encodedData = htmlspecialchars(json_encode($productTags), ENT_QUOTES, 'UTF-8');
                $td->appendElement('plaintext', array(), "<div class='product-tag' id='product" . $row['product_id'] . "'><input class='form-control productsTagsJs' placeholder='" . Labels::getLabel('FRM_TYPE_TO_SEARCH_TAGS', $siteLangId) . "'  type='text' name='tag_name" . $row['product_id'] . "' value='" . $encodedData . "' data-product_id='" . $row['product_id'] . "'></div>", true);
                break;
            default:
                $td->appendElement('plaintext', [], $row[$key], true);
                break;
        }
    }
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
?>
<script>
    $(function() {
        TagTagify('<?php echo $formLayout; ?>');
    });
</script>