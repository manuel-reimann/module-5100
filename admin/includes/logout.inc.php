<?php
//unset sessions and logout Admin / Teammember
session_start();
session_unset();
session_destroy();
header("location: ../admin.php");