<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$recordId = $recordId ?? 0;
if (0 < $recordId) {
    include('row.php');
} else { ?>
    <div class="accordion-categories listingRecordJs">
        <?php if (count($arrListing) > 0) { ?>
            <ul id="sorting-categories" class="sorting-categories">
                <?php foreach ($arrListing as $sn => $row) {
                    include('row.php');
                } ?>
            </ul>
        <?php } else {
            $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId));
        }
        ?>
    </div>
<?php } ?>

<script type="text/javascript">
    $(function() {
        var optionsPlus = {
            insertZone: 0,
            insertZonePlus: true,
            placeholderCss: {
                'background-color': '#e5f5ff',
            },
            hintCss: {
                'background-color': '#6dc5ff'
            },
            baseCss: {
                'list-style-type': 'none',
            },
            listsClass: "sorting-categories",
            onDragStart: function(e, cEl) {
                var catId = $(cEl).attr('id');
                $("#" + catId).children().children().children('.sorting-title').css('margin-left', '25px');
                $("#" + catId).children('ul').css('list-style-type', 'none');
            },
            complete: function(cEl) {
                var catId = $(cEl).attr('id');
                $("#" + catId).children().children().children('.sorting-title').css('margin-left', '0px');
            },
            onChange: function(cEl) {

                $("#js-cat-section").addClass('overlay-blur');
                var catId = $(cEl).attr('id');
                var parentCatId = $(cEl).parent('ul').parent('li').attr('id');
                var catOrder = [];
                $($(cEl).parent().children()).each(function(i) {
                    catOrder[i + 1] = $(this).attr('id');
                });
                var data = "catId=" + catId + "&parentCatId=" + parentCatId + "&catOrder=" + JSON.stringify(catOrder);

                if (typeof parentCatId != 'undefined') {
                    displaySubCategories(cEl, parentCatId, data);
                    $(cEl).parents('li').each(function() {
                        var rootCat = $(this).attr('id');
                        $("#" + rootCat).children('div').children('.sortableListsOpener').remove();
                        $("#" + rootCat).removeClass('sortableListsClosed').addClass(
                            'sortableListsOpen');
                        $("#" + rootCat).children('div').append(
                            '<span class="sortableListsOpener" ><i class="fa fa-minus clickable sort-icon" onclick="hideItems(this)"></i></span>'
                        );
                    });
                    $("#" + catId).parent('ul').addClass('append-ul');
                } else {
                    updateCatOrder(data);
                }
            },
            opener: {
                active: true,
                as: 'html', // if as is not set plugin uses background image
                close: '<i class="fa fa-minus clickable sort-icon" onclick="hideItems(this)"></i>',
                open: '<i class="fa fa-plus c3 clickable sort-icon" onclick="displaySubCategories(this)"></i>',
                openerCss: {}
            },
            ignoreClass: 'clickable'
        };

        $('#sorting-categories').sortableLists(optionsPlus);

    });
</script>