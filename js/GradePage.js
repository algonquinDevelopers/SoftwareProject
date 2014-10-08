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

    makeBSTable();
    makeStudentTable();

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
                console.log( "Data Loaded: " , data );
                $('#grade-table-javascript').bootstrapTable('load', data);
            }
        });
    }

    function makeStudentTable(){
        $('#student-table-javascript').bootstrapTable({
                // data: data,
                // search: true,
                // minimumCountColumns: 2,
                // showColumns: true,
                onClickRow: function (name) {
                    console.log(name.studentName);
                    getGrades(selectLevel, name.studentName);
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

    function makeBSTable(){
        // http://wenzhixin.net.cn/p/bootstrap-table/docs/documentation.html
        // http://wenzhixin.net.cn/p/bootstrap-table/docs/examples.html
            $('#grade-table-javascript').bootstrapTable({
                // cache: true,
                pageSize: 10,
                // height: 500,
                striped : true,
                classes: 'table-condensed',
                pagination: true,
                // pageList: [10, 25, 50, 100, 200],
                showColumns: true,
                // search: true,
                minimumCountColumns: 2,
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
                    field: 'grade',
                    title: 'Grade',
                    align: 'left',
                    valign: 'top',
                    sortable: true,
                },
                {
                    field: 'aLevel',
                    title: 'Level',
                    align: 'center',
                    valign: 'middle',
                    clickToSelect: false,
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
   
    // pass in json info about grades
    function showStudentGrades(gradeJson){
        var html = '';
        $.each(gradeJson, function(key, val){
            console.log(key);

            html += '<tr>'+
                    '<td>'+ val.courseNumber + '</td>'+
                    '<td>'+ val.courseName +'</td>'+
                    '<td>'+ val.grade + '</td>'+
                    '<td>'+ val.aLevel +'</td>'+
                    '</tr>';
            $("#gradeList").html(html);
        });
    }

    return {
        getGradesJson : getGradesJson
    };
};