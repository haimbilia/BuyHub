<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COMMISSION_SETUP', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
                    <?php 
                        if (0 < $recordId) {
                            echo Labels::getLabel('LBL_UPDATE', $adminLangId); 
                        } else {
                            echo Labels::getLabel('LBL_SAVE', $adminLangId); 
                        }
                    ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$("document").ready(function(){
    $('input[name=\'user_name\']').autocomplete({
        'classes': {
            "ui-autocomplete": "custom-ui-autocomplete"
        },
        'source': function(request, response) {
            $.ajax({
                url: fcom.makeUrl('Commission', 'userAutoComplete'),
                data: {keyword: request['term'],fIsAjax:1},
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    response($.map(json, function(item) {
                        return { label: item['name'], value: item['name'], id: item['id'] };
                    }));
                },
            });
        },
        select: function(event, ui) {
            $("input[name='commsetting_user_id']").val( ui.item.id );
        }
    });

    $('input[name=\'user_name\']').keyup(function(){
        $('input[name=\'commsetting_user_id\']').val('');
    });

    $('input[name=\'product\']').autocomplete({
        'classes': {
            "ui-autocomplete": "custom-ui-autocomplete"
        },
        'source': function(request, response) {
            $.ajax({
                url: fcom.makeUrl('Commission', 'productAutoComplete'),
                data: {keyword: request['term'],fIsAjax:1},
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    response($.map(json, function(item) {
                        return { label: item['name'], value: item['name'], id: item['id'] };
                    }));
                },
            });
        },
        select: function(event, ui) {
			$('input[name=\'commsetting_product_id\']').val(ui.item.id);
		}
    });

    $('input[name=\'product\']').keyup(function(){
        $('input[name=\'commsetting_product_id\']').val('');
    });

    $('input[name=\'category_name\']').autocomplete({
        'classes': {
            "ui-autocomplete": "custom-ui-autocomplete"
        },
        'source': function(request, response) {
			$.ajax({
				url: fcom.makeUrl('productCategories', 'links_autocomplete'),
				data: {keyword: request['term'],fIsAjax:1},
				dataType: 'json',
				type: 'post',
				success: function(json) {
					response($.map(json, function(item) {
						return { label: item['name'], value: item['name'], id: item['id'] };
					}));
				},
			});
		},
		select: function(event, ui) {
			$('input[name=\'commsetting_prodcat_id\']').val(ui.item.id);
		}
	});

    $('input[name=\'category_name\']').change(function() {
        if ($(this).val() == '') {
            $("input[name='commsetting_prodcat_id']").val(0);
        }
    });
});
</script>
