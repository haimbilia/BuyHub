<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-body">
    <div class="settings">
        <?php foreach ($options as $key => $val) { 
            $onclick = 'exportForm(' . $key . '); return false;';
            $href = 'javascript:void(0);';
            if (Importexport::TYPE_LANGUAGE_LABELS == $key) {
                $onclick = '';
                $href = UrlHelper::generateUrl('ImportExport', 'exportLabels');
            }
            ?>
            <a class="setting" href="<?php echo $href; ?>" onclick="<?php echo $onclick; ?>">
                <div class="setting__detail">
                    <h6><?php echo $val; ?></h6>
                    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
                </div>
            </a>
        <?php } ?>
    </div>
</div>