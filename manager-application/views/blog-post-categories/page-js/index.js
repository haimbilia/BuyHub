$(document).ready(function() {
    searchBlogPostCategories();
});
(function() {

	searchBlogPostCategories = function () {
		fcom.ajax(fcom.makeUrl('BlogPostCategories', 'search'), '', function (res) {
			$("#listing").html(res);
		});
	};

	reloadList = function(){
		searchBlogPostCategories();
	}

    displaySubCategories = function (obj, catId = 0, data, callable = '') {
		$(obj).removeClass('clickable');
		if (catId > 0) {
			var recordId = catId;
		} else {
			var recordId = $(obj).parent().parent().parent().attr('id');
		}

		if ($("#" + recordId + ' ul.append-ul').length) {
			$("#" + recordId + ' ul:first').show();
			if (catId == 0) {
				togglePlusMinus(recordId);
			}
			if (catId > 0) {
				updateCatOrder(data);
			}
			return false;
		}

		fcom.ajax(fcom.makeUrl('BlogPostCategories', 'getSubCategories'), 'recordId=' + recordId, function (res) {
			if ($("#" + recordId).children('ul.append-ul').length) {
				$("#" + recordId).children('ul.append-ul').append(res);
			} else {
				$("#" + recordId).append('<ul class="append-ul">' + res + '</ul>');
			}
			if (catId == 0) {
				togglePlusMinus(recordId);
			}	
			
			if (catId > 0) {
				updateCatOrder(data);
			}

			if ('' != callable) {
				window[callable]();
			}
		});
	}

    togglePlusMinus = function (catId) {
		$("#" + catId).children('div').children('.sortableListsOpener').remove();
		if ($("#" + catId).hasClass('sortableListsClosed')) {
			$("#" + catId).removeClass('sortableListsClosed').addClass('sortableListsOpen');
			$("#" + catId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-minus clickable sort-icon cat'+catId+'-js" onClick="hideItems(this)"></i></span>');
		} else {
			$("#" + catId).removeClass('sortableListsOpen').addClass('sortableListsClosed');
			$("#" + catId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon cat'+catId+'-js" onClick="displaySubCategories(this)"></i></span>');
		}

		$("#" + catId + ' > ul:first > li:has(> ul)').children('div').children('.sortableListsOpener').remove();
		$("#" + catId + ' > ul:first > li:has(> ul)').removeClass('sortableListsOpen').addClass('sortableListsClosed');
		$("#" + catId + ' > ul:first > li:has(> ul)').children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon" onClick="displaySubCategories(this)"></i></span>');
	}

	updateCatOrder = function (data) {
		fcom.updateWithAjax(fcom.makeUrl('BlogPostCategories', 'updateOrder'), data, function (res) {
			searchBlogPostCategories();
			$("#js-cat-section").removeClass('overlay-blur');
			setTimeout(function(){
				data = queryStringToJSON(data);
				goToCategory(data.catId);
			}, 1000);
		});
	}

	hideItems = function (obj) {
		var catId = $(obj).parent().parent().parent().attr('id');
		$("#" + catId + ' ul').hide();
		$("#" + catId).removeClass('sortableListsOpen').addClass('sortableListsClosed');
		var icon = $("#" + catId).children('div').children('.sortableListsOpener').remove();
		$("#" + catId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon" onClick="displaySubCategories(this)"></i></span>');
	}

	var parentIds = [];
	var i = 0;
	goToCategory = function (catId = 0) {
		if (0 < parentIds.length) {
			parentIds = i >= parentIds.length ? [] : parentIds;

			if (i < parentIds.length) {
				const element = $('.cat' + parentIds[i] + '-js')[0];
				i = i+1;
				displaySubCategories(element, 0, '', 'goToCategory');
			}
			return;
		} else {
			i = 0;
			fcom.ajax(fcom.makeUrl('BlogPostCategories', 'getParentIds', [catId]), '', function (t) {
				var ans = JSON.parse(t);	
				if (0 < ans.status) {					
					parentIds = ans.data;					
					if (i < parentIds.length) {						
						const element = $('.cat' + parentIds[i] + '-js')[0];
						i = i+1;
						displaySubCategories(element, 0, '', 'goToCategory');
					}
				}
			});
		}
	}  
	goToBlog = function (prodCatId) {
		window.location.href = fcom.makeUrl('BlogPosts', 'index', [prodCatId]);
	};

})();
