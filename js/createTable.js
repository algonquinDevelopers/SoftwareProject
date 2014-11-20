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
            field: 'course_no',
			title: 'Code',
            align: 'center',
            valign: 'middle',
            sortable: true,
            clickToSelect: false,
        },
        {
            field: 'course_name',
			title: 'Name',
            align: 'center',
            valign: 'middle',
        },
        {
            field: 'course_level',
			title: 'Level',
            align: 'center',
            valign: 'middle',
        }
        ]
    });		
}

MODULE.createStudentTable = function(){
    $('#student-table-javascript').bootstrapTable({
        search: true,
        onClickRow: function(row, element){
            // element[0].bgColor = '#AED4E9';
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
			title: 'code ',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'course_name',
			title: 'Name <span class="glyphicon glyphicon-chevron-down"></span>',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            width: 1,
            field: 'grade',
            title: 'Grade <span class="glyphicon glyphicon-chevron-down"></span>',
            align: 'center',
            valign: 'top',
            sortable: true,
        },
        {
            width: 1,
            field: 'a_level',
			title: 'Level <span class="glyphicon glyphicon-chevron-down"></span>',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }
        ]
    });
}