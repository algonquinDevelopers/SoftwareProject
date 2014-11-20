var MODULE = MODULE || {};

// http://wenzhixin.net.cn/p/bootstrap-table/docs/documentation.html
// http://wenzhixin.net.cn/p/bootstrap-table/docs/examples.html
MODULE.createCourseTable = function(){
	$('#course-table-javascript').bootstrapTable({
        clickToSelect: true,
        columns: [
        {
            field: 'state',
            checkbox: true
        },
        {
            field: 'course_no',
            title: 'Code',
            align: 'center',
            valign: 'middle',
            clickToSelect: false,
            sortable: true,
        },
        {
            field: 'course_name',
            title: 'Name',
            align: 'center',
            valign: 'middle',
            // sortable: true,
        },
        {
            field: 'course_level',
            title: 'Level',
            align: 'center',
            valign: 'middle',
            sortable: true,
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
            console.log();
            element[0].bgColor = '#AED4E9';
        },
        columns: [
        {
            field: 'student_name',
            title: 'Name',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'student_no',
            title: 'Number',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }
        ]
    });
}


MODULE.createPlanHistoryTable = function(){
    $('#history-table').bootstrapTable({
        // pageSize: 7,
        striped : true,
        // pagination: true,
        // clickToSelect: true,
        columns: [
        {
            field: 'course_no',
            title: 'Course Number',
            align: 'center',
            valign: 'middle',
            sortable: true
        },
        {
            width: 1,
            field: 'student_no',
            title: 'Student Number',
            align: 'center',
            valign: 'top',
            sortable: true
        },
        {
            width: 1,
            field: 'plan_version',
            title: 'Plan Version',
            align: 'center',
            valign: 'middle',
            sortable: true
        }
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
            field: 'course_no',
            title: 'Code ',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'course_name',
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
            field: 'a_level',
            title: 'Level',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }
        ]
    });
}