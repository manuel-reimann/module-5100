<?php
require_once 'admin/includes/dbh.inc.php';
require_once 'admin/includes/functions.inc.php';

//if submit button is pressed, start validation process
if(isset($_POST["submit"])){
  $username = $_POST["username"];
  $password = $_POST["pwd"];

//errorhandlers
  if(emptyInputLogin($username, $password) !== false ){
      header("location: customers.php?error=emptyinput");
      exit();
  }
  //execute login function in functions.inc.php
  loginUser($conn, $username, $password);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once("html/head.php"); ?>

<body>
  <?php
  require_once("html/navi.php");
  ?>
  <div class="z-50 fixed top-0 left-0 px-4 py-3" onclick="openNav(event)" id="bars"><i class="fa-solid fa-bars icon-main"></i></div>
  <div class="z-50 fixed top-0 left-0 px-4 py-3 hidden" onclick="openNav(event)" id="close"><i class="fa-solid fa-x icon-main"></i></div>

  <div class="lg:mx-80 lg:p-12 lg:m-32 m-6 mt-24 p-4 bg-white shadow-[#5E10BC] shadow-lg rounded">
  
    <form id="login" action="" method="post">
      <h1 class="text-4xl">Customer Login <i class="fa-solid fa-lock"></i></h1>
      <div class="my-2">
        <label for="username" class="block mb-2 text-lg font-medium text-black ">Username / Email</label>
        <input type="text" id="username" name="username" class="block px-4 py-2 w-full text-gray-900 bg-gray-50 lg:rounded border border-gray-300 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
      </div>
      <div class="my-2">
        <label for="password" class="block mb-2 text-lg font-medium text-black ">Password</label>
        <input type="password" id="password" name="pwd" class="block px-4 py-2 w-full text-gray-900 bg-gray-50 lg:rounded border border-gray-300 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
      </div>
      <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 mb-6 w-full group">
          <div class="my-4" id="send-login">

            <button name="submit" type="submit" class="bg-[#5E10BC] shadow-lg shadow-[#5E10BC] cursor-pointer rounded py-2 px-6 text-white text-xl text-bold">Login</button>
          </div>
        </div>
        <div class="my-4 relative z-0 mb-6 w-full group">
          <?php
          if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
              echo '<p style="color: red; text-align: end; font-size: 1.4rem;">Fill out all fields.</p>';
            } else if ($_GET["error"] == "wronglogin") {
              echo '<p style="color: red; text-align: end; font-size: 1.4rem;">Incorrect login information.</p>';
            } else if ($_GET["error"] == "sessionfail") {
              echo '<p style="color: red; text-align: end; font-size: 1.4rem;">Logged out because of inactivity.</p>';
            } else if ($_GET["error"] == "nouid") {
              echo '<p style="color: red; text-align: end; font-size: 1.4rem;">Customer does not exist!</p>';
            }
          }
          ?>
        </div>
      </div>
    </form>
  </div>
</body>
</html>