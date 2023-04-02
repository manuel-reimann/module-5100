<?php
require_once("admin/includes/dbh.inc.php");
require_once("html/configuration.php");
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

  <a href="photo.php" aria-label="Direct link to photography offers">
    <div class="fixed md:top-0 bottom-0  md:right-0 right-25 px-4 py-3"><i class="fa-solid fa-camera icon-main"></i></div>
  </a>

  <div class="fixed top-2/4 left-2/4 transform -translate-x-2/4 -translate-y-2/4 text-7xl lg:text-9xl">
    <h1>pixlify</h1>
  </div>

  <a href="video.php" aria-label="Direct link to video offers">
    <div class="fixed bottom-0 md:left-0 left-2/4 transform -translate-x-2/4 md:translate-x-0 px-4 py-3"><i class="fa-solid fa-film icon-main"></i></div>
  </a>

  <a href="web.php" aria-label="Direct link to web offers">
    <div class="fixed bottom-0 right-0 px-4 py-3"><i class="fa-solid fa-code icon-main"></i></i></div>
  </a>

</body>

</html>