<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_EXTRA_INFO', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit layoutsJs">
    <div class="form-edit-body loaderContainerJs">
        <ul class="list-stats list-stats-double">
            <li class="list-stats-item list-stats-item-full">
                <span class="lable"><?php echo Labels::getLabel('LBL_REASON', $siteLangId); ?>:</span>
                <span class="value"><?php echo $row['ocreason_title']; ?></span>
            </li>
            <li class="list-stats-item list-stats-item-full">
                <span class="lable"><?php echo Labels::getLabel('LBL_COMMENT', $siteLangId); ?>:</span>
                <span class="value"><?php echo $row['ocrequest_message']; ?></span>
            </li>
            <li class="list-stats-item list-stats-item-full">
                <span class="lable"><?php echo Labels::getLabel('LBL_SELLER_INFO', $siteLangId); ?>:</span>                
                <?php 
                $onclick = $canViewShops && !empty($row['op_shop_id']) ? 'redirectToShop(' . $row['op_shop_id'] . ')' : '';   
                if (!empty($row['op_shop_name'])) {
                    $str = Labels::getLabel('LBL_SHOP:_{SHOP}', $siteLangId);
                    $row['extra_text'] = CommonHelper::replaceStringData($str, ['{SHOP}' => $row['op_shop_name']]);                    
                }             
                $this->includeTemplate('_partial/user/user-info-card.php', ['user' => $row, 'siteLangId' => $siteLangId,'href'=>'javascript:void(0)' , 'onclick'=> $onclick ,'extraClass' => 'user-profile-sm','displayProfileImage'=> false]); ?>
            </li>
        </ul>
    </div>
</div>