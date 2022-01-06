<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<main class="main">
    <div class="container">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false); ?>
        <div class="row">
            <div class="col-md-3">
                <div class="card mb-0 h-100">
                    <div class="card-head flex-column">
                        <div class="message__search">
                            <?php
                            $frmSearch->setFormTagAttribute('class', 'form');
                            $frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');

                            $fld = $frmSearch->getField('message_by');
                            $fld->addFieldtagAttribute('id', 'searchFrmBuyerIdJs');

                            $fld = $frmSearch->getField('message_to');
                            $fld->addFieldtagAttribute('id', 'searchFrmSellerIdJs');

                            echo $frmSearch->getFormTag();
                            echo $frmSearch->getFieldHtml('page');
                            ?>
                            <div class="d-flex align-items-center">
                                <?php echo $frmSearch->getFieldHtml('keyword'); ?>
                                <div class="dropdown">
                                    <a class="dropdown-toggle no-after p-2" data-bs-toggle="dropdown" href="">
                                        <span class="icon">
                                            <svg class="svg" width="20" height="20">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-filters">
                                                </use>
                                            </svg>
                                        </span>
                                    </a>
                                    <div class="header-action__target p-3 dropdown-menu dropdown-menu-right dropdown-menu-anim">
                                        <div class="form-group">
                                            <label class="label">
                                                <?php
                                                $fld = $frmSearch->getField('message_by');
                                                echo $fld->getCaption();;
                                                ?>
                                            </label>
                                            <?php echo $frmSearch->getFieldHtml('message_by'); ?>
                                        </div>
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
                    </div>
                    <div class="card-body p-0 settings-inner">
                        <?php
                            $activeIndex = 0;
                            require_once(CONF_THEME_PATH . 'messages/search.php'); 
            
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
                </div>
            </div>
            <?php
            $threadListing = [current($arrListing)];
            require_once(CONF_THEME_PATH . 'messages/view-thread.php'); ?>
        </div>
    </div>
</main>