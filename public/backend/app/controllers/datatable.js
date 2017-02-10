'use strict';

app.controller('DataTableCtrl', function ($scope) {

/*$scope.dset = []; 
$http({ method:'POST',
        url: 'admin/master-hr/listUser',
        headers: { 'Content-Type' : 'application/json'
        }                  
     })
.success(function(response){
      //$scope.dset = data;

      $scope.simpleTableOptions = {
//        fnServerData: $scope.dset,
        sAjaxSource: '/backend/lib/jquery/datatable/data.json',
        aoColumns: [
            {data: 'id'},
            {data: 'id'},
            {data: 'first_name'},
            {data: 'designation'},
            {data: 'reporting_to_id'},
            {data: 'team_lead_id'},
            {data: 'department_name'},
            {data: 'joining_date'},
            {data: 'employee_status'},
            {data: 'updated_date'},
            {data: 'id'},
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

      console.log(response);
    })
    /*$scope.LoadTypesView = function () {        
        Data.post('master-hr/listUser').then(function (response) {
//        if (response.success) {
            var obj = response;
            console.log(obj);
//        } else {
//            $scope.errorMsg = response.message;
//        }
    });*/
    
       /* $http({
            method: 'POST',
            url: "admin/master-hr/listUser",
            //headers: {'Content-Type': 'application/json'}  // set the headers so angular passing info as form data (not request payload)
        })
        .success(function (response) {
//            if (response.success)
//            {
                console.log("Response:"+response);
                $scope.Type = response;
                var oTable = $('#manageUsers').dataTable({
                    "sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                    "oTableTools": {
                        "aButtons": [
                            "copy",
                            "print",
                            {
                                "sExtends": "collection",
                               // "sButtonText": 'Save <span class="caret" />',
                                "aButtons": ["csv", "xls", "pdf"]
                            }
                        ]
                    },
                    "bProcessing": true,
//                            "sAjaxSource": '$scope.Type'
                    "sAjaxSource": $scope.TypeId,
                        "sAjaxDataProp": "aaData",
                        'fnServerParams' : function (aoData) {
                        aoData.push({"name":"SessionId",  "value":Session_Id});
                    }
                });
                $('#types').modal('show');
//            }
        });*/
//    };
    $scope.simpleTableOptions = {

        sAjaxSource: '/backend/lib/jquery/datatable/data.json',
        aoColumns: [
            {data: 'id'},
            {data: 'id'},
            {data: 'first_name'},
            {data: 'designation'},
            {data: 'reporting_to_id'},
            {data: 'team_lead_id'},
            {data: 'department_name'},
            {data: 'joining_date'},
            {data: 'employee_status'},
            {data: 'updated_date'},
            {data: 'id'},
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