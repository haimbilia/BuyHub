<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (!empty($rfqList)) {
    foreach ($rfqList as $rfq) { ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="rfq-item">
                <div class="card-body">
                    <?php
                        $userName = $rfq['user_name'] ?? 'User';
                        $userImageId = $rfq['user_profile_image_id'] ?? 0;
                        $userImgUrl = CommonHelper::generateUrl('Image', 'user', [$rfq['rfq_user_id'], 'SMALL']) . '?t=' . $userImageId;
                    ?>
                    <div class="user">
                        <img src="<?= $userImgUrl ?>" alt="<?= htmlspecialchars($userName) ?>">
                        <div class="user-name"><?= htmlspecialchars($userName) ?></div>
                    </div>

                    <h5 class="card-title"><?= htmlspecialchars($rfq['rfq_selprod_code'] ?: $rfq['rfq_title']); ?></h5>

                    <?php if (!empty($rfq['afile_id'])): ?>
                        <div class="products__media">
                            <img src="<?= $rfq['image_url'] ?>" alt="RFQ Image">
                        </div>
                    <?php endif; ?>

                    <p class="card-text"><?= nl2br(htmlspecialchars($rfq['rfq_description'])); ?></p>
                    <div class="products__meta">
                        <small class="text-muted">
                            <?= Labels::getLabel('LBL_Posted_on', $siteLangId); ?>:
                            <?= date('d/m/Y H:i', strtotime($rfq['rfq_added_on'])); ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    <?php  }
} else { ?>
    <div class="col-12">
        <p><?= Labels::getLabel('LBL_No_RFQs_Found', $siteLangId); ?></p>
    </div>
<?php }
