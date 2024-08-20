$(document).ready(function () {
  searchRecords(document.frmRecordSearch);
});

$(document).on("click", ".headerColumnJs", function (e) {
  var fld = $(this).attr("data-field");
  var frm = document.frmReportPaging;
  document.getElementById("sortBy").value = fld;
  $(frm.sortBy).val(fld);
  if (document.getElementById("sortOrder").value == "ASC") {
    $(frm.sortOrder).val("DESC");
    document.getElementById("sortOrder").value = "DESC";
  } else {
    $(frm.sortOrder).val("ASC");
    document.getElementById("sortOrder").value = "ASC";
  }
  searchRecords(frm, false);
});

$(function () {
  $("#sortable")
    .sortable({
      helper: fixWidthHelper,
      handle: ".handleJs",
      start: fixPlaceholderStyle,
      stop: function () {
        reloadList(false);
      },
    })
    .disableSelection();
});

(function () {
  var dv = "#listingDiv";

  searchRecords = function (frm, withloader) {
    setColumnsData(frm);
    if (typeof withloader == "undefined" || withloader != false) {
      $(dv).prepend(fcom.getLoader());
    }
    var data = fcom.frmData(frm);
    fcom.ajax(fcom.makeUrl("Reports", "searchSalesReport"), data, function (t) {
      fcom.removeLoader();
      $(dv).html(t);
    });
  };

  goToSalesReportSearchPage = function (page) {
    if (typeof page == undefined || page == null) {
      page = 1;
    }
    var frm = document.frmReportPaging;
    $(frm.page).val(page);
    searchRecords(frm);
  };

  reloadList = function (withloader) {
    var frm = document.frmRecordSearch;
    searchRecords(frm, withloader);
  };

  clearSearch = function () {
    document.frmRecordSearch.reset();
    $("input:checkbox[name=reportColumns]:checked").each(function () {
      if ($(this).attr("disabled") != "disabled") {
        $(this).prop("checked", false);
      }
    });
    searchRecords(document.frmRecordSearch);
  };

  exportReport = function () {
    setColumnsData(document.frmRecordSearch);
    document.frmRecordSearch.action = fcom.makeUrl(
      "Reports",
      "exportSalesReport"
    );
    document.frmRecordSearch.submit();
  };

  setColumnsData = function (frm) {
    reportColumns = [];
    $("input:checkbox[name=reportColumns]:checked").each(function () {
      reportColumns.push($(this).val());
    });
    $(frm.reportColumns).val(JSON.stringify(reportColumns));
  };
  redirectUrl = function (url) {
    window.location = url;
  };
})();
