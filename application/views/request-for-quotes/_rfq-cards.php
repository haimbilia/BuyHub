<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($rfqList)) {
    foreach ($rfqList as $rfq) {
        $userName = $rfq['user_name'] ?? 'User';
        $userImgUrl = CommonHelper::generateUrl('Image', 'user', [$rfq['rfq_user_id'], 'SMALL']) . '?t=' . ($rfq['user_profile_image_id'] ?? 0);
        ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="rfq-item">
                <div class="user">
                    <img src="<?= $userImgUrl ?>" alt="<?= htmlspecialchars($userName) ?>">
                    <div class="user-name"><?= htmlspecialchars($userName) ?></div>
                </div>

                <h5 class="card-title"><?= htmlspecialchars($rfq['rfq_selprod_code'] ?: $rfq['rfq_title']) ?></h5>

                <?php if (!empty($rfq['afile_id'])): ?>
                    <div class="products__media">
                        <img src="<?= $rfq['image_url'] ?>" alt="RFQ Image">
                    </div>
                <?php endif; ?>

                <div class="rfq-content">
                    <p><?= nl2br(htmlspecialchars($rfq['rfq_description'])) ?></p>
                </div>

                <div class="products__meta">
                    <small class="text-muted">
                        <?= Labels::getLabel('LBL_Posted_on', $siteLangId); ?>:
                        <?= date('d/m/Y H:i', strtotime($rfq['rfq_added_on'])); ?>
                    </small>
                </div>
            </div>
        </div>
    <?php
    }
}
