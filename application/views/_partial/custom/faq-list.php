<?php defined('SYSTEM_INIT') or die('Invalid usage');
if (!empty($list) && is_array($list)) {
    foreach ($list as $listItem) { ?>
        <li class="faq-list-item">
            <button class="faq-list-link faqHeading" type="button" data-cat-id="<?php echo $listItem['faqcat_id']; ?>" data-bs-toggle="collapse" data-bs-target="#faqCollapse<?php echo $listItem['faq_id']; ?>" data-bs-target="<?php echo $listItem['faq_id']; ?>" data-id="<?php echo $listItem['faq_id']; ?>"><?php echo $listItem['faq_title']; ?>
            </button>
            <div class="collapse faqText" id="faqCollapse<?php echo $listItem['faq_id']; ?>">
                <p><?php echo $listItem['faq_content']; ?></p>
            </div>
        </li>
<?php
    }
}
