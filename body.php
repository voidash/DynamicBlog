<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<?php
//this is perfect usage of xml parser to show all the blog post
//xml defination and how it can be used + some ideas about xml to placed in project folder

$perPageElement= 10;  //user fixable . to show the number of blog post per per page
$xml = simplexml_load_file("posts.xml") or die("object couldn't be created");
$totalBlogs =  $xml -> count();  //to count the number of children in element
$TotalPagination =  $totalBlogs < $perPageElement ? 1 : floor($totalBlogs / $perPageElement) +1;  // 1 2 3 4 Next pagination Rule


$pageNumber = isset($_GET['page']); //get the page from pagination
$pageNumber = basename($pageNumber);
//if there is no input for page number
if($pageNumber ==""){
  $pageNumber=1;
}
//if someone tries to mess up with url


if($pageNumber > $TotalPagination){
  $pageNumber = 1;
}

$startPage = $pageNumber == 1  ? 0 : ($pageNumber-1) * $perPageElement; //for the startpage
$endPage =  $startPage + $perPageElement;// for  the end page



//Now comes the real part of showing the blog content
$endpage = $endPage > $totalBlogs ? $totalBlogs : $endPage;
 //suppose $totalBlogs = 23 and $endpage = 30 then $endpage = $totalBlogs

 echo $startPage;
echo $endpage;

for ($i=$startPage; $i < $endpage ; $i++) {

   $BlogPostHTMLelements = '<div class="w3-container">
     <div class="w3-panel w3-card-4 ">
       <header>
     <span class="title">
       <h3>'.$xml->blog[$i]->title.'</h3>
     </span>

   </header>

   <div class ="w3-container" style="width:75%">
     <span class="description">'.$xml->blog[$i]->description.' </span>

     </div><img src="'.$xml->blog[$i]->image.'" class="img-right" style="float:right;width:25%;" />
   <div class="w3-container">
   <a href="'.$xml->blog[$i]->href.'" class="w3-button w3-padding-large w3-border"> read More</a>

   </div>
   <footer>

     <span class="tags">'.$xml->blog[$i]["tag"]. '

     </span>

   </footer></div>

   </div>';
echo $BlogPostHTMLelements;



}

$paginationCounter0= '<div class="w3-center">
<div class="w3-bar w3-border w3-round">';
echo $paginationCounter0;

for($p=1; $p <=$TotalPagination; $p++) {
echo '<a href="body.php?page='.$p.'" class="w3-bar-item w3-button">'.$p.'</a> '; //to be changed
}
echo '<div/><div/>'; //creates a pagination










?>
