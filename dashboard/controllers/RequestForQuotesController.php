<?php
class RequestForQuotesController extends BuyerBaseController
{
    use RequestForQuotesUtility;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->isBuyer = true;
    }

    public function downloadRfqCopy(int $rfqId)
    {
        $srch = new RequestForQuoteSearch();
        $srch->joinBuyer();
        $srch->joinSellers();
        $srch->joinSellerShop($this->siteLangId);
        $srch->joinSellerProduct($this->siteLangId);
        $srch->joinBuyerAddress($this->siteLangId);
        $srch->joinCountry(true);
        $srch->joinState(true);

        $dbFlds = array_merge(RequestForQuote::FIELDS, ['shop_name', 'selprod_updated_on', 'selprod_id', 'selprod_product_id', 'addr_name', 'addr_address1', 'addr_address2', 'addr_city', 'state_name', 'country_name', 'addr_zip', 'addr_phone_dcode', 'addr_phone', 'buc.credential_username as credential_username', 'bu.user_id as user_id', 'bu.user_updated_on', 'credential_email', 'bu.user_name', 'IFNULL(country_name, country_code) as country_name', 'IFNULL(state_name, state_identifier) as state_name']);
        $srch->addMultipleFields($dbFlds);

        $srch->addCondition('rfq_id', '=', $rfqId);
        $srch->addCondition('rfq_user_id', '=', $this->userId);
        $rfqData = FatApp::getDb()->fetch($srch->getDataResultSet());
        // CommonHelper::printArray($rfqData, 1);

        $template = new FatTemplate('', '');
        $template->set('siteLangId', $this->siteLangId);
        $template->set('rfqData', $rfqData);

        require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(FatApp::getConfig("CONF_WEBSITE_NAME_" . $this->siteLangId));
        $pdf->SetKeywords(FatApp::getConfig("CONF_WEBSITE_NAME_" . $this->siteLangId));
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderMargin(0);
        $pdf->SetHeaderData('', 0, '', '', array(255, 255, 255), array(255, 255, 255));
        $pdf->setFooterData(array(0, 0, 0), array(200, 200, 200));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetMargins(10, 10, 10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();
        $pdf->SetTitle(Labels::getLabel('LBL_TAX_INVOICE', $this->siteLangId));
        $pdf->SetSubject(Labels::getLabel('LBL_TAX_INVOICE', $this->siteLangId));

        // set LTR direction for english translation
        $pdf->setRTL(('rtl' == Language::getLayoutDirection($this->siteLangId)));
        // set font
        $pdf->SetFont('dejavusans');

        $templatePath = "request-for-quotes/download-rfq-copy.php";
        $html = $template->render(false, false, $templatePath, true, true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();

        ob_end_clean();
        $pdf->Output($rfqId . '-invoice.pdf', 'I');
        return true;
    }
}
