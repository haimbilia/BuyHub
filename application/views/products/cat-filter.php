<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$catCodeArr = array();

if (isset($prodcat_code)) {
    $currentCategoryCode = substr($prodcat_code, 0, -1);
    $catCodeArr = explode("_", $currentCategoryCode);
    array_walk($catCodeArr, function (&$n) {
        $n = FatUtility::int($n);
    });
}
?>
<?php if ($shopCatFilters) {
    $searchFrm->setFormTagAttribute('onSubmit', 'searchProducts(this); return(false);');
    $keywordFld = $searchFrm->getField('keyword');
    $keywordFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_PRODUCT_SEARCH', $siteLangId)); ?>
    <div class="product-search">
        <?php
        $searchFrm->addFormTagAttribute('class', 'form');
        $searchFrm->setFormTagAttribute('id', 'filterSearchForm');
        echo $searchFrm->getFormTag();
        $fld = $searchFrm->getField('keyword');
        $fld->overrideFldType('search');
        $fld->addFieldTagAttribute("class", "form-control omni-search filterSearchJs");
        echo $searchFrm->getFieldHtml('keyword');
        echo $searchFrm->getFieldHtml('shop_id');
        echo $searchFrm->getFieldHtml('join_price');
        echo '</form>';
        echo $searchFrm->getExternalJS(); ?>
    </div>
<?php
} ?>

<div class="" id="filters_body--js">
    <div class="sidebar-widget resetFilterSectionJs" style="display: none;">
        <div class="selected-filters-head">
            <h5> <?php echo Labels::getLabel('LBL_Filtered_by_:', $siteLangId); ?></h5>
            <button type="button" class="link-underline link-underline-brand" id="resetAllJs" onClick="resetListingFilter()" style="display:none;">
                <?php echo Labels::getLabel('LBL_Clear_All', $siteLangId); ?>
            </button>
        </div>
        <div class="selected-filters selectedFiltersJs"></div>
    </div>
    <?php if (isset($categoriesArr) && $categoriesArr) { ?>
        <div class="sidebar-widget">
            <div class="sidebar-widget_head" data-bs-toggle="collapse" data-bs-target="#category" aria-expanded="true">
                <?php echo Labels::getLabel('LBL_Categories', $siteLangId); ?>
            </div>
            <div class="sidebar-widget_body collapse show" id="category">
                <?php if (!$shopCatFilters) { ?>
                    <ul class="grouping grouping-level sidebarNavLinksJs category-accordion" id="sidebarNavLinks">
                        <?php
                        $isDisplayInFilters = true;
                        $displayCount = 0;
                        foreach ($categoriesArr as $link) {
                            if ($displayCount > 50) {
                                break;
                            }
                            $href = UrlHelper::generateUrl('category', 'view', array($link['prodcat_id']));
                            $OrgnavUrl = UrlHelper::generateUrl('category', 'view', array($link['prodcat_id']), '', false);
                            if (0 < count($link['children'])) {
                                $href = '#';
                            }

                            require CONF_THEME_PATH . '_partial/navigation/mobile-nav-item-cat.php';
                            $displayCount++;
                        }
                        if ($displayCount > 50) {
                        ?>
                            <li class="grouping-item">
                                <span class="grouping-section">
                                    <a class="grouping-title view-all" href="<?php echo UrlHelper::generateUrl('category'); ?>"><?php echo Labels::getLabel('LBL_VIEW_ALL') ?></a>
                                </span>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <div class="scrollbar-filters  scroll scroll-y" id="scrollbar-filters">
                        <ul class="list-vertical">
                            <?php
                            $seprator = '&raquo;&raquo;&nbsp;&nbsp;';
                            foreach ($categoriesArr as $cat) {
                                $catName = $cat['prodcat_name'];
                                $productCatCode = explode("_", $cat['prodcat_code']);
                                $productCatName = '';
                                $seprator = '';
                                foreach ($productCatCode as $code) {
                                    $code = FatUtility::int($code);
                                    if ($code) {
                                        if (isset($categoriesArr[$code]['prodcat_name'])) {
                                            $productCatName .= $seprator . $categoriesArr[$code]['prodcat_name'];
                                            $seprator = '&raquo;&raquo;&nbsp;&nbsp;';
                                        }
                                    }
                                } ?>
                                <li>
                                    <label class="checkbox brand" id="prodcat_<?php echo $cat['prodcat_id']; ?>">
                                        <input name="category" value="<?php echo $cat['prodcat_id']; ?>" type="checkbox" data-title="<?php echo $catName; ?>" <?php echo (in_array($cat['prodcat_id'], $prodcatArr)) ? "checked" : ""; ?>>
                                        <span class="label-txt"> <?php echo $productCatName; ?></span>
                                    </label>
                                </li>
                            <?php
                            } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    var catCodeArr = <?php echo json_encode($catCodeArr); ?>;
    $.each(catCodeArr, function(key, value) {
        if ($("ul li a[data-id='" + value + "']").parent().find('span')) {
            $("ul li a[data-id='" + value + "']").parent().find('span:first').addClass(
                'is-active');
            $("ul li a[data-id='" + value + "']").parent().find('ul:first').css('display',
                'block');
        }
    });

    $("#accordian li span.acc-trigger").on('click', function() {
        var link = $(this);
        var closest_ul = link.siblings("ul");

        if (link.hasClass("is-active")) {
            closest_ul.slideUp();
            link.removeClass("is-active");
        } else {
            closest_ul.slideDown();
            link.addClass("is-active");
        }
    });
    $('.dropdown-menu').on('click', function(e) {
        e.stopPropagation();
    });
</script>