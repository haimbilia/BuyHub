<?php
class HtmlHelper
{   
    public static function addButtonHtml(string $lbl, string $type = 'button', $name = '', $class = '', $onclick = ''): string
    {
        $name = (!empty($name) ? 'name="' . $name . '"' : '');
        $onclick = (!empty($onclick) ? 'onclick="' . $onclick . ';"' : '');
        $class = !empty($class) ? $class : 'btn btn-brand btn-wide btn-search submitBtnJs';
        return '<button type="' . $type . '" ' . $name . ' class="' . $class . '" ' . $onclick . '>' . $lbl . '</button>';
    }
    
    public static function addSearchButton(Form &$frm, string $lbl = '')
    {
        $lbl = empty($lbl) ? Labels::getLabel('FRM_SEARCH', CommonHelper::getLangId()) : $lbl;
        $frm->addHtml('', 'btn_submit', self::addButtonHtml($lbl, 'submit', 'btn_submit'));
    }

    public static function addClearButton(Form &$frm, string $btnClass = 'btn btn-link', string $lbl = '')
    {
        $lbl = empty($lbl) ? Labels::getLabel('FRM_CLEAR', CommonHelper::getLangId()) : $lbl;
        $frm->addHtml('', 'btn_clear', self::addButtonHtml($lbl, 'button', 'btn_clear', $btnClass, 'clearSearch()'));
    }


    public static function formatFormFields(Form &$frm, $col = 12)
    {
        $frm->setCustomRendererClass('FormRendererBS');
        /* For Each Row On Above Elements */
        $frm->developerTags['colWidthClassesDefault'] = [null, 'col-md-', null, null];
        $frm->developerTags['colWidthValuesDefault'] = [null, $col, null, null];
        /* For Each Row On Above Elements */

        /* For Input Fields */
        $frm->developerTags['fldWidthClassesDefault'] = ['', '', '', ''];
        $frm->developerTags['fldWidthValuesDefault'] = ['', '', '', ''];
        /* For Input Fields */

        /* For Labels Fields */
        $frm->developerTags['labelWidthClassesDefault'] = ['label', 'label', 'label', 'label'];
        $frm->developerTags['labelWidthValuesDefault'] = ['', '', '', ''];
        /* For Labels Fields */

        /* Group Label and Input field. */
        $frm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';
        /* Group Label and Input field. */
    }

    public static function configureSwitchForCheckbox($fld, $msg = '')
    {
        $fld->developerTags['fldWidthValues'] = ['setting-block', null, null, null];
        $fld->developerTags['cbLabelAttributes'] = ['class' => 'switch switch-sm switch-icon'];
        $fld->developerTags['cbHtmlAfterCheckbox'] = '<span class="input-helper"></span>';
        if (!empty($msg)) {
            $fld->htmlAfterField = '<span class="form-text text-muted">' . $msg . '</span>';
        }
    }

    public static function configureSwitchForRadio($fld, $msg = '')
    {
        $fld->developerTags['rdLabelAttributes'] = ['class' => 'radio'];
        if (!empty($msg)) {
            $fld->htmlAfterField = '<span class="form-text text-muted">' . $msg . '</span>';
        }
    }
    /**
     * getFieldHtml
     *
     * @param  Form $frm
     * @param  string $fldName
     * @param  int $col
     * @param  array $setFieldTagAttrs
     * @param  string $fieldInfoText
     * @param  string $labelInfoText : To show tooltip on label
     * @param  array $labelExtraArr : [
     *                                   'attr' => [
     *                                       'href' => 'javascript:void(0)',
     *                                       'onclick' => 'FN()',
     *                                       'title' => <TITLE>
     *                                   ],
     *                                   'label' => <LABEL>
     *                               ]
     * @param  bool $doNotAddFieldWrapper
     * @return string
     */
    public static function getFieldHtml(Form $frm, string $fldName, int $col = 6, array $setFieldTagAttrs = [],  string $fieldInfoText = '', string $labelInfoText = '', array $labelExtraArr = [], bool $doNotAddFieldWrapper = false): string
    {
        
        $fld = $frm->getField($fldName);
        if (null == $fld) {
            return '';
        }

        foreach ($setFieldTagAttrs as $attrkey => $attrVal) {
            $fld->setfieldTagAttribute($attrkey, $attrVal);
        }
        $caption = $fld->getCaption();

        switch ($fld->fldType) {
            case 'radio':
                $fld->addOptionListTagAttribute('class', 'list-radio');
                self::configureSwitchForRadio($fld);
                break;
            case 'hidden':
                return $fld->getHtml();
                break;
        }

        if ($doNotAddFieldWrapper) {
            if (!empty($labelExtraArr)) {
                $mainDiv = $div = new HtmlElement('div', [
                    'class' => 'd-flex justify-content-between',
                ]);

                $label = $div->appendElement('label', [
                    'class' => 'label',
                ], $caption);
            } else {

                $mainDiv = $div = $label =  new HtmlElement('label', [
                    'class' => 'label',
                ], $caption);
            }
        } else {
            $mainDiv = new HtmlElement("div", [
                'class' => 'col-md-' . $col,
            ]);

            $div1 =  $div = $mainDiv->appendElement('div', [
                'class' => 'form-group',
            ]);

            if (!empty($labelExtraArr)) {
                $div =  $div->appendElement('div', [
                    'class' => 'd-flex justify-content-between',
                ]);
            }

            $label = $div->appendElement('label', [
                'class' => 'form-label',
            ], $caption);
        }

        if ($fld->requirements()->isRequired()) {
            $label->appendElement('span', [
                'class' => 'spn_must_field',
            ], '*');
        }

        if (!empty($labelInfoText)) {
            $label->appendElement('i', [
                'class' => 'fas fa-exclamation-circle',
                'data-bs-toggle' => 'tooltip',
                'data-original-title' => $labelInfoText,
            ]);
        }

        if (isset($labelExtraArr['attr']) && isset($labelExtraArr['label'])) {
            $div->appendElement('a', $labelExtraArr['attr'], $labelExtraArr['label']);
        }
        /*** label  ] */

        if (!empty($fieldInfoText)) {
            $fld->htmlAfterField = '<span class="form-text text-muted">' . $fieldInfoText . '</span>';
        }

        if ($doNotAddFieldWrapper) {
            return $mainDiv->getHtml() . (new HtmlElement('plaintext', [], $fld->getHtml(), true))->getHtml();
        } else {
            $div1->appendElement('plaintext', [], $fld->getHtml(), true);
            return $mainDiv->getHtml();
        }
    }  
}
