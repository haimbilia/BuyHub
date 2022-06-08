<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_INFO_REGARDING_THIS_PAGE', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div id="catalogToolTip">
            <?php
            if (!empty($pageData)) {
                echo isset($pageData['epage_content']) && !empty($pageData['epage_content']) ? $pageData['epage_content'] : $pageData['epage_default_content'];
            } else {
                $this->includeTemplate('_partial/no-record-found.php', ['message' => Labels::getLabel('LBL_NO_INSTRUCTIONS_FOUND!')], false);
            }
            ?>
        </div>
    </div>
</div>