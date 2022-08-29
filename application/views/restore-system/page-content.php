<?php
$html = '<div class="modal-header"><h5 class="modal-title">Yo!kart</h5></div><div class="modal-body"><div class="cms p-4"> <p>To enhance your demo experience, we periodically restore our database every 4 hours.</p><h6 class="mt-2">For technical issues :-</h6> <ul class="contacts"> <li> <h6>Call us at: </h6> <p>+1 469 844 3346,</br> +91 85919 19191,</br> +91 95555 96666,</br> +91 73075 70707,</br> +91 93565 35757</p></li><li> <h6>Mail us at: </h6> <a href="mailto:sales@fatbit.com">sales@fatbit.com</a> </li></ul> <div class="divider"></div><div class="cta"> <p class="mb-2">Create Your Dream Multi-vendor Ecommerce Store With Yo!Kart</p><a class="btn btn-brand btn-sm" href="https://www.yo-kart.com/contact-us.html" target="_blank">Click here</a> </div></div></div>'; ?>

<script>
    $(document).on("click", "#demoBoxClose", function(e) {
        $('.demo-header').hide();
        $('html').removeClass('sticky-demo-header');

        if (0 < $(".nav-detail-js").length) {
            var headerHeight = $("#header").height();
            $(".nav-detail-js").css('top', headerHeight);
        }
    });
    <?php
    $dateTime = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +4 hours'));
    $restoreTime = FatApp::getConfig('CONF_RESTORE_SCHEDULE_TIME', FatUtility::VAR_STRING, $dateTime);
    ?>
    // Set the date we're counting down to
    var countDownDate = new Date('<?php echo $restoreTime; ?>').getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        //var now = new Date().getTime();
        var currentTime = new Date();
        var currentOffset = currentTime.getTimezoneOffset();
        var ISTOffset = 330; // IST offset UTC +5:30
        var now = new Date(currentTime.getTime() + (ISTOffset + currentOffset) * 60000);

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        var str = ('0' + hours).slice(-2) + ":" + ('0' + minutes).slice(-2) + ":" + ('0' + seconds).slice(-2);
        // Display the result in the element with id="demo"
        $('.restoreCounterJs').html(str);
        var progressPercentage = 100 - (parseFloat(hours + '.' + parseFloat(minutes / 15 * 25)) * 100 / 4);
        $('.restore__progress-bar').css('width', progressPercentage + '%');
        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            $('.restoreCounterJs').html("Process...");
            showRestorePopup();
            restoreSystem();
        }
        
        if (1 > hours && 5 >= minutes && 1 > $('.timerSectionCloneJs').length) {
            $($('.timerSectionJs')[0].outerHTML).addClass('timerSectionClone timerSectionCloneJs').insertAfter('.restoreBtnJs')
        }

    }, 1000);

    function showRestorePopup() {
        $.ykmodal('<?php echo $html; ?>', true);
    }

    function restoreSystem() {
        $.ykmsg.warning('Restore is in process..');
        setTimeout(function() {
            $.facebox.close();
        }, 5000);
        fcom.updateWithAjax(fcom.makeUrl('RestoreSystem', 'index', '',
            '<?php echo CONF_WEBROOT_FRONT_URL; ?>'), '', function(
            resp) {
            fcom.removeLoader();
            setTimeout(function() {
                window.location.reload();
            }, 5000);
        }, false, false);
    }
</script>
<!-- Set up the path for the initial page view -->
<script>
    var _hsq = window._hsq = window._hsq || [];
    _hsq.push(['setPath', '/']);
</script>

<!-- Load the HubSpot tracking code -->
<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" defer src="//js.hs-scripts.com/2865881.js"></script>
<!-- End of HubSpot Embed Code -->

<!-- Tracking subsequent page views -->
<script>
    var _hsq = window._hsq = window._hsq || [];
    _hsq.push(['setPath', '<?php echo $_SERVER['REQUEST_URI']; ?>']);
    _hsq.push(['trackPageView']);
</script>