<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<!-- offcanvas-blog-search -->
<div class="offcanvas offcanvas-top offcanvas-blog-search" tabindex="-1" id="blog-search">
    <div class="blog-search">
        <div class="logo">
            <a>

            </a>
        </div>
        <div class="blog-search-inner">
            <?php $blogSearchFrm->setFormTagAttribute('onSubmit', 'submitBlogSearch(this); return(false);');
            $blogSearchFrm->setFormTagAttribute('class', 'blog-search-form');
            $blogSearchFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
            $blogSearchFrm->developerTags['fld_default_col'] = 12;
            $keywordFld = $blogSearchFrm->getField('keyword');
            $keywordFld->setFieldTagAttribute('class', 'blog-search-input');
            $keywordFld->setFieldTagAttribute('id', 'blogAutoCompleteJs');
            $keywordFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_In_Blogs...'));
            $submitFld = $blogSearchFrm->getField('btnProductSrchSubmit');
            $submitFld->setFieldTagAttribute('class', 'btn');
            echo $blogSearchFrm->getFormTag();
            echo $blogSearchFrm->getFieldHTML('keyword');
            echo $blogSearchFrm->getExternalJS(); ?>
            <div class="search-suggestions" id="blogSuggetionList">
                </ul>
                </form>
            </div>

        </div>
        <button type="button" class="btn btn-close text-reset btn-search-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <script type="application/javascript">
        $(document).on('focus keyup', '#blogAutoCompleteJs', function(e) {
            $('#blogSuggetionList').html("");
            let keyword = $(this).val();
            fcom.updateWithAjax(
                fcom.makeUrl("blog", "autocomplete"), {
                    keyword
                },
                function(t) {
                    $('#blogSuggetionList').html(t.html);
                },
            );
        });
    </script>
</div>