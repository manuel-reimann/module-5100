<?php
session_start();
$serverName ="localhost";
$dbUsername ="root";
$dbPassword ="root"; //change to nothing if windows
$dbName ="a_pixlify";

$conn = mysqli_connect($serverName,$dbUsername, $dbPassword, $dbName);

//Errormessage in case of a failing connection
 if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

define('CONFIG_SESSION_NAME', 'PIXLIFYSESSION');
define('CONFIG_SESSION_LIFETIME', 3600);

// images 
define( 'MAX_FILESIZE', 5000000); //5mb
define( 'IMAGE_FOLDER', 'images');
define( 'ZIP_FOLDER', 'zips');
define( 'IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/Modul_5100/Modulprojekt/'.IMAGE_FOLDER); //change to your root folder
define( 'ZIP_PATH', $_SERVER['DOCUMENT_ROOT'].'/Modul_5100/Modulprojekt/'.ZIP_FOLDER); //change to your root folder
