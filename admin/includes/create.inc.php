<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';


//empty fields to clear the form
$category = "";
$title = "";
$description = "";
$time = "";
//check for stopping registration validation if error occurs
$check = false;
//error array 
$errors = array();
$sucess = array();
//upload config
$allowed_types 	= array('image/png', 'image/jpeg', 'image/webp');
//----------

    
//variables to validate inputs 
if (isset($_POST["submit"])) {
    $category = $_POST["category"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $time = time();   
   

    //if something there is an empty input 
    if (emptyInputPost($category, $title, $description) !== false) {
        array_push($errors, 'Fill out all fields.');
        $check = true;
    }
    //check if image has been uploaded
    else if (empty($_FILES['image']['name'])) {
        array_push($errors, 'Please upload an image');
        $check = true;
    }
    //check if there are no special characters in the title
    else if (invalidChars($title, $description) !== false) {
        array_push($errors, "These characters # $ % ^ &amp ; * () ' are not allowed");
        $check = true;
    }
    //check if description is less than 300 characters
    else if (maxChars($title) !== false) {
        array_push($errors, 'The maximum allowed characters are 300.');
        $check = true;
    }
    //check if uploaded file is jpg, png or webp
    else if (fileTypes($allowed_types) !== false) {
        array_push($errors, 'Only Jpeg, PNG or WebP allowed!'); 
        $check = true;
    }
    //validation file size image
    else if( $_FILES['image']['size']> MAX_FILESIZE ){
		array_push($errors, 'Max Upload should be less than 5MB!'); 
		$check = true;
	}
   // if all the validations have been sucessfull, move image and send to DB
    else if($check == false){
        //make a unique name for the image file, that if people upload the same image no problems occur
        $ext = substr($_FILES['image']['name'], strrpos($_FILES['image']['name'], '.'));
		$imagename = 'upload_'.time().$ext; 
		$targetPath = IMAGE_PATH.'/'.$imagename;
      
		// move image from temp to targeted folder 
        $uploadSuccess = move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
     
        //go to functions.inc.php
        createPost($conn, $category, $imagename, $title, $description);
        // empty form fields
        $title = "";
        $description = "";
        
    }
    
    
} 
