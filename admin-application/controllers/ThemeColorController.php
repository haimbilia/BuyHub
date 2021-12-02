<?php

require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';
require_once CONF_INSTALLATION_PATH . 'library/GoogleFonts.class.php';

use Curl\Curl;

class ThemeColorController extends AdminBaseController
{
    private $canView;
    private $canEdit;
    private $apiKey;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewThemeColor($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditThemeColor($this->admin_id, true);
        $this->apiKey = FatApp::getConfig('CONF_GOOGLE_FONTS_API_KEY', FatUtility::VAR_STRING, '');
        $this->set("apiKey", $this->apiKey);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewThemeColor();

        $record = Configurations::getConfigurations();

        $googleFontFamily = FatApp::getConfig('CONF_THEME_FONT_FAMILY', FatUtility::VAR_STRING, '');
        if (!empty($this->apiKey) && array_key_exists('CONF_THEME_FONT_FAMILY', $record) && ('' == $record['CONF_THEME_FONT_FAMILY'] || 'Poppins' == $googleFontFamily)) {
            $record['CONF_THEME_FONT_FAMILY'] = 'Poppins-regular';
        }
        
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

        if (!empty($this->apiKey)) {
            $frm->addHiddenField("", 'CONF_THEME_FONT_FAMILY_URL');
            $fld = $frm->addSelectBox(Labels::getLabel('LBL_FONT_FAMILY:', $this->adminLangId), 'CONF_THEME_FONT_FAMILY', [], '', array('placeholder' => Labels::getLabel('LBL_FONT_FAMILY:', $this->adminLangId)));
            $fld->requirement->setRequired(true);
            $link = "<a href='https://fonts.google.com' target='_blank'>https://fonts.google.com</a>";
            $url = CommonHelper::replaceStringData(Labels::getLabel('LBL_REFERENCE_:_{URL}', $this->adminLangId), ['{URL}' => $link]);
            $fld->htmlAfterField = '<small>' . $url . ' </small>';
        }

        $frm->addRequiredField(Labels::getLabel('LBL_THEME_COLOR', $this->adminLangId), 'CONF_THEME_COLOR');
        $frm->addRequiredField(Labels::getLabel('LBL_THEME_COLOR_INVERSE', $this->adminLangId), 'CONF_THEME_COLOR_INVERSE');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_RESET', $this->adminLangId), ['title' => Labels::getLabel('LBL_RESET_TO_DEFAULT_VALUES', $this->adminLangId)]);
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    public function getGoogleFonts()
    {
        $this->objPrivilege->canEditThemeColor();

        if (empty($this->apiKey)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_API_KEY_FOR_GOOGLE_FONTS_NOT_CONFIGURED', $this->adminLangId));
        }

        $curl = new Curl();
        $curl->get('https://www.googleapis.com/webfonts/v1/webfonts?key=' . $this->apiKey);
        if ($curl->error) {
            FatUtility::dieJsonError($curl->errorCode . ': ' . $curl->errorMessage);
        }

        if (!isset($curl->response->items)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_UNABLE_TO_LOAD_FONTS', $this->adminLangId));
        }

        $googleFontsResp = json_decode(json_encode($curl->response), true);
        
        $fonts = [];
        foreach ($googleFontsResp['items'] as $font) {
            $fontName = str_replace(' ', '+', $font['family']);
            $i = 1;
            $allWeights = [];
            $allSubsets = [];
            foreach ($font['variants'] as $variant) {
                $name = $fontName . '-' . $variant;
                $fonts[] = [
                    'id' => $name,
                    'name' => $font['family'] . ' - ' . ucwords($variant),
                    'text' => $name,
                    'weight' => $variant,
                    'subset' => implode(',', $font['subsets']),
                ];

                $allWeights[] = $variant;
                $allSubsets = array_merge($allSubsets, $font['subsets']);
                if (1 < count($font['variants']) && $i == count($font['variants'])) {
                    $fonts[] = [
                        'id' => $fontName . '-' . Labels::getLabel('LBL_ALL', $this->adminLangId),
                        'name' => $font['family'] . ' - ' . Labels::getLabel('LBL_ALL', $this->adminLangId),
                        'text' => $fontName . '-' . Labels::getLabel('LBL_ALL', $this->adminLangId),
                        'weight' => implode(',', $allWeights),
                        'subset' => implode(',', array_unique($allSubsets)),
                    ];
                }
                $i++;
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
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $fontFamily = FatApp::getPostedData('CONF_THEME_FONT_FAMILY', FatUtility::VAR_STRING, '');
        $post['CONF_THEME_FONT_FAMILY'] = empty($this->apiKey) ? 'Poppins' : $fontFamily;

        $record = new Configurations();
        if (!$record->update($post)) {
            FatUtility::dieJsonError($record->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function resetToDefault()
    {
        $this->objPrivilege->canEditThemeColor();

        $font = empty($this->apiKey) ? 'Poppins' : 'Poppins-regular';

        $data = [
            "CONF_THEME_FONT_FAMILY_URL" => "",
            "CONF_THEME_FONT_FAMILY" => $font,
            "CONF_THEME_COLOR" => "rgb(255,58,89)",
            "CONF_THEME_COLOR_INVERSE" => "rgb(255,255,255)",
        ];

        $record = new Configurations();
        if (!$record->update($data)) {
            FatUtility::dieJsonError($record->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_COMPLETED', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
}
