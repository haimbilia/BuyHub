<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_CANCEL_ORDER', $siteLangId),
        'siteLangId' => $siteLangId,
        'headingBackButton' => [
            'href' => UrlHelper::generateUrl('Seller', 'sales'),
            'onclick' => '',
        ]
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="row">
            <?php
            $data = $this->variables + ['childOrderDetail' => $orderDetail, 'isSellerDashboardView' => true];
            $this->includeTemplate('_partial/order/left-side-block.php', $data, false);
            $data = $this->variables + [
                'canViewShippingCharges' => CommonHelper::canAvailShippingChargesBySeller($orderDetail['op_selprod_user_id'], $orderDetail['opshipping_by_seller_user_id']),
                'canViewTaxCharges' => $orderDetail['op_tax_collected_by_seller'],
                'childOrderDetail' => $orderDetail,
                'isSellerDashboardView' => true
            ];
            $this->includeTemplate('_partial/order/right-side-block.php', $data, false);
            ?>
        </div>
    </div>
</div>