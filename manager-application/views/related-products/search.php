<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
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
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', [], $serialNo);
                break;
            case 'product_name':
                $product = $productsList[$selProdId];
                $product['sellerName'] = $product['credential_username']; 
                $str = $this->includeTemplate('_partial/product/product-info-card.php', ['product' => $product, 'siteLangId' => $siteLangId], false, true);
                $td->appendElement('plaintext', array(), $str, true);
                break;
            case 'related_products':
                $userName = $row['credential_username'];
                unset($row['credential_username']);
                $data = [];
                foreach ($row as $relatedProd) {
                    $options = SellerProduct::getSellerProductOptions($relatedProd['selprod_id'], true, $siteLangId);
                    $variantsStr = '';
                    array_walk($options, function ($item, $key) use (&$variantsStr) {
                        $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
                    });
                    $productName = strip_tags(html_entity_decode(($relatedProd['selprod_title'] != '') ? $relatedProd['selprod_title'] :  $relatedProd['product_name'], ENT_QUOTES, 'UTF-8'));
                    $productName .=  $variantsStr . " | " . $userName;
                    $data[] = [
                        'id' => $relatedProd['selprod_id'],
                        'value' => htmlentities($productName, ENT_QUOTES),
                        'mainRecord' => $selProdId,
                    ];
                }
                $td->appendElement('plaintext', array(), "<input class='tagifyJs' data-mainrecord='" . $selProdId . "' value='" . json_encode($data) . "'>", true);
                break;
            default:
                break;
        }
    }
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
} ?>

<script>
    bindProduct = function(e) {
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
        fcom.ajax(fcom.makeUrl("RelatedProducts", "bindProduct"), data, function(t) {});
    }

    removeProduct = function(tag) {
        var mainRecordId = tag.data.mainRecord;
        if ('undefined' == typeof mainRecordId) {
            return;
        }
        var recomendedSelprodId = tag.data.id;
        if ('' == recomendedSelprodId) {
            e.detail.tag.remove();
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('RelatedProducts', 'deleteSelprodRelatedProduct', [mainRecordId, recomendedSelprodId]), '', function(t) {            
        });
    }

    getProducts = function(e) {
        var keyword = e.detail.value;
        var element = e.detail.tagify.DOM.originalInput;
        var list = [];
        fcom.ajax(fcom.makeUrl('SellerProducts', 'autoComplete'), {
            keyword: keyword,
            selProdId: $(element).data('mainrecord'),
        }, function(t) {
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
    var isDeletedConfirmed = false;
    bindTagify = function() {
        var input = document.querySelectorAll('.tagifyJs');
        input.forEach(function(element) {
            tagify = new Tagify(element, {
                whitelist: [],
                dropdown: {
                    position: 'text',
                    enabled: 1 // show suggestions dropdown after 1 typed character
                },
                hooks: {
                    beforeRemoveTag: function(tags) {
                        return new Promise((resolve, reject) => {
                            if (isDeletedConfirmed == false &&  !confirm(langLbl.confirmRemove)) {
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

    $(document).ready(function() {
        bindTagify();
    });
</script>