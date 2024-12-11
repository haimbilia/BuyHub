<?php

trait BadgeRequestSetup
{
    /**
     * getRequestedBadgeObj
     *
     * @return object
     */
    private function getRequestedBadgeObj(): object
    {
        $srch = new SearchBase(BadgeRequest::DB_TBL, 'breq');
        $srch->joinTable(BadgeLinkCondition::DB_TBL, 'INNER JOIN', 'blinkcond_id = breq_blinkcond_id', 'blc');
        $srch->joinTable(Badge::DB_TBL, 'INNER JOIN', 'badge_id = blinkcond_badge_id', 'bdg');
        $srch->joinTable(Badge::DB_TBL_LANG, 'LEFT JOIN', 'badgelang_badge_id = badge_id AND badgelang_lang_id = ' . $this->siteLangId, 'bdg_l');

        $srch->addMultipleFields(array_merge(
            BadgeRequest::ATTR,
            [
                'COALESCE(' . Badge::DB_TBL_PREFIX . 'name, ' . Badge::DB_TBL_PREFIX . 'identifier) as ' . Badge::DB_TBL_PREFIX . 'name',
                Badge::DB_TBL_PREFIX . 'id', BadgeLinkCondition::DB_TBL_PREFIX . 'from_date', BadgeLinkCondition::DB_TBL_PREFIX . 'to_date'
            ]
        ));

        $srch->addCondition(BadgeRequest::DB_TBL_PREFIX . 'user_id', '=', UserAuthentication::getLoggedUserId());
        $srch->addOrder(BadgeRequest::DB_TBL_PREFIX . 'requested_on', 'DESC');
        return $srch;
    }

    /**
     * getBadgeForm
     *
     * @param  mixed $badgeReqId
     * @return object
     */
    private function getBadgeForm(int $badgeReqId = 0, int $badgeId = 0): object
    {
        $frm = new Form('frmBadgeReq');
        $frm->addHiddenField('', 'breq_id');
        $frm->addHiddenField('', 'record_ids');
        $frm->addHiddenField('', 'breq_blinkcond_id');

        if (0 < $badgeReqId || 0 < $badgeId) {
            $frm->addHiddenField('', 'badge_id', $badgeId);
        } else {
            $approvalRequiredBadges = BadgeLinkCondition::getApprovalRequestBadges($this->siteLangId);
            $fld = $frm->addSelectBox(Labels::getLabel('FRM_SELECT_BADGE', $this->siteLangId), 'badge_id', $approvalRequiredBadges, '', [], '');
            $fld->requirements()->setRequired(true);
        }

        $frm->addDateTimeField(Labels::getLabel('FRM_FROM_DATE', $this->siteLangId), 'blinkcond_from_date', '', ['readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender date_js']);
        $frm->addDateTimeField(Labels::getLabel('FRM_TO_DATE', $this->siteLangId), 'blinkcond_to_date', '', ['readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender date_js']);

        if (0 < $badgeReqId) {
            $frm->addHiddenField('', 'breq_record_type',);
        } else {
            $frm->addSelectBox(Labels::getLabel('FRM_RECORD_TYPE', $this->siteLangId), 'breq_record_type', BadgeLinkCondition::getRecordTypeArr($this->siteLangId), '', [], '');
        }

        $frm->addFileUpload(Labels::getLabel('FRM_REFERENCE', $this->siteLangId), 'breq_file');

        $frm->addTextArea(Labels::getLabel('FRM_MESSAGE', $this->siteLangId), 'breq_message');

        $frm->addSelectBox(Labels::getLabel('FRM_LINK_TO', $this->siteLangId), 'badgelink_record_id', [], '', ['placeholder' => Labels::getLabel('LBL_SEARCH_RECORD', $this->siteLangId), 'class' => 'recordIds--js'], '');
        return $frm;
    }

    /**
     * setupBadgeRequestImage
     *
     * @param  int $badgeReqId
     * @return bool
     */
    private function setupBadgeRequestImage(int $badgeReqId): bool
    {
        if (!array_key_exists('breq_file', $_FILES) || empty($_FILES['breq_file']['name'])) {
            return true;
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->saveImage(
            $_FILES['breq_file']['tmp_name'],
            AttachedFile::FILETYPE_BADGE_REQUEST,
            $badgeReqId,
            0,
            $_FILES['breq_file']['name'],
            -1,
            false,
            0,
            $_FILES['breq_file']['type'],
            0
        )) {
            $this->error = $fileHandlerObj->getError();
            return false;
        }
        return true;
    }

