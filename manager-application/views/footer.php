<?php if ($isAdminLogged) {
    $this->includeTemplate('_partial/footer/loggeduser-footer.php', $this->variables, false);
} /* else {
    $this->includeTemplate('_partial/footer/non-loggeduser-footer.php', $this->variables, false);
} */
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE, false, true, false, false); ?>
</div>
</div>

<?php if (!isset($_SESSION['geo_location']) && FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '') != '') { ?>
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=<?php echo FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '');?>&libraries=places'></script>
<?php } ?>

</body>

</html>