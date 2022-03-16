<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<!-- offcanvas-mega-search -->
<div class="offcanvas offcanvas-mega-search" data-bs-backdrop="false" tabindex="-1" id="mega-nav-search" aria-labelledby="mega-nav-searchLabel">
    <?php $this->includeTemplate('_partial/headerSearchFormArea.php'); ?>
</div>

<!-- offcanvas-filters -->
<div class="offcanvas offcanvas-end  offcanvas-filters" tabindex="-1" id="filters-right" aria-labelledby="filters-right">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Offcanvas right</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        Filter Right
    </div>
</div>