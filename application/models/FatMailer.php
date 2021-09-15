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
    private $smtpObj = null;

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

    public function setFrom(string $email, string $name = '')
    {
        $this->addAnAddress('from', $email, $name);
    }

    public function setReplyTo(string $email, string $name = '')
    {
        $this->addAnAddress('replyTo', $email, $name);
    }

    public function addCc(string $email, string $name = '')
    {
        $this->addAnAddress('cc', $email, $name);
    }

    public function addBcc(string $email, string $name = '')
    {
        $this->addAnAddress('bcc', $email, $name);
    }

    public function setTo(string $email, string $name = '')
    
    {
        
        $this->addAnAddress('to', $email, $name);
    }

    public function setVariables(array $variables)
    {
        $this->variables = $variables;
    }

    /**
     * @param string $path Path to the attachment.
     * @param string $name attachment name.
     * 
     */
    public function addAttachment($path, $name)
    {
        array_push($this->attachments, ['path' => $path, 'name' => $name]);
    }

    /**
     * 
     * @param int $priority higher priority email will go first [range 0 - 5]
     * 5 means immediate  
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;
    }

    /**
     * 
     * @param type $smtpArr
     *  $smtp_arr = ["host" => '',"port" =>'' ,"username" => '', "password" =>'' , "secure" => '' ];
     */
    public function setSmtpDetails(SmtpModel $smtpobj)
    {
        $this->smtpObj = $smtpobj;
    }

    private function addAnAddress(string $type, string $email, string $name)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }        
        switch ($type) {          
             case 'to':            
                $this->toEmail = $email;
                $this->toName = $name;
                echo $this->toEmail;
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

    public function send(): bool
    {      
        
        if (!empty($this->toEmail)) { 
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
        $subject = $row['etpl_subject'];
        $body = $header . $row['etpl_body'] . $footer;
        $this->variables += static::commonVars($row['etpl_lang_id']);

        $body = $this->replaceVariables($row['etpl_body']);
        $subject = $this->replaceVariables($row['etpl_subject']);     
        if (!$this->addToArchive($subject, $body, $row['etpl_priority'])) {
            return false;
        }   

        if ($row['etpl_status'] != applicationConstants::ACTIVE || !empty($body)) {
            return false;
        }

        if ($row['etpl_priority'] != self::PRIORITY_TYPE_IMMEDIATE) {
            return true;
        }
        if (FatApp::getConfig('CONF_SEND_EMAIL') == applicationConstants::NO || !ALLOW_EMAILS) {
            return true;
        }
        if (!$this->sendByPhpMailer($subject, $body)) {
            return false;
        }
        $this->markArchiveSent();
        return true;
    }

    private function sendByPhpMailer(string $subject, string $body): bool
    {
        $mail = new PHPMailer();
        $mail->SMTPDebug = false;
        if (FatApp::getConfig('CONF_SEND_SMTP_EMAIL')) {
            $mail->IsSMTP();
            $mail->Host = $this->smtpObj->host ?? FatApp::getConfig("CONF_SMTP_HOST");
            $mail->SMTPAuth = (strtolower($mail->Host) == 'localhost') ? false : true;
            $mail->Port = $this->smtpObj->port ?? FatApp::getConfig("CONF_SMTP_PORT");
            $mail->Username = $this->smtpObj->username ?? FatApp::getConfig("CONF_SMTP_USERNAME");
            $mail->Password = $this->smtpObj->password ?? FatApp::getConfig("CONF_SMTP_PASSWORD");
            $mail->SMTPSecure = $this->smtpObj->secure ?? ((strtolower($mail->Host) == 'localhost') ? 'none' : FatApp::getConfig("CONF_SMTP_SECURE"));
        } else {
            $mail->isMail();
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
            if (!$mail->send()) {
                $this->error = $mail->ErrorInfo;
                return false;
            }
        } catch (phpmailerException $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    private function getTemplate()
    {
        $row = $this->getMailTpl($this->langId);
        if (!$row) {
            $row = $this->getMailTpl(FatApp::getConfig('conf_default_site_lang'));
        }
        return $row;
    }

    private function getMailTpl($langId)
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
            'earch_bcc_email' => json_encode($this->bccArr),
            'earch_tpl_name' => $this->template,
            'earch_subject' => $subject,
            'earch_body' => $body,
            'earch_attachments' => json_encode($this->attachments),
            'earch_added' => date('Y-m-d H:i:s'),
            'earch_priority' => $this->priority ?? $priority,
        ];   
        
        print_r($archiveRecord);
        
        die();
        $record = new TableRecord(static::DB_TBL_ARCHIVE);
        $record->assignValues($archiveRecord);
        if (!$record->addNew()) {
            echo $this->error = $record->getError();
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

    public static function sendArchivedEmail()
    {
        if (FatApp::getConfig('CONF_SEND_EMAIL') == applicationConstants::NO || !ALLOW_EMAILS) {
            return 'Email is disabled';
        }

        $srch = new SearchBase(self::DB_TBL_ARCHIVE);
        $srch->addCondition('earch_sent_on', '=', 'mysql_func_null', true);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(50);
        $srch->addOrder('earch_priority DESC');
        $archives = FatApp::getDb()->fetchAll($srch->getResultSet());
        $fatMailerObj = new self(1, '');
        foreach ($archives as $archive) {
            $fatMailerObj->toEmail = $archive['earch_to_email'];
            $fatMailerObj->toName = $archive['earch_to_name'];
            $fatMailerObj->fromEmail = $archive['earch_from_email'];
            $fatMailerObj->fromName = $archive['earch_from_name'];
            $fatMailerObj->ccArr = json_decode($archive['earch_cc_email'], true);
            $fatMailerObj->bccArr = json_decode($archive['earch_bcc_email'], true);
            $fatMailerObj->attachments = json_decode($archive['earch_attachments'], true);
            if ($this->sendByPhpMailer($archive['earch_subject'], $archive['earch_body'])) {
                $this->archiveId = $archive['earch_id'];
                $this->markArchiveSent();
            }
        }
        return true;
    }

    private static function commonVars($langId)
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

class SmtpModel
{    
    
    public $username;
    public $password;
    public $host;

    /**
     * @var port int.
     */
    public $port;    

    /**
     * @var secure int.
     */
    public $secure;

}
