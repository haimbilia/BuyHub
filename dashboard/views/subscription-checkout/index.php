<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<section class="section" data-content="">
    <div class="container checkout-content-js"></div>
</section>
<script type="text/javascript">
    $("document").ready(function() {
        $(document).on("click", ".toggle--collapseable-js", function(e) {
            var prodgroup_id = $(this).attr('data-prodgroup_id');
            $(this).toggleClass("is--active");
            $("#prodgroup_id_" + prodgroup_id).slideToggle();
        });
    });
</script>