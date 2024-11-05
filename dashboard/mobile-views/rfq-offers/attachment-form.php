<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$messages = [];
foreach ($messagesData as $row) {
    $attachmentLink = '';
    if (0 < $row['afile_id']) {
        $attachmentLink = UrlHelper::generateFullUrl('RfqOffers', 'downloadAttachmentFile', array($row['rom_id'], $row['rom_primary_offer_id']));
    }
    $messages[] = [
        'rom_id' => $row['rom_id'],
        'rom_user_type' => $row['rom_user_type'],
        'rom_buyer_access' => $row['rom_buyer_access'],
        'rom_primary_offer_id' => $row['rom_primary_offer_id'],
        'rom_added_on' => FatDate::format($row['rom_added_on'], true),
        'rom_message' => preg_replace("/\r\n|\r|\n/", '<br/>', $row['rom_message']),
        'afile_name' => $row['afile_name'],
        'attachmentLink' => $attachmentLink,
    ];
}

$data['page'] = $page ?? 1;
$data['pageCount'] = $pageCount;
$data['messages'] = $messages;

if (empty($messages)) {
    $status = applicationConstants::OFF;
}
