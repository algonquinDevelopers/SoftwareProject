var MODULE = MODULE || {};

// http://wenzhixin.net.cn/p/bootstrap-table/docs/documentation.html
// http://wenzhixin.net.cn/p/bootstrap-table/docs/examples.html
MODULE.createCourseTable = function(){
	$('#course-table-javascript').bootstrapTable({
        // height: 600,
        // pageSize: 7,
        // striped : true,
        clickToSelect: true,
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
            sortable: true,
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

MODULE.createStudentTable = function(){
    $('#student-table-javascript').bootstrapTable({
        // search: true,
        smartDisplay: true,
        // cardView: true,
        // showToggle: true,
        onClickRow: function(row, element){
            $('#student-table-javascript tr').attr("bgColor", "#fff");
            element[0].bgColor = '#AED4E9';
        },
        columns: [
        {
            field: 'studentName',
            title: 'Name',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'studentNumber',
            title: 'Number',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }
        ]
    });
}

MODULE.createEmailTable = function(){
    $('#student-table-javascript').bootstrapTable({
        // search: true,
        onClickRow: function(row, element){
            // element[0].bgColor = '#AED4E9';
        },
        columns: [
        {
            field: 'studentName',
            title: 'Name',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'studentName',
            title: 'Email',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'studentNumber',
            title: 'Number',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }
        ]
    });
}



MODULE.createPlanTable = function(){
    $('#plan-table').bootstrapTable({

    striped : true,

    columns: [
        {
            field: 'student_no',
            title: 'Student Number',
            align: 'center',
            valign: 'middle',
            sortable: true
        },

        {
            width: 1,
            field: 'course_no',
            title: 'Course Number',
            align: 'center',
            valign: 'middle',
            sortable: true
        }
        ]
    });
}


MODULE.createCurrentPlanTable = function(){
    $('#current-plan-table').bootstrapTable({
        // pageSize: 7,
        striped : true,
        // pagination: true,
        // clickToSelect: true,
        columns: [
        {
            width: 1,
            field: 'course_no',
            title: 'Course Number',
            align: 'center',
            valign: 'top',
            sortable: true
        },

        ]
    });
}

MODULE.createGradeTable = function(){
    $('#grade-table-javascript').bootstrapTable({
        pageSize: 7,
        striped : true,
        // pagination: true,
        clickToSelect: true,
        columns: [
        {
            field: 'courseNumber',
            title: 'Code ',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
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