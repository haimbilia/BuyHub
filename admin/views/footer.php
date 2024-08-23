<?php if ($isAdminLogged) {
    $this->includeTemplate('_partial/footer/loggeduser-footer.php', $this->variables, false);
} /* else {
    $this->includeTemplate('_partial/footer/non-loggeduser-footer.php', $this->variables, false);
} */
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE, false, true, false, false); ?>
</div>
<?php if (CommonHelper::demoUrl()) { ?>
    <div class="no-print">
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/5fe08aa9df060f156a8ef9fd/1eq2hracf';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    </div>
<?php } ?>
</div>

<?php if (!isset($_SESSION['geo_location']) && FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '') != '') { ?>
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=<?php echo FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''); ?>&libraries=places&callback=initMap'></script>
<?php }

$msgStrJs = '';
foreach (Message::getData() as $type => $errors) {
    if (count($errors)) {
        switch ($type) {
            case 'errs':
                $msgStrJs .= 'fcom.displayErrorMessage("' . current($errors) . '");';
                break;
            case 'msgs':
                $msgStrJs .= 'fcom.displaySuccessMessage("' . current($errors) . '");';
                break;
            case 'info':
                $msgStrJs .= '$.ykmsg.info("' . current($errors) . '");';
                break;
            case 'dialog':
                $msgStrJs .= '$.ykmsg.info("' . current($errors) . '");';
                break;
        }
    }
}
?>
<script>
    $(document).ready(function() {
        <?php echo $msgStrJs; ?>
    });
</script>



</body>

</html>