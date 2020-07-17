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
            res = $.parseJSON(res);
            if (1 > res.status) {
                $.systemMessage(res.msg,'alert--danger', false);
            } else {
                $.systemMessage(res.msg,'alert--success', false);
            }
            landingPage();
        });
    }

    login = function (userTempToken){
        setCookie('_ykEasyLogin', userTempToken);
        setTimeout(function(){ window.open('http://yokartv9.4qcteam.com', '_blank'); }, 1000);
    }
})();
