siteConstants.userWebRoot = (siteConstants.rewritingEnabled) ? siteConstants.webroot : siteConstants.webroot_traditional;
var pageReloading = false;
var fcom = {
	ajaxRequestLog: [],
	logAjaxRequest: function (url, data, res, ajaxLoopHandler) {

		var d = (new Date()).getTime();
		var last = d - 20000;
		var obj = {
			url: url,
			data: (typeof data == "object") ? JSON.stringify(data) : data,
			res: (typeof res == "object") ? JSON.stringify(res) : res,
			t: d
		};

		var repeatCount = 0;

		for (var i = fcom.ajaxRequestLog.length - 1; i >= 0; i--) {
			var oldObj = fcom.ajaxRequestLog[i];
			if (oldObj.t < last) {
				fcom.ajaxRequestLog.splice(i, 1);
				continue;
			}

			if (oldObj.url == obj.url && oldObj.data == obj.data && oldObj.res == obj.res) {
				repeatCount++;
			}
		}

		fcom.ajaxRequestLog.push(obj);

		if (repeatCount >= 10 && !pageReloading) {
			if (confirm('This page seems to be stuck with some ajax call loop.\nDo you want to reload the page?')) {
				pageReloading = true;
				location.reload();
			}
		}

		if (ajaxLoopHandler && repeatCount >= 2) {
			console.log('Executing ajaxLoopHandler for url: ' + url + ', data: ' + obj.data + ', res: ' + obj.res);
			ajaxLoopHandler();
		}

		return repeatCount;
	},

	ajax: function (url, data, fn, options) {
		var o = $.extend(true, { fOutMode: 'html', timeout: null, maxRetry: 0, retryNumber: 0, ajaxLoopHandler: null }, options);
		if ("string" == $.type(data)) {
			data += '&fOutMode=' + o.fOutMode + '&fIsAjax=1';
		}

		if ("object" == $.type(data)) {
			var data = $.extend(true, {}, data);
			if (!data.isAjax) data.fIsAjax = 1;
			if (!data.fOutMode) data.fOutMode = o.fOutMode;
		}

		var dbmsg = o.dbmsg || '<img src="' + fcom.makeUrl() + 'img/loading.gif" alt="Processing..">';
		var dvdebug = $('<div />').append(dbmsg);
		dvdebug.appendTo($('#dv-bg-processes'));

		$.ajax({
			method: "POST",
			url: url,
			data: data,
			dataType: o.fOutMode,
			success: function (t) {
				dvdebug.remove();
				var repeatCount = fcom.logAjaxRequest(url, data, t, o.ajaxLoopHandler);
				if (o.fOutMode == 'json') {
					if (t.status == -1) {
						alert(t.msg);
						if (options.errorFn) {
							options.errorFn();
						}
						return;
					}
				}
				if (repeatCount >= 2 && o.ajaxLoopHandler) {
					setTimeout(function () {
						fn(t);
					}, 1000);
				}
				else {
					fn(t);
				}
			},
			error: function (jqXHR, textStatus, error) {
				console.log(jqXHR.responseText);
				dvdebug.remove();
				if (textStatus == "parsererror" && jqXHR.statusText == "OK") {
					alert('Seems some json error.' + jqXHR.responseText);
					return;
				}


				o.retryNumber++;
				if (o.retryNumber <= o.maxRetry) {
					setTimeout(function () {
						fcom.ajax(url, data, fn, o)
					}, 3000);
				}
				else {
					if (!options.errorFn) {
						console.log('Http Error: ' + textStatus);
						/* alert('Http Error: ' + textStatus); */
					}
				}

				console.log("Ajax Request " + url + " error: " + textStatus + " -- " + error);
				if (options.errorFn) {
					options.errorFn();
				}
			},
			timeout: o.timeout
		});
	},

	addTrailingSlash: function () {
		var existingUrl = window.location.href;
		var lastChar = existingUrl.substr(-1);
		if (lastChar != '/') {
			window.history.pushState("", "", existingUrl + '/');
		}
	},

	updateWithAjax: function (url, data, fn, options, processMsg) {

		if (typeof processMsg == undefined || processMsg == null) {
			processMsg = true;
		}
		if (processMsg) {
			$.mbsmessage(langLbl.requestProcessing, false, 'alert--process alert');
		}
		var o = $.extend(true, { fOutMode: 'json' }, options);
		this.ajax(url, data, function (ans) {
			fcom.closeAlertMessage();
			if (ans.status != 1) {
				$(document).trigger('close.mbsmessage');
				$.systemMessage(ans.msg, 'alert--danger');
				/* Custom Code[ */
				if (ans.redirectUrl) {
					setTimeout(function () { window.location.href = ans.redirectUrl }, 3000);
				}
				/* ] */
				return;
			}

			if (ans.alertType) {
				$alertType = ans.alertType;
			} else {
				$alertType = 'alert--success';
			}

			if (processMsg) {
				$.mbsmessage(ans.msg, true, $alertType);
			}

			if (CONF_AUTO_CLOSE_SYSTEM_MESSAGES == 1) {
				var time = CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES * 1000;
				setTimeout(function () {
					$.systemMessage.close();
				}, time);
			}
			fn(ans);
		}, o);
	},

	camel2dashed: function (str) {
		return str.replace(/([a-zA-Z])(?=[A-Z])/g, '$1-').toLowerCase();
	},

	breakUrl: function (url) {
		url = url.substring(siteConstants.userWebRoot.length);
		var arr = url.split('/');
		var obj = { controller: arr[0], action: '', others: [] };
		arr.shift();
		if (!arr.length) return obj;

		obj.action = arr[0];
		arr.shift();

		obj.others = arr;

		return obj;
	},

	makeUrl: function (controller, action, others, use_root_url, urlRewritingEnabled) {
		if (typeof urlRewritingEnabled === 'undefined') {
			urlRewritingEnabled = (siteConstants.rewritingEnabled == 1);
		}
		if (!use_root_url) {
			use_root_url = (urlRewritingEnabled) ? siteConstants.webroot : siteConstants.webroot_traditional;
		}
		var url;
		if (!controller) controller = '';
		if (!action) action = '';

		controller = this.camel2dashed(controller);
		action = this.camel2dashed(action);

		if (!others) others = [];
		if ('' == action && others.length) action = 'index';

		url = use_root_url + controller;

		if ('' != action) url += '/' + action;
		if (others.length) {
			for (x in others) others[x] = encodeURIComponent(others[x]);
			url += '/' + others.join('/');
		}
		return url;
	},
	frmData: function (frm) {
		var disabled = $(frm).find(':input:disabled').removeAttr('disabled');
		var out = $(frm).serialize();
		disabled.attr('disabled', 'disabled');
		return out;
	},
	qStringToObject: function (q) {
		var args = new Object();
		var pairs = q.split("&");
		for (var i = 0; i < pairs.length; i++) {
			var pos = pairs[i].indexOf('=');
			if (pos == -1) continue;
			var argname = pairs[i].substring(0, pos);
			var value = pairs[i].substring(pos + 1);
			args[argname] = unescape(value);
		}
		return args;
	},
	urlWrittenQueryObject: function () {
		var url = location.pathname;
		url = url.substring(siteConstants.userWebRoot.length);
		var arr = url.split('/');
		if (arr.length <= 2) return {};
		arr.shift();
		arr.shift();
		var obj = {};
		for (var i = 0; i < arr.length; i += 2) {
			obj[arr[i]] = arr[i + 1];
		}

		return obj;
	}
};

