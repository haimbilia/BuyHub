<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$actionItemsData = $actionItemsData + [
    'canEdit' => $canEdit ?? false
];
?>
<style>
.sorting-categories li {
    padding-left: 50px;
    margin: 5px;
    border: 1px solid #dee2e6;
    background-color: #efefef;
    color: #282828;
}

.sorting-categories li div {
    background: #ffffff;
}

ul.append-ul {
    background: #ffffff;
    display: flex;
    flex-direction: column;
}
.sorting-categories .sorting-bar{
    margin-bottom: 0;
}
.sorting-categories .sorting-bar{
    border: 0;
}
ul.append-ul li + li {
    margin-top: 0;
}
</style>
<main class="main mainJs">
    <div class="container">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', $actionItemsData, false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <?php include ('search.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    var addNewRatingType = '<?php echo Labels::getLabel('LBL_ADD_NEW_RATING_TYPE?', $siteLangId); ?>';
</script>