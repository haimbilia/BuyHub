<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$includeWrapper = $includeWrapper ?? true;

if ($includeWrapper) { ?>
    <ul id="childrens-<?php echo $navId; ?>" class="append-ul childrensJs">
<?php } ?>

    <?php foreach ($arrListing as $sn => $row) {  ?>
        <li id="children-<?php echo $row['nlink_nav_id'] . '-' . $row['nlink_id']; ?>" data-nlinkId="<?php echo $row['nlink_id']; ?>" data-parent="<?php echo $row['nlink_nav_id']; ?>" class="sortableListsClosed">
            <div>
                <div class="sorting-bar ">
                    <div class="sorting-title">
                        <span class="clickable">
                            <?php echo $row['nlink_caption']; ?>
                        </span>
                    </div>
                    <div class="clickable">
                        <div class="sorting-actions">
                            <?php if ($canEdit) { ?>
                                <button onclick="addNewLinkForm(<?php echo $row['nlink_nav_id']; ?>, <?php echo $row['nlink_id']; ?>)" title="<?php echo  Labels::getLabel('LBL_EDIT', $siteLangId); ?>" class="btn btn-clean btn-sm clickable">
                                    <svg class="svg clickable" width="18" height="18" data-toggle="tooltip" data-placement="top">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                        </use>
                                    </svg>
                                </button>
                                <button onclick="deleteLink(<?php echo $row['nlink_nav_id']; ?>, <?php echo $row['nlink_id']; ?>)" title="<?php echo  Labels::getLabel('LBL_DELETE_RECORD', $siteLangId); ?>" class="btn btn-clean btn-sm clickable">
                                    <svg class="svg clickable" width="18" height="18" data-toggle="tooltip" data-placement="top">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                        </use>
                                    </svg>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    <?php } ?>

<?php if ($includeWrapper) { ?>
    </ul>
<?php } ?>