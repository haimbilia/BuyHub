<?php if ($isAdminLogged) {
    $this->includeTemplate('_partial/footer/loggeduser-footer.php', $this->variables, false);
} /* else {
    $this->includeTemplate('_partial/footer/non-loggeduser-footer.php', $this->variables, false);
} */
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE, false, true, false, false); ?>
</div>
</div>
</body>

</html>