 <div class="container">
     <div class="header-blog-inner">
         <div class="logo">
             <?php
                $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
                $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                ?>
             <a href="<?php echo UrlHelper::generateUrl('Blog'); ?>">
                 <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId); ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>">
             </a>
         </div>
         <div class="header-blog-right">
             <span class="blog-overlay blogOverlayJs" id="blog-overlay"></span>
             <?php if (!empty($categoriesArr)) {
                    $noOfCharAllowedInNav = 60;
                    $navLinkCount = 0;
                    foreach ($categoriesArr as $cat) {
                        if (!$cat) {
                            break;
                        }

                        $noOfCharAllowedInNav = $noOfCharAllowedInNav - mb_strlen($cat);
                        if ($noOfCharAllowedInNav < 0) {
                            break;
                        }
                        $navLinkCount++;
                    } ?>
                 <div class="menu-nav menuNavJs">
                     <ul class="nav-blog <?php echo ($navLinkCount > 4) ? 'justify-content-between' : ''; ?>">
                         <?php $mainNavigation = array_slice($categoriesArr, 0, $navLinkCount, true);
                            foreach ($mainNavigation as $id => $cat) { ?>
                             <li class="nav-blog-item">
                                 <a class="nav-blog-link" href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>">
                                     <?php echo $cat; ?>
                                 </a>
                             </li>
                         <?php } ?>
                         <li class="nav-blog-item">
                             <a class="nav-blog-link nav-blog-more" data-bs-toggle="collapse" href="#blog-more" role="button" aria-expanded="false" aria-controls="blog-more">More</a>
                             <div class="collapse blog-more" id="blog-more">
                                 <div class="container">
                                     <ul>
                                         <li><a href="https://www.fatbit.com/fab/category/online-learning-consulting-business-ideas/">eLearning Business Ideas (26)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/rental-startup-ideas/">Online Rental Business Ideas (26)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/online-grocery-business-models/">Online Grocery Business Ideas (31)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/ecommerce/">eCommerce (64)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/web-based-business-ideas/">Web Based Business Models (116)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/online-food-delivery-business-ideas/">Food Delivery Startup Ideas (24)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/online-ride-hailing-business-ideas/">Online Ride Hailing Business Ideas (8)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/mobile-app-development/">Mobile App Development (39)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/service-marketplace-business-ideas/">On-demand Services Business Ideas (7)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/travel-marketplace-business-ideas/">Travel Marketplace Business Ideas (22)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/seo-ppc/">SEO &amp; PPC (21)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/conversion/">Conversion (30)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/online-reputation-management/">Online Reputation Management (9)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/trends/">Tips and Trends (59)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/user-experience/">User Experience (9)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/case-studies/">Case Studies (2)</a></li>
                                         <li><a href="https://www.fatbit.com/fab/category/design-dev/">Design &amp; Development (54)</a></li>
                                         <li class="noBorderBottom"><a href="https://www.fatbit.com/fab/category/entrepreneurship/">Entrepreneurship (6)</a></li>
                                     </ul>
                                 </div>
                             </div>
                         </li>
                     </ul>
                 </div>
             <?php } ?>

             <button class="btn-menu blogPageBurgerIconJs" data-bs-backdrop="true" data-bs-toggle="offcanvas" data-bs-target="#blog-menu">
                 <svg class="svg" width="20" height="20">
                     <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-blog.svg#burgerMenu">
                     </use>
                 </svg>
             </button>
             <button class="btn-blog-search" data-bs-backdrop="true" data-bs-toggle="offcanvas" data-bs-target="#blog-search">

                 <svg class="svg" width="20" height="20">
                     <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-blog.svg#magnifying">
                     </use>
                 </svg>

             </button>
         </div>
     </div>
 </div>