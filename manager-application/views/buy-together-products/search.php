<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $selProdId => $row) {
    $serialNo++;
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    $tr->setAttribute('id', $selProdId);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="record_ids[]" value=' . $row['upsell_sellerproduct_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'product_name':
                $str = $this->includeTemplate('_partial/product/product-info-card.php', ['product' => $row, 'siteLangId' => $siteLangId, 'sellerName' => $row['credential_username']], false, true);
                $td->appendElement('plaintext', $tdAttr, $str, true);
                break;
            case 'upsell_products':
                $userName = $row['credential_username'];
                unset($row['credential_username']);
                $data = [];
                foreach ($row['products'] as $relatedProd) {
                    $options = SellerProduct::getSellerProductOptions($relatedProd['selprod_id'], true, $siteLangId);
                    $variantsStr = '';
                    array_walk($options, function ($item, $key) use (&$variantsStr) {
                        $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
                    });
                    $productName = strip_tags(html_entity_decode(($relatedProd['selprod_title'] != '') ? $relatedProd['selprod_title'] : $relatedProd['product_name'], ENT_QUOTES, 'UTF-8'));
                    $productName .= $variantsStr . " | " . $userName;
                    $data[] = [
                        'id' => $relatedProd['upsell_recommend_sellerproduct_id'],
                        'value' => htmlentities($productName, ENT_QUOTES),
                        'mainRecord' => $selProdId,
                    ];
                }
                $td->appendElement('plaintext', $tdAttr, "<input class='form-control tagifyJs' placeholder='".Labels::getLabel('FRM_TYPE_TO_SEARCH_PRODUCT', $siteLangId)."' data-mainrecord='" . $selProdId . "' value='" . json_encode($data) . "'>", true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['upsell_sellerproduct_id']
                ];

                if ($canEdit) {
                    $data['deleteButton'] = [];
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                break;
        }
    }
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
?>

<script>
    bindProduct = function (e) {
        var mainRecordId = e.detail.data.mainRecord;
        if ('undefined' == typeof mainRecordId) {
            return;
        }

        var recomendedSelprodId = e.detail.data.id;
        if ('' == recomendedSelprodId) {
            e.detail.tag.remove();
            return false;
        }
        var data = 'selprod_id=' + mainRecordId + "&id=" + recomendedSelprodId;
        fcom.ajax(fcom.makeUrl("BuyTogetherProducts", "bindProduct"), data, function (t) {});
    }

    removeProduct = function (tag) {
        var mainRecordId = tag.data.mainRecord;
        if ('undefined' == typeof mainRecordId) {
            return;
        }
        var recomendedSelprodId = tag.data.id;
        if ('' == recomendedSelprodId) {
            e.detail.tag.remove();
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('BuyTogetherProducts', 'deleteSelprodProduct', [mainRecordId, recomendedSelprodId]), '', function (t) {
        });
    }

    getProducts = function (e) {
        var keyword = e.detail.value;
        var element = e.detail.tagify.DOM.originalInput;
        var list = [];
        fcom.ajax(fcom.makeUrl('SellerProducts', 'autoComplete'), {
            keyword: keyword,
            selProdId: $(element).data('mainrecord'),
        }, function (t) {
            var ans = JSON.parse(t);
            for (i = 0; i < ans.results.length; i++) {
                var products = ans.results;
                list.push({
                    "id": products[i].id,
                    "value": products[i].text,
                    "mainRecord": $(element).data('mainrecord'),
                });
            }
            e.detail.tagify.settings.whitelist = list;
            e.detail.tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    }
    isDeletedConfirmed = false;
    bindTagify = function () {
        var input = document.querySelectorAll('.tagifyJs');
        input.forEach(function (element) {
            tagify = new Tagify(element, {
                whitelist: [],
                dropdown: {
                    position: 'text',
                    enabled: 0 // show suggestions dropdown after 1 typed character
                },
                hooks: {
                    beforeRemoveTag: function (tags) {
                        return new Promise((resolve, reject) => {
                            if (isDeletedConfirmed == false && !confirm(langLbl.confirmRemove)) {
                                return false;
                            }
                            isDeletedConfirmed = true;
                            removeProduct(tags[0]);
                            resolve();
                        })
                    }
                }
            }).on('input', getProducts).on('focus', getProducts).on('dropdown:select', bindProduct);
        });
    };

    $(document).ready(function () {
        bindTagify();
    });
</script>