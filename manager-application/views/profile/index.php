<main class="main">
    <div class="container">
        <div class="grid grid--desktop grid--ver grid--ver-desktop app">
            <!--Begin:: App Aside Mobile Toggle-->
            <button class="app__aside-close d-none" id="user_profile_aside_close">
                <i class="la la-close"></i>
            </button>
            <?php require_once CONF_THEME_PATH . 'profile/leftSideBar.php'; ?>   
            <div class="grid__item grid__item--fluid app__content">
                <div class="row">
                    <div class="col-xl-12" id="mainProfileBlockJs">
                  
                    </div>
                </div>
            </div>      
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {        
        openProfileTab("<?php echo $tab ?>");
    });
</script>