<?php
require_once('includes/dbh.inc.php');
require_once('includes/upload-data.inc.php');
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

//--------------------------Code for FORM INPUT START
//query to insert all users type customer into the select query
$sql = "SELECT * FROM `users` WHERE `usertype` = 3";
//connect to db and hand over order
$resultD = mysqli_query($conn, $sql);
//fetch all user data in arrays, last one first
$row = array_reverse(mysqli_fetch_all($resultD, MYSQLI_ASSOC));
//--------------------------Code for FORM INPUT END

//--------------------------Code for List START
//Action to delete Post --> MUST BE BEFORE FETCHING USER LIST otherwise reload is necessary
if (isset($_GET["action"])) {
  if ($_GET["action"] == "delete") {
      $query = 'DELETE FROM `customer` WHERE `ID` = ' . $_GET["id"];
      $resultD = mysqli_query($conn, $query);
  }
}

//Delete Files automatically older than 90 days
mysqli_query($conn, "DELETE FROM customer WHERE date < DATE_SUB(NOW(), INTERVAL 90 DAYS)");


//query to select Project rows and fetch Username via userid foreign key
$sql2 = "SELECT `customer`.*, `users`.username FROM `customer` LEFT JOIN `users` ON customer.userID = users.ID";
//connect to db and hand over order
$resultD2 = mysqli_query($conn, $sql2);
//fetch all user data in arrays, last one first
$row2 = array_reverse(mysqli_fetch_all($resultD2, MYSQLI_ASSOC));
//--------------------------Code for List END
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once("head-admin.php"); ?>

<body>
            <!-- deny access for customers -->
<?php if ( $_SESSION["uType"] != 1 && $_SESSION["uType"] != 2 ) {
    echo '<div class="flex justify-center items-center flex-col mt-64">';
    echo '<i class="fa-solid fa-lock icon-main"></i>';
    echo '<h2 class="text-4xl text-[#5E10BC]">No access!</h2>';
    echo '</div>';
}
else {
?>
    <!--sidenav Admin start-->
    <?php
    require_once("navi-admin.php");
    ?>
    <div class="z-50 fixed top-0 left-0 px-4 py-3" onclick="openNav(event)" id="bars"><i class="fa-solid fa-bars icon-main"></i></div>
    <div class="z-50 fixed top-0 left-0 px-4 py-3 hidden" onclick="openNav(event)" id="close"><i class="fa-solid fa-x icon-main"></i></div>
    <!--sidenav Admin end-->



    <div class="lg:mx-80 lg:p-12 lg:m-32 m-6 mt-24 p-4 bg-white shadow-[#5E10BC] shadow-lg rounded">
        <form action="" method="post" id="customer-content" enctype="multipart/form-data" novalidate>
            <h1 class="text-4xl mb-6">Add customer data</h1>

            <label for="projecttitle" class="block mb-2  text-lg font-medium text-gray-900 ">Project Title</label>
            <input name="projecttitle" value="<?= $ptitle; ?>" type="text" id="title" class="block px-4 py-2 w-full text-gray-900 bg-gray-50 lg:rounded border border-gray-300 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

              <label class="block mb-2 mt-4 text-lg font-medium text-gray-900 "  for="customer">Choose the Customer</label>
                <select name="userID" class="p-2 mb-4 block w-full text-lg text-gray-300 border border-gray-300 lg:rounded cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="customer">
                  <!-- display the name of each customer as option -->
                  <?php foreach ($row as $oneRow) { ?>
                     <option value="<?php echo $oneRow['ID']; ?>"> <?php echo $oneRow['username']; ?></option>
                   <?php } // end foreach  ?>
              
               </select>

            <!-- zip upload-->
            <label class="block mb-2 mt-4 text-lg font-medium text-gray-900 " for="zip">Upload zip file</label>
            <input name="zip" value="<?= $zip; ?>" class="block w-full text-lg text-gray-300 border border-gray-300 lg:rounded cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="zip" type="file">
            <p class="mt-1 text-md text-gray-500 mb-8" id="file_input_help">zip file (max. 5MB)</p>

            
            
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 mb-6 w-full group">
                    <button name="submit" class="bg-[#5E10BC] shadow-lg shadow-[#5E10BC] cursor-pointer rounded py-2 px-6 text-white text-xl text-bold">Add Content</button>
                </div>




                <div class="relative z-0 mb-6 w-full group">
                    <?php
                    //display errors / sucess from functions.inc.php 
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmtfailed") {
                            echo '<p id="getMessages" style="color: red; text-align: end; font-size: 1.4rem;">Something went wrong, try again.</p>';
                        }
                        if ($_GET["error"] == "created") {
                            echo '<p id="getMessages" style="color: green; text-align: end; font-size: 1.4rem;">Data uploaded!</p>';
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
    <!--form end-->

    <div class="lg:mx-80 lg:m-32 m-6 mt-24 shadow-[#5E10BC] overflow-x-auto relative shadow-lg sm:rounded-lg">
        <table class="w-full text-md text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th scope="col" class="py-3 px-6">
                        Project Title
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Customer
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Data Name
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Date Uploaded
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Delete
                    </th>
                   
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($row2 as $secRow) { ?>
                    <tr class="odd:bg-white even:bg-slate-50 border-b dark:border-gray-700">
                        <td class="py-4 px-6">  
                            <?php echo $secRow['projecttitle']; ?>
                        </td>
                        <td class="py-4 px-6">
                            <?php echo $secRow['username']; ?>
                        </td>
                       
                        <td class="py-4 px-6">
                            <?php echo $secRow['zip']; ?>
                        </td>
                        <td class="py-4 px-6">
                            <?php echo $secRow['date']; ?>
                        </td>
                     
                        <td class="py-4 px-6">
                            <a href="customer-admin.php?id=<?php echo $secRow['ID']; ?>&action=delete" class="pl-3"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } // end foreach 
                ?>
            </tbody>
        </table>
    </div>


</body>
<!-- end access denied-->
<?php
}
?>

</html>