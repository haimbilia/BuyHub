<div class="not-found">
  <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/error-404.svg" alt="">
  <h3>404 PAGE NOT FOUND</h3>
  <p>Check that you typed the address correctly, go back to your previous page or try using our site search to find something specific.</p>

  <div class="action">
    <a href="<?php echo UrlHelper::generateUrl(''); ?>" class="btn btn-outline-brand "><?php echo Labels::getLabel('MSG_Back_To_Home', $siteLangId); ?></a>
  </div>

</div>