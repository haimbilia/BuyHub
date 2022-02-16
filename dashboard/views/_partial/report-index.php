<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php');
$htm = '';
if (!empty($fields)) {
    $htm = '<div class="dropdown custom-drag-drop">
                        <button class="btn btn-outline-gray btn-icon dropdown-toggle no-after" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="svg" width="18" height="18">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#columns">
                        </use>
                    </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-anim scroll scroll-y" aria-labelledby="dropdownMenuButton">
                                <ul class="list-drag-drop" id="sortable">';
    foreach ($fields as $key => $label) {
        $isDef = (in_array($key, $defaultColumns));
        $disabled = ($isDef) ? 'disabled' : '';
        $checked = ($isDef) ? 'checked="checked"' : '';

        $htm .= '<li>
                                        <label class="checkbox ' . $disabled . '">
                                            <input class="filterColumn-js" type="checkbox" name="reportColumns" value="' . $key . '" ' . $checked . $disabled . ' onclick=reloadList(false)>
                                            ' . $label . '
                                        </label>
                                        <i class="icn fas fa-grip-lines"></i>
                                    </li>';
    }
    $htm .= '</ul>
                        </div>
                    </div>';
}
?>

<div class="content-wrapper content-space">
    <?php
    $extraBtns = isset($actionButtons['otherButtons']) ? $actionButtons['otherButtons'] : [];

    $data = [
        'headingLabel' => $pageTitle,
        'siteLangId' => $siteLangId,
        'otherButtons' => [
            [
                'html' => $htm
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

    $data['otherButtons'] = array_merge($extraBtns, $data['otherButtons']);

    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body p-0">
                        <div class="listing-tbl" id="listingDiv"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var controllerName = '<?php echo str_replace('Controller', '', FatApp::getController()); ?>';
</script>