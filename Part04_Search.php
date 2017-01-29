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

    <link href="style.css" type="text/css" rel="stylesheet" />

</head>

<body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(function() {

            $('input[type="radio"]').click(function() {
                
                $(this).prop("checked","checked")
                
                $('.validationMsg').addClass('hide')
                
                $('.filter').remove();
                
                if ($(this).val() !== "all") {

                    $('#radio' + $(this).val()).append($('<input>', {
                        type: 'text',
                        class: "form-control col-md-6 filter",
                        placeholder: $(this).val(),
                        id: $(this).val()

                    }));
                    if ($("#hiddenTitle").val() != "") {

                        $('#searchTitle').val($("#hiddenTitle").val());
                        $('#Title').val($("#hiddenTitle").val());
                        $("#hiddenTitle").val("");
                        $('#searchForm').submit();
                    }
                }
            })

           
            $('#searchForm').submit(function() {

                var data = {
                    filterType: "",
                    filterValue: ""
                };
                $('#ajaxdata').empty();
                if (!$("input[name='filter']").is(':checked')) {
                    
                    $('.validationMsg').removeClass('hide').text("Please select the filter type");
                    return false;
                }
                var filterType = $("input[type='radio'][name='filter']:checked").val();

                if ($("#" + filterType).val() == "") {

                    $('.validationMsg').removeClass('hide').text("Please enter the value ");
                    $('#' + filterType).addClass('alertText');
                    return false;
                }

                $('.validationMsg').addClass('hide');
                $('.validationMsg').removeClass('alertText');
                if (filterType != "all") {
                    
                    data.filterValue = $("#" + filterType).val();
                }
                data.filterType = filterType;
                
                $.ajax({ // this bit doesn't seem to do anything

                    url: 'searchProcess.php',
                    data: {
                        action: 'searchWorks',
                        data: data
                    },
                    type: 'POST',
                    success: function(data) {
                        
                        $('#ajaxdata').html(data);
                        $('#searchTitle').val("");
                    },
                    error: function(log) {
                        $('#ajaxdata').html('<div class="alert alert-danger"><strong>There was an error processing your request</strong></div>')
                        //console.log(log.message);
                    }
                });

                return false;
            });
        


        });
        
        
    </script>



    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle         navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Assign 3</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="default.php">Home</a>
                    </li>
                    <li><a href="about.php">About Us</a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenu1" role="button" aria-haspopup="true" aria-expanded="true">Pages <span class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="Part01_ArtistsDataList.php">Artist Data List(Part 1)</a>
                            </li>
                            <li><a href="Part02_SingleArtist.php?id=19">Single Artist (Part 2)</a>
                            </li>
                            <li><a href="Part03_SingleWork.php?id=394">Single Work (Part 3)</a>
                            </li>
                            <li><a href="Part04_Search.php">Search (Part 4)</a>
                            </li>
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
            </div>
            <!--/.nav-collapse -->

        </div>
    </nav>





    <div class="container">
        <div class="row">
            <div class="page-header">
                <h2> Search Result</h2>
            </div>
            <div class="container">
                <div class="row">

                    <div class="alert alert-danger hide validationMsg"></div>
                    <div class="jumbotron">
                        <form id="searchForm">
                            <div class="form-group">
                                <div id="radioTitle">
                                    <input type="radio" name="filter" value="Title" id="titleRadio"> Filter by Title
                                </div>

                            </div>
                            <div class="form-group">
                                <div id="radioDescription">
                                    <input type="radio" name="filter" value="Description"> Filter by Description
                                </div>

                            </div>
                            <div class="form-group">
                                <input type="radio" name="filter" value="all"> No filter(show all art works)
                            </div>



                            <button type="submit" class="btn btn-primary" id="filter">Filter</button>
                        </form>
                    </div>
                </div>
            </div>


            <input type="hidden" id="hiddenTitle" />
            <div id="ajaxdata"></div>

        </div>


        <?php if(isset($_POST[ 'title'])) { echo '<script type="text/javascript">
                 $(function(){

                      $("#hiddenTitle").val("'.$_POST[ 'title']. '");

                 $("#titleRadio").click(); 



                 })
                 </script>'; } ?>


    </div>
</body>

</html>