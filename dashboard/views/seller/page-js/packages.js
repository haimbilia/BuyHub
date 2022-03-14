$("document").ready(function () {
	$(".buySubscription--js").on('click', function (event) {
		event.preventDefault();
		var selectedPackage = $(this).closest('.packagesBoxJs');
		if (selectedPackage.find('input[name=packages]:checked').val() == '' || selectedPackage.find('input[name=packages]:checked').val() == 0 || selectedPackage.find('input[name=packages]:checked').val() == undefined) {
			fcom.displayErrorMessage(langLbl.selectPlan);
			return false;
		}

		if (currentActivePlanId != undefined && currentActivePlanId == selectedPackage.find('input[name=packages]:checked').val()) {
			fcom.displayErrorMessage(langLbl.alreadyHaveThisPlan);
			return false;
		}

		/* $packageId = $(this).attr('data-id'); */

		$spplan_id = selectedPackage.find('input[name=packages]:checked').val();

		subscription.add($spplan_id, true);
		return false;
	});
	/* $(".buyFreeSubscription").on('click', function(event){
		event.preventDefault();
		$packageId = $(this).attr('data-id');

		subscription.add( $packageId, true , true);
		return false;
	}); */
});

function htmlDecode(input) {
	var e = document.createElement('div');
	e.innerHTML = input;
	return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
}
