<?php

class TestimonialsController extends MyAppController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function index()
    {
        $this->_template->render();
    }

    public function search()
    {
        $post = FatApp::getPostedData();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : FatUtility::int($post['page']);
        $pageSize = 12;

        $srch = Testimonial::getSearchObject($this->siteLangId, true);
        $srch->addMultipleFields(array('t.*', 't_l.testimonial_title', 't_l.testimonial_text'));
        $srch->addCondition('testimoniallang_testimonial_id', 'is not', 'mysql_func_null', 'and', true);
        $srch->addOrder('testimonial_added_on', 'desc');
        $srch->setPageSize($pageSize);
        $srch->setPageNumber($page);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set('page', $page);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set("list", $records);
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $json['html'] = $this->_template->render(false, false, 'testimonials/search.php', true, false);
        $json['loadMoreBtnHtml'] = $this->_template->render(false, false, 'testimonials/load-more-btn.php', true, false);
        FatUtility::dieJsonSuccess($json);
    }
}
