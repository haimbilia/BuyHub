<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <?php 
        $data = [
            'headingLabel' => Labels::getLabel('LBL_Requests', $siteLangId),
            'siteLangId' => $siteLangId,
        ];

        if ($canEdit && !$noRecordFound) {
            $otherBtnHtml = '<div class="dropdown dashboard-user">
                                <button class="btn btn-outline-brand dropdown-toggle btn-sm" type="button" id="dashboardDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ' . Labels::getLabel('LBL_New_Request', $siteLangId) . '
                                </button>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim" aria-labelledby="dashboardDropdown">
                                    <ul class="nav nav-block">';
                                        if (FatApp::getConfig('CONF_SELLER_CAN_REQUEST_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0)) {
                                            $otherBtnHtml .= '<li class="nav__item">
                                                <a class="dropdown-item nav__link" href="' . UrlHelper::generateUrl('Seller', 'customCatalogProductForm') . '">
                                                    ' . Labels::getLabel('LBL_Marketplace_Product', $siteLangId) . '
                                                </a>
                                            </li>';
                                        }

                                        if (FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) {
                                            $otherBtnHtml .= '<li class="nav__item">
                                                <a class="dropdown-item nav__link" href="javascript:void(0);" onClick="addBrandReqForm(0)">
                                                    ' . Labels::getLabel('LBL_Brand', $siteLangId) . '
                                                </a>
                                            </li>';
                                        }

                                        if (FatApp::getConfig('CONF_PRODUCT_CATEGORY_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) {
                                            $otherBtnHtml .= '<li class="nav__item">
                                                <a class="dropdown-item nav__link" href="javascript:void(0);" onClick="addCategoryReqForm(0)">
                                                    ' . Labels::getLabel('LBL_Category', $siteLangId) . '
                                                </a>
                                            </li>';
                                        }

                                        if ($canRequestBadge) {
                                            $otherBtnHtml .= '<li class="nav__item">
                                                <a class="dropdown-item nav__link" href="javascript:void(0);" onClick="addBadgeReqForm(0)">
                                                    ' . Labels::getLabel('LBL_BADGE_REQUEST', $siteLangId) . '
                                                </a>
                                            </li>';
                                        }
                    $otherBtnHtml .= '</ul>
                                </div>
                            </div>';

            $data['otherButtons'] = [
                'html' => $otherBtnHtml
            ];
        }
        $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>

        <div class="content-body">
            
            <?php
            if (!$noRecordFound) {
                $variables = array('siteLangId' => $siteLangId, 'action' => $action, 'canRequestBadge' => $canRequestBadge);
                $this->includeTemplate('seller-requests/_partial/requests-navigation.php', $variables, false);
            }
            ?>
           
            <div class="card">
                <div class="card-body">
                    <div class="pagebody--js">
                        <?php if ($noRecordFound) { ?>
                            <div class="row justify-content-center my-5">
                                <div class="col-md-6">
                                    <div class="info">
                                        <span> <svg class="svg">
                                                <use xlink:href="<?php echo CONF_WEBROOT_FRONT_URL; ?>images/retina/sprite.svg#info" href="<?php echo CONF_WEBROOT_FRONT_URL; ?>images/retina/sprite.svg#info">
                                                </use>
                                            </svg><?php echo Labels::getLabel('LBL_Generate_requests_using_buttons_below', $siteLangId); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <?php if (FatApp::getConfig('CONF_SELLER_CAN_REQUEST_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0)) { ?>
                                    <div class="col-md-3">
                                        <div class="no-data-found">
                                            <div class="img">
                                                <img src="<?php echo CONF_WEBROOT_FRONT_URL; ?>images/retina/no-product-requests.svg" width="70px" height="70px">
                                            </div>
                                            <div class="data">
                                                <div class="action">
                                                    <a class="btn btn-outline-brand btn-sm" href="<?php echo UrlHelper::generateUrl('Seller', 'customCatalogProductForm'); ?>"><?php echo Labels::getLabel('LBL_New_Product_Request', $siteLangId); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) { ?>
                                    <div class="col-md-3">
                                        <div class="no-data-found">
                                            <div class="img">
                                                <img src="<?php echo CONF_WEBROOT_FRONT_URL; ?>images/retina/no-brand-requests.svg" width="70px" height="70px">
                                            </div>
                                            <div class="data">
                                                <div class="action">
                                                    <a class="btn btn-outline-brand btn-sm" href="javascript:void(0);" onClick="addBrandReqForm(0)"><?php echo Labels::getLabel('LBL_New_Brand_Request', $siteLangId); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (FatApp::getConfig('CONF_PRODUCT_CATEGORY_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) { ?>
                                    <div class="col-md-3">
                                        <div class="no-data-found">
                                            <div class="img">
                                                <img src="<?php echo CONF_WEBROOT_FRONT_URL; ?>images/retina/no-category-requests.svg" width="70px" height="70px">
                                            </div>
                                            <div class="data">
                                                <div class="action">
                                                    <a class="btn btn-outline-brand btn-sm" href="javascript:void(0);" onClick="addCategoryReqForm(0)"><?php echo Labels::getLabel('LBL_New_Category_Request', $siteLangId); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($canRequestBadge) { ?>
                                    <div class="col-md-3">
                                        <div class="no-data-found">
                                            <div class="img">
                                                <img src="<?php echo CONF_WEBROOT_FRONT_URL; ?>images/retina/no-brand-requests.svg" width="70px" height="70px">
                                            </div>
                                            <div class="data">
                                                <div class="action">
                                                    <a class="btn btn-outline-brand btn-sm" href="javascript:void(0);" onClick="addBadgeReqForm(0)"><?php echo Labels::getLabel('LBL_ADD_BADGE_REQUEST', $siteLangId); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>                                   
                            <div id="listing"> <?php echo Labels::getLabel('LBL_Processing...', $siteLangId); ?></div>
                        <?php } ?>
                    </div>
                    <span class="editRecord--js"></span>
                </div>
            </div>            
        </div>
    </div>
</main>
<script>
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;
    var canRequestCustomProduct = <?php echo FatApp::getConfig('CONF_SELLER_CAN_REQUEST_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0); ?>;
    $(document).ready(function() {
        if (canRequestCustomProduct) {
            searchCustomCatalogProducts();
        } else {
            searchBrandRequests();
        }
    });
</script>