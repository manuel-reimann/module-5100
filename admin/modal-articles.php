<!DOCTYPE html>
<html lang="en">
<?php
require_once 'head-admin.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/update-articles.inc.php';
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
	$query = 'SELECT `category`, `image`, `title`, `description` FROM `articles` WHERE `ID` = ?';
	$stmt = mysqli_prepare( $conn, $query ); // send order without data
    mysqli_stmt_bind_param( $stmt, 'i', $_GET['id'] ); // send id as int afterwards
    mysqli_stmt_execute( $stmt ); // prepared statement execution
    $res = mysqli_stmt_get_result( $stmt );// object to be able to fetch data 
    $articleVal = mysqli_fetch_assoc($res);
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
        <form action="" method="post" id="edit-article" enctype="multipart/form-data" novalidate>
            <h1 class="text-4xl">Edit Article</h1>

            <!--choose category-->
            <label class="block mb-2 mt-4 text-lg font-medium text-gray-900" for="category">Category</label>
            <fieldset class="flex items-center gap-4 mt-4">
                <legend class="sr-only">Select type of article</legend>
                <div class="flex items-center mb-4">
                    <input id="photo" type="radio" <?php if($articleVal["category"] == 'photo') echo 'checked' ?> name="category" value="photo" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" >
                    <label for="photo" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-600">
                        Photo
                    </label>
                </div>

                <div class="flex items-center mb-4">
                    <input id="video" type="radio" <?php if($articleVal["category"] == 'video') echo 'checked' ?> name="category" value="video" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                    <label for="video" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-600">
                        Video
                    </label>
                </div>

                <div class="flex items-center mb-4">
                    <input id="web" type="radio" <?php if($articleVal["category"] == 'web') echo 'checked' ?> name="category" value="web" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                    <label for="web" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-600">
                        Web
                    </label>
                </div>
            </fieldset>

            <!--hidden input field to send id to validation -->
            <input type="hidden" name="hiddenID" value="<?php echo $id?>"> 

            <!-- photo upload-->
            <label class="block mb-2 mt-4 text-lg font-medium text-gray-900 " for="file_input">Optional: Upload new photo</label>
            
           
            <input name="image" class="block w-full text-lg text-gray-300 border border-gray-300 lg:rounded cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
            <p class="mt-1 text-md text-gray-500" id="file_input_help">PNG, JPG or GIF | Leave empty if you want to keep the old image</p>
           

            <!--describe article -->
            <div class="my-2">
                <label for="title" class="block mb-2 text-lg font-medium text-black ">Title</label>
                <input name="title" value="<?php echo $articleVal['title']; ?>" type="text" id="title" class="block px-4 py-2 w-full text-gray-900 bg-gray-50 lg:rounded border border-gray-300 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div class="my-2">
                <label for="description" class="block mb-2  text-lg font-medium text-gray-900 ">Description</label>
                <textarea name="description" type="text" id="description" class="block px-4 py-0 w-full h-32 text-gray-900 bg-gray-50 lg:rounded border border-gray-300 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"><?php echo $articleVal['description']; ?></textarea>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 mb-6 w-full group">
                    <button name="submit" type="submit" class="bg-[#5E10BC] shadow-lg shadow-[#5E10BC] dark:hover:bg-purple-800  cursor-pointer rounded py-2 px-6 text-white text-xl text-bold">Update Article</button>
                    <a href="articles.php"><button type="button" name="cancel" class="text-white shadow-lg shadow-red-400 cursor-pointer rounded py-2 px-6 text-white text-xl text-bold text-center dark:bg-red-700 dark:hover:bg-red-500 dark:focus:ring-red-800">Cancel</button></a>
                </div>
                <div class="relative z-0 mb-6 w-full group">
                    <?php
                    //display errors / sucess from functions.inc.php 
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmtfailed") {
                            echo '<p id="getMessages" style="color: red; text-align: end; font-size: 1.4rem;">Something went wrong, try again.</p>';
                        }
                        if ($_GET["error"] == "updated") {
                            echo '<p id="getMessages" style="color: green; text-align: end; font-size: 1.4rem;">Article updated!</p>';
                        }
                    }
                    //display errors / sucess from create.inc.php
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