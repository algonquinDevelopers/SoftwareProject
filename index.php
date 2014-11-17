<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://rawgit.com/wenzhixin/bootstrap-table/master/dist/bootstrap-table.min.css">
    <!-- <link rel="stylesheet" href="http://bootswatch.com/cosmo/bootstrap.min.css"> -->
    <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/cosmo/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>

<div class="nav">
    <div class="container">
    <!-- http://getbootstrap.com/components/#navbar-component-alignment -->
		<nav class="navbar navbar-inverse" role="navigation">
			<div class="container-fluid">
				<ul class="nav navbar-nav pull-left">
					<li class="navbar-brand-sm"><a href="#">Software Project</a></li>
					<li class="active"><a href="index.php">Home</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="visibleValue">Programs<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" visibleTag="#visibleValue">
							<?php include("dropDown.php"); ?>
						</ul>
					</li>


				</ul>
                <ul class="nav navbar-nav pull-right">
                    <li><a href="" data-toggle="modal" data-target=".bs-upload-modal-sm">Upload</a></li>
                </ul>

<!--                 <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                      <input type="text" id="search" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form> -->
			</div>    
		</nav>

<!-- MODEL CONTENT -->
        <div class="modal fade bs-upload-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    Upload your file
                </div>
                <div class="modal-body">
                    select your .csv data file to update to the database
                    <input type="file" id="fileLoader" name="files" title="Load File" style="display:none;"/>
                     <button type="load" class="btn btn-sm" onclick="openfileDialog();">Upload</button>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
    <!-- <h1>Students</h1> -->
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default">
                <div  class="panel-heading">
                    Students
                    <!-- <button type="submit" class="btn btn-sm pull-right" id="st-format"><span class="glyphicon glyphicon glyphicon-list-alt icon-list-alt "></span></button> -->
                    <input type="text" name="searchInput" id="searchInput" placeholder="search students" onkeyup="searchStudent();" />
                </div>
                <div id="students">
                    <table id="student-table-javascript" data-card-view="false"></table>
                </div>
            </div>
        </div>
        <div class="col-md-5 nopadding">
            <div id="gradeContent">
                <div class="panel panel-default">
                    <div class="panel-heading">Grades</div>
                    <table id="grade-table-javascript"></table>
                </div>
            </div>
        <div>
            <!-- <p> search for izglu to see it work with F</p> -->
        </div>
        </div>
        <div class="col-md-5 nopadding">
            <div class="panel panel-default">

                <!-- maybe change id to c -->
                <ul class="nav nav-tabs" role="tablist" id="course-tabs">
                  <li class="active"><a href="#course" role="tab" data-toggle="tab">Course</a></li>
                  <li><a href="#plan" role="tab" data-toggle="tab">Plan</a></li>
                </ul>

                <div class="tab-content">
                  <div class="tab-pane active" id="course">

                    <table id="course-table-javascript">

                    </table>
                <nav>
                    <ul class="pagination">
                        <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                        <li><a href="#" class="plink">1</a></li>
                        <li><a href="#" class="plink">2</a></li>
                        <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
                      </ul>
                    </nav> 
                  </div>
                  <div class="tab-pane" id="plan">
                        <table id="history-table"></table>
                  </div>
                </div>
      
          </div>

        </div>
    </div>

    </div>
</div>


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.1/jquery.slimscroll.min.js"></script>
<script src="https://rawgit.com/wenzhixin/bootstrap-table/master/dist/bootstrap-table.min.js"></script>

<script src="js/createTable.js"></script>
<script src="js/GradePage.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        // init page for viewing grades  
          

        MODULE.GradePage.init();
        

        $('#course-tabs a').click(function (e) {
          e.preventDefault();
          $(this).tab('show');
        });


        // $("#st-format").click(function(){
        //     console.log('click');
            
    });
    //http://jsfiddle.net/taditdash/9Fh4c/
    function openfileDialog() {
        $("#fileLoader").click();
    }

    // function searchStudent() {
    //     var selectLimit = 300;
    //     var searchInput = document.getElementById("searchInput").value;

    //     $.ajax({
    //         type: "GET",
    //         url: 'searchStudents.php',
    //         dataType: 'json',
    //         data: {search: searchInput, limit: selectLimit},
    //         success: function(data){
    //             $('#student-table-javascript').bootstrapTable('load', data);

    //         },
    //         error:function(textStatus, errorThrown){
    //             // console.log("error");
    //             console.log(errorThrown);
    //         }
    //     });
    // }

</script>

</body>
</html>
