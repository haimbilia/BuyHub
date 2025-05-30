(function () {
	exportForm = function (actionType) {
		fcom.ajax(fcom.makeUrl('ImportExport', 'exportForm', [actionType]), '', function (t) {
			$.ykmodal(t);
		});
	};

	exportData = function (frm, actionType) {
		if (!$(frm).validate()) { return; }
		document.frmImportExport.action = fcom.makeUrl('ImportExport', 'exportData', [actionType]);
		document.frmImportExport.submit();
	};

	exportMediaForm = function (actionType) {
		fcom.ajax(fcom.makeUrl('ImportExport', 'exportMediaForm', [actionType]), '', function (t) {
			$.ykmodal(t);
		});
	};

	exportMedia = function (frm, actionType) {
		if (!$(frm).validate()) { return; }
		document.frmImportExport.action = fcom.makeUrl('ImportExport', 'exportMedia', [actionType]);
		document.frmImportExport.submit();
	};

	importForm = function (actionType) {
		fcom.ajax(fcom.makeUrl('ImportExport', 'importForm', [actionType]), '', function (t) {
			$.ykmodal(t);
		});
	};

	getInstructions = function (actionType) {
		fcom.ajax(fcom.makeUrl('ImportExport', 'importInstructions', [actionType]), '', function (t) {
			$.ykmodal(t);
		});
	};

	importMediaForm = function (actionType) {
		fcom.ajax(fcom.makeUrl('ImportExport', 'importMediaForm', [actionType]), '', function (t) {
			$.ykmodal(t);
		});
	};

	importFile = function (method, actionType) {
		var data = new FormData();
		$inputs = $('#frmImportExport input[type=text],#frmImportExport select,#frmImportExport input[type=hidden]');
		$inputs.each(function () { data.append(this.name, $(this).val()); });
		fcom.displayProcessing();
		$.each($('#import_file')[0].files, function (i, file) {
			$('#fileupload_div').prepend(fcom.getLoader());
			data.append('import_file', file);
			$.ajax({
				url: fcom.makeUrl('ImportExport', method, [actionType]),
				type: "POST",
				data: data,
				processData: false,
				contentType: false,
				success: function (t) {
					fcom.removeLoader();
					try {
						var ans = $.parseJSON(t);
						if (ans.status == 1) {
							fcom.displaySuccessMessage(ans.msg);
						} else {
							$('#fileupload_div').html('');							
							fcom.displayErrorMessage(ans.msg);
						}

						if (typeof ans.CSVfileUrl !== 'undefined') {
							location.href = ans.CSVfileUrl;
						}
					}
					catch (exc) {
						fcom.displayErrorMessage(t);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert("Error Occured.");
				}
			});
		});
	};

	showHideExtraFld = function (type, BY_ID_RANGE, BY_BATCHES) {
		if (type == BY_ID_RANGE) {
			$(".range_fld").show();
			$(".batch_fld").hide();
		} else if (type == BY_BATCHES) {
			$(".range_fld").hide();
			$(".batch_fld").show();
		} else {
			$(".range_fld").hide();
			$(".batch_fld").hide();
		}
	};

})();
