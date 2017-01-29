<!-- Student Name: Shet,Neha Nilcant and Project Name: Project#3  and Due date: Sunday November 20

Database details:

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "art";
-->
      <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>COMP5335-Assign#3 </title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
      
      <link href="style.css" type="text/css" rel ="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
      
        $(function () {
            $('[data-toggle="modal"]').click(function(){
                
                //alert("here")
               // var imageLoad = "<img src=''/>";
                $('#imgModal img').attr('src',$(this).children('img').attr('src'));
                var displayText = $(this).attr('data-Title')+" by "+ $(this).attr('data-lastName');
            //    $(this).text();
               $('.modal-title').text(displayText)
                //console.log($(this).children('img').attr('src'));
                //modal-title
                var myModel = $('#myModal');
                myModel.modal('show');
            })
        })
      
      </script>
      
      
      
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
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "art";
    $artistId = $_GET["id"];
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    header("Location: error.php?error=1");
} 

$sql = "SELECT * FROM `artworks` JOIN `artists` ON artworks.ArtistID = artists.ArtistID where artworks.ArtWorkID =".$artistId;
$sqlGetGenre = "SELECT GenreName FROM `genres` WHERE GenreID IN (SELECT GenreID from `artworkgenres` where ArtWorkID = ".$artistId.")";  
$sqlGetSubject = "SELECT SubjectName FROM `subjects` WHERE SubjectID IN (SELECT SubjectID from `artworksubjects` where ArtWorkID = ".$artistId.")";  
$sqlGetOrder = "SELECT DateCreated FROM `orders` WHERE OrderID IN (SELECT OrderID from `orderdetails` where ArtWorkID = ".$artistId.")";  
$result = $conn->query($sql);
$genreResult = $conn->query($sqlGetGenre);
$subjectResult = $conn->query($sqlGetSubject);
$orderResult = $conn->query($sqlGetOrder);
      
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo  '<div class="row"> 
                <div class="col-md-4">
                <div>    
                    <h3>'.$row["Title"].'</h3>
                    
                    <h4>By <a href="Part02_SingleArtist.php?id='.utf8_encode($row["ArtistID"]).'">'.utf8_encode($row["LastName"]).'</a></h4>
                </div>
                    <a data-toggle="modal" id="imgView" data-Title="'.utf8_encode($row["Title"]).'" data-lastName = "'.$row["LastName"].'">
                        <img src="images/art/works/medium/'.$row["ImageFileName"].'.jpg" class="img-thumbnail"/> 
                    </a>
                </div>
            <div class="col-md-6">
            <br><br><br><br>
                <div class="row">
                    <p class="text-justify">'.utf8_encode($row['Description']).'</p>
                </div>
                <div class="row">
                    <p class="textRed"><strong>$'.number_format($row["MSRP"],2,'.','').'</strong></p>
                </div>
                <div class="row">
                      <button class="btn btn-default changeColor"><span class="glyphicon glyphicon-gift"></span>&nbsp;Add to Wish List</button>
                      <button class="btn btn-default changeColor"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Add to Shopping Cart</button>
                </div><br><br>
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">Product Details</div>
                            
                                <table class="table">
                            
                                    <tr>
                                        <td>Date: </td>
                                        <td>'.$row['YearOfWork'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Medium: </td>
                                        <td>'.$row['Medium'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Dimensions: </td>
                                        <td>'.$row['Width'].'cm x '.$row['Height'].'cm</td>
                                    </tr>
                                    <tr>
                                        <td>Home: </td>
                                        <td>'.utf8_encode($row['OriginalHome']).'</td>
                                    </tr>
                                    <tr>
                                        <td>Genre: </td>
                                        <td>';
                                        if ($genreResult->num_rows > 0) {
                                            // output data of each row
                                            while($genreRow = $genreResult->fetch_assoc()) {
                                                    echo '<a>'.utf8_encode($genreRow['GenreName']).'</a><br/>';
                                            }
                                        } else {
                                            
                                            echo 'No details';
                                        }
                                    echo '</td></tr><tr>
                                        <td>Subject: </td>
                                        <td>';
                                        if ($subjectResult->num_rows > 0) {
                                            // output data of each row
                                            while($subjectRow = $subjectResult->fetch_assoc()) {
                                                    echo '<a>'.utf8_encode($subjectRow['SubjectName']).'</a><br/>';
                                            }
                                        } else {
                                            
                                            echo 'No details';
                                        }

                                echo '</table>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <br><br><br><br>
                <div>
                    <div class="panel panel-info">
                        <div class="panel-heading">Sales</div>
                            <div class="panel-body">';
                            
                                        if ($orderResult->num_rows > 0) {
                                            // output data of each row
                                            while($orderRow = $orderResult->fetch_assoc()) {
                                                /*date("d/m/Y", strtotime("2012-12-24 12:13:14")*/
                                                    echo '<p><a>'.date("m/d/Y", strtotime($orderRow['DateCreated'])).'</a></p>';
                                            }
                                        } else {
                                            
                                            echo 'No details';
                                        }
                            
                            echo '</div>
                        </div>
                    </div>
                    </div>
                    
            </div>
            </div>';
    }
    } else {
            header("Location:error.php");
        }
$conn->close();
?>
      </div>

  <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" id="imgModal">
          <img class="img-thumbnail">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>    
      </div>
  </body>
</html>