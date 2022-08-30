<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$includeBreadcrumb = $includeBreadcrumb ?? false;
$subHeadLabel = $subHeadLabel ?? '';
?>
<div class="bg-brand-light pt-3 pb-3">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-12">
                <div class="section-head section-head-center mb-0">
                    <div class="section-heading">
                        <h1><?php echo $headLabel; ?></h1>
                        <?php if (!empty($subHeadLabel)) { ?>
                            <p><?php echo $subHeadLabel; ?></p>
                        <?php } ?>
                        <?php if ($includeBreadcrumb) { ?>
                            <div class="breadcrumb breadcrumb-center">
                                <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>