<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Catelog_Request_Messages', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="col-md-12">
            <?php echo $searchFrm->getFormHtml(); ?>
            <div id="loadMoreBtnDiv"></div>
            <ul class="media media--details" id="messagesList"></ul>

            <?php
            $frm->setFormTagAttribute('onSubmit', 'setUpCatalogRequestMessage(this); return false;');
            $frm->setFormTagAttribute('class', 'form');
            $frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
            $frm->developerTags['fld_default_col'] = 12;
            ?>
            <ul class="media media--details" id="frmArea">
                <li>
                    <div class="grid grid--first">
                        <div class="avtar"><img src="<?php echo UrlHelper::generateFileUrl('Image', 'user', array($logged_user_id, ImageDimension::VIEW_THUMB, 1), CONF_WEBROOT_FRONTEND); ?>" alt="<?php echo $logged_user_name; ?>" title="<?php echo $logged_user_name; ?>"></div>
                    </div>
                    <div class="grid grid--second">
                        <span class="media__title"><?php echo $logged_user_name; ?></span>
                        <div class="grid grid--third">

                            <?php echo $frm->getFormHtml(); ?>

                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>