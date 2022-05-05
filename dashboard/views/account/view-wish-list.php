<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$randomId = rand(1, 1000);
$frm->setFormTagAttribute('class', 'form form-apply setupWishList-Js');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('id', 'setupWishList_Js_' . $randomId);
$frm->setFormTagAttribute('onsubmit', 'setupWishList(this,event); return(false);');
$uwlist_title_fld = $frm->getField('uwlist_title');
$uwlist_title_fld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_New_List', $siteLangId));

$btn = $frm->getField('btn_submit');
$btn->setFieldTagAttribute('class', 'btn-apply');
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_Your_List', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php if ($wishLists) { ?>
            <div class="buyer-wishlist">
                <ul class="listing--check">
                    <?php foreach ($wishLists as $list) { ?>
                        <li class="listing--check-item wishListCheckBox_<?php echo $list['uwlist_id']; ?> <?php echo array_key_exists($selprod_id, $list['products']) ? ' is-active' : ''; ?>" onclick="addRemoveWishListProduct(<?php echo $selprod_id . ', ' . $list['uwlist_id']; ?>, event);">
                            <a href="javascript:void(0)">
                                <?php echo ($list['uwlist_type'] == UserWishList::TYPE_DEFAULT_WISHLIST) ? Labels::getLabel('LBL_Default_list', $siteLangId) : $list['uwlist_title']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <div class="">
            <?php
            echo $frm->getFormTag();
            echo $frm->getFieldHtml('uwlist_title');
            echo $frm->getFieldHtml('selprod_id');

            ?> <button type="submit" name="btn_submit" class="btn-apply">
                <?php echo Labels::getLabel('LBL_Add', $siteLangId); ?></button>
            </form>
            <?php echo $frm->getExternalJs(); ?>
        </div>
    </div>

</div>