$(document).on('change', '.languageJs', function () {
    var lang_id = $(this).val();
    var coupon_id = $("input[name='coupon_id']").val();
    couponImages(coupon_id, lang_id);
});

$(document).on('keyup', '.discountValueJs', function () {
    if ($('.discountTypeJs option:selected').val() == PERCENTAGE && $(this).val() > 100) {
        $(this).val(100);
        return false;
    }
});

$(document).ready(function () {
    bindTagify();
});


(function () {
    var couponHistoryId = 0;

    couponLinkPlanForm = function (couponId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'linkPlanForm'), 'recordId=' + couponId, function (t) {
            $.ykmsg.close();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };


    couponHistory = function (couponId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'usesHistory'), 'recordId=' + couponId, function (t) {
            $.ykmodal(t.html);
            $.ykmsg.close();
            fcom.removeLoader();
        });
    };

    goToCouponHistoryPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmHistorySearchPaging;
        $(frm.page).val(page.html);
        data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'usesHistory', [couponHistoryId]), data, function (t) {
            $.ykmodal(t.html);
            $.ykmsg.close();
            fcom.removeLoader();
        });
    };

    callCouponDiscountIn = function (val, DISCOUNT_IN_PERCENTAGE, DISCOUNT_IN_FLAT) {
        if (val == DISCOUNT_IN_PERCENTAGE) {
            $("#coupon_max_discount_value_div").show();
            if (100 < $('.discountValueJs').val()) {
                $('.discountValueJs').val(100);
            }
        }
        if (val == DISCOUNT_IN_FLAT) {
            $("#coupon_max_discount_value_div").hide();
        }
    };

    callCouponTypePopulate = function (val) {
        if (val == 1) {
            //if cms Page
            $("#couponMinorderDivJs").show();
            $("#couponValidforDivJs").hide();

        } if (val == 3) {
            $("#couponMinorderDivJs").hide();
            $("#couponValidforDivJs").show();
        }
    };

    loadImages = function (recordId, lang_id) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'images', [recordId, lang_id]), '', function (t) {
            fcom.removeLoader();
            $.ykmsg.close();
            var uploadedContentEle = $(".dropzoneContainerJs .dropzoneUploadedJs");
            if (0 < uploadedContentEle.length) {
                uploadedContentEle.remove();
            }

            if ('' != t.html) {
                $(".dropzoneContainerJs").append(t.html);
                $(".dropzoneUploadJs").hide();
            } else {
                $(".dropzoneUploadJs").show();
            }
        });
    };

    deleteImage = function (recordId, afile_id, lang_id) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.ajax(fcom.makeUrl(controllerName, 'deleteImage', [recordId, afile_id, lang_id]), '', function (t) {
            var ans = $.parseJSON(t);
            if (ans.status == 0) {
                $.ykmsg.error(ans.msg);
                return;
            }

            $.ykmsg.success(ans.msg);
            loadImages(recordId, lang_id);
        });
    }

    /* Bind Tagify */
    bindItem = function (e) {
        var linkType = e.detail.data.linkType;
        var recordId = e.detail.data.recordId;
        if ('undefined' == typeof linkType || 'undefined' == typeof recordId) {
            return false;
        }

        var itemId = e.detail.data.id;
        if ('' == itemId) {
            e.detail.tag.remove();
            return false;
        }
        var data = 'linkType=' + linkType + "&id=" + itemId + '&recordId=' + recordId;
        fcom.ajax(fcom.makeUrl(controllerName, "bindItem"), data, function (t) { });
    }

    removeItem = function (tag) {
        var linkType = tag.data.linkType;
        var recordId = tag.data.recordId;
        var itemId = tag.data.id;
        if ('undefined' == typeof linkType || 'undefined' == typeof recordId || 'undefined' == typeof itemId) {
            return false;
        }

        var data = 'linkType=' + linkType + "&id=" + itemId + '&recordId=' + recordId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeItem'), data, function (t) { });
    }

    getItem = function (e) {
        e.stopPropagation();
        var keyword = e.detail.value;
        var element = e.detail.tagify.DOM.originalInput;
        var linkType = element.dataset.linkType;
        var ctrl = '';
        switch (linkType) {
            case 'products':
                ctrl = 'Products';
                break;
            case 'categories':
                ctrl = 'ProductCategories';
                break;
            case 'users':
                ctrl = 'Users';
                break;
            case 'shops':
                ctrl = 'Shops';
                break;
            case 'brands':
                ctrl = 'Brands';
                break;
            case 'subscription':
                ctrl = 'SellerPackages';
                break;
            default:
                $.ykmsg.error(langLbl.invalidRequest);
                return false;
        }
        var recordId = element.dataset.recordId;
        var list = [];
        fcom.ajax(fcom.makeUrl(ctrl, 'autoComplete'), {
            keyword: keyword,
            linkType: linkType,
            recordId: recordId,
            doNotLimitRecords: 1,
        }, function (t) {
            var ans = JSON.parse(t);
            for (i = 0; i < ans.results.length; i++) {
                var results = ans.results;
                list.push({
                    "id": results[i].id,
                    "value": results[i].text,
                    "linkType": linkType,
                    "recordId": recordId,
                });
            }
            e.detail.tagify.settings.whitelist = list;
            e.detail.tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    }
    let isDeletedConfirmed = false;
    bindTagify = function () {
        var input = document.querySelectorAll('.tagifyJs');
        input.forEach(function (element) {
            tagify = new Tagify(element, {
                whitelist: [],
                dropdown: {
                    closeOnSelect: false,
                    position: 'text',
                    enabled: 1 // show suggestions dropdown after 1 typed character
                },
                hooks: {
                    beforeRemoveTag: function (tags) {
                        return new Promise((resolve, reject) => {
                            if (isDeletedConfirmed == false && !confirm(langLbl.confirmRemove)) {
                                return false;
                            }
                            isDeletedConfirmed = true;
                            removeItem(tags[0]);
                            resolve();
                        })
                    }
                }
            }).on('input', getItem).on('focus', getItem).on('dropdown:select', bindItem);
        });
    };
})();
