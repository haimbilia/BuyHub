var keyName = 'EasyEcom';

$(document).ready(function() {
    landingPage();
});

(function() {
    var dv = '#landingpage-js';
    landingPage = function(){
		$(dv).html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl(keyName, 'landingPage'), '', function(res){
			$(dv).html(res);
		});
    };

    register = function (){
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(keyName, 'register'), '', function(res) {
            $(dv).html(res);
        });
    }
})();
