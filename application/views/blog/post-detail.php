<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class=" <?php echo (false === CommonHelper::isAppUser()) ? ' ' : ''; ?>">
    <div class="container">
        <div class="blog-detail post-data">
            <div class="blog-detail-left">
                <a class="btn btn-icon btn-link btn-back" href="">
                    <i class="icn">
                        <svg class="svg" width="20" height="20">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-blog.svg#arrow-back">
                            </use>
                        </svg>
                    </i>
                    <?php Labels::getLabel('LBL_BACK_TO_HOME', $siteLangId); ?>
                </a>

                <div class="blog-head">
                    <h1 class="title"> <?php echo $blogPostData['post_title']; ?></h1>
                    <div class="posted-by">
                        <div class="user-profile">
                            <div class="user-profile_photo"> <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_2.jpg" alt=""></div>
                            <div class="user-profile_data">
                                <span class="user-profile_title">
                                    <?php echo $blogPostData['post_author_name']; ?>
                                </span>
                                <span class="time"> <?php echo FatDate::format($blogPostData['post_added_on']); ?>
                                </span>
                            </div>
                        </div>
                        <span class="">
                            <?php $categoryIds = !empty($blogPostData['categoryIds']) ? explode(',', $blogPostData['categoryIds']) : array();
                            $categoryNames = !empty($blogPostData['categoryNames']) ? explode('~', $blogPostData['categoryNames']) : array();
                            $categories = array_combine($categoryIds, $categoryNames); ?>
                            <?php if (!empty($categories)) {
                                echo Labels::getLabel('Lbl_in', $siteLangId);
                                foreach ($categories as $id => $name) {
                                    if ($name == end($categories)) { ?>
                                        <a href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>" class="text--dark"><?php echo $name; ?></a>
                                    <?php break;
                                    } ?>
                                    <a href="<?php echo UrlHelper::generateUrl('Blog', 'category', array($id)); ?>" class="text--dark"><?php echo $name; ?></a>,
                            <?php }
                            } ?>
                        </span>
                        <div class="dropdown share-blog">
                            <button class="btn btn-outline-brand btn-wide btn-icon dropdown-toggle no-after" type="button" data-bs-toggle="dropdown">
                                Share
                                <svg class="svg" width="16" height="16">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-blog.svg#share">
                                    </use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-anim">
                                <ul class="social-sharing">
                                    <li class="social-facebook">
                                        <a class="social-link st-custom-button" data-network="facebook" data-url="<?php echo UrlHelper::generateFullUrl('Blog', 'postDetail', array($blogPostData['post_id'])); ?>/">
                                            <i class="icn">
                                                <svg class="svg" width="16" height="16">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb">
                                                    </use>
                                                </svg>
                                            </i>
                                        </a>
                                    </li>
                                    <li class="social-twitter">
                                        <a class="social-link st-custom-button" data-network="twitter">
                                            <i class="icn">
                                                <svg class="svg" width="16" height="16">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw">
                                                    </use>
                                                </svg></i>
                                        </a>
                                    </li>
                                    <li class="social-pintrest">
                                        <a class="social-link st-custom-button" data-network="pinterest">
                                            <i class="icn">
                                                <svg class="svg" width="16" height="16">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt">
                                                    </use>
                                                </svg>
                                            </i>
                                        </a>
                                    </li>
                                    <li class="social-email">
                                        <a class="social-link st-custom-button" data-network="email">
                                            <i class="icn">
                                                <svg class="svg" width="16" height="16">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope">
                                                    </use>
                                                </svg>
                                            </i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (false === CommonHelper::isAppUser()) { ?>
                    <div class="posted-media">
                        <?php if (!empty($post_images)) { ?>
                            <div class="post__pic">
                                <?php foreach ($post_images as $post_image) { ?>
                                    <div class="items">
                                        <div class="media-wrapper">
                                            <img data-ratio="16:9" src="<?php echo FatUtility::generateUrl('image', 'blogPostFront', array($post_image['afile_record_id'], $post_image['afile_lang_id'], ImageDimension::VIEW_LAYOUT1, 0, $post_image['afile_id']), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo $post_image['afile_attribute_alt']; ?>" title="<?php echo $post_image['afile_attribute_title']; ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="post-content">
                    <?php if (false === CommonHelper::isAppUser()) { ?>
                        <!-- <div class="post-meta-detail">
                            <?php /*<ul class="likes-count">
                                    <!--<li><i class="icn-like"><img src="<?php echo CONF_WEBROOT_URL; ?>images/eye.svg"></i>500                     Views </li>-->
                            <?php if ($blogPostData['post_comment_opened']) { ?>
                            <li><i class="icn-msg">
                            <img
                                        src="<?php echo CONF_WEBROOT_URL; ?>images/comments.svg"></i><?php echo $commentsCount,' ',Labels::getLabel('Lbl_Comments', $siteLangId); ?>
                            </li>
                            
                            </ul>*/ ?>
                        </div> -->

                    <?php } ?>

                    <?php echo FatUtility::decodeHtmlEntities($blogPostData['post_description']); ?>

                </div>
                <?php
                if (false === CommonHelper::isAppUser()) {
                    if ($blogPostData['post_comment_opened']) { ?>
                        <?php echo $srchCommentsFrm->getFormHtml(); ?>
                        <div class="comments" id="container--comments">
                            <h5>
                                <?php echo ($commentsCount) ? sprintf(Labels::getLabel('Lbl_Comments(%s)', $siteLangId), $commentsCount) : Labels::getLabel('Lbl_Comments', $siteLangId); ?>
                            </h5>
                            <div id="comments--listing"> </div>
                            <div class="text-center" id="loadMoreCommentsBtnDiv"></div>
                        </div>
                    <?php } ?>
                    <?php if ($blogPostData['post_comment_opened'] && UserAuthentication::isUserLogged() && isset($postCommentFrm)) { ?>

                        <div id="respond" class="comment-respond">
                            <h4>
                                <?php echo Labels::getLabel('Lbl_Leave_A_Comment', $siteLangId); ?>
                            </h4>
                            <?php
                            $postCommentFrm->setFormTagAttribute('class', 'form');
                            $postCommentFrm->setFormTagAttribute('onsubmit', 'setupPostComment(this);return false;');
                            $postCommentFrm->setRequiredStarPosition(Form::FORM_REQUIRED_STAR_POSITION_NONE);
                            $postCommentFrm->developerTags['colClassPrefix'] = 'col-md-';
                            $postCommentFrm->developerTags['fld_default_col'] = 12;
                            $nameFld = $postCommentFrm->getField('bpcomment_author_name');
                            $nameFld->addFieldTagAttribute('readonly', true);
                            $nameFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Name', $siteLangId));
                            $nameFld->developerTags['col'] = 6;
                            $emailFld = $postCommentFrm->getField('bpcomment_author_email');
                            $emailFld->addFieldTagAttribute('readonly', true);
                            $emailFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Email_Address', $siteLangId));
                            $emailFld->developerTags['col'] = 6;
                            $commentFld = $postCommentFrm->getField('bpcomment_content');
                            $commentFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Message', $siteLangId));

                            $btnSubmitFld = $postCommentFrm->getField('btn_submit');
                            $btnSubmitFld->setFieldTagAttribute('class', 'btn btn-brand btn-wide');

                            echo $postCommentFrm->getFormHtml(); ?>
                        </div>

                <?php }
                } ?>

            </div>
            <?php if (false === CommonHelper::isAppUser()) { ?>
                <?php $this->includeTemplate('_partial/blogSidePanel.php', array('popularPostList' => $popularPostList, 'featuredPostList' => $featuredPostList)); ?>

            <?php } ?>
            <?php /* <div class="col-md-3 colums__right">
            <div class="wrapper--adds" >
              <div class="grids" id="div--banners"> </div>
            </div>
          </div>  */ ?>
        </div>
    </div>
</section>
<?php if (false === CommonHelper::isAppUser()) { ?>
    <script>
        var boolLoadComments = (<?php echo FatUtility::int($blogPostData['post_comment_opened']); ?>) ? true : false;
        /* for social sticky */
        $(window).scroll(function() {
            body_height = $(".post-data").position();
            scroll_position = $(window).scrollTop();
            if (body_height.top < scroll_position)
                $(".post-data").addClass("is-fixed");
            else
                $(".post-data").removeClass("is-fixed");

        });
    </script>
    <?php echo $this->includeTemplate('_partial/shareThisScript.php'); ?>
<?php } ?>