<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php');
$htmlContent = '';
if (!empty($fields)) {
    $htmlContent = '<div class="custom-drag-drop">
                        <button class="btn btn-brand btn-sm dropdown-toggle no-after" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-columns"></i>
                        </button>
                        <div class="dropdown-menu  dropdown-menu-right dropdown-menu-fit dropdown-menu-anim scroll scroll-y" aria-labelledby="dropdownMenuButton">
                            <div class="">
                                <ul class="list-drag-drop" id="sortable">';
                                    foreach ($fields as $key => $label) {
                                        
                                        $isDef = (in_array($key, $defaultColumns));
                                        $disabled = ($isDef) ? 'disabled' : '';
                                        $checked = ($isDef) ? 'checked="checked"' : '';

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
                        </div>
                    </div>';
}
?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <?php 
        $otherButton = isset($actionButtons['otherButtons']) ? $actionButtons['otherButtons'] : [];
        
        $data = [
            'headingLabel' => $pageTitle,
            'siteLangId' => $siteLangId,
            'otherButtons' => [
                [
                    'html' => $htmlContent
                ],
                [
                    'attr' => [
                        'onclick' => 'exportReport()',
                        'title' => Labels::getLabel('LBL_Export', $siteLangId)
                    ],
                    'label' => Labels::getLabel('LBL_Export', $siteLangId)
                ],
            ]
        ];

        $data['otherButtons'] = array_merge($otherButton, $data['otherButtons']);

        $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
        <div class="content-body">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card card-search">
                        <div class="card-body">
                            <div class="replaced">
                                <?php echo $frmSearch->getFormHtml(); ?>
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