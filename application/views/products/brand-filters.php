<?php
$brandsCheckedArr = (isset($brandsCheckedArr) && !empty($brandsCheckedArr)) ? $brandsCheckedArr : array();

$charArr = array();
$firstCharacter = '';
$brandHtml = '';
$mySelection = array();
$count = 0;
$rangeArr = [];
foreach ($brandsArr as $brand) {
    if (in_array($brand['brand_id'], $brandsCheckedArr)) {
        $mySelection[$brand['brand_id']] = $brand;
        continue;
    }
    //$totalProducts = array_key_exists('totalProducts', $brand) ? $brand['totalProducts'] : 0;

    $str = mb_substr(strtolower($brand['brand_name']), 0, 1);
    if (is_numeric($str)) {
        $str = '0-9';
    }
    $closingTag = '';
    if ($str != $firstCharacter) {
        $brandHtml .= '<li><ul><li class="filter-directory_list_title ' . $str . '" data-item="' . $str . '" id="' . $str . '">' . $str . '</li>';
        $firstCharacter = $str;
        $closingTag = '</ul></li>';
    }


    $charArr[$str] =   $rangeArr[] = strtoupper($str);
    $brandHtml .= ' <li class="brandList-js b-' . $str . '" data-caption=' . mb_substr(strtolower($brand['brand_name']), 0, 1) . '>
                <label class="checkbox brand" ><input name="brands" value="' . $brand['brand_id'] . '" data-id="brand_' . $brand['brand_id'] . '" data-title="' . $brand['brand_name'] . '" type="checkbox" ><span class="lb-txt">' . $brand['brand_name'] . '</span></label>
            </li>';
    $brandHtml .=    $closingTag;
}

?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_All_brands', $siteLangId); ?></h5>
</div>
<div class="modal-body">
    <div class="filter-directory">
        <div class="filter-directory_bar">
            <input type="text" placeholder="<?php echo Labels::getLabel('LBL_SEARCH_BRAND'); ?>" class="form-control filter-directory_search_input omni-search" onKeyup="autoKeywordSearch(this.value)">
            <ul class="filter-directory_indices bfilter-js">
                <?php
                $rangeArr = array_unique($rangeArr);
                foreach ($rangeArr as $char) {
                    $disabled = '';
                    if (!in_array($char, $charArr)) {
                        $disabled = 'class="filter-directory_disabled"';
                    }
                ?>
                    <li data-item="<?php echo $char; ?>" <?php echo $disabled; ?>><a href="#<?php echo $char; ?>"><?php echo $char; ?></a>
                    <?php }   ?>
            </ul>
        </div>
        <div>
            <ul class="filter-directory_list">
                <?php foreach ($mySelection as $brand) {
                    //$totalProducts = array_key_exists('totalProducts', $brand) ? $brand['totalProducts'] : 0;
                    echo ' <li>
                  <label class="checkbox brand" ><input name="brands" value="' . $brand['brand_id'] . '" data-id="brand_' . $brand['brand_id'] . '" type="checkbox" checked="true" data-title="' . $brand['brand_name'] . '"><span class="lb-txt">' . $brand['brand_name'] . '</span></label>
              </li>';
                    /* echo ' <li>
              <label class="checkbox brand" ><input name="brands" value="' . $brand['brand_id'] . '" data-id="brand_' . $brand['brand_id'] . '" type="checkbox" checked="true" data-title="' . $brand['brand_name'] . '">' . $brand['brand_name'] . ' <span class="filter-directory_count">(' . $totalProducts . ')</span> </label>
          </li>'; */
                } ?>
                <?php echo $brandHtml; ?>
            </ul>
        </div>
    </div>
</div>