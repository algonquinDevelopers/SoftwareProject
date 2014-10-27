var MODULE = MODULE || {};

// http://wenzhixin.net.cn/p/bootstrap-table/docs/documentation.html
// http://wenzhixin.net.cn/p/bootstrap-table/docs/examples.html

MODULE.createCourseTable = function(){
	$('#course-table-javascript').bootstrapTable({
        height: 600,
        pageSize: 7,
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
        search: true,
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

MODULE.createGradeTable = function(){
    $('#grade-table-javascript').bootstrapTable({
        pageSize: 7,
        // striped : true,
        // pagination: true,
        clickToSelect: true,
        columns: [
        {
            field: 'courseNumber',
            title: 'code ',
            align: 'center',
            valign: 'middle',
            sortable: true,
        },
        {
            field: 'courseName',
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
            field: 'aLevel',
            title: 'Level <span class="glyphicon glyphicon-chevron-down"></span>',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }
        ]
    });
}