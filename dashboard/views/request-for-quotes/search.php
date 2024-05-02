<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-table">
    <div class="js-scrollable table-wrap table-responsive">
        <?php
        $tbl = new HtmlElement('table', array('class' => 'table table-justified'));
        $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => ''));
        foreach ($headerCols as $val) {
            $e = $th->appendElement('th', array(), $val);
        }

        $sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
        foreach ($arrListing as $sn => $row) {
            $tr = $tbl->appendElement('tr', array('class' => ''));

            foreach ($headerCols as $key => $val) {
                $td = $tr->appendElement('td');
                switch ($key) {
                    case 'listSerial':
                        $td->appendElement('plaintext', array(), $sr_no);
                        break;
                    case 'rfq_title':
                        $url = 0 < $row['rfq_selprod_id'] ? UrlHelper::generateUrl('Products', 'view', array($row['rfq_selprod_id']), CONF_WEBROOT_FRONTEND) : 'javascript:void(0)';
                        $global = '';
                        if (1 > $row['rfq_product_id'] && 1 > $row['rfq_selprod_id']) {
                            $global = HtmlHelper::getStatusHtml(HtmlHelper::INFO, Labels::getLabel('LBL_GLOBAL'));
                        }
                        $htm = '<div>
                                    <span class="product-profile__title">
                                        <a href="' . $url . '">' . Labels::getLabel('LBL_TITLE') . ': ' . $row[$key] . '</a>
                                    </span>
                                    ' . $global . '
                                    <div>' . Labels::getLabel('LBL_QTY') . ': ' . $row['rfq_quantity'] . ' ' . applicationConstants::getWeightUnitName($siteLangId, $row['rfq_quantity_unit'], true) . '</div>
                                </div>';
                        $td->appendElement('plaintext', array(), $htm, true);
                        break;
                    case 'rfq_number':
                        $td->appendElement('div', ["class" => 'text-nowrap'], $row['rfq_number'], true);
                        break;
                    case 'acceptedOffers':
                    case 'rejectedOffers':
                        $offerCount = ($row['totalOffers'] > 0) ? $row[$key] . '/' . $row['totalOffers'] : 0;
                        $td->appendElement('plaintext', [], $offerCount, true);
                        break;
                    case 'rfq_approved':
                        if (RequestForQuote::STATUS_CLOSED == $row['rfq_status']) {
                            $html = HtmlHelper::getStatusHtml(HtmlHelper::DANGER, Labels::getLabel('LBL_CLOSED'));
                        } else {
                            $html = '<span class="' . RequestForQuote::getBadgeClass($row[$key]) . '">' . $approvalStatusArr[$row[$key]] . '</span>';
                        }
                        $td->appendElement('plaintext', array(), $html, true);
                        break;
                    case 'rfq_added_on':
                        $td->appendElement('plaintext', array(), HtmlHelper::formatDateTime($row[$key]), true);
                        break;
                    case 'action':
                        $ul = $td->appendElement("ul", array("class" => "actions"), '', true);
                        $li = $ul->appendElement("li", ['class' => 'actions-item']);
                        $li->appendElement(
                            'a',
                            array(
                                'class' => 'actions-link',
                                'href' => 'javascript:void(0)',
                                'onclick' => 'viewRfq("' . $row['rfq_id'] . '", ' . $rfqPlacementType . ');',
                                'title' => Labels::getLabel('LBL_VIEW', $siteLangId)
                            ),
                            '<svg class="svg" width="18" height="18">
                            <use
                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#view">
                            </use>
                        </svg>',
                            true
                        );

                        if ($row['rfq_approved'] == RequestForQuote::APPROVED) {
                            $action = RequestForQuote::PLACEMENT_TYPE_GLOBAL == $rfqPlacementType ? 'globalListing' : 'listing';
                            $li = $ul->appendElement("li", ['class' => 'actions-item']);
                            $li->appendElement(
                                'a',
                                array(
                                    'class' => 'actions-link',
                                    'href' => UrlHelper::generateUrl(($isSeller ? 'Seller' : '') . 'RfqOffers', $action, [$row['rfq_id']]),
                                    'title' => Labels::getLabel('LBL_OFFERS', $siteLangId)
                                ),
                                '<svg class="svg" width="18" height="18">
                            <use
                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#list">
                            </use>
                        </svg>',
                                true
                            );
                        }
                        break;
                    default:
                        $td->appendElement('plaintext', array(), $row[$key], true);
                        break;
                }
            }

            $sr_no--;
        }
        echo $tbl->getHtml();
        if (count($arrListing) == 0) {
            $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId));
        } ?>
    </div>
</div>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmSrchPaging'));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'pageSize' => $pagesize, 'recordCount' => $recordCount, 'callBackJsFunc' => 'goToSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
