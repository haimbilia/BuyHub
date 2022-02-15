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

		if (!$(frm).validate()) return;
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
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'updateSettingsInfo'), data, function (t) {
			settingsForm();
		});
	};
	setBankInfo = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'updateBankInfo'), data, function (t) {
			bankInfoForm();
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
				$(document).trigger('close.facebox');
			}
		});
	};

	setUpAffiliatePaymentInfo = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Affiliate', 'setUpPaymentInfo'), data, function (t) {
			//returnAddressForm();
		});
	}

	popupImage = function (inputBtn) {
		if (inputBtn) {
			if (inputBtn.files && inputBtn.files[0]) {
				$.facebox(fcom.getLoader(), '', 'cropper-body');
				fcom.ajax(fcom.makeUrl('Account', 'imgCropper'), '', function (t) {
					$.facebox(t);
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
					return cropImage(file, options, 'saveProfileImage', inputBtn);
				});
			}
		} else {
			$.facebox(fcom.getLoader(), '', 'cropper-body');
			fcom.ajax(fcom.makeUrl('Account', 'imgCropper'), '', function (t) {
				$.facebox(t);
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
				return cropImage(image, options, 'saveProfileImage');
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
				$('#dispMessage').html(ans.msg);
				profileInfoForm();
				$(document).trigger('close.facebox');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}

	truncateDataRequestPopup = function () {
		$.facebox(function () {
			fcom.ajax(fcom.makeUrl('Account', 'truncateDataRequestPopup'), '', function (t) {
				$.facebox(t);
			});
		});
	};

	sendTruncateRequest = function () {
		fcom.updateWithAjax(fcom.makeUrl('Account', 'sendTruncateRequest'), '', function (t) {
			profileInfoForm();
			$.facebox.close();
		});
	};

	cancelTruncateRequest = function () {
		$.facebox.close();
	};

	requestData = function () {
		$.facebox(function () {
			fcom.ajax(fcom.makeUrl('Account', 'requestDataForm'), '', function (t) {
				$.facebox(t);
			});
		});
	};

	setupRequestData = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'setupRequestData'), data, function (t) {
			$.facebox.close();
		});
	};

	setCookiesPreferences = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'updateCookiesPreferences'), data, function (t) { });
	};

})();
