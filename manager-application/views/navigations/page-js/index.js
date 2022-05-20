(function () {
    var dv = "#listing";

    reloadList = function () {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'search'), '', function (res) {
            fcom.removeLoader();
            $(dv).html(res.html);
        });
    };

    callPageTypePopulate = function (el) {
        var nlink_type = $(el).val();
        if (nlink_type == 0) {
            //if cms Page
            $("#nlinkUrlWrapJs").hide();
            $("#nlinkCategoryIdWrapJs").hide();
            $("#nlinkCpageIdWrapJs").show();

        } else if (nlink_type == 2) {
            //if External page
            $("#nlinkUrlWrapJs").show();
            $("#nlinkCpageIdWrapJs").hide();
            $("#nlinkCategoryIdWrapJs").hide();
        }
        else if (nlink_type == 3) {
            //if External page
            $("#nlinkUrlWrapJs").hide();
            $("#nlinkCpageIdWrapJs").hide();
            $("#nlinkCategoryIdWrapJs").show();
        }
    };

    addNewLinkForm = function (navId, nlinkId = 0) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "linkForm"), 'nav_id=' + navId + '&nlink_id=' + nlinkId, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, false);
            fcom.removeLoader();
        });
    };

    linkLangForm = function (navId, nlinkId, langId, autoFillLangData = 0) {
        data = "nav_id=" + navId + "&nlink_id=" + nlinkId + "&langId=" + langId;
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "linkLangForm", [autoFillLangData]),
            data,
            function (t) {
                fcom.closeProcessing();
                $.ykmodal(t.html, false);
                fcom.removeLoader();
            }
        );
    };

    setupLink = function (frm) {
        if (!$(frm).validate()) return;
        $.ykmodal(fcom.getLoader());
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setupLink'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
            if (t.langId > 0 && t.nlinkId > 0) {
                linkLangForm($(frm.nlink_nav_id).val(), t.nlinkId, t.langId);
            }

            var navId = ('undefined' != typeof t.navId) ? t.navId : 0;
            var nlinkId = ('undefined' != typeof t.nlinkId) ? t.nlinkId : 0;
            if (1 > $("#childrens-" + navId + " li:visible").length) {
                $('.openerJs[data-record-id="' + navId + '"]').click();
            }
            $(".subRecordsCountJs-" + navId).text(t.subRecordsCount);
            setTimeout(() => {
                togglePlusMinus($('.openerJs[data-record-id="' + navId + '"]')[0], 1);
                getNavLinks(navId);
            }, 500);
        });
    }

    setupLinksLang = function (frm) {
        if (!$(frm).validate()) return;
        $.ykmodal(fcom.getLoader());
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setupLinksLang'), data, function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            if (t.langId > 0 && t.nlinkId > 0) {
                linkLangForm($(frm.nav_id).val(), t.nlinkId, t.langId);
            }
        });
    }

    deleteLink = function (navId, nlinkId) {
        if (!confirm(langLbl.confirmDelete)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'deleteLink'), 'navId=' + navId + '&nlinkId=' + nlinkId, function (res) {
            fcom.displaySuccessMessage(res.msg);
            $(".subRecordsCountJs-" + navId).text(res.subRecordsCount);
            if (1 > res.subRecordsCount) {
                $('.openerJs[data-record-id="' + navId + '"]').removeClass('fa-caret-down').addClass('fa-caret-right').hide();
            }
            $('li#' + nlinkId).remove();
        });
    };

    togglePlusMinus = function (obj, isVisible = 0) {
        if (1 == isVisible) {
            $(obj).removeClass('fa-caret-right').addClass('fa-caret-down');
        } else {
            $(obj).removeClass('fa-caret-down').addClass('fa-caret-right');
        }
    }

    closeAll = function () {
        $('.navigationsJs .fa-caret-down').removeClass('fa-caret-down').addClass('fa-caret-right');
    }

    getNavLinks = function (navId, nlinkId = 0) {
        if (1 > navId || 'undefined' == typeof navId) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        $(dv).prepend(fcom.getLoader());

        var includeWrapper = 1 < nlinkId && (0 < $("#childrens-" + navId).length) ? 0 : 1;      
        var data = 'recordId=' + navId;
        if (0 < nlinkId) {
            data += '&nlinkId=' + nlinkId;
        }

        data += '&includeWrapper=' + includeWrapper;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'navLinks'), data, function (res) {
            fcom.closeProcessing();
            fcom.removeLoader();
            if (0 < nlinkId) {
                if (0 < $('.children-' + navId + '-' + nlinkId).length) {
                    $('.children-' + navId + '-' + nlinkId).replaceWith(res.html);
                } else if (0 < $("#childrens-" + navId).length && 0 == includeWrapper) {
                    $("#childrens-" + navId).append(res.html);
                } else {
                    $("#parent-" + navId).append(res.html);
                }
                return;
            }

            if (0 < $("#childrens-" + navId).length) {
                $("#childrens-" + navId).remove();
            }
            $("#parent-" + navId).append(res.html);
            $("#parent-" + navId +" .openerJs").show();
            
            bindSortable();
        });
    }

    displaySubRows = function (obj, isVisible = 0) {
        bindSortable();

        var navRow = $(obj);
        var navId = navRow.data('record-id');
        var childrens = $("#childrens-" + navId);

        if (1 > isVisible) {
            togglePlusMinus(obj, isVisible);
            navRow.attr('onclick', 'displaySubRows(this, 1)');
            childrens.slideUp()
        } else {
            navRow.attr('onclick', 'displaySubRows(this, 0)');
            closeAll();
            $(".childrensJs").slideUp();
            togglePlusMinus(obj, isVisible);
            if (0 < childrens.length) {
                childrens.slideDown();
                return;
            }
            getNavLinks(navId);
        }
    };

    bindSortable = function () {
        $(".childrensJs").sortable({
            handle: '.handleJs',
            helper: fixWidthHelper,
            start: fixPlaceholderStyle,
            update: function (event, ui) {
                fcom.displayProcessing();
                $(dv).prepend(fcom.getLoader());

                var order = $(this).sortable('toArray');
                var data = '';
                const bindData = new Promise((resolve, reject) => {
                    for (let i = 0; i < order.length; i++) {
                        data += 'nlinksIds[' + (i + 1) + ']=' + order[i];
                        if (i + 1 < order.length) {
                            data += '&';
                        }
                    }
                    resolve(data);
                });
                bindData.then(
                    function (value) {
                        fcom.ajax(fcom.makeUrl(controllerName, 'updateNavlinksOrder'), value, function (res) {
                            fcom.closeProcessing();
                            fcom.removeLoader();
                            var ans = JSON.parse(res);
                            if (ans.status == 1) {
                                fcom.displaySuccessMessage(ans.msg);
                                return;
                            }
                            fcom.displayErrorMessage(ans.msg);
                        });
                    },
                    function (error) {
                        fcom.removeLoader();
                        fcom.closeProcessing();
                    }
                );
            },
        });
    };
})();