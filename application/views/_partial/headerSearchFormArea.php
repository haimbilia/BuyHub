<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$keywordFld = $headerSrchFrm->getField('keyword');
$submitFld = $headerSrchFrm->getField('btnSiteSrchSubmit');
$submitFld->setFieldTagAttribute('class', 'search--btn submit--js');
$keywordFld->setFieldTagAttribute('class', 'search--keyword search--keyword--js no--focus');
$keywordFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_I_am_looking_for...', $siteLangId));
$keywordFld->setFieldTagAttribute('id', 'header_search_keyword');
$selectFld = $headerSrchFrm->getField('category');
$selectFld->setFieldTagAttribute('id', 'searched_category');
?>

<!-- <div class="main-search">
    <a href="javascript:void(0)" class="toggle--search" data-trigger="form--search-popup"> <span class="icn">
        <svg
                class="svg">
                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#magnifying"
                   ></use>
            </svg></span></a>
    <div class="form--search form--search-popup" id="form--search-popup"
        data-close-on-click-outside="form--search-popup">
        <?php echo $headerSrchFrm->getFormTag(); ?>
        <div class="main-search__field"><?php echo $headerSrchFrm->getFieldHTML('keyword'); ?>
            <div id="search-suggestions-js">               
            </div>
        </div>

        <?php echo $headerSrchFrm->getFieldHTML('category'); ?>
        <?php echo $headerSrchFrm->getFieldHTML('btnSiteSrchSubmit'); ?>
        </form>
        <?php echo $headerSrchFrm->getExternalJS(); ?>
    </div>
</div> -->

<div class="main-search">
    <button class="btn-mega-search" data-bs-backdrop="true" data-bs-toggle="offcanvas" data-bs-target="#mega-nav-search" aria-controls="offcanvas-mega-search">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
        </svg>
    </button>
</div>