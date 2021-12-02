<?php defined('SYSTEM_INIT') or die('Invalid Usage.');  ?>

<div class="accordion-categories">
    <?php
    if (count($arrListing) > 0) {
    ?>
        <ul id="sorting-categories" class="sorting-categories">
            <?php foreach ($arrListing as $sn => $row) {
                $row['child_count'] = count($row['children']);
            ?>
                <li id="<?php echo $row['bpcategory_id']; ?>" class="sortableListsClosed <?php if ($row['child_count'] == 0) { ?>no-children<?php } ?>">
                    <div>
                        <div class="sorting-bar">
                            <div class="sorting-title">
                                <span class="clickable">
                                    <?php echo !empty($row['bpcategory_name']) ? $row['bpcategory_name'] : $row['bpcategory_identifier']; ?>
                                </span>
                                <a onclick="goToBlog(<?php echo $row['bpcategory_id']; ?>)" href="javascript:void(0)" class="count badge badge-success clickable" title="<?php echo  Labels::getLabel('LBL_CATEGORY_BLOGS', $siteLangId); ?>">
                                    <?php echo CommonHelper::displayBadgeCount($row['countChildBlogPosts']); ?>
                                </a>
                            </div>
                            <div class="sorting-actions">
                                <?php
                                $active = "";
                                $changeStatus = applicationConstants::ACTIVE;
                                if (applicationConstants::ACTIVE == $row['bpcategory_active']) {
                                    $active = 'checked';
                                    $changeStatus = applicationConstants::INACTIVE;
                                }

                                $statusAct = ($canEdit === true) ? 'updateStatus(event,this,' . $row['bpcategory_id'] . ', ' . $changeStatus . ')' : 'return false;';
                                $statusClass = ($canEdit === false) ? 'disabled' : '';
                                $hasParent = 0 < $row['bpcategory_parent'] ? applicationConstants::YES : applicationConstants::NO;

                                ?>
                                <label class="switch switch-sm switch-icon">
                                    <input <?php echo $active; ?> type="checkbox" id="switch<?php echo $row['bpcategory_id']; ?>" value="<?php echo $row['bpcategory_id']; ?>" onclick="<?php echo $statusAct; ?>" <?php echo $statusClass; ?> data-childcount="<?php echo $row['child_count']; ?>" data-hasparent="<?php echo $hasParent; ?>" />
                                    <span></span>
                                </label>
                                <?php if ($canEdit) { ?>                                   
                                    <button onclick="editRecord(<?php echo $row['bpcategory_id']; ?>)" title="<?php echo  Labels::getLabel('LBL_Edit', $siteLangId); ?>" class="btn btn-clean btn-sm btn-icon clickable">
                                        <svg class="svg clickable" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                            </use>
                                        </svg>
                                    </button>
                                    <button title="<?php echo  Labels::getLabel('LBL_DELETE', $siteLangId); ?>" onclick="deleteRecord(<?php echo $row['bpcategory_id']; ?>)" class="btn btn-clean btn-sm btn-icon clickable">
                                        <svg class="svg clickable" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                            </use>
                                        </svg>
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($row['child_count'] > 0) { ?>
                            <span class="sortableListsOpener"><i class="fa fa-plus clickable sort-icon cat<?php echo $row['bpcategory_id']; ?>-js" onclick="displaySubCategories(this)"></i></span>
                        <?php } ?>
                    </div>
                </li>
            <?php } ?>
        </ul>
    <?php } else {
        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId));
    }
    ?>
</div>


<script type="text/javascript">
    $(function() {
        var optionsPlus = {
            insertZone: 0,
            insertZonePlus: true,
            placeholderCss: {
                'background-color': '#e5f5ff',
            },
            hintCss: {
                'background-color': '#6dc5ff'
            },
            baseCss: {
                'list-style-type': 'none',
            },
            listsClass: "sorting-categories",
            onDragStart: function(e, cEl) {
                var catId = $(cEl).attr('id');
                $("#" + catId).children().children().children('.sorting-title').css('margin-left', '25px');
                $("#" + catId).children('ul').css('list-style-type', 'none');
            },
            complete: function(cEl) {
                var catId = $(cEl).attr('id');
                $("#" + catId).children().children().children('.sorting-title').css('margin-left', '0px');
            },
            onChange: function(cEl) {

                $("#js-cat-section").addClass('overlay-blur');
                var catId = $(cEl).attr('id');
                var parentCatId = $(cEl).parent('ul').parent('li').attr('id');
                var catOrder = [];
                $($(cEl).parent().children()).each(function(i) {
                    catOrder[i + 1] = $(this).attr('id');
                });
                var data = "catId=" + catId + "&parentCatId=" + parentCatId + "&catOrder=" + JSON.stringify(catOrder);

                if (typeof parentCatId != 'undefined') {
                    displaySubCategories(cEl, parentCatId, data);
                    $(cEl).parents('li').each(function() {
                        var rootCat = $(this).attr('id');
                        $("#" + rootCat).children('div').children('.sortableListsOpener').remove();
                        $("#" + rootCat).removeClass('sortableListsClosed').addClass(
                            'sortableListsOpen');
                        $("#" + rootCat).children('div').append(
                            '<span class="sortableListsOpener" ><i class="fa fa-minus clickable sort-icon" onclick="hideItems(this)"></i></span>'
                        );
                    });
                    $("#" + catId).parent('ul').addClass('append-ul');
                } else {
                    updateCatOrder(data);
                }
            },
            opener: {
                active: true,
                as: 'html', // if as is not set plugin uses background image
                close: '<i class="fa fa-minus clickable sort-icon" onclick="hideItems(this)"></i>',
                open: '<i class="fa fa-plus c3 clickable sort-icon" onclick="displaySubCategories(this)"></i>',
                openerCss: {}
            },
            ignoreClass: 'clickable'
        };

        $('#sorting-categories').sortableLists(optionsPlus);

    });
</script>