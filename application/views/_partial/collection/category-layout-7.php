<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($collection['categories']) && count($collection['categories'])) { ?>
    <section class="section" data-collection="collection-categories">
        <div class="container">
            <?php /*?><div class="section-head section-head-center">
                <div class="section-heading">
                    <h2><?php echo $collection['collection_name']; ?></h2>
                </div>
            </div> <?php */ ?>
            <div class="section-body">
                <div class="industry-carousal industryCarousalJs">
                    <?php
                    $i = 1;
                    foreach ($collection['categories'] as $category) {
                        $rootParentId = FatUtility::int(current(explode('_', $category['prodcat_code'])));
                        $rootParentId = (1 > $rootParentId) ? $category['prodcat_id'] : $rootParentId;
                        if (1 == $i) { ?>
                            <div class="industry-carousal-item">
                            <?php } ?>
                            <?php
                            $afile_record_id = 0;
                            $afile_lang_id = 0;
                            $afile_id = 0;
                            $uploadedTime = '';
                            $image = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_ICON, $rootParentId);
                            if (!empty($image)) {
                                $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                                $afile_record_id = $image['afile_record_id'];
                                $afile_lang_id = $image['afile_lang_id'];
                                $afile_id = $image['afile_id'];
                                /*   $catIconUrl = UrlHelper::generateFileUrl('Category', ImageDimension::VIEW_ICON, array($image['afile_record_id'], $image['afile_lang_id'], ImageDimension::VIEW_THUMB, $image['afile_id']), CONF_WEBROOT_FRONT_URL) . $uploadedTime; */
                            }
                            $catIconUrl = UrlHelper::generateFileUrl('Category', ImageDimension::VIEW_ICON, array($afile_record_id, $afile_lang_id, ImageDimension::VIEW_THUMB, $afile_id), CONF_WEBROOT_FRONT_URL) . $uploadedTime;
                            $prodCatUrl = UrlHelper::generateUrl('Category', 'View', array($category['prodcat_id']));
                            ?>
                            <a class="industry-carousal-link" title="<?php echo $category['prodcat_name']; ?>" href="<?php echo $prodCatUrl; ?>">
                                <div class="industry-carousal-block">
                                    <img class="industry-carousal-icon" src="<?php echo $catIconUrl; ?>">
                                    <div class="industry-carousal-name"><span><?php echo $category['prodcat_name']; ?></span>
                                    </div>
                                </div>
                            </a>
                            <?php if (2 == $i) { ?>
                            </div>
                        <?php } ?>
                    <?php
                        $i = ($i == 2) ? 1 : ($i + 1);
                    }
                    ?>
                </div>
            </div>
            <?php if (count($collection['categories']) > Collections::LIMIT_CATEGORY_LAYOUT3) { ?>
                <div class="section-foot">
                    <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>" class="link-underline">
                        <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
                    </a>
                </div>
            <?php } ?>
        </div>
        <script>
            $('.industryCarousalJs').not('.slick-initialized').slick({
                draggable: true,
                slidesToShow: 7,
                slidesToScroll: 1,
                arrows: true,
                prevArrow: '<button class="slick-arrow slick-prev"><span></span> </button>',
                nextArrow: '<button class="slick-arrow slick-next"><span></span> </button>',
                responsive: [{
                        breakpoint: 1180,
                        settings: {
                            slidesToShow: 5,
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                        }
                    }
                ]
            })
        </script>
    </section>
<?php } ?>