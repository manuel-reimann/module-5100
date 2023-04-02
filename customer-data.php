<?php
require_once 'admin/includes/dbh.inc.php';
require_once("html/configuration.php");

//check login state, if login was not correct
//--------------------------Code LOGIN CHECK START
if (
    !isset($_SESSION['isloggedin'])
    || $_SESSION['useragent'] !== $_SERVER['HTTP_USER_AGENT']
    || $_SESSION['userip'] !== $_SERVER['REMOTE_ADDR']
    || $_SESSION['timestamp'] < time() - 15 * 60
) {
    // unset sessions
    unset($_SESSION['uUsername']);
    unset($_SESSION['isloggedin']);
    unset($_SESSION['useragent']);
    unset($_SESSION['userip']);
    unset($_SESSION['timestamp']);


    header("location: customers.php?error=sessionfail");
    exit(); 
}
//--------------------------Code LOGIN CHECK START

$userID = $_SESSION["uUid"];

//--------------------------Code PROJECT LIST START
//query to select Project rows and fetch Username via userid foreign key
$sql = "SELECT * FROM `customer` WHERE `userID` =  $userID" ;
//connect to db and hand over order
$resultD = mysqli_query($conn, $sql);
//fetch all user data in arrays, last one first
$row = array_reverse(mysqli_fetch_all($resultD, MYSQLI_ASSOC));
//--------------------------Code PROJECT LIST END
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once("html/head.php"); ?>
<body class="h-screen">
<!--sidenav -->
        <?php 
				require_once("html/navi.php"); 
				?>
    <div class="z-50 fixed top-0 left-0 px-4 py-3" onclick="openNav(event)" id="bars"><i class="fa-solid fa-bars icon-main"></i></div>
    <div class="z-50 fixed top-0 left-0 px-4 py-3 hidden" onclick="openNav(event)" id="close"><i class="fa-solid fa-x icon-main"></i></div>
<!--sidenav end-->

    <div class="fixed top-36 left-2/4 transform -translate-x-2/4 -translate-y-2/4 text-4xl lg:text-4xl">
      <h1 >Download your Data here</h1>
    </div>
    
    <div class="flex justify-center items-center mt-64">
    <div class="grid lg:grid-cols-2 grid-cols-1 gap-4">

  <!-- only run for each if data has been uploaded -->
    <?php if (count($row) > 0) { ?>
      <!-- to display all projects of the customer -->
      <?php foreach ($row as $oneRow) { ?>     
        <a href="<?php echo 'zips/'.$oneRow['zip'] ?>" class="hover:shadow-[#5E10BC] shadow-md rounded h-full block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-600 dark:border-gray-700 dark:hover:bg-gray-500 flex flex-row gap-8" download="<?php echo $oneRow['projecttitle']; ?>">
                    <h1 class="text-8xl font-bold text-gray-900 dark:text-white"> <i class="fa-solid fa-download"></i></h1>
                    <div class="flex flex-col justify-center">
                        <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white"> <?php echo $oneRow['projecttitle']; ?></h2>
                        <p class="font-normal text-white dark:text-white">Your data is availible for <?php
                        //save upload time in variable
                        $upload_time = $oneRow['date'];
                        // convert the upload time to a timestamp
                        $upload_timestamp = strtotime($upload_time);
                        // get the current timestamp
                        $current_timestamp = time();
                        // calculate the difference in seconds between the current time and the upload time
                        $difference = $current_timestamp - $upload_timestamp;
                        // calculate the number of days by dividing the difference in seconds by the number of seconds in a day
                        $days = 89 - (floor($difference / 86400));
                        // print the number of remaining days
                        echo $days;
                      ?> days.</p>
                    </div>
        </a>
      <?php } // end foreach  ?>
    <?php } 
    else {          //display message no data has been uploaded
                    echo '<div class="absolute left-1/2 top-1/2 transform -translate-x-2/4 -translate-y-2/4">
                    <p class="text-white text-2xl "> <i class="fa-regular fa-folder-open pr-4"></i>Nothing uploaded yet.</p>
                    </div>';
          } ?>
    </div>

    </div>


    

</body>
</html>