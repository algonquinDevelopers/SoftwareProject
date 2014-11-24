// http://toddmotto.com/mastering-the-module-pattern/
// come up with better name
var MODULE = MODULE || {};

MODULE.GradePage = {};

// code for grading page
// main method of the appilcation.
MODULE.GradePage.init = function(){
	 'use strict';
    
    // get request data to limit the students returned
    var selectLimit = 1000;

    //used for make the student plan
    var studentName = null;
    var studentRowIndex = 0;
    var studentNum = 0;
    var courseLevel = null;

    var currentProgram = null;
    var currentStudentLevel = null;

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
                addCheckToRow();
                openTab('plan');
                loadPlanTable();
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
    });


    
	//level drop down menu
	$('#levelDropDown').on("click", "a", function(){
		var visible = $(this).parents('ul').attr('visibleTag');
		$(visible).html($(this).attr('value'));
	   	
		currentStudentLevel = $(this).html();
		courseLevel = parseInt(currentStudentLevel.charAt(1));
        resetTable('#grade-table-javascript');

        if(currentStudentLevel !== null && currentProgram !== null){
            $('#message').hide();
        }
        loadStudentTable(currentProgram, currentStudentLevel);
	});


    function loadStudentTable(currentProgram, currentStudentLevel){
        $.ajax({
            type: "GET",
            url: 'selectStudents.php',
            dataType: 'json',
            data: { name: currentProgram, level: currentStudentLevel, limit: selectLimit },
            success: function(data){
                console.log("success");
                $('#student-table-javascript').bootstrapTable('load', data);
                // loadCourseTable();
                
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
        loadPlanTable();    
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
            data: { student_no: student_no, level: currentStudentLevel },
            success: function(data){
                $('#grade-table-javascript').bootstrapTable('load', data);
                highlightFailedCourses();
                updateAllCourses(data);
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
    // also set prevLevel to select 
    function updateAllCourses(data){
        for(var i in data){
            var table_row = data[i];
            if(table_row == undefined) return;
            if(table_row.grade[0] === "F"){
                loadCourseTableNextLevelPlus();
                return;
            }
        }
        loadCourseTableNextLevel();
    }


    // adds check mark to student row
    // if student name has a check ( a span tag ) then it doesn't add another check
    function addCheckToRow(){       
        // console.log("doesnt contain span  ", studentName, studentName.search("span") === -1);
        // search return -1 is the string is not found
        if(studentName.search("span") !== -1){
            return;
        }
        //T_T why no immutable strings
        // var studentNameRow = studentName + '<span style="float: right; color: green;" class="glyphicon glyphicon-ok"> </span>';

        var $studentTable = $('#student-table-javascript').bootstrapTable();
        //todo: check if name has tags and then return
        $studentTable.bootstrapTable('updateRow', {
            index: studentRowIndex,
                row: {
                   student_name: studentName + '<span style="float: right; color: green;" class="glyphicon glyphicon-ok"> </span>',
                }
        });
    }

    //load course table when student is clicked. Loads courses in next level
    function loadCourseTableNextLevel(){
        // onlt
        $.ajax({
            type: "GET",
            url: 'selectCourse.php',
            dataType: 'json',
            data: { name: currentProgram, nextLevel: courseLevel + 1, currentLevel: null},
            success: function(data){
                console.log("courses updated");
                $('#course-table-javascript').bootstrapTable('load', data);
                // check all courses. assuming student has passed everything 
                $("#course-table-javascript").bootstrapTable('checkAll');  
            },
            error:function(textStatus, errorThrown, error){
                console.log("load course error");
                console.log(errorThrown);     
                console.log(errorThrown.message);
                console.log(error);
            }
        });
    }

     //load course table when student is clicked. Loads courses in next level and current course level level
    function loadCourseTableNextLevelPlus(){
        // if you preLevel is null only next level courses are selected
        // else then prevLevel and next level courses are loaded
        $.ajax({
            type: "GET",
            url: 'selectCourse.php',
            dataType: 'json',
            data: { name: currentProgram, nextLevel: courseLevel + 1, currentLevel: courseLevel},
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

    //insert 1 course into the plan table
    function insertPlanTable(courseCode) {
        $.ajax({
            type: "POST",
            url: 'planInsert.php',
            dataType: 'json',
            data: { course_no: courseCode, student_no: studentNum},
        });
    }

    // loads plan table based on current selected student's student number
    function loadPlanTable(){
        $.ajax({
            type: 'GET',
            url: 'planInsert.php',
            dataType: 'json',
            data: {student_no: studentNum},
            success: function(data){
                $('#history-table').bootstrapTable('load', data);
            },
            error:function(textStatus, errorThrown, error){
                console.log("delete error");
                console.log(errorThrown);     
                console.log(errorThrown.message);
                console.log(error);
            }
        }); 
    }


    // assigns all the selected courses to the plan.
    // todo: remove delete. send a array of courses to php and have php loop and excute insert statements
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
                loadPlanTable();
            },
            error:function(textStatus, errorThrown, error){
                console.log("delete error");
                console.log(errorThrown);     
                console.log(errorThrown.message);
                console.log(error);
            }
        });
        
    }

    /// table helper functions

    //clear all rows in the table
    function resetTable(tableId){
       //setting table data to an empty array will clear all rows 
       $(tableId).bootstrapTable('load', []);
    }

    // opens a bootstrap tab
    function openTab(tab){
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };

};