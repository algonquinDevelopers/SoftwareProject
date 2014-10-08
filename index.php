<!DOCTYPE html>
<html>
<head>
    <!-- <link rel="stylesheet" href="https://s3.amazonaws.com/codecademy-content/courses/ltp/css/bootstrap.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://rawgit.com/wenzhixin/bootstrap-table/master/dist/bootstrap-table.min.css">
<style>

    .content{
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
    /* this is for the course level selection*/
    #myPager{
        margin-top: 0px;
    }


    #studentList{
        width:10em;
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
    .panel-heading{
        background-color: #ddd;
        color: #00b0ff;
    }

    .search{
        width: 100px;
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
                <li><a href="#">Link</a></li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li><a href="#">Login</a></li>
                <li><a href="#">Help</a></li>
            </ul>
         <!--    <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form> -->

        </div>    
    </nav>
    </div>
</div>

<div class="content">
    <div class="container">
    <!-- <h1>Students</h1> -->
    <div class="row">
        <div class="col-md-3">
            <div class="panel">
                <div  class="panel-heading">Students</div>
                <div id="students">
                    <table id="student-table-javascript"></table>
                </div>
                </ul>
            </div>
        </div>
        <div class="col-md-5">
            <div id="gradeContent">
                <div class="panel">
                    <div class="panel-heading">Grades</div>
                    <table id="grade-table-javascript"></table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Courses</div>
                <!-- maybe change id to c -->
                <div id="allCourses">
                    <table id="table">
                        <thead>
                            <tr>
                                <th data-field="id">Item ID</th>
                                <th data-field="name">Item Name</th>
                                <th data-field="price">Item Price</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                        <ul class="pagination pagination-md pull-left"   id="myPager">
                              <li><a href="#">1</a></li>
                              <li><a href="#">2</a></li>
                              <li><a href="#">3</a></li>
                              <li><a href="#">4</a></li>
                              <li><a href="#">5</a></li>
                              <li><a href="#">6</a></li>
                        </ul>
                            <!-- http://bootsnipp.com/snippets/featured/collection-of-bootstrap-buttons -->
                           <!-- <span class="btn btn-success btn-md center pull-right"><i class="glyphicon"></i>Assign </span> -->
                           <!-- <span class="btn btn-primary btn-md pull-right"><i class="glyphicon glyphicon-envelope"></i> Email</span> -->
                        </div>
                    </div>
                </div>

            <!-- </div> -->
          </div>

        </div>
    </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
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

    });

</script>


</body>
</html>