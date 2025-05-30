<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<table class="table table--view">
    <tr>
        <th><?php echo Labels::getLabel('LBL_Name',$siteLangId);?> </th>
        <td><?php echo $info['user_name'];?></td>
    </tr>
    <tr>
        <th><?php echo Labels::getLabel('LBL_Email',$siteLangId);?></th>
        <td><?php echo $info['credential_email'];?></td>
    </tr>
    <tr>
        <th><?php echo Labels::getLabel('LBL_Phone',$siteLangId);?></th>
        <td><span class="default-ltr"><?php echo CommonHelper::displayNotApplicable( $siteLangId, ValidateElement::formatDialCode($info['user_phone_dcode']) . $info['user_phone'] );?></span>
        </td>
    </tr>
    <?php 
	 /* <tr>
		 <th><?php echo Labels::getLabel('LBL_Location',$siteLangId);?></th>
    <td><?php echo $info['user_city'];?> </td>
    </tr> */
    ?>
    <tr>
        <th><?php echo Labels::getLabel('LBL_Member_Since',$siteLangId);?> </th>
        <td><?php echo FatDate::format($info['user_regdate']);?> </td>
    </tr>
</table>