<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body">
    <?php $this->includeTemplate('_partial/page-head-section.php', ['headLabel' => Labels::getLabel('LBL_ALL_TOP_BRANDS'), 'includeBreadcrumb' => true]); ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="cg-main">
                        <?php if (!empty($allBrands)) {
                            $firstCharacter = '';
                            foreach ($allBrands as $brands) {
                                $str = substr(strtolower(trim($brands['brand_name'])), 0, 1);

                                if (is_numeric($str)) {
                                    $str = '0-9';
                                }

                                if ($str != $firstCharacter) {
                                    if ($firstCharacter != '') {
                                        echo "</ul></div>";
                                    }
                                    $firstCharacter = $str; ?>
                                    <div class="item">
                                        <h6 class="big-title"><?php echo $firstCharacter; ?></h6>
                                        <ul>
                                        <?php } ?>
                                        <li>
                                            <a
                                                href="<?php echo UrlHelper::generateUrl('Brands', 'view', array($brands['brand_id'])); ?>"><?php echo $brands['brand_name']; ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
    </section>
</div>