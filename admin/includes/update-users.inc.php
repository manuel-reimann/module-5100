<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

//error array 
$errors = array();
$sucess = array();

//check for stopping registration process if error occurs
$check = false;

//if submit button is pressed, start validation process
if (isset($_POST["submit"])) {
    $id = $_POST["hiddenID"];
    $usertype = $_POST["utype"];
    $email = $_POST["email"];
    $name = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];   

    //additional security for password
    $uppercase = preg_match('@[A-Z]@', $pwd);
    $lowercase = preg_match('@[a-z]@', $pwd);
    $number    = preg_match('@[0-9]@', $pwd);
    $specialChars = preg_match('@[^\w]@', $pwd);

    //if something in the form has been forgotten
    if (emptyInputSignup($usertype, $name, $email, $pwd, $pwdRepeat) !== false) {
        array_push($errors, 'Fill out all fields.');
        $check = true;
    }
    //check username if valid
    else if (invalidUid($name) !== false) {
        array_push($errors, 'Choose a proper Username!');
        $check = true;
    }
    //check email if valid
    else if (invalidEmail($email) !== false) {
        array_push($errors, 'Choose a proper email!');
        $check = true;
    }
    //pwd Security minimum length and special chars
    else if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pwd) < 8) {
        array_push($errors, 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
        $check = true;
    }
    //check if passwords match each other
    else if (pwdMatch($pwd, $pwdRepeat) !== false) {
        array_push($errors, 'Passwords do not match!');
        $check = true;
    }
    //check if username already exists
    else if (uidExists($conn, $name, $email) !== false) {
        array_push($errors, 'Username already taken.');
        $check = true;
    }
    else if($check == false){
        //go to functions.inc.php
        updateUser($conn, $id, $usertype, $name, $email, $pwd);
        array_push($sucess, 'User updated!');
        $usertype = "";
        $email = "";
        $name = "";
        $pwd = "";
        $pwdRepeat = "";
    }
    
    
} 

