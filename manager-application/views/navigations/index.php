<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<main class="main mainJs">
    <div class="container">
        <?php
        $this->includeTemplate('_partial/header/header-breadcrumb.php', ['canEdit' => $canEdit], false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="listing">
                        <?php require_once('search.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>