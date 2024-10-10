<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($collection['categories']) && count($collection['categories'])) {
    $displaySize = (8 < $collection['collection_primary_records']) ? min($collection['collection_primary_records'], 16) / 2 : (0 < $collection['collection_primary_records'] ? $collection['collection_primary_records'] : 8);
    $loopBreakCount = (8 < $collection['collection_primary_records']) ? 2 : 1;
?>
    <section class="section" data-collection="collection-categories">
        <div class="container">
            <?php /*?><div class="section-head section-head-center">
            <div class="section-heading">
                <h2><?php echo $collection['collection_name']; ?></h2>
            </div>
        </div> <?php */ ?>
            <div class="section-body">
                <div class="industry-carousal industryCarousalJs"
                    data-view="<?php echo $displaySize; ?>">
                    <?php
                    $i = 1;
                    foreach ($collection['categories'] as $category) {
                        $rootParentId = FatUtility::int(current(explode('_', $category['prodcat_code'])));
                        $rootParentId = (1 > $rootParentId) ? $category['prodcat_id'] : $rootParentId;
                        if (1 == $i) { ?>
                            <div class="industry-carousal-item">
                            <?php } ?>
                            <?php
                            $image = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_IMAGE, $category['prodcat_id']);
                            if (!empty($image) && $image['afile_id'] <= 0) {
                                $image = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_IMAGE, $rootParentId);
                            }
                            $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                            $afile_record_id = $image['afile_record_id'];
                            $afile_lang_id = $image['afile_lang_id'];
                            $afile_id = $image['afile_id'];

                            $catIconUrl = UrlHelper::generateFileUrl('Category', ImageDimension::VIEW_THUMB, array($afile_record_id, $afile_lang_id, ImageDimension::VIEW_THUMB, $afile_id), CONF_WEBROOT_FRONT_URL) . $uploadedTime;
                            $prodCatUrl = UrlHelper::generateUrl('Category', 'View', array($category['prodcat_id']));
                            ?>
                            <a class="industry-carousal-link" title="<?php echo $category['prodcat_name']; ?>"
                                href="<?php echo $prodCatUrl; ?>">
                                <div class="industry-carousal-block">
                                    <img class="industry-carousal-icon" src="<?php echo $catIconUrl; ?>">
                                    <div class="industry-carousal-name"><span><?php echo $category['prodcat_name']; ?></span>
                                    </div>
                                </div>
                            </a>
                            <?php if ($loopBreakCount == $i) { ?>
                            </div>
                        <?php } ?>
                    <?php
                        $i = ($i == $loopBreakCount) ? 1 : ($i + 1);
                    }
                    ?>
                </div>
            </div>
            <?php /*if (count($collection['categories']) > Collections::LIMIT_CATEGORY_LAYOUT3) { ?>
        <div class="section-foot">
            <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>"
                class="link-underline">
                <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
            </a>
        </div>
        <?php } */ ?>
        </div>
        <script>
            var displaySize = <?php echo 0 < $displaySize ? $displaySize : 8; ?>;
            $('.industryCarousalJs').not('.slick-initialized').slick({
                draggable: true,
                slidesToShow: displaySize,
                slidesToScroll: 1,
                arrows: true,
                prevArrow: '<button class="slick-arrow slick-prev"><span></span> </button>',
                nextArrow: '<button class="slick-arrow slick-next"><span></span> </button>',
                responsive: [{
                        breakpoint: 1180,
                        settings: {
                            slidesToShow: displaySize,
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 5,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 4,
                        }
                    }
                ]
            })
        </script>
    </section>
<?php } ?>