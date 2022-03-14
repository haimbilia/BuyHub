$(document).ready(function () {
    searchRecords();
});

(function () {
    var runningAjaxReq = false;
    var dv = '#listing';

    reloadList = function () {
        searchRecords();
    };

    searchRecords = function (form) {
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'searchUsers'), data, function (res) {
            fcom.removeLoader();
            showFormActionsBtns();
            $(dv).html(res);
            $('.hideDiv-js').removeClass('d-none');
        });
    };
    goToUserSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmUserSearchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    }

    addUserForm = function (id) {
        fcom.ajax(fcom.makeUrl('Seller', 'addSubUserForm', [id]), '', function (t) {
            fcom.removeLoader();
            $.ykmodal(t);
            stylePhoneNumberFld();
        });
    };

    setup = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setupSubUser'), data, function (t) {
            $.ykmsg.close();
            reloadList();
            closeForm();
        });
    };

    userPasswordForm = function (id) {
        fcom.ajax(fcom.makeUrl('Seller', 'subUserPasswordForm', [id]), '', function (t) {
            $.ykmodal(t);
        });
    };

    updateUserPassword = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'updateUserPassword'), data, function (t) {
            $.ykmodal.close();
            $.ykmsg.close();
            reloadList();
        });
    };

    deleteRecord = function (id) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        data = 'splatformId=' + id;
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'deleteuser'), data, function (res) {
            reloadList();
        });
    };

    cancelForm = function (frm) {
        reloadList();
        $(dv).html('');
    };

    toggleBulkStatues = function (status) {
        if (!confirm(langLbl.confirmUpdateStatus)) {
            return false;
        }
        $("#frmSellerUsersListing input[name='status']").val(status);
        $("#frmSellerUsersListing").submit();
    };

    toggleSellerUserStatus = function (e, obj) {
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return;
        }
        var userId = parseInt(obj.value);
        if (userId < 1) {
            return false;
        }
        var status = (obj.hasAttribute('checked')) ? 0 : 1;
        data = 'userId=' + userId + '&status=' + status;
        fcom.ajax(fcom.makeUrl('Seller', 'changeUserStatus'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

})();
