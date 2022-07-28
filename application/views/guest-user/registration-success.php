<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 ">
                <div class="thanks-screen text-center">
                    <div class="success-animation">
                        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"></circle>
                            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path>
                        </svg>
                    </div>

                    <h2><?php echo Labels::getLabel('MSG_Congratulations', $siteLangId); ?></h2>

                    <p><?php echo $registrationMsg; ?> </p>
                </div>
            </div>
        </div>
    </div>
</section>