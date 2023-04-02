<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

//error array 
$errors = array();
$sucess = array();
//upload config
$allowed_types = array('image/png', 'image/jpeg', 'image/webp');

//check for stopping update process if error occurs
$check = false;

//if submit button is pressed, start validation process
if (isset($_POST["submit"])) {
    $id = $_POST["hiddenID"];
    $category = $_POST["category"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $time = time();

    //if something in the form has been forgotten
    if (emptyInputPost($category, $title, $description) !== false) {
        array_push($errors, 'Fill out all required fields.');
        $check = true;
    }

    //check title if valid
    else if (invalidChars($title, $description) !== false) {
        array_push($errors, "These characters # $ % ^ &amp ; * () ' are not allowed");
        $check = true;
    }
    //check if description is less than 300 characters
    else if (maxChars($title) !== false) {
        array_push($errors, 'The maximum allowed characters are 300.');
        $check = true;
    }
    //enter here if new image has been uploaded
    else if (is_uploaded_file($_FILES['image']['tmp_name'])) {

        //validate new image / file format
        if (fileTypes($allowed_types) !== false) {
            array_push($errors, 'Only Jpeg, PNG or WebP allowed!');
            $check = true;
        }
        //validate new image / image size
        if ($_FILES['image']['size'] > MAX_FILESIZE) {
            echo "driiicho";
            array_push($errors, 'Max Upload should be less than 5MB!');
            $check = true;
        }

        //enters if when there are no errors and a new image has been uploaded
        if ($check == false && is_uploaded_file($_FILES['image']['tmp_name'])) {
            //make a unique name for the image file, that if people upload the same image no problems occur
            $ext = substr($_FILES['image']['name'], strrpos($_FILES['image']['name'], '.'));
            $imagename = 'upload_' . time() . $ext; 
            $targetPath = IMAGE_PATH . '/' . $imagename;

            // move image from temp to targeted folder 
            $uploadSuccess = move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
            //go to functions.inc.php and execute update order WITH image
            updatePost($conn, $id, $category, $imagename, $title, $description);
        }
    } 
    //if NO new image has been added
    else {
        //go to functions.inc.php and execute update order WITHOUT image
        updatePostnoImage($conn, $id, $category, $title, $description);
    }
}
