<?php

class Discord_Client {
    private $access_token;

    private $client_id;
    private $client_secret;
    private $redirect_url;
    private $scope;

    public function __construct($client_id, $client_secret, $redirect_url, $scope) {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_url = $redirect_url;
        $this->scope = $scope;
    }

    # A function to generate oAuth2 URL for logging in
    public function url()
    {
        $state = $this->gen_state();
        return 'https://discordapp.com/oauth2/authorize?response_type=code&client_id=' . $this->client_id . '&redirect_uri=' . $this->redirect_url . '&scope=' . $this->scope . "&state=" . $state;
    }
    
    # A function to initialize and store access token in SESSION to be used for other requests
    public function init($code, $state)
    {
        # Check if $state == $_SESSION['state'] to verify if the login is legit | CHECK THE FUNCTION get_state($state) FOR MORE INFORMATION.
        $url = "https://discord.com/api/oauth2/token";
        $data = array(
            "client_id" =>  $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type" => "authorization_code",
            "code" => $code,
            "redirect_uri" => $this->redirect_url
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $results = json_decode($response, true);

        $this->access_token = (isset($results['access_token']) ? $results['access_token'] : false);

        return $this->access_token;
    }
    
    # A function to get user information | (identify scope)
    public function get_user()
    {
        $url = "https://discord.com/api/users/@me";
        $headers = array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $this->access_token);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        $results = json_decode($response, true);
    
        return $results;
    }   
    
    public function gen_state()
    {
        $state = bin2hex(openssl_random_pseudo_bytes(12));

        return $state;
    }

    public static function is_animated($avatar)
    {
        $ext = substr($avatar, 0, 2);
        if ($ext == "a_")
        {
            return ".gif";
        }
        else
        {
            return ".png";
        }
    }
    
}