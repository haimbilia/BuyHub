<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?><div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SUB_ACCOUNTS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <ul class="list-options">
            <?php foreach ($accounts as $account) { ?>
                <li class="list-options-item mt-2">
                    <?php $class = $account->getId() == $merchantId ? 'btn-outline-info' : 'btn-outline-gray'; ?>
                    <button class="btn <?php echo $class; ?> btn-block list-options-link list-options-link" type="button" role="button" onclick="selectSubAccount(<?php echo $account->getId();?>)">
                        <?php echo $account->getName() . ' - ' . $account->getId(); ?>
                    </button>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>