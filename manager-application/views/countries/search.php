<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-head">
    <h3 class="card-head-label">
        <span class="card-head-title"><?php echo Labels::getLabel('LBL_NEW_PRODUCTS', $adminLangId); ?></span>
        <span class="text-muted"><?php echo sprintf(Labels::getLabel('LBL_OVER_%S_NEW_PRODUCTS', $adminLangId), $recordCount); ?></span>
    </h3>
    <div class="card-toolbar">
        <a href="#" class="btn btn-sm btn-light btn-light">
            <span class="svg-icon svg-icon-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black">
                    </rect>
                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"></rect>
                </svg>
            </span>
            <?php echo Labels::getLabel('LBL_NEW', $adminLangId); ?>
        </a>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <?php $tbl = new HtmlElement(
            'table',
            array('width' => '100%', 'class' => 'table table-dashed')
        );
        $th = $tbl->appendElement('thead')->appendElement('tr');
        foreach ($fields as $key => $val) {
            $headColumData = Common::getHeaderElementColumn($key, $sortBy, $sortOrder);
            $cls = '';
            if (in_array($key, $allowedKeysForSorting)) {
                $cls .= 'headerColumnJs ' . $headColumData['class'];
            }

            if ('action' == strtolower($key)) {
                $cls .= 'align-right';
            }

            $td = $th->appendElement('th', ['class' => $cls, 'data-field' => $key]);

            switch ($key) {
                case 'select_all':
                    $td->appendElement('plaintext', [], '<label class="checkbox"><input title="' . $val . '" type="checkbox" onclick="selectAll( $(this) )" class="selectAll-js"><i class="input-helper"></i></label>', true);
                    break;
                case 'action':
                    $td->appendElement('plaintext', [], $val);
                    break;
                default:
                    $td->appendElement('plaintext', [], $val);
                    break;
            }
        }

        $tbody = $tbl->appendElement('tbody');
        $serialNo = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;

        foreach ($arrListing as $sn => $row) {
            $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
            $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
            foreach ($fields as $key => $val) {
                $cls = ('action' == $key) ? ['class' => 'align-right'] : [];
                $td = $tr->appendElement('td', $cls);

                switch ($key) {
                    case 'select_all':
                        $td->appendElement('plaintext', array(), '');
                        break;
                    case 'listSerial':
                        $td->appendElement('plaintext', array(), $serialNo);
                        break;
                    case 'country_active':
                        '(obj, recordId, status)';
                        $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['country_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                        $statusClass = ($canEdit) ? '' : 'disabled';
                        $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';
                        
                        $htm = '<span class="switch switch--sm switch--icon">
                                    <label>
                                        <input type="checkbox" value="' . $row['country_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                                        <span></span>
                                    </label>
                                </span>';
                        $td->appendElement('plaintext', array(), $htm, true);
                        break;
                    case 'action':
                        $data = [
                            'adminLangId' => $adminLangId,
                            'recordId' => $row['country_id']
                        ];

                        if ($canEdit) {
                            $data['editButton'] = [];
                            $data['deleteButton'] = [];
                        }
                        $actionItems = $this->includeTemplate('_partial/listing-action-buttons.php', $data, false, true);
                        $td->appendElement('plaintext', $cls, $actionItems, true);
                        break;
                    default:
                        $td->appendElement('plaintext', array(), $row[$key], true);
                        break;
                }
            }
            $serialNo--;
        }
        if (count($arrListing) == 0) {
            $tbl->appendElement('tr')->appendElement(
                'td',
                array(
                    'colspan' => count($fields)
                ),
                Labels::getLabel('LBL_No_Records_Found', $adminLangId)
            );
        }
        echo $tbl->getHtml();
        ?>
    </div>

</div>
<div class="card-foot">
    <?php $postedData['page'] = $page;
    echo FatUtility::createHiddenFormFromData($postedData, array(
        'name' => 'frmReportSearchPaging'
    ));
    $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'pageSize' => $pageSize, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
    $this->includeTemplate('_partial/pagination.php', $pagingArr, false); ?>
</div>