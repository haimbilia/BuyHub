<?php if (isset($pageData['plang_warring_msg']) && !empty($pageData['plang_warring_msg'])) { ?>
    <div class="alert alert-solid-warning fade show" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text"><?php echo $pageData['plang_warring_msg']; ?></div>
        <div class="alert-close">
            <button type="button" class="close closeAlertJs" data-dismiss="alert" aria-label="Close" data-name="<?php echo 'alert_' . $pageData['plang_id']; ?>">
                <span aria-hidden="true"><i class="la la-close"></i></span>
            </button>
        </div>
    </div>
<?php } ?>