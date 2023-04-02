<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

//empty field to clear the form
$ptitle = "";

//check for stopping registration process if error occurs
$check = false;
//error array 
$errors = array();
$sucess = array();
//upload config
$allowed_types 	= array('application/zip');


    
//if submit button is pressed, start validation process
if (isset($_POST["submit"])) {
   
    $customer = $_POST["userID"];
    $ptitle = $_POST["projecttitle"];
    $time = time(); 

    //if something in the form has been forgotten
    if (emptyInputDataUpload($customer, $ptitle) !== false) {
        array_push($errors, 'Fill out all fields.');
        $check = true;
    }
    // if no file has been selected
    else if (empty($_FILES['zip']['name'])) {
        array_push($errors, 'Please upload a zip');
        $check = true;
    }
    //check if uploaded file is a zip
    else if (fileTypeZip($allowed_types) !== false) {
        array_push($errors, 'Only zip is allowed!'); 
        $check = true;
    }
    //validation file size zip
    else if( $_FILES['zip']['size']> MAX_FILESIZE ){
		array_push($errors, 'Max Upload should be less than 5MB!'); 
		$check = true;
	}
   
    else if($check == false){
        //make a unique name for the zip file, that if people upload the same zip no problems occur
        $ext = substr($_FILES['zip']['name'], strrpos($_FILES['zip']['name'], '.'));
		$zipname = 'upload_'.time().$ext; 
		$targetPath = ZIP_PATH.'/'.$zipname;
        
		// move zip from temp to targeted folder 
        $uploadSuccess = move_uploaded_file($_FILES['zip']['tmp_name'], $targetPath);
       
        //go to functions.inc.php
        createCustomerData($conn, $ptitle, $zipname, $customer);
      
        
    }
    
    
} 
