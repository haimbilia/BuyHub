<?php

require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';
require_once CONF_INSTALLATION_PATH . 'library/GoogleFonts.class.php';

use Curl\Curl;

class ThemeColorController extends AdminBaseController
{
    private $apiKey;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewThemeColor();

        $this->apiKey = FatApp::getConfig('CONF_GOOGLE_FONTS_API_KEY', FatUtility::VAR_STRING, '');
        $this->set("apiKey", $this->apiKey);
    }

    public function index()
    {
        $record = Configurations::getConfigurations();

        $googleFontFamily = FatApp::getConfig('CONF_THEME_FONT_FAMILY', FatUtility::VAR_STRING, '');
        if (!empty($this->apiKey) && array_key_exists('CONF_THEME_FONT_FAMILY', $record) && ('' == $record['CONF_THEME_FONT_FAMILY'] || 'Poppins' == $googleFontFamily)) {
            $record['CONF_THEME_FONT_FAMILY'] = 'Poppins';
            $record['CONF_THEME_FONT_WEIGHT'] = '[{"id":"regular","value":"Poppins - Regular","subset":["devanagari","latin","latin-ext"]}]';
        }
        
        $frm = $this->getFontsForm();
        $frm->fill($record);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($this->adminLangId));
        $this->_template->addJs(array('js/tagify.min.js', 'js/tagify.polyfills.min.js'));
        $this->_template->addCss(array('css/tagify.min.css'));
        $this->_template->render();
    }

    private function getFontsForm()
    {
        $frm = new Form('frmGoogleFonts');
        $frm->addHiddenField("", 'CONF_THEME_COLOR_RGB');
        $frm->addHiddenField("", 'CONF_THEME_COLOR_HSL');
        $frm->addHiddenField("", 'CONF_THEME_COLOR_INVERSE_RGB');
        $frm->addHiddenField("", 'CONF_THEME_COLOR_INVERSE_HSL');

        if (!empty($this->apiKey)) {
            $frm->addHiddenField("", 'CONF_THEME_FONT_FAMILY_URL');
            $fld = $frm->addRequiredField(Labels::getLabel('LBL_FONT_FAMILY:', $this->adminLangId), 'CONF_THEME_FONT_FAMILY');
            $link = "<a href='https://fonts.google.com' target='_blank'>https://fonts.google.com</a>";
            $url = CommonHelper::replaceStringData(Labels::getLabel('LBL_REFERENCE_:_{URL}', $this->adminLangId), ['{URL}' => $link]);
            $fld->htmlAfterField = '<small>' . $url . ' </small>';
            $frm->addRequiredField(Labels::getLabel('LBL_FONT_WEIGHT:', $this->adminLangId), 'CONF_THEME_FONT_WEIGHT');
        }

        $frm->addRequiredField(Labels::getLabel('LBL_THEME_COLOR', $this->adminLangId), 'CONF_THEME_COLOR');
        $frm->addRequiredField(Labels::getLabel('LBL_THEME_COLOR_INVERSE', $this->adminLangId), 'CONF_THEME_COLOR_INVERSE');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->adminLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_RESET', $this->adminLangId), ['title' => Labels::getLabel('LBL_RESET_TO_DEFAULT_VALUES', $this->adminLangId)]);
        return $frm;
    }

    private function getFonts(): array
    {
        $this->objPrivilege->canEditThemeColor();

        if (empty($this->apiKey)) {
            LibHelper::exitWithError(Labels::getLabel('MSG_API_KEY_FOR_GOOGLE_FONTS_NOT_CONFIGURED', $this->adminLangId), true);
        }

        $googleFonts = CacheHelper::get('googleFonts' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($googleFonts) {
            $fontsArr = json_decode($googleFonts, true);
        } else {
            $curl = new Curl();
            $curl->get('https://www.googleapis.com/webfonts/v1/webfonts?key=' . $this->apiKey);
            if ($curl->error) {
                LibHelper::exitWithError($curl->errorCode . ': ' . $curl->errorMessage, true);
            }

            if (!isset($curl->response->items)) {
                LibHelper::exitWithError(Labels::getLabel('MSG_UNABLE_TO_LOAD_FONTS', $this->adminLangId), true);
            }

            $fontsArr = json_decode(json_encode($curl->response), true);
            CacheHelper::create('googleFonts' . $this->adminLangId, json_encode($fontsArr));
        }
        return $fontsArr;
    }

    public function getGoogleFonts()
    {
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $fontsArr = $this->getFonts();

        $fonts = [];
        foreach ($fontsArr['items'] as $font) {
            if (!empty($keyword) && false === strpos(strtolower($font['family']), strtolower($keyword))) {
                continue;
            }

            $fontName = str_replace(' ', '+', $font['family']);
            $fonts[] = [
                'id' => $fontName,
                'name' => $fontName,
                'text' => $font['family'],
            ];
        }

        FatUtility::dieJsonSuccess(['fonts' => $fonts]);
    }
        
    public function getVariants()
    {
        $selectedFont = FatApp::getPostedData('fontName', FatUtility::VAR_STRING, '');
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        if (empty($selectedFont)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $fontsArr = $this->getFonts();

        $fonts = [];
        foreach ($fontsArr['items'] as $font) {
            if (strtolower($selectedFont) != strtolower($font['family'])) {
                continue;
            }

            $fontName = str_replace(' ', '+', $font['family']);
            if (!empty($keyword) && false === strpos(strtolower($fontName), strtolower($keyword))) {
                continue;
            }
            foreach ($font['variants'] as $variant) {
                $name = $fontName . '-' . $variant;
                $fonts[] = [
                    'id' => $name,
                    'name' => $font['family'] . ' - ' . ucwords($variant),
                    'text' => $name,
                    'weight' => $variant,
                    'subset' => $font['subsets'],
                ];
            }
        }

        FatUtility::dieJsonSuccess(['fonts' => $fonts]);
    }

    public function loadGoogleFont()
    {
        if (empty(FatApp::getPostedData('name', FatUtility::VAR_STRING, ''))) {
            $json['html'] = '';
            LibHelper::exitWithError($json, true);
        }
        $font = new GoogleFonts(FatApp::getPostedData(), true);
        $json['html'] = $font->load();
        FatUtility::dieJsonSuccess($json);
    }

    public function setupFontStyle()
    {
        $this->objPrivilege->canEditThemeColor();

        $frm = $this->getFontsForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        $fontFamily = FatApp::getPostedData('CONF_THEME_FONT_FAMILY', FatUtility::VAR_STRING, '');
        $post['CONF_THEME_FONT_FAMILY'] = empty($this->apiKey) ? 'Poppins' : $fontFamily;
        $record = new Configurations();
        if (!$record->update($post)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function resetToDefault()
    {
        $this->objPrivilege->canEditThemeColor();

        $data = [
            "CONF_THEME_FONT_FAMILY_URL" => "",
            "CONF_THEME_FONT_FAMILY" => 'Poppins',
            "CONF_THEME_COLOR" => "#FF3A59",
            "CONF_THEME_COLOR_RGB" => "255,58,89",
            "CONF_THEME_COLOR_HSL" => "351,100%,61%",
            "CONF_THEME_COLOR_INVERSE" => "#ffffff",
            "CONF_THEME_COLOR_INVERSE_RGB" => "255,255,255",
            "CONF_THEME_COLOR_INVERSE_HSL" => "0,0%,100%",
            "CONF_THEME_FONT_WEIGHT" => '[{"id":"regular","value":"Poppins - Regular","subset":["devanagari","latin","latin-ext"]}]',
        ];

        $record = new Configurations();
        if (!$record->update($data)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_COMPLETED', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
}
