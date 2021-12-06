<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$actionItemsData = $actionItemsData + [
    'canEdit' => $canEdit ?? false
];
?>
<main class="main mainJs">
    <div class="container">
        <?php
        $this->includeTemplate('_partial/header/header-breadcrumb.php', $actionItemsData, false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="listing">
                        <?php require_once(CONF_THEME_PATH . $actionItemsData['searchListingPage']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>