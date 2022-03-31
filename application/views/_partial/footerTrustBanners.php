<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<?php if ($footerData) { ?>
    <section class="section">        
        <?php echo FatUtility::decodeHtmlEntities($footerData['epage_content']); ?> 
    </section>
<?php } ?>