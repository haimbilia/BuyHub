(function () {
    redirectfunc = function (url, id, nid, newTab) {
        newTab = (typeof newTab != "undefined") ? newTab : true;
        if (nid > 0) {
            $.systemMessage(langLbl.processing, 'alert--process');
            markRead(nid, url, id);
        } else {
            var target = (newTab) ? ' target="_blank" ' : ' ';
            var form = '<input type="hidden" name="id" value="' + id + '">';
            $('<form' + target + 'action="' + url + '" method="POST">' + form + '</form>').appendTo($(document.body)).submit();
        }
    };

    mediaForm = function (banner_id, langId = 0, slide_screen = 1) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Shops', 'media', [banner_id, langId, slide_screen]), '', function (t) {
            $.ykmodal(t);
            brandImages(banner_id, 'logo', slide_screen, langId);
            brandImages(banner_id, 'image', slide_screen, langId);
            fcom.removeLoader();
        });
    };

    brandImages = function (brandId, fileType, slide_screen, langId) {
        fcom.ajax(fcom.makeUrl('Shops', 'images', [brandId, fileType, langId, slide_screen]), '', function (t) {
            if (fileType == 'logo') {
                $('#logoListingJs').html(t);
            } else {
                $('#imageListingJs').html(t);
            }
        });
    };

    deleteMedia = function (brandId, fileType, afileId, langId, slide_screen) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Shops', 'removeMedia', [brandId, fileType, afileId]), '', function (t) {
            brandImages(brandId, fileType, slide_screen, langId);
            reloadList();
        });
    };

    $(document).on('change', '#logoLanguageJs', function () {
        var lang_id = $(this).val();
        var shop_id = $(this).closest("form").find('input[name="shop_id"]').val();
        brandImages(shop_id, 'logo', 1, lang_id);
    });
    $(document).on('change', '#imageLanguageJs', function () {
        var lang_id = $(this).val();
        var shop_id = $(this).closest("form").find('input[name="shop_id"]').val();
        var slide_screen = $("#slideScreenJs").val();
        brandImages(shop_id, 'image', slide_screen, lang_id);
    });
})();

