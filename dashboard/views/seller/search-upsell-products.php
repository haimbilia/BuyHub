<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="js-scrollable table-wrap table-responsive">
    <?php
    $arr_flds = array(
        // 'select_all'=>'',
        'product_name' => Labels::getLabel('LBL_Product_Name', $siteLangId),
        'upsell_products' => Labels::getLabel('LBL_Buy_Together_Products', $siteLangId)
    );

    $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table volDiscountList-js'));
    $thead = $tbl->appendElement('thead');
    $th = $thead->appendElement('tr', array('class' => ''));

    foreach ($arr_flds as $key => $val) {
        if ('product_name' == $key) {
            $th->appendElement('th', array('width' => '25%'), $val);
        } else {
            $th->appendElement('th', array('width' => '75%'), $val);
        }
    }
    foreach ($arrListing as $selProdId => $row) {
        $tr = $tbl->appendElement('tr', array());
        foreach ($arr_flds as $key => $val) {
            $tr->setAttribute('id', 'row-' . $selProdId);
            if ($key == 'product_name') {
                $td = $tr->appendElement('td', array('class' => (($canEdit) ? 'js-product-edit cursor-pointer' : ''), 'row-id' => $selProdId));
            } else {
                $td = $tr->appendElement('td');
            }
            switch ($key) {
                case 'select_all':
                    $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItem--js" type="checkbox" name="selprod_ids[' . $selProdId . ']" value=' . $selProdId . '></label>', true);
                    break;
                case 'product_name':
                    $row['options'] = SellerProduct::getSellerProductOptions($selProdId, true, $siteLangId);
                    $txt = $this->includeTemplate('_partial/product/product-info-html.php', ['product' => $row, 'siteLangId' => $siteLangId], false, true);
                    $td->appendElement('plaintext', array(), $txt, true);
                    break;
                case 'upsell_products':
                    $div = $td->appendElement('div', array("class" => "list-tag-wrapper"));
                    $ul = $div->appendElement("ul", array("class" => "list-tags"));
                    foreach ($row['products'] as $upsellProd) {
                        $options = SellerProduct::getSellerProductOptions($upsellProd['selprod_id'], true, $siteLangId);
                        $variantsStr = '';
                        array_walk($options, function ($item, $key) use (&$variantsStr) {
                            $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
                        });
                        $productName = strip_tags(html_entity_decode(($upsellProd['selprod_title'] != '') ? $upsellProd['selprod_title'] :  $upsellProd['product_name'], ENT_QUOTES, 'UTF-8'));
                        $productName .=  $variantsStr;

                        $li = $ul->appendElement("li");
                        $removeIcon = '';
                        if ($canEdit) {
                            $removeIcon = '<i class="remove_buyTogether remove_param fa fa-times" onclick="deleteSelprodUpsellProduct(' . $selProdId . ', ' . $upsellProd['selprod_id'] . ')"></i>';
                        }
                        $li->appendElement('plaintext', array(), '<span>' . $productName . ' ' . $removeIcon . '</span>', true);
                        $li->appendElement('plaintext', array(), '<input type="hidden" name="product_upsell[]" value="' . $upsellProd['selprod_id'] . '">', true);
                    }
                    break;
                default:
                    break;
            }
        }
    }

    echo $tbl->getHtml();
    if (count($arrListing) == 0) {
        $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
    }
    $frm = new Form('frmVolDiscountListing', array('id' => 'frmVolDiscountListing'));
    $frm->setFormTagAttribute('class', 'form');

    echo $frm->getFormTag(); ?>
    </form>
</div>
<?php
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmSearchVolumeDiscountPaging'));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'callBackJsFunc' => 'goToSearchPage', 'adminLangId' => $siteLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
