<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$url = UrlHelper::generateFullUrl('GuestUser', 'redirectAbandonedCartUser', array($userId, 0, true), CONF_WEBROOT_FRONTEND);
?>
<tr>
    <td>
        <div class="btn-wrapper" style="text-align: center">
            <a href="<?php echo $url; ?>" style="
                border-radius: 4px;
                background-color: #f13925;
                color: #fff;
                font-size: 14px;
                letter-spacing: -0.28px;
                text-decoration: none;
                padding: 9px 20px;
                display: inline-block;
                margin-bottom: 30px;
            "><?php echo Labels::getLabel('LBL_SHOP_NOW'); ?></a>
        </div>
    </td>
</tr>