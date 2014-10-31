<!DOCTYPE html>
<html>
<head>
    <!-- <link rel="stylesheet" href="https://s3.amazonaws.com/codecademy-content/courses/ltp/css/bootstrap.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://rawgit.com/wenzhixin/bootstrap-table/master/dist/bootstrap-table.min.css">
<style>

    .stephen{
        background-color: #eee;
        /*margin-top: -10px;*/
        border-radius: 5px;
    }

    .content #grades{
        font-size: 14px;
        color: #00b0ff;
    }

    .content h1{
        font-size: 16px;
        padding-bottom:5px;
        margin-left: -10px;
        text-transform:uppercase;
    }

    .nav #title{
        /*font-size: 16px;*/
    }

    #allCourses{
        margin-bottom: -15px;
    }

    .navbar{
        border-radius: 0px;
        background-color: #E6E6E6;
        color: #5a5a5a;
        font-size: 11px;
        font-weight: bold;
        text-transform:uppercase;
        /*margin-bottom: 0px;*/
    }

    .navbar form{
        padding-top: 10px;
    }
    .navbar #title{
        font-size: 12px;
    }


    .active1 {
        background-color: #ddd;
    }
   /* .panel-heading{
        background-color: #ddd;
        color: #00b0ff;
    }
*/

    #students{
        margin-left: 10px;
    }
    </style>
</head>

<body>



<div class="nav">
    <div class="container">

    
    <!-- http://getbootstrap.com/components/#navbar-component-alignment -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <ul class="nav navbar-nav pull-left">
                <li id="title"><a href="#">Software Project</a></li>
                <li class="active1"><a href="#">Home</a></li>
                <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="visibleValue">Programs<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu" visibleTag="#visibleValue">
						<?php
							include("connect.php");
							
							$sql = "SELECT distinct pgmName from studentstats";
							$result = mysqli_query($db,$sql);
							while ( $row = mysqli_fetch_array($result))
							{
								echo "<li><a role=\"menuitem\" href=\"javascript:void(0)\" value=\"$row[0]\">$row[0]</a></li>";
							}
						?>
					</ul>
				</li>
            </ul>
        </div>    
    </nav>
    </div>
</div>

<div class="content">
    <div class="container">
    <!-- <h1>Students</h1> -->
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default">
                <div  class="panel-heading">Students</div>
                <div id="students">
                    <table id="student-table-javascript"></table>
                </div>
                </ul>
            </div>
        </div>
        <div class="col-md-5">
            <div id="gradeContent">
                <div class="panel panel-default">
                    <div class="panel-heading">Grades</div>
                    <table id="grade-table-javascript"></table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
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
                    <table class="table">
                      <tr>
                        <td>Jill</td>
                        <td>Smith</td>
                        <td>50</td>
                      </tr>
                      <tr>
                        <td>Eve</td>
                        <td>Jackson</td>
                        <td>94</td>
                      </tr>
                      <tr>
                        <td>Jill</td>
                        <td>Smith</td>
                        <td>50</td>
                      </tr>
                      <tr>
                        <td>Eve</td>
                        <td>Jackson</td>
                        <td>94</td>
                      </tr>        
                       <!--  <tfoot>
                            <span class="btn btn-success btn-md center pull-right"><i class="glyphicon"></i>Assign </span>
                            <span class="btn btn-primary btn-md pull-right"><i class="glyphicon glyphicon-envelope"></i> Email</span>
                        </tfoot> -->
                    </table>
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

<script src="js/GradePage.js"></script>

<script src="js/Menu.js"></script>

<script>

    $(document).ready(function(){
        // init page for viewing grades  
        //MODULE.Menu.init();


        //courseNumber , courseName, grade , aLevel
        
        var gradePage = MODULE.GradePage.init();
        $('#course-tabs a').click(function (e) {
          e.preventDefault()
          $(this).tab('show')
        })

    });

</script>

<script type="text/javascript">
	$(function(){
		$('.dropdown-menu a').click(function(){
			var visible = $(this).parents('ul').attr('visibleTag');
			$(visible).html($(this).attr('value'));
			
			var programName = $(this).html();
			$.ajax({
				type: 'post',
				url: 'selectStudents.php',
				data: { name: programName},
				success: function(data){
					console.log("success")
				}
			});
			
		});
	});
</script>

</body>
</html>
