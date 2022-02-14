<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keyFld = $frmSearch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));

$submitBtnFld = $frmSearch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class', 'btn-block');

$cancelBtnFld = $frmSearch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class', 'btn-block');
?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_MY_MESSAGES', $siteLangId),
        'siteLangId' => $siteLangId
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="communication">
        <?php if (empty($arrListing)) { ?>
            <div class="col-md-12">
                <div class="card mb-0 h-100">
                    <div class="card-body">
                        <div class="not-found">
                            <img width="100" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg" alt="">
                            <h3><?php echo Labels::getLabel('MSG_SORRY,_NO_MATCHING_RESULT_FOUND'); ?></h3>
                            <p><?php echo Labels::getLabel('MSG_TRY_CHECKING_YOUR_SPELLING_OR_USER_MORE_GENERAL_TERMS'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="communication-nav">
                <div class="communication-search">
                    <?php
                    $frmSearch->setFormTagAttribute('class', 'form');
                    $frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');

                    $fld = $frmSearch->getField('keyword');
                    $fld->addFieldtagAttribute('class', 'form-control omni-search');

                    $fld = $frmSearch->getField('message_to');
                    $fld->addFieldtagAttribute('id', 'searchFrmSellerIdJs');

                    echo $frmSearch->getFormTag();
                    echo $frmSearch->getFieldHtml('page');
                    ?>
                    <div class="d-flex align-items-center">
                        <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle no-after" data-bs-toggle="dropdown">
                                <span class="icon">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-filters">
                                        </use>
                                    </svg>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-anim communication-filter">
                                <div class="form-group">
                                    <label class="label">
                                        <?php
                                        $fld = $frmSearch->getField('message_to');
                                        echo $fld->getCaption();;
                                        ?>
                                    </label>
                                    <?php echo $frmSearch->getFieldHtml('message_to'); ?>
                                </div>
                                <div class="form-group">
                                    <label class="label">
                                        <?php
                                        $fld = $frmSearch->getField('date_from');
                                        echo $fld->getCaption();;
                                        ?>
                                    </label>
                                    <?php echo $frmSearch->getFieldHtml('date_from'); ?>
                                </div>
                                <div class="form-group">
                                    <label class="label">
                                        <?php
                                        $fld = $frmSearch->getField('date_to');
                                        echo $fld->getCaption();;
                                        ?>
                                    </label>
                                    <?php echo $frmSearch->getFieldHtml('date_to'); ?>
                                </div>
                                <?php echo $frmSearch->getFieldHtml('btn_submit'); ?>
                                <?php echo $frmSearch->getFieldHtml('btn_clear'); ?>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>


                <?php
                $activeIndex = 0;
                require_once(CONF_THEME_PATH . '/account/message-search.php');

                $lastRecord = current(array_reverse($arrListing));
                $data = [
                    'siteLangId' => $siteLangId,
                    'postedData' => $postedData,
                    'page' => $page,
                    'pageCount' => $pageCount,
                ];
                $this->includeTemplate('_partial/load-more-pagination.php', $data);
                ?>


            </div>
        <?php
            $doNotshowMessages = false;
            $threadListing = [current($arrListing)];
            require_once(CONF_THEME_PATH . 'account/view-thread.php');
        } ?>
    </div>
    <!-- <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card card-search">
                        <div class="card-body">
                            <div id="withdrawalReqForm"></div>
                            <div class="replaced">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php
                                        /* $submitFld = $frmSearch->getField('btn_submit');
                                        $submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block ');

                                        $fldClear = $frmSearch->getField('btn_clear');
                                        $fldClear->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
                                        echo $frmSearch->getFormHtml(); */
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="messageListing"><?php /* echo Labels::getLabel('LBL_Loading..', $siteLangId); */ ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
</div>