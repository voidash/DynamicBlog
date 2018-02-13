<?php
function description($MainBody){
  //for description. we need to get first 40 words for that lets use wordwarp which is awsome by the way
  //working functionality of wordwarp goes like this
  //splits the text in multiple lines
  $maximum_words = 500;
  $mp = $maximum_words;

  $flag = True;
  $flyer="";
  $count = $maximum_words;

  while($flag){
    $count++;

    $flyer = substr($MainBody,$mp,$count);
    $mp++;

    if($flyer = "."){
      $flag = False;

    }
  }
  $Word = substr($MainBody,0,$count);
  return $Word;


}
$MainTag = strtolower($_POST["mainTag"]);
$NodeTag = strtolower($_POST["nodeTag"]);

$Title = $_POST["title"];
$content = $_POST["content"];
$otherTags=$_POST["tags"];


$url_title= strtolower($Title);
//converting the title to array . first seperating the whitespaces
$urlArray = explode(" ",$url_title);
$SplitArray =""; //this is url form of title . FOR SEO
foreach ($urlArray as $x) {

  $SplitArray =$SplitArray ."-" .$x;


}
$SplitArray = substr($SplitArray,1,strlen($SplitArray));









$FolderHolder = '../'.$MainTag.'/'.$NodeTag.'/'; //create a Folder according to tag for good possible Access


if(file_exists($FolderHolder)){
  //to check whether this folder exists or Not
  chdir($FolderHolder);

}else{
  $Holder = '../'.$MainTag.'/';

  if(file_exists($Holder)){
    //if mainTag exists then just create node tag
    chdir($Holder);
    mkdir($NodeTag.'/');
    chdir($FolderHolder);
  }else{
    //if nothing exists then create everything and get into that folder to store important things

    mkdir($Holder);
    chdir($Holder);
    mkdir($NodeTag.'/');
    chdir($FolderHolder);


  }
}


//create an file for blog
mkdir($SplitArray."/");
chdir($SplitArray."/");

$MainBlogFile = fopen("index.php",'w');
$indexFile = '<?php
chdir($_SERVER["DOCUMENT_ROOT"]);
chdir("mainContents");
echo"<head>";
ob_start();
include "header.php";
$buffer = ob_get_contents();
ob_end_clean();

$title = "'.$url_title.'";
$buffer = preg_replace("/(<title>)(.*?)(<\/title>)/i", "$1" . $title . "$3", $buffer);
echo $buffer;
echo \'<meta name= "keyword"  description="'.$MainTag.','.$NodeTag.','.$otherTags.'"/>'.'\';
echo "</head><body><br/><br/>";

include "navBar.php";
echo\'<div class="w3-container">'.$content.'</div>\';
include "footer.php";
echo"</body></html>";
?>';
fwrite($MainBlogFile,$indexFile);
fclose($MainBlogFile);

//for image upload
$UploadIndex= 0; //for number of uploaded images

echo count($_FILES['file']['name']);

for($i=0; $i< count($_FILES['file']['name']);$i++){
  $validextensions = array("jpeg","jpg","png");
  $UploadIndex += $UploadIndex;
  $ext = explode('.', basename($_FILES['file']['name'][$i]));//explode file name from dot(.)
  $file_extension = end($ext);

  if(($_FILES["file"]["size"][$i] < 1000*1024) && in_array($file_extension,$validextensions)) {
    move_uploaded_file($_FILES['file']['tmp_name'][$i],basename($_FILES['file']['name'][$i]));
 echo" images";

  }else{
    echo" error occured during uploading a image";

  }

}


//pushing xml into its place
chdir($_SERVER['DOCUMENT_ROOT']);
/*
<blog tag= "arduino , China, vague,  content">
<title>Arduino</title>
<image>arduino.png</image>
<description>some generic description</description>
<href>../ss/this.html</href>
</blog>
*/

$xml_adder='<blog tag="'.$MainTag.','.$NodeTag.'">
<title>'.$Title.'</title>
<image>'.$FolderHolder.$SplitArray."/".'indexImage.jpg</image>
<description>'.description($content).".....".'</description>
<href>'.$FolderHolder.$SplitArray."/".'</href></blog>






</blogpost>';
$xml_file = fopen('posts.xml','c');
fseek($xml_file, -15,SEEK_END);
fwrite($xml_file,$xml_adder);
fclose($xml_file);

?>
