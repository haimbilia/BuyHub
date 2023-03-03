<?php defined('SYSTEM_INIT') or die('Invalid usage');
if (!empty($list) && is_array($list)) {
    foreach ($list as $listItem) { ?>
        <li class="faq-list-item">
            <button class="faq-list-link faqHeading" type="button" data-cat-id="<?php echo $listItem['faqcat_id']; ?>" data-bs-toggle="collapse" data-bs-target="#faqCollapse<?php echo $listItem['faq_id']; ?>" data-bs-target="<?php echo $listItem['faq_id']; ?>" data-id="<?php echo $listItem['faq_id']; ?>"><?php echo $listItem['faq_title']; ?>
            </button>
            <div class="collapse" id="faqCollapse<?php echo $listItem['faq_id']; ?>">
                <p class="faq_data faqText"><?php echo (isset($listItem['faq_content']) && !empty($listItem['faq_content'])) ? nl2br($listItem['faq_content']) : ''; ?></p>
            </div>
        </li>
<?php
    }
}

?>

<script>
    $(function() {
        $(document).off("keyup").on("keyup", '#faqQuestionJs', function(e) {
            if (e.which == 13) {
                return;
            }
            // Get user input from search box
            var filter_text = $(this).val();
            if ('' == filter_text && typeof faqRightPanel === 'function') {
                faqRightPanel();
                return;
            }

            $('#listing .faqHeading').each(function() {
                if ('' !== filter_text) {
                    let headingText = $(this).text();
                    var startAt = headingText.toLowerCase().indexOf(filter_text
                        .toLowerCase());

                    if (startAt >= 0) {
                        var endAt = filter_text.length;
                        filter_text = headingText.substr(startAt, endAt);
                        var replaceWith = "<mark>" + filter_text +
                            "</mark>";
                        $(this).html(headingText.replace(filter_text, replaceWith));
                    } else {
                        $(this).text(headingText);
                    }

                    let faqTextEle = $(this).siblings('.faqText');
                    let faqTextContent = faqTextEle.find('p').text();
                    var startAt = faqTextContent.toLowerCase().indexOf(filter_text
                        .toLowerCase());

                    if (startAt >= 0) {
                        var endAt = filter_text.length;
                        filter_text = faqTextContent.substr(startAt, endAt);
                        var replaceWith = "<mark>" + filter_text +
                            "</mark>";
                        faqTextEle.closest('.collapse').collapse('show');
                        faqTextEle.find('p').html(faqTextContent.replace(filter_text, replaceWith));
                    } else {
                        faqTextEle.find('p').text(faqTextContent);
                        faqTextEle.closest('.collapse').collapse('hide');
                    }
                } else {
                    $(this).text($(this).text());
                    $(this).siblings('.faqText').text($(this).siblings('.faqText').find('p').text());
                    $('#listing .faqText').collapse('hide');
                }
            });
        });
    });
</script>