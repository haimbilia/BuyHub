<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$actionItemsData =  [
    'canEdit' => ($canEdit ?? false),
    'keywordPlaceholder' => ($keywordPlaceholder ?? Labels::getLabel('FRM_SEARCH', $siteLangId))
];

?>
<main class="main mainJs">
    <div class="container">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-head">
                        <div class="d-flex justify-content-between flex-grow-1">
                            <ul class="notification-action">
                                <?php if ($canEdit) { ?>
                                    <li>
                                        <label class="checkbox">
                                            <input type="checkbox" title="<?php echo Labels::getlabel('FRM_SELECT_ALL', $siteLangId); ?>" class="selectAllJs" onclick="selectAll(this)">
                                            <i class="input-helper"></i>
                                            <span></span>
                                        </label>
                                    </li>
                                    <li>
                                        <a class="btn" href="javascript:void(0)" onclick="deleteSelected()" title="<?php echo Labels::getlabel('FRM_REMOVE', $siteLangId); ?>">
                                            <svg class="icon" width="20" height="20">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-delete">
                                                </use>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="btn" href="javascript:void(0)" onclick="reloadList()" title="<?php echo Labels::getlabel('FRM_REFRESH', $siteLangId); ?>">
                                            <svg class="icon" width="18" height="18">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-refresh">
                                                </use>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="btn" href="javascript:void(0)"  onclick="toggleBulkStatues(1,'');" title="<?php echo Labels::getlabel('FRM_MARK_READ', $siteLangId); ?>">
                                            <svg class="icon" width="18" height="18">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-message">
                                                </use>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="btn" href="javascript:void(0)" onclick="toggleBulkStatues(0,'');" title="<?php echo Labels::getlabel('FRM_MARK_UNREAD', $siteLangId); ?>">
                                            <svg class="icon" width="18" height="18">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-message-unread">
                                                </use>
                                            </svg>
                                        </a>
                                    </li>
                                <?php } ?>
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
                        <div class="table-responsive table-scrollable js-scrollable listingTableJs" data-auto-column-width="0">
                            <?php
                            $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table table-dashed', 'id' => 'orderStatuses'));

                            $tbody = $tbl->appendElement('tbody', ['class' => 'listingRecordJs']);
                            require_once(CONF_THEME_PATH . 'notifications/search.php');
                            $this->includeTemplate('_partial/listing/print-listing-table.php', ['performBulkAction' => true, 'tbl' => $tbl], false); ?>
                        </div>
                    </div>
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-foot.php'); ?>
                </div>
            </div>
        </div>
    </div>
</main>