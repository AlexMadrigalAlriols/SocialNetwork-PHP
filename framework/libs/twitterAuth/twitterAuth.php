<?php
require_once('cards/assets/vendor/twitter-login-php/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter_Client {
    private $oauth_token;
    private $oauth_token_secret;
    private $twitter_access_token;

    public function __construct() {
        $connection = new TwitterOAuth( gc::getSetting("twitter.clientId"), gc::getSetting("twitter.clientSecret") );
        $request_token = $connection->oauth( 'oauth/request_token', array( 'oauth_callback' => gc::getSetting("site.url") . '/login' ) );

        $this->oauth_token = $request_token['oauth_token'];
        $this->oauth_token_secret = $request_token['oauth_token_secret'];
    }

    public function getLogin($oauth_token, $oauth_verifier) {
        $connection = new TwitterOAuth(gc::getSetting("twitter.clientId"), gc::getSetting("twitter.clientSecret"), $this->oauth_token, $this->oauth_token_secret);
		$access_token = $connection->oauth( "oauth/access_token", array( "oauth_token" => $oauth_token, "oauth_verifier" => $oauth_verifier ) );

        if($access_token) {
            $this->twitter_access_token = $access_token;
        
            $connection = new TwitterOAuth(gc::getSetting("twitter.clientId"), gc::getSetting("twitter.clientSecret"), $this->twitter_access_token["oauth_token"], $this->twitter_access_token["oauth_token_secret"] );
    
            $user = $connection->get( "account/verify_credentials", ['include_email' => 'true'] );
    
            return $user;
        }

        return false;
    }

    public function getUrl() {
        // connect to twitter with our app creds
        $connection = new TwitterOAuth( gc::getSetting("twitter.clientId"), gc::getSetting("twitter.clientSecret") );

        // get a request token from twitter
        $request_token = $connection->oauth( 'oauth/request_token', array( 'oauth_callback' => gc::getSetting("site.url") . '/login' ) );
            
        return $connection->url( 'oauth/authorize', array( 'oauth_token' => $request_token['oauth_token'] ) );
    }
}

?>