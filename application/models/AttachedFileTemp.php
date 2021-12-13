<?php

class AttachedFileTemp extends AttachedFile
{
    public const DB_TBL = 'tbl_attached_files_temp';
    public const DB_TBL_PREFIX = 'afile_';

    private $_isDownloaded;

    /**
     * set afile_downloaded  while saving record
     */
    public function setDownloadedAttr(bool $value)
    {
        $this->_isDownloaded = (int) $value;
    }

    protected function updateFileToDb($fileType, $recordId, $recordSubid, $fileLoc, $name, $langId, $screen, $displayOrder, $uniqueRecord, $aspectRatio = 0)
    {
        $defaultLangIdForErrors = ($langId == 0) ? $this->commonLangId : $langId;
        $this->assignValues(
            array(
                'afile_type' => $fileType,
                'afile_record_id' => $recordId,
                'afile_record_subid' => $recordSubid,
                'afile_physical_path' => $fileLoc,
                'afile_name' => $name,
                'afile_lang_id' => $langId,
                'afile_screen' => $screen,
                'afile_aspect_ratio' => $aspectRatio
            )
        );

        $db = FatApp::getDb();

        if ($displayOrder == -1) {
            //@todo display order thing needs to be checked.
            $smt = $db->prepareStatement(
                'SELECT MAX(afile_display_order) AS max_order FROM ' . static::DB_TBL . '
                    WHERE afile_type = ? AND afile_record_id = ? AND afile_record_subid = ? AND afile_lang_id = ?'
            );
            $smt->bindParameters('iii', $fileType, $recordId, $recordSubid, $langId);

            $smt->execute();
            $row = $smt->fetchAssoc();

            $displayOrder = FatUtility::int($row['max_order']) + 1;
        }

        $this->setFldValue('afile_display_order', $displayOrder);
        $this->setFldValue('afile_updated_at', date("Y-m-d H:i:s"));

        if ($this->_isDownloaded != null) {
            $this->setFldValue('afile_downloaded', $this->_isDownloaded);
        }

        if (!$this->save()) {
            $this->error = Labels::getLabel('MSG_COULD_NOT_SAVE_FILE', $defaultLangIdForErrors);
            return false;
        }

        if ($uniqueRecord) {
            $db->deleteRecords(
                static::DB_TBL,
                array(
                    'smt' => 'afile_type = ? AND afile_record_id = ? AND afile_record_subid = ? AND afile_lang_id = ?  AND afile_id != ? AND afile_screen = ?',
                    'vals' => array($fileType, $recordId, $recordSubid, $langId, $this->mainTableRecordId, $screen)
                )
            );
        }

        $this->setRecordModifiedTime($fileType, $recordId);

        return $fileLoc;
    }

}
