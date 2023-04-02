<div id="sidenav" class="w-60 z-40 hidden shadow-md bg-slate-800 px-1 absolute">
        <ul class="relative mt-24">
     
        <li class="relative">
            <a href="dashboard.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out"  data-mdb-ripple="true" data-mdb-ripple-color="dark">
            <i class="fa-solid fa-table-columns pr-4"></i> Dashboard
            </a>
        </li>
        <li class="relative">
            <a href="articles.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out"  data-mdb-ripple="true" data-mdb-ripple-color="dark">
            <i class="fa-regular fa-newspaper pr-4"></i> Articles
            </a>
        </li>
         <!-- restrict acess for Teammembers-->
         <?php 
         if (isset($_SESSION["isloggedin"])){
         if ( $_SESSION["uType"] != 1 ) { //show nothing
            }
            
            else {
            ?>
        <li class="relative">
            <a href="users.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out"  data-mdb-ripple="true" data-mdb-ripple-color="dark">
            <i class="fa-solid fa-user pr-4"></i> Users
            </a>
        </li>
         <!-- end access denied-->
         <?php
            }
        }
            ?>
            
        <li class="relative">
            <a href="customer-admin.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out"  data-mdb-ripple="true" data-mdb-ripple-color="dark">
            <i class="fa-solid fa-user-group pr-4"></i> Customer Data
            </a>
        </li>
      
		<?php
		if (isset($_SESSION["isloggedin"])){
			echo 
			'<li class="relative">
            	<a href="includes/logout.inc.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="dark">
                <i class="fa-solid fa-right-from-bracket pr-4"></i> Logout
            	</a>
        	</li>';

		}
		else {
			echo'<li class="relative">
            <a href="admin.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="dark">
            <i class="fa-solid fa-lock pr-4"></i> Admin Login
            </a>
        </li>';

		}
       
         ?> 
        </ul>
</div>
