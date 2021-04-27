<?php
require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';

use Curl\Curl;

class ThemeColorController extends AdminBaseController
{
    private $canView;
    private $canEdit;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewThemeColor($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditThemeColor($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->_template->addJs('js/jscolor.js');
        $this->objPrivilege->canViewThemeColor();
        $search = $this->getSearchForm();
        $this->set("search", $search);
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewThemeColor();
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = ThemeColor::getSearchObject(true);
        $srch->addMultipleFields(array('theme_id , theme_name', 'theme_added_by', 'tcolor_key', 'tcolor_value'));
        $srch->addCondition('tcolor_key', '=', ThemeColor::TYPE_BRAND);
        if (!empty($post['keyword'])) {
            $srch->addCondition('theme_name', 'like', '%' . $post['keyword'] . '%');
        }
        $srch->addOrder('theme_name', 'ASC');
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("arr_listing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->adminLangId));
        $this->_template->render(false, false);
    }

    public function listing($themeId)
    {
        $themeId = FatUtility::int($themeId);
        if (1 > $themeId) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }

        $frmSearch = $this->getSearchForm();
        $frmSearch->fill(array('theme_id' => $themeId));

        $this->set('data', $data);
        $this->set('themeId', $themeId);
        $this->set('frmSearch', $frmSearch);
        $this->_template->render();
    }

    private function getSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    public function form($themeId)
    {
        $this->objPrivilege->canEditThemeColor();
        $themeId = FatUtility::int($themeId);

        $frm = $this->getForm($themeId);

        if (0 < $themeId) {
            $data = ThemeColor::getAttributesById($themeId);

            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }
            $themeColors = ThemeColor::getById($themeId, $this->adminLangId, true);
            foreach ($themeColors as $tColor) {
                $data[$tColor['tcolor_key']] = $tColor['tcolor_value'];
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('theme_id', $themeId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function cloneForm($themeId = 0)
    {
        $this->objPrivilege->canEditThemeColor();
        $themeId = FatUtility::int($themeId);

        $frm = $this->getForm($themeId);

        if (0 < $themeId) {
            $data = ThemeColor::getAttributesById($themeId);

            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }
            $data['theme_id'] = 0;
            $data['parent_theme_id'] = $themeId;
            $data['theme_name'] = 'Copy of ' . $data['theme_name'];

            $themeColors = ThemeColor::getById($themeId, $this->adminLangId);
            foreach ($themeColors as $tColor) {
                $data[$tColor['tcolor_key']] = $tColor['tcolor_value'];
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('theme_id', $themeId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditThemeColor();

        $frm = $this->getForm();
        $post = FatApp::getPostedData();
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $themeId = $post['theme_id'];
        unset($post['theme_id']);
        $data = $post;
        $data['theme_added_by'] = $this->admin_id;
        $record = new ThemeColor($themeId);
        $record->assignValues($data);

        if (!$record->save()) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        $parentThemeId = ($post['parent_theme_id'] > 0) ? $post['parent_theme_id'] : $themeId;
        $themeColors = ThemeColor::getById($parentThemeId, $this->adminLangId);
        $newThemeId = $record->getMainTableRecordId();
        foreach ($themeColors as $tColor) {
            $dataToSave = array(
                'tcolor_theme_id' => $newThemeId,
                'tcolor_key' => $tColor['tcolor_key'],
                'tcolor_value' => isset($post[$tColor['tcolor_key']]) ? $post[$tColor['tcolor_key']] : $tColor['tcolor_value'],
            );
            $dataToUpdateOnDuplicate = $dataToSave;
            unset($dataToUpdateOnDuplicate['uextra_user_id']);
            if (!FatApp::getDb()->insertFromArray(ThemeColor::DB_TBL_COLORS, $dataToSave, false, array(), $dataToUpdateOnDuplicate)) {
                $message = Labels::getLabel("LBL_Details_could_not_be_saved!", $this->adminLangId);
                if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                }
                Message::addErrorMessage($message);
                if (FatUtility::isAjaxCall()) {
                    FatUtility::dieWithError(Message::getHtml());
                }
            }
        }

        if ($themeId > 0) {
            $this->set('msg', Labels::getLabel($this->str_update_record, $this->adminLangId));
        } else {
            $themeId = $newThemeId;
            $this->set('msg', Labels::getLabel($this->str_setup_successful, $this->adminLangId));
        }

        $this->set('themeId', $themeId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($themeId = 0)
    {
        $this->objPrivilege->canViewThemeColor();
        $themeId = FatUtility::int($themeId);
        $frm = new Form('frmThemeColor');
        $frm->addHiddenField('', 'theme_id', $themeId);
        $frm->addHiddenField('', 'parent_theme_id');

        $frm->addRequiredField(Labels::getLabel('LBL_Theme_Name', $this->adminLangId), 'theme_name');
        $themeColors = ThemeColor::getById($themeId, $this->adminLangId, true);
        $colorTypes = ThemeColor::getTypeArr($this->adminLangId);
        foreach ($themeColors as $tColor) {
            $frm->addRequiredField($colorTypes[$tColor['tcolor_key']], $tColor['tcolor_key'])->addFieldTagAttribute('class', 'jscolor');
        }
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    public function activateThemeColor($themeId = 0)
    {
        $this->objPrivilege->canEditThemeColor();
        if (FatUtility::isAjaxCall()) {
            $themeId = FatApp::getPostedData('themeId', FatUtility::VAR_INT, 0);
        }

        if (0 >= $themeId) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $data = ThemeColor::getAttributesById($themeId, array('theme_id'));

        if ($data == false) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $configurationObj = new Configurations();
        if (!$configurationObj->update(array('CONF_FRONT_THEME' => $themeId))) {
            Message::addErrorMessage($configurationObj->getError());
            if (FatUtility::isAjaxCall()) {
                FatUtility::dieJsonError(Message::getHtml());
            } else {
                FatApp::redirectUser(UrlHelper::generateUrl('ThemeColor', ''));
            }
        }
        /* $this->updateCssFiles(); */
        if (FatUtility::isAjaxCall()) {
            $this->set('msg', Labels::getLabel('Msg_Theme_Activated_Successfully', CommonHelper::getLangId()));
            $this->_template->render(false, false, 'json-success.php');
        } else {
            Message::addMessage(Labels::getLabel('Msg_Theme_Activated_Successfully', CommonHelper::getLangId()));
            FatApp::redirectUser(UrlHelper::generateUrl('ThemeColor', ''));
        }
    }

    public function deleteTheme()
    {
        $this->objPrivilege->canEditThemeColor();
        $themeId = FatApp::getPostedData('themeId', FatUtility::VAR_INT, 0);

        if (0 >= $themeId) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $data = ThemeColor::getAttributesById($themeId, array('theme_id'));

        if ($data == false) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $themeObj = new ThemeColor($themeId);
        if (!$themeObj->deleteRecord()) {
            Message::addErrorMessage($themeObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        if (!FatApp::getDb()->deleteRecords(ThemeColor::DB_TBL_COLORS, array('smt' => 'tcolor_theme_id = ?', 'vals' => array($themeId)))) {
            Message::addErrorMessage($themeObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        $this->set('msg', Labels::getLabel('Msg_Theme_Settings_Deleted_Successfully', CommonHelper::getLangId()));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function preview($themeId)
    {
        $themeId = FatUtility::int($themeId);
        if (0 >= $themeId) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatApp::redirectUser(UrlHelper::generateUrl('ThemeColor'));
        }

        /* $tObj = new ThemeColor();
        $theme = $tObj->getAttributesById($themeId); */
        if (!$themeId) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatApp::redirectUser(UrlHelper::generateUrl('ThemeColor'));
        }
        $_SESSION['preview_theme'] = $themeId;

        $this->set('theme', $themeId);
        $this->_template->render(false, false);
    }

    public function settings()
    {
        $this->objPrivilege->canViewThemeColor();

        $record = Configurations::getConfigurations();
        $frm = $this->getFontsForm();
        $frm->fill($record);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($this->adminLangId));
        $this->_template->addJs(array('js/select2.js', 'js/jscolor.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render();
    }

    private function getFontsForm()
    {
        $frm = new Form('frmGoogleFonts');
        $frm->addHiddenField("", 'CONF_THEME_FONT_FAMILY_URL');
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_FONT_FAMILY:', $this->adminLangId), 'CONF_THEME_FONT_FAMILY', [], '', array('placeholder' => Labels::getLabel('LBL_FONT_FAMILY:', $this->adminLangId)));
        $fld->requirement->setRequired(true);
        $link = "<a href='https://fonts.google.com' target='_blanlk'>https://fonts.google.com</a>";
        $url = CommonHelper::replaceStringData(Labels::getLabel('LBL_REFERENCE_:_{URL}', $this->adminLangId), ['{URL}' => $link]);
        $fld->htmlAfterField = '<small>' . $url . ' </small>';
        $frm->addRequiredField(Labels::getLabel('LBL_THEME_COLOR', $this->adminLangId), 'CONF_THEME_COLOR');
        $frm->addRequiredField(Labels::getLabel('LBL_THEME_COLOR_INVERSE', $this->adminLangId), 'CONF_THEME_COLOR_INVERSE');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->adminLangId));
        return $frm;
    }

    public function getGoogleFonts()
    {
        $this->objPrivilege->canEditThemeColor();

        $apiKey = FatApp::getConfig('CONF_GOOGLE_FONTS_API_KEY', FatUtility::VAR_STRING, '');
        if (empty($apiKey)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_API_KEY_FOR_GOOGLE_FONTS_NOT_CONFIGURED', $this->adminLangId));
        }

        $curl = new Curl();
        $curl->get('https://www.googleapis.com/webfonts/v1/webfonts?key=' . $apiKey);
        if ($curl->error) {
            FatUtility::dieJsonError($curl->errorCode . ': ' . $curl->errorMessage);
        }

        if (!isset($curl->response->items)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_UNABLE_TO_LOAD_FONTS', $this->adminLangId));
        }

        $googleFontsResp = json_decode(json_encode($curl->response), true);
        
        $fonts = [];
        foreach ($googleFontsResp['items'] as $font) {
            foreach ($font['variants'] as $variant) {
                $name = str_replace(' ', '+', $font['family']) . '-' . $variant;
                $fonts[] = [
                    'id' => $name,
                    'name' => $font['family'] . ' - ' . ucwords($variant),
                    'text' => $name,
                    'weight' => $variant,
                    'subset' => implode(',', $font['subsets']),
                ];
            }
        }

        FatUtility::dieJsonSuccess(['fonts' => $fonts]);
    }

    public function loadGoogleFont()
    {
        if (empty(FatApp::getPostedData('name', FatUtility::VAR_STRING, ''))) {
            $json['html'] = '';
            FatUtility::dieJsonError($json);    
        }
        $json['html'] = ThemeColor::loadGoogleFont(FatApp::getPostedData());
        FatUtility::dieJsonSuccess($json);
    }

    public function setupFontStyle()
    {
        $this->objPrivilege->canEditThemeColor();

        $frm = $this->getFontsForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $post['CONF_THEME_FONT_FAMILY'] = FatApp::getPostedData('CONF_THEME_FONT_FAMILY', FatUtility::VAR_STRING, '');

        $record = new Configurations();
        if (!$record->update($post)) {
            FatUtility::dieJsonError($record->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFUL', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
}
