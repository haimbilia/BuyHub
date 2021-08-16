/* To override facebox functionality with bootstrap modal. */
(function ($) {
	$.facebox = function (data, klass, bodyClass) {
		init(klass);
		if (data.ajax) fillFaceboxFromAjax(data.ajax)
		else if (data.image) fillFaceboxFromImage(data.image)
		else if (data.div) fillFaceboxFromHref(data.div)
		else if ($.isFunction(data)) data.call($)
		else $.facebox.reveal(data, bodyClass)
	}


	$.extend($.facebox, {
		element: Date.now(),
		reveal: function (data, bodyClass) {
            if (0 == $(data).find('.modal-body').length && false === $(data).hasClass('modal-body')) {
                data = '<div class="modal-body">' + data + '</div>'
            }

            var contentBody = 'body .' + $.facebox.element + ' .contentBody--js';

			$(contentBody).html(data);

			var headerHtm = '<div class="modal-header">';
			var closeBtnHtm = '<button type="button" class="close" data-dismiss="modal" aria-label="' + langLbl.close + '"><span aria-hidden="true">&times;</span></button>';
			if (1 > $(contentBody).find('.modal-header').length) {
				$(contentBody).prepend(headerHtm + closeBtnHtm + '</div>');
			} else if (0 < $(contentBody).find('.modal-header').length && 1 > $('body .' + $.facebox.element + ' .contentBody--js .modal-header').find('.close').length) {
				$('body .' + $.facebox.element + ' .contentBody--js .modal-header').append(closeBtnHtm);
			}
            
            if ('undefined' != typeof bodyClass && 0 == $(data).find(bodyClass).length) {
                $(contentBody + " .modal-body").addClass(bodyClass);
            }

			$('.' + $.facebox.element).modal('show');
		},

		close: function () {
			$("." + $.facebox.element).modal('hide');
            setTimeout(() => {
                $("." + $.facebox.element + ', .modal-backdrop').remove();
            }, 500);
			return false;
		}
	});

	/* called one time to setup facebox on this page */
	function init(klass) {
		klass = ('undefined' == typeof klass ? '' : klass);
		if (1 > $("body").find('.' + $.facebox.element).length) {
			var content = '<div class="modal-dialog modal-dialog-centered ' + klass + ' " role="document"><div class="modal-content contentBody--js"></div></div>';
			var htm = '<div class="modal fade ' + $.facebox.element + '" tabindex="-1" role="dialog">' + content + '</div>';
			$('body').append(htm);
		}
		
		if (!$('body .' + $.facebox.element + ' .modal-dialog').hasClass(klass)) {
			$('body .' + $.facebox.element + ' .modal-dialog').addClass(klass);
		}
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

	/*
	 * Bindings
	 */
	$(document).bind('close.facebox', function () {
		$.facebox.close();
	})

	$(document).on('hidden.bs.modal', '.' + $.facebox.element, function(){
		$.facebox.close();
	});

})(jQuery);