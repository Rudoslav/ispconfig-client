<?php
session_start();
/**
 * Created by PhpStorm.
 * User: xr
 * Date: 25.08.17.
 * Time: 15:33
 */
require 'IspconfigSoapclient.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $postData = $_POST;

    $validationErrors = [];

    $fieldsValidation = [
        'name' => [
            FILTER_SANITIZE_STRING,
            'required'
        ],
        'surname' => [
            FILTER_SANITIZE_STRING,
            'required'
        ],
        'company_name' => [
            FILTER_SANITIZE_STRING
        ],
        'date_ico' => [
            FILTER_SANITIZE_STRING,
            'required'
        ],
        'street' => [
            FILTER_SANITIZE_STRING,
            'required'
        ],
        'number' => [
            FILTER_SANITIZE_STRING,
            'required'
        ],
        'town' => [
            FILTER_SANITIZE_STRING,
            'required'
        ],
//        'psc' => FILTER_VALIDATE_INT,
        'state' => [
            FILTER_SANITIZE_STRING,
            'required'
        ],
        'email' => [
            FILTER_VALIDATE_EMAIL,
            'required'
        ],
        'telephone' => [
            FILTER_SANITIZE_STRING
        ],
        'username' => [
            FILTER_SANITIZE_STRING,
            'required'
        ],
        'password' => [
            FILTER_SANITIZE_STRING,
            'required'
        ]
    ];

    foreach ( $fieldsValidation as $field => $validationRules ){

        if( is_array( $validationRules ) ){

            if( !empty( $postData[$field] ) || in_array( 'required', $validationRules ) ){

                $validationStatus = false;

                foreach ( $validationRules as $validationRule ){
                    if( $validationRule != 'required' )
                        $validationStatus = filter_var( $postData[$field], $validationRule );
                }

                if( !$validationStatus )
                    $validationErrors[$field] = 'Not a valid format for ' . $field;
            }
        }
    }

    if( !is_numeric($postData['psc']) )
        $validationErrors['psc'] = 'Not a valid format for PSC';

    if( !isset( $postData['agreement'] ) ){
        $validationErrors['agreement'] = 'Please check the user information agreement to proceed';
    }

    if( $validationErrors ) {
        $_SESSION['errors'] = $validationErrors;
        $_SESSION['old'] = $postData;
        header('Location: index.php');
        exit;
    }

    $soapClient = new IspconfigSoapclient();

    // Login data is supplied by config.php
    $soapClient->login();
    $soapClient->setInputData( $postData );

    $soapActions = [
        'addClient', 'addMailUser', 'logout'
    ];

    foreach ( $soapActions as $soapAction ){
        $response = $soapClient->$soapAction();
        if( $response !== true ){
            $_SESSION['errors'][$soapAction] = $response;
            $_SESSION['status'] = false;
            $_SESSION['old'] = $postData;
            header('Location: index.php');
            exit;
        }
    }

    $_SESSION['status'] = true;
    header('Location: index.php');
    exit;
}