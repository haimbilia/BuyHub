<?php 
if (isset($collection['testimonials']) && count($collection['testimonials']) > 0) { ?>
<section class="section bg-brand-light">
    <div class="container">
        <div class="section-head section--head--center">
            <div class="section__heading">
                <h2>
                    <?php echo $collection['collection_name']; ?>
                </h2>
            </div>
        </div>

        <div
            class="<?php echo (3 < count($collection['testimonials'])) ? 'js-slider-testimonials' : '';?> slider-testimonials">
            <?php foreach ($collection['testimonials'] as $testimonial) { ?>
            <div class="slide">
                <div class="slide-item">
                    <div class="slide-item__text">
                        <p>
                            <?php echo CommonHelper::truncateCharacters($testimonial['testimonial_text'], 250, '', '', true); ?>
                            <?php if (strlen($testimonial['testimonial_text']) > 150) {
                                    echo '...';
                                } ?>

                        </p>
                    </div>
                    <div class="slide-item__from">
                        <img class="user-pic" alt="<?php echo $testimonial['testimonial_user_name']; ?>"
                            src="<?php echo UrlHelper::generateFileUrl('Image', 'testimonial', array($testimonial['testimonial_id'], $siteLangId, 'THUMB')) . '?t=' . time(); ?>">
                        <div class="user-detail">
                            <p>
                                <span class="name"><?php echo $testimonial['testimonial_user_name']; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>




        <div class="section-foot text-center">
            <a class="btn btn-outline-brand btn-wide"
                href="<?php echo UrlHelper::generateUrl('Testimonials'); ?>"><?php echo Labels::getLabel('LBL_View_all', $siteLangId); ?>
            </a>
        </div>
    </div>
</section>
<?php if (3 < count($collection['testimonials'])) { ?>
<script>
$(".js-slider-testimonials").slick({
    centerMode: true,
    centerPadding: '0',
    slidesToShow: 3,
    variableWidth: false,
    dots: true,
    arrows: true,
    swipe: true,
    //  infinite: true,
    swipeToSlide: true,
    //adaptiveHeight: true,

    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                dots: true,
                arrows: false,
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                dots: true,
                arrows: false,
            }
        }

    ]
});
</script>
<?php } ?>
<?php } ?>