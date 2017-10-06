<?php

require 'config.php';

class IspconfigSoapclient
{
    /**
     * holds data received from POST
     * @var $inputData array
     */
    private $inputData = [];

    /**
     * @var $soapClient SoapClient
     */
    private $soapClient;

    /**
     * @var $sessionId string
     */
    private $sessionId;

    /**
     * @var $clientId string
     */
    private $clientId;

    public function __construct()
    {
        error_reporting(E_ALL);
        ini_set( "display_errors", 1);

        try{
            $this->soapClient = new SoapClient(
                null,
                array(
                    'location' => SOAP_LOCATION,
                    'uri'      => SOAP_URI,
                    'trace' => 1,
                    'exceptions' => 1,
                    'stream_context'=> stream_context_create(
                        array(
                            'ssl'=> array(
                                'verify_peer'=>false,
                                'verify_peer_name'=>false
                            )
                        )
                    )
                )
            );
        }
        catch ( SoapFault $exception ){
            echo $exception->getMessage();
        }
        catch ( Exception $exception ){
            echo $exception->getMessage();
        }
    }

    /**
     * try to login using username and password
     * @return boolean
     */
    public function login(){
        try{
            $this->sessionId = $this->soapClient->login(SOAP_USERNAME, SOAP_PASSWORD);
        }
        catch ( Exception $exception ){
            echo $exception->getMessage();
        }

        if( !$this->sessionId ){
            return false;
        }
        return true;
    }

    /**
     * save data from an array to a class attribute
     * @param $postArray array
     * @throws Exception
     * @return void
     */
    public function setInputData( $postArray ){
        if( !is_array( $postArray ) ){
            throw new Exception("Supplied parameter needs to be an array");
        }
        $this->inputData = $postArray;
    }

    /**
     * add a client, data comes from the inputData attribute
     * @throws Exception
     * @return mixed
     */
    public function addClient(){

        $inputData = $this->inputData;

        $paramsClientAdd = [
            'company_name' => $inputData['company_name'],
            'contact_name' => $inputData['name'] . ' ' . $inputData['surname'],
            'customer_no' => '', # fix - just blank for the moment
            'vat_id' => '',
            'street' => $inputData['street'] . ' ' . $inputData['number'],
            'zip' => $inputData['psc'],
            'city' => $inputData['town'],
            'state' => $inputData['state'],
            'country' => $inputData['state'],
            'telephone' => $inputData['telephone'],
            'mobile' => $inputData['telephone'],
            'fax' => '',
            'email' => $inputData['email'],
            'internet' => '',
            'icq' => '',
            'notes' => '',
            'default_mailserver' => 1,
            'limit_maildomain' => 1,
            'limit_mailbox' => 5,
            'limit_mailalias' => 1,
            'limit_mailaliasdomain' => 1,
            'limit_mailforward' => 1,
            'limit_mailcatchall' => 1,
            'limit_mailrouting' => 0,
            'limit_mailfilter' => 5,
            'limit_fetchmail' => -1,
            'limit_mailquota' => 500,
            'limit_spamfilter_wblist' => 0,
            'limit_spamfilter_user' => 0,
            'limit_spamfilter_policy' => 1,
            'default_webserver' => 1,
            'limit_web_ip' => '',
            'limit_web_domain' => 1,
            'limit_web_quota' => 1000,
            'web_php_options' => 'no,fast-cgi,cgi,mod,suphp,php-fpm',
            'limit_web_subdomain' => 1,
            'limit_web_aliasdomain' => 1,
            'limit_ftp_user' => 2,
            'limit_shell_user' => 0,
            'ssh_chroot' => 'no,jailkit,ssh-chroot',
            'limit_webdav_user' => 0,
            'default_dnsserver' => 1,
            'limit_dns_zone' => 0,
            'limit_dns_slave_zone' => 0,
            'limit_dns_record' => 0,
            'default_dbserver' => 1,
            'limit_database' => 1,
            'limit_cron' => 0,
            'limit_cron_type' => 'url',
            'limit_cron_frequency' => 5,
            'limit_traffic_quota' => 1000,
            'limit_client' => 0, // If this value is > 0, then the client is a reseller
            'parent_client_id' => 0,
            'username' => $inputData['username'],
            'password' => $inputData['password'],
            'language' => 'en',
            'usertheme' => 'default',
            'template_master' => 0,
            'template_additional' => '',
            #'created_at' => 0
            'added_date' => date("Y-m-d")
        ];

        if( !$this->sessionId ){
            throw new Exception( "SoapClient login() method did not return a valid ID. Session ID is not set." );
        }

        try{
            $this->clientId = $this->soapClient->client_add($this->sessionId, 0, $paramsClientAdd);
            return true;
        }
        catch ( SoapFault $exception ){
            return $exception->getMessage();
        }

    }

    /**
     * adds a mail user
     * @throws Exception
     * @return mixed
     */
    public function addMailUser(){

        $inputData = $this->inputData;

        $paramsMailUserAdd = [
            'server_id' => 1,
            'email' => $inputData['username'] . '@' . 'localdomain.local',
            'login' => $inputData['username'] . '@' . 'localdomain.local',
            'password' => $inputData['password'],
            'name' => $inputData['username'],
            'uid' => 5000, #fix
            'gid' => 5000, #fix
            'maildir' => '/var/vmail/' . 'localdomain.local' . '/' . $inputData['username'],
            'quota' => '500000000', # 500 ends up into - 0.00047683715820312 ; its a bigint(20)
            'cc' => '',
            'homedir' => '/var/vmail',
            'autoresponder' => 'n',
            'autoresponder_start_date' => '0000-00-00 00:00:00',
            'autoresponder_end_date' => '2050-01-01 00:00:00',
            'move_junk' => 'n',
            'postfix' => 'y',
            'access' => 'y',
            'disableimap' => 'n',
            'disablepop3' => 'n',
            'disabledeliver' => 'n',
            'disablesmtp' => 'n'
        ];

        if( !$this->sessionId ){
            throw new Exception( 'Session ID is not set. SoapClient login() method should return it.' );
        }

        if( !$this->clientId ){
            throw new Exception( 'Client ID is not set. SoapClient client_add() method should return it.' );
        }

        try{
            $this->soapClient->mail_user_add($this->sessionId, $this->clientId, $paramsMailUserAdd);
            return true;
        }
        catch ( Exception $exception ){
            return $exception->getMessage();
        }

    }

    /**
     * log out the SoapClient
     * @throws Exception
     * @return boolean
     */
    public function logout(){
        if( !$this->sessionId ){
            throw new Exception( 'Session ID is not set. SoapClient login() method should return it.' );
        }

        try{
            $this->soapClient->logout( $this->sessionId );
            return true;
        }
        catch ( SoapFault $exception ){
            echo $exception->getMessage();
            return false;
        }
    }



}