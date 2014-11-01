// http://toddmotto.com/mastering-the-module-pattern/
// come up with better name
var MODULE = MODULE || {};

MODULE.GradePage = {};

// code for grading page
MODULE.GradePage.init = function(makeGradeTable){
	"use strict";
    
    // get request data to limit the students returned
    var selectLimt = 100;
    // var JSONdata;

    // get request data to select the level; 
    var selectLevel = 6;

    var currentRow;
    //http://rocha.la/jQuery-slimScroll
    $(function(){
        $('#students').slimScroll({
            position: 'left',
            height: '550px',
            railVisible: true,
            allowPageScroll: false,
            alwaysVisible: true
        });
    });

    makeGradeTable();
    makeStudentTable();
    makeCourseTable();
    makeButton();

	
	//drop down menu
	$('.dropdown-menu a').click(function(){
		var visible = $(this).parents('ul').attr('visibleTag');
		$(visible).html($(this).attr('value'));
		
		var programName = $(this).html();
		$.ajax({
			type: "GET",
			url: 'selectStudents.php',
			dataType: 'json',
			data: { name: programName },
			success: function(data){
				console.log("success")
				//$('#student-table-javascript').bootstrapTable('load', data);
			},
			error:function(textStatus, errorThrown, error){
				console.log(errorThrown);
				console.log(error);
				console.log(textStatus);
				console.log(errorThrown.message);
				console.log(programName);
				console.log(typeof programName);
			}
		});
	});
	

    //get the students names
    $.ajax({
        type: "GET",
        url: 'selectStudents.php',
        dataType: 'json',
        data: { limit: selectLimt},
        success: function(data){
            console.log("success");
            $('#student-table-javascript').bootstrapTable('load', data);

        },
        error:function(textStatus, errorThrown){
            console.log("error");
            console.log(errorThrown);
        }
    });

    $.ajax({
        type: "GET",
        url: 'selectCourse.php',
        dataType: 'json',
        success: function(data){
            console.log("success");
            $('#course-table-javascript').bootstrapTable('load', data);

        },
        error:function(textStatus, errorThrown){
            console.log("error");
            console.log(errorThrown);
        }
    });

    function makeButton(){
        var $button =
        $("<span>",
        {
            id: "name",
            class: "btn btn-success btn-md center pull-right",
            html: '<i class="glyphicon"></i>Assign',
            click: function(){
                currentRow.bgColor = '#AED4E9';
            },
            
        },"</span>");

        $("#course-table-javascript").append($button);
        console.log('ok');
                console.log('ok');

    }


    function makeCourseTable(){
        $('#course-table-javascript').bootstrapTable({
            pageSize: 7,
            pagination: true,
            striped : true,
            // showColumns: true,
            // showRefresh: true,
            // minimumCountColumns: 2,
            clickToSelect: true,
            columns: [
            {
                field: 'state',
                checkbox: true
            },
            {
                field: 'courseName',
                title: 'Name',
                align: 'center',
                valign: 'middle',
                // sortable: true,
            },
            {
                field: 'courseCode',
                title: 'Code',
                align: 'center',
                valign: 'middle',
                clickToSelect: false,
            }
            ]
        });
    }


    
    // get info about the grades as json, 
    // this return courseNum , courseName, grade , aLevel for the student
    function getGrades(level, name){
        // var level = level;
        $.ajax({
            type: "GET",
            url: 'selectGrades.php',
            dataType: 'json',
            // get request for student name
            data: { studentName: name, level: level},
            success: function(data){
                // console.log( "Data Loaded: " , data );
                $('#grade-table-javascript').bootstrapTable('load', data);
            }
        });
    }

    function makeStudentTable(){
        $('#student-table-javascript').bootstrapTable({
                // data: data,
                search: true,
                // minimumCountColumns: 2,
                // showColumns: true,
                onClickRow: function (row, index) {
                    console.log(index);
                    currentRow = index[0];
                    // index[0].bgColor = '#eee';
                    // index[0].bgColor = '#AED4E9';

                    getGrades(selectLevel, row.studentName);
                },
                columns: [
                {
                    field: 'studentName',
                    title: 'Name',
                    align: 'center',
                    valign: 'middle',
                }
                ]
            });
    }

    function makeGradeTable(){
        // http://wenzhixin.net.cn/p/bootstrap-table/docs/documentation.html
        // http://wenzhixin.net.cn/p/bootstrap-table/docs/examples.html
            $('#grade-table-javascript').bootstrapTable({
                pageSize: 7,
                striped : true,
                pagination: true,
                clickToSelect: true,
                columns: [
                {
                    field: 'courseName',
                    title: 'Name',
                    align: 'center',
                    valign: 'middle',
                    sortable: true,
                },
                {
                    width: 1,
                    field: 'grade',
                    title: 'Grade',
                    align: 'center',
                    valign: 'top',
                    sortable: true,
                },
                {
                    width: 1,
                    field: 'aLevel',
                    title: 'Level',
                    align: 'center',
                    valign: 'middle',
                    sortable: true,
                }
                ]
            });
        }

    function getGradesJson(level, name){
        // var level = level;
        var json;
        $.ajax({
            type: "GET",
            url: 'selectGrades.php',
            dataType: 'json',
            // get request for student name
            data: { studentName: name, level: level},
            success: function(data){
                console.log( "Data Loaded: " , data );
                // pass in json info about grades
                makeGradeTable(data);
            }
        });
        // return json;
    }

    // makes a list element per student based on json data
    // assign it to the list-group-item bootstrap class 
    function makeStudentList(data){
        // the previous hover and on click functions don't work for some reason.
        // assigning them as attributes does 

        //https://api.jquery.com/jquery.each/
        $.each(data, function(key, val){
            var $student =
            $("<li>",
            {
                id: "name",
                class: "list-group-item",
                html: val.studentName,
                click: function(){
                    var name = $(this).text();
                    console.log(name);
                    // getGrades(selectLevel, name);
                },
                // http://api.jquery.com/hover/#hover1
                mouseenter: function() {
                    $(this).css({"background-color": "grey"});
                    $(this).css({"color":"lightgreen"});
                },
                mouseleave: function(){
                    $(this).css({"background-color": "white"});
                    $(this).css({"color":"black"});
                }
            },"</li>");
            
            $("#studentList").append($student);
        });
    }


};