<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="col-lg-7 faqSectionJs position-relative">
    <?php if (!empty($result)) {
        $catsHtml = '';
        $catsResult = [];
        $quesHtml = '';
        foreach ($result as $index => $faqCat) {
            if (!in_array($faqCat['faqcat_id'], $catsResult)) {
                $catsResult[] = $faqCat['faqcat_id'];
                $catsHtml .= '<a href="javascript:void(0);" onClick="searchFaqs(\'' . $page . '\',' . $faqCat['faqcat_id'] . ');" id="' . $faqCat['faqcat_id'] . '" class="faqCatIdJs ' . (0 == $index ? "is--active" : "") . '">' . $faqCat['faqcat_name'] . '</a>';
            }

            $quesHtml .= '<li class="faq-list-item">
                            <button class="faq-list-link faqHeading" type="button" data-cat-id="' . $faqCat['faqcat_id'] . '" data-bs-toggle="collapse" data-bs-target="#faqCollapse' . $faqCat['faq_id'] . '" data-bs-target="' . $faqCat['faq_id'] . '" data-id="' . $faqCat['faq_id'] . '">' . $faqCat['faq_title'] . '
                            </button>
                            <div class="collapse" id="faqCollapse' . $faqCat['faq_id'] . '">
                                <p class="faq_data">' . $faqCat['faq_content'] . '</p>
                            </div>
                        </li>';
        } ?>
        <div class="faq-filters mb-4" id="categoryPanel">
            <?php echo $catsHtml; ?>
        </div>
        <ul class="faq-list" id="listing">
            <?php echo $quesHtml; ?>
        </ul>
    <?php } else { ?>
        <?php $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId), false);?>
        <div class="faq-filters mb-4" id="categoryPanel"></div>
        <ul class="faq-list" id="listing"></ul>
    <?php } ?>
</div>