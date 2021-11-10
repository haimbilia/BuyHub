<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<main class="main mainJs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php $data = [ 
                        'canEdit' => $canEdit,
                        'siteLangId' => $siteLangId,
                        'cardHeadTitle' => Labels::getLabel('LBL_CATEGORIES', $siteLangId),
                        'newRecordBtn' => true
                    ];

                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body" id="listing"></div>
                </div>
            </div>
        </div>
    </div>
</main>