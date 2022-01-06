<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
?>

<main class="main mainJs">
    <div class="container">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive table-scrollable js-scrollable listingTableJs" data-auto-column-width="<?php echo $autoTableColumWidth; ?>">
                            <form class="form">
                                <?php                  
                                require_once(CONF_THEME_PATH . 'tracking-code-relation/search.php');
                                ?>
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</main>