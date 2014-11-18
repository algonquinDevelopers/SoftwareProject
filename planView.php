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

    <style type="text/css">
    #plans{
       padding-left: 20px; 
    }
    </style>

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
                    <li><a href="planView.html">View All Plans</a></li>
					</li>

				</ul>
                <ul class="nav navbar-nav pull-right">
                </ul>
			</div>    
		</nav>


    </div>
</div>

<div class="content">
    <div class="container">
    <!-- <h1>Students</h1> -->
    <div class="row">
        <div class="col-md-6">
            <div id="plans"></div>    
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
        
        makeTables();      
        function makeTables(){
            $.ajax({
            type: "GET",
            url: 'selectPlan.php',
            dataType: 'json',
            // get request for student name
            success: function(data){
                var prev_name;
               data.forEach(function(element){
                // console.log(element.student_name);
                if(prev_name !==  element.student_name){
                    console.log(prev_name);
                    var dividerHtml = '<br>';
                    // $('#plans').append(dividerHtml);
                    $('#plans').append('<h3 style="padding-top: 20px; border-top: 1px solid #ccc;">' + element.student_name + '</h3>');

                }
                $('#plans').append('<p>' + element.course_no + ' ' + element.course_name + '</p>');
                prev_name = element.student_name;
               }) 
            }
        });
        }          

 
    });

</script>

</body>
</html>
