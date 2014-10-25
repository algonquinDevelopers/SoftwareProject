var MODULE = MODULE || {};

// http://wenzhixin.net.cn/p/bootstrap-table/docs/documentation.html
// http://wenzhixin.net.cn/p/bootstrap-table/docs/examples.html

MODULE.createCourseTable = function(){
	$('#course-table-javascript').bootstrapTable({
        height: 600,
        pageSize: 7,
        striped : true,
        clickToSelect: true,
        onCheck: function(element){
            console.log(element);
            $(this).css("background-color", "yellow");
            // $element.css("background-color", "yellow");
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
        striped : true,
        pagination: true,
        clickToSelect: true,
        columns: [
        {
            field: 'courseNumber',
            title: 'code',
            align: 'center',
            valign: 'middle',
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