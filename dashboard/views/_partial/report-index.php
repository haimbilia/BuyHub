<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php');
$htmlContent = '';
if (!empty($fields)) {
    $htmlContent = '   
    <button class="btn btn-brand btn-sm dropdown-toggle no-after" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        <input class="filterColumn-js" type="checkbox" name="reportColumns" value="' . $key . '" ' . $checked . $disabled . ' onClick=reloadList(false)>
        ' . $label . '
    </label>
    <i class="icn fas fa-grip-lines"></i>
</li>';
    }

    $htmlContent .= '</ul>
        </div>
    </div>';
}
?>
?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <div class="content-header row justify-content-between mb-3">
            <div class="col-md-auto">
                <h2 class="content-header-title"><?php echo $pageTitle; ?></h2>
            </div>
            <div class="col-auto">
                <div class="col-auto">

                    <?php
                    $otherButton = isset($actionButtons['otherButtons']) ? $actionButtons['otherButtons'] : [];
                    $actionButtons = [
                        'siteLangId' => $siteLangId,
                        'htmlContent' => $htmlContent,
                        'otherButtons' => [
                            [
                                'attr' => [
                                    'href' => 'javascript:void(0)',
                                    'onclick' => 'exportReport()',
                                    'class' => '',
                                    'title' => Labels::getLabel('LBL_Export', $siteLangId)
                                ],
                                'label' => Labels::getLabel('LBL_Export', $siteLangId)
                            ],
                        ]
                    ] + $actionButtons;
                    $actionButtons['otherButtons'] = array_merge($actionButtons['otherButtons'],  $otherButton);
                    $this->includeTemplate('_partial/action-buttons.php', $actionButtons, false); ?>

                </div>
            </div>
        </div>
        <div class="content-body">

            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="replaced">
                                <?php
                                echo $frmSearch->getFormHtml();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="listing-tbl" id="listingDiv"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    var controllerName = '<?php echo str_replace('Controller', '', FatApp::getController()); ?>';
</script>