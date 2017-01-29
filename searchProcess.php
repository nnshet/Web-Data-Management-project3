<!-- Student Name: Shet,Neha Nilcant and Project Name: Project#3  and Due date: Sunday November 20

Database details:

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "art";
-->
<?php

if(isset($_POST['action']) && function_exists($_POST['action'])) {
    $action = $_POST['action'];
    $data = $_POST['data'];
    echo $action($data);
}
 function highlight($text, $words) {
    preg_match_all('~\w+~', $words, $m);
    return preg_replace("/\w*?".implode($m[0])."\w*/i", '<span style="background-color: #FFFF00">$0</span>', $text);
}
function searchWorks($data) {
    
  //  echo $data['filterType'];
    
    $filterType = $data['filterType'];
    $filterValue = $data['filterValue'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "art";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo '<div class="alert alert-danger"><strong>There was an error connecting to database. Please try again later.
</strong></div>';
    } 
    if($filterType == "all") {
        $sql = "SELECT * FROM artworks";
    } else {
        $sql = "SELECT * FROM artworks WHERE $filterType LIKE '%$filterValue%'";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
        
            if($filterType == "Description") {
                
                $description =  highlight($row["Description"], $filterValue);
            } else {
                
                $description = $row["Description"];
            }
            echo '<div class="row"><div class="col-md-2 thumbnail"><a href="Part03_SingleWork.php?id='.$row["ArtWorkID"].'"><img src="images/art/works/square-medium/'.$row["ImageFileName"].'.jpg"></img></a></div><div class="col-md-8"><a href="Part03_SingleWork.php?id='.$row["ArtWorkID"].'">'.utf8_encode($row["Title"]).'</a><p>'.utf8_encode($description).'</p></div></div><br/>';
        }
    } else {
        echo '<div class="alert alert-danger"><strong>No Result found for the '.$filterType.' = '.$filterValue.
'.</div>';
    }
    echo "</div>";
    $conn->close();

}

?>