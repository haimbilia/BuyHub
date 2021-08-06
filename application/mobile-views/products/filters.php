<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$conditions = array();
$conditionTitles = Product::getConditionArr($siteLangId);
foreach ($conditionsArr as $condition) {
    if (!isset($condition['selprod_condition']) || $condition['selprod_condition'] == 0) {
        continue;
    }
    $conditions[] = array(
        'title' => $conditionTitles[$condition['selprod_condition']],
        'value' => $condition['selprod_condition'],
    );
}

$optionRows = $optionsValues = $optionsResult = array();
if (isset($options) && 0 < count($options)) {
    function sortByOrder($a, $b)
    {
        return $a['option_id'] - $b['option_id'];
    }
    usort($options, 'sortByOrder');

    foreach ($options as $opt) {
        $optionRows[$opt['option_id']] = [
            'option_id' => $opt['option_id'],
            'option_is_color' => $opt['option_is_color'],
            'option_name' => $opt['option_name']
        ];
        $optionsValues[$opt['option_id']]['values'][] = [
            'optionvalue_name' => $opt['optionvalue_name'],
            'optionvalue_id' => $opt['optionvalue_id'],
            'optionvalue_color_code' => $opt['optionvalue_color_code'],
        ];
    }
    $optionsResult = array_replace_recursive($optionRows, $optionsValues);
}

$data = array(
    'productFiltersArr' => empty($productFiltersArr) ? (object)array() : $productFiltersArr,
    'headerFormParamsAssocArr' => $headerFormParamsAssocArr,
    'shopCatFilters' => $shopCatFilters,
    'prodcatArr' => $prodcatArr,
    'brandsCheckedArr' => $brandsCheckedArr,
    'optionValueCheckedArr' => $optionValueCheckedArr,
    'conditionsArr' => $conditions,
    'conditionsCheckedArr' => $conditionsCheckedArr,
    'priceInFilter' => $priceInFilter,
    'filterDefaultMinValue' => $filterDefaultMinValue,
    'filterDefaultMaxValue' => $filterDefaultMaxValue,
    'availability' => $availability,
    'availabilityArr' => array_values($availabilityArr),
);

if (Product::FILTER_POSITION_DEFAULT == $position) {
    $data['categoriesArr'] = $categoriesArr;
    $data['brandsArr'] = $brandsArr;
    $data['options'] = array_values($optionsResult);
    $data['priceArr'] = $priceArr;

} else if (Product::FILTER_POSITION_ALTERNATE == $position) {
    $data['filters'] = [
        [
            'title' => Labels::getLabel('LBL_CATEGORIES', $siteLangId),
            'type' => Product::FILTER_TYPE_CATEGORY,
            'data' => $categoriesArr,
        ],
        [
            'title' => Labels::getLabel('LBL_BRANDS', $siteLangId),
            'type' => Product::FILTER_TYPE_BRAND,
            'data' => $brandsArr,
        ],
        [
            'title' => Labels::getLabel('LBL_OPTIONS', $siteLangId),
            'type' => Product::FILTER_TYPE_OPTION,
            'data' => array_values($optionsResult),
        ],
        [
            'title' => Labels::getLabel('LBL_SORT_BY', $siteLangId),
            'type' => Product::FILTER_TYPE_SORT_BY,
            'data' => [
                [
                    'title' => Labels::getLabel('LBL_Price_(Low_to_High)', $siteLangId),
                    'value' => 'price_asc',
                ],
                [
                    'title' => Labels::getLabel('LBL_Price_(High_to_Low)', $siteLangId),
                    'value' => 'price_desc',
                ],
                [
                    'title' => Labels::getLabel('LBL_Sort_by_Popularity', $siteLangId),
                    'value' => 'popularity_desc',
                ],
                [
                    'title' => Labels::getLabel('LBL_Most_discounted', $siteLangId),
                    'value' => 'discounted',
                ],
            ],
        ],
        [
            'title' => Labels::getLabel('LBL_PRICE_FILTER', $siteLangId),
            'type' => Product::FILTER_TYPE_PRICE,
            'data' => [$priceArr],
        ],
    ];
}
