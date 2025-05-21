<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<style>
@keyframes fadeInDownLogo {
    0% {
        opacity: 0;
        transform: translateY(-40px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
@keyframes fadeInUpModal {
    0% {
        opacity: 0;
        transform: translateY(40px) scale(0.95);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes fadeOutModal {
    0% {
        opacity: 1;
        transform: translateY(30px) scale(0.95);
    }
    100% {
        opacity: 0;
        transform: translateY(0) scale(1);
    }
}
.firstVisitLogo {
    max-width: 200px;
    height: auto;
    margin-bottom: 30px;
	animation: fadeInDownLogo 0.6s ease-out;
}

.firstVisitPopupContainer {
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 30px 20px;
    font-family: var(--primary-font, 'Poppins', sans-serif);
    text-align: center;
}

.firstVisitBox {
    position: relative;
    background-color: rgba(147, 112, 219, 0.4);
    color: #fff;
    font-size: 32px;
    font-weight: 500;
    width: 100%;
    max-width: 300px;
    height: 150px;
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 2px solid #4b0082;
    border-radius: 16px;
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.2s ease;
    overflow: hidden; /* ensures pseudo-element stays within box */
	animation: fadeInUpModal 0.8s ease-out;
}

.firstVisitBox::before {
    content: "";
    position: absolute;
    inset: 0;
    background-repeat: no-repeat;
    background-position: center;
    background-size: 90%;
    opacity: 0.3;
    z-index: 0;
}

.firstVisitBox.buy::before {
    background-image: url('/public/images/svg/Buy.svg');
}

.firstVisitBox.sell::before {
    background-image: url('/public/images/svg/Sell.svg');
}

.firstVisitBox > * {
    position: relative;
    z-index: 1;
}

.firstVisitBox:hover {
    background-color: rgba(147, 112, 219, 0.4);
    transform: scale(1.3);
}

.firstVisitBox .labelText {
    color: #fff;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.7);
    position: relative;
    z-index: 1;
}
.firstVisitBox a {
    position: absolute;
    inset: 0;
    z-index: 2;
}
.firstVisitBox .labelText.firstVisitAction {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    font-size: inherit;
    font-weight: inherit;
    background: transparent;
    border: none;
    cursor: pointer;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.7);
}

.firstVisitCloseBtn {
    background-color: rgba(255, 255, 255, 0.2);
    color: #ffe9ff;
    border: 2px solid #705583;
    padding: 12px 12px;
    border-radius: 16px;
    font-size: 26px;
    font-weight: 500;
    margin-top: 30px;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease;
    width: 100%;
    max-width: 300px;
	animation: fadeInUpModal 0.8s ease-out;
}

.firstVisitCloseBtn:hover {
    background-color: #f0f0f0;
    color: #4b0082;
}

@media (max-width: 480px) {
	
	    .firstVisitLogo {
        max-width: 200px;
        margin-bottom: 20px;
    }
    .firstVisitBox {
        padding: 20px;
    }

    .firstVisitCloseBtn {
        width: 100%;
    }

    .firstVisitPopupContainer {
        padding: 20px 10px;
    }
}


#closePopup:checked ~ .firstVisitPopupWrapper {
    opacity: 0;
    transition: opacity 0.4s ease-out;
    pointer-events: none;
}
</style>

<input type="checkbox" id="closePopup" hidden>

<div class="firstVisitPopupWrapper fade show">
    <div class="firstVisitPopupContainer">


    <img src="/public/images/svg/logo2.svg" class="firstVisitLogo" alt="Logo">

    <div class="firstVisitBox buy">
        <div class="labelText firstVisitAction">
            <?php echo Labels::getLabel("LBL_I_WANT_TO_BUY", $siteLangId); ?>
            <a href="javascript:void(0);" onclick="requestForQuoteFn(0); document.getElementById('closePopup').checked = true;" style="position:absolute; inset:0;"></a>
        </div>
    </div>

    <div class="firstVisitBox sell">
        <div class="labelText firstVisitAction">
            <?php echo Labels::getLabel("LBL_I_WANT_TO_SELL", $siteLangId); ?>
            <a href="javascript:void(0);" onclick="gotoPage('Seller'); document.getElementById('closePopup').checked = true;" style="position:absolute; inset:0;"></a>
        </div>
    </div>

    <label for="closePopup" class="firstVisitCloseBtn firstVisitAction">
        <?php echo Labels::getLabel("LBL_CLOSE", $siteLangId); ?>
    </label>

</div>


</div>
