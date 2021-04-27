$(document).ready(function () {
	var lastSearchString = '';
	var fontFamilyElement = $("select[name='CONF_THEME_FONT_FAMILY']");
	$.ajax({
		url: fcom.makeUrl('ThemeColor', 'getGoogleFonts'),
		type: 'post',
		dataType: 'json',
		success: function (data) {
			fontFamilyElement.select2({
				closeOnSelect: true,
				dir: layoutDirection,
				allowClear: true,
				placeholder: fontFamilyElement.attr('placeholder'),
				data: data.fonts,
				minimumInputLength: 0,
				templateResult: function (result) {
					return result.name;
				},
				templateSelection: function (result) {
					return result.name || result.text;
				}
			}).on('select2:selecting', function (e) {
				var item = e.params.args.data;
				lastSearchString = $('.select2-search__field').val();
				loadGoogleFont(item);
				return;
			}).on('select2:unselecting', function (e) {
				lastSearchString = '';
				$('link[data-font="googleFontCss--js"]').remove();
			});

			setTimeout(() => {
				var defaultFontFamily = fontFamilyElement.data('value');
				if ('undefined' != typeof defaultFontFamily && '' != defaultFontFamily) {
					fontFamilyElement.val(defaultFontFamily).trigger('change.select2').trigger('select.select2');
				}
			}, 200);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});

	$(document).on('select2:open', "select[name='CONF_THEME_FONT_FAMILY']", function () {
		setTimeout(() => {
			if (lastSearchString) {
				$('.select2-search').find('input').val(lastSearchString).trigger('paste');
			}
			document.getElementById($(".select2-results__options").attr("id")).scrollTop = $(".select2-results__option[aria-selected=true]").outerHeight() * $(".select2-results__option[aria-selected=true]").index() - 100;
		}, 10);
});

	$('.jscolor').trigger("input");
});

$(document).on('input', '.jscolor', function () {
	$(this).siblings('.colorBlock--js').find('.colorTab--js').css('background-color', $(this).val());
	if ($(this).hasClass('themeColor--js')) {
		$("[data-jscolorSelector]:not(text)").attr('fill', $(this).val());
	}
	if ($(this).hasClass('themeColorInverse--js')) {
		$("text[data-jscolorSelector]").attr('fill', $(this).val());
	}
});

loadGoogleFont = function (item) {
	var name = item.name;
	name = name.substring(0, name.indexOf(" - "));
	$.ajax({
		url: fcom.makeUrl('ThemeColor', 'loadGoogleFont'),
		data: { fIsAjax: 1, name: name, weight: item.weight, subset: item.subset },
		dataType: 'json',
		type: 'post',
		success: function (resp) {
			if (null != resp.html) {
				$('link[data-font="googleFontCss--js"]').remove();
				$('head').append(resp.html);
				$('.googleFonts--js').find('text').attr('font-family', name);
				$("input[name='CONF_THEME_FONT_FAMILY_URL']").val($(resp.html).attr('href'));
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

setupFontStyle = function(frm) {
	if (!$(frm).validate()) return;		
	var data = fcom.frmData(frm);
	fcom.updateWithAjax(fcom.makeUrl('ThemeColor', 'setupFontStyle'), data, function(t) {
		// $(document).trigger('close.facebox');
	});
};