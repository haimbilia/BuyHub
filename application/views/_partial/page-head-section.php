<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$includeBreadcrumb = $includeBreadcrumb ?? false;
$subHeadLabel = $subHeadLabel ?? '';
?>
<div class="bg-brand-light py-4">
    <div class="container">
        <header class="section-head section-head-center">
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
        </header>
    </div>
</div>