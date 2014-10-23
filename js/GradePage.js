// http://toddmotto.com/mastering-the-module-pattern/
// come up with better name
var MODULE = MODULE || {};

MODULE.GradePage = {};

// code for grading page
MODULE.GradePage.init = function(){
	// "use strict";
    
    // get request data to limit the students returned
    var selectLimt = 100;
    // var JSONdata;

    // get request data to select the level; 
    var selectLevel = 1;

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
    courseSelect();

    function courseSelect(level, name){
        var fail_cases = ["F", "W", "B-"];

        // var grades = getGradesJson2(level, name);
        var grades;

        $.ajax({
            type: "GET",
            url: 'selectGrades.php',
            dataType: 'json',
            // get request for student name
            data: { studentName: name, level: level},
            success: function(data){
                grades = data;
                // console.log(grades);
                // /makeGradeTable(data);
                // console.log(grades + 'json');
                for(var i in grades){
                    var row = grades[i];
                    // console.log(row);
                    if(row.aLevel == "A1" && checkForFailed(fail_cases, row)) {
                        // console.log(row);
                        console.log("passed");
                        courseTableSelect(row);
                    }
                }
            }
        });
    };

    function selectCoursesCheckBox(row, index){
        var courseName = row.courseName;
    }

    function checkForFailed(fail_cases, row){
        for(var i in fail_cases){

            var gradeLetter = row.grade;
            // console.log(gradeLetter);
            // if(gradeLetter == "A+"){
            //     console.log('this was a plus' + gradeLetter);
            // }
            // if(gradeLetter !== fail_cases[i]){
            //     // console.log('true');
            //     return true;
            // }
            if(gradeLetter == fail_cases[i]){
               return false;
            }
            // console.log('false')
            return true;
        }
    }

    function courseTableSelect(row){
        var data = $('#course-table-javascript').bootstrapTable('getData');    
        // var data = $('table#course-table-javascript > tbody > tr'); 
        // $("table#course-table-javascript > tbody > tr[data-index='1']");
        var studentCourse = row.courseName;
        console.log(studentCourse);
        //$('table#course-table-javascript > tbody > tr');
        //.prop( "checked", true );
        for(var i in data){
            var row = data[i];
            if(studentCourse === row.courseName){
                // console.log('ok');
                console.log(row.courseName, i);
                // var $tr = $("table#course-table-javascript > tbody > tr[data-index='"+ i +"']");
                var $tr = $("#course-table-javascript .bs-checkbox input[data-index='"+ i +"']");
                
                $tr.prop( "checked", true ); 
            }
        }
    }



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
    }


    function makeCourseTable(){
        $('#course-table-javascript').bootstrapTable({
            height: 600,
            pageSize: 7,
            striped : true,
            clickToSelect: true,
            onLoadSuccess: function(data){
                console.log(data);
            },
            columns: [
            {
                field: 'state',
                checkbox: true
            },
            {
                field: 'courseCode',
                title: 'Code',
                align: 'center',
                valign: 'middle',
                clickToSelect: false,
            },
            {
                field: 'courseName',
                title: 'Name',
                align: 'center',
                valign: 'middle',
                // sortable: true,
            },
            {
                field: 'courseLevel',
                title: 'Level',
                align: 'center',
                valign: 'middle',
                // sortable: true,
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
                search: true,
                onClickRow: function (row, index) {
                    $('#course-table-javascript').bootstrapTable('uncheckAll');
                    console.log(index);
                    currentRow = index[0];
                    courseSelect(selectLevel, row.studentName);
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
        var json;
        $.ajax({
            type: "GET",
            url: 'selectGrades.php',
            dataType: 'json',
            // get request for student name
            data: { studentName: name, level: level},
            success: function(data){
                console.log( "Data Loaded: " , data );
                makeGradeTable(data);
            }
        });
    }

    function getGradesJson2(level, name){
        var json;
        $.ajax({
            type: "GET",
            url: 'selectGrades.php',
            dataType: 'json',
            // get request for student name
            data: { studentName: name, level: level},
            success: function(data){
                console.log("gg 2");
                json = data;
                console.log(json);
                // /makeGradeTable(data);
            }
        });
        return json; 
    }

    return {courseSelect: courseSelect };

};