$(document).ready(function () {
    searchRecords(document.frmSearch);

    $('input[name=\'user_name\']').autocomplete({
        'classes': {
            "ui-autocomplete": "custom-ui-autocomplete"
        },
        'source': function (request, response) {
            $.ajax({
                url: fcom.makeUrl('Users', 'autoCompleteJson'),
                data: { keyword: request['term'], fIsAjax: 1 },
                dataType: 'json',
                type: 'post',
                success: function (json) {
                    response($.map(json, function (item) {
                        return { label: item['name'] + '(' + item['username'] + ')', value: item['name'] + '(' + item['username'] + ')', id: item['id'] };
                    }));
                },
            });
        },
        select: function (event, ul) {
            $("input[name='user_id']").val(ul.item.id);
        }
    });
});

(function () {
    var dv = '#listing';
    var controller = 'BadgeRequests';

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSrchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    reloadList = function () {
        var frm = document.frmSrchPaging;
        searchRecords(frm);
    };

    form = function (badgeReqId) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl(controller, 'form', [badgeReqId]), '', function (t) {
                $.facebox(t, 'medium-fb-width catalog-bg');
            });
        });
    };

    setup = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controller, 'setup'), data, function (t) {
            reloadList();
            $(document).trigger('close.facebox');
        });
    };

    searchRecords = function (frm) {
        $(dv).html(fcom.getLoader());
        data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controller, 'search'), data, function (res) {
            $(dv).html(res);
        });
    }

    clearSearch = function () {
        $('input[name="user_id"]').val("");
        document.frmSearch.reset();
        searchRecords(document.frmSearch);
        $('.searchHead--js').click();
    };

})();