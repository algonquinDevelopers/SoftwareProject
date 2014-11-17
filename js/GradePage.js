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
    var studentNum;
    var studentLevel  = 0;
    // var JSONdata;
    var courseLevel= 3;
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


    $('.plink').click(function () { 
        // console.log($(this).html());
        // loadCourse($(this).html());
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
            data: { name: programName, limit: selectLimit},
            success: function(data){
                console.log("success");
                $('#student-table-javascript').bootstrapTable('load', data);
            },
            error:function(textStatus, errorThrown){
                // console.log("error");
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
            console.log(errorThrown);
        }
    });




    $('#student-table-javascript').bootstrapTable().on('click-row.bs.table', onStudentRowClick);

    function onStudentRowClick(row, $element){
            studentNum = $element.student_no;
            // console.log($element);
            $('#course-table-javascript').bootstrapTable('uncheckAll');
            loadGradesTable($element.student_name);
    }

    // this is
    function loadGradesTable(studentName){
        $.ajax({
            type: "GET",
            url: 'selectGrades.php',
            dataType: 'json',
            data: { studentName: studentName},
            success: function(data){
                // as long as json data doesn't have multiple a_level's this will work
                // console.log(data[0]);
                setStudentLevel(data);
                // checkAndSelect(studentLevel, studentName);
                loadCourseTable(courseLevel);
                $('#grade-table-javascript').bootstrapTable('load', data);
                highlightFailed();
            },
            error:function(textStatus, errorThrown){
                console.log(errorThrown);
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
                checkAllCourses();
            },
            error:function(textStatus, errorThrown){
                console.log("course table load error");
                console.log(errorThrown);           
            }
        });
    }

    function activaTab(tab){
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };

    function checkAndSelect(level, name){
        // console.log(level, name);
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
                    if(checkForFailed(fail_cases, row)) {
                        courseTableSelect(row);
                    }
                }
            }
        });
    };

    // change color for failed courses
    function highlightFailed(){
        var data = $('#grade-table-javascript').bootstrapTable('getData');
        for(var i in data){
            var table_row = data[i];
            if(table_row.grade[0] === "F"){
                // $("#grade-table-javascript tr[data-index='"+ i +"']").css("color", "red" );
                $("#grade-table-javascript tr[data-index='"+ i +"']").addClass("failed-course");
            }
        }
    }

    function checkAllCourses(){
        if(courseLevel === 6 || courseLevel === undefined) return;
        var data = $('#grade-table-javascript').bootstrapTable('getData');
        for(var i in data){
            var table_row = data[i];
            if(table_row == undefined) return;
            if(table_row.grade[0] === "F"){
                // $("#grade-table-javascript tr[data-index='"+ i +"']").addClass("failed-course");
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
                // console.log('plus 2');
            }else{
                ccn++;
            } 

            var target_course = ccl + ccn;
            // console.log(table_row);
            if(table_row.course_no === target_course){
            // console.log("target course" ,target_course);
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
                assignStudentPlan();
                activaTab('history');
            },
            
        },"</span>");

        $("#course-table-javascript").append($button);
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
        for(var i in selectedData) {
            var courseCode = selectedData[i].courseCode;
            // console.log(studentNum);
            insertPlanTable(courseCode);
        }
    }


    // return { loadCourse: loadCourse};
};