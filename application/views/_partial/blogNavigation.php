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
                 <ul class="nav-blog <?php echo ($navLinkCount > 4) ? 'justify-content-between' : ''; ?>">
                     <?php $mainNavigation = array_slice($categoriesArr, 0, $navLinkCount, true);
                        foreach ($mainNavigation as $id => $cat) { ?>
                         <li class="nav-blog-item">
                             <a class="nav-blog-link" href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>"><?php echo $cat; ?>
                             </a>
                         </li>
                     <?php } ?>
                 </ul>
             <?php } ?>

             <button class="btn-blog-search" data-bs-backdrop="true" data-bs-toggle="offcanvas" data-bs-target="#blog-search" aria-controls="offcanvas-blog-search">
                 <i class="icn">
                     <svg class="svg" width="20" height="20">
                         <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#magnifying">
                         </use>
                     </svg>
                 </i>
             </button>
             <!-- offcanvas-blog-search -->
             <div class="offcanvas offcanvas-blog-search" data-bs-backdrop="false" tabindex="-1" id="blog-search" aria-labelledby="blog-searchLabel">
                 <div class="blog-search">
                     <?php $srchFrm->setFormTagAttribute('onSubmit', 'submitBlogSearch(this); return(false);');
                        $srchFrm->setFormTagAttribute('class', 'form');
                        $srchFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
                        $srchFrm->developerTags['fld_default_col'] = 12;
                        $keywordFld = $srchFrm->getField('keyword');
                        $keywordFld->setFieldTagAttribute('class', 'blog-search-input');
                        $keywordFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_In_Blogs...', $siteLangId));
                        $submitFld = $srchFrm->getField('btnProductSrchSubmit');
                        $submitFld->setFieldTagAttribute('class', 'btn');
                        echo $srchFrm->getFormTag();
                        echo $srchFrm->getFieldHTML('keyword');
                        echo $srchFrm->getFieldHTML('btnProductSrchSubmit');
                        echo $srchFrm->getExternalJS(); ?>
                     </form>
                 </div>
             </div>
             <!-- <div class="back-to">
                 <a class="btn btn-icon btn-outline-brand" href="<?php echo UrlHelper::generateUrl(); ?>">
                     <?php echo Labels::getLabel('LBL_Shop', $siteLangId) . ' ' . FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId);  ?>

                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                         <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                     </svg>
                 </a>
             </div> -->
         </div>
     </div>
 </div>