<?php 
// USER REGISTRATION START ---------------------------------------
//function check for empty inputs
function emptyInputSignup($usertype, $name, $pwd, $pwdRepeat, $email){
 $result = 0;
 if(empty($usertype) || empty($name) || empty($pwd) || empty($pwdRepeat)|| empty($email)){
    $result = true;
    
 }
 else{
    $result = false;
 }
 //return once instead of twice
 return $result;
}
//function check for invalid chars
function invalidUid($name){
 $result = 0;
 //this checks the username input if there are only a-z, A-Z and 0-9 --> Regex test
 if(!preg_match('/^[a-zA-Z0-9]*$/', $name)) {
    $result = true;
 }
 else{
    $result = false;
 }
 return $result;
}
//function to check if email adress is valid
function invalidEmail($email){
 $result = 0;
 //PHP Email checking function
 if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = true;
 }
 else{
    $result = false;
 }
 return $result;
}
//function to check if the passwords match each other
function pwdMatch($pwd, $pwdRepeat){
 $result = 0;
 if($pwd !== $pwdRepeat) {
    $result = true;
 }
 else{
    $result = false;
 }
 return $result;
}

//function to check if username / mail exists in DB
function uidExists($conn, $name, $email){
 $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
 //prepared statement for sequrity
 $stmt = mysqli_stmt_init($conn);
//first checking if there is a mistake in the sql statement
 if (!mysqli_stmt_prepare( $stmt, $sql)){
    header("location: ../users.php?error=stmtfailed");
    exit();
 }
 //passing data from user to DB
 mysqli_stmt_bind_param($stmt, "ss", $name, $email );
 mysqli_stmt_execute($stmt);

 $resultData = mysqli_stmt_get_result($stmt);

 //if it gets data from DB --> true, else false
 if($row = mysqli_fetch_assoc($resultData)){
    mysqli_stmt_close($stmt);
    //returns all data from row if user exists in DB
    return $row;

 }
else{
    $result = false;
    mysqli_stmt_close($stmt);
    return $result;
}
}

//function to create a new user
function createUser($conn, $usertype, $name, $email, $pwd){
   //? placeholder for prepared statement
    $sql = "INSERT INTO users (usertype, username, email, password) VALUES (?, ?, ?, ?);";
    //prepared statement for sequrity
    $stmt = mysqli_stmt_init($conn);
   //first checking if there is a mistake in the sql statement
    if (!mysqli_stmt_prepare( $stmt, $sql)){
       header("location: users.php?error=stmtfailed");
       exit(); 
    }
    //secure password algorythm
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    //passing data from user to DB
    mysqli_stmt_bind_param($stmt, "isss", $usertype, $name, $email, $hashedPwd );
    mysqli_stmt_execute($stmt);  
    mysqli_stmt_close($stmt);
   
   }
   // USER REGISTRATION END ---------------------------------------

   // USER UPDATE START ---------------------------------------
   // function to update user from modal
   function updateUser($conn,$id, $usertype, $name, $email, $pwd){
      //? placeholder for prepared statement
      $sql = "UPDATE `users` SET `usertype`= ?,`username`=?,`email`= ?,`password`= ?  WHERE ID = $id";
      //prepared statement for sequrity
      $stmt = mysqli_prepare($conn, $sql);
     //first checking if there is a mistake in the sql statement
      if (!mysqli_stmt_prepare( $stmt, $sql)){
         header("location: modal-users.php?error=stmtfailed");
         //exit();
      }
      //secure password algorythm
      $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
  
      //passing data from user to DB
      mysqli_stmt_bind_param($stmt, "isss", $usertype, $name, $email, $hashedPwd );
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      header("location: users.php?error=updated");
      exit();
     }


   // USER UPDATE END -------------------------------------------
  
   // LOGIN START ---------------------------------------
   // function to validate inputs from admin login / customer login
   function emptyInputLogin($username, $password){
      $result = 0;
      if(empty($username) || empty($password)){
         $result = true;
      }
      else{
         $result = false;
      }
      //return once instead of twice
      return $result;
     }
     
   
     // function to login a admin and create sessions
     function loginAdmin($conn, $name, $password){
      //Double username in order to check for email or username, only one has to be typed in
      $uidExists = uidExists($conn, $name, $name);
      
      //errorhandler to rule out non-existing usernames / email
      if($uidExists === false){
         header("location: ../admin/admin.php?error=nouid");
         exit();
      }

      $pwdHashed = $uidExists["password"];
      $checkPwd = password_verify($password, $pwdHashed);

      if($checkPwd === false){
         header("location: ../admin/admin.php?error=wronglogin");
         exit();
      }
      else {
         //session_start();
         $_SESSION["uUsername"] = $uidExists["username"];
         $_SESSION["uUid"] = $uidExists["ID"];
         $_SESSION["uType"] = $uidExists["usertype"];
         $_SESSION['isloggedin'] = true;
			$_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['userip'] = $_SERVER['REMOTE_ADDR'];
			$_SESSION['timestamp'] = time();

         header("location: ../admin/dashboard.php");
         exit();
      }
     }

     // function to login a user and create sessions
     function loginUser($conn, $name, $password){
      //Double username in order to check for email or username, only one has to be typed in
      $uidExists = uidExists($conn, $name, $name);
      
      //errorhandler to rule out non-existing usernames / email
      if($uidExists === false){
         header("location: customers.php?error=nouid");
         exit();
      }
      $pwdHashed = $uidExists["password"];
      $checkPwd = password_verify($password, $pwdHashed);

      if($checkPwd === false){
         header("location: customers.php?error=wronglogin");
         exit();
      }
      else {
         //session_start();
         $_SESSION["uUsername"] = $uidExists["username"];
         $_SESSION["uUid"] = $uidExists["ID"];
         $_SESSION["uType"] = $uidExists["usertype"];
         $_SESSION['isloggedin'] = true;
			$_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['userip'] = $_SERVER['REMOTE_ADDR'];
			$_SESSION['timestamp'] = time();

         header("location: customer-data.php");
         exit();
      }

     }



   // ARTICLES START ---------------------------------------
   // function to check for empty inputs in articles
