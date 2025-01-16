$(document).ready(function () {
	profileInfoForm();
});

(function () {
	var runningAjaxReq = false;
	var dv = '#profileInfoFrmBlock';
	var imgdv = '#profileImageFrmBlock';

	profileInfoForm = function () {
		$(dv).prepend(fcom.getLoader());
		$("#tab-myaccount").parents().children().removeClass("is-active");
		$("#tab-myaccount").addClass("is-active");
		fcom.ajax(fcom.makeUrl('Account', 'profileInfoForm'), '', function (t) {
			fcom.removeLoader();
			$(dv).html(t);
			stylePhoneNumberFld();
		});
	};

	profileImageForm = function () {
		$(imgdv).prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Account', 'profileImageForm'), '', function (t) {
			fcom.removeLoader();
			location.reload();
			/* $(imgdv).html(t); */
		});
	};

	updateProfileInfo = function (frm) {

		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'updateProfileInfo'), data, function (t) { });
	};

	setPreferredDashboad = function (id) {
		fcom.updateWithAjax(fcom.makeUrl('Account', 'setPrefferedDashboard', [id]), '', function (res) {
		});
	};

	settingsForm = function () {
		$(dv).prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Account', 'settingsInfo'), '', function (t) {
			fcom.removeLoader();
			$(dv).html(t);
		});
	};
	setSettingsInfo = function (frm) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'updateSettingsInfo'), data, function (t) {
			settingsForm();
		});
	};
	setBankInfo = function (frm) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'updateBankInfo'), data, function (t) {
			// bankInfoForm();
		});
	};

	removeProfileImage = function () {
		fcom.ajax(fcom.makeUrl('Account', 'removeProfileImage'), '', function (t) {
			profileImageForm();
		});
	};

	sumbmitProfileImage = function () {
		$("#frmProfile").ajaxSubmit({
			delegation: true,
			success: function (json) {
				json = $.parseJSON(json);
				profileImageForm();

			}
		});
	};

	setUpAffiliatePaymentInfo = function (frm) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Affiliate', 'setUpPaymentInfo'), data, function (t) {
			//returnAddressForm();
		});
	}

	popupImage = function (inputBtn) {
		loadCropperSkeleton(false);
		$("#modalBoxJs .modal-title").text(cropperHeading);
		if (inputBtn) {
			if (inputBtn.files && inputBtn.files[0]) {
				if (!validateFileUpload(inputBtn.files[0])) {
					return;
				}
				fcom.updateWithAjax(fcom.makeUrl('Account', 'imgCropper'), '', function (t) {
					$("#modalBoxJs .modal-body").html(t.body);
					$("#modalBoxJs .modal-footer").html(t.footer);
					var file = inputBtn.files[0];
					var options = {
						aspectRatio: 1 / 1,
						preview: '.img-preview',
						imageSmoothingQuality: 'high',
						imageSmoothingEnabled: true,
						crop: function (e) {
							var data = e.detail;
						}
					};
					$(inputBtn).val('');
					setTimeout(function () { cropImage(file, options, 'saveProfileImage', inputBtn); }, 100);
					return;
				});
			}
		} else {
			fcom.updateWithAjax(fcom.makeUrl('Account', 'imgCropper'), '', function (t) {
				$("#modalBoxJs .modal-body").html(t.body);
				$("#modalBoxJs .modal-footer").html(t.footer);
				var container = document.querySelector('.img-container');
				var image = container.getElementsByTagName('img').item(0);
				var options = {
					aspectRatio: 1 / 1,
					preview: '.img-preview',
					imageSmoothingQuality: 'high',
					imageSmoothingEnabled: true,
					crop: function (e) {
						var data = e.detail;
					}
				};
				setTimeout(function () { cropImage(image, options, 'saveProfileImage'); }, 100);
				return
			});
		}
	};

	saveProfileImage = function (formData) {
		$.ajax({
			url: fcom.makeUrl('Account', 'uploadProfileImage'),
			type: 'post',
			dataType: 'json',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('#loader-js').prepend(fcom.getLoader());
			},
			success: function (ans) {
				fcom.removeLoader();
				fcom.displaySuccessMessage(ans.msg);
				$("#modalBoxJs").modal("hide");
				profileInfoForm();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}

	truncateDataRequestPopup = function () {
		fcom.ajax(fcom.makeUrl('Account', 'truncateDataRequestPopup'), '', function (t) {
			$.ykmodal(t, true);
		});
	};

	sendTruncateRequest = function () {
		fcom.updateWithAjax(fcom.makeUrl('Account', 'sendTruncateRequest'), '', function (t) {
			profileInfoForm();
			$.ykmodal.close();
		});
	};

	cancelTruncateRequest = function () {
		$.ykmodal.close();
	};

	requestData = function () {
		fcom.ajax(fcom.makeUrl('Account', 'requestDataForm'), '', function (t) {
			$.ykmodal(t, true);
		});
	};

	setupRequestData = function (frm) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'setupRequestData'), data, function (t) {
			$.ykmodal.close();
		});
	};

	setCookiesPreferences = function (frm) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'updateCookiesPreferences'), data, function (t) { });
	};
	guestActivate = function () {
		fcom.updateWithAjax(fcom.makeUrl('Account', 'guestActivate'), '', function (t) {
			fcom.displaySuccessMessage(t.msg);
		});
	}
})();
