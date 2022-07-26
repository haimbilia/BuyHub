<h2><?php echo Labels::getLabel('LBL_Seller_Registration', $siteLangId); ?></h2>

<div class="registeration-process">
    <ul>
        <li><a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Details', $siteLangId); ?></a></li>
        <li><a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Activation', $siteLangId); ?></a></li>
        <li class="is--active"><a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Confirmation', $siteLangId); ?></a></li>
    </ul>
</div>
<div class="thanks-screen text-center">
    <div class="success-animation">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"></circle>
            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path>
        </svg>
    </div>

    <h2><?php echo Labels::getLabel('MSG_Congratulations', $siteLangId); ?>!</h2>
    <p><?php echo $success_message; ?></p>
    <div class="gap"></div>
    <a href="<?php echo UrlHelper::generateUrl('guest-user', 'login-form'); ?>" class="btn btn-brand"><?php echo Labels::getLabel('Lbl_Login', $siteLangId); ?></a>

</div>