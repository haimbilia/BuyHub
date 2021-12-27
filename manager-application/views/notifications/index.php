<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<main class="main mainJs">
    <div class="container">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false); ?>
        <div class="card card--notification">
            <div class="card-head">
                <div class="d-flex justify-content-between flex-grow-1">
                    <ul class="notification-action">
                        <li>
                            <label class="checkbox">
                                <input type="checkbox" title="<?php echo Labels::getlabel('FRM_SELECT_ALL', $siteLangId);?>" class="selectAllJs" onclick="selectAll(this)">
                                <i class="input-helper"></i>
                                <span></span>
                            </label>
                        </li>
                        <li>
                            <a class="btn" href="" title="Remove">
                                <svg class="icon" width="20" height="20">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-delete">
                                    </use>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="btn" href="" title="Refresh">
                                <svg class="icon" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-refresh">
                                    </use>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="btn" href="" title="Message read">
                                <svg class="icon" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-message">
                                    </use>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="btn" href="" title="Message unread">
                                <svg class="icon" width="18" height="18">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-message-unread">
                                    </use>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <?php 
                        $frmSearch->setFormTagAttribute('class', 'form form--notification-search');
                        echo $frmSearch->getFormTag();
                        $fld =  $frmSearch->getField('keyword');
                        $fld->addFieldTagAttribute('placeholder', Labels::getlabel('FRM_SEARCH_NOTIFICATION', $siteLangId));
                        echo $fld->getHtml();
                    ?>
                    </form>
                    <div class="notification-filter">
                        <label class="notification-filter__label">Sort By</label>
                        <div class="notification-filter__sortby">
                            <select class="form-control">
                                <option>All</option>
                                <option>Read</option>
                                <option>Unread</option>
                            </select>
                        </div>
                    </div>

                </div>

            </div>

            <div class="card-body">
                <div class="notifications listingTableJs">
                   
                    <?php require_once(CONF_THEME_PATH . 'notifications/search.php'); ?>   
                
                </div>
            </div>

            <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-foot.php'); ?>
          
        </div>
    </div>
</main>