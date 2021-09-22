<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';

class FatMailer extends FatModel
{

    const DB_TBL = 'tbl_email_templates';
    const DB_TBL_ARCHIVE = 'tbl_email_archives';
    const PRIORITY_TYPE_IMMEDIATE = 5;

    private $toEmail = '';
    private $toName = '';
    private $fromEmail = '';
    private $fromName = '';
    private $ccArr = [];
    private $bccArr = [];
    private $replyToArr = [];
    private $variables = [];
    private $attachments = [];
    private $archiveId = 0;
    private $langId = 0;
    private $template = '';
    private $priority = null;
    private $smtpArr = [];
    private $forceSmtp = false; //testing with smtp only

    /**
     * Initialize Mailer
     * 
     * @param string $template
     * @param int $langId
     */
    public function __construct(int $langId, string $template)
    {
        $this->langId = $langId;
        $this->template = $template;
    }

    public function setFrom(string $email, string $name = ''): object
    {
        $this->addAnAddress('from', $email, $name);
        return $this;
    }

    public function setReplyTo(string $email, string $name = ''): object
    {
        $this->addAnAddress('replyTo', $email, $name);
        return $this;
    }

    public function addCc(string $email, string $name = ''): object
    {
        $this->addAnAddress('cc', $email, $name);
        return $this;
    }

    public function addBcc(string $email, string $name = ''): object
    {
        $this->addAnAddress('bcc', $email, $name);
        return $this;
    }

    public function setTo(string $email, string $name = ''): object
    {
        $this->addAnAddress('to', $email, $name);
        return $this;
    }

    public function setVariables(array $variables): object
    {
        $this->variables = $variables;
        return $this;
    }

    /**
     * @param string $path Path to the attachment.
     * @param string $name attachment name.
     * 
     */
    public function addAttachment($path, $name): object
    {
        array_push($this->attachments, ['path' => $path, 'name' => $name]);
        return $this;
    }

    /**
     * 
     * @param int $priority higher priority email will go first [range 0 - 5]
     * 5 means immediate  
     */
    public function setPriority(int $priority): object
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * 
     * @param type $smtpArr
     *  $smtpArr = ["host" => '',"port" =>'' ,"username" => '', "password" =>'' , "secure" => '' ];
     */
    public function setSmtpDetails(array $smtpArr): object
    {
        $this->smtpArr = $smtpArr;
        $this->forceSmtp();
        return $this;
    }

    public function forceSmtp(): object
    {
        $this->forceSmtp = true;
        return $this;
    }

    public function send(): bool
    {
        if (empty($this->toEmail)) {
            $this->error = Labels::getLabel('ERR_TO_EMAIL_ADDRESS_IS_REQUIRED!', $this->langId);
            return false;
        }
        $row = $this->getTemplate();
        if ($row == null) {
            $this->error = Labels::getLabel('ERR_EMAIL_TEMPLATE_NOT_FOUND!', $this->langId);
            return false;
        }

        if (empty($this->fromEmail)) {
            $this->fromEmail = FatApp::getConfig("CONF_FROM_EMAIL");
            $this->fromName = FatApp::getConfig('CONF_FROM_NAME_' . $this->langId, FatUtility::VAR_STRING, '');
        }

        $etpl = new FatTemplate('', '');
        $etpl->set('langId', $row['etpl_lang_id']);
        $header = $etpl->render(false, false, '_partial/emails/email-header.php', true);
        /* */
        $ftpl = new FatTemplate('', '');
        $ftpl->set('langId', $row['etpl_lang_id']);
        $footer = $ftpl->render(false, false, '_partial/emails/email-footer.php', true);
        $body = $header . $row['etpl_body'] . $footer;
        $this->variables += $this->commonVars($row['etpl_lang_id']);

        $body = $this->replaceVariables($body);
        $subject = $this->replaceVariables($row['etpl_subject']);

        if ($row['etpl_status'] != applicationConstants::ACTIVE) {
            SystemLog::system('Email template is not active - ' . $row['etpl_code'], 'Email Template');
            return true;
        }

        if (!$this->addToArchive($subject, $body, $row['etpl_priority'])) {
            return false;
        }

        if (empty($body)) {
            SystemLog::system('Email template body is empty - ' . $row['etpl_code'], 'Email Template');
            return false;
        }

        if (!ALLOW_EMAILS) {
            return true;
        }

        if (!$this->forceSmtp) {
            if ($row['etpl_priority'] != self::PRIORITY_TYPE_IMMEDIATE) {
                return true;
            }

            if (FatApp::getConfig('CONF_SEND_EMAIL') == applicationConstants::NO) {
                return true;
            }
        }

        if (!$this->sendByPhpMailer($subject, $body)) {
            return false;
        }
        $this->markArchiveSent();
        return true;
    }

