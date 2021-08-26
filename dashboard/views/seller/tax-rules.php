<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main"   >
    <div class="content-wrapper content-space">
        <?php 
        $data = [
            'headingLabel' => $taxCategory,
            'siteLangId' => $siteLangId,
            'otherButtons' => [
                [
                    'attr' => [
                        'href' => UrlHelper::generateUrl('seller', 'taxCategories'),
                        'title' => Labels::getLabel('LBL_Back_To_Tax_Categories', $siteLangId)
                    ],
                    'label' => Labels::getLabel('LBL_Back_To_Tax_Categories', $siteLangId)
                ]
            ]
        ];
        $this->includeTemplate('_partial/header/content-header.php', $data); ?>
        <div class="content-body">
            <div class="card">
                <?php echo $frmSearch->getFormHtml(); ?>
                <div class="card-body" id="listing">                   
                </div>
            </div>
        </div>
    </div>
</main>
