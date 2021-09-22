<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
echo '<div class="datatable datatable-sticky scroll scroll-x">';
$tbl = new HtmlElement(
	'table',
	array('width' => '100%', 'class' => 'datatable__table')
);

$th = $tbl->appendElement('thead', ['class' => 'datatable__head'])->appendElement('tr', ['class' => 'datatable__row']);
$count = 0;
$staticFlds = [];
foreach ($fields as $key => $val) {
	$cls = 'datatable_cell datatable_cell-sort datatable_cell_top headerColumnJs';
	if (0 == $count) {
		$staticFlds = [$key];
		$cls .= ' datatable_cell_left';
	}

	$cls .= ($key == $sortBy) ? ' datatable_cell-sorted' : '';

	$td = $th->appendElement('th', ['class' => $cls, 'data-field' => $key]);
	$span = $td->appendElement('span');
	$span->appendElement('plaintext', array(), $val);
	if ($key == $sortBy) {
		$arrow = ($sortOrder == applicationConstants::SORT_ASC) ? '<i class="fas fa-arrow-down"></i>' : '<i class="fas fa-arrow-up"></i>';
		$span->appendElement('plaintext', array(), $arrow, true);
	}
	$count++;
}

$tbody = $tbl->appendElement('tbody', ['class' => 'datatable__body']);
$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $sn => $row) {
	$cls = (($serialNo % 2) == 0) ? 'datatable__row datatable__row--even' : 'datatable__row';
	$tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);

	foreach ($fields as $key => $val) {
		if (in_array($key, $staticFlds)) {
			$td = $tr->appendElement('th', ['class' => 'datatable_cell datatable_cell_left']);
			$span = $td->appendElement('span');
		} else {
			$td = $tr->appendElement('td', ['class' => 'datatable_cell']);
			$span = $td->appendElement('span');
		}
		switch ($key) {
			case 'listSerial':
				$span->appendElement('plaintext', array(), $serialNo);
				break;
			case 'name':
				$span->appendElement('plaintext', array(), $row['name'] . '<br/>(' . $row['email'] . ')', true);
				break;
			case 'affiliateLink':
				$url = UrlHelper::generateFullUrl('Home', 'referral', [$row['user_referral_code']], CONF_WEBROOT_FRONTEND);
				$span->appendElement('plaintext', array(), '<a href="' . $url . '" target="_blank">' . $url, '</a>', true);
				break;
			case 'availableBalance':
			case 'totAffilateRevenue':
			case 'totAffilateSignupRevenue':
			case 'totAffilateOrdersRevenue':
				$span->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key], true, true));
				break;

			default:
				$span->appendElement('plaintext', array(), $row[$key], true);
				break;
		}
	}
	$serialNo++;
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
echo '</div>';
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
	'name' => 'frmReportSearchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false); ?>
<script>
	resetReportFirstColumnWidth();
</script>