<head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>







<?php
chdir("mainContents");
echo"<head>";
ob_start();
include "header.php";
$buffer = ob_get_contents();
ob_end_clean();



$xmlDoc=new DOMDocument();
$xmlDoc->load("../posts.xml");

$x=$xmlDoc->getElementsByTagName('blog');


$q=$_GET["search"];
$title = $q;

$buffer = preg_replace("/(<title>)(.*?)(<\/title>)/i", "$1" . $title . "$3", $buffer);
echo $buffer;

include "navBar.php";
chdir($_SERVER["DOCUMENT_ROOT"]);

//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $hint="";
  for($i=0; $i<($x->length); $i++) {
    $title=$x->item($i)->getElementsByTagName('title');
    $url=$x->item($i)->getElementsByTagName('href');
    $image= $x->item($i)->getElementsByTagName('image');
    $desc= $x->item($i)->getElementsByTagName('description');
    if ($title->item(0)->nodeType==1) {

      if (stristr($title->item(0)->childNodes->item(0)->nodeValue,$q)) {
        if ($hint=="") {
          //$z->item(0)->childNodes->item(0)->nodeValue .
        $hint = '<div class="w3-container">
          <div class="w3-panel w3-card-4 ">
            <header>
          <span class="title">
            <h3>'.$title->item(0)->childNodes->item(0)->nodeValue.'</h3>
          </span>
          </header>

          <div class ="w3-container"  >

            <span style="width:70%;float:left;" class="description w3-bar-item">'.$desc->item(0)->childNodes->item(0)->nodeValue.' </span>


                        <img style="width:25%;" src="'.$image->item(0)->childNodes->item(0)->nodeValue.'" class="w3-right w3-bar-item"  />
                      <div class="w3-container ">
                      <a href="'.$url->item(0)->childNodes->item(0)->nodeValue.'" class="w3-button w3-padding-large w3-border"> read more</a>

                      </div>
                      </div>
<div style="height:10px;"></div>
                      </div>';
        } else {
          $hint=$hint . '<div class="w3-container">
            <div class="w3-panel w3-card-4 ">
              <header>
            <span class="title">
              <h3>'.$title->item(0)->childNodes->item(0)->nodeValue.'</h3>
            </span>
            </header>

            <div class ="w3-container" style="width:75%">
              <span class="description">'.$desc->item(0)->childNodes->item(0)->nodeValue.' </span>


                          </div><img src="'.$image->item(0)->childNodes->item(0)->nodeValue.'" class="img-right" style="float:right;width:25%;top:50px;" />
                        <div class="w3-container">
                        <a href="'.$url->item(0)->childNodes->item(0)->nodeValue.'" class="w3-button w3-padding-large w3-border"> read more</a>

                        </div>
                        </div>
</div>
                        </div>';
        }
      }
    }
  }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint=="") {
  $response="no suggestion";
} else {
  $response=$hint;
}

//output the response
echo $response;



echo"<br/>";
echo"<br/>";
echo"<br/>";
echo"<br/>";
chdir("mainContents");
include "footer.php";
echo"</body></html>";


?>
