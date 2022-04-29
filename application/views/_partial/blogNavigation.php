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
                     </ul>
                 </div>
             <?php } ?>

             <button class="btn-menu blogPageBurgerIconJs" data-bs-backdrop="true" data-bs-toggle="offcanvas" data-bs-target="#blog-menu" aria-controls="offcanvas-blog-menu">
                 <svg class="svg" width="20" height="20">
                     <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-blog.svg#burgerMenu">
                     </use>
                 </svg>
             </button>
             <button class="btn-blog-search" data-bs-backdrop="true" data-bs-toggle="offcanvas" data-bs-target="#blog-search" aria-controls="offcanvas-blog-search">

                 <svg class="svg" width="20" height="20">
                     <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-blog.svg#magnifying">
                     </use>
                 </svg>

             </button>
         </div>
     </div>
 </div>