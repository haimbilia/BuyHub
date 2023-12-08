<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?> <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Gift_Cards', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $data['newRecordBtn'] = true;
    $data['newRecordBtnAttrs'] = [
        'attr' => [
            'onclick' => 'addGiftCards()',
            'title' => Labels::getLabel('BTN_SHARE_GIFT_CARD', $siteLangId),
        ],
        'label' => '<svg class="svg btn-icon-start" width="18" height="18">
                            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#add">
                            </use>
                        </svg>' . Labels::getLabel('BTN_ADD_GIFT_CARD', $siteLangId)
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div id="listing"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
            </div>
        </div>
    </div>
</div>

<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>