<?php

use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Html;

class ConfigurationsController extends AdminBaseController
{
    /* these variables must be only those which will store array type data and will saved as serialized array [*/
    private array $serializeArrayValues = ['CONF_VENDOR_ORDER_STATUS', 'CONF_BUYER_ORDER_STATUS', 'CONF_PROCESSING_ORDER_STATUS', 'CONF_COMPLETED_ORDER_STATUS', 'CONF_REVIEW_READY_ORDER_STATUS', 'CONF_ALLOW_CANCELLATION_ORDER_STATUS', 'CONF_DIGITAL_ALLOW_CANCELLATION_ORDER_STATUS', 'CONF_RETURN_EXCHANGE_READY_ORDER_STATUS', 'CONF_DIGITAL_RETURN_READY_ORDER_STATUS', 'CONF_ENABLE_DIGITAL_DOWNLOADS', 'CONF_PURCHASE_ORDER_STATUS', 'CONF_BUYING_YEAR_REWARD_ORDER_STATUS', 'CONF_SUBSCRIPTION_ORDER_STATUS', 'CONF_SELLER_SUBSCRIPTION_STATUS', 'CONF_BADGE_COUNT_ORDER_STATUS', 'CONF_PRODUCT_IS_ON_ORDER_STATUSES', 'CONF_ALLOW_FILES_TO_ADD_WITH_ORDER_STATUSES'];
    /* ] */

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewGeneralSettings();
        $this->set("includeEditor", true);
    }

    public function index()
    {
        $this->setGeneralForm(Configurations::FORM_GENERAL, $this->getDefaultFormLangId());
        $svgIconNames = Configurations::getSvgIconNames();
        $this->set('svgIconNames', $svgIconNames);
        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs('js/cropper.js');
        $this->_template->addJs('js/cropper-main.js');
        $this->set('defaultLangId', $this->getDefaultFormLangId());
        $this->set('activeTab', Configurations::FORM_GENERAL);
        $this->_template->addJs('js/jscolor.js');
        $this->_template->render();
    }

    public function setGeneralForm($frmType, $langId)
    {
        $record = Configurations::getConfigurations();
        $arrayValues = array();

        foreach ($this->serializeArrayValues as $val) {
            if (array_key_exists($val, $record)) {
                $data = @unserialize($record[$val]);
                if ($data !== false) {
                    $arrayValues[$val] = $data;
                    unset($record[$val]);
                }
            } else {
                $arrayValues[$val] = array();
            }
        }

        $frm = $this->getForm($frmType, $langId);
        if (array_key_exists('CONF_SITE_FAX_DCODE', $record)) {
            $record['CONF_SITE_FAX_dcode'] = $record['CONF_SITE_FAX_DCODE'];
            unset($record['CONF_SITE_FAX_DCODE']);
        }

        if (array_key_exists('CONF_SITE_PHONE_DCODE', $record)) {
            $record['CONF_SITE_PHONE_dcode'] = $record['CONF_SITE_PHONE_DCODE'];
            unset($record['CONF_SITE_PHONE_DCODE']);
        }

        $frm->fill(($record + $arrayValues));

        $this->set('frm', $frm);
        $this->set('record', $record);
        $this->set('frmType', $frmType);

        $dispLangTab = false;
        if (in_array($frmType, Configurations::getLangTypeFormArr())) {
            $dispLangTab = true;
            $this->set('languages', Language::getAllNames());
        }

        $tabs = Configurations::getTabsArr();
        $this->set('tabs', $tabs);
        $this->set('dispLangTab', $dispLangTab);
        $this->set('lang_id', $langId);
        $this->set('formLayout', Language::getLayoutDirection($langId));
    }

    public function form(int $frmType, int $langId = 0)
    {
        if(1 > $langId ){
            $langId = $this->getDefaultFormLangId();
        }
        $this->setGeneralForm($frmType, $langId);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditGeneralSettings();

        $post = FatApp::getPostedData();
        $langId  = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $user_state_id = 0;
        if (isset($post['CONF_STATE'])) {
            $user_state_id = FatUtility::int($post['CONF_STATE']);
        }

        if (isset($post['CONF_GEO_DEFAULT_STATE'])) {
            $geoState = $post['CONF_GEO_DEFAULT_STATE'];
        }

        $frmType = FatUtility::int($post['form_type']);

        if (1 > $frmType) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (in_array($frmType, Configurations::getLangTypeFormArr())) {
            if(1 > $langId){
                LibHelper::exitWithError($this->str_invalid_request, true);
            }            
        }

        $frm = $this->getForm($frmType, $langId);
        $post = $frm->getFormDataFromArray($post);
        if ($user_state_id > 0) {
            $post['CONF_STATE'] = $user_state_id;
        }
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        unset($post['form_type']);
        unset($post['btn_submit']);
        foreach ($this->serializeArrayValues as $val) {
            if (array_key_exists($val, $post)) {
                if (is_array($post[$val])) {
                    $post[$val] = serialize($post[$val]);
                }
            } else {
                if (isset($post[$val])) {
                    $post[$val] = 0;
                }
            }
        }

        if (!empty($geoState)) {
            $post['CONF_GEO_DEFAULT_STATE'] = $geoState;
        }

        $record = new Configurations();

        if (isset($post["CONF_SEND_SMTP_EMAIL"]) && $post["CONF_SEND_EMAIL"] && $post["CONF_SEND_SMTP_EMAIL"] && (($post["CONF_SEND_SMTP_EMAIL"] != FatApp::getConfig("CONF_SEND_SMTP_EMAIL")) || ($post["CONF_SMTP_HOST"] != FatApp::getConfig("CONF_SMTP_HOST")) || ($post["CONF_SMTP_PORT"] != FatApp::getConfig("CONF_SMTP_PORT")) || ($post["CONF_SMTP_USERNAME"] != FatApp::getConfig("CONF_SMTP_USERNAME")) || ($post["CONF_SMTP_SECURE"] != FatApp::getConfig("CONF_SMTP_SECURE")) || ($post["CONF_SMTP_PASSWORD"] != FatApp::getConfig("CONF_SMTP_PASSWORD")))) {
            $smtp_arr = [
                "host" => $post["CONF_SMTP_HOST"],
                "port" => $post["CONF_SMTP_PORT"],
                "username" => $post["CONF_SMTP_USERNAME"],
                "password" => $post["CONF_SMTP_PASSWORD"],
                "secure" => $post["CONF_SMTP_SECURE"]
            ];

            if (EmailHandler::sendSmtpTestEmail($this->siteLangId, $smtp_arr)) {
                Message::addMessage(Labels::getLabel('LBL_We_have_sent_a_test_email_to_administrator_account' . FatApp::getConfig("CONF_SITE_OWNER_EMAIL"), $this->siteLangId));
            } else {
                unset($post["CONF_SEND_SMTP_EMAIL"]);
                foreach ($smtp_arr as $skey => $sval) {
                    unset($post['CONF_SMTP_' . strtoupper($skey)]);
                }
                LibHelper::exitWithError(Labels::getLabel("LBL_SMTP_settings_provided_is_invalid_or_unable_to_send_email_so_we_have_not_saved_SMTP_settings", $this->siteLangId), true);
            }
        }

        if (isset($post['CONF_USE_SSL']) && $post['CONF_USE_SSL'] == 1) {
            if (!$this->isSslEnabled()) {
                if ($post['CONF_USE_SSL'] != FatApp::getConfig('CONF_USE_SSL')) {
                    LibHelper::exitWithError(Labels::getLabel('MSG_SSL_NOT_INSTALLED_FOR_WEBSITE_Try_to_Save_data_without_Enabling_ssl', $this->siteLangId), true);
                }

                unset($post['CONF_USE_SSL']);
            }
        }

        if (isset($post['CONF_SITE_ROBOTS_TXT'])) {
            $filePath = CONF_UPLOADS_PATH . 'robots.txt';
            $robotfile = fopen($filePath, "w");
            fwrite($robotfile, $post['CONF_SITE_ROBOTS_TXT']);
            fclose($robotfile);
        }

        if (array_key_exists('CONF_CURRENCY', $post)) {
            $data = Currency::getAttributesById($post['CONF_CURRENCY']);
            if (empty($data) || ($data['currency_value'] * 1) != 1) {
                LibHelper::exitWithError(Labels::getLabel('MSG_Please_set_default_currency_value_to_1', $this->siteLangId), true);
            }
        }

        if (!$record->update($post)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Setup_Successful', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateMaintenanceMode(){
        
    }

    private function isSslEnabled()
    {

        // url connection
        $url = "https://" . $_SERVER["HTTP_HOST"];

        // Initiate connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); // set browser/user agent
        // Set cURL and other options
        curl_setopt($ch, CURLOPT_URL, $url); // set url
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // allow https verification if true
        curl_setopt($ch, CURLOPT_NOBODY, true);
        // grab URL and pass it to the browser
        $res = curl_exec($ch);
        if (!$res) {
            return false;
        }
        return true;
    }

    public function uploadMedia()
    {
        $this->objPrivilege->canEditGeneralSettings();
        $post = FatApp::getPostedData();

        if (empty($post)) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Request_Or_File_not_supported', $this->siteLangId), true);
        }
        $file_type = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $aspectRatio = FatApp::getPostedData('ratio_type', FatUtility::VAR_INT, 0);

        if (!$file_type) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $allowedFileTypeArr = array(
            AttachedFile::FILETYPE_ADMIN_LOGO,
            AttachedFile::FILETYPE_FRONT_LOGO,
            AttachedFile::FILETYPE_EMAIL_LOGO,
            AttachedFile::FILETYPE_FAVICON,
            AttachedFile::FILETYPE_SOCIAL_FEED_IMAGE,
            AttachedFile::FILETYPE_PAYMENT_PAGE_LOGO,
            AttachedFile::FILETYPE_WATERMARK_IMAGE,
            AttachedFile::FILETYPE_APPLE_TOUCH_ICON,
            AttachedFile::FILETYPE_MOBILE_LOGO,
            AttachedFile::FILETYPE_CATEGORY_COLLECTION_BG_IMAGE,
            AttachedFile::FILETYPE_BRAND_COLLECTION_BG_IMAGE,
            AttachedFile::FILETYPE_INVOICE_LOGO,
            AttachedFile::FILETYPE_APP_MAIN_SCREEN_IMAGE,
            AttachedFile::FILETYPE_APP_LOGO,
            AttachedFile::FILETYPE_FIRST_PURCHASE_DISCOUNT_IMAGE,
            AttachedFile::FILETYPE_META_IMAGE,
        );

        if (!in_array($file_type, $allowedFileTypeArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('MSG_Please_Select_A_File', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        if (!$res = $fileHandlerObj->saveImage($_FILES['cropped_image']['tmp_name'], $file_type, 0, 0, $_FILES['cropped_image']['name'], -1, true, $lang_id, '', 0, $aspectRatio)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('frmType', Configurations::FORM_GENERAL);
        $this->set('msg', $_FILES['cropped_image']['name'] . Labels::getLabel('MSG_Uploaded_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function redirect()
    {
        include_once CONF_INSTALLATION_PATH . 'library/analytics/analyticsapi.php';
        $analyticArr = array(
            'clientId' => FatApp::getConfig("CONF_ANALYTICS_CLIENT_ID"),
            'clientSecretKey' => FatApp::getConfig("CONF_ANALYTICS_SECRET_KEY"),
            'redirectUri' => UrlHelper::generateFullUrl('configurations', 'redirect', array(), '', false),
            'googleAnalyticsID' => FatApp::getConfig("CONF_ANALYTICS_ID")
        );
        try {
            $analytics = new Ykart_analytics($analyticArr);
            $obj = FatApplication::getInstance();
            $get = $obj->getQueryStringVar();
        } catch (exception $e) {
            Message::addErrorMessage($e->getMessage());
        }

        if (isset($get['code']) && isset($get['code']) != '') {
            $code = $get['code'];
            $auth = $analytics->getAccessToken($code);
            if ($auth['refreshToken'] != '') {
                $arr = array('CONF_ANALYTICS_ACCESS_TOKEN' => $auth['refreshToken']);
                $record = new Configurations();
                if (!$record->update($arr)) {
                    Message::addErrorMessage($record->getError());
                } else {
                    Message::addMessage(Labels::getLabel('MSG_Setting_Updated_Successfully', $this->siteLangId));
                }
            } else {
                Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access_Token', $this->siteLangId));
            }
        } else {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }
        FatApp::redirectUser(UrlHelper::generateUrl('configurations', 'index'));
    }

    public function removeMediaImage($file_type, $lang_id = 0)
    {
        $this->objPrivilege->canEditGeneralSettings();

        $fileType = FatUtility::int($file_type);
        $lang_id = FatUtility::int($lang_id);

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile($fileType, 0, 0, 0, $lang_id)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Deleted_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($type, $langId)
    {
        $frm = new Form('frmConfiguration');
        switch ($type) {
            case Configurations::FORM_GENERAL:

                $frm->addTextBox(Labels::getLabel("LBL_Site_Name", $langId), 'CONF_WEBSITE_NAME_' . $langId);
                $frm->addTextBox(Labels::getLabel("LBL_Site_Owner", $langId), 'CONF_SITE_OWNER_' . $langId);
                $fld = $frm->addTextarea(Labels::getLabel('LBL_Cookies_Policies_Text', $langId), 'CONF_COOKIES_TEXT_' . $langId);
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $frm->addEmailField(Labels::getLabel('LBL_Store_Owner_Email', $langId), 'CONF_SITE_OWNER_EMAIL');
                $frm->addHiddenField('', 'CONF_SITE_PHONE_dcode');
                $phnFld = $frm->addTextBox(Labels::getLabel('LBL_Telephone', $langId), 'CONF_SITE_PHONE', '', array('class' => 'phone-js ltr-right', 'placeholder' => ValidateElement::PHONE_NO_FORMAT, 'maxlength' => ValidateElement::PHONE_NO_LENGTH));
                $phnFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
                $phnFld->requirements()->setCustomErrorMessage(Labels::getLabel('LBL_Please_enter_valid_format.', $langId));

                $frm->addHiddenField('', 'CONF_SITE_FAX_dcode');
                $faxFld = $frm->addTextBox(Labels::getLabel('LBL_Fax', $langId), 'CONF_SITE_FAX', '', array('class' => 'phone-js ltr-right', 'placeholder' => ValidateElement::PHONE_NO_FORMAT, 'maxlength' => ValidateElement::PHONE_NO_LENGTH));
                $faxFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
                $faxFld->requirements()->setCustomErrorMessage(Labels::getLabel('LBL_Please_enter_valid_format.', $langId));

                $cpagesArr = ContentPage::getPagesForSelectBox($langId);

                $frm->addSelectBox(Labels::getLabel('LBL_About_Us', $langId), 'CONF_ABOUT_US_PAGE', $cpagesArr, '', [], Labels::getLabel('LBL_Select', $langId));
                $frm->addSelectBox(Labels::getLabel('LBL_Privacy_Policy_Page', $langId), 'CONF_PRIVACY_POLICY_PAGE', $cpagesArr, '', [], Labels::getLabel('LBL_Select', $langId));
                $frm->addSelectBox(Labels::getLabel('LBL_Terms_and_Conditions_Page', $langId), 'CONF_TERMS_AND_CONDITIONS_PAGE', $cpagesArr, '', [], Labels::getLabel('LBL_Select', $langId));
                $frm->addSelectBox(Labels::getLabel('LBL_GDPR_policy_page', $langId), 'CONF_GDPR_POLICY_PAGE', $cpagesArr, '', [], Labels::getLabel('LBL_Select', $langId));

                $frm->addSelectBox(Labels::getLabel('LBL_Cookies_Policies_Page', $langId), 'CONF_COOKIES_BUTTON_LINK', $cpagesArr, '', [], Labels::getLabel('LBL_Select', $langId));

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Header_Mega_Menu", $langId), 'CONF_LAYOUT_MEGA_MENU', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld);
                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Home_page_loader", $langId), 'CONF_LOADER', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld);

                $fld = $frm->addCheckBox(Labels::getLabel('LBL_Cookies_Policies', $langId), 'CONF_ENABLE_COOKIES', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_cookies_policies_section_will_be_shown_on_frontend", $langId));

                /* $fld3 = $frm->addTextBox(Labels::getLabel("LBL_Admin_Default_Items_Per_Page", $langId), "CONF_ADMIN_PAGESIZE");
                $fld3->requirements()->setInt();
                $fld3->requirements()->setRange('1', '2000');
                $fld3->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Determines_how_many_items_are_shown_per_page_(user_listing,_categories,_etc)", $langId) . ".</span>"; */

                $iframeFld = $frm->addTextarea(Labels::getLabel('LBL_Google_Map_Iframe', $langId), 'CONF_MAP_IFRAME_CODE');
                $iframeFld->developerTags['colWidthValues'] = [null, '12', null, null];
                $iframeFld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("LBL_This_is_the_Gogle_Map_Iframe_Script,_used_to_display_google_map_on_contact_us_page", $langId) . '</span>';

                break;

            case Configurations::FORM_LOCAL:

                $frm->addTextarea(Labels::getLabel("LBL_Address", $langId), 'CONF_ADDRESS_' . $langId);
                $frm->addTextarea(Labels::getLabel("LBL_ADDRESS_LINE_2", $langId), 'CONF_ADDRESS_LINE_2_' . $langId);
                $frm->addTextBox(Labels::getLabel("LBL_City", $langId), 'CONF_CITY_' . $langId);
                $frm->addSelectBox(
                    Labels::getLabel('LBL_Default_Site_Laguage', $langId),
                    'CONF_DEFAULT_SITE_LANG',
                    Language::getAllNames(),
                    false,
                    array(),
                    ''
                );

                $fld = $frm->addSelectBox(Labels::getLabel('LBL_Timezone', $langId), 'CONF_TIMEZONE', Configurations::dateTimeZoneArr(), false, array(), '');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("LBL_Current", $langId) . ' <span id="currentDate">' . CommonHelper::currentDateTime(null, true) . '</span></span>';
                $countryObj = new Countries();
                $countriesArr = $countryObj->getCountriesAssocArr($langId);
                $fld = $frm->addSelectBox(Labels::getLabel('LBL_Country', $langId), 'CONF_COUNTRY', $countriesArr, '', ['id' =>'user_country_id','onChange'=>'getCountryStates(this.value,' . FatApp::getConfig('CONF_STATE', FatUtility::VAR_INT, 1) . ',\'#user_state_id\')'], Labels::getLabel('LBL_Select', $langId));

                $frm->addSelectBox(Labels::getLabel('LBL_State', $langId), 'CONF_STATE', array(), '', ['id' =>'user_state_id'], Labels::getLabel('LBL_Select', $langId));
                $frm->addRequiredField(Labels::getLabel("LBL_Postal_Code", $langId), 'CONF_ZIP_CODE');
                $frm->addSelectBox(Labels::getLabel('LBL_date_Format', $langId), 'CONF_DATE_FORMAT', Configurations::dateFormatPhpArr(), false, array(), '');

                $currencyArr = Currency::getCurrencyNameWithCode($langId);
                $frm->addSelectBox(Labels::getLabel('LBL_Default_System_Currency', $langId), 'CONF_CURRENCY', $currencyArr, false, array(), '');

                $currencySeparatorArr = applicationConstants::currencySeparatorArr($langId);
                $frm->addSelectBox(Labels::getLabel('LBL_Default_Currency_Decimal_Separator', $langId), 'CONF_DEFAULT_CURRENCY_SEPARATOR', $currencySeparatorArr, false, array(), '');


                $faqCategoriesArr = FaqCategory::getFaqPageCategories();
                $sellerCategoriesArr = FaqCategory::getSellerPageCategories();

                $frm->addSelectBox(Labels::getLabel('LBL_Faq_Page_Main_Category', $langId), 'CONF_FAQ_PAGE_MAIN_CATEGORY', $faqCategoriesArr, '', [], Labels::getLabel('LBL_Select', $langId));
                $frm->addSelectBox(Labels::getLabel('LBL_Seller_Page_Main_Faq_Category', $langId), 'CONF_SELLER_PAGE_MAIN_CATEGORY', $sellerCategoriesArr, '', [], Labels::getLabel('LBL_Select', $langId));

                break;

            case Configurations::FORM_SEO:
                $fld = $frm->addCheckBox(Labels::getLabel('LBL_ENABLE_LANGUAGE_CODE_TO_SITE_URLS_&_LANGUAGE_SPECIFIC_URL_REWRITING', $langId), 'CONF_LANG_SPECIFIC_URL', 1, array(), false, 0);
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_LANGUAGE_CODE_TO_SITE_URLS_EXAMPLES", $langId));
                

                $fld = $frm->addTextBox(Labels::getLabel('LBL_Twitter_Username', $langId), 'CONF_TWITTER_USERNAME');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("LBL_This_is_required_for_Twitter_Card_code_SEO_Update", $langId) . '</span>';

                $fld2 = $frm->addTextarea(Labels::getLabel('LBL_Site_Tracker_Code', $langId), 'CONF_SITE_TRACKER_CODE');
                $fld2->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld2->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("LBL_This_is_the_site_tracker_script,_used_to_track_and_analyze_data_about_how_people_are_getting_to_your_website._e.g.,_Google_Analytics.", $langId) . ' http://www.google.com/analytics/</span>';

                $robotsFld = $frm->addTextarea(Labels::getLabel('LBL_Robots_Txt', $langId), 'CONF_SITE_ROBOTS_TXT');
                $robotsFld->developerTags['colWidthValues'] = [null, '12', null, null];
                $robotsFld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("LBL_This_will_update_your_Robots.txt_file._This_is_to_help_search_engines_index_your_site_more_appropriately.", $langId) . '</span>';

                $fld = $frm->addHtml('', 'seperatorGoogleTag', '<div class="separator separator-dashed my-2"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addHtml('', 'googleTagManager', '<h3 class="form-section-head">' . Labels::getLabel("LBL_Google_Tag_Manager", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addTextarea(Labels::getLabel("LBL_Head_Script", $langId), 'CONF_GOOGLE_TAG_MANAGER_HEAD_SCRIPT');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_code_provided_by_google_tag_manager_for_integration.", $langId) . "</span>";

                $fld = $frm->addTextarea(Labels::getLabel("LBL_Body_Script", $langId), 'CONF_GOOGLE_TAG_MANAGER_BODY_SCRIPT');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_code_provided_by_google_tag_manager_for_integration.", $langId) . "</span>";
                $fld = $frm->addHtml('', 'googlewebmaster', '<div class="separator separator-dashed my-2"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addHtml('', 'googleFileVerification', '<h3 class="form-section-head">' . Labels::getLabel("LBL_Google_Webmaster", $langId) . '</h3>');
                $htmlAfterField = '';
                if (file_exists(CONF_UPLOADS_PATH . '/google-site-verification.html')) {
                    $htmlAfterField .= $fld->htmlAfterField = '<a href="' . UrlHelper::generateFullUrl('', '', array(), CONF_WEBROOT_FRONT_URL) . 'google-site-verification.html" target="_blank" class="btn btn-clean btn-sm btn-icon" title="' . Labels::getLabel("LBL_View_File", $langId) . '"><i class="fas fa-eye icon"></i></a><a href="javascript:void();" class="btn btn-clean btn-sm btn-icon" title="' . Labels::getLabel("LBL_Delete_File", $langId) . '" onclick="deleteVerificationFile(\'google\')"><i class="fa fa-trash  icon"></i></a>';
                }
                $htmlAfterField .= "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Upload_HTML_file_provided_by_Google_webmaster_tool.", $langId) . "</span>";
                $fld->htmlAfterField = $htmlAfterField;

                $fld = $frm->addHtml('', 'bingFileVerification', '<h3 class="form-section-head">' . Labels::getLabel("LBL_Bing_Webmaster", $langId) . '</h3>');
                $htmlAfterField = '';
                if (file_exists(CONF_UPLOADS_PATH . '/BingSiteAuth.xml')) {
                    $htmlAfterField .= $fld->htmlAfterField = '<a href="' . UrlHelper::generateFullUrl('', '', array(), CONF_WEBROOT_FRONT_URL) . 'BingSiteAuth.xml' . '" target="_blank" class="btn btn-clean btn-sm btn-icon" title="' . Labels::getLabel("LBL_View_File", $langId) . '"><i class="fas fa-eye icon"></i></a><a href="javascript:void();" class="btn btn-clean btn-sm btn-icon" title="' . Labels::getLabel("LBL_Delete_File", $langId) . '" onclick="deleteVerificationFile(\'bing\')"><i class="fa fa-trash  icon"></i></a>';
                }
                $htmlAfterField .= "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Upload_BindSiteAuthXML_file_provided_by_Bing_webmaster_tool.", $langId) . "</span>";
                $fld->htmlAfterField = $htmlAfterField;

                $frm->addFileUpload(Labels::getLabel('LBL_HTML_file_Verification', $langId), 'google_file_verification', array('accept' => '.html', 'onChange' => 'updateVerificationFile(this, "google")'));
                $frm->addFileUpload(Labels::getLabel('LBL_XML_file_Authentication', $langId), 'bing_file_verification', array('accept' => '.xml', 'onChange' => 'updateVerificationFile(this, "bing")'));

                $fld = $frm->addHtml('', 'hotjar', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Hotjar", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addTextarea(Labels::getLabel("LBL_Head_Script", $langId), 'CONF_HOTJAR_HEAD_SCRIPT');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_code_provided_by_hotjar_for_integration.", $langId) . "</span>";

                $fld = $frm->addHtml('', 'schemacode', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Schema_COdes", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addTextarea(Labels::getLabel("LBL_Default_Schema", $langId), 'CONF_DEFAULT_SCHEMA_CODES_SCRIPT');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Update_Schema_code_related_information.", $langId) . "</span>";

                break;

            case Configurations::FORM_PRODUCT:
                // $frm->addHtml('', 'Product', '<h3 class="form-section-head">' . Labels::getLabel('LBL_Product', $langId) . '</h3>');

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Allow_Sellers_to_add_products", $langId),
                    'CONF_ENABLED_SELLER_CUSTOM_PRODUCT',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld);

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Enable_Admin_Approval_on_Products_added_by_sellers", $langId),
                    'CONF_CUSTOM_PRODUCT_REQUIRE_ADMIN_APPROVAL',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld);

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_ALLOW_SELLERS_TO_REQUEST_PRODUCTS_WHICH_ARE_AVAILABLE_TO_ALL_SELLERS", $langId),
                    'CONF_SELLER_CAN_REQUEST_CUSTOM_PRODUCT',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld);

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Adding_Model_#_for_products_will_be_mandatory", $langId), 'CONF_PRODUCT_MODEL_MANDATORY', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld);

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Adding_SKU_for_products_will_be_mandatory", $langId), 'CONF_PRODUCT_SKU_MANDATORY', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld);

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Enable_linking_shipping_packages_to_products", $langId), 'CONF_PRODUCT_DIMENSIONS_ENABLE', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_Shipping_packages_are_required_in_case_Shipping_API_is_enabled", $langId));

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Brands_requested_by_sellers_will_require_approval", $langId), 'CONF_BRAND_REQUEST_APPROVAL', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_Enabling_This_Feature,_Admin_Need_To_Approve_the_brand_requests_(User_Cannot_link_the_requested_brand_with_any_product_until_it_gets_approved_by_Admin)", $langId));

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Categories_requested_by_sellers_will_require_approval", $langId), 'CONF_PRODUCT_CATEGORY_REQUEST_APPROVAL', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_Enabling_This_Feature,_Admin_Need_To_Approve_the_Product_category_requests_(User_Cannot_link_the_requested_category_with_any_product_until_it_gets_approved_by_Admin)", $langId));


                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Brand_will_be_mandatory_for_products", $langId), 'CONF_PRODUCT_BRAND_MANDATORY', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld);

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Product_prices_will_be_inclusive_of_tax", $langId), 'CONF_PRODUCT_INCLUSIVE_TAX', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld);

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Enable_tax_code_for_categories", $langId), 'CONF_TAX_CATEGORIES_CODE', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_This_will_enable_tax_categories_code", $langId));

                $fulFillmentArr = Shipping::getFulFillmentArr($langId);
                $frm->addSelectBox(Labels::getLabel('LBL_FULFILLMENT_METHOD', $langId), 'CONF_FULFILLMENT_TYPE', $fulFillmentArr, applicationConstants::NO, array(), '');

                $fld3 = $frm->addTextBox(Labels::getLabel("LBL_Default_Items_Per_Page_(Catalog)", $langId), "CONF_ITEMS_PER_PAGE_CATALOG");
                $fld3->requirements()->setInt();
                $fld3->requirements()->setRange('1', '2000');
                $fld3->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Determines_how_many_catalog_items_are_shown_per_page_(products,_categories,_etc)", $langId) . ".</span>";

                $fld = $frm->addHtml('', 'geolocation', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel('LBL_Location', $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addCheckBox(Labels::getLabel("LBL_ACTIVATE_GEO_LOCATION", $langId), 'CONF_ENABLE_GEO_LOCATION', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld);

                $prodGeoSettingArr = applicationConstants::getProductListingSettings($langId);

                $shippingServiceActive = Plugin::isActiveByType(Plugin::TYPE_SHIPPING_SERVICES);
                if ($shippingServiceActive) {
                    unset($prodGeoSettingArr[applicationConstants::BASED_ON_DELIVERY_LOCATION]);
                }
                $fld = $frm->addRadioButtons(
                    Labels::getLabel("LBL_PRODUCT_LISTING", $langId),
                    'CONF_PRODUCT_GEO_LOCATION',
                    $prodGeoSettingArr,
                    '',
                    array('class' => 'list-radio geoLocation')
                );
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                HtmlHelper::configureSwitchForRadio($fld);
                // $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_DISPLAY_AND_SEARCH_PRODUCTS_BASED_ON_LOCATION", $langId) . "</span>";

                $fld = $frm->addRadioButtons(
                    Labels::getLabel("LBL_PRODUCT_LISTING_FILTER", $langId),
                    'CONF_LOCATION_LEVEL',
                    applicationConstants::getLocationLevels($langId),
                    '',
                    array('class' => 'list-radio listingFilter')
                );   
                if (FatApp::getConfig('CONF_PRODUCT_GEO_LOCATION', FatUtility::VAR_INT, 0) == applicationConstants::BASED_ON_RADIUS) {
                    $fld->setFieldTagAttribute('disabled', 'disabled');
                }

                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                HtmlHelper::configureSwitchForRadio($fld, Labels::getLabel("LBL_DISPLAY_AND_SEARCH_PRODUCTS_BASED_ON_CRITERIA", $langId));

                $fld = $frm->addTextBox(Labels::getLabel('LBL_RADIUS_MAX_DISTANCE_IN_MILES', $langId), 'CONF_RADIUS_DISTANCE_IN_MILES');
                $fld->requirements()->setInt();
                if (FatApp::getConfig('CONF_PRODUCT_GEO_LOCATION', FatUtility::VAR_INT, 0) != applicationConstants::BASED_ON_RADIUS) {                  
                    $fld->setFieldTagAttribute('disabled', 'disabled');
                }

                $fld = $frm->addRadioButtons(
                    Labels::getLabel("LBL_SET_DEFAULT_GEO_LOCATION", $langId),
                    'CONF_DEFAULT_GEO_LOCATION',
                    applicationConstants::getYesNoArr($langId),
                    '0',
                    array('class' => 'list-radio defaultLocationGeoFilter')
                );
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                HtmlHelper::configureSwitchForRadio($fld, Labels::getLabel("LBL_SET_DEFAULT_LOCATION_FOR_PRODUCT_LISTING", $langId));

                $countryObj = new Countries();
                $countriesArr = $countryObj->getCountriesAssocArr($langId, true, 'country_code');
                $countryFld = $frm->addSelectBox(Labels::getLabel('LBL_Country', $langId), 'CONF_GEO_DEFAULT_COUNTRY', $countriesArr, '', [], Labels::getLabel('LBL_Select', $langId));
                $countryFld->setFieldTagAttribute('id', 'geo_country_code');
                $countryFld->setFieldTagAttribute('onChange', 'getStatesByCountryCode(this.value,' . FatApp::getConfig('CONF_GEO_DEFAULT_STATE', FatUtility::VAR_STRING, 1) . ',\'#geo_state_code\', \'state_code\')');

                $stateFld = $frm->addSelectBox(Labels::getLabel('LBL_State', $langId), 'CONF_GEO_DEFAULT_STATE', array(), '', [], Labels::getLabel('LBL_Select', $langId));
                $stateFld->setFieldTagAttribute('id', 'geo_state_code');

                $zipFld = $frm->addTextBox(Labels::getLabel("LBL_Postal_Code", $langId), 'CONF_GEO_DEFAULT_ZIPCODE','',['id'=>'geo_postal_code']);
                $frm->addHiddenField('', 'CONF_GEO_DEFAULT_LAT', FatApp::getConfig('CONF_GEO_DEFAULT_LAT', FatUtility::VAR_INT, 40.72 , ['id' => 'lat']));
                $frm->addHiddenField('', 'CONF_GEO_DEFAULT_LNG', FatApp::getConfig('CONF_GEO_DEFAULT_LNG', FatUtility::VAR_INT, -73.96, ['id' => 'lng']));
                $frm->addHiddenField('', 'CONF_GEO_DEFAULT_ADDR', FatApp::getConfig('CONF_GEO_DEFAULT_ADDR', FatUtility::VAR_STRING, '',['id' => 'geo_city']));

                if (FatApp::getConfig('CONF_DEFAULT_GEO_LOCATION', FatUtility::VAR_INT, 0) != applicationConstants::YES) {
                    $countryFld->setFieldTagAttribute('disabled', 'disabled');
                    $stateFld->setFieldTagAttribute('disabled', 'disabled');
                    $zipFld->setFieldTagAttribute('disabled', 'disabled');
                }

                break;

            case Configurations::FORM_USER_ACCOUNT:
                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Activate_Admin_Approval_After_Registration_(Sign_Up)", $langId),
                    'CONF_ADMIN_APPROVAL_REGISTRATION',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_this_feature,_admin_need_to_approve_each_user_after_registration_(User_cannot_login_until_admin_approves)", $langId));

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Activate_Email_Verification_After_Registration", $langId),
                    'CONF_EMAIL_VERIFICATION_REGISTRATION',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_user_need_to_verify_their_email_address_provided_during_registration", $langId));


                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Activate_Notify_Administrator_on_Each_Registration", $langId),
                    'CONF_NOTIFY_ADMIN_REGISTRATION',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_this_feature,_notification_mail_will_be_sent_to_administrator_on_each_registration.", $langId));

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Activate_Auto_Login_After_Registration", $langId),
                    'CONF_AUTO_LOGIN_REGISTRATION',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_this_feature,_users_will_be_automatically_logged-in_after_registration", $langId));

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Activate_Sending_Welcome_Mail_After_Registration", $langId),
                    'CONF_WELCOME_EMAIL_REGISTRATION',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_this_feature,_users_will_receive_a_welcome_mail_after_registration.", $langId));

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Activate_Separate_Seller_Sign_Up_Form", $langId),
                    'CONF_ACTIVATE_SEPARATE_SIGNUP_FORM',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_this_feature,_buyers_and_seller_will_have_a_separate_sign_up_form.", $langId));

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Activate_Administrator_Approval_On_Seller_Request", $langId),
                    'CONF_ADMIN_APPROVAL_SUPPLIER_REGISTRATION',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_this_feature,_admin_need_to_approve_Seller's_request_after_registration", $langId));

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Buyers_can_see_Seller_Tab", $langId),
                    'CONF_BUYER_CAN_SEE_SELLER_TAB',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_this_feature,_buyers_will_be_able_to_see_Seller_tab", $langId));

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Max_Seller_Request_Attempts", $langId), 'CONF_MAX_SUPPLIER_REQUEST_ATTEMPT', '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Maximum_seller_request_attempts_allowed", $langId) . "</span>";

                $fld = $frm->addHtml('', 'Withdrawal', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Withdrawal", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Minimum_Withdrawal_Amount", $langId) . ' [' . $this->siteDefaultCurrencyCode . ']', 'CONF_MIN_WITHDRAW_LIMIT', '');
                $fld->htmlAfterField = "<span class='form-text text-muted'> " . Labels::getLabel("LBL_This_is_the_minimum_withdrawable_amount.", $langId) . "</span>";

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Maximum_Withdrawal_Amount", $langId) . ' [' . $this->siteDefaultCurrencyCode . ']', 'CONF_MAX_WITHDRAW_LIMIT', '');
                $fld->htmlAfterField = "<span class='form-text text-muted'> " . Labels::getLabel("LBL_This_is_the_maximum_withdrawable_amount.", $langId) . "</span>";

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Minimum_Interval_[Days]", $langId), 'CONF_MIN_INTERVAL_WITHDRAW_REQUESTS', '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_minimum_interval_in_days_between_two_withdrawal_requests.", $langId) . "</span>";
                break;

            case Configurations::FORM_CHECKOUT_PROCESS:
                $fld = $frm->addHtml('', 'Checkout', '<h3 class="form-section-head">' . Labels::getLabel('LBL_COD_Payments', $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addTextBox(Labels::getLabel('LBL_Minimum_COD_Order_Total', $langId) . ' [' . $this->siteDefaultCurrencyCode . ']', 'CONF_MIN_COD_ORDER_LIMIT');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_minimum_cash_on_delivery_order_total,_eligible_for_COD_payments.", $langId) . "</span>";
                $fld = $frm->addTextBox(Labels::getLabel('LBL_Maximum_COD_Order_Total', $langId) . ' [' . $this->siteDefaultCurrencyCode . ']', 'CONF_MAX_COD_ORDER_LIMIT');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_maximum_cash_on_delivery_order_total,_eligible_for_COD_payments._Default_is_0", $langId) . "</span>";
                $fld = $frm->addTextBox(Labels::getLabel('LBL_Minimum_Wallet_Balance', $langId) . ' [' . $this->siteDefaultCurrencyCode . ']', 'CONF_COD_MIN_WALLET_BALANCE');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_seller_needs_to_maintain_to_accept_COD_orders._Default_is_-1", $langId) . "</span>";

                $fld = $frm->addHtml('', 'pickup', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel('LBL_Pickup', $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addTextBox(Labels::getLabel('LBL_Display_Time_Slots_After_Order', $langId) . ' [' . Labels::getLabel('LBL_Hours', $langId) . ']', 'CONF_TIME_SLOT_ADDITION', 2);
                $fld->requirements()->setInt();
                $fld->requirements()->setRange('2', '9999999999');
                $fld->requirements()->setRequired(true);
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_SHOP_PICKUP_INTERVAL_INFO", $langId) . "</span>";

                $fld = $frm->addHtml('', 'cprocess', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel('LBL_Checkout_Process', $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addCheckBox(Labels::getLabel('LBL_Activate_Live_Payment_Transaction_Mode', $langId), 'CONF_TRANSACTION_MODE', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_Set_Transaction_Mode_to_live_environment", $langId));

                $obj = new Plugin();
                if ($obj->getDefaultPluginData(Plugin::TYPE_SHIPPING_SERVICES, 'plugin_active')) {
                    $fld = $frm->addCheckBox(
                        Labels::getLabel("LBL_USE_MANUAL_SHIPPING_RATES._INSTEAD_OF_THIRD_PARTY.", $langId),
                        'CONF_MANUAL_SHIPPING_RATES_ADMIN',
                        1,
                        array(),
                        false,
                        0
                    );
                    HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_MANUAL_SHIPPING_RATES_WERE_CONSIDERED_FOR_ADMIN_SHIPPING.", $langId));
                }

                $fld = $frm->addCheckBox(Labels::getLabel('LBL_New_Order_Alert_Email', $langId), 'CONF_NEW_ORDER_EMAIL', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_Send_an_email_to_store_owner_when_new_order_is_placed.", $langId));

                $orderStatusArr = Orders::getOrderProductStatusArr($langId);

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Tax_Collected_By_Seller", $langId), 'CONF_TAX_COLLECTED_BY_SELLER', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_this_feature,_seller_will_be_able_to_collect_tax.", $langId));

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_TAX_AFTER_DISCOUNTS", $langId), 'CONF_TAX_AFTER_DISOCUNT', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_this_feature,_tax_will_be_applicable_after_discounts", $langId));

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Return_Shipping_Charges_to_Customer", $langId), 'CONF_RETURN_SHIPPING_CHARGES_TO_CUSTOMER', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_return_shipping_charges_to_customer", $langId));

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_SHIPPED_BY_ADMIN_ONLY", $langId), 'CONF_SHIPPED_BY_ADMIN_ONLY', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_shipping_charges_manged_by_admin_only", $langId));

                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_Default_Child_Order_Status", $langId),
                    'CONF_DEFAULT_ORDER_STATUS',
                    $orderStatusArr,
                    false,
                    array(),
                    ''
                );

                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_Default_Paid_Order_Status", $langId),
                    'CONF_DEFAULT_PAID_ORDER_STATUS',
                    $orderStatusArr,
                    false,
                    array(),
                    ''
                );
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_default_child_order_status_when_an_order_is_marked_Paid.", $langId) . "</span>";

                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_DEFAULT_APPROVED_ORDER_STATUS", $langId),
                    'CONF_DEFAULT_APPROVED_ORDER_STATUS',
                    $orderStatusArr,
                    false,
                    array(),
                    ''
                );
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_SET_THE_DEFAULT_APPROVED_ORDER_STATUS", $langId) . "</span>";

                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_Default_InProcess_Order_Status", $langId),
                    'CONF_DEFAULT_INPROCESS_ORDER_STATUS',
                    $orderStatusArr,
                    false,
                    array(),
                    ''
                );
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_default_in-process_order_status", $langId) . "</span>";

                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_Default_Shipping_Order_Status", $langId),
                    'CONF_DEFAULT_SHIPPING_ORDER_STATUS',
                    $orderStatusArr,
                    false,
                    array(),
                    ''
                );
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_default_child_order_status_when_an_order_is_marked_Shipped.", $langId) . "</span>";

                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_Default_Delivered_Order_Status", $langId),
                    'CONF_DEFAULT_DEIVERED_ORDER_STATUS',
                    $orderStatusArr,
                    false,
                    array(),
                    ''
                );
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_default_child_order_status_when_an_order_is_marked_delivered.", $langId) . "</span>";

                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_Default_Cancelled_Order_Status", $langId),
                    'CONF_DEFAULT_CANCEL_ORDER_STATUS',
                    $orderStatusArr,
                    false,
                    array(),
                    ''
                );
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_default_child_order_status_when_an_order_is_marked_Cancelled.", $langId) . "</span>";

                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_Return_Requested_Order_Status", $langId),
                    'CONF_RETURN_REQUEST_ORDER_STATUS',
                    $orderStatusArr,
                    false,
                    array(),
                    ''
                );
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_default_child_order_status_when_return_request_is_opened_on_any_order.", $langId) . "</span>";

                $fld = $frm->addSelectBox(Labels::getLabel("LBL_Return_Request_Withdrawn_Order_Status", $langId), 'CONF_RETURN_REQUEST_WITHDRAWN_ORDER_STATUS', $orderStatusArr, false, array(), '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_default_child_order_status_when_return_request_is_withdrawn.", $langId) . "</span>";

                $fld = $frm->addSelectBox(Labels::getLabel("LBL_Return_Request_Approved_Order_Status", $langId), 'CONF_RETURN_REQUEST_APPROVED_ORDER_STATUS', $orderStatusArr, false, array(), '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_default_child_order_status_when_return_request_is_accepted_by_the_Seller.", $langId) . "</span>";

                $fld = $frm->addSelectBox(Labels::getLabel("LBL_Pay_At_Store_Order_Status", $langId), 'CONF_PAY_AT_STORE_ORDER_STATUS', $orderStatusArr, false, array(), '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_Pay_at_store_order_status.", $langId) . "</span>";

                $fld = $frm->addSelectBox(Labels::getLabel("LBL_Cash_on_Delivery_Order_Status", $langId), 'CONF_COD_ORDER_STATUS', $orderStatusArr, false, array(), '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_Cash_on_delivery_order_status.", $langId) . "</span>";

                $fld = $frm->addSelectBox(Labels::getLabel("LBL_Ready_For_Pickup_Order_Status", $langId), 'CONF_PICKUP_READY_ORDER_STATUS', $orderStatusArr, false, array(), '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_Ready_for_Pickup_order_status.", $langId) . "</span>";

                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_STATUS_USED_BY_SYSTEM_TO_MARK_ORDER_AS_COMPLETED", $langId),
                    'CONF_DEFAULT_COMPLETED_ORDER_STATUS',
                    $orderStatusArr,
                    false,
                    array(),
                    ''
                );
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_SET_THE_DEFAULT_CHILD_ORDER_STATUS_WHEN_AN_ORDER_IS_MARKED_COMPLETED.", $langId) . "</span>";

                $returnAge = FatApp::getConfig("CONF_DEFAULT_RETURN_AGE", FatUtility::VAR_INT, 7);
                $fld = $frm->addIntegerField(Labels::getLabel("LBL_DEFAULT_RETURN_AGE_[Days]", $langId), 'CONF_DEFAULT_RETURN_AGE', $returnAge);
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_IT_WILL_CONSIDERED_IF_NO_RETURN_AGE_IS_DEFINED_IN_SHOP_OR_SELLER_PRODUCT.", $langId) . "</span>";
              
                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Seller_Order_Statuses", $langId), 'CONF_VENDOR_ORDER_STATUS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_order_status_the_customer's_order_must_reach_before_the_order_starts_displaying_to_Sellers.", $langId) . "</span>";
                
                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Buyer_Order_Statuses", $langId), 'CONF_BUYER_ORDER_STATUS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_order_status_the_customer's_order_must_reach_before_the_order_starts_displaying_to_Buyers.", $langId) . "</span>";

                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Processing_Order_Status", $langId), 'CONF_PROCESSING_ORDER_STATUS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_order_status_the_customer's_order_must_reach_before_the_order_starts_stock_subtraction.", $langId) . "</span>";
              
                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Completed_Order_Status", $langId), 'CONF_COMPLETED_ORDER_STATUS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_order_status_the_customer's_order_must_reach_before_they_are_considered_completed_and_payment_released_to_Sellers.", $langId) . "</span>";

                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Feedback_ready_Order_Status", $langId), 'CONF_REVIEW_READY_ORDER_STATUS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_order_status_the_customer's_order_must_reach_before_they_are_allowed_to_review_the_orders.", $langId) . "</span>";

               
                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Allow_Order_Cancellation_by_Buyers", $langId), 'CONF_ALLOW_CANCELLATION_ORDER_STATUS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_order_status_the_customer's_order_must_reach_before_they_are_allowed_to_place_cancellation_request_on_orders.", $langId) . "</span>";

                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Allow_Order_Cancellation_by_Buyers_On_Digital", $langId), 'CONF_DIGITAL_ALLOW_CANCELLATION_ORDER_STATUS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_order_status_the_customer's_order_must_reach_before_they_are_allowed_to_place_cancellation_request_on_orders.", $langId) . "</span>";

                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Allow_Return/Exchange", $langId), 'CONF_RETURN_EXCHANGE_READY_ORDER_STATUS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_order_status_the_customer's_order_must_reach_before_they_are_allowed_to_place_return/exchange_request_on_orders.", $langId) . "</span>";

                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Enable_Digital_Download", $langId), 'CONF_ENABLE_DIGITAL_DOWNLOADS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_order_status_the_customer's_order_must_reach_before_they_are_allowed_to_access_their_downloadable_Products.", $langId) . "</span>";

                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Order_statuses_to_allow_to_attach_more_files_with_order_product", $langId), 'CONF_ALLOW_FILES_TO_ADD_WITH_ORDER_STATUSES', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_order_statuses_to_allow_seller_or_admin_to_attach_more_files_with_order_products", $langId) . "</span>";

                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Order_Statuses_to_calculate_badge_count_(For_Admin)", $langId), 'CONF_BADGE_COUNT_ORDER_STATUS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Order_Statuses_to_calculate_badge_count_for_seller_orders_in_admin_left_navigation_panel", $langId) . "</span>";

                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Products_On_Order_Stage(For_Seller_Inventory_Report)", $langId), 'CONF_PRODUCT_IS_ON_ORDER_STATUSES', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Products_are_in_On_Order_Used_on_Seller_Dashboard_Products_Inventory_Stock_Status_Report", $langId) . "</span>";

                break;

            case Configurations::FORM_CART_WISHLIST:
                $fld = $frm->addRadioButtons(Labels::getLabel("LBL_ADD_PRODUCTS_TO_WISHLIST_OR_FAVORITE?", $langId), 'CONF_ADD_FAVORITES_TO_WISHLIST', UserWishList::wishlistOrFavtArr($langId), applicationConstants::YES, array('class' => 'list-radio'));
                HtmlHelper::configureSwitchForRadio($fld);

                $fld = $frm->addHtml('', 'Cart', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Cart", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addCheckBox(Labels::getLabel('LBL_On_Payment_Cancel_Maintain_Cart', $langId), 'CONF_MAINTAIN_CART_ON_PAYMENT_CANCEL', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_Cart_Items_Will_be_retained_on_Cancelling_the_payment", $langId));

                $fld = $frm->addCheckBox(Labels::getLabel('LBL_On_Payment_Failure_Maintain_Cart', $langId), 'CONF_MAINTAIN_CART_ON_PAYMENT_FAILURE', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_Cart_Items_Will_be_retained_on_payment_failure", $langId));

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Reminder_Interval_For_Products_In_Cart_[Days]", $langId), 'CONF_REMINDER_INTERVAL_PRODUCTS_IN_CART', '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_interval_in_days_to_send_auto_notification_alert_to_buyer_for_products_in_cart.", $langId) . "</span>";

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Set_Notification_Count_to_be_Sent", $langId), 'CONF_SENT_CART_REMINDER_COUNT', '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_how_many_notifications_will_be_sent_to_buyer.", $langId) . "</span>";

                $frm->addHtml('', 'Wishlist', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Wishlist", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Reminder_Interval_For_Products_In_Wishlist_[Days]", $langId), 'CONF_REMINDER_INTERVAL_PRODUCTS_IN_WISHLIST', '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_interval_in_days_to_send_auto_notification_alert_to_buyer_for_products_in_Wishlist.", $langId) . "</span>";

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Set_Notification_Count_to_be_Sent", $langId), 'CONF_SENT_WISHLIST_REMINDER_COUNT', '');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_how_many_notifications_will_be_sent_to_buyer.", $langId) . "</span>";

                break;

            case Configurations::FORM_COMMISSION:

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Commission_charged_including_shipping", $langId), 'CONF_COMMISSION_INCLUDING_SHIPPING', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_Commission_charged_including_shipping_charges", $langId));

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Commission_charged_including_tax", $langId), 'CONF_COMMISSION_INCLUDING_TAX', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_Commission_charged_including_tax_charges", $langId));

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Maximum_Site_Commission", $langId) . ' [' . $this->siteDefaultCurrencyCode . ']', 'CONF_MAX_COMMISSION', '');
                $fld->requirements()->setFloatPositive();
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_maximum_commission/Fees_that_will_be_charged_on_a_particular_product.", $langId) . "</span>";

                break;

            case Configurations::FORM_AFFILIATE:
                /* Affiliate Accounts[ */

                $fld = $frm->addRadioButtons(
                    Labels::getLabel("LBL_Requires_Approval", $langId),
                    'CONF_AFFILIATES_REQUIRES_APPROVAL',
                    applicationConstants::getYesNoArr($langId),
                    '',
                    array('class' => 'list-radio')
                );
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                HtmlHelper::configureSwitchForRadio($fld, Labels::getLabel("LBL_Automatically_approve_any_new_affiliates_who_sign_up.", $langId));

                $fld = $frm->addTextBox(Labels::getLabel('LBL_Sign_Up_Commission', $langId) . ' [' . $this->siteDefaultCurrencyCode . ']', 'CONF_AFFILIATE_SIGNUP_COMMISSION');
                $fld->requirements()->setInt();
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('LBL_Affiliate_will_get_commission_when_new_registration_is_received_through_affiliate.', $langId) . '</span>';

                $cpagesArr = ContentPage::getPagesForSelectBox($langId);
                $fld = $frm->addSelectBox(Labels::getLabel('LBL_Affiliate_Terms', $langId), 'CONF_AFFILIATE_TERMS_AND_CONDITIONS_PAGE', $cpagesArr, '', array(), '');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('LBL_Forces_affiliate_to_agree_to_terms_before_an_affiliate_account_can_be_created.', $langId) . '</span>';

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Referrer_Url/link_Validity_Period", $langId), 'CONF_AFFILIATE_REFERRER_URL_VALIDITY');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('LBL_Days,_After_Which_Referrer_Url_Is_Expired.(Cookie_Data_on_landed_user)', $langId) . '</span>';

                $fld = $frm->addRadioButtons(
                    Labels::getLabel("LBL_New_Affiliate_Alert_Mail", $langId),
                    'CONF_NOTIFY_ADMIN_AFFILIATE_REGISTRATION',
                    applicationConstants::getYesNoArr($langId),
                    '',
                    array('class' => 'list-radio')
                );
                HtmlHelper::configureSwitchForRadio($fld, Labels::getLabel("LBL_Send_an_email_to_the_store_owner_when_a_new_affiliate_is_registered", $langId));

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Activate_Email_Verification_After_Registration", $langId),
                    'CONF_EMAIL_VERIFICATION_AFFILIATE_REGISTRATION',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_affiliate_user_need_to_verify_their_email_address", $langId));

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Activate_Sending_Welcome_Mail_After_Registration", $langId),
                    'CONF_WELCOME_EMAIL_AFFILIATE_REGISTRATION',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("LBL_On_enabling_this_feature,_affiliate_will_receive_a_welcome_e-mail_after_registration.", $langId));

                break;

            case Configurations::FORM_REWARD_POINTS:
                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Reward_Points_in", $langId) . '[' . $this->siteDefaultCurrencyCode . ']', 'CONF_REWARD_POINT');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_how_many_rewards_points_equal_to", $langId) . "[" . $this->siteDefaultCurrencyCode . "]</span>";
                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Minimum_Reward_Point_Required_To_Use", $langId), 'CONF_MIN_REWARD_POINT');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_minimun_reward_points_required_user_to_avail_discount_during_checkout", $langId) . " .</span>";

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Maximum_Reward_Point", $langId), 'CONF_MAX_REWARD_POINT');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_maximum_reward_points_limit_to_avail_discount_during_checkout", $langId) . "</span>";

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Reward_Point_Validity", $langId), 'CONF_REWARDS_VALIDITY_ON_PURCHASE');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Reward_Point_Validity_in_days_from_date_of_credit", $langId) . "</span>";

                $fld = $frm->addCheckBox(
                    Labels::getLabel("LBL_Activate_reward_point_on_every_purchase", $langId),
                    'CONF_ENABLE_REWARDS_ON_PURCHASE',
                    1,
                    array(),
                    false,
                    0
                );
                HtmlHelper::configureSwitchForCheckbox($fld, Labels::getLabel("MSG_Buyer_will_reward_point_on_every_purchase_as_defined_settings", $langId));


                $fld = $frm->addHtml('', 'Birthday_Rewards', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Birthday_Reward_Points", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld =  $frm->addRadioButtons(
                    Labels::getLabel("LBL_Enable_birthday_discount", $langId),
                    'CONF_ENABLE_BIRTHDAY_DISCOUNT_REWARDS',
                    applicationConstants::getYesNoArr($langId),
                    '',
                    array('class' => 'list-radio')
                );
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                HtmlHelper::configureSwitchForRadio($fld);

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Birthday_Reward_Points", $langId), 'CONF_BIRTHDAY_REWARD_POINTS');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_User_get_this_reward_points_on_his_birthday.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_reward_Points_Validity", $langId), 'CONF_BIRTHDAY_REWARD_POINTS_VALIDITY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Reward_Points_validity_in_days_from_the_date_of_credit._Please_leave_it_blank_if_you_don't_want_reward_points_to_expire.", $langId) . "</span>";

                $fld = $frm->addHtml('', 'BuyingAnYear', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Buying_in_an_Year_Reward_Points", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addRadioButtons(
                    Labels::getLabel("LBL_Enable_Module", $langId),
                    'CONF_ENABLE_BUYING_IN_AN_YEAR_REWARDS',
                    applicationConstants::getYesNoArr($langId),
                    '',
                    array('class' => 'list-radio')
                );
                HtmlHelper::configureSwitchForRadio($fld, Labels::getLabel("LBL_Enable_Buying_in_an_year_reward_points_module", $langId));

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Minimum_buying_value", $langId), 'CONF_BUYING_IN_AN_YEAR_MIN_VALUE');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Min_buying_value_in_an_year_to_get_reward_points", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Reward_Points", $langId), 'CONF_BUYING_IN_AN_YEAR_REWARD_POINTS');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_User_get_this_reward_points_on_min_buying_value_in_an_year", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Reward_Points_Validity", $langId), 'CONF_BUYING_IN_AN_YEAR_REWARD_POINTS_VALIDITY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Reward_Points_validity_in_days_from_the_date_of_credit", $langId) . "</span>";

                $orderStatusArr = Orders::getOrderProductStatusArr($langId);                
                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Buying_Completion_Order_Status", $langId), 'CONF_BUYING_YEAR_REWARD_ORDER_STATUS', $orderStatusArr, 0, array('class' => 'list-checkboxes'));
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_order_status_the_customer's_order_must_reach_before_they_are_considered_completed_and_payment_released_to_Sellers.", $langId) . "</span>";

                break;

            case Configurations::FORM_REVIEWS:

                $fld = $frm->addRadioButtons(Labels::getLabel("LBL_Allow_Reviews", $langId), 'CONF_ALLOW_REVIEWS', applicationConstants::getYesNoArr($langId), '', array('class' => 'list-radio'));
                HtmlHelper::configureSwitchForRadio($fld);

                $fld = $frm->addRadioButtons(Labels::getLabel("LBL_New_Review_Alert_Email", $langId), 'CONF_REVIEW_ALERT_EMAIL', applicationConstants::getYesNoArr($langId), '', array('class' => 'list-radio'));
                HtmlHelper::configureSwitchForRadio($fld);

                $reviewStatusArr = SelProdReview::getReviewStatusArr($langId);
                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_Default_Review_Status", $langId),
                    'CONF_DEFAULT_REVIEW_STATUS',
                    $reviewStatusArr,
                    false,
                    array(),
                    ''
                );
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Set_the_default_review_order_status_when_a_new_review_is_placed", $langId) . "</span>";

                break;

            case Configurations::FORM_EMAIL:
                $frm->addTextBox(Labels::getLabel("LBL_From_Name", $langId), 'CONF_FROM_NAME_' . $langId);
                $fld = $frm->addEmailField(Labels::getLabel("LBL_From_Email", $langId), 'CONF_FROM_EMAIL');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Required_for_sending_emails", $langId) . "</span>";
                $fld = $frm->addEmailField(Labels::getLabel("LBL_Reply_to_Email_Address", $langId), 'CONF_REPLY_TO_EMAIL');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Required_for_email_headers_-_user_can_reply_to_this_email", $langId) . "</span>";

                $fld = $frm->addEmailField(Labels::getLabel("LBL_Contact_Email_Address", $langId), 'CONF_CONTACT_EMAIL');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Email_id_to_contact_site_owner", $langId) . "</span>";

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Send_Email", $langId), 'CONF_SEND_EMAIL', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld);

                /* $fld = $frm->addRadioButtons(Labels::getLabel("LBL_Send_Email", $langId), 'CONF_SEND_EMAIL', applicationConstants::getYesNoArr($langId), '', array('class' => 'list-radio')); */
                HtmlHelper::configureSwitchForRadio($fld);
                if (FatApp::getConfig('CONF_SEND_EMAIL', FatUtility::VAR_INT, 1)) {
                    $fld = $frm->addHTML('', 'sendmailhtml', '<a href="javascript:void(0)" id="testMail-js">' . Labels::getLabel("LBL_Click_Here", $langId) . '</a> to test email. ' . Labels::getLabel("LBL_This_will_send_Test_Email_to_Site_Owner_Email", $langId) . ' - ' . FatApp::getConfig("CONF_SITE_OWNER_EMAIL"));
                    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                    /*  $fld->htmlAfterField = '<a href="javascript:void(0)" id="testMail-js">' . Labels::getLabel("LBL_Click_Here", $langId) . '</a> to test email. ' . Labels::getLabel("LBL_This_will_send_Test_Email_to_Site_Owner_Email", $langId) . ' - ' . FatApp::getConfig("CONF_SITE_OWNER_EMAIL"); */
                }

                $fld = $frm->addCheckBox(Labels::getLabel("LBL_Send_SMTP_Email", $langId), 'CONF_SEND_SMTP_EMAIL', 1, array(), false, 0);
                HtmlHelper::configureSwitchForCheckbox($fld);

                $fld = $frm->addRadioButtons(Labels::getLabel("LBL_SMTP_Secure", $langId), 'CONF_SMTP_SECURE', applicationConstants::getSmtpSecureArr($langId), '', array('class' => 'list-radio'));
                HtmlHelper::configureSwitchForRadio($fld);

                /*   $frm->addRadioButtons(Labels::getLabel("LBL_Send_SMTP_Email", $langId), 'CONF_SEND_SMTP_EMAIL', applicationConstants::getYesNoArr($langId), '', array('class' => 'list-inline')); */

                $fld = $frm->addTextBox(Labels::getLabel("LBL_SMTP_Host", $langId), 'CONF_SMTP_HOST');
                $fld = $frm->addTextBox(Labels::getLabel("LBL_SMTP_Port", $langId), 'CONF_SMTP_PORT');
                $fld = $frm->addTextBox(Labels::getLabel("LBL_SMTP_Username", $langId), 'CONF_SMTP_USERNAME');
                $fld = $frm->addPasswordField(Labels::getLabel("LBL_SMTP_Password", $langId), 'CONF_SMTP_PASSWORD');


                $fld = $frm->addTextarea(Labels::getLabel("LBL_Additional_Alert_E-Mails", $langId), 'CONF_ADDITIONAL_ALERT_EMAILS');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Any_additional_emails_you_want_to_receive_the_alert_email", $langId) . "</span>";

                break;

            case Configurations::FORM_LIVE_CHAT:
                $fld = $frm->addRadioButtons(
                    Labels::getLabel("LBL_Activate_Live_Chat", $langId),
                    'CONF_ENABLE_LIVECHAT',
                    applicationConstants::getYesNoArr($langId),
                    '',
                    array('class' => 'list-radio')
                );
                HtmlHelper::configureSwitchForRadio($fld, Labels::getLabel("LBL_Activate_3rd_Party_Live_Chat.", $langId));

                $fld = $frm->addTextarea(Labels::getLabel("LBL_Live_Chat_Code", $langId), 'CONF_LIVE_CHAT_CODE');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_live_chat_script/code_provided_by_the_3rd_party_API_for_integration.", $langId) . "</span>";

                break;

            case Configurations::FORM_THIRD_PARTY_API:
                $frm->addHtml('', 'GooglePushNotification', '<h3 class="form-section-head">' . Labels::getLabel("LBL_GOOGLE_PUSH_NOTIFICATION", $langId) . '</h3>');

                $frm->addHtml('', 'FaceBookPixel', '<h3 class="form-section-head">' . Labels::getLabel("LBL_FACEBOOK_PIXEL", $langId) . '</h3>');

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Google_Push_Notification_API_KEY", $langId), 'CONF_GOOGLE_PUSH_NOTIFICATION_API_KEY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_api_key_used_in_push_notifications.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_FACEBOOK_PIXEL_ID", $langId), 'CONF_FACEBOOK_PIXEL_ID');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_THIS_IS_THE_FACEBOOK_PIXEL_ID_USED_IN_TRACK_EVENTS.", $langId) . "</span>";

                $fld = $frm->addHtml('', 'Engagespot', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Engagespot_Push_Notifications_(WEB)", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addRadioButtons(Labels::getLabel("LBL_Enable_Engagespot", $langId), 'CONF_ENABLE_ENGAGESPOT_PUSH_NOTIFICATION', applicationConstants::getYesNoArr($langId), '', array('class' => 'list-radio'));
                HtmlHelper::configureSwitchForRadio($fld);

                $fld = $frm->addTextBox(Labels::getLabel("LBL_API_Key", $langId), 'CONF_ENGAGESPOT_API_KEY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_API_key_provided_by_Engagespot.", $langId) . "</span>";

                $fld = $frm->addTextarea(Labels::getLabel("LBL_Engagespot_Code", $langId), 'CONF_ENGAGESPOT_PUSH_NOTIFICATION_CODE');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_code_provided_by_the_engagespot_for_integration.", $langId) . "</span>";


                $fld = $frm->addHtml('', 'GoogleMap', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Google_Map_API", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addTextBox(Labels::getLabel("LBL_Google_Map_API_Key", $langId), 'CONF_GOOGLEMAP_API_KEY');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_Google_map_api_key_used_to_get_user_current_location.", $langId) . "</span>";

                $fld = $frm->addHtml('', 'Newsletter', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Newsletter_Subscription", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addRadioButtons(Labels::getLabel("LBL_Activate_Newsletter_Subscription", $langId), 'CONF_ENABLE_NEWSLETTER_SUBSCRIPTION', applicationConstants::getYesNoArr($langId), '', array('class' => 'list-radio'));
                HtmlHelper::configureSwitchForRadio($fld);

                $fld = $frm->addRadioButtons(Labels::getLabel("LBL_Email_Marketing_System", $langId), 'CONF_NEWSLETTER_SYSTEM', applicationConstants::getNewsLetterSystemArr($langId), '', array('class' => 'list-radio'));
                HtmlHelper::configureSwitchForRadio($fld, Labels::getLabel("LBL_Please_select_the_system_you_wish_to_use_for_email_marketing.", $langId));

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Mailchimp_Key", $langId), 'CONF_MAILCHIMP_KEY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_Mailchimp's_application_key_used_in_subscribe_and_send_newsletters.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Mailchimp_List_ID", $langId), 'CONF_MAILCHIMP_LIST_ID');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_Mailchimp's_subscribers_List_ID.", $langId) . "</span>";

                $fld = $frm->addTextarea(Labels::getLabel("LBL_Aweber_Signup_Form_Code", $langId), 'CONF_AWEBER_SIGNUP_CODE');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Enter_the_newsletter_signup_code_received_from_Aweber", $langId) . "</span>";

                $fld = $frm->addHtml('', 'Analytics', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Google_Analytics", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addTextBox(Labels::getLabel("LBL_Client_Id", $langId), 'CONF_ANALYTICS_CLIENT_ID');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_application_Client_Id_used_in_Analytics_dashboard.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Secret_Key", $langId), 'CONF_ANALYTICS_SECRET_KEY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_application_secret_key_used_in_Analytics_dashboard.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Analytics_Id", $langId), 'CONF_ANALYTICS_ID');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_Google_Analytics_ID._Ex._UA-xxxxxxx-xx.", $langId) . "</span>";

                $fld = $frm->addRadioButtons(Labels::getLabel("LBL_ADVANCE_ECOMMERCE_TRACKING", $langId), 'CONF_ANALYTICS_ADVANCE_ECOMMERCE', applicationConstants::getYesNoArr($langId), applicationConstants::NO, array('class' => 'list-radio'));
                HtmlHelper::configureSwitchForRadio($fld);

                $accessToken = FatApp::getConfig("CONF_ANALYTICS_ACCESS_TOKEN", FatUtility::VAR_STRING, '');
          
                include_once CONF_INSTALLATION_PATH . 'library/analytics/analyticsapi.php';
                $analyticArr = array(
                    'clientId' => FatApp::getConfig("CONF_ANALYTICS_CLIENT_ID", FatUtility::VAR_STRING, ''),
                    'clientSecretKey' => FatApp::getConfig("CONF_ANALYTICS_SECRET_KEY", FatUtility::VAR_STRING, ''),
                    'redirectUri' => UrlHelper::generateFullUrl('configurations', 'redirect', array(), '', false),
                    'googleAnalyticsID' => FatApp::getConfig("CONF_ANALYTICS_ID", FatUtility::VAR_STRING, '')
                );
                try {
                    $analytics = new Ykart_analytics($analyticArr);
                    $authUrl = $analytics->buildAuthUrl();
                } catch (exception $e) {
                    $authUrl = '';
                }

                if ($authUrl) {
                    $authenticateText = ($accessToken == '') ? 'Authenticate' : 'Re-Authenticate';
                    $fld = $frm->addHTML('', 'accessToken', 'Please save your settings & <a href="' . $authUrl . '" >click here</a> to ' . $authenticateText . ' settings.<div class="gap"></div>', '', 'class="medium"');
                } else {
                    $fld = $frm->addHTML('', 'accessToken', 'Please configure your settings and then authenticate them', '', 'class="medium"');
                }
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addHtml('', 'seperator', '<div class="separator separator-dashed my-2"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld =  $frm->addHtml('', 'GoogleReCaptcha', '<h3 class="form-section-head">' . Labels::getLabel("LBL_GOOGLE_RECAPTCHA_V3", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addTextBox(Labels::getLabel("LBL_Site_Key", $langId), 'CONF_RECAPTCHA_SITEKEY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_application_Site_key_used_for_Google_Recaptcha.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Secret_Key", $langId), 'CONF_RECAPTCHA_SECRETKEY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_application_Secret_key_used_for_Google_Recaptcha.", $langId) . "</span>";

                $fld =  $frm->addHtml('', 'Translatorseperator', '<div class="separator separator-dashed my-2"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $frm->addHtml('', 'Microsoft Translator Text API', '<h3 class="form-section-head">' . Labels::getLabel("LBL_Microsoft_Translator_Text_API", $langId) . '</h3>');

                $frm->addHtml('', 'GoogleFontsAPI', '<h3 class="form-section-head">' . Labels::getLabel("LBL_GOOGLE_FONTS_API", $langId) . '</h3>');

                $fld = $frm->addTextBox(Labels::getLabel("LBL_SUBSCRIPTION_KEY", $langId), 'CONF_TRANSLATOR_SUBSCRIPTION_KEY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_MICROSOFT_TRANSLATOR_TEXT_API_3.0_SUBSCRIPTION_KEY.", $langId) . "</span>";


                $fld = $frm->addTextBox(Labels::getLabel("LBL_API_KEY", $langId), 'CONF_GOOGLE_FONTS_API_KEY');
                $fld =  $frm->addHtml('', 'JWPlayerseperator', '<div class="separator separator-dashed my-2"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                /* JW player Settings */
                $frm->addHtml('', 'JWPlayerSettings', '<h3 class="form-section-head">' . Labels::getLabel("LBL_JW_Player_Settings", $langId) . '</h3>');

                $fld = $frm->addTextBox(Labels::getLabel("LBL_JW_Player_Key", $langId), 'CONF_JW_PLAYER_KEY');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_key_provided_by_JW_PLAYER", $langId) . "</span>";
                /* JW player Settings */
                break;
            case Configurations::FORM_REFERAL:
                $fld = $frm->addRadioButtons(
                    Labels::getLabel("LBL_Enable_Referral_Module", $langId),
                    'CONF_ENABLE_REFERRER_MODULE',
                    applicationConstants::getYesNoArr($langId),
                    '',
                    array('class' => 'list-radio')
                );

                $fld = $frm->addIntegerField(Labels::getLabel("LBL_Referrer_Url/Link_Validity_Period", $langId), 'CONF_REFERRER_URL_VALIDITY');
                $fld->requirements()->setIntPositive();
                $string = Labels::getLabel("LBL_Days,_after_which_Referrer_Url_is_Expired.", $langId);
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . $string . "</span>";

                $fld = $frm->addHtml('', 'RewardsOnRegistration', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Reward_Benefits_on_Registration", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Referrer_Reward_Points", $langId), 'CONF_REGISTRATION_REFERRER_REWARD_POINTS');
                $fld->requirements()->setIntPositive();
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Referrers_get_this_reward_points_when_their_referrals_(friends)_will_register.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Referrer_Reward_Points_Validity", $langId), 'CONF_REGISTRATION_REFERRER_REWARD_POINTS_VALIDITY');
                $fld->requirements()->setIntPositive();
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Rewards_points_validity_in_days_from_the_date_of_credit", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Referral_Reward_Points", $langId), 'CONF_REGISTRATION_REFERRAL_REWARD_POINTS');
                $fld->requirements()->setIntPositive();
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Referrals_get_this_reward_points_when_they_register_through_referrer.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Referral_Reward_Points_Validity", $langId), 'CONF_REGISTRATION_REFERRAL_REWARD_POINTS_VALIDITY');
                $fld->requirements()->setIntPositive();
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Rewards_points_validity_in_days_from_the_date_of_credit", $langId) . "</span>";

                $fld =  $frm->addHtml('', 'RewardsonPurchase', '<div class="separator separator-dashed my-2"></div><h3 class="form-section-head">' . Labels::getLabel("LBL_Reward_Benefits_on_First_Purchase", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Referrer_Reward_Points", $langId), 'CONF_SALE_REFERRER_REWARD_POINTS');
                $fld->requirements()->setIntPositive();
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Referrers_get_this_reward_points_when_their_referrals_(friends)_will_make_first_purchase.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Referrer_Reward_Points_Validity", $langId), 'CONF_SALE_REFERRER_REWARD_POINTS_VALIDITY');
                $fld->requirements()->setIntPositive();
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Rewards_points_validity_in_days_from_the_date_of_credit", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Referral_Reward_Points", $langId), 'CONF_SALE_REFERRAL_REWARD_POINTS');
                $fld->requirements()->setIntPositive();
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Referrals_get_this_reward_points_when_they_will_make_first_purchase_through_their_referrers.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Rewards_points_validity_in_days", $langId), 'CONF_SALE_REFERRAL_REWARD_POINTS_VALIDITY');
                $fld->requirements()->setIntPositive();
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_NOTE:Rewards_points_validity_in_days_from_the_date_of_credit", $langId) . "</span>";

                break;

            case Configurations::FORM_DISCOUNT:
                $fld = $frm->addHtml('', 'firstTimeDiscount', '<h3 class="form-section-head">' . Labels::getLabel("LBL_First_time_buyers_discount_coupon", $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld = $frm->addRadioButtons(
                    Labels::getLabel("LBL_Enable_1st_time_buyers_discount", $langId),
                    'CONF_ENABLE_FIRST_TIME_BUYER_DISCOUNT',
                    applicationConstants::getYesNoArr($langId),
                    '',
                    array('class' => 'list-radio')
                );
                HtmlHelper::configureSwitchForRadio($fld);

                $percentageFlatArr = applicationConstants::getPercentageFlatArr($langId);
                $disType = $frm->addSelectBox(Labels::getLabel("LBL_Discount_in", $langId), 'CONF_FIRST_TIME_BUYER_COUPON_IN_PERCENT', $percentageFlatArr, '', array(), '');

                $fld =  $frm->addTextBox(Labels::getLabel("LBL_Discount_value", $langId), 'CONF_FIRST_TIME_BUYER_COUPON_DISCOUNT_VALUE');
                $fld->requirements()->setPositive();

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Minimum_order_value", $langId), 'CONF_FIRST_TIME_BUYER_COUPON_MIN_ORDER_VALUE');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Minimum_order_value_on_which_the_coupon_can_be_applied.", $langId) . "</span>";
                $fld->requirements()->setPositive();


                $fld = $frm->addTextBox(Labels::getLabel("LBL_Max_Discount_Value", $langId), 'CONF_FIRST_TIME_BUYER_COUPON_MAX_DISCOUNT_VALUE');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Max_discount_value_user_can_get_by_using_this_coupon.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Discount_Coupon_Validity", $langId), 'CONF_FIRST_TIME_BUYER_COUPON_VALIDITY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Coupon_validity_in_days_from_the_date_of_credit", $langId) . "</span>";

                break;
            case Configurations::FORM_SUBSCRIPTION:
                $fld = $frm->addRadioButtons(
                    Labels::getLabel('LBL_Enable_Subscription_Module', $langId),
                    'CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE',
                    applicationConstants::getYesNoArr($langId),
                    '',
                    array('class' => 'list-radio')
                );
                HtmlHelper::configureSwitchForRadio($fld, Labels::getLabel('LBL_Seller_Needs_to_Purchase_the_subscrption_before_listing_products', $langId));

                $fld = $frm->addRadioButtons(
                    Labels::getLabel('LBL_ENABLE_ADJUST_AMOUNT', $langId),
                    'CONF_ENABLE_ADJUST_AMOUNT_CHANGE_PLAN',
                    applicationConstants::getYesNoArr($langId),
                    '',
                    array('class' => 'list-radio')
                );
                HtmlHelper::configureSwitchForRadio($fld, Labels::getLabel('LBL_Subscription_Payment_will_be_adjusted_While_Upgrading/downgrading_plan', $langId));

                $orderSubscriptionStatusArr = Orders::getOrderSubscriptionStatusArr($langId);
                $fld = $frm->addTextBox(Labels::getLabel("LBL_Reminder_Email_Before_Subscription_Expire_Days", $langId), 'CONF_BEFORE_EXIPRE_SUBSCRIPTION_REMINDER_EMAIL_DAYS');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_Before_How_many_Days_email_needs_to_be_sent_to_user_before_ending_subscription.", $langId) . "</span>";

                $fld = $frm->addSelectBox(
                    Labels::getLabel("LBL_In-Active_Order_Status", $langId),
                    'CONF_SUBSCRIPTION_INACTIVE_ORDER_STATUS',
                    $orderSubscriptionStatusArr,
                    false,
                    array(),
                    ''
                );
                
                $fld = $frm->addCheckBoxes(Labels::getLabel("LBL_Seller_Subscription_Statuses", $langId), 'CONF_SELLER_SUBSCRIPTION_STATUS', $orderSubscriptionStatusArr, 0, array('class' => 'list-checkboxes'));

                break;

            case Configurations::FORM_SYSTEM:
                $fld = $frm->addRadioButtons(Labels::getLabel("LBL_Auto_Close_System_Messages", $langId), 'CONF_AUTO_CLOSE_SYSTEM_MESSAGES', applicationConstants::getYesNoArr($langId), '', array('class' => 'list-radio'));
                HtmlHelper::configureSwitchForRadio($fld);
                $fld->addFieldTagAttribute("onchange", "changedMessageAutoCloseSetting(this.value);");

                $fld = $frm->addTextBox(Labels::getLabel('LBL_TIME_FOR_AUTO_CLOSE_MESSAGES', $langId), 'CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("LBL_NOTE:_After_how_much_seconds_system_message_should_be_close", $langId) . '.</span>';
                $fld->requirements()->setInt();
                break;
            case Configurations::FORM_PPC:
                $fld = $frm->addFloatField(Labels::getLabel('LBL_Minimum_Wallet_Balance', $langId), 'CONF_PPC_MIN_WALLET_BALANCE');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("MSG_Minimum_wallet_balance_to_start_promotion", $langId) . '</span>';

                $fld = $frm->addTextBox(Labels::getLabel('LBL_Days_Interval_to_Charge_Wallet', $langId), 'CONF_PPC_WALLET_CHARGE_DAYS_INTERVAL');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("MSG_Days_Interval_to_Charge_Wallet", $langId) . '</span>';

                $fld = $frm->addFloatField(Labels::getLabel('LBL_Cost_Per_Click_(product)', $langId), 'CONF_CPC_PRODUCT');
                $fld->requirements()->setCompareWith('CONF_PPC_MIN_WALLET_BALANCE', 'lt');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("MSG_PPC_cost_per_click_for_Product", $langId) . '</span>';

                $fld = $frm->addFloatField(Labels::getLabel('LBL_Cost_Per_Click_(shop)', $langId), 'CONF_CPC_SHOP');
                $fld->requirements()->setCompareWith('CONF_PPC_MIN_WALLET_BALANCE', 'lt');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("MSG_PPC_cost_per_click_for_shop", $langId) . '</span>';

                $fld = $frm->addFloatField(Labels::getLabel('LBL_Cost_Per_Click_(slide)', $langId), 'CONF_CPC_SLIDES');
                $fld->requirements()->setCompareWith('CONF_PPC_MIN_WALLET_BALANCE', 'lt');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("MSG_PPC_cost_per_click_for_slide", $langId) . '</span>';

                $fld = $frm->addTextBox(Labels::getLabel('LBL_PPC_products_count_home_page', $langId), 'CONF_PPC_PRODUCTS_HOME_PAGE');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("MSG_how_many_PPC_products_shown_on_home_page", $langId) . '</span>';

                $fld = $frm->addTextBox(Labels::getLabel('LBL_PPC_shops_count_home_page', $langId), 'CONF_PPC_SHOPS_HOME_PAGE');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("MSG_how_many_PPC_shops_shown_on_home_page", $langId) . '</span>';
                $fld = $frm->addTextBox(Labels::getLabel('LBL_PPC_slides_count_home_page', $langId), 'CONF_PPC_SLIDES_HOME_PAGE');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("MSG_how_many_PPC_slides_shown_on_home_page", $langId) . '</span>';
                $fld = $frm->addTextBox(Labels::getLabel('LBL_PPC_Clicks_Count_Time_Interval(Minutes)', $langId), 'CONF_PPC_CLICK_COUNT_TIME_INTERVAL');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("MSG_Set_time_interval_to_calculate_no._of_click_from_one_user_for_each_promotion", $langId) . '</span>';

                break;
            case Configurations::FORM_SERVER:                
                $fld = $frm->addRadioButtons(Labels::getLabel("LBL_Use_SSL", $langId), 'CONF_USE_SSL', applicationConstants::getYesNoArr($langId), '', array('class' => 'list-radio'));
                HtmlHelper::configureSwitchForRadio($fld, Labels::getLabel("LBL_NOTE:_To_use_SSL,_check_with_your_host_if_a_SSL_certificate_is_installed_and_enable_it_from_here.", $langId));

                $fld = $frm->addSelectBox(Labels::getLabel("LBL_Enable_Maintenance_Mode", $langId), 'CONF_MAINTENANCE', applicationConstants::getYesNoArr($langId), '', array(), '');
                $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel("LBL_NOTE:_Enable_Maintenance_Mode_Text", $langId) . '.</span>';
                
                $fld = $frm->addHtmlEditor(Labels::getLabel('LBL_Maintenance_Text', $this->siteLangId), 'CONF_MAINTENANCE_TEXT_' . $langId);
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                $fld->requirements()->setRequired(true);

                break;            
            case Configurations::FORM_MEDIA:
                $ratioArr = AttachedFile::getRatioTypeArray($langId);
                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_ADMIN_LOGO", $langId) . ' </h6>
                    <span class="form-text text-muted">
                        <strong> Image Disclaimer:</strong> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry</span>');

                $fileType = AttachedFile::FILETYPE_ADMIN_LOGO;

                $imageArr = [];
                $selectedRadio = array_key_first($ratioArr);
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteAdminLogo', array($langId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                        $selectedRadio = $fileData['afile_aspect_ratio'];
                    }
                }

                $fld = $frm->addRadioButtons(
                    Labels::getLabel("LBL_ASPECT_RATIO", $langId),
                    'ratio_type_' . $fileType,
                    $ratioArr,
                    $selectedRadio,
                    [],
                    ['class' => 'prefRatio-js']
                );

                $fld = HtmlHelper::configureRadioAsButton($frm, 'ratio_type_' . $fileType);

                $fld1 = $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)', 'data-min_width' => 150, 'data-min_height' => 150, 'data-file_type' => $fileType , 'accept'=>'image/*' ,'data-name' => Labels::getLabel("LBL_ADMIN_LOGO", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));
                $fld->attachField($fld1);
                $fld = $frm->addHtml('', 'spacer', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_DESKTOP_LOGO", $langId) . ' </h6>
                    <span class="form-text text-muted">
                        <strong> Image Disclaimer:</strong> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry</span>');

                $fileType = AttachedFile::FILETYPE_FRONT_LOGO;
                $imageArr = [];
                $selectedRadio = array_key_first($ratioArr);
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($langId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                        $selectedRadio = $fileData['afile_aspect_ratio'];
                    }
                }

                $fld = $frm->addRadioButtons(
                    Labels::getLabel("FRM_ASPECT_RATIO", $langId),
                    'ratio_type_' . $fileType,
                    $ratioArr,
                    $selectedRadio,
                    [],
                    ['class' => 'prefRatio-js']
                );

                $fld = HtmlHelper::configureRadioAsButton($frm, 'ratio_type_' . $fileType);

                $fld1 = $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)', 'data-frm' => 'frmShopLogo', 'data-min_width' => 150, 'data-min_height' => 150, 'data-file_type' => $fileType, 'accept'=>'image/*','data-name' => Labels::getLabel("LBL_DESKTOP_LOGO", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));
                $fld->attachField($fld1);
                $fld =  $frm->addHtml('', 'spacer1', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_WEBSITE_FAVICON", $langId) . ' </h6>
                    <span class="form-text text-muted">
                        <strong> Image Disclaimer:</strong> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry</span>');

                $fileType = AttachedFile::FILETYPE_FAVICON;

                $imageArr = [];
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'favicon', array($langId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                    }
                }
                $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)', 'data-min_width' => 16, 'data-min_height' => 16, 'data-file_type' => $fileType, 'accept'=>'image/*','data-name' => Labels::getLabel("LBL_WEBSITE_FAVICON", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));
                $fld = $frm->addHtml('', 'spacer2', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_SOCIAL_FEED_IMAGE", $langId) . ' </h6>
                    <span class="form-text text-muted">
                        <strong> Image Disclaimer:</strong> ' . Labels::getLabel('LBL_Dimensions', $langId) . ' 160*240</span>');

                $fileType = AttachedFile::FILETYPE_SOCIAL_FEED_IMAGE;

                $imageArr = [];
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'socialFeed', array($langId, 'THUMB'), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                    }
                }

                $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)', 'data-min_width' => 160, 'data-min_height' => 240, 'data-file_type' => $fileType, 'accept'=>'image/*','data-name' => Labels::getLabel("LBL_SOCIAL_FEED_IMAGE", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));
                $fld = $frm->addHtml('', 'spacer3', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_PAYMENT_PAGE_LOGO", $langId) . ' </h6>
                    <span class="form-text text-muted">
                        <strong> Image Disclaimer:</strong>' . Labels::getLabel("MSG_PLEASE_UPLOAD_WHITE_PNG_IMAGE", $langId) . ' </span>');

                $fileType = AttachedFile::FILETYPE_PAYMENT_PAGE_LOGO;
                $imageArr = [];
                $selectedRadio = array_key_first($ratioArr);
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'paymentPageLogo', array($langId, 'THUMB'), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                        $selectedRadio = $fileData['afile_aspect_ratio'];
                    }
                }

                $fld = $frm->addRadioButtons(
                    Labels::getLabel("FRM_ASPECT_RATIO", $langId),
                    'ratio_type_' . $fileType,
                    $ratioArr,
                    $selectedRadio,
                    [],
                    ['class' => 'prefRatio-js']
                );

                $fld = HtmlHelper::configureRadioAsButton($frm, 'ratio_type_' . $fileType);

                $fld1 = $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)',  'data-min_width' => 150, 'data-min_height' => 150, 'data-file_type' => $fileType, 'accept'=>'image/*','data-name' => Labels::getLabel("LBL_PAYMENT_PAGE_LOGO", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));
                $fld->attachField($fld1);
                $fld =$frm->addHtml('', 'spacer4', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];


                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_WATERMARK_IMAGE", $langId) . ' </h6>
                    <span class="form-text text-muted">
                        <strong> Image Disclaimer:</strong> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry</span>');

                $fileType = AttachedFile::FILETYPE_WATERMARK_IMAGE;

                $imageArr = [];
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'watermarkImage', array($langId, 'THUMB'), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                    }
                }

                $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)', 'data-min_width' => 168, 'data-min_height' => 37, 'data-file_type' => $fileType, 'accept'=>'image/*','data-name' => Labels::getLabel("LBL_WATERMARK_IMAGE", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));
                $fld = $frm->addHtml('', 'spacer5', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_APPLE_TOUCH_ICON", $langId) . ' </h6>
                     <span class="form-text text-muted">
                         <strong> Image Disclaimer:</strong> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry</span>');

                $fileType = AttachedFile::FILETYPE_APPLE_TOUCH_ICON;

                $imageArr = [];
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'appleTouchIcon', array($langId, 'THUMB'), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                    }
                }

                $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)',  'data-min_width' => 152, 'data-min_height' => 152, 'data-file_type' => $fileType, 'accept'=>'image/*','data-name' => Labels::getLabel("LBL_APPLE_TOUCH_ICON", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));

                $fld = $frm->addHtml('', 'spacer6', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_MOBILE_LOGO", $langId) . ' </h6>
                      <span class="form-text text-muted">
                          <strong> Image Disclaimer:</strong> ' . Labels::getLabel('LBL_DIMENSIONS', $langId) . ' 168*37</span>');

                $fileType = AttachedFile::FILETYPE_MOBILE_LOGO;

                $imageArr = [];
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'mobileLogo', array($langId, 'THUMB'), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                    }
                }

                $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)',  'data-min_width' => 168, 'data-min_height' => 37, 'data-file_type' => $fileType, 'accept'=>'image/*','data-name' => Labels::getLabel("LBL_MOBILE_LOGO", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));
                $fld = $frm->addHtml('', 'spacer7', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_INVOICE_LOGO", $langId) . ' </h6>
                    <span class="form-text text-muted">
                        <strong> Image Disclaimer:</strong> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry</span>');

                $fileType = AttachedFile::FILETYPE_INVOICE_LOGO;
                $imageArr = [];
                $selectedRadio = array_key_first($ratioArr);
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'invoiceLogo', array($langId, 'THUMB'), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                        $selectedRadio = $fileData['afile_aspect_ratio'];
                    }
                }

                $fld = $frm->addRadioButtons(
                    Labels::getLabel("FRM_ASPECT_RATIO", $langId),
                    'ratio_type_' . $fileType,
                    $ratioArr,
                    $selectedRadio,
                    [],
                    ['class' => 'prefRatio-js']
                );

                $fld = HtmlHelper::configureRadioAsButton($frm, 'ratio_type_' . $fileType);
                $fld1 = $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)', 'data-min_width' => 150, 'data-min_height' => 150, 'data-file_type' => $fileType, 'accept'=>'image/*','data-name' => Labels::getLabel("LBL_INVOICE_LOGO", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));
                $fld->attachField($fld1);
                $fld = $frm->addHtml('', 'spacer8', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];


                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_FIRST_PURCHASE_DISCOUNT_IMAGE", $langId) . ' </h6>
                    <span class="form-text text-muted">
                        <strong> Image Disclaimer:</strong> ' . Labels::getLabel('LBL_DIMENSIONS', $langId) . ' 120*120</span>');

                $fileType = AttachedFile::FILETYPE_FIRST_PURCHASE_DISCOUNT_IMAGE;

                $imageArr = [];
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'firstPurchaseCoupon', array($langId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                    }
                }

                $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)',  'data-min_width' => 120, 'data-min_height' => 120, 'data-file_type' => $fileType, 'accept'=>'image/*','data-name' => Labels::getLabel("LBL_FIRST_PURCHASE_DISCOUNT_IMAGE", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));
                $fld = $frm->addHtml('', 'spacer9', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                /* block start */

                $fld = $frm->addHtml('', 'main_heading', '<h6>' . Labels::getLabel("LBL_META_IMAGE", $langId) . ' </h6>
                    <span class="form-text text-muted">
                       <strong> Image Disclaimer:</strong> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry</span>');

                $fileType = AttachedFile::FILETYPE_META_IMAGE;
                $imageArr = [];
                $selectedRadio = array_key_first($ratioArr);
                if ($fileData = AttachedFile::getAttachment($fileType, 0, 0, $langId)) {
                    if (0 < $fileData['afile_id']) {
                        $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                        $image = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'metaImage', array($langId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $imageArr = ['name' =>  $fileData['afile_name'], 'url' => $image];
                        $selectedRadio = $fileData['afile_aspect_ratio'];
                    }
                }

                $fld = $frm->addRadioButtons(
                    Labels::getLabel("FRM_ASPECT_RATIO", $langId),
                    'ratio_type_' . $fileType,
                    $ratioArr,
                    $selectedRadio,
                    [],
                    ['class' => 'prefRatio-js']
                );

                $fld = HtmlHelper::configureRadioAsButton($frm, 'ratio_type_' . $fileType);

                $fld1 = $frm->addHtml('', 'file_input', HtmlHelper::getfileInputHtml(
                    ['onChange' => 'popupImage(this)',  'data-min_width' => 150, 'data-min_height' => 150, 'data-file_type' => $fileType, 'accept'=>'image/*','data-name' => Labels::getLabel("LBL_META_IMAGE", $langId)],
                    $langId,
                    'removeMediaImage(' . $fileType . ',' . $langId . ')',
                    '',
                    $imageArr,
                    'mt-3'
                ));
                $fld->attachField($fld1);
                $fld = $frm->addHtml('', 'spacer10', '<div class="separator separator-dashed my-5"></div>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];
                break;
            case Configurations::FORM_SHARING:
                $fld =  $frm->addHtml('', 'ShareAndEarn', '<h3 class="form-section-head">' . Labels::getLabel('LBL_Share_and_Earn_Settings', $langId) . '</h3>');
                $fld->developerTags['colWidthValues'] = [null, '12', null, null];

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Facebook_APP_ID", $langId), 'CONF_FACEBOOK_APP_ID');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_application_ID_used_in_post.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Facebook_App_Secret", $langId), 'CONF_FACEBOOK_APP_SECRET');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_Facebook_secret_key_used_for_authentication_and_other_Facebook_related_plugins_support.", $langId) . "</span>";

                $fld = $frm->addTextbox(Labels::getLabel("LBL_Facebook_Post_Title", $langId), 'CONF_SOCIAL_FEED_FACEBOOK_POST_TITLE_' . $langId);
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_title_shared_on_facebook", $langId) . "</span>";
                $fld = $frm->addTextbox(Labels::getLabel("LBL_Facebook_Post_Caption", $langId), 'CONF_SOCIAL_FEED_FACEBOOK_POST_CAPTION_' . $langId);
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_caption_shared_on_facebook", $langId) . "</span>";
                $fld = $frm->addTextarea(Labels::getLabel("LBL_Facebook_Post_Description", $langId), 'CONF_SOCIAL_FEED_FACEBOOK_POST_DESCRIPTION_' . $langId);
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_description_shared_on_facebook", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Twitter_APP_KEY", $langId), 'CONF_TWITTER_API_KEY');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_application_ID_used_in_post.", $langId) . "</span>";

                $fld = $frm->addTextBox(Labels::getLabel("LBL_Twitter_App_Secret", $langId), 'CONF_TWITTER_API_SECRET');
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_is_the_Twitter_secret_key_used_for_authentication_and_other_Twitter_related_plugins_support.", $langId) . "</span>";

                $fld = $frm->addTextarea(Labels::getLabel("LBL_Twitter_Post_Description", $langId), 'CONF_SOCIAL_FEED_TWITTER_POST_TITLE' . $langId);
                $fld->htmlAfterField = "<span class='form-text text-muted'>" . Labels::getLabel("LBL_This_description_shared_on_twitter", $langId) . "</span>";
                break;
        }
        $frm->addHiddenField('', 'form_type', $type);
        $frm->addHiddenField('', 'lang_id', $langId);
        return $frm;
    }

    public function testEmail()
    {
        try {
            if (EmailHandler::sendMailTpl(FatApp::getConfig('CONF_SITE_OWNER_EMAIL'), 'test_email', $this->siteLangId)) {
                FatUtility::dieJsonSuccess("Mail sent to - " . FatApp::getConfig('CONF_SITE_OWNER_EMAIL'));
            }
        } catch (Exception $e) {
            LibHelper::exitWithError($e->getMessage(), true);
        }
    }

    public function displayDateTime()
    {
        $post = FatApp::getPostedData();
        $timeZone = $post['time_zone'];
        $dateTime = CommonHelper::currentDateTime(null, true, null, $timeZone);
        $this->set("dateTime", $dateTime);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateVerificationFile()
    {
        $post = FatApp::getPostedData();
        if (empty($post)) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Request_Or_File_not_supported', $this->siteLangId), true);
        }
        $fileType = FatApp::getPostedData('fileType', FatUtility::VAR_STRING, '');
        if (!isset($_FILES['verification_file']['name'])) {
            LibHelper::exitWithError(Labels::getLabel('MSG_Please_select_a_file', $this->siteLangId), true);
        }

        $target_dir = CONF_UPLOADS_PATH;
        $file = $_FILES['verification_file']['name'];
        $temp_name = $_FILES['verification_file']['tmp_name'];
        $path = pathinfo($file);
        $ext = $path['extension'];
        if (!in_array(strtoupper($ext), ['XML', 'HTML'])) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Request_Or_File_not_supported', $this->siteLangId), true);
        }

        if ($fileType == 'bing') {
            /*If we change file name then we also need to update in htacces file */
            $path_filename = $target_dir . 'BingSiteAuth.xml';
        } else if ($fileType == 'google') {
            $path_filename = $target_dir . 'google-site-verification.html';
        }
        // Check if file already exists
        if (file_exists($path_filename)) {
            unlink($path_filename);
        }
        move_uploaded_file($temp_name, $path_filename);
        $this->set('msg', Labels::getLabel('LBL_File_uploaded_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteVerificationFile($fileType)
    {
        if ($fileType == '') {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId), true);
        }
        $target_dir = CONF_UPLOADS_PATH;
        if ($fileType == 'bing') {
            $path_filename = $target_dir . 'BingSiteAuth.xml';
        } else {
            $path_filename = $target_dir . 'google-site-verification.html';
        }
        if (file_exists($path_filename)) {
            unlink($path_filename);
        }
        $this->set('msg', Labels::getLabel('LBL_File_deleted_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_CONFIGURATION_&_MANAGEMENT', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => Labels::getLabel('LBL_GENERAL_SETTINGS', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
