<?php
require_once("html/configuration.php");
require_once("admin/includes/dbh.inc.php");

//query to select all articles type video
$sql = "SELECT * FROM `articles` WHERE `category` = 'video'";
//connect to db and hand over order
$resultD = mysqli_query($conn, $sql);
//fetch all user data in arrays, last one first
$row = array_reverse(mysqli_fetch_all($resultD, MYSQLI_ASSOC));
?>


<!DOCTYPE html>
<html lang="en">
<?php require_once("html/head.php"); ?>

<body>
    <!--sidenav start-->
    <?php
    require_once("html/navi.php");
    ?>
    <div class="z-50 fixed top-0 left-0 px-4 py-3" onclick="openNav(event)" id="bars"><i class="fa-solid fa-bars icon-main"></i></div>
    <div class="z-50 fixed top-0 left-0 px-4 py-3 hidden" onclick="openNav(event)" id="close"><i class="fa-solid fa-x icon-main"></i></div>

    <!-- component -->
    <div class="container my-16 mx-auto px-4 md:px-12">
        <div class="flex flex-wrap -mx-1 lg:-mx-4">
            <?php if (count($row) > 0) { ?>
                <?php foreach ($row as $oneRow) { ?>
                    <!-- Column -->
                    <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">
                        <!-- Article -->
                        <article class="overflow-hidden rounded-lg shadow-lg bg-white">
                            <img alt="articleimage" class="block h-72 object-cover w-full" src="<?php echo IMAGE_FOLDER . '/' . $oneRow['image'] ?>" data-caption="<?php echo $oneRow['title'] ?>">
                            <header class="flex items-center justify-between p-2 md:p-4">
                                <h1 class="text-2xl text-black ">
                                    <?php echo $oneRow['title'] ?>
                                </h1>
                                <p class="text-grey-darker text-lg">
                                    <i class="fa-solid fa-film"></i>
                                </p>
                            </header>
                            <footer class="no-underline text-grey-darker text-md p-2 md:p-4">
                                <?php echo $oneRow['description'] ?>
                            </footer>
                        </article>
                        <!-- END Article -->
                    </div>
                <?php } ?>
            <?php } else {
                echo '<div class="absolute left-1/2 top-1/2 transform -translate-x-2/4 -translate-y-2/4">
                    <p class="text-white text-2xl "> <i class="fa-regular fa-folder-open pr-4"></i>No articles yet.</p>
                    </div>';
            } ?>
            <!-- END Column -->
        </div>
    </div>
</body>

</html>