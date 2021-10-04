<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$activeGentab = !empty($activeGentab) ? 'active' : '';
$activeLangtab = !empty($activeLangtab) ? 'active' : '';
$disabled = !empty($disabled) ? ' disabled' : '';
$formTitle = !empty($formTitle) ? $formTitle : Labels::getLabel('LBL_SETUP', $adminLangId);
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $formTitle; ?>
    </h5>
</div>
<div class="modal-body form-edit"> <!-- Closing tag must be added inside the files who include this file. -->
    <?php if (0 < count($languages)) { ?>
        <div class="form-edit-head">
            <nav class="nav nav-tabs">
                <a class="nav-link <?php echo $activeGentab; ?>" href="javascript:void(0)" onclick="editRecord(<?php echo $recordId ?>);" title="<?php echo Labels::getLabel('LBL_GENERAL', $adminLangId); ?>">
                    <?php echo Labels::getLabel('LBL_GENERAL', $adminLangId); ?>
                </a>
                <a class="nav-link <?php echo $activeLangtab . $disabled; ?>" href="javascript:void(0);" <?php echo (0 < $recordId) ? "onclick='editLangData(" . $recordId . "," . array_key_first($languages) . ");'" : ""; ?> title="<?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $adminLangId); ?>">
                    <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $adminLangId); ?>
                </a>
                <?php
                /* 
                *    EXAMPLE : $otherButtons = [
                *        [
                *           'attr' => [
                *                'href' => 'javascript:void(0)',
                *                'onclick' => '',
                *                'title' => 'TITLE'
                *            ],
                *            'label' => 'LABEL',
                *            'isActive' => true/false
                *        ]
                *    ] 
                */
                if (isset($otherButtons) && is_array($otherButtons)) {
                    foreach ($otherButtons as $link) {
                        $attr = isset($link['attr']) ? $link['attr'] : [];
                        $label = isset($link['label']) ? $link['label'] : '';
                        $isActive = isset($link['isActive']) ? $link['isActive'] : false;
                        $active = $isActive ? 'active' : '';

                        $href = !empty($attr) ? $attr['href'] : 'javascript:void(0);';
                        $onclick = !empty($attr) ? $attr['onclick'] : '';
                        $title = !empty($attr) ? $attr['title'] : '';
                        ?>
                        <a class="nav-link <?php echo $active . $disabled; ?>" href="<?php echo $href; ?>" <?php echo !empty($onclick) ? "onclick='" . $onclick . "'" : ""; ?> title="<?php echo $title; ?>">
                            <?php echo $label; ?>
                        </a>
                    <?php }
                }
                ?>
            </nav>
        </div>
    <?php } ?>