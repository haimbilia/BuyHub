<?php if (isset($tourStep) && 0 < $tourStep) { ?>
    <div class="header-action__item mx-2">
        <a href="<?php echo SiteTourHelper::getPrevLink($tourStep); ?>">
            PREV
        </a>
    </div>
    <div class="header-action__item mx-2">
        <a href="<?php echo SiteTourHelper::getNextLink($tourStep); ?>">
            NEXT
        </a>
    </div>
<?php } ?>