    /**
     * setupBadgeReq
     *
     * @return void
     */
    public function setupBadgeReq()
    {
        $this->userPrivilege->canEditBadgesAndRibbons();

        $badgeReqId = FatApp::getPostedData('breq_id', FatUtility::VAR_INT, 0);
        $badgeId = FatApp::getPostedData('badge_id', FatUtility::VAR_INT, 0);
        $recordType = FatApp::getPostedData('breq_record_type', FatUtility::VAR_INT, 0);
        $frm = $this->getBadgeForm($badgeReqId, $badgeId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        if (isset($_FILES['breq_file']['tmp_name']) && !empty($_FILES['breq_file']['tmp_name'])) {
            $fileHandlerObj = new AttachedFile();
            if (false === $fileHandlerObj->validateFile($_FILES['breq_file']['tmp_name'], $_FILES['breq_file']['name'], $this->siteLangId)) {
                FatUtility::dieJsonError($fileHandlerObj->getError());
            }
        }

        $badgeLinkCondId = FatApp::getPostedData('breq_blinkcond_id', FatUtility::VAR_INT, 0);
        if (1 > $badgeLinkCondId && 1 > $badgeId) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_BADGE', $this->siteLangId));
        }

        $recordIds = isset($post['record_ids']) ? json_decode($post['record_ids'], true) : [];

        if (BadgeLinkCondition::RECORD_TYPE_SHOP == $recordType) {
            $shopId = Shop::getAttributesByUserId($this->userParentId, 'shop_id');
            if (false === $shopId || 1 > $shopId) {
                FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_SHOP', $this->adminLangId));
            }
            $recordIds = [$shopId];
        }

        if (null === $recordIds || false === $recordIds || empty($recordIds)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_SELECT_ATLEAST_ONE_RECORD', $this->siteLangId));
        }

        /* Badge Condition Setup if not added. */
        if (1 > $recordType) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_RECORD_TYPE', $this->siteLangId));
        }

        $fromDate = FatApp::getPostedData('blinkcond_from_date', FatUtility::VAR_STRING, '');
        $toDate = FatApp::getPostedData('blinkcond_to_date', FatUtility::VAR_STRING, '');

