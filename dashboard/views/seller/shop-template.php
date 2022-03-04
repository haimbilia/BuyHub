<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $variables = array('language' => $language, 'siteLangId' => $siteLangId, 'shop_id' => $shop_id, 'action' => $action);

$this->includeTemplate('seller/_partial/shop-navigation.php', $variables, false);

?>

<div class="nav nav-pills nav-sm">
    <ul>
        <li class="is-active">
            <a href="javascript:void(0)"><?php echo Labels::getLabel('TXT_Template', $siteLangId); ?></a>
        </li>
    </ul>
</div>

<div class="tabs__content">
    <div class="row" id="shopFormBlock">
        <?php foreach ($shopTemplateLayouts as $k => $layout) { ?>
            <div class="col-lg-3">
                <div class="shop-template <?php echo ($shopLayoutTemplateId == $layout['ltemplate_id']) ? 'is--active' : ''; ?> "> <a href="javascript:void(0)" onclick="setTemplate(<?php echo $layout['ltemplate_id']; ?>)">
                        <figure class="thumb--square"><img src="<?php echo UrlHelper::generateFileUrl('Image', 'shopLayout', array($layout['ltemplate_id'], ImageDimension::VIEW_SMALL), CONF_WEBROOT_FRONTEND); ?>" alt="<?php echo Labels::getLabel('TXT_Shop_Layout', $siteLangId); ?>"></figure>
                        <p><?php echo Labels::getLabel('LBL_Layout', $siteLangId); ?> <strong><?php echo $layout['ltemplate_id']; ?></strong> </p>
                    </a> </div>
            </div>
        <?php } ?>
    </div>
</div>