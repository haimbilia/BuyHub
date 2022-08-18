<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($postList)) {
    foreach ($postList as $blogPost) { ?>
        <div class="post">
            <div class="post-head">
                <figure class="post-media">
                    <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>">
                        <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $blogPost['post_id']);
                        $uploadedTime = AttachedFile::setTimeParam($fileRow['afile_updated_at']);
                        $pictureAttr = [
                            'webpImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Image', 'blogPostFront', array($blogPost['post_id'], $siteLangId, "WEBP" . ImageDimension::VIEW_LAYOUT2), CONF_WEBROOT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp')],
                            'jpgImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Image', 'blogPostFront', array($blogPost['post_id'], $siteLangId, ImageDimension::VIEW_LAYOUT2), CONF_WEBROOT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg')],
                            'ratio' => '16:9',
                            'imageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Image', 'blogPostFront', array($blogPost['post_id'], $siteLangId, ImageDimension::VIEW_LAYOUT2), CONF_WEBROOT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                            'alt' => (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $blogPost['post_title'],
                            'siteLangId' => $siteLangId,
                        ];
                        $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                        ?></a>
                </figure>
            </div>
            <div class="post-body">
                <ul class="post-category">
                    <?php $categoryIds = !empty($blogPost['categoryIds']) ? explode(',', $blogPost['categoryIds']) : array();
                    $categoryNames = !empty($blogPost['categoryNames']) ? explode('~', $blogPost['categoryNames']) : array();
                    $categories = array_combine($categoryIds, $categoryNames);
                    foreach ($categories as $id => $name) { ?>
                        <li class="post-category-tag">
                            <a href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>"><?php echo $name; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <h2 class="post-title">
                    <a href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo $blogPost['post_title'] ?></a>
                </h2> <a class="post-link" href="<?php echo UrlHelper::generateUrl('Blog', 'postDetail', array($blogPost['post_id'])); ?>"><?php echo Labels::getLabel('LBL_READ_MORE', $siteLangId); ?></a>

            </div>

        </div>

    <?php } ?>
    <?php
    $postedData['page'] = $page;
    echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmBlogSearchPaging'));
    $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'callBackJsFunc' => 'goToSearchPage');
    $this->includeTemplate('_partial/pagination.php', $pagingArr, false); ?>
<?php } else { ?>
    <div class="post">
        <?php $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId), false); ?>
    </div>
<?php } ?>
<?php $this->includeTemplate('_partial/shareThisScript.php'); ?>