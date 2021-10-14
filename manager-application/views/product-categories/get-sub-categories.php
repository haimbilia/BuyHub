<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (count($childCategories) > 0) {
?>

<?php foreach ($childCategories as $sn => $row) { ?>
<li id="<?php echo $row['prodcat_id']; ?>"
    class="sortableListsClosed child-category <?php if ($row['subcategory_count'] == 0) { ?>no-children<?php } ?>">
    <div>
        <div class="sorting-bar">
            <div class="sorting-title">
                <span class="clickable" onClick="displaySubCategories(this);"><?php echo $row['prodcat_name']; ?></span>
                <a href="<?php echo commonHelper::generateUrl('Products', 'index', array($row['prodcat_id'])); ?>"
                    class="count badge badge-success clickable"
                    title="<?php echo  Labels::getLabel('LBL_Category_Products', $siteLangId); ?>">
                    <?php echo CommonHelper::displayBadgeCount($row['category_products']); ?>
                </a>
            </div>
            <div class="sorting-actions">
                <?php
                        $active = "";
                        $changeStatus = applicationConstants::ACTIVE;
                        if ($row['prodcat_active']) {
                            $active = 'checked';
                            $changeStatus = applicationConstants::INACTIVE;
                        }
                        $statusAct = ($canEdit === true) ? 'toggleStatus(event,this,' . applicationConstants::YES . ',' . $changeStatus . ')' : 'toggleStatus(event,this,' . applicationConstants::NO . ',' . $changeStatus . ')';
                        $statusClass = ($canEdit === false) ? 'disabled' : '';
                        $hasParent = 0 < $row['prodcat_parent'] ? applicationConstants::YES : applicationConstants::NO;
                        ?>
                <label class="switch switch-sm switch-icon">
                    <input <?php echo $active; ?> type="checkbox" id="switch<?php echo $row['prodcat_id']; ?>"
                        value="<?php echo $row['prodcat_id']; ?>" onclick="<?php echo $statusAct; ?>"
                        data-childcount="<?php echo $row['subcategory_count']; ?>"
                        data-hasparent="<?php echo $hasParent; ?>" />
                    <span></span>
                </label>
                <?php if ($canEdit) { ?>
                <button onClick="goToProduct(<?php echo $row['prodcat_id']; ?>)"
                    title="<?php echo  Labels::getLabel('LBL_Add_Product', $siteLangId); ?>"
                    class="btn btn-clean btn-sm btn-icon clickable">
                    <svg class="svg clickable" width="18" height="18">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#add">
                        </use>
                    </svg></button>
                <button onClick="categoryForm(<?php echo $row['prodcat_id']; ?>)"
                    title="<?php echo  Labels::getLabel('LBL_Edit', $siteLangId); ?>"
                    class="btn btn-clean btn-sm btn-icon clickable">
                    <svg class="svg clickable" width="18" height="18">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#edit">
                        </use>
                    </svg>
                </button>
                <button title="<?php echo  Labels::getLabel('LBL_Delete', $siteLangId); ?>"
                    onclick="deleteRecord(<?php echo $row['prodcat_id']; ?>)"
                    class="btn btn-clean btn-sm btn-icon clickable">
                    <svg class="svg clickable" width="18" height="18">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite-actions.svg#delete">
                        </use>
                    </svg>
                </button>
                <?php } ?>
            </div>
        </div>
        <?php if ($row['subcategory_count'] > 0) { ?>
        <span class="sortableListsOpener"><i
                class="fa fa-plus clickable sort-icon cat<?php echo $row['prodcat_id']; ?>-js"
                onClick="displaySubCategories(this)"></i></span>
        <?php } ?>
    </div>
</li>
<?php } ?>

<?php } ?>