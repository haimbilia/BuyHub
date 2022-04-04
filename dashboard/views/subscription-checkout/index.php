<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="checkout">
    <header class="header-checkout" data-header="">
        <div class="container">
            <div class="header-checkout_inner">
                <a class="logo-checkout-main" href="/yokart"><img src="http://localhost/yokart/image/site-logo/1?t=1608690809" alt="Yo!Kart" title="Yo!Kart"></a>
            </div>
        </div>
    </header>
    <section class="section" data-content="">
        <div class="container checkout-content-js">

        </div>
    </section>
</div>
<script type="text/javascript">
    $("document").ready(function() {
        $(document).on("click", ".toggle--collapseable-js", function(e) {
            var prodgroup_id = $(this).attr('data-prodgroup_id');
            $(this).toggleClass("is--active");
            $("#prodgroup_id_" + prodgroup_id).slideToggle();
        });
    });
</script>