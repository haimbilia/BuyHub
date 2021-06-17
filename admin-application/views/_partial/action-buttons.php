<!-- <div class="dropdown custom-drag-drop">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Customize columns
    </button>
    <div class="dropdown-menu  dropdown-menu-right dropdown-menu-fit dropdown-menu-anim scroll scroll-y" aria-labelledby="dropdownMenuButton">
        <div class="">
            <ul class="list-drag-drop">
                <li class="">
                    <label class="checkbox">
                        <input class="" type="checkbox" name="" value=""><i class="input-helper"></i>
                        Lorem ipsum, dolor Lorem ipsum dolor  dolor Lorem ipsum dolor  
                    </label>

                    <i class="icn fas fa-grip-lines"></i>

                </li>
                <li class="disabled">
                    <label class="checkbox">
                        <input class="" type="checkbox" name="" value=""><i class="input-helper"></i>
                        Lorem ipsum, dolor vel, pariatur dolores facilis
                    </label>

                    <i class="icn fas fa-grip-lines"></i>

                </li>
                <li>
                    <label class="checkbox">
                        <input class="" type="checkbox" name="" value=""><i class="input-helper"></i>
                        Lorem ipsum, dolor
                    </label>

                    <i class="icn fas fa-grip-lines"></i>

                </li>
                <li>
                    <label class="checkbox">
                        <input class="" type="checkbox" name="" value=""><i class="input-helper"></i>
                        Lorem ipsum, dolor vel, pariatur dolores facilis
                    </label>

                    <i class="icn fas fa-grip-lines"></i>

                </li>
                <li>
                    <label class="checkbox">
                        <input class="" type="checkbox" name="" value=""><i class="input-helper"></i>
                        Lorem ipsum, 
                    </label>

                    <i class="icn fas fa-grip-lines"></i>

                </li>
                <li>
                    <label class="checkbox">
                        <input class="" type="checkbox" name="" value=""><i class="input-helper"></i>
                        Lorem ipsum, dolor vel, pariatur dolores facilis
                    </label>

                    <i class="icn fas fa-grip-lines"></i>

                </li>
                <li>
                    <label class="checkbox">
                        <input class="" type="checkbox" name="" value=""><i class="input-helper"></i>
                        Lorem ipsum, dolor
                    </label>

                    <i class="icn fas fa-grip-lines"></i>

                </li>
                <li>
                    <label class="checkbox">
                        <input class="" type="checkbox" name="" value=""><i class="input-helper"></i>
                        Lorem ipsum, dolor
                    </label>

                    <i class="icn fas fa-grip-lines"></i>

                </li>
            </ul>

        </div>
    </div>
</div>
<script>
    $('.dropdown-menu').on('click', function(e) {
    e.stopPropagation();
});
</script> -->
<?php
defined('SYSTEM_INIT') or die('Invalid Usage');

$div = new HtmlElement("div", array("class" => "section__toolbar"));
$msg = isset($msg) ? $msg : '';
if ((!isset($statusButtons) || true === $statusButtons)) {
    $div->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn-clean btn-sm btn-icon btn-secondary toolbar-btn-js d-none', 'title' => Labels::getLabel('LBL_Publish', $adminLangId), "onclick" => "toggleBulkStatues(1, '" . $msg . "')"), '<i class="fas fa-eye"></i>', true);

    $div->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn-clean btn-sm btn-icon btn-secondary toolbar-btn-js d-none', 'title' => Labels::getLabel('LBL_Unpublish', $adminLangId), "onclick" => "toggleBulkStatues(0, '" . $msg . "')"), '<i class="fas fa-eye-slash"></i>', true);
}

if (!isset($deleteButton) || true === $deleteButton) {
    $div->appendElement('a', array('href' => 'javascript:void(0)', 'class' => 'btn-clean btn-sm btn-icon btn-secondary toolbar-btn-js d-none', 'title' => Labels::getLabel('LBL_Delete', $adminLangId), "onclick" => "deleteSelected()"), '<i class="fas fa-trash"></i>', true);
}

if (isset($otherButtons) && is_array($otherButtons)) {
    foreach ($otherButtons as $attr) {
        $class = isset($attr['attr']['class']) ? $attr['attr']['class'] : '';
        $attr['attr']['class'] = 'btn-clean btn-sm btn-icon btn-secondary ' . $class;
        $div->appendElement('a', $attr['attr'], (string) $attr['label'], true);
    }
}

echo $div->getHtml();
