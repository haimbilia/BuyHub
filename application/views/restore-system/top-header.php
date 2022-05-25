 <button class="restore-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
     <!-- <span class="restore-btn-icon"></span> -->
     <span class="restore-btn-label">Restore</span>
 </button>

 <div class="offcanvas offcanvas-end offcanvas-restore" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
     <div class="offcanvas-header bg-shape">

         <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
     </div>
     <div class="offcanvas-body">
         <div class="demo">
             <div class="demo-restore">
                 <div class="restore">
                     <button class="demo-restore" type="button" onclick="showRestorePopup()">
                         <h3 class="restore-title">Database Restores in</h3>
                         <div class="restore__progress">
                             <div class="restore__progress-bar" style="width:25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                             </div>
                         </div>
                         <span class="restore-counter" id="restoreCounter">00:00:00</span>
                     </button>
                 </div>
             </div>
             <div class="demo-switch">
                 <ul class="views">
                     <?php
                        $admin = '';
                        $mobileSite = '';
                        $tabSite = '';
                        $desktopSite = '';
                        $adminUrl = 'admin';
                        if ('SiteDemoController' == FatApp::getController()) {
                            switch (FatApp::getAction()) {
                                case 'mobile':
                                    $mobileSite = 'is-active';
                                    break;
                                case 'tab':
                                    $tabSite = 'is-active';
                                    break;
                            }
                        } elseif (strpos($_SERVER['REQUEST_URI'], rtrim(CONF_WEBROOT_BACKEND, '/')) !== false) {
                            $admin = 'is-active';
                            $adminUrl = '';
                        } else {
                            $desktopSite = 'is-active';
                        }
                        ?>

                     <li class="views-item <?php echo $admin; ?>">
                         <a class="views-links" title="Admin" href="<?php echo UrlHelper::generateUrl($adminUrl); ?>">
                             <svg class="svg" width="32" height="32">
                                 <use xlink:href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#admin">
                                 </use>
                             </svg>
                             <span class="label"> Admin </span>
                         </a>
                     </li>
                     <li class="views-item <?php echo $desktopSite; ?>">
                         <a class="views-links" title="Marketplace" href="<?php echo UrlHelper::generateUrl('', '', array(), CONF_WEBROOT_FRONTEND); ?>">
                             <svg class="svg" width="32" height="32">
                                 <use xlink:href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#desktop">
                                 </use>
                             </svg>
                             <span class="label"> Marketplace </span>
                         </a>
                     </li>

                     <li class="views-item <?php echo $mobileSite; ?>">
                         <a class="views-links" title="Marketplace Mobile View" href="<?php echo UrlHelper::generateUrl('SiteDemo', 'mobile', array(), CONF_WEBROOT_FRONTEND); ?>">

                             <svg class="svg" width="32" height="32">
                                 <use xlink:href="<?php echo CONF_WEBROOT_FRONTEND; ?>images/retina/sprite.svg#mobile">
                                 </use>
                             </svg>
                             <span class="label">
                                 Mobile
                             </span>
                         </a>
                     </li>
                 </ul>

                 <a class="btn btn-outline-brand btn-block mt-3" target="_blank" rel="noopener" href="https://www.yo-kart.com/blog/yokart-releases-v9-3-0-to-personalize-shopping-experiences-automate-payouts-taxes-shipping/?q=demov9.3 ">Learn about <?php echo str_replace('RV-', 'V', CONF_WEB_APP_VERSION); ?>
                 </a>
             </div>
             <div class="demo-action">
                 <a class="link-underline" href="javascript:0;"> Start Your Marketplace </a> <a class="link-underline" href="javascript:0;"> Request a Demo </a>


             </div>

         </div>
     </div>
 </div>