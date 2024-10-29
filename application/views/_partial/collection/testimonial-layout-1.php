<?php
if (isset($collection['testimonials']) && count($collection['testimonials']) > 0) { ?>
    <section class="section bg-gray" data-section="section">
        <div class="container">
            <header class="section-head section-head-center">
                <div class="section-heading">
                    <h2>
                        <?php echo $collection['collection_name']; ?>
                    </h2>
                </div>
            </header>
            <div class="section-body">
                <div
                    class="<?php echo (1 < count($collection['testimonials'])) ? 'js-slider-testimonials' : ''; ?> slider-testimonials">
                    <?php foreach ($collection['testimonials'] as $testimonial) {
                        $uploadedTime = AttachedFile::setTimeParam($testimonial['testimonial_added_on']);
                    ?>
                        <div>
                            <div class="slider-testimonials-item">
                                <div class="slider-testimonials-image">
                                    <img class="slider-testimonials-user" alt="<?php echo $testimonial['testimonial_user_name']; ?>"
                                        src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'testimonial', array($testimonial['testimonial_id'], $siteLangId, ImageDimension::VIEW_MEDIUM)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>">
                                </div>
                                <div class="slider-testimonials-data">
                                    <div class="slider-testimonials-text">
                                        <p>
                                            <?php echo CommonHelper::truncateCharacters($testimonial['testimonial_text'], 250, '', '', true); ?>
                                            <?php if (strlen($testimonial['testimonial_text']) > 150) {
                                                echo '...';
                                            } ?>

                                        </p>
                                    </div>
                                    <div class="slider-testimonials-from">
                                        <h3 class="name">
                                            <?php echo $testimonial['testimonial_user_name']; ?>
                                        </h3>

                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>
            <div class="section-foot">
                <a class="link-underline"
                    href="<?php echo UrlHelper::generateUrl('Testimonials'); ?>"><?php echo Labels::getLabel('LBL_View_all', $siteLangId); ?>
                </a>
            </div>
        </div>
    </section>
    <?php if (1 < count($collection['testimonials'])) { ?>
        <script>
            $(function() {
                $(".js-slider-testimonials").not('.slick-initialized').slick({
                    rtl: ('rtl' == langLbl.layoutDirection),
                    slidesToShow: 1,
                    dots: false,
                    arrows: true,
                    swipe: true,
                    //  infinite: true,
                    swipeToSlide: true,
                    //adaptiveHeight: true,

                    responsive: [{
                            breakpoint: 768,
                            settings: {
                                arrows: false,
                                dots: true,
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false,
                                dots: true,
                            }
                        }
                    ]
                });
            });
        </script>
    <?php } ?>
<?php } ?>