<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg-gray">
    <section class="top-space">
        <div class="container">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="<?php echo UrlHelper::generateUrl('', '', [], CONF_WEBROOT_FRONTEND, null, false, false, true, $siteLangId); ?>"><?php echo Labels::getLabel('LBL_Home', $siteLangId); ?> </a></li>
                    <li><?php echo Labels::getLabel('LBL_Shopping_Cart', $siteLangId); ?> </li>
                </ul>
            </div>
            <div class="white--bg" id="subsriptionCartList">
            </div>
        </div>
    </section>
</div>