function emptyInputPost($category, $title, $description){
   $result = 0;
   if(empty($category) ||  empty($title) || empty($description)){
      $result = true;
   }
   else{
      $result = false;
   }
   return $result;
  }
  
  // function to check for invalid chars in articles
  function invalidChars($title, $description){
   $result = 0;
   //this checks the title input if there are only a-z, A-Z and 0-9 --> Regex test
   if(!preg_match("/^(a-z|A-Z|0-9)*[^#$%^&*()']*$/", $title, $description)) {
      $result = true;
   }
   else{
      $result = false;
   }
   return $result;
  }

  //function description should not be more than 300 characters
  function maxChars($description){
   $result = 0;
   //this checks the title input if there are only a-z, A-Z and 0-9 --> Regex test
   if(strlen($description) > 300) {
      $result = true;
   }
   else{
      $result = false;
   }
   return $result;
  }

  // function to restrict allowed image types
  function fileTypes($allowed_types){
   $result = 0;
   // validate imagefield - restrict file types
	if( in_array($_FILES['image']['type'], $allowed_types) == false ){
      $result = true;
	}
   else{
      $result = false;
   }
   return $result;
  }

  //function to upload article values to DB in a prepared statement
  function createPost($conn, $category, $imagename, $title, $description){
  //data with placeholders
  $insertQuery = "INSERT INTO articles (category, image, title, description, date, userID) VALUES (?, ?, ?, ?, NOW(), ?);";
  //order to send without data
  $stmt = mysqli_prepare( $conn, $insertQuery ); 
  //send without date and dynamic session value
  mysqli_stmt_bind_param( $stmt, 'ssssi', $category, $imagename, $title, $description, $_SESSION["uUid"] ); 
  //execute prepared statement
  mysqli_stmt_execute( $stmt ); 
  //close DB connection
  mysqli_stmt_close($stmt);
  header("location: articles.php?error=created");
  exit();
  }

  // function to update a article from modal IF A NEW IMAGE IS UPLOADED
  function updatePost($conn, $id, $category, $imagename, $title, $description){
   //? placeholder for prepared statement
   $sql = "UPDATE articles SET category= ?,`image`=?,`title`= ?,`description`= ? ,`userID`= ?  WHERE ID = $id";
   //prepared statement for sequrity
   $stmt = mysqli_prepare($conn, $sql);
  //first checking if there is a mistake in the sql statement
   if (!mysqli_stmt_prepare( $stmt, $sql)){
      header("location: modal-articles.php?error=stmtfailed");
      exit();
   }
   //passing data from user to DB
   mysqli_stmt_bind_param($stmt, 'ssssi', $category, $imagename, $title, $description, $_SESSION["uUid"]);
   
   mysqli_stmt_execute($stmt);
   mysqli_stmt_close($stmt);
   header("location: articles.php?error=updated");
   exit();
  }

  // function to update a article from modal IF NO NEW IMAGE HAS BEEN UPLOADED
  function updatePostnoImage($conn, $id, $category, $title, $description){    
   //? placeholder for prepared statement
   $sql = "UPDATE articles SET category= ?,`title`= ?,`description`= ? ,`userID`= ?  WHERE ID = $id";
   //prepared statement for sequrity
   $stmt = mysqli_prepare($conn, $sql);
  //first checking if there is a mistake in the sql statement
   if (!mysqli_stmt_prepare( $stmt, $sql)){
      header("location: modal-articles.php?error=stmtfailed");
      exit();
   }
   
   //passing data from user to DB
   mysqli_stmt_bind_param($stmt, 'sssi', $category, $title, $description, $_SESSION["uUid"]);
  
   
   mysqli_stmt_execute($stmt);
   mysqli_stmt_close($stmt);
   header("location: articles.php?error=updated");
   exit();
  }
   // ARTICLES END ---------------------------------------


   // CUSTOMERS START ---------------------------------------
   // function to check if empty inputs in Data Upload 
   function emptyInputDataUpload($customer, $ptitle){
   $result = 0; 
   if( empty($customer) || empty($ptitle) ){
      $result = true;
   }
   else{
      $result = false;
   }
   return $result;
  }
 // function to check if file upload is a zip file
  function fileTypeZip($allowed_types){
   $result = 0;
   // validate imagefield - restrict file types
	if( in_array($_FILES['zip']['type'], $allowed_types) == false ){
      $result = true;
	}
   else{
      $result = false;
   }
   return $result;
  }

   // function to create Customer Data in the DB
  function createCustomerData($conn, $ptitle, $zipname, $customer){
   $insertQuery = "INSERT INTO customer (projecttitle, userID, zip, date) VALUES (?, ?, ?, NOW());";
   //prepared statement
   $stmt = mysqli_prepare( $conn, $insertQuery ); 
   
   mysqli_stmt_bind_param( $stmt, 'sis', $ptitle, $customer, $zipname ); 
   mysqli_stmt_execute( $stmt );
  
   mysqli_stmt_close($stmt);
   header("location: customer-admin.php?error=created");
   
   }