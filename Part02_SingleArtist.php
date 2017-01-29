<!DOCTYPE html>
<!-- Student Name: Shet,Neha Nilcant and Project Name: Project#3  and Due date: Sunday November 20

Database details:

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "art";
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>COMP5335-Assign#3 </title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
      
      <link href="style.css" type="text/css" rel ="stylesheet" />
  </head>
  <body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
      
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Assign 3</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="default.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li class="dropdown">
              <a  class="dropdown-toggle"  data-toggle="dropdown" id="dropdownMenu1" role="button" aria-haspopup="true" aria-expanded="true">Pages <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="Part01_ArtistsDataList.php">Artist Data List(Part 1)</a></li>
                <li><a href="Part02_SingleArtist.php?id=19">Single Artist (Part 2)</a></li>
                <li><a href="Part03_SingleWork.php?id=394">Single Work (Part 3)</a></li>
                <li><a href="Part04_Search.php">Search (Part 4)</a></li>
              </ul>
            </li>
          </ul>
            <form class="navbar-form navbar-right" method="POST" action="Part04_Search.php">
                        
                    
                        <input type="search" placeholder="Search Paintings" id="searchTitle" name="title" class="form-control">

                        <button class="btn btn-primary" id="search">Search</button>
                    </form>
            
            <ul class="nav navbar-nav navbar-right">
                <li><a> Neha Shet </a></li>
            </ul>
        </div><!--/.nav-collapse -->
           
      </div>
    </nav>
    <div class="container">
        +
        
        
        
        
        
      
      
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "art";
//echo $_GET["id"]
    $artistId = $_GET["id"];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    header("Location: error.php?error=1");
} 

$sql = "SELECT * FROM artists where artists.ArtistID=' ". $artistId. " '";
 $sql_get = "SELECT * from artworks where artworks.ArtistID=' ". $artistId. " '";     
$result = $conn->query($sql);
$result2 = $conn->query($sql_get);
      
   
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo  '<div class="row"> 
                <div class="col-md-4">
                    <h2>'.utf8_encode($row["FirstName"]).' '.utf8_encode($row["LastName"]).'</h2>
                    <img src="images/art/artists/medium/'.$artistId.'.jpg" class="img-thumbnail"/> 
                    <h3>Art By '.utf8_encode($row["FirstName"]).' '.utf8_encode($row["LastName"]).'</h3>
                </div>
            <div class="col-md-6"><br><br><br>
                <div class="row">
                    <p>'.utf8_encode($row['Details']).'</p>
                </div>
                <div class="row">
                    <button class="btn btn-default changeColor"><span class="glyphicon glyphicon-heart"></span>&nbsp;Add to Favorites List</button>
                </div><br><br>
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">Artist Details</div>
                                <table class="table">
                            
                                    <tr>
                                        <td>Date: </td>
                                        <td>'.$row['YearOfBirth'].'-'.$row['YearOfDeath'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Nationality: </td>
                                        <td>'.$row['Nationality'].'</td>
                                    </tr>
                                    <tr>
                                        <td>More Info: </td>
                                        <td><a href="'.$row['ArtistLink'].'" target="_blank">'.$row['ArtistLink'].'</td>
                                    </tr>
                                </table>
                        
                    </div>
                </div>
            </div>
            </div>';
    }
    
            echo '<div class="row">';
        if ($result2->num_rows > 0) {
            while($rowsResult = $result2->fetch_assoc()) {
                
            /*
            SELECT * FROM `artworks` INNER JOIN `artists` ON artworks.ArtistID = artists.ArtistID where artworks.ArtWorkID = 1
            */
        echo '<div class="col-sm-6 col-md-3">
                <div class="thumbnail thumbnailImg">
                    <a href="Part03_SingleWork.php?id='.$rowsResult["ArtWorkID"].'">
                        <img src="images/art/works/square-medium/'.$rowsResult['ImageFileName'].'.jpg" class="img-thumbnail" />   
                    </a> 
                    
                    <div class="caption text-center">
                    
                        <h6><a href="Part03_SingleWork.php?id='.$rowsResult["ArtWorkID"].'" >'.utf8_encode($rowsResult['Title']).', '.$rowsResult['YearOfWork'].'</a></h6>
                     <a class="btn btn-primary" href="Part03_SingleWork.php?id='.$rowsResult["ArtWorkID"].'"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;View</a>&nbsp;<button class="btn btn-success"><span class="glyphicon glyphicon-gift"></span>&nbsp;Wish</button>&nbsp;<button class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Cart</button></span>
                 </div>
            </div>
        </div>';
                
                
                //echo $rowsResult['ArtistID'];
            }
        } else {
            
            #echo "No details found for work";
        }
    echo '</div>';
    echo '</div>';
} else {
    
    header("Location: error.php");
}
$conn->close();
?>
      
      
      </div>
  </body>
</html>