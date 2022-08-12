<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$recordId = $recordId ?? 0;
$allOpen = $data['allOpen'] ?? $allOpen ?? false;
$searchRequest = $searchRequest ?? false;
$siteLangId = $data['siteLangId'] ?? $siteLangId ?? CommonHelper::getLangId();
$canEdit = $data['canEdit'] ?? $canEdit ?? false;
$parentCatId = $data['parentCatId'] ?? $parentCatId ?? 0;
$arrListing = $data['arrListing'] ?? $arrListing ?? [];
$keyword = $data['keyword'] ?? $keyword ?? '';

if (0 < $recordId) {
    include('row.php');
} else if (true === $allOpen) {
    if (count($arrListing) > 0) {
        $ulClass = 'append-ul ulJs ul-' . $parentCatId;
        $ulId = '';
        if ($searchRequest) {
            echo '<div class="accordion-categories listingRecordJs">';
            $ulClass = 'sorting-categories categoriesListJs';
            $ulId = 'sorting-categories';
        } ?>
        <ul class="<?php echo $ulClass; ?>" id="<?php echo $ulId; ?>">
            <?php foreach ($arrListing as $sn => $row) {
                $childrenHtml = '';
                if (isset($row['children']) && !empty($row['children'])) {
                    $data = [
                        'allOpen' => true,
                        'parentCatId' => $row['prodcat_id'],
                        'arrListing' => $row['children'],
                        'canEdit' => $canEdit,
                        'keyword' => $keyword,
                        'siteLangId' => $siteLangId,
                    ];
                    $childrenHtml = HtmlHelper::getHtml('product-categories/search.php', $data);
                }
                include('row.php');
            } ?>
        </ul>
        <?php
        if ($searchRequest) {
            echo '</div>';
        }
    } else { ?>
        <div class="accordion-categories listingRecordJs">
            <?php $this->includeTemplate('_partial/no-record-found.php'); ?>
        </div>
    <?php }
} else { ?>
    <div class="accordion-categories listingRecordJs">
        <ul id="sorting-categories" class="sorting-categories categoriesListJs">
            <?php if (count($arrListing) > 0) { ?>
                <?php foreach ($arrListing as $sn => $row) {
                    include('row.php');
                } ?>
            <?php } else {
                $this->includeTemplate('_partial/no-record-found.php');
            } ?>
        </ul>
    </div>
    <script type="text/javascript">
        $(function() {
            listAccordian();
        });
    </script>
<?php } ?>