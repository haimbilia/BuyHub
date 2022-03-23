<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<!-- offcanvas-blog-search -->
<div class="offcanvas offcanvas-blog-search" data-bs-backdrop="false" tabindex="-1" id="blog-search" aria-labelledby="blog-searchLabel">
    <div class="blog-search">
        <?php $blogSearchFrm->setFormTagAttribute('onSubmit', 'submitBlogSearch(this); return(false);');
        $blogSearchFrm->setFormTagAttribute('class', 'form-search-blog');
        $blogSearchFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
        $blogSearchFrm->developerTags['fld_default_col'] = 12;
        $keywordFld = $blogSearchFrm->getField('keyword');
        $keywordFld->setFieldTagAttribute('class', 'blog-search-input');
        $keywordFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_In_Blogs...'));
        $submitFld = $blogSearchFrm->getField('btnProductSrchSubmit');
        $submitFld->setFieldTagAttribute('class', 'btn');
        echo $blogSearchFrm->getFormTag();
        echo $blogSearchFrm->getFieldHTML('keyword');
        echo $blogSearchFrm->getFieldHTML('btnProductSrchSubmit');
        echo $blogSearchFrm->getExternalJS(); ?>
        </form>
    </div>

    <button type="button" class="btn btn-close text-reset btn-search-close" data-bs-dismiss="offcanvas" aria-label="Close">
    </button>
</div>