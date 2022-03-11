<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$theDay = '';
$count = 1;
$lastDate = isset($postedData['reference']) ? date('Y-m-d', strtotime($postedData['reference'])) : '';
$shippedOrderStatus = FatApp::getConfig("CONF_DEFAULT_SHIPPING_ORDER_STATUS");

foreach ($arrListing as $sn => $row) {
    $headTitle = HtmlHelper::getTheDay($row['oshistory_date_added'], $siteLangId);
    $canAddHead = (empty($lastDate) || (!empty($lastDate) && $lastDate != date('Y-m-d', strtotime($row['oshistory_date_added']))));
    if ($theDay != $headTitle && $canAddHead) {
        $theDay = $headTitle;
        if ($count != 1) {
            echo '</ul></div>';
        } ?>
        <div class="rowJs" data-reference="<?php echo $row['oshistory_date_added']; ?>">
            <div class="timeline-v4__item-date">
                <span class="tag">
                    <?php echo $headTitle; ?>
                </span>
            </div>
            <ul class="timeline-v4__items">
            <?php } ?>

            <li class="timeline-v4__item">
                <span class="timeline-v4__item-time"><?php echo date('H:i', strtotime($row['oshistory_date_added'])); ?></span>
                <div class="timeline-v4__item-desc">
                    <span class="timeline-v4__item-text">
                        <span class="tag"><?php echo $row['orderstatus_name']; ?></span>
                    </span>            
                    <?php 
                  
                    if ($row['oshistory_orderstatus_id'] ==  $shippedOrderStatus) {
                        if (empty($row['oshistory_courier'])) {                           
                            $str = !empty($row['oshistory_tracking_number']) ? '<b>' . Labels::getLabel('LBL_TRACKING_NUMBER', $siteLangId).':</b>': '';                                              
                            if (!empty($shippingApiObj) && $shippingApiObj->getKey('plugin_id') == $row['opshipping_plugin_id'] && true === $shippingApiObj->canFetchTrackingDetail()) {
                                $trackingNumbers = explode(",",$row['oshistory_tracking_number']); 
                                foreach($trackingNumbers as $trackingNumber){
                                    $trackingNumber = trim($trackingNumber);
                                    $trackingNumber = number_format($trackingNumber,0,null,'');  
                                    $str .=  '<span class="timeline-v4__item-text"><a href="javascript:void(0)" onclick="fetchTrackingDetail(' . "'". $trackingNumber ."'" . ',' . "'" . $row['op_id'] . "'" . ')" title="' . Labels::getLabel("LBL_TRACK", $siteLangId) . '">' . $trackingNumber . '</a></span>';
                                }                                
                            }else{
                                $str .= $row['oshistory_tracking_number'];
                            }                                               
                            if (empty($trackingUrl) && !empty($trackingNumber)) {                               
                                $str .=  '<span class="timeline-v4__item-text">VIA ' . CommonHelper::displayNotApplicable($siteLangId, $row["opshipping_label"]) . '</span>';
                            } elseif (!empty($trackingUrl) && !empty($trackingNumber)) {                             
                                $trackingUrls = (array) explode(', ', $trackingUrl);                              
                                foreach ($trackingUrls as $url) { 
                                    $str .=  '<span class="timeline-v4__item-text"><a class="" href="' . $url . '" target="_blank">' . $trackingNumber . '</a>';
                                }                                
                            }
                            echo $str;
                        } else {                           
                            $trackingNumber = $row['oshistory_tracking_number'];
                            $carrier = $row['oshistory_courier'];
                    ?>
                        <span class="timeline-v4__item-text">
                            <b><?php echo Labels::getLabel('LBL_TRACKING_NUMBER', $siteLangId); ?>:</b>
                            <a href="javascript:void(0)" title="<?php echo Labels::getLabel('LBL_TRACK', $siteLangId); ?>" class="link link--dark timeline-v4__item-link" onclick="trackOrder('<?php echo trim($trackingNumber); ?>', '<?php echo trim($carrier); ?>','<?php echo $row['op_invoice_number']; ?>','<?php echo $row['op_order_id']; ?>','<?php echo $row['op_id']; ?>')">
                                <?php echo $trackingNumber; ?>
                            </a>
                            <?php if(!empty($row["opshipping_label"])) { ?>
                            <span>
                                <?php echo Labels::getLabel('LBL_VIA', $siteLangId); ?>
                                <em><?php echo CommonHelper::displayNotApplicable($siteLangId, $row["opshipping_label"]); ?></em>
                            </span>    
                            <?php } ?>                        
                        </span>
                    <?php }

                    } ?>                 
                    <?php if (!empty($row['oshistory_courier'])) { ?>
                        <span class="timeline-v4__item-text">
                            <b><?php echo Labels::getLabel('LBL_COURIER', $siteLangId); ?>:</b> <?php echo  CommonHelper::displayText($row['oshistory_courier']); ?>
                        </span>
                    <?php } ?>
                    <?php if (!empty($row['oshistory_tracking_url'])) { ?>
                        <span class="timeline-v4__item-user-name">
                            <a href="<?php echo $row['oshistory_tracking_url']; ?>" target="_blank" class="link link--dark timeline-v4__item-link">
                                <?php echo Labels::getLabel('LBL_CLICK_HERE_TO_TRACK', $siteLangId); ?>
                            </a>
                        </span>
                    <?php } ?>
                    <?php if (!empty($row['oshistory_comments'])) { ?>
                        <span class="timeline-v4__item-text">
                            <b><?php echo Labels::getLabel('LBL_COMMENTS', $siteLangId); ?>:</b> <?php echo  CommonHelper::displayText($row['oshistory_comments']); ?>
                        </span>
                    <?php } ?>
                </div>
            </li>

        <?php if (count($arrListing) == $count && $canAddHead) {
            echo '</ul></div>';
        }
        $count++;
    }
