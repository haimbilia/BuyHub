<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<section class="section section--gray">

    <div class="container container--fixed">

<div class="row" id="rfq-listing-container">
    <div id="rfq-paging" data-page="1" data-loaded="false" style="display: none;"></div>
    <?php
echo $this->includeTemplate('request-for-quotes/list-rows.php', ['rfqList' => $rfqList, 'siteLangId' => $siteLangId], false);

?>
</div>
    </div>

<div id="rfq-loader" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); z-index:9999;">
    <img src="/images/spinner.svg" alt="Loading..." width="40">
</div>
</section>

<script src="/public/index.php?url=js-css/js&f=js%2Finfinite-scroll.js&min=1"></script>


