<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="js-scrollable table-wrap table-responsive">
    <?php $arr_flds = array(
        'listserial' => '#',
        'product_identifier' => Labels::getLabel('LBL_Product', $langId),
        'tags' => Labels::getLabel('LBL_Tags', $langId)
    );
    $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table layout--' . $formLayout, 'dir' => $formLayout));
    $th = $tbl->appendElement('thead')->appendElement('tr', array('class' => ''));

    foreach ($arr_flds as $key => $val) {
        if ($key == 'listserial') {
            $e = $th->appendElement('th', array('width' => '5%'), $val);
        } elseif ($key == 'product_identifier') {
            $e = $th->appendElement('th', array('width' => '30%'), $val);
        } else {
            $e = $th->appendElement('th', array('width' => '65%'), $val);
        }
    }
    $productsArr = array();
    $sr_no = ($page == 1) ? 0 : ($pageSize * ($page - 1));
    foreach ($arrListing as $sn => $row) {
        $productsArr[] = $row['product_id'];
        $sr_no++;
        $tr = $tbl->appendElement('tr', array('class' => ''));

        foreach ($arr_flds as $key => $val) {
            $td = $tr->appendElement('td');
            switch ($key) {
                case 'listserial':
                    $td->appendElement('plaintext', array(), $sr_no, true);
                    break;
                case 'product_identifier':
                    $td->appendElement('plaintext', array(), $row['product_name'], true);
                    break;
                case 'tags':
                    $productTags = Product::getProductTags($row['product_id'], $langId);
                    $tagData = array();
                    foreach ($productTags as $key => $data) {
                        $tagData[$key]['id'] = $data['tag_id'];
                        $tagData[$key]['value'] = $data['tag_name'];
                    }
                    $readOnly = (!$canEdit) ? 'readonly' : '';
                    $encodedData = htmlspecialchars(json_encode($tagData), ENT_QUOTES, 'UTF-8');
                    $td->appendElement('plaintext', array(), "<div class='product-tag scroll scroll-y' id='product" . $row['product_id'] . "'><input " . $readOnly . " class='tag_name' type='text' name='tag_name" . $row['product_id'] . "' value='" . $encodedData . "' data-product_id='" . $row['product_id'] . "'></div>", true);
                    break;
                default:
                    $td->appendElement('plaintext', array(), $row[$key], true);
                    break;
            }
        }
    }


    if (count($arrListing) == 0) {
        $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
    } else {
        echo $tbl->getHtml();
    } ?>
</div>
<?php $postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmCatalogProductSearchPaging'));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'callBackJsFunc' => 'goToCatalogProductSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
?>
<?php if (count($arrListing) > 0) { ?>
    <script>
        var productsArr = [<?php echo '"' . implode('","', $productsArr) . '"' ?>];
        var langId = <?php echo $langId; ?>;
        $("document").ready(function() {
            getTagsAutoComplete = function(e) {
                var keyword = e.detail.value;
                var list = [];
                fcom.ajax(fcom.makeUrl('Seller', 'tagsAutoComplete'), {
                    keyword: keyword,
                    langId: langId
                }, function(t) {
                    var ans = $.parseJSON(t);
                    for (i = 0; i < ans.length; i++) {
                        list.push({
                            "id": ans[i].id,
                            "value": ans[i].name,
                        });
                    }
                    e.detail.tagify.settings.whitelist = list;
                    e.detail.tagify.loading(false).dropdown.show.call(e.detail.tagify, keyword);
                });
            }

            $.each(productsArr, function(index, value) {
                tagify = new Tagify(document.querySelector('input[name=tag_name' + value + ']'), {
                        whitelist: [],
                        delimiters: "#",
                        editTags: false,
                        backspace: false
                    })
                    .on('dropdown:select', attachTag).on('add', addTagData).on('remove', removeTagData)
                    .on('input', getTagsAutoComplete).on('focus', getTagsAutoComplete);
            });

            $.each(productsArr, function(index, value) {
                tagify = new Tagify(document.querySelector('input[name=tag_name' + value + ']'), {
                    whitelist: [],
                    delimiters: "#",
                    editTags: false,
                    backspace: false
                }).on('focus', getTagsAutoComplete).on('dropdown:select', addTagData).on('remove', removeTagData).on('input', getTagsAutoComplete);
            });

        });
    </script>
<?php } ?>