    public static function sendArchivedEmails(): bool
    {
        if (FatApp::getConfig('CONF_SEND_EMAIL') == applicationConstants::NO || !ALLOW_EMAILS) {
            return 'Email is disabled';
        }

        $srch = new SearchBase(self::DB_TBL_ARCHIVE);
        $srch->addCondition('earch_sent_on', 'is', 'mysql_func_null', 'and', true);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(50);
        $srch->addOrder('earch_priority', 'DESC');
        $srch->addOrder('earch_added', 'ASC');
        $archives = FatApp::getDb()->fetchAll($srch->getResultSet());
        $fatMailerObj = new self(1, '');
        foreach ($archives as $archive) {
            $fatMailerObj->toEmail = $archive['earch_to_email'];
            $fatMailerObj->toName = $archive['earch_to_name'];
            $fatMailerObj->fromEmail = $archive['earch_from_email'];
            $fatMailerObj->fromName = $archive['earch_from_name'];
            $fatMailerObj->ccArr = $archive['earch_cc_email'] ? json_decode($archive['earch_cc_email'], true) : [];
            $fatMailerObj->bccArr = $archive['earch_bcc_email'] ? json_decode($archive['earch_bcc_email'], true) : [];
            $fatMailerObj->attachments = $archive['earch_attachments'] ? json_decode($archive['earch_attachments'], true) : [];
            if ($fatMailerObj->sendByPhpMailer($archive['earch_subject'], $archive['earch_body'])) {
                $fatMailerObj->archiveId = $archive['earch_id'];
                $fatMailerObj->markArchiveSent();
            }
        }
        return true;
    }

    private function sendByPhpMailer(string $subject, string $body): bool
    {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = false;
        if (FatApp::getConfig('CONF_SEND_SMTP_EMAIL') || $this->forceSmtp) {
            $mail->IsSMTP();
            $mail->Host = $this->smtpArr['host'] ?? FatApp::getConfig("CONF_SMTP_HOST");
            $mail->SMTPAuth = (strtolower($mail->Host) == 'localhost') ? false : true;
            $mail->Port = $this->smtpArr['port'] ?? FatApp::getConfig("CONF_SMTP_PORT");
            $mail->Username = $this->smtpArr['username'] ?? FatApp::getConfig("CONF_SMTP_USERNAME");
            $mail->Password = $this->smtpArr['password'] ?? FatApp::getConfig("CONF_SMTP_PASSWORD");
            $mail->SMTPSecure = $this->smtpArr['secure'] ?? ((strtolower($mail->Host) == 'localhost') ? 'none' : FatApp::getConfig("CONF_SMTP_SECURE"));
        } else {
            $mail->isMail();
        }

        if ($this->forceSmtp) {
            $mail->Timeout = 30;
        }

        $mail->IsHTML();
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($this->fromEmail, $this->fromName);
        if (!empty($this->replyToArr) && isset($this->replyToArr['email'])) {
            $mail->addReplyTo($this->replyToArr['email'], $this->replyToArr['name']);
        }
        $mail->addAddress($this->toEmail, $this->toName);
        foreach ($this->ccArr as $cc) {
            $mail->addCC($cc['email'], $cc['name']);
        }
        foreach ($this->bccArr as $bcc) {
            $mail->addBCC($bcc['email'], $bcc['name']);
        }
        foreach ($this->attachments as $attachment) {
            $mail->addAttachment($attachment['path'], $attachment['name']);
        }
        $mail->msgHTML($body);
        $mail->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        try {
            $mail->send();
        } catch (Exception $e) {
            $this->error = $mail->ErrorInfo;
            return false;
        }
        return true;
    }

    private function addAnAddress(string $type, string $email, string $name): void
    {
        if (false == filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }
        switch ($type) {
            case 'to':
                $this->toEmail = $email;
                $this->toName = $name;
                break;
            case 'from':
                $this->fromEmail = $email;
                $this->fromName = $name;
                break;
            case 'replyTo':
                $this->replyToArr = ['email' => $email, 'name' => $name];
                break;
            case 'cc':
                array_push($this->ccArr, ['email' => $email, 'name' => $name]);
                break;
            case 'bcc':
                array_push($this->ccArr, ['email' => $email, 'name' => $name]);
                break;

            default:
                break;
        }
    }

    private function getTemplate(): array
    {
        $row = $this->getMailTpl($this->langId);
        if (!$row) {
            $row = $this->getMailTpl(FatApp::getConfig('conf_default_site_lang'));
        }
        return $row;
    }

