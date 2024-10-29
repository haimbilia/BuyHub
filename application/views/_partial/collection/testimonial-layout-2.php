<?php if (isset($collection['testimonials']) && count($collection['testimonials']) > 0) { ?>
    <section class="section" data-collection="testimonials-categories">
        <div class="container">
            <header class="section-head">
                <div class="section-heading">
                    <h2><?php echo $collection['collection_name']; ?></h2>
                </div>
                <div class="section-head-action">
                    <a class="link-brand link-underline" href="<?php echo UrlHelper::generateUrl('Testimonials'); ?>">
                        <?php echo Labels::getLabel('LBL_View_all', $siteLangId); ?>
                    </a>
                </div>
            </header>
            <div class="section-body">
                <div class="testimonials-layout-2 js-carousel <?php echo (1 < count($collection['testimonials'])) ? '' : ''; ?>"
                    data-slides="<?php echo (0 < $collection['collection_primary_records'] ? $collection['collection_primary_records'] : 5) ?>,3,1,1"
                    aria-label="carousel">
                    <?php foreach ($collection['testimonials'] as $testimonial) {
                        $uploadedTime = AttachedFile::setTimeParam($testimonial['testimonial_added_on']); ?>
                        <div class="js-carousel-item">
                            <div class="testimonial-card">
                                <div class="testimonial-card-head">
                                    <img src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'testimonial', array($testimonial['testimonial_id'], $siteLangId, ImageDimension::VIEW_MEDIUM)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>"
                                        alt="<?php echo $testimonial['testimonial_user_name']; ?>"
                                        title="<?php echo $testimonial['testimonial_user_name']; ?>" decoding="async">
                                </div>
                                <div class="testimonial-card-body">
                                    <p>
                                        <?php echo CommonHelper::truncateCharacters($testimonial['testimonial_text'], 250, '', '', true); ?>
                                        <?php if (strlen($testimonial['testimonial_text']) > 150) {
                                            echo '...';
                                        } ?>
                                    </p>
                                </div>
                                <div class="testimonial-card-foot">
                                    <h5><?php echo $testimonial['testimonial_user_name']; ?></h5>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php if (1 < count($collection['testimonials'])) { ?>
        <script>
            var displaySize =
                <?php echo 0 < $collection['collection_primary_records'] ? $collection['collection_primary_records'] : 4; ?>;
            $(function() {
                $(".sliderTestimonialsjs").not('.slick-initialized').slick({
                    rtl: ('rtl' == langLbl.layoutDirection),
                    draggable: true,
                    slidesToShow: displaySize,
                    dots: false,
                    arrows: true,
                    infinite: false,

                    prevArrow: '<button class="slick-arrow slick-prev"><span></span> </button>',
                    nextArrow: '<button class="slick-arrow slick-next"><span></span> </button>',
                    responsive: [{
                            breakpoint: 1199,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 1,
                            }
                        },
                        {
                            breakpoint: 1023,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                }).on('setPosition', function(event, slick) {
                    slick.$slides.css('height', slick.$slideTrack.height() + 'px');
                });
            });
        </script>
    <?php } ?>
<?php } ?>