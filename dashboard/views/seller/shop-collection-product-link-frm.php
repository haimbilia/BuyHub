<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="col-lg-6 col-md-6">
    <?php
    $collectionLinkFrm->setFormTagAttribute('onsubmit', 'setUpSellerCollectionProductLinks(this); return(false);');
    $collectionLinkFrm->setFormTagAttribute('class', 'form form--horizontal');
    $collectionLinkFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md- ';
    $collectionLinkFrm->developerTags['fld_default_col'] = 12;

    $submitFld = $collectionLinkFrm->getField('btn_submit');
    $submitFld->setFieldTagAttribute('class', "btn btn-brand btn-wide");
    echo $collectionLinkFrm->getFormHtml();
    ?>
</div>

<script type="text/javascript">
    $("document").ready(function () {
        $('#selprod-products').on('click', '.remove_link', function () {
            $(this).parent().remove();
        });
    });

<?php
if (isset($products) && !empty($products)) {
    foreach ($products as $key => $val) {
        $options = SellerProduct::getSellerProductOptions($val['selprod_id'], true, $siteLangId);
        $variantsStr = '';
        array_walk($options, function ($item, $key) use (&$variantsStr) {
            $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
        });
        $productName = strip_tags(html_entity_decode(($val['product_name'] != '') ? $val['product_name'] : $val['product_identifier'], ENT_QUOTES, 'UTF-8'));
        $productName .= $variantsStr;
        ?>
            $('#selprod-products ul').append("<li id=\"selprod-products<?php echo $val['selprod_id']; ?>\"> <?php echo $productName; ?>[<?php echo $val['product_identifier']; ?>] <i class=\"fa fa-times remove_param remove_link\"></i> <input type=\"hidden\"  name=\"product_ids[]\" value=\"<?php echo $val['selprod_id']; ?>\" /></li>");
    <?php }
}
?>
</script>