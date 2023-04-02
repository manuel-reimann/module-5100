<?php
require_once('includes/dbh.inc.php');
require_once('includes/create.inc.php');
//--------------------------Code LOGIN CHECK START
//check login state first
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
    exit(); 
}
//--------------------------Code LOGIN CHECK END
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once("head-admin.php"); ?>

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
    <!--sidenav Admin start-->
    <?php
    require_once("navi-admin.php");
    ?>
    <div class="z-50 fixed top-0 left-0 px-4 py-3" onclick="openNav(event)" id="bars"><i class="fa-solid fa-bars icon-main"></i></div>
    <div class="z-50 fixed top-0 left-0 px-4 py-3 hidden" onclick="openNav(event)" id="close"><i class="fa-solid fa-x icon-main"></i></div>
    <!--sidenav Admin end-->

<div class="flex justify-center items-center mt-64">
    <div class="grid lg:grid-cols-2 grid-cols-1 gap-4">
            <a href="articles.php" class="cursor-pointer hover:shadow-[#5E10BC] shadow-md rounded h-full block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-600 dark:border-gray-700 dark:hover:bg-gray-500 flex  flex-row gap-8">
                <h1 class="text-8xl font-bold text-gray-900 dark:text-white"> <i class="fa-solid fa-table-columns"></i></h1>
                <div class="flex flex-col justify-center">
                    <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white"> Articles</h2>
                    <p class="font-normal text-white dark:text-white">Add new Articles and edit the existing. </p>
                </div>
            </a>

            <!-- restrict acess for Teammembers-->
            <?php if ( $_SESSION["uType"] != 1 ) { //show nothing
            }
            
            else {
            ?>
            <a href="users.php" class="cursor-pointer hover:shadow-[#5E10BC] shadow-md rounded h-full block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-600 dark:border-gray-700 dark:hover:bg-gray-500 flex  flex-row gap-8">
                <h1 class="text-8xl font-bold text-gray-900 dark:text-white"> <i class="fa-solid fa-user "></i></h1>
                <div class="flex flex-col justify-center">
                    <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white"> Users</h2>
                    <p class="font-normal text-white dark:text-white">Add and edit Admins, Teammembers or Customers. </p>
                </div>
            </a>

            <!-- end access denied-->
            <?php
            }
            ?>

            <a href="customer-admin.php" class="cursor-pointer hover:shadow-[#5E10BC] shadow-md rounded h-full block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-600 dark:border-gray-700 dark:hover:bg-gray-500 flex  flex-row gap-8">
                <h1 class="text-8xl font-bold text-gray-900 dark:text-white">  <i class="fa-solid fa-user-group"></i ></h1>
                <div class="flex flex-col justify-center">
                    <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white"> Customer Data</h2>
                    <p class="font-normal text-white dark:text-white">Add content specific for a single Customer.</p>
                </div>
            </a>
        
            <a href="includes/logout.inc.php" class="cursor-pointer hover:shadow-red-700 shadow-md rounded h-full block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-600 dark:border-gray-700 dark:hover:bg-gray-500 flex  flex-row gap-8">
                <h1 class="text-8xl font-bold text-gray-900 dark:text-white"> <i class="fa-solid fa-right-from-bracket"></i></h1>
                <div class="flex flex-col justify-center">
                    <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white"> Logout</h2>
                    <p class="font-normal text-white dark:text-white">Logout </p>
                </div>
            </a>

    </div>

    </div>


</body>

<!-- end access denied-->
<?php
}
?>

</html>