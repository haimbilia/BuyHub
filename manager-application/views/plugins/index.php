<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder'); ?>

<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card sticky-sidebar">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title">
                                <a class="back" href="<?php echo UrlHelper::generateUrl('Settings'); ?>">
                                    <svg class="svg" width="24" height="24">
                                        <use
                                            xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#back">
                                        </use>
                                    </svg>
                                </a>
                                <?php echo Labels::getLabel('LBL_PLUGINS', $siteLangId); ?>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="settings-inner">
                            <ul class="pluginTypesJs">
                                <?php foreach ($pluginTypes as $formType => $tabName) {
                                    $tabsId = 'tabJs-' . $formType; ?>
                                <li class="settings-inner-item <?php echo $tabsId; ?> <?php echo ($activeTab == $formType) ? 'is-active' : '' ?>"
                                    data-listType="<?php echo $formType; ?>">
                                    <a class="settings-inner-link" href="javascript:void(0)"
                                        onClick="searchRecords(<?php echo $formType; ?>);">
                                        <i class="settings-inner-icn">
                                            <svg class="svg" width="20" height="20">
                                                <use
                                                    xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#<?php echo isset($svgIconNames[$formType]) ? $svgIconNames[$formType] : 'icon-extension'; ?>">
                                                </use>
                                            </svg>
                                        </i>
                                        <div>
                                            <h6 class="settings-inner-title"><?php echo $tabName; ?></h6>
                                            <span class="settings-inner-desc">Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Suscipit est quos </span>
                                        </div>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <?php echo $frmSearch->getFormHtml(); ?>
                <div id="pluginsListing" class="card">
                    <?php require_once(CONF_THEME_PATH . 'plugins/search.php'); ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
$(document).ready(function() {
    bindSortable();
});
$(document).ajaxComplete(function() {
    bindSortable();
});

function bindSortable() {
    if (1 > $('[data-field="dragdrop"]').length) {
        return;
    }

    $("#pluginsJs > tbody").sortable({
        update: function(event, ui) {
            fcom.displayProcessing();
            $('.listingTableJs').prepend(fcom.getLoader());

            var order = $(this).sortable('toArray');
            var data = '';
            const bindData = new Promise((resolve, reject) => {
                for (let i = 0; i < order.length; i++) {
                    data += 'plugin[]=' + order[i];
                    if (i + 1 < order.length) {
                        data += '&';
                    }
                }
                resolve(data);
            });
            bindData.then(
                function(value) {
                    fcom.ajax(fcom.makeUrl('plugins', 'updateOrder'), value, function(res) {
                        fcom.removeLoader();
                        $.ykmsg.close();
                        var ans = $.parseJSON(res);
                        if (ans.status == 1) {
                            $.ykmsg.success(ans.msg);
                            return;
                        }
                        $.ykmsg.error(ans.msg);
                    });
                },
                function(error) {
                    fcom.removeLoader();
                    $.ykmsg.close();
                }
            );
        },
    });
    $("#plugin > tbody").disableSelection();
}
</script>