<?php
class SitemapController extends AdminBaseController
{
    public function generate()
    {
        if ((new Sitemap())->generate()) {
            Message::addMessage(Labels::getLabel('MSG_SITEMAP_HAS_BEEN_UPDATED_SUCCESSFULLY.', $this->siteLangId));
        } else {
            Message::addErrorMessage(Labels::getLabel('MSG_UNABLE_TO_UPDATE_SITEMAP.', $this->siteLangId));
        }
        CommonHelper::redirectUserReferer();
    }
}
