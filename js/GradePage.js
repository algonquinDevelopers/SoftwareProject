// http://toddmotto.com/mastering-the-module-pattern/
// come up with better name
var MODULE = MODULE || {};

MODULE.GradePage = {};

// code for grading page
MODULE.GradePage.init = function(){
	// "use strict";
    
    // get request data to limit the students returned
    var selectLimt = 300;
    var studentNum;
    // var JSONdata;

    // get request data to select the level; 
    var selectLevel = 1;

    var currentRow;
    //http://rocha.la/jQuery-slimScroll
    $(function(){
        $('#students').slimScroll({
            position: 'left',
            // height: '650px',
            height: '' + (window.innerHeight - 150),
            railVisible: true,
            allowPageScroll: false,
            alwaysVisible: true
        });
    });

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
            $('#student-table-javascript').bootstrapTable('load', data);

        },
        error:function(textStatus, errorThrown){
            // console.log("error");
            console.log(errorThrown);
        }
    });

    $.ajax({
        type: "GET",
        url: 'selectCourse.php',
        dataType: 'json',
        success: function(data){
            // console.log("student get success");
            $('#course-table-javascript').bootstrapTable('load', data);

        },
        error:function(textStatus, errorThrown){
            console.log("error");
            console.log(errorThrown);           
        }
    });


    MODULE.createCourseTable();
    MODULE.createStudentTable();
    MODULE.createGradeTable();
    MODULE.createPlanHistoryTable();
    makeButton();


    $('#student-table-javascript').bootstrapTable().on('click-row.bs.table', onStudentRowClick);

    $('#student-table-javascript  tr').on('click', function(){
        console.log("ok");
    });

    function onStudentRowClick(row, index){
            studentNum = index.studentNumber;
            // console.log();
            // $(this).css("background-color" , "white);
            $('#course-table-javascript').bootstrapTable('uncheckAll');
            checkAndSelect(selectLevel, index.studentName);
               
            getGrades(selectLevel, index.studentName);
    }

    function activaTab(tab){
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };

    function checkAndSelect(level, name){
        var fail_cases = ["F"];
        var grades;

        $.ajax({
            type: "GET",
            url: 'selectGrades.php',
            dataType: 'json',
            // get request for student name
            data: { studentName: name, level: level},
            success: function(data){
                grades = data;
                for(var i in grades){
                    var row = grades[i];
                    if(row.aLevel == "A1" && checkForFailed(fail_cases, row)) {
                        courseTableSelect(row);
                    }
                }
            }
        });
    };

    function checkForFailed(fail_cases, row){
        for(var i in fail_cases){
            var gradeLetter = row.grade;
            if(gradeLetter == fail_cases[i]){
               return false;
            }
            return true;
        }
    }

    function courseTableSelect(row){
        //gets table data its a array of objects every object reps a row
        var data = $('#course-table-javascript').bootstrapTable('getData');    
        // var studentCourse = row.courseName;
        var studentCourseCode = row.courseNumber; 
        // console.log("course code", studentCourseNumber);
        for(var i in data){
            var table_row = data[i];
            // get the char at the end as a int of incr and select the next course
            //eg MAT8051 this get the 1
            var ccn = parseInt(studentCourseCode.slice(-1));
            // get the rest except the end 
            //eg MAT8051 this get the MAT805
            var ccl = studentCourseCode.slice(0, -1);

            if(isNaN(ccn)) continue;
            // console.log(studentCourseCode);
            // CAD8407 Architectural CAD I goes from 07 to 09 at level 2
            if(studentCourseCode == "CAD8407"){
                ccn+=2;
                // console.log('plus 2');
            }else{
                ccn++;
            } 

            var target_course = ccl + ccn;
            if(table_row.courseCode === target_course){
                // last character of n
                // console.log(drow.courseCode, target_course, ccl, ccn);
                var $tr = $("#course-table-javascript .bs-checkbox input[data-index='"+ i +"']");

                // $tr.prop( "checked", true ); 
                //triiger the click event so the libary will know its selected prop doesn't work
                $tr.trigger("click");
            }
        }
    }

    function makeButton(){
        var $button =
        $("<span>",
        {
            id: "name",
            class: "btn btn-success btn-md center pull-right",
            html: '<i class="glyphicon"></i>Assign',
            click: function(){
                console.log("clicked assign");
                assignStudentPlan();
                activaTab('history');
                // currentRow.bgColor = '#AED4E9';
            },
            
        },"</span>");

        $("#course-table-javascript").append($button);
    }
   
    function getGrades(level, name){
        // var level = level;
       // console.log("grades top"+ level + name);
        $.ajax({
            type: "GET",
            url: 'selectGrades.php',
            dataType: 'json',
            // get request for student name
            data: { studentName: name, level: level},
            success: function(data){
                // console.log("grades success");
                $('#grade-table-javascript').bootstrapTable('load', data);

            }
        });
    }
    


    function insertPlanTable(courseCode) {
        $.ajax({
            type: "GET",
            url: 'planInsert.php',
            dataType: 'json',
            // get request for student name
            data: { courseCode: courseCode, studentNum: studentNum},
            success: function(data){
                // console.log( "Data Loaded: " , data );
                $('#history-table').bootstrapTable('load', data);

            }
        });

    }

    function assignStudentPlan() {
        var selectedData = $('#course-table-javascript').bootstrapTable('getSelections');
        console.log(selectedData);
        for(var i in selectedData) {
            var courseCode = selectedData[i].courseCode;
            console.log(studentNum);
            insertPlanTable(courseCode);
        }
    }


};