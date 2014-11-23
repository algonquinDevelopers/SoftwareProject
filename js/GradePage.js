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
    var courseLevel = null;


    var currentProgram = null;
    var currentLevel = null;

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
    //loadCourseTable(courseLevel);

    function makeLevelDropDown(){
        $.ajax({
            type: "GET",
            url: 'selectDropDownLevels.php',
            dataType: 'json',
            data: { programName: currentProgram},
            success: function(data){
                var html ='';
                data.forEach(function(element){
                    html += '<li><a role="menuitem" value='+ element.a_level +'>'+ element.a_level +'</a></li>';
                });
                $('#levelDropDown').html(html);
            },
            error:function(textStatus, errorThrown, error){
                console.log("student level drop down load", error);
                console.log(errorThrown);
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
                getStudentPlan();
            },
            
        },"</span>");

        $("#course-table-javascript").append($button);
    }



    $('#programDropDown a').click(function(){
        var visible = $(this).parents('ul').attr('visibleTag');
        $(visible).html($(this).attr('value'));
		
        currentProgram = $(this).html();
        makeLevelDropDown();
        resetTable('#grade-table-javascript');
        // if(currentLevel == null){
        //    return; 
        // }
        // loadStudentTable(currentProgram, currentLevel);
    });


    
	//level drop down menu
	$('#levelDropDown').on("click", "a", function(){
		var visible = $(this).parents('ul').attr('visibleTag');
		$(visible).html($(this).attr('value'));
		
		currentLevel = $(this).html();
		courseLevel = parseInt(currentLevel.charAt(1));
        resetTable('#grade-table-javascript');
	    if(courseLevel != 6){
            courseLevel++;
        }	
        if(currentLevel !== null && currentProgram !== null){
            $('#message').hide();
        }
        loadStudentTable(currentProgram, currentLevel);
	});


    function loadStudentTable(currentProgram, currentLevel){
        $.ajax({
            type: "GET",
            url: 'selectStudents.php',
            dataType: 'json',
            data: { name: currentProgram, level: currentLevel, limit: selectLimit },
            success: function(data){
                console.log("success");
                $('#student-table-javascript').bootstrapTable('load', data);
                loadCourseTable();
                
            },
            error:function(textStatus, errorThrown, error){
                console.log(error);
                console.log(errorThrown);
            }
        });
    }

    $('#student-table-javascript').bootstrapTable().on('click-row.bs.table', onStudentRowClick);

    function onStudentRowClick(row, $element, element){
        highlightStudent(element);
        studentNum = $element.student_no;
        studentRowIndex = element.data().index;
        studentName = $element.student_name;

        $('#course-table-javascript').bootstrapTable('uncheckAll');
        loadGradesTable($element.student_no);
        getStudentPlan();    
    }

    function highlightStudent(element){
        $('#student-table-javascript tr').attr("bgColor", "#fff");
        element[0].bgColor = '#AED4E9';
    }


    function loadGradesTable(student_no){
        $.ajax({
            type: "GET",
            url: 'selectGrades.php',
            dataType: 'json',
            data: { student_no: student_no, level: currentLevel },
            success: function(data){
                $('#grade-table-javascript').bootstrapTable('load', data);
                highlightFailedCourses();
                checkAllCourses(data);
            },
            error:function(textStatus, errorThrown){
                console.log("Load grade table", errorThrown);
            }
        });
    }
	


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

    //checks all courses if no grade is F
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



    //THIS DOESN"T WORK. 
    //IT WILL ONLY WORK IF THE COURSE CODE INCREMENT BY 1 PER LEVEL
    function courseTableSelect(row){
        var data = $('#course-table-javascript').bootstrapTable('getData');    

        var studentCourseCode = row.course_no; 

        for(var i in data){
            var table_row = data[i];
            // get the char at the end as a int of incr and select the next course
            var ccn = parseInt(studentCourseCode.slice(-1));
            // get the rest except the end 
            //eg MAT8051 this get the MAT805
            var ccl = studentCourseCode.slice(0, -1);

            //some courses end with a letter. 
            if(isNaN(ccn)) continue;

            // CAD8407 Architectural CAD I goes from 07 to 09 at level 2
            if(studentCourseCode === "CAD8407" || studentCourseCode === "ENG4001"){
                ccn+=2;
            }else{
                ccn++;
            } 

            var target_course = ccl + ccn;
            if(table_row.course_no === target_course){
                var $tr = $("#course-table-javascript .bs-checkbox input[data-index='"+ i +"']");
                // click row table row to check the check box
                $tr.trigger("click");
            }
        }
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

    // adds check mark to student row
    function addCheckToRow(){       
        var $studentTable = $('#student-table-javascript').bootstrapTable();
        //todo: check if name has tags and then return
        $studentTable.bootstrapTable('updateRow', {
            index: studentRowIndex,
                row: {
                   student_name: studentName + '<span style="float: right; color: green;" class="glyphicon glyphicon-ok"> </span>',
                }
        });
    }

     //called when program or level is selected
    function loadCourseTable(){
        $.ajax({
            type: "GET",
            url: 'selectCourse.php',
            dataType: 'json',
            data: { name: currentProgram, level: courseLevel },
            success: function(data){
                console.log("courses updated");
                $('#course-table-javascript').bootstrapTable('load', data);

            },
            error:function(textStatus, errorThrown, error){
                console.log("error");
                console.log(errorThrown);     
                console.log(errorThrown.message);
                console.log(error);
            }
        });
    }

    function insertPlanTable(courseCode) {
        console.log(courseCode, studentNum);
        $.ajax({
            type: "POST",
            url: 'planInsert.php',
            dataType: 'json',
            data: { course_no: courseCode, student_no: studentNum},
        });
    }

    function getStudentPlan(){
        $.ajax({
            type: 'GET',
            url: 'planInsert.php',
            dataType: 'json',
            data: {student_no: studentNum},
            success: function(data){
                $('#history-table').bootstrapTable('load', data);
            }
        }); 
    }

    function assignStudentPlan() {
        $.ajax({
            type: 'POST',
            url: 'planInsert.php',
            data: {student_no_to_delete: studentNum},
            success: function(data){
                var selectedData = $('#course-table-javascript').bootstrapTable('getSelections');
                console.log(selectedData);
                for(var i in selectedData) {
                    var course_no = selectedData[i].course_no;
                    insertPlanTable(course_no);
                }
                getStudentPlan();
            },
            error:function(textStatus, errorThrown, error){
                console.log("error");
                console.log(errorThrown);     
                console.log(errorThrown.message);
                console.log(error);
            }
        });
        
    }

    function resetTable(tableId){
       //setting table data to an empty array will clear all rows 
       $(tableId).bootstrapTable('load', []);
    }

    function openTab(tab){
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };

};