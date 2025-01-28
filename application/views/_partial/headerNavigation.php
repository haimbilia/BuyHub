<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$isMegaMenuEnabled = FatApp::getConfig('CONF_LAYOUT_MEGA_MENU', FatUtility::VAR_INT, 1);
if ($headerNavigation || $isMegaMenuEnabled) {
    $getOrgUrl = (CONF_DEVELOPMENT_MODE) ? true : false;

    if (count($headerNavigation)) {
        $noOfCharAllowedInNav = 75;
        $rightNavCharCount = 10;
        if (!UserAuthentication::isUserLogged()) {
            $rightNavCharCount = $rightNavCharCount + mb_strlen(html_entity_decode(Labels::getLabel('LBL_Sign_In', $siteLangId), ENT_QUOTES, 'UTF-8'));
        } else {
            $rightNavCharCount = $rightNavCharCount + mb_strlen(html_entity_decode(Labels::getLabel('LBL_Hi,', $siteLangId) . ' ' . $userName, ENT_QUOTES, 'UTF-8'));
        }
        $rightNavCharCount = $rightNavCharCount + mb_strlen(html_entity_decode(Labels::getLabel("LBL_Cart", $siteLangId), ENT_QUOTES, 'UTF-8'));
        $noOfCharAllowedInNav = $noOfCharAllowedInNav - $rightNavCharCount;

        $navLinkCount = 0;
        foreach ($headerNavigation as $nav) {
            if (!$nav['pages']) {
                break;
            }
            foreach ($nav['pages'] as $link) {
                $noOfCharAllowedInNav = $noOfCharAllowedInNav - mb_strlen(html_entity_decode($link['nlink_caption'], ENT_QUOTES, 'UTF-8'));
                if ($noOfCharAllowedInNav < 0) {
                    break;
                }
                $navLinkCount++;
            }
        }
    }
    
    if ($layoutType == applicationConstants::SCREEN_DESKTOP) {
        require('desktop-nav.php');
    }

    if ($layoutType == applicationConstants::SCREEN_MOBILE) {
        require_once('navigation/mobile-nav.php');
    }
}
