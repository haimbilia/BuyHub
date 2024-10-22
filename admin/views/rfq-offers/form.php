<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (0 < $counterOfferId) {
    $frm->setFormTagAttribute('data-onclear', 'counter(' . $counterOfferId . ', ' . $rfqId . ')');
} else {
    $frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ', ' . $rfqId . ')');
}

$fld = $frm->getField('offer_user_id');
if (null != $fld) {
    $fld->setfieldTagAttribute('id', 'sellerJs');
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
    $fld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_USER_NAME,_EMAIL_OR_SHOP_NAME', $siteLangId));
}

$fld = $frm->getField('offer_comments');
$fld->developerTags['colWidthValues'] = [null, '12', null, null];

$fld = $frm->getField('offer_negotiable');
$fld->developerTags['colWidthValues'] = [null, '12', null, null];

$fld = $frm->getField('offer_expired_on');
$fld->addfieldTagAttribute('class', 'fldDateJs');

$unitLabel =  applicationConstants::getWeightUnitName($siteLangId, $rfq_quantity_unit) . '[' . CommonHelper::getCurrencySymbol() . ']';

$fld = $frm->getField('offer_price');
$fld->changeCaption(Labels::getLabel('FRM_OFFER_PRICE_PER_' . $unitLabel));

$fld = $frm->getField('offer_cost');
$fld->changeCaption(Labels::getLabel('FRM_OFFER_COST_PER_' . $unitLabel));

$fld = $frm->getField('offer_quantity');
if (false == RfqOffers::isPosted($rfqId, 0, $recordId)) {
    $fld->addfieldTagAttribute('readOnly', 'true');
}
$fld->changeCaption(Labels::getLabel('LBL_OFFER_QUANTITY[' . applicationConstants::getWeightUnitName($siteLangId, $rfq_quantity_unit, true) . ']'));

$colWidthValuesDefault = 6;
$hidden  = 0 < $selProdPrice ? '' : 'hidden';
$selProdPrice = CommonHelper::displayMoneyFormat($selProdPrice);

$prependHtml = "<span id='wrapSelProdPriceJs' class='badge badge-inline badge-info " . $hidden ."' >
" . Labels::getLabel('LBL_SELLING_PRICE', $siteLangId). ": <span id='selProdPrice'>" . $selProdPrice . "</span></span>";

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>
<script>
    $(document).ready(function() {
        getSellersSelect2("sellerJs", {
            'isGlobal': <?php echo $isGlobal; ?>
        });
        var date = new Date();
        date.setDate(date.getDate() + 1);
        $('.fldDateJs').datepicker('option', {
            minDate: date,
            onClose: function() {
                $('textarea[name="offer_comments"]').focus();
            }
        })
    });
    $('#sellerJs').on('select2:select', function (e) {
        let rfqId = $('input[name="offer_rfq_id"]').val();
        var userId = e.params.data.id;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "getSelProdPrice", [rfqId, userId]), '', function (t) {
            fcom.closeProcessing();
            if(0 != t.selProdPrice) {
                $('#selProdPrice').html(t.selProdPrice);
                $('#wrapSelProdPriceJs').removeClass('hidden');
            } else{
                $('#wrapSelProdPriceJs').addClass('hidden');
            }

        });
    });

    $('#sellerJs').on('select2:unselecting', function (e) {
        $('#wrapSelProdPriceJs').addClass('hidden');
    });
</script>