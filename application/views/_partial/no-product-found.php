<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$pSrchFrm->setFormTagAttribute('class', 'form custom-form');
$pSrchFrm->setFormTagAttribute('name', 'frmSiteSearchCustom');
$pSrchFrm->setFormTagAttribute('id', 'frm_fat_id_frmSiteSearch_custom');
$keywordFld = $pSrchFrm->getField('keyword');

$keywordFld->setFieldTagAttribute('class', 'search--keyword--js omni-search');
$keywordFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_for_Product...', $siteLangId));
$keywordFld->overrideFldType('search');

$keywordFld->setFieldTagAttribute('id', 'header_search_keyword');
$keywordFld->setFieldTagAttribute('onkeyup', 'animation(this)'); ?>
<div class="container align-center">
    <div class="no-product">
        <div class="block-empty m-auto text-center">
            <img class="block__img" width="100" height="100" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/empty-cart.svg" alt="<?php echo Labels::getLabel('LBL_No_Product_found', $siteLangId); ?>">
            <h3><?php echo Labels::getLabel('LBL_WE_COULD_NOT_FIND_ANY_MATCHES!', $siteLangId); ?></h3>
            <h6><?php echo Labels::getLabel('LBL_Please_check_if_you_misspelt_something_or_try_searching_again_with_fewer_keywords.', $siteLangId); ?>
            </h6><br>
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4">
                    <div class="query-form">
                        <?php echo $pSrchFrm->getFormTag(); ?>
                        <?php echo $pSrchFrm->getFieldHTML('keyword'); ?>
                        </form>
                        <?php echo $pSrchFrm->getExternalJS(); ?>
                    </div>
                </div>
            </div>
            <?php
            $top_searched_keywords = SearchItem::getTopSearchedKeywords();
            if (count($top_searched_keywords) > 0) : ?>
                <div class="popular-searches my-5">
                    <h3 class=""><?php echo Labels::getLabel('L_Popular_Searches', $siteLangId) ?> </h3>
                    <ul class="browse-more">
                        <?php $inc = 0;
                        foreach ($top_searched_keywords as $record) {
                            $inc++;
                            if ($inc > 1) {
                                echo "";
                            } ?>
                            <li>
                                <a onclick="searchTags(this)" data-txt="<?php echo $record['searchitem_keyword']; ?>" href="javascript:void(0);"><?php echo $record['searchitem_keyword'] ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
$postedData['page'] = 1;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmProductSearchPaging', 'id' => 'frmProductSearchPaging'));
