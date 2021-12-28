<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$headerSrchFrm->getFormTag();
$headerSrchFrm->setFormTagAttribute('class', 'form mega-search-form');

$keywordFld = $headerSrchFrm->getField('keyword');
$keywordFld->overrideFldType('search');
/* $submitFld = $headerSrchFrm->getField('btnSiteSrchSubmit');
$submitFld->setFieldTagAttribute('class', 'search--btn submit--js'); */
$keywordFld->setFieldTagAttribute('class', 'mega-search-input search--keyword search--keyword--js no--focus');
$keywordFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_I_am_looking_for...', $siteLangId));

$keywordFld->setFieldTagAttribute('id', 'header_search_keyword');


$selectFld = $headerSrchFrm->getField('category');
$selectFld->setFieldTagAttribute('id', 'searched_category');
?>

<div class="mega-search">

    <?php echo $headerSrchFrm->getFormTag(); ?>
    <div class="main-search__field">
        <?php echo $headerSrchFrm->getFieldHTML('keyword'); ?>
        <div id="search-suggestions-js">
        </div>
    </div>

    <?php echo $headerSrchFrm->getFieldHTML('category'); ?>
    <?php /* echo $headerSrchFrm->getFieldHTML('btnSiteSrchSubmit'); */ ?>
    </form>
    <?php echo $headerSrchFrm->getExternalJS(); ?>

</div>