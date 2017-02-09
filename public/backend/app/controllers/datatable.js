'use strict';

app.controller('DataTableCtrl', function($scope) {
    $scope.simpleTableOptions = {
        sAjaxSource: '/backend/lib/jquery/datatable/data.json',
        aoColumns: [
            { data: 'id' },
            { data: 'employee_id' },
            { data: 'first_name' },
            { data: 'designation' },
            { data: 'reporting_to_id' },
            { data: 'team_lead_id' },
            { data: 'department_name' },
            { data: 'joining_date' },
            { data: 'employee_status' },
            { data: 'updated_date' },
            { data: 'id' },
        ],
        "sDom": "Tflt<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 5,
        "oTableTools": {
            "aButtons": [
                "copy", "csv", "xls", "pdf", "print"
            ],
            "sSwfPath": "/backend/assets/swf/copy_csv_xls_pdf.swf"
        },
        "language": {
            "search": "",
            "sLengthMenu": "_MENU_",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },
        "aaSorting": []
    };
});