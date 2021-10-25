<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (count($childCategories) > 0) { ?>

    <?php foreach ($childCategories as $sn => $row) {
        $row['child_count'] = count($row['children']);

    ?>
        <li id="<?php echo $row['bpcategory_id']; ?>" class="sortableListsClosed child-category <?php if ($row['child_count'] == 0) { ?>no-children<?php } ?>">
            <div>
                <div class="sorting-bar">
                    <div class="sorting-title">
                        <span class="clickable" onClick="displaySubCategories(this);"><?php echo $row['bpcategory_name']; ?></span>
                        <a href="<?php echo commonHelper::generateUrl('BlogPost', 'index', array($row['bpcategory_id'])); ?>" class="count badge badge-success clickable" title="<?php echo  Labels::getLabel('LBL_CATEGORY_BLOGS', $siteLangId); ?>">
                            <?php echo CommonHelper::displayBadgeCount($row['countChildBlogPosts']); ?>
                        </a>
                    </div>
                    <div class="sorting-actions">
                        <?php
                        $active = "";
                        $changeStatus = applicationConstants::ACTIVE;
                        if ($row['bpcategory_active']) {
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
                            <button onClick="editRecord(<?php echo $row['bpcategory_id']; ?>)" title="<?php echo  Labels::getLabel('LBL_EDIT', $siteLangId); ?>" class="btn btn-clean btn-sm btn-icon clickable">
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
                    <span class="sortableListsOpener"><i class="fa fa-plus clickable sort-icon cat<?php echo $row['bpcategory_id']; ?>-js" onClick="displaySubCategories(this)"></i></span>
                <?php } ?>
            </div>
        </li>
    <?php } ?>

<?php } ?>