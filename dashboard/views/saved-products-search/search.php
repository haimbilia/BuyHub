<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($arrListing)) { ?>
    <ul class="saved-searched">
        <?php foreach ($arrListing as $sn => $row) { ?>
            <li class="saved-searched-item">
                <div class="saved-searched-head">
                    <p class="date"><?php echo FatDate::format($row['pssearch_added_on']); ?></p>
                    <h6 class="h6"><?php echo ucfirst($row['pssearch_name']); ?></h6>
                    <h5 class="h5">
                        <?php
                        $str = '';
                        foreach ($row['search_items'] as $record) {
                            if (is_array($record['value'])) {
                                $str .= ' <strong>' . $record['label'] . '</strong>: ';
                                $listValues = '';
                                foreach ($record['value'] as $list) {
                                    $listValues .= $list . ',';
                                }
                                $str .= rtrim($listValues, ' , ') . ' |';
                            } else {
                                $str .= ' <strong>' . $record['label'] . '</strong>: ' . $record['value'] . ' |';
                            }
                        }
                        echo rtrim($str, '|');
                        ?>
                    </h5>
                </div>
                <div class="saved-searched-action">
                    <a href="<?php echo html_entity_decode($row['search_url']); ?>" class="btn-searched"><?php echo Labels::getLabel('LBL_View_results', $siteLangId); ?></a>
                    <button class="btn-searched" type="button" onclick="deleteSavedSearch(<?php echo $row['pssearch_id']; ?>)"><?php echo Labels::getLabel('LBL_Delete', $siteLangId); ?></button>

                </div>
            </li>
        <?php } ?>
    </ul>

<?php
    $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'siteLangId' => $siteLangId);
    $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
} else {
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId), false);
} ?>