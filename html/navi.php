<?php
//because the header is not included in this file 

?>
<div id="sidenav" class="w-60 z-40 hidden shadow-md bg-slate-800 px-1 absolute">
        <ul class="relative mt-24">
     
        <li class="relative">
            <a href="index.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out"  data-mdb-ripple="true" data-mdb-ripple-color="dark">
            <i class="fa-solid fa-house pr-4"></i>Home
            </a>
        </li>
        <li class="relative">
            <a href="photo.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out"  data-mdb-ripple="true" data-mdb-ripple-color="dark">
                 <i class="fa-solid fa-camera pr-4"> </i> Photo
            </a>
        </li>
        <li class="relative">
            <a href="video.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out"  data-mdb-ripple="true" data-mdb-ripple-color="dark">
            <i class="fa-solid fa-film pr-4"></i> Video
            </a>
        </li>
        <li class="relative">
            <a href="web.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out"  data-mdb-ripple="true" data-mdb-ripple-color="dark">
            <i class="fa-solid fa-code pr-4"></i>Web
            </a>
        </li>
		<?php
		if (isset($_SESSION["isloggedin"])){
			echo 
			'<li class="relative">
                <a href="customer-data.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="dark">
                <i class="fa-solid fa-file-zipper pr-4"></i> My Files
                </a>
            </li>
            
            
            <li class="relative">
            	<a href="html/logout.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="dark">
                <i class="fa-solid fa-right-from-bracket pr-4"></i> Logout
            	</a>
        	</li>';

		}
		else {
			echo'<li class="relative">
            <a href="customers.php" class="flex items-center text-m py-4 px-6 h-12 overflow-hidden text-white text-ellipsis whitespace-nowrap rounded hover:text-black hover:bg-blue-100 transition duration-300 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="dark">
                <i class="fa-solid fa-user-group pr-4"></i> Customer Login
            </a>
        </li>';

		}
       
         ?> 
        </ul>
</div>
