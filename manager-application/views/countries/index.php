<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this, false); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

$keyword  = $frmSearch->getField('keyword');
$keyword->addFieldtagAttribute('class', 'form-control');
$keyword->setFieldtagAttribute('placeholder', Labels::getLabel('LBL_SEARCH_COUNTRIES', $adminLangId));

$submit  = $frmSearch->getField('btn_submit');
$submit->addFieldtagAttribute('class', 'btn btn-brand btn-block');

$btn_clear = $frmSearch->getField('btn_clear');
$btn_clear->addFieldtagAttribute('class', 'btn btn-link');
$btn_clear->addFieldtagAttribute('onclick', 'clearSearch();');
?>
<main class="main mainJs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php echo $frmSearch->getFormTag(); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <?php echo $frmSearch->getFieldHTML('keyword'); ?>
                            </div>
                            <div class="col-md-2">
                                <?php echo $frmSearch->getFieldHTML('btn_submit'); ?>
                            </div>
                            <div class="col-md-2">
                                <?php echo $frmSearch->getFieldHTML('btn_clear'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                echo $frmSearch->getFieldHTML('sortBy');
                echo $frmSearch->getFieldHTML('sortOrder');
                echo $frmSearch->getFieldHTML('reportColumns');
                echo $frmSearch->getFieldHTML('pageSize');
                echo $frmSearch->getExternalJS(); ?>
                </form>
                <div class="card">
                    <?php $data = [
                        'canEdit' => $canEdit,
                        'adminLangId' => $adminLangId,
                        'cardHeadTitle' => Labels::getLabel('LBL_COUNTRIES', $adminLangId),
                        'recordsTitle' => CommonHelper::replaceStringData(Labels::getLabel('LBL_OVER_{COUNT}_COUNTRIES', $adminLangId), ['{COUNT}' => $recordCount]),
                        'newRecordBtn' => true,
                        'statusButtons' => true
                    ];
                   
                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php $tbl = new HtmlElement(
                                'table',
                                array('width' => '100%', 'class' => 'table table-dashed')
                            );
                            $th = $tbl->appendElement('thead')->appendElement('tr');
                            foreach ($fields as $key => $val) {                                
                                $headColumData = HtmlHelper::getListingHeaderColumnHtml($key, $sortBy, $sortOrder);                                
                                $cls = '';
                                $html = '';
                                if (in_array($key, $allowedKeysForSorting)) {
                                    $cls .= 'headerColumnJs sorting ' . $headColumData['class'];
                                    $html = $headColumData['html'];
                                }

                                if ('action' == strtolower($key)) {
                                    $cls .= 'align-right';
                                }

                                switch ($key) {
                                    case 'select_all':
                                        $thWidth = '5%';
                                        break;
                                    case 'action':
                                        $thWidth = '10%';
                                    case 'listSerial':
                                    case 'country_code':
                                    case 'country_code_alpha3':
                                    case 'country_active':
                                        $thWidth = '14%';
                                        break;
                                    case 'country_name':
                                        $thWidth = '29%';
                                        break;
                                    default:
                                        $thWidth = '';
                                        break;
                                }
                                $td = $th->appendElement('th', ['class' => $cls, 'data-field' => $key, 'width' => $thWidth]);
                                $span = $td->appendElement('span');

                                switch ($key) {
                                    case 'select_all':
                                        $span->appendElement('plaintext', [], '<label class="checkbox"><input title="' . $val . '" type="checkbox" onclick="selectAll( $(this) )" class="selectAllJs"><i class="input-helper"></i></label>', true);
                                        break;
                                    default:
                                        $span->appendElement('plaintext', [], $val . $html, true);
                                        break;
                                }
                            }
                            $tbody = $tbl->appendElement('tbody', ['class' => 'listingRecordJs']);
                            require_once(CONF_THEME_PATH . 'countries/search.php');

                            if (count($arrListing) == 0) {
                                $tbl->appendElement('tr')->appendElement(
                                    'td',
                                    array(
                                        'colspan' => count($fields)
                                    ),
                                    Labels::getLabel('LBL_No_Records_Found', $adminLangId)
                                );
                            }

                            $frm = new Form('frmCountryListing', array('id' => 'frmCountryListing'));
                            $frm->setFormTagAttribute('class', 'actionButtons-js');
                            $frm->setFormTagAttribute('onsubmit', 'formAction(this, reloadList ); return(false);');
                            $frm->setFormTagAttribute('action', UrlHelper::generateUrl('Countries', 'toggleBulkStatuses'));
                            $frm->addHiddenField('', 'status');

                            echo $frm->getFormTag();
                            echo $frm->getFieldHtml('status');
                            echo $tbl->getHtml(); ?>
                            </form>
                        </div>
                    </div>
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-foot.php'); ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    var controllerName = '<?php echo str_replace('Controller', '', FatApp::getController()); ?>';
    getHelpCenterContent(controllerName);
</script>