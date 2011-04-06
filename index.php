<?php

    define( 'CONTROLLERS','app/controllers/' );
    define( 'VIEWS','app/views/' );
    define( 'LAYOUT','app/views/layout/' );
    define( 'MODELS','app/models/' );
    define( 'HELPERS','system/helpers/' );
    define( 'CONFIG','app/config/' );
    define( 'ELEMENT','app/views/element/' );

    error_reporting(E_ALL);
    @ini_set('display_errors', 'on');
    @error_reporting(E_ALL | E_NOTICE);
    @ini_set('error_reporting', E_ALL | E_NOTICE);


    require_once('system/system.php');
    require_once('system/controller.php');
    require_once('system/model.php');
    require_once(CONFIG.'config.php');
    
    function __autoload( $file ){
        if ( file_exists(MODELS . $file . '.php') )
            require_once( MODELS . $file . '.php' );
        else if ( file_exists(HELPERS . $file . '.php') )
            require_once( HELPERS . $file . '.php' );
        else
            die("Model ou Helper nao encontrado.");
    }

    $start = new System;
    $start->run();