        if (!empty($fromDate) && !empty($toDate) && $fromDate > $toDate) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_TO_DATE_MUST_BE_GREATER_THAN_OR_EQUAL_TO_FROM_DATE', $this->siteLangId));
        }

        $db = FatApp::getDb();
        $db->startTransaction();

        $data = [
            'blinkcond_badge_id' => $badgeId,
            'blinkcond_record_type' => $recordType,
            'blinkcond_from_date' => $fromDate,
            'blinkcond_to_date' => $toDate,
            'blinkcond_user_id' => UserAuthentication::getLoggedUserId(),
        ];

        if (0 < $badgeLinkCondId) {
            unset($data['blinkcond_user_id']);
        }

        $record = new BadgeLinkCondition($badgeLinkCondId);
        $record->assignValues($data);
        if (!$record->save()) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError($record->getError());
        }

        $badgeLinkCondId = $record->getMainTableRecordId();
        $post['breq_blinkcond_id'] = $badgeLinkCondId;

        /* Badge Condition Setup if added. */
        $post['breq_requested_on'] = date('Y-m-d H:i:s');
        $post['breq_user_id'] = UserAuthentication::getLoggedUserId();

        $status = BadgeRequest::getRequestStatus($post['breq_blinkcond_id'], UserAuthentication::getLoggedUserId());
        if (BadgeRequest::REQUEST_APPROVED == $status || BadgeRequest::REQUEST_REJECTED == $status) {
            $db->rollbackTransaction();
            $msg = Labels::getLabel('MSG_YOUR_REQUEST_TO_THIS_BADGE_ID_ALREADY_APPROVED/REJECTED', $this->siteLangId);
            FatUtility::dieJsonError($msg);
        }

        $record = new BadgeRequest($badgeReqId);
        $record->assignValues($post);

        if (!$record->save()) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError($record->getError());
        }

        $badgeReqId = $record->getMainTableRecordId();
        if (false === $this->setupBadgeRequestImage($badgeReqId)) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError($this->error);
        }

        foreach ($recordIds as $recordId) {
            $linkData = array(
                'badgelink_blinkcond_id' => $badgeLinkCondId,
                'badgelink_record_id' => $recordId,
                'badgelink_breq_id' => $badgeReqId
            );
            FatApp::getDb()->insertFromArray(BadgeLinkCondition::DB_TBL_BADGE_LINKS, $linkData);
        }

        $db->commitTransaction();
        CalculativeDataRecord::updateBadgeRequestCount();
        $msg = Labels::getLabel("MSG_REQUESTED_SUCCESSFULLY", $this->siteLangId);
        if (0 < $badgeReqId) {
            $msg = Labels::getLabel("MSG_REQUEST_UPDATED_SUCCESSFULLY", $this->siteLangId);
        }
        $this->set('msg', $msg);
        $this->set('badgeReqId', $badgeReqId);
        $this->set('badgeId', $badgeId);
        $this->_template->render(false, false, 'json-success.php');
    }

    /**
     * badgeReqForm
     *
     * @param  int $badgeReqId
     * @param  int $badgeId
     * @return void
     */
    public function badgeReqForm($badgeReqId = 0, $badgeId = 0)
    {
        $this->userPrivilege->canEditBadgesAndRibbons();
        $frm = $this->getBadgeForm($badgeReqId, $badgeId);
        $res = [];
        if (0 < $badgeReqId) {
            $srch = $this->getRequestedBadgeObj();
            $srch->addCondition('breq_id', '=', $badgeReqId);
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $requestedBadge = FatApp::getDb()->fetch($srch->getResultSet());
            if ($requestedBadge === false) {
                FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            }
            $requestedBadge['record_ids'] = json_encode($this->records($badgeReqId, true));
            $badgeId = $requestedBadge['badge_id'];
            $frm->fill($requestedBadge);

            $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $badgeReqId);
        }
        $this->set('attachment', $res);

        $approvalRequiredBadges = BadgeLinkCondition::getApprovalRequestBadges($this->siteLangId);
        $this->set('approvalRequiredBadges', $approvalRequiredBadges);
        $this->set('frm', $frm);
        $this->set('badgeReqId', $badgeReqId);
        $this->set('badgeId', $badgeId);
        $this->_template->render(false, false, 'badges/badge-req-form.php');
    }

    /**
     * getRecordType
     *
     * @param  int $blinkcond_id
     * @return void
     */
    public function getRecordType(int $blinkcond_id)
    {
        $json = [
            'recordType' => (int) BadgeLinkCondition::getAttributesById($blinkcond_id, 'blinkcond_record_type')
        ];

        FatUtility::dieJsonSuccess($json);
    }

    /**
     * records
     *
     * @param  int $badgeReqId
     * @param  int $returnAllRecordIds
     * @return void
     */
    public function records(int $badgeReqId, bool $returnAllRecordIds = false)
    {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;

        $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->siteLangId, true);
        /* Bind Records */
        $srch->joinProduct($this->siteLangId);
        $srch->joinSellerProduct($this->siteLangId);
        $srch->joinShop($this->siteLangId);
        /* Bind Records */
        $srch->joinTable(BadgeRequest::DB_TBL, 'INNER JOIN', 'blc.badgelink_breq_id = breq.breq_id', 'breq');

        if (false === $returnAllRecordIds) {
            $srch->setPageNumber($page);
            $srch->setPageSize($pagesize);
        } else {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
        }

        $srch->addCondition('breq_id', '=', $badgeReqId);
        $result = FatApp::getDb()->fetchAll($srch->getResultSet(), 'badgelink_record_id');

        if (true === $returnAllRecordIds) {
            return array_keys($result);
        }

        $records = [];
        foreach ($result as $badgeLink) {
            if (array_key_exists('badgelink_record_id', $badgeLink) && empty($badgeLink['badgelink_record_id'])) {
                break;
            }

            $recordId = $badgeLink['badgelink_record_id'];
            $recordName = $badgeLink['record_name'];
            $optionName = !empty($badgeLink['option_name']) ? explode('|', $badgeLink['option_name']) : [];
            $optionValueName = !empty($badgeLink['option_value_name']) ? explode('|', $badgeLink['option_value_name']): [];
            $seller = $badgeLink['seller'];
            unset($badgeLink['badgelink_record_id'], $badgeLink['record_name'], $badgeLink['option_name'], $badgeLink['option_value_name'], $badgeLink['seller']);

            if (BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT == $badgeLink['blinkcond_record_type']) {
                $name = $recordName;
                if (isset($records[$recordId]['record_name'])) {
                    $name = $records[$recordId]['record_name'];
                }

                $option = '';
                foreach ($optionName as $index => $optname) {
                    $option .= !empty($optname) ? ' | ' .  $optname . ' : ' . (isset($optionValueName[$index]) ? $optionValueName[$index] : '') : '';
                }
                $recordName = $name . $option . ' | ' . $seller;
            }

            $records[$recordId] = [
                'badgelink_record_id' => $recordId,
                'record_name' => $recordName
            ];
        }

        $this->set('badgeReqId', $badgeReqId);
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('recordCount', $srch->recordCount());
        $this->set('pageCount', $srch->pages());
        $this->set('records', $records);
        $this->set('postedData', FatApp::getPostedData());
        $this->_template->render(false, false, 'badges/records.php');
    }

    /**
     * unlinkRecord
     *
     * @param  int $badgeReqId
     * @param  int $record_id
     * @return void
     */
    public function unlinkRecord(int $badgeReqId, int $record_id = 0)
    {
        if (1 > $badgeReqId) {
            if(1 > $record_id) {
                FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            } 
            FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESS', $this->siteLangId));
        }
        $smt = 'badgelink_breq_id = ?';
        $vals = [$badgeReqId];
        if (0 < $record_id) {
            $smt .= ' AND badgelink_record_id = ?';
            $vals[] = $record_id;
        }

        $db = FatApp::getDb();
        if (!$db->deleteRecords(
            BadgeLinkCondition::DB_TBL_BADGE_LINKS,
            [
                'smt' => $smt,
                'vals' => $vals
            ]
        )) {
            FatUtility::dieJsonError($db->getError());
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESS', $this->siteLangId));
    }
}
