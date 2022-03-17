<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<section class="section section--slide" style="background-image:url(<?php echo CONF_WEBROOT_URL; ?>images/page-bg.jpg)">
    <div class="slide__text">
        <h2><?php echo Labels::getLabel('LBL_Sell_on_yokart', $siteLangId); ?></h2>
        <a href="<?php echo UrlHelper::generateUrl('Supplier', 'Account'); ?>" class="btn btn-brand btn--h-large"><?php echo Labels::getLabel('LBL_Open_a_shop', $siteLangId); ?></a>
    </div>
    <div class="slide__caption">
        <ul>
            <li><?php echo Labels::getLabel('LBL_More_Customers.', $siteLangId); ?></li>
            <li><?php echo Labels::getLabel('LBL_Higher_Sales.', $siteLangId); ?></li>
            <li><?php echo Labels::getLabel('LBL_One_Location.', $siteLangId); ?></li>
            <li><?php echo Labels::getLabel('LBL_Low_Commission_Fees.', $siteLangId); ?></li>
        </ul>
    </div>
</section>


<?php if ((isset($contentBlocks[Extrapage::SELLER_PAGE_BLOCK1]['epage_content']) && $contentBlocks[Extrapage::SELLER_PAGE_BLOCK1]['epage_content'] != '') || (isset($contentBlocks[Extrapage::SELLER_PAGE_BLOCK2]['epage_content']) && $contentBlocks[Extrapage::SELLER_PAGE_BLOCK2]['epage_content'] != '')) { ?>
    <section class="section section--intro">
        <div class="container container--fixed">
            <?php if (isset($contentBlocks[Extrapage::SELLER_PAGE_BLOCK1]['epage_content']) && $contentBlocks[Extrapage::SELLER_PAGE_BLOCK1]['epage_content'] != '') { ?>
                <div class="threecols">
                    <?php echo CommonHelper::renderHtml($contentBlocks[Extrapage::SELLER_PAGE_BLOCK1]['epage_content']); ?>
                    <?php /* <div class="box box--white box--small">
					<div class="box__content">
						<h2>Fees & Documents</h2>
						<p>All you need is to have a business</p>
					</div>
				</div>
				<div class="box box--white box--large">
					<div class="box__content">
						<img src="<?php echo CONF_WEBROOT_URL; ?>images/icon_user.svg" alt="">
						<h2>Become a Seller</h2>
						<p>Open a shop and have more opportunities</p>
					</div>
				</div>
				<div class="box box--white box--small">
					<div class="box__content">
						<h2>Explore the way</h2>
						<p>How to easily sell your product</p>
					</div>
				</div> */ ?>
                </div>
            <?php } ?>

            <?php if (isset($contentBlocks[Extrapage::SELLER_PAGE_BLOCK2]['epage_content']) && $contentBlocks[Extrapage::SELLER_PAGE_BLOCK2]['epage_content'] != '') { ?>
                <div class="row--counter">
                    <?php echo CommonHelper::renderHtml($contentBlocks[Extrapage::SELLER_PAGE_BLOCK2]['epage_content']); ?>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>

<?php if (!empty($faqs)) { ?>
    <section class="section section--faqs">
        <div class="container container--fixed">
            <h3 class="align-center"><?php echo Labels::getLabel('Lbl_Frequently_Asked_Questions', $siteLangId); ?></h3>
            <div class="row">
                <div class="container--faqs">
                    <?php $this->includeTemplate('_partial/faq-list.php', array('list' => $faqs, 'siteLangId' => $siteLangId, 'showViewAllButton' => true), false); ?>
                </div>
                <span class="gap"></span>
                <div class="align-center">
                    <a href="<?php echo UrlHelper::generateUrl('Custom', 'faq'); ?>" class="btn btn-brand btn--h-large"><?php echo Labels::getLabel('LBL_View_All', $siteLangId) ?></a>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<script type="text/javascript">
    /* home page main slider */
    $('.slider--stories-js').slick({
        dots: false,
        arrows: false,
        autoplay: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: '',
        pauseOnHover: false,
        adaptiveHeight: true,
        responsive: [{
                breakpoint: 1050,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    centerPadding: '30px',
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    centerPadding: '50px',
                }
            },
            {
                breakpoint: 400,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    centerPadding: '10px',
                }
            }

        ]
    });
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
    /******** for faq accordians  ****************/

    $('.accordians__trigger-js').on('click', function() {
        if ($(this).hasClass('is-active')) {
            $(this).removeClass('is-active');
            $(this).siblings('.accordians__target-js').slideUp();
            return false;
        }
        $('.accordians__trigger-js').removeClass('is-active');
        $(this).addClass("is-active");
        $('.accordians__target-js').slideUp();
        $(this).siblings('.accordians__target-js').slideDown();
    });
</script>
</body>

</html>