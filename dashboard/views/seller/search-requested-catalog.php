<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="box__head">
    <h5><?php echo Labels::getLabel('LBL_Catalog_Listing', $siteLangId); ?></h5>
    <div class="">
        <a href="<?php echo UrlHelper::generateUrl('seller', 'products'); ?>" class="btn btn-brand btn-sm"><?php echo Labels::getLabel('LBL_Back_To_Products', $siteLangId); ?></a>
        <a href="javascript:void(0);" onclick="addNewCatalogRequest()" class="btn btn-outline-gray btn-sm"><?php echo Labels::getLabel('LBL_Request_to_add_catalog', $siteLangId); ?></a>
    </div>
</div>
<div class="box__body">
    <div class="js-scrollable table-wrap table-responsive">
        <?php $arr_flds = array(
            'listserial' => 'Sr.',
            'scatrequest_reference' => Labels::getLabel('LBL_Reference_number', $siteLangId),
            'scatrequest_title' => Labels::getLabel('LBL_Title', $siteLangId),
            'scatrequest_status' => Labels::getLabel('LBL_Status', $siteLangId),
            'action' => Labels::getLabel('LBL_Action', $siteLangId)
        );
        $tableClass = '';
        if (0 < count($arrListing)) {
            $tableClass = "table-justified";
        }
        $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table ' . $tableClass));
        $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => ''));
        foreach ($arr_flds as $val) {
            $e = $th->appendElement('th', array(), $val);
        }

        $sr_no = ($page == 1) ? 0 : ($pageSize * ($page - 1));
        foreach ($arrListing as $sn => $row) {
            $sr_no++;
            $tr = $tbl->appendElement('tr', array('class' => ''));

            foreach ($arr_flds as $key => $val) {
                $td = $tr->appendElement('td');
                switch ($key) {
                    case 'listserial':
                        $td->appendElement('plaintext', array(), $sr_no, true);
                        break;
                    case 'scatrequest_title':
                        $td->appendElement('plaintext', array(), $row[$key] . '<br>', true);
                        break;
                    case 'scatrequest_status':
                        $td->appendElement('plaintext', array(), $catalogReqStatusArr[$row[$key]], true);
                        break;
                    case 'action':
                        $ul = $td->appendElement("ul", array('class' => 'actions'), '', true);
                        $li = $ul->appendElement("li");
                        $li->appendElement(
                            'a',
                            array('href' => 'javascript:void(0)', 'onclick' => 'viewRequestedCatalog(' . $row['scatrequest_id'] . ')', 'class' => '', 'title' => Labels::getLabel('LBL_View', $siteLangId)),
                            '<i class="icn">
                        <svg class="svg" width="18" height="18">
                            <use
                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg' . AttachedFile::setTimeParam(RELEASE_DATE) . '#view">
                            </use>
                        </svg>
                    </i>',
                            true
                        );
                        if ($row['scatrequest_status'] == User::CATALOG_REQUEST_PENDING) {
                            $li = $ul->appendElement("li");
                            $li->appendElement(
                                'a',
                                array('href' => 'javascript:void(0)', 'onclick' => 'deleteRequestedCatalog(' . $row['scatrequest_id'] . ')', 'class' => '', 'title' => Labels::getLabel('LBL_Delete', $siteLangId)),
                                '<i class="icn">
                        <svg class="svg" width="18" height="18">
                            <use
                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg' . AttachedFile::setTimeParam(RELEASE_DATE) . '#delete">
                            </use>
                        </svg>
                    </i>',
                                true
                            );
                        }
                        $li = $ul->appendElement("li");
                        $li->appendElement(
                            'a',
                            array('href' => 'javascript:void(0)', 'onclick' => 'messageForm(' . $row['scatrequest_id'] . ')', 'class' => '', 'title' => Labels::getLabel('LBL_Messages', $siteLangId)),
                            '<i class="icn">
                        <svg class="svg" width="18" height="18">
                            <use
                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg' . AttachedFile::setTimeParam(RELEASE_DATE) . '#icon-message">
                            </use>
                        </svg>
                    </i>',
                            true
                        );
                        break;
                    default:
                        $td->appendElement('plaintext', array(), $row[$key], true);
                        break;
                }
            }
        }
        echo $tbl->getHtml();
        if (count($arrListing) == 0) {
            $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
            $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
        } ?>
    </div>
    <?php $postedData['page'] = $page;
    echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmCatalogReqSearchPaging'));

    $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'callBackJsFunc' => 'goToCatalogReqSearchPage');
    $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
    ?>
</div>