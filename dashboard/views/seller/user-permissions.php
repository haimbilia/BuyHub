<?php $this->includeTemplate('_partial/dashboardNavigation.php');
$allAccessfrm->setFormTagAttribute('class', 'form');
$allAccessfrm->developerTags['fld_default_col'] = 8;
$submitFld = $allAccessfrm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', "btn btn-brand");
$submitFld->developerTags['col'] = 4;
?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => sprintf(Labels::getLabel('LBL_Manage_Permissions_for_%S', $siteLangId), $userData['user_name']),
        'siteLangId' => $siteLangId,
        'headingBackButton' => true,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
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