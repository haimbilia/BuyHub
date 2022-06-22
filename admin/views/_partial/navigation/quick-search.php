<div class="quick-search">
    <form method="get" class="form  quick-search-form">
        <div class="quick-search-head">
            <input id="quickSearchJs" type="search" class="form-control" placeholder="<?php echo Labels::getLabel('LBL_GO_TO..', $siteLangId); ?>">
        </div>
        <div class="quick-search-body">
            <?php 
                $quickSearch = true;
                require CONF_THEME_PATH . '_partial/navigation/nav-links.php'; 
            ?>
        </div>
    </form>
</div>