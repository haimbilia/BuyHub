<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
    <section class="section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6">
                    <div class="section-head section-head-center mb-0">
                        <div class="section-heading">
                            <h1><?php echo Labels::getLabel('LBL_Frequently_Asked_Questions', $siteLangId); ?></h1>
                        </div>
                    </div>
                    <div class="faqsearch">
                        <form name="frmSearchFaqs" class="form" action="javascript:void(0);">
                            <input placeholder="Search" class="faq-input no-focus" data-field-caption="Enter your question" type="search" name="question" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="divider"></div>
    <section class="section bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <?php if ($recordCount > 0) { ?>
                        <div class="faq-filters mb-4" id="categoryPanel"></div>
                    <?php } ?>
                    <ul class="faq-list" id="listing"></ul>
                </div>
            </div>
        </div>
    </section>
    <script>
        var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
        var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
    </script>
    <script> 
        $(function() {
            $(document).on("keyup", '.faq-input', function() {
                // Get user input from search box
                var filter_text = $(this).val();
                
                    $('#listing .faqHeading').each(function() {
                        if ('' !== filter_text) {                        
                            let headingText = $(this).text(); 
                            var startAt = headingText.toLowerCase().indexOf(filter_text
                                .toLowerCase());
                           
                            if (startAt >= 0) {
                                var endAt = filter_text.length;                              
                                filter_text = headingText.substr(startAt, endAt);
                                var replaceWith = "<span class='js--highlightText'>" + filter_text +
                                    "</span>";                                                             
                                $(this).html(headingText.replace(filter_text, replaceWith));
                            }else{
                                $(this).text(headingText); 
                            }

                            let faqTextEle = $(this).siblings('.faqText');
                            let faqTextContent = faqTextEle.text();
                            var startAt = faqTextContent.toLowerCase().indexOf(filter_text
                                .toLowerCase());                           

                            if (startAt >= 0) {
                                var endAt = filter_text.length;                                
                                filter_text = faqTextContent.substr(startAt, endAt);
                                var replaceWith = "<span class='js--highlightText'>" + filter_text +
                                    "</span>";                              
                                faqTextEle.collapse('show');
                                faqTextEle.html(faqTextContent.replace(filter_text, replaceWith));
                            } else {
                                faqTextEle.text(faqTextContent);
                                faqTextEle.collapse('hide');
                            }
                        }else {
                            $(this).text($(this).text());                           
                            $(this).siblings('.faqText').text($(this).siblings('.faqText').text());
                            $('#listing .faqText').collapse('hide');
                        } 
                    });                 
            });
        });
    </script>
</div>