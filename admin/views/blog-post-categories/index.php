<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$actionItemsData = $actionItemsData + [
    'canEdit' => $canEdit ?? false
];
?>
<main class="main mainJs">
    <div class="container">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', $actionItemsData, false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <?php include('search.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>