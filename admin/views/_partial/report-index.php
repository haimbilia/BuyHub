<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$htmlContent = '';
if (!empty($fields)) {
    $htmlContent = '<div class="dropdown custom-drag-drop">
    <button class="btn btn-secondary btn-sm dropdown-toggle no-after" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside"  aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-columns"></i>
    </button>
    <div class="dropdown-menu  dropdown-menu-right dropdown-menu-fit dropdown-menu-anim scroll scroll-y" aria-labelledby="dropdownMenuButton">
        <div class="">
            <ul class="list-drag-drop" id="sortable">';
    foreach ($fields as $key => $label) {
        $disabled = '';
        $checked = '';
        if (in_array($key, $defaultColumns)) {
            $disabled = 'disabled';
            $checked = 'checked="checked"';
        }
        $htmlContent .= '<li class="">
    <label class="checkbox ' . $disabled . '">
        <input class="filterColumn-js" type="checkbox" name="reportColumns" value="' . $key . '" ' . $checked . $disabled . ' onclick=reloadList(false)><i class="input-helper"></i>
        ' . $label . '
    </label>
    <i class="icn fas fa-grip-lines"></i>
</li>';
    }

    $htmlContent .= '</ul>
        </div>
    </div>
</div>';
}
?>
<div class='page'>
    <div class='container container-fluid'>
        <div class="row">
            <div class="col-lg-12 col-md-12 space">
                <div class="page__title">
                    <div class="row">
                        <div class="col--first col-lg-6">
                            <span class="page__icon"><i class="ion-android-star"></i></span>
                            <h5><?php echo $pageTitle; ?>
                            </h5>
                            <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                        </div>
                    </div>
                </div>
                <section class="section searchform_filter">
                    <div class="sectionhead">
                        <h4> <?php echo Labels::getLabel('LBL_Search...', $siteLangId); ?>
                        </h4>
                    </div>
                    <div class="sectionbody space togglewrap" style="display:none;">
                        <?php echo  $frmSearch->getFormHtml(); ?>
                    </div>
                </section>
                <section class="section">
                    <div class="sectionhead">
                        <h4><?php echo $pageTitle; ?>
                        </h4>
                        <?php
                        $otherButton = isset($actionButtons['otherButtons']) ? $actionButtons['otherButtons'] : [];
                        $actionButtons = [
                            'siteLangId' => $siteLangId,
                            'htmlContent' => $htmlContent,
                            'otherButtons' => [
                                [
                                    'attr' => [
                                        'href' => 'javascript:void(0)',
                                        'onclick' => 'exportRecords()',
                                        'title' => Labels::getLabel('LBL_Export', $siteLangId)
                                    ],
                                    'label' => '<i class="fas fa-file-export"></i>'
                                ]
                            ]
                        ] + $actionButtons;

                        $actionButtons['otherButtons'] = array_merge($actionButtons['otherButtons'],  $otherButton);
                        $this->includeTemplate('_partial/listing/action-buttons.php', $actionButtons, false); ?>
                    </div>
                    <div class="sectionbody">
                        <div class="tablewrap">
                            <div id="listing">
                                <?php echo Labels::getLabel('LBL_Processing...', $siteLangId); ?> </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>