    private function getMailTpl($langId): array
    {
        $srch = new SearchBase(self::DB_TBL);
        $srch->addCondition('etpl_code', '=', $this->template);
        $srch->addCondition('etpl_lang_id', '=', $langId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return (array) FatApp::getDb()->fetch($srch->getResultSet());
    }

    /**
     * Add to archives
     *
     * @param string $subject
     * @param string $body
     * @return bool
     */
    private function addToArchive(string $subject, string $body, int $priority): bool
    {
        $archiveRecord = [
            'earch_to_email' => $this->toEmail,
            'earch_to_name' => $this->toName,
            'earch_from_email' => $this->fromEmail,
            'earch_from_name' => $this->fromName,
            'earch_cc_email' => json_encode($this->ccArr),
            'earch_bcc_email' => json_encode($this->ccArr),
            'earch_tpl_name' => $this->template,
            'earch_subject' => $subject,
            'earch_body' => $body,
            'earch_attachments' => json_encode($this->attachments),
            'earch_added' => date('Y-m-d H:i:s'),
            'earch_priority' => $this->priority ?? $priority,
        ];

        $record = new TableRecord(static::DB_TBL_ARCHIVE);
        $record->assignValues($archiveRecord);
        if (!$record->addNew()) {
            $this->error = $record->getError();
            return false;
        }
        $this->archiveId = $record->getId();
        return true;
    }

    /**
     * Mark archived email sent
     *
     * @return bool
     */
    private function markArchiveSent(): bool
    {
        $record = new TableRecord(static::DB_TBL_ARCHIVE);
        $record->setFldValue('earch_sent_on', date('Y-m-d H:i:s'));
        $where = ['smt' => 'earch_id = ?', 'vals' => [$this->archiveId]];
        if (!$record->update($where)) {
            $this->error = $record->getError();
            return false;
        }
        return true;
    }

    /**
     * Replace template variables
     *
     * @param string $string
     * @return string
     */
    private function replaceVariables(string $string): string
    {
        return CommonHelper::replaceStringData($string, $this->variables);
    }

    private static function replaceDomain(array $emailIds): array
    {
        $emails = array_unique(array_filter($emailIds));
        $liveDomians = ['yourlive.domain.com'];
        if (in_array($_SERVER['SERVER_NAME'], $liveDomians)) {
            return $emails;
        }
        foreach ($emails as $key => $email) {
            $domain = substr($email, strpos($email, '@') + 1);
            $emails[$key] = str_replace($domain, 'dummyid.com', $email);
        }
        return array_unique($emails);
    }

    private function commonVars($langId): array
    {
        $srch = SocialPlatform::getSearchObject($langId);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('splatform_user_id', '=', 0);
        $rs = $srch->getResultSet();
        $rows = FatApp::getDb()->fetchAll($rs);

        $social_media_icons = '';
        $imgSrc = '';
        foreach ($rows as $row) {
            $img = AttachedFile::getAttachment(AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE, $row['splatform_id']);
            $title = ($row['splatform_title'] != '') ? $row['splatform_title'] : $row['splatform_identifier'];
            $target_blank = ($row['splatform_url'] != '') ? 'target="_blank"' : '';
            $url = $row['splatform_url'] != '' ? $row['splatform_url'] : 'javascript:void(0)';

            if (!empty($img)) {
                $uploadedTime = AttachedFile::setTimeParam($img['afile_updated_at']);
                $imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'SocialPlatform', array($row['splatform_id']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            } elseif ($row['splatform_icon_class'] != '') {
                $imgSrc = UrlHelper::generateFullUrl('', '', array(), CONF_WEBROOT_FRONT_URL) . 'images/' . $row['splatform_icon_class'] . '.png';
            }
            $social_media_icons .= '<a style="display:inline-block;vertical-align:top; width:26px;height:26px; margin:0 0 0 5px; background:rgba(255,255,255,0.2); border-radius:100%;padding:4px;" href="' . $url . '" ' . $target_blank . ' title="' . $title . '" ><img alt="' . $title . '" width="24" style="margin:1px auto 0; display:block;" src = "' . $imgSrc . '"/></a>';
        }


        $fileRow = AttachedFile::getAttachment(AttachedFile::FILETYPE_EMAIL_LOGO, 0, 0, $langId);
        $uploadedTime = AttachedFile::setTimeParam($fileRow['afile_updated_at']);

        return array(
            '{website_name}' => FatApp::getConfig('CONF_WEBSITE_NAME_' . $langId),
            '{website_url}' => UrlHelper::generateFullUrl('', '', array(), CONF_WEBROOT_FRONT_URL),
            '{Company_Logo}' => '<img style="max-width:100%" src="' . UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'emailLogo', array($langId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '" />',
            '{current_date}' => date('M d, Y'),
            '{social_media_icons}' => $social_media_icons,
            '{contact_us_url}' => UrlHelper::generateFullUrl('custom', 'contactUs', array(), CONF_WEBROOT_FRONT_URL),
        );
    }

}
