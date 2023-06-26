<?php require_once 'autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter extends PluginBase
{
    private $oAuth;
    private $response;
    private const REQUEST_AUTH_URL = 1;
    private const REQUEST_TWEET = 2;

    /**
     * __construct
     *
     * @param  int $langId
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = FatUtility::int($langId);
        if (1 > $this->langId) {
            $this->langId = CommonHelper::getLangId();
        }
    }

    /**
     * getAuthUrl
     *
     * @return string
     */
    public function getAuthUrl(): string
    {
        return (string) $this->doRequest(self::REQUEST_AUTH_URL);
    }

    /**
     * postTweet
     *
     * @param  string $oAuthVerifier
     * @param  string $imagePath
     * @param  array $extraParams
     * @return bool
     */
    public function postTweet(string $oAuthVerifier, string $imagePath, array $extraParams = []): bool
    {
        if (!empty($imagePath) && filesize($imagePath) > (5 * 1000000)) { /*Max 5mb size image can be uploaded by Twitter*/
            $this->error = Labels::getLabel('ERR_FILE_SIZE_SHOULD_NOT_BE_GREATER_THAN_5MB', $this->langId);
            return false;
        }

        if (false === $this->doRequest(self::REQUEST_TWEET, [
            'oauth_verifier' => $oAuthVerifier,
            'imagePath' => $imagePath,
            'params' => $extraParams,
        ])) {
            return false;
        }
        return true;
    }

    /**
     * getResponse
     *
     * @return array|object
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * init
     *
     * @return void
     */
    private function init(): void
    {
        $this->oAuth = new TwitterOAuth(FatApp::getConfig("CONF_TWITTER_API_KEY", FatUtility::VAR_STRING, ''), FatApp::getConfig("CONF_TWITTER_API_SECRET", FatUtility::VAR_STRING, ''));
        $this->oAuth->setDecodeJsonAsArray(true);
    }

    /**
     * getCallbackUrl
     *
     * @return string
     */
    private function getCallbackUrl(): string
    {
        return UrlHelper::generateFullUrl('Affiliate', 'twitterCallback', [], '', false);
    }

    /**
     * tweet
     *
     * @param  string $oAuthVerifier
     * @param  string $imagePath
     * @param  array $params
     * @return bool
     */
    private function tweet(string $oAuthVerifier, string $imagePath, array $params = []): bool
    {
        /* Request With Old Tokens. */
        $this->oAuth->setOauthToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        $access_token = $this->oAuth->oauth("oauth/access_token", ["oauth_verifier" => $oAuthVerifier]);

        /* Request With Fresh Tokens.  */
        $this->oAuth->setOauthToken($access_token['oauth_token'], $access_token['oauth_token_secret']);
        $this->oAuth->setTimeouts(60, 30);
        if (!empty($imagePath)) {
            $result = $this->oAuth->upload('media/upload', array('media' => $imagePath));
            if ($this->oAuth->getLastHttpCode() == 200) {
                $params['media_ids'] = $result->media_id_string;
            }
        }
        $this->oAuth->setApiVersion('2');
        $this->response = $this->oAuth->post('tweets', $params, false);
        if ($this->oAuth->getLastHttpCode() == 200) {
            return true;
        }

        $this->error = json_encode($this->oAuth->getLastBody());
        return false;
    }

    /**
     * doRequest
     *
     * @param  mixed $requestType
     * @return mixed
     */
    private function doRequest(int $requestType, array $requestParam = [])
    {
        $err = Labels::getLabel('ERR_UNABLE_TO_CONNECT', $this->langId);
        try {
            $this->init();
            switch ($requestType) {
                case self::REQUEST_AUTH_URL:
                    $request_token = $this->oAuth->oauth('oauth/request_token', array('oauth_callback' => $this->getCallbackUrl()));
                    $_SESSION['oauth_token'] = $request_token['oauth_token'];
                    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
                    return $this->oAuth->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
                    break;
                case self::REQUEST_TWEET:
                    return $this->tweet($requestParam['oauth_verifier'], $requestParam['imagePath'], $requestParam['params']);
                    break;
            }
        } catch (\UnexpectedValueException $e) {
            // Display a very generic error to the user, and maybe send
            $this->error = !empty($e->getMessage()) ? $e->getMessage() : $err;
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $this->error = !empty($e->getMessage()) ? $e->getMessage() : $err;
        } catch (Error $e) {
            // Handle error
            $this->error = !empty($e->getMessage()) ? $e->getMessage() : $err;
        }
        return false;
    }
}
