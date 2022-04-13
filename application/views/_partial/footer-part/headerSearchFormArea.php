<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>

<!-- offcanvas-mega-search -->
<div class="offcanvas offcanvas-mega-search" data-bs-backdrop="false" tabindex="-1" id="mega-nav-search" aria-labelledby="mega-nav-searchLabel">
    <?php $headerSrchFrm->getFormTag();
    $headerSrchFrm->setFormTagAttribute('class', ' mega-search-form');

    $keywordFld = $headerSrchFrm->getField('keyword');
    $keywordFld->overrideFldType('search');
    $keywordFld->setFieldTagAttribute('class', 'mega-search-input search--keyword search--keyword--js');
    $keywordFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_I_am_looking_for...', $siteLangId));

    $keywordFld->setFieldTagAttribute('id', 'header_search_keyword');


    $selectFld = $headerSrchFrm->getField('category');
    $selectFld->setFieldTagAttribute('id', 'searched_category');
    ?>

    <div class="mega-search">
        <div class="mega-search-inner">
            <?php echo $headerSrchFrm->getFormTag(); ?>
            <?php echo $headerSrchFrm->getFieldHTML('keyword'); ?>
            <div id="search-suggestions-js"> </div>
            <?php echo $headerSrchFrm->getFieldHTML('category'); ?>
            </form>
            <?php echo $headerSrchFrm->getExternalJS(); ?>
            <button type="button" class="btn btn-close text-reset btn-search-close" data-bs-dismiss="offcanvas" aria-label="Close">
            </button>
        </div>
    </div>
</div>