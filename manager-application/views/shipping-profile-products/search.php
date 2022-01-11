<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
if (!empty($productsData)) {
    echo '<div class="mt-4"> <ul class="upload__list">';
    foreach ($productsData as $product) {
        ?>
        <li class="upload__list-item">
            <div class="media">
                <img class="mr-2 product-profile-img" src="<?php echo UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'SMALL', 0, 0, 1)) ?>" alt="" width="50">
            </div>
            <div class="title"><?php echo $product['product_name'] ?></div>
            <?php if (isset($profileData['shipprofile_default']) && $profileData['shipprofile_default'] != 1) { ?>
                <div class="action">
                    <a href="javascript:void(0);" class="" title="<?php echo Labels::getLabel('LBL_Remove_Product_from_profile', $siteLangId); ?>" onclick="removeProductFromProfile('<?php echo $product['product_id']; ?>')"> </a>
                </div>
            <?php } ?>
        </li>
        <?php
    }
    echo '</ul></div>';
} else {
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId));
}

$frm = new Form('frmProductListing', array('id' => 'frmProductListing'));
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'formAction(this, reloadListProduct); return(false);');
echo $frm->getFormTag();
?>
</form>
<?php
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmProductSearchPaging'));
//$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'siteLangId' => $siteLangId);

$pageCount = ($pageCount == 1) ? 0 : $pageCount;
$pagingArr = array('pageCount' => $pageCount, 'displayPageSizeDropdown' => false, 'page' => $page, 'pageSize' => $pageSize, 'recordCount' => $recordCount, 'siteLangId' => (isset($langId) && 0 < $langId ? $langId : $siteLangId));
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
?>
<style>
    .product-profile-img {
        display: inline;
    }
</style>