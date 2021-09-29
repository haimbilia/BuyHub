$(document).ready(function () {
    var fontFamilyElement = $("input[name='CONF_THEME_FONT_FAMILY']");
    if (0 < fontFamilyElement.length) {
        if ('' != fontFamilyElement.val()) {
            $('.tagifyWeightJs').removeAttr('disabled');
        }

        $.ajax({
            url: fcom.makeUrl('ThemeColor', 'getGoogleFonts'),
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (0 == data.status) {
                    return;
                }
                var fonts = $.map(data.fonts, function (item) {
                    return { label: item['text'], value: item['text'], id: item['weight'] };
                });

                fontFamilyElement.autocomplete({
                    'source': fonts,
                    'minLength': 0,
                    'scroll': true,
                    'change': function (request, ui) {
                        if (null == ui.item) {
                            $('.tagifyWeightJs').val("").attr('disabled', 'disabled');
                        }
                    },
                    'select': function (event, ui) {
                        if (null != ui.item) {
                            $('.tagifyWeightJs').removeAttr('disabled');
                        }
                    }
                }).focus(function () {
                    $(this).autocomplete("search", $(this).val());
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $.ykmsg.error(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });

        fontFamilyElement.on('search', function () {
            if ('' == $(this).val()) {
                $('.tagifyWeightJs').val("").attr('disabled', 'disabled');
            }
        });
    }
    
    if (0 < $(".colorPickerJs").length) {
        $(document).on("input", ".colorPickerJs", function () {
            var hex = $(this).val();
            var rgb = hexToRgb(hex);
            var hsl = hexToHsl(hex);
            var colorBlock = $(this).closest('.colorBlockJs');
            if (0 < colorBlock.length) {
                colorBlock.find('.hexJs').text(hex);
                colorBlock.find('.rgbJs').text(rgb);
                colorBlock.find('.hslJs').text(hsl);

                colorBlock.find('.inputRgbJs').val(rgb);
                colorBlock.find('.inputHslJs').val(hsl);
            }

            if ($(this).hasClass('themeColorJs')) {
                $("[data-jscolorSelector]:not(text)").attr('fill', hex);
            }

            if ($(this).hasClass('themeColorInverseJs')) {
                $("text[data-jscolorSelector]").attr('fill', hex);
            }
        });
    }
});

(function () {
    loadGoogleFont = function (item) {
        var name = item.font;
        name = 0 < name.indexOf(" - ") ? name.substring(0, name.indexOf(" - ")) : name;
        $.ajax({
            url: fcom.makeUrl('ThemeColor', 'loadGoogleFont'),
            data: { fIsAjax: 1, name: name, weight: item.weight, subset: item.subset },
            dataType: 'json',
            type: 'post',
            success: function (resp) {
                if (null != resp.html) {
                    $('link[data-font="googleFontCssJs"]').remove();
                    $('head').append(resp.html);
                    $('.googleFontsJs').find('text').attr('font-family', name);
                    $("input[name='CONF_THEME_FONT_FAMILY_URL']").val($(resp.html).attr('href'));
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    setupFontStyle = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('ThemeColor', 'setupFontStyle'), data, function (t) { });
    };

    resetToDefault = function () {
        if (!confirm(langLbl.confirmReset)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('ThemeColor', 'resetToDefault'), '', function (t) {
            location.reload();
        });
    };

    addElement = function (e) {
        var weight = e.detail.tag.id;
        var subsetArr = e.detail.data.subset;
        var selectedWeights = $("input[name='CONF_THEME_FONT_WEIGHT']").val();
        if ('' != selectedWeights) {
            var weightsArr = $.parseJSON(selectedWeights);
            for (let i = 0; i < weightsArr.length; i++) {
                weight += "," + weightsArr[i]['id'];
            }
        }
        var selectedFont = $('input[name="CONF_THEME_FONT_FAMILY"]').val();
        let subsets = subsetArr.join();

        const item = {
            font: selectedFont,
            weight: weight,
            subset: subsets,
        };
        loadGoogleFont(item);
    }

    getVariants = function (e) {
        var fontName = $("input[name='CONF_THEME_FONT_FAMILY']").val();
        if ('' == fontName) {
            $.ykmsg.error(langLbl.selectFont);
            return false;
        }

        var keyword = e.detail.value;
        keyword = 'undefined' == typeof keyword ? '' : keyword;

        var list = [];
        var data = 'fontName=' + fontName + '&keyword=' + keyword;
        tagify.loading(true);
        fcom.ajax(fcom.makeUrl('ThemeColor', 'getVariants'), data, function (t) {
            var ans = $.parseJSON(t);
            if (0 == ans.status) {
                return;
            }
            var fonts = ans['fonts'];
            for (i = 0; i < fonts.length; i++) {
                list.push({
                    "id": fonts[i].weight,
                    "value": fonts[i].name,
                    "subset": fonts[i].subset,
                });
            }
            tagify.settings.whitelist = list;
            tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    }

    tagifyElement = function () {
        var input = document.querySelector('input[name=CONF_THEME_FONT_WEIGHT]');
        if (null == input) {
            return false;
        }

        tagify = new Tagify(input, {
            whitelist: [],
        }).on('input', getVariants).on('focus', getVariants).on('add', addElement);
    };
    tagifyElement();




    hexToRgb = function (hex) {
        hex = hex.replace(/#/g, '');
        if (hex.length === 3) {
            hex = hex.split('').map(function (hex) {
                return hex + hex;
            }).join('');
        }
        // validate hex format
        var result = /^([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})[\da-z]{0,0}$/i.exec(hex);
        if (result) {
            var red = parseInt(result[1], 16);
            var green = parseInt(result[2], 16);
            var blue = parseInt(result[3], 16);

            return [red, green, blue];
        } else {
            // invalid color
            return null;
        }
    }

    hexToHsl = function (hex) {
        hex = hex.replace(/#/g, '');
        if (hex.length === 3) {
            hex = hex.split('').map(function (hex) {
                return hex + hex;
            }).join('');
        }
        var result = /^([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})[\da-z]{0,0}$/i.exec(hex);
        if (!result) {
            return null;
        }
        var r = parseInt(result[1], 16);
        var g = parseInt(result[2], 16);
        var b = parseInt(result[3], 16);
        r /= 255, g /= 255, b /= 255;
        var max = Math.max(r, g, b),
            min = Math.min(r, g, b);
        var h, s, l = (max + min) / 2;
        if (max == min) {
            h = s = 0;
        } else {
            var d = max - min;
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
            switch (max) {
                case r:
                    h = (g - b) / d + (g < b ? 6 : 0);
                    break;
                case g:
                    h = (b - r) / d + 2;
                    break;
                case b:
                    h = (r - g) / d + 4;
                    break;
            }
            h /= 6;
        }
        s = s * 100;
        s = Math.round(s);
        l = l * 100;
        l = Math.round(l);
        h = Math.round(360 * h);

        return [h, s + '%', l + '%'];
    }
})();