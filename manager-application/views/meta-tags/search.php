<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$havingOtherTable = [
    MetaTag::META_GROUP_PRODUCT_DETAIL,
    MetaTag::META_GROUP_SHOP_DETAIL,
    MetaTag::META_GROUP_CMS_PAGE,
    MetaTag::META_GROUP_BRAND_DETAIL,
    MetaTag::META_GROUP_CATEGORY_DETAIL,
    MetaTag::META_GROUP_BLOG_CATEGORY,
    MetaTag::META_GROUP_BLOG_POST,
];

$tableHeadAttrArr = [
    'listSerial' => [
        'width' => '10%',
    ],
    'meta_title' => [
        'width' => (in_array($metaType, $havingOtherTable)) ? '40%' : '80%',
    ],    
    'action' => [
        'width' => '10%',
    ]
];

switch ($metaType) {
    case MetaTag::META_GROUP_PRODUCT_DETAIL:
        $tableHeadAttrArr = array_merge($tableHeadAttrArr, [
            'selprod_title' => [
                'width' => '40%',
            ],
        ]);
        break;
    case MetaTag::META_GROUP_SHOP_DETAIL:
        $tableHeadAttrArr = array_merge($tableHeadAttrArr, [
            'shop_name' => [
                'width' => '40%',
            ],
        ]);
        break;
    case MetaTag::META_GROUP_CMS_PAGE:
        $tableHeadAttrArr = array_merge($tableHeadAttrArr, [
            'cpage_title' => [
                'width' => '40%',
            ],
        ]);
        break;
    case MetaTag::META_GROUP_BRAND_DETAIL:
        $tableHeadAttrArr = array_merge($tableHeadAttrArr, [
            'brand_name' => [
                'width' => '40%',
            ],
        ]);
        break;
    case MetaTag::META_GROUP_CATEGORY_DETAIL:
        $tableHeadAttrArr = array_merge($tableHeadAttrArr, [
            'prodcat_name' => [
                'width' => '40%',
            ],
        ]);
        break;
    case MetaTag::META_GROUP_BLOG_CATEGORY:
        $tableHeadAttrArr = array_merge($tableHeadAttrArr, [
            'bpcategory_name' => [
                'width' => '40%',
            ],
        ]);
        break;
    case MetaTag::META_GROUP_BLOG_POST:
        $tableHeadAttrArr = array_merge($tableHeadAttrArr, [
            'post_title' => [
                'width' => '40%',
            ],
        ]);
        break;
}

/* No sorting functionality required if no record found. */
if (2 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');

$siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['meta_id']]);
    $metaId = FatUtility::int($row['meta_id']);
    $metaRecordId = FatUtility::int($row['meta_record_id']);
    foreach ($fields as $key => $val) {
        if (!array_key_exists($key, $tableHeadAttrArr)) {
            continue;
        }

        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $metaId
                ];

                if ($canEdit) {
                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => "editMetaTagLangForm(" . $metaId . "," . $siteDefaultLangId . ",'" . $metaType . "'," . $metaRecordId . ")",
                                'title' => Labels::getLabel('BTN_EDIT', $siteLangId)
                            ],
                            'label' => '<svg class="svg" width="20" height="20">
                                            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#edit">
                                            </use>
                                        </svg>'
                        ],
                    ];

                    if ($metaType == MetaTag::META_GROUP_ADVANCED) {
                        $data['deleteButton'] = [];
                    }
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
    $serialNo++;
}

if (count($arrListing) == 0) {
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields),
            'class' => 'noRecordFoundJs'
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId)
    );
} 
if (1 > $loadRows) {
    $onSubmit = 'searchRecords(this, true); return(false);';
    require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); 
} ?>
<div class="card listingTableJs">
    <div class="card-head">
        <div class="card-head-label">
            <h3 class="card-head-title">
                <?php echo CommonHelper::replaceStringData(Labels::getLabel('LBL_{TAB-TITLE}_META_TAGS_LISTING', $siteLangId), ['{TAB-TITLE}' =>  $tabsArr[$metaType]['name']]); ?>
            </h3>
        </div>
        <?php if ($metaType == MetaTag::META_GROUP_ADVANCED) { ?>
        <div class="card-toolbar">
            <?php
                $data = [
                    'canEdit' => $canEdit,
                    'siteLangId' => $siteLangId,
                    'otherButtons' => [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'class' => 'btn btn-icon btn-light btn-add',
                                'title' => Labels::getLabel('BTN_ADD_META_TAG', $siteLangId),
                                'onclick' => "metaTagForm(0,'" . $metaType . "',0)",
                            ],
                            'label' => '<i class="icn">
                                            <svg class="svg">
                                                <use
                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#add">
                                                </use>
                                            </svg>
                                        </i><span> ' . Labels::getLabel('BTN_NEW', $siteLangId) . '</span>'
                        ]
                    ]
                ];
                $this->includeTemplate('_partial/listing/action-buttons.php', $data, false);
                ?>
        </div>
        <?php } ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php echo $tbl->getHtml(); ?>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-foot.php'); ?>
</div>