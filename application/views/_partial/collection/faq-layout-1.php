<?php if (isset($collection['faqs']) && count($collection['faqs']) > 0) {
    $faqCategories = array();
    foreach ($collection['faqs'] as $faq) {
        $faqCategories[$faq['faqcat_id']]['faqcat_name'] = $faq['faqcat_name'];
        $faqCategories[$faq['faqcat_id']]['faqs'][$faq['faq_id']] = $faq;
    }  ?>
    <section class="section">
        <div class="container">
            <div class="section-head section-head-center">
                <div class="section__heading">
                    <h2>
                        <?php echo $collection['collection_name']; ?>
                    </h2>
                </div>
            </div>

            <div class="faq-layout-1">
                <ul class="faq" id="myTab" role="tablist">
                    <?php $count = 0;
                    foreach ($faqCategories as $faqCatId => $faqCat) { ?>
                        <li class="faq-item <?php echo ($count == 0) ? 'is-active' : ''; ?>" role="presentation">
                            <button class="faq-links active" id="faq<?php echo $faqCatId; ?>" data-bs-toggle="tab" data-bs-target="#faq<?php echo $faqCatId; ?>" type="button" role="tab" aria-controls="home" aria-selected="true"><?php echo $faqCat['faqcat_name']; ?></button>
                        </li>
                    <?php $count++;
                    } ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <?php foreach ($faqCategories as $faqCatId => $faqCat) { ?>
                        <div class="tab-pane fade show active" id="faq<?php echo $faqCatId; ?>" role="tabpanel" aria-labelledby="faq<?php echo $faqCatId; ?>">
                            <ul class="faq-list" id="faqCollapseParent<?php echo $faqCatId; ?>">
                                <?php
                                $i = 0;
                                foreach ($faqCat['faqs'] as $faqId => $faq) { ?>
                                    <li class="faq-list-item">
                                        <button class="faq-list-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse<?php echo $faqId; ?>" aria-expanded="<?php echo ($i == 0 ? 'true' : 'false'); ?>">
                                            <?php echo $faq['faq_title']; ?>
                                        </button>
                                        <p class="collapse <?php echo ($i == 0 ? 'show' : ''); ?>" id="faqCollapse<?php echo $faqId; ?>" data-parent="#faqCollapseParent<?php echo $faqCatId; ?>">
                                            <span class="faq_data">
                                                <?php echo FatUtility::decodeHtmlEntities($faq['faq_content']); ?>
                                            </span>
                                        </p>
                                    </li>
                                <?php $i++;
                                } ?>
                            </ul>
                        </div>

                    <?php }
                    if (count($faqCategories) > Collections::LIMIT_FAQ_LAYOUT1) { ?>
                </div>
                <div class="section-foot text-center">
                    <a class="btn btn-outline-primary btn-wide" href="<?php echo UrlHelper::generateUrl('custom', 'faq'); ?>"><?php echo Labels::getLabel('LBL_View_All', $siteLangId); ?></a>
                </div>
            </div>
        <?php } ?>
        </div>
    </section>
<?php } ?>
<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>