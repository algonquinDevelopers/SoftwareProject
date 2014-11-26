<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
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
		<nav class="navbar navbar-inverse" role="navigation">
			<div class="container-fluid">
				<ul class="nav navbar-nav pull-left">
					<li class="navbar-brand-sm"><a href="#">Software Project</a></li>
					<li ><a href="index.php">Home</a></li>
                    <li class="active"><a href="planView.html">View All Plans</a></li>
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
			   </div> 
                <h2 class="pull-right"><a href="export.php">Save to PDF</a></h2>
				<div id="plans">
				<h2> Plans for next semester</h2>
				<?php
	            include("connect.php");

	            $query = "SELECT DISTINCT s.student_name, pl.student_no, pl.course_no, c.course_name, p.program_name
	                    from student s, course c, plan pl, program p
	                    where  pl.student_no = s.student_no 
	                    and pl.course_no = c.course_no
	                    and s.program_no = p.program_no
	                    order by s.student_name
	                    LIMIT 1000";

					if ($stmt = $db->prepare($query)) {
					    $stmt->execute();
					}

					$result = $stmt->get_result();

		            $prev_name = '';
		            while($r = $result->fetch_assoc()) {
		                if($r['student_name'] != $prev_name){
		                    echo '<h3 style="padding-top: 20px; border-top: 1px solid #ccc;">' . $r['student_name'] .'</h3>';
		                    echo '<h4>Program Name: '. $r['program_name'] .'</h4>';
		                    echo '<h4>Student Number: '. $r['student_no'] .'</h4>';
		                }
		                echo '<p>'. $r['course_no'] .' '. $r['course_name'] .'</p>';
		                $prev_name = $r['student_name'];
		            }
				?>
				</div>    
			</div>
			<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
			<!-- // <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.js"></script> -->
	</div>
</div>
</body>
</html>
