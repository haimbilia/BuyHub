<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('data-onclear', 'recordForm(' . $recordId . ',' . $collection_type . ')');

$fld = $frm->getField('collection_records[]');
$fld->setFieldTagAttribute('id', 'collectionItemJs');
$fld->addFieldTagAttribute('multiple', 'multiple');
$fld->addFieldTagAttribute('data-allow-clear', 'false');

$actionName = 'autocomplete';
$hideSelectField = 'hide-addrecord-field--js';
switch ($collection_type) {
    case Collections::COLLECTION_TYPE_PRODUCT:
        $controllerName = 'SellerProducts';
        $hideSelectField = '';
        break;
    case Collections::COLLECTION_TYPE_CATEGORY:
        $controllerName = 'ProductCategories';
        $hideSelectField = '';
        break;
    case Collections::COLLECTION_TYPE_SHOP:
        $controllerName = 'Shops';
        $hideSelectField = '';
        break;
    case Collections::COLLECTION_TYPE_BRAND:
        $controllerName = 'Brands';
        $hideSelectField = '';
        break;
    case Collections::COLLECTION_TYPE_BLOG:
        $controllerName = 'BlogPosts';
        $hideSelectField = '';
        break;
    case Collections::COLLECTION_TYPE_FAQ:
        $controllerName = 'Faq';
        $hideSelectField = '';
        break;
    case Collections::COLLECTION_TYPE_FAQ_CATEGORY:
        $controllerName = 'FaqCategories';
        $hideSelectField = '';
        break;
    case Collections::COLLECTION_TYPE_TESTIMONIAL:
        $controllerName = 'Testimonials';
        $hideSelectField = '';
        break;
    default:
        $controllerName = '';
        $actionName = '';
        break;
}

$generalTab['attr']['onclick'] = 'collectionForm(' . $collection_type . ', ' . $collection_layout_type . ', ' . $recordId . ');';
$activeGentab = false;

if (!in_array($collection_type, Collections::COLLECTION_WITHOUT_RECORDS)) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'recordForm(' . $recordId . ',' . $collection_type . ')',
            'title' => Labels::getLabel('LBL_LINK_RECORDS', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_LINK_RECORDS', $siteLangId),
        'isActive' => true
    ];
}

if (!in_array($collection_type, Collections::COLLECTION_WITHOUT_MEDIA)) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'collectionMediaForm(' . $recordId . ',' . $collection_type . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ];
}

$includeTabs = ($collection_layout_type != Collections::TYPE_PENDING_REVIEWS1);

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script type="text/javascript">
    var ctrlName = '<?php echo $controllerName; ?>';
    var actionName = '<?php echo $actionName; ?>';
    var recordId = '<?php echo $recordId; ?>';
    $(function() {
        select2('collectionItemJs', fcom.makeUrl(ctrlName, actionName), function(obj) {
            return {
                excludeRecords: obj.val()
            }
        }, function(e) {
            var item = e.params.args.data; 
            updateRecord(recordId, item.id);   
        }, function(e) {
            var item = e.params.args.data; 
            removeCollectionRecord(recordId, item.id);   
        });
    });
</script>