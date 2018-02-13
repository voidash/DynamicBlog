<?php

chdir("mainContents");
echo"<head>";
ob_start();
include "header.php";
$buffer = ob_get_contents();
ob_end_clean();

$title = "Welcome to best site in the world";
$buffer = preg_replace("/(<title>)(.*?)(<\/title>)/i", "$1" . $title . "$3", $buffer);
echo $buffer;
include "navBar.php";
chdir($_SERVER["DOCUMENT_ROOT"]);
include "body.php";
echo"<br/>";
echo"<br/>";
echo"<br/>";
echo"<br/>";
chdir("mainContents");
include "footer.php";
echo"</body></html>";
?>
