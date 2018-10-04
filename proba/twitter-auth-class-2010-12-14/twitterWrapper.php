<?php
    session_start();
    /* ****** ****** ****** ****** ****** ******
    *
    * Author       :   Shafiul Azam
    *              :   ishafiul@gmail.com
    *              :   Core Developer
    * Page         :
    * Description  :
    * Last Updated :
    *
    * ****** ****** ****** ****** ****** ******/

    require_once 'EpiCurl.php';
    require_once 'EpiOAuth.php';
    require_once 'EpiTwitter.php';
    require_once 'html.php';

    define('SESS_IDENT','shafiul12');


    

    class twitterWrapper {
        //put your code here
        public $consumer_key = ''; // get from http://dev.twitter.com
        public $consumer_secret = ''; // get from http://dev.twitter.com
        public $twitterObj = null;
        public $token = null;
        public $twitterInfo = null;

        public function init(){
            $this->twitterObj = new EpiTwitter($this->consumer_key, $this->consumer_secret);

            $this->twitterObj->setToken($_GET['oauth_token']);
            $this->token = $this->twitterObj->getAccessToken();
            $this->twitterObj->setToken($this->token->oauth_token, $this->token->oauth_token_secret);
            $this->twitterInfo= $this->twitterObj->get_accountVerify_credentials();
            $this->twitterInfo->response;
        }

        public function isLoggedIn(){
            if(isset ($_SESSION[SESS_IDENT]))
                return true;
            else
                return false;
        }

        public function authenticate(){
            // This functions sets session data, so i think should be called before headers are sent
            if($this->isLoggedIn()){
                // just continue...
                return $_SESSION[SESS_IDENT];
            }else{
                // not logged in, return login link
                $this->init();
                if($this->twitterInfo->screen_name){
                    // set session data, and then continue
                    $_SESSION[SESS_IDENT] = $this->twitterInfo->screen_name;
                    return $_SESSION[SESS_IDENT];
                }else{
                    // generate a page giving link to authorize. then die
                    html_head("Authentication required!","","",true);
                    echo '<div align = "center">';
                    echo '<h1 style = "color:red;">Please authenticate yourself using your Twitter Account!</h1>';
                    echo '<br />';
                    echo '<a href="' . $this->twitterObj->getAuthorizationUrl() . '">Authorize with Twitter</a>';
                    echo '</div>';
                    html_foot();
                    exit();
                }
            }
        }

        public function getIdentifier(){
            return $_SESSION[SESS_IDENT];
        }
    }
?>
