<?php
defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$frm->setFormTagAttribute('class', 'web_form form_horizontal');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
$fld = $frm->getField('shop_name');
$fld->setWrapperAttribute('class', 'ui-front');
?>

<section class="section">
	<div class="sectionhead">

		<h4><?php echo Labels::getLabel('LBL_Coupon_Setup',$siteLangId); ?></h4>
	</div>
	<div class="sectionbody space">
		<div class="row">	

<div class="col-sm-12">
	<h1><?php //echo Labels::getLabel('LBL_Coupon_Setup',$siteLangId);?></h1>
	<div class="tabs_nav_container responsive flat" style='min-height:380px;'>
		<ul class="tabs_nav">
			<li><a href="javascript:void(0)" onclick="couponLinkProductForm(<?php echo $coupon_id ?>);"><?php echo Labels::getLabel('LBL_Link_Products',$siteLangId);?></a></li>
			<li><a href="javascript:void(0)" onclick="couponLinkCategoryForm(<?php echo $coupon_id ?>);"><?php echo Labels::getLabel('LBL_Link_Categories',$siteLangId);?></a></li>
			<li><a href="javascript:void(0)" onclick="couponLinkUserForm(<?php echo $coupon_id ?>);"><?php echo Labels::getLabel('LBL_Link_Users',$siteLangId);?></a></li>
			<li><a class="active" href="javascript:void(0)" onclick="couponLinkShopForm(<?php echo $coupon_id ?>);"><?php echo Labels::getLabel('LBL_Link_Shops',$siteLangId);?></a></li>
			<li><a href="javascript:void(0)" onclick="couponLinkBrandForm(<?php echo $coupon_id ?>);"><?php echo Labels::getLabel('LBL_Link_Brands',$siteLangId);?></a></li>
		</ul>
		
		<div class="tabs_panel_wrap" >
			<div class="tabs_panel">
				<?php echo $frm->getFormHtml(); ?>
				<div id="coupon_list" class="col-xs-9 box--scroller"></div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</section>
<script type="text/javascript">
$("document").ready(function(){
	
	reloadCouponShop(<?php echo $coupon_id; ?>);
	
	$('input[name=\'shop_name\']').autocomplete({
        'classes': {
            "ui-autocomplete": "custom-ui-autocomplete"
        },
		'source': function(request, response) {			
			$.ajax({
				url: fcom.makeUrl('Shops', 'autoComplete'),
				data: {keyword: request['term'],fIsAjax:1},
				dataType: 'json',
				type: 'post',
				success: function(json) {
					response($.map(json, function(item) {
						return { label: item['name'], value: item['name'], id: item['id']	};
					}));
				},
			});
		},
		'select': function(event, ui) {
			updateCouponShop(<?php echo $coupon_id; ?>, ui.item.id );
                        $('input[name=\'shop_name\']').val('');
                        return false;
		}
	});
	
});
</script>