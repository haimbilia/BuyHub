$(function () {
	$(".buySubscription--js").on('click', function (event) {
		event.preventDefault();
		var selectedPackage = $(this).closest('.packagesBoxJs')
		var spplan_id = selectedPackage.find('.packagesJS').val();

		if (spplan_id == '' || spplan_id == 0 || spplan_id == undefined) {
			fcom.displayErrorMessage(langLbl.selectPlan);
			return false;
		}

		if (currentActivePlanId != undefined && currentActivePlanId == spplan_id) {
			fcom.displayErrorMessage(langLbl.alreadyHaveThisPlan);
			return false;
		}

		subscription.add(spplan_id, true);
		return false;
	});
});

function htmlDecode(input) {
	var e = document.createElement('div');
	e.innerHTML = input;
	return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
}
