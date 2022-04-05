$(function () {
	$(".buySubscription--js").on('click', function (event) {
		event.preventDefault();
		var selectedPackage = $(this).closest('.packagesBoxJs');
		if (selectedPackage.find('.packagesJS').val() == '' || selectedPackage.find('.packagesJS').val() == 0 || selectedPackage.find('.packagesJS').val() == undefined) {
			fcom.displayErrorMessage(langLbl.selectPlan);
			return false;
		}

		if (currentActivePlanId != undefined && currentActivePlanId == selectedPackage.find('.packagesJS').val()) {
			fcom.displayErrorMessage(langLbl.alreadyHaveThisPlan);
			return false;
		}

		var spplan_id = selectedPackage.find('.packagesJS').val();
		alert(spplan_id);return;
		subscription.add(spplan_id, true);
		return false;
	});
});

function htmlDecode(input) {
	var e = document.createElement('div');
	e.innerHTML = input;
	return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
}