$.fn.selectRange = function (start, end) {
	if (!end) end = start;
	return this.each(function () {
		if (this.setSelectionRange) {
			if (!$(this).is(':visible')) return;
			this.focus();
			this.setSelectionRange(start, end);
		} else if (this.createTextRange) {
			var range = this.createTextRange();
			range.collapse(true);
			range.moveEnd('character', end);
			range.moveStart('character', start);
			range.select();
		}
	});
};

/* To override facebox functionality with bootstrap modal. */
(function ($) {
	$.facebox = function (data, klass) {
		init(klass);
		if (data.ajax) fillFaceboxFromAjax(data.ajax)
		else if (data.image) fillFaceboxFromImage(data.image)
		else if (data.div) fillFaceboxFromHref(data.div)
		else if ($.isFunction(data)) data.call($)
		else $.facebox.reveal(data)
	}


	$.extend($.facebox, {
		element : Date.now(),
		reveal: function (data) {
			$('body .' + $.facebox.element + ' .contentBody--js').html(data);

			var headerHtm = '<div class="modal-header">';
			var closeBtnHtm = '<button type="button" class="close" data-dismiss="modal" aria-label="' + langLbl.close + '"><span aria-hidden="true">&times;</span></button>';
			if (1 > $('body .' + $.facebox.element + ' .contentBody--js').find('.modal-header').length) {
				$('body .' + $.facebox.element + ' .contentBody--js').prepend(headerHtm + closeBtnHtm + '</div>');
			} else if (0 < $('body .' + $.facebox.element + ' .contentBody--js').find('.modal-header').length && 1 > $('body .' + $.facebox.element + ' .contentBody--js .modal-header').find('.close').length) {
				console.log();
				$('body .' + $.facebox.element + ' .contentBody--js .modal-header').append(closeBtnHtm);
			}

			$('.' + $.facebox.element).modal('show');
		},

		close: function () {
			$('.' + $.facebox.element).remove();
			return false
		}
	});

	/* called one time to setup facebox on this page */
	function init(klass) {
		var content = '<div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content ' + klass + ' contentBody--js"></div></div>';
		if (1 > $("body").find('.' + $.facebox.element).length) {
			var htm = '<div class="modal fade ' + $.facebox.element + '" tabindex="-1" role="dialog">' + content + '</div>';
			$('body').append(htm);
		} else {
			$('body .' + $.facebox.element).html(htm);
		}

		/* On Close Event. */
		$('.' + $.facebox.element).on("hidden.bs.modal", function () {
			$('.' + $.facebox.element + ', .modal-backdrop').remove();
		});
	}
	
	/* Figures out what you want to display and displays it formats are:
		div: #id
	  image: blah.extension
	   ajax: anything else */
	function fillFaceboxFromHref(href) {
		/* div */
		if (href.match(/#/)) {
			var url = window.location.href.split('#')[0]
			var target = href.replace(url, '')
			if (target == '#') return
			$.facebox.reveal($(target).html())

			/* image */
		} else if (href.match($.facebox.settings.imageTypesRegexp)) {
			fillFaceboxFromImage(href)
			/* ajax */
		} else {
			fillFaceboxFromAjax(href)
		}
	}

	function fillFaceboxFromImage(href) {

		var image = new Image()
		image.onload = function () {
			$.facebox.reveal('<div class="image"><img src="' + image.src + '" /></div>')
		}
		image.src = href
	}

	function fillFaceboxFromAjax(href) {
		$.facebox.jqxhr = $.get(href, function (data) {
			$.facebox.reveal(data)
		})
	}

})(jQuery);