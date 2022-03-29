
(function() {	
    
    setUpCourierRelation = function(ele) {
		var trackingApiCode = $(ele).val();
        var shipApiCode = $(ele).attr('id');
        if(trackingApiCode == '' || shipApiCode == ''){
            return false;
        }
        
        var data = 'trackingApiCode='+trackingApiCode+'&shipApiCode='+shipApiCode;
		fcom.updateWithAjax(fcom.makeUrl('TrackingCodeRelation', 'setUpCourierRelation'), data, function(t) {
            fcom.closeProcessing();
			searchCourier();
		});
	};
})();
