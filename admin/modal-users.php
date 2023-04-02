<!DOCTYPE html>
<html lang="en">
<?php
require_once 'includes/dbh.inc.php';
require_once 'head-admin.php';
require_once 'includes/update-users.inc.php';
require_once 'includes/functions.inc.php';
//--------------------------Code LOGIN CHECK START
//check login state, if login was not correct
if (
    !isset($_SESSION['isloggedin'])
    || $_SESSION['useragent'] !== $_SERVER['HTTP_USER_AGENT']
    || $_SESSION['userip'] !== $_SERVER['REMOTE_ADDR']
    || $_SESSION['timestamp'] < time() - 15 * 60
) {
     // unset all sessions
    unset($_SESSION['uUsername']);
    unset($_SESSION['isloggedin']);
    unset($_SESSION['useragent']);
    unset($_SESSION['userip']);
    unset($_SESSION['timestamp']);


    header("location: admin.php?error=sessionfail");
    exit(); // cancel script, head to login page
}
//--------------------------Code LOGIN CHECK END


//--------------------------Code to repopulate fields with User input START
if (isset($_GET["action"])) {
    if ($_GET["action"] == "edit") {
	$query = 'SELECT `usertype`, `username`, `email`, `password` FROM `users` WHERE `ID` = ?';
	$stmt = mysqli_prepare( $conn, $query ); // send order without data
    mysqli_stmt_bind_param( $stmt, 'i', $_GET['id'] ); // send id as int afterwards
    mysqli_stmt_execute( $stmt ); // prepared statement execution
    $res = mysqli_stmt_get_result( $stmt );// object to be able to fetch data 
    $userVal = mysqli_fetch_assoc($res);
    }
}
//--------------------------Code to repopulate fields with User input END

//-----Safe way to get ID to hidden field value
$id = $_GET['id'];
?>
           <!-- deny access for customers -->
           <?php if ( $_SESSION["uType"] != 1 && $_SESSION["uType"] != 2 ) {
    echo '<div class="flex justify-center items-center flex-col mt-64">';
    echo '<i class="fa-solid fa-lock icon-main"></i>';
    echo '<h2 class="text-4xl text-[#5E10BC]">No access!</h2>';
    echo '</div>';
}
else {
?>

<body>
    <?php
    require_once("navi-admin.php");
    ?>
    <div class="z-50 fixed top-0 left-0 px-4 py-3" onclick="openNav(event)" id="bars"><i class="fa-solid fa-bars icon-main"></i></div>
    <div class="z-50 fixed top-0 left-0 px-4 py-3 hidden" onclick="openNav(event)" id="close"><i class="fa-solid fa-x icon-main"></i></div>



    <div class="lg:mx-80 lg:p-12 lg:m-32 m-6 mt-24 p-4 bg-white shadow-[#5E10BC] shadow-lg rounded">
        <h1 class="text-4xl mb-6">Edit User:</h1>
        <!--post that action is not visible in the url -->
        <form action="" method="post" novalidate>
            <fieldset>
                <legend class="sr-only">Type of User</legend>

                <div class="flex items-center mb-4">
                    <input id="user-option-1" value="1" <?php if($userVal["usertype"] == '1') echo 'checked' ?> type="radio" name="utype" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                    <label for="user-option-1" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-600">
                        Admin
                    </label>
                </div>

                <div class="flex items-center mb-4">
                    <input id="user-option-2" value="2" <?php if($userVal["usertype"]  == '2') echo 'checked' ?> type="radio" name="utype" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                    <label for="user-option-2" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-600">
                        Teammember
                    </label>
                </div>

                <div class="flex items-center mb-4">
                    <input id="user-option-3" value="3" <?php if($userVal["usertype"]  == '3') echo 'checked' ?> type="radio" name="utype"  class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                    <label for="user-option-3" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-600">
                        Customer
                    </label>
                </div>

            </fieldset>
            <!--hidden input field to send id to validation -->
            <input type="hidden" name="hiddenID" value="<?php echo $id?>"> 
            <div class="relative z-0 mb-6 w-full group">
                <input type="username" name="username" value="<?php echo $userVal['username']; ?>" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-[#5E10BC] focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="username" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-[#5E10BC] peer-focus:dark:text-[#5E10BC] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Username</label>
            </div>
            <div class="relative z-0 mb-6 w-full group">
                <input type="email" name="email" value="<?php echo $userVal['email']; ?>" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-[#5E10BC] focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-[#5E10BC] peer-focus:dark:text-[#5E10BC] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
            </div>
            <div class="relative z-0 mb-6 w-full group">
                <input type="password" name="pwd" id="floating_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-[#5E10BC] focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-[#5E10BC] peer-focus:dark:text-[#5E10BC] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">New Password</label>
            </div>
            <div class="relative z-0 mb-6 w-full group">
                <input type="password" name="pwdRepeat" id="floating_repeat_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-[#5E10BC] focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_repeat_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-[#5E10BC] peer-focus:dark:text-[#5E10BC] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm new password</label>
            </div>
          
            <div class="grid md:grid-cols-2 md:gap-2">
                <div class="relative z-0 mb-6 w-full group">
                    <button type="submit" name="submit" class="text-white bg-[#5E10BC] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-[#5E10BC] dark:hover:bg-[#7514EB] dark:focus:ring-blue-800">Update User</button>
                    <a href="users.php"><button type="button" name="cancel" class="text-white bg-[#5E10BC] hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-700 dark:hover:bg-red-500 dark:focus:ring-red-800">Cancel</button></a>
                </div>
              
                  
               
                <div class="relative z-0 mb-6 w-full group">
                <?php
                
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmtfailed") {
                      echo '<p id="getMessages" style="color: red; text-align: end; font-size: 1.4rem;">Something went wrong, try again.</p>';
                  }   
                         }
                //display errors / sucess from signup.inc.php
                if (!empty($errors)) {
                    foreach ($errors as $Umessage) {
                        echo '<p id="onappear" style="color: red; text-align: end; font-size: 1.4rem;">&bullet; ' . $Umessage . '</p>';
                   
                    } // end foreach
                    
                } else {
                    foreach ($sucess as $Umessage) {
                        echo '<p id="onappear" style="color: green; text-align: end; font-size: 1.4rem;"> ' . $Umessage . '</p>';
                         
                    
                    } // end foreach
                }
                //end if statement
                ?>
                </div>
            </div>
            

        </form>

    </div>
    
</body>
<!-- end access denied-->
<?php
}
?>

</html>