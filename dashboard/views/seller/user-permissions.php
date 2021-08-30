<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php');
$allAccessfrm->setFormTagAttribute('class', 'form');
$allAccessfrm->developerTags['colClassPrefix'] = 'col-md-';
$allAccessfrm->developerTags['fld_default_col'] = 4;
$submitFld = $allAccessfrm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', "btn btn-brand btn-wide");
?>
<main id="main-area" class="main"   >
    <div class="content-wrapper content-space">
        <?php 
        $data = [
            'headingLabel' => sprintf(Labels::getLabel('LBL_Manage_Permissions_for_%S', $siteLangId), $userData['user_name']),
            'siteLangId' => $siteLangId
        ];
        $this->includeTemplate('_partial/header/content-header.php', $data); ?>
        <div class="content-body">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <?php 
                                echo $frm->getFormHtml();
                                echo $allAccessfrm->getFormHtml(); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="listing">
                <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
            </div>
        </div>
    </div>
</main>
