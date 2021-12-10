<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('badge_condition_type');
$fld->addFieldTagAttribute('onChange', 'conditionType(this)');
$fld->addFieldTagAttribute('id', 'badgeConditionTypeJs');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('badge_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('badge_required_approval');
$fld->addFieldTagAttribute('id', 'badgeRequiredApprovalJs');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('badge_active');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
];

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script>
    var condAuto =  <?php echo Badge::COND_AUTO; ?>;
    $(document).ready(function(){
        $("#badgeConditionTypeJs").trigger('change')
    });
</script>