<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_PACKAGE_NAME', $siteLangId); ?>

<main class="main mainJs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">              
                <div class="card">
                    <?php $data = [
                        'canEdit' => $canEdit,
                        'siteLangId' => $siteLangId,
                        'cardHeadTitle' => Labels::getLabel('LBL_SUBSCRIPTION_PACKAGE_PLANS', $siteLangId) ." (".$packageName.")",
                        'cardHeadBackButtonHref' => UrlHelper::generateUrl('SellerPackages'),
                        'newRecordBtn' => true,
                        'newRecordBtnAttrs' => [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'addNewPlan(' . $spackageId . ')',
                                'title' => Labels::getLabel('BTN_NEW', $siteLangId)
                            ],
                            'label' => Labels::getLabel('BTN_NEW', $siteLangId)
                        ],
                        'statusButtons' => true
                    ];

                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'seller-package-plans/search.php');

                            $data = [
                                'tbl' => $tbl, /* Received from listing-column-head.php file. */
                                'performBulkAction' => true /* Used in case of performing bulk action. */
                            ];
                            $this->includeTemplate('_partial/listing/print-listing-table.php', $data, false); ?>
                        </div>
                    </div>
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-foot.php'); ?>
                </div>
            </div>
        </div>
    </div>
</main>