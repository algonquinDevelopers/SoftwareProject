// http://toddmotto.com/mastering-the-module-pattern/
// come up with better name
var MODULE = MODULE || {};

MODULE.GradePage = {};

// code for grading page
MODULE.GradePage.init = function(){
	 "use strict";
    
    // get request data to limit the students returned
    var selectLimit = 1000;

    //used for make the student plan
    var studentName;
    var studentRowIndex;
    var studentNum;
    var studentLevel  = 0;
    var courseLevel= 3;


    var currentProgram = null;
    var currentLevel = 1;

    // get request data to select the level; 
    var selectLevel = 1;


    //http://rocha.la/jQuery-slimScroll
    $(function(){
        $('#students').slimScroll({
            position: 'left',
            height: '' + (window.innerHeight - 150),
            railVisible: true,
            allowPageScroll: false,
            alwaysVisible: true
        });
    });

    MODULE.createCourseTable();
    MODULE.createStudentTable();
    MODULE.createGradeTable();
    MODULE.createPlanHistoryTable();
    makeButton();
    loadCourseTable(courseLevel);

    function makeLevelDropDown(){
        levelDropDown
    }



    $('#programDropDown a').click(function(){
        var visible = $(this).parents('ul').attr('visibleTag');
        $(visible).html($(this).attr('value'));
        currentProgram = $(this).html();
        //to select students in the program
            $.ajax({
            type: "GET",
            url: 'selectStudents.php',
            dataType: 'json',
            data: { name: currentProgram, level: currentLevel, limit: selectLimit },
            success: function(data){
                $('#student-table-javascript').bootstrapTable('load', data);
                console.log("student load success");
                changeCourseTable();
                },
            error:function(textStatus, errorThrown, error){
                console.log("student load", error);
                console.log(errorThrown);
                }
            });
    });




	//level drop down menu
	$('#levelDropDown a').click(function(){
		var visible = $(this).parents('ul').attr('visibleTag');
		$(visible).html($(this).attr('value'));
		
		currentLevel = $(this).html();
		$.ajax({
            type: "GET",
            url: 'selectStudents.php',
            dataType: 'json',
            data: { name: currentProgram, level: currentLevel, limit: selectLimit },
            success: function(data){
                console.log("success");
                $('#student-table-javascript').bootstrapTable('load', data);
				changeCourseTable();

            },
            error:function(textStatus, errorThrown, error){
                console.log(error);
                console.log(errorThrown);
			}
		});
	});
	
    //get the students names
    $.ajax({
        type: "GET",
        url: 'selectStudents.php',
        data: { limit: selectLimit},
        success: function(data){
            $('#student-table-javascript').bootstrapTable('load', data);
        },
        error:function(textStatus, errorThrown){
            console.log("loading student", errorThrown);
        }
    });


    $('#student-table-javascript').bootstrapTable().on('click-row.bs.table', onStudentRowClick);

    function onStudentRowClick(row, $element, element){
        highlightStudent(element);
        studentNum = $element.studentNumber;
        studentRowIndex = element.data().index;
        studentName = $element.student_name;
        $('#course-table-javascript').bootstrapTable('uncheckAll');
        loadGradesTable($element.student_name);
    }

    function highlightStudent(element){
        $('#student-table-javascript tr').attr("bgColor", "#fff");
        element[0].bgColor = '#AED4E9';
    }

    function loadGradesTable(studentName){
        $.ajax({
            type: "GET",
            url: 'selectGrades.php',
            dataType: 'json',
            data: { studentName: studentName, level: currentLevel },
            success: function(data){
                setStudentLevel(data);
                $('#grade-table-javascript').bootstrapTable('load', data);
                highlightFailedCourses();
                checkAllCourses(data);
            },
            error:function(textStatus, errorThrown){
                console.log("Load grade table", errorThrown);
            }
        });
    }

    function setStudentLevel(data){
        if(data[0] === undefined){
            courseLevel = undefined;
            return;
        } 
        var studentLevelString = data[0].a_level;
                
        studentLevel = parseInt(studentLevelString.slice(-1));
        courseLevel = studentLevel + 1;
        if(studentLevel === 6){
            courseLevel = 6;
        }
    }

    function loadCourseTable(courseLevel){
        $.ajax({
            type: "GET",
            url: 'selectCourse.php',
            dataType: 'json',
            data: {courseLevel: courseLevel},
            success: function(data){
                $('#course-table-javascript').bootstrapTable('load', data);
            },
            error:function(textStatus, errorThrown){
                console.log("course table load error");
                console.log(errorThrown);           
            }
        });
    }

    function openTab(tab){
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };

    // change color for failed courses
    function highlightFailedCourses(){
        var data = $('#grade-table-javascript').bootstrapTable('getData');
        for(var i in data){
            var table_row = data[i];
            if(table_row.grade[0] === "F"){
                $("#grade-table-javascript tr[data-index='"+ i +"']").addClass("failed-course");
            }
        }
    }

    function checkAllCourses(data){
        for(var i in data){
            var table_row = data[i];
            if(table_row == undefined) return;
            if(table_row.grade[0] === "F"){
                return;
            }
        }
        $("#course-table-javascript").bootstrapTable('checkAll');  
    }

    function checkForFailed(fail_cases, row){
        for(var i in fail_cases){
            var gradeLetter = row.grade;
            if(gradeLetter == fail_cases[i]){
               return false;
            }
            return true;
        }
    }

    //THIS DOESN"T WORK. 
    //IT WILL ONLY WORK IF THE COURSE CODE INCREMNET BY 1 PER LEVEL
    function courseTableSelect(row){
        //gets table data its a array of objects every object reps a row
        var data = $('#course-table-javascript').bootstrapTable('getData');    
        // var studentCourse = row.courseName;
        var studentCourseCode = row.course_no; 
        // console.log("course code", studentCourseNumber);
        for(var i in data){
            var table_row = data[i];
            // get the char at the end as a int of incr and select the next course
            var ccn = parseInt(studentCourseCode.slice(-1));
            // get the rest except the end 
            //eg MAT8051 this get the MAT805
            var ccl = studentCourseCode.slice(0, -1);

            if(isNaN(ccn)) continue;
            // console.log(studentCourseCode);
            // CAD8407 Architectural CAD I goes from 07 to 09 at level 2
            if(studentCourseCode === "CAD8407" || studentCourseCode === "ENG4001"){
                ccn+=2;
            }else{
                ccn++;
            } 

            var target_course = ccl + ccn;
            if(table_row.course_no === target_course){
                // last character of n
                var $tr = $("#course-table-javascript .bs-checkbox input[data-index='"+ i +"']");
                // click row table row to check it
                $tr.trigger("click");
            }
        }
    }

    function checkRow(){       
        var $studentTable = $('#student-table-javascript').bootstrapTable();
        $studentTable.bootstrapTable('updateRow', {
            index: studentRowIndex,
                row: {
                   student_name: studentName + '<span style="float: right; color: green;" class="glyphicon glyphicon-ok"> </span>',
                }
        });
    }

    function makeButton(){
        var $button =
        $("<span>",
        {
            id: "name",
            class: "btn btn-success btn-md center pull-right",
            html: '<i class="glyphicon"></i>Assign Plan',
            click: function(){
                //todo: don't assign if no student is selected
                assignStudentPlan();
                checkRow();
                openTab('plan');
            },
            
        },"</span>");

        $("#course-table-javascript").append($button);
    }
   
    function insertPlanTable(courseCode) {
        console.log("whar");
        $.ajax({
            type: "GET",
            url: 'planInsert.php',
            dataType: 'json',
            data: { courseCode: courseCode, studentNum: studentNum},
            success: function(data){
                $('#history-table').bootstrapTable('load', data);
            }
        });

    }

    function assignStudentPlan() {
        var selectedData = $('#course-table-javascript').bootstrapTable('getSelections');
        console.log(selectedData);
        for(var i in selectedData) {
            var courseCode = selectedData[i].courseCode;
            insertPlanTable(courseCode);
        }
    }

    //called when program or level is selected
    function changeCourseTable(){
    
        $.ajax({
            type: "GET",
            url: 'selectCourse.php',
            dataType: 'json',
            data: { name: currentProgram, level: currentLevel },
            success: function(data){
                console.log("courses updated");
                $('#course-table-javascript').bootstrapTable('load', data);

            },
            error:function(textStatus, errorThrown, error){
                console.log(currentLevel);
                console.log(typeof currentLevel);
                console.log(currentProgram);
                console.log("error");
                console.log(errorThrown);     
                console.log(errorThrown.message);
                console.log(error);
            }
        });
    
    }//changeCourseTable()

};