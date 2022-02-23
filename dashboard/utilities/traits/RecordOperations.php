<?php
/*
* This class has been used to perform record related operations.
*/
trait RecordOperations
{
    protected function setLangData(object $classObj, array $langDataArr, $langId = 0)
    {

        $recordId = $classObj->getMainTableRecordId();
        if (!$classObj->updateLangData((0 < $langId  ? $langId : CommonHelper::getDefaultFormLangId()), $langDataArr)) {
            Message::addErrorMessage($classObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }       
        $newTabLangId = 0;
        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        if (0 < count($languages)) {
            foreach ($languages as $languageId => $langName) {
                if (!$classObj::getAttributesByLangId($languageId, $recordId)) {
                    $newTabLangId = $languageId;
                    break;
                }
            }
        }
       
        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData($classObj::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId, CommonHelper::getDefaultFormLangId())) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
        }  

        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->set('msg', $this->str_setup_successful);
    } 
}
