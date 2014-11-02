<!DOCTYPE html>
<html>
<head>
    <!-- <link rel="stylesheet" href="https://s3.amazonaws.com/codecademy-content/courses/ltp/css/bootstrap.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://rawgit.com/wenzhixin/bootstrap-table/master/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>

<div class="nav">
    <div class="container">
    <!-- http://getbootstrap.com/components/#navbar-component-alignment -->
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<ul class="nav navbar-nav pull-left">
					<li id="title"><a href="#">Software Project</a></li>
					<li class="active"><a href="index.php">Home</a></li>
                    <li><a href="email-page.html">Email</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="visibleValue">Programs<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" visibleTag="#visibleValue">
							<?php include("dropDown.php"); ?>
						</ul>
					</li>

				</ul>
<!--                 <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                      <input type="text" id="search" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form> -->
			</div>    
		</nav>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
    <!-- <h1>Students</h1> -->
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default">
                <div  class="panel-heading">Students</div>
                <div id="students">
                    <table id="student-table-javascript"></table>
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
            <p> search for izglu to see it work with F</p>
        </div>
        </div>
        <div class="col-md-5 nopadding">
            <div class="panel panel-default">

                <!-- maybe change id to c -->
                <ul class="nav nav-tabs" role="tablist" id="course-tabs">
                  <li class="active"><a href="#course" role="tab" data-toggle="tab">Course</a></li>
                  <li><a href="#history" role="tab" data-toggle="tab">History</a></li>
                </ul>

                <div class="tab-content">
                  <div class="tab-pane active" id="course">

                    <table id="course-table-javascript">
                    </table>

                  </div>
                  <div class="tab-pane" id="history">
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



    });


</script>

</body>
</html>
