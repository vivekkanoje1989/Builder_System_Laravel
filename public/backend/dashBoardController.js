app.controller('dashboardCtrl', ['$scope', 'Data', 'toaster', '$state', function ($scope, Data, toaster, $state) {

        $scope.itemsPerPage = 30;
        $scope.reqLeave = false;
        $scope.reqOtherLeave = false;
        $scope.noOfRows = 1;
        $scope.request = {};
        $scope.getEmployees = function () {
            Data.get('getEmployees').then(function (response) {
                $scope.employeeRow = response.records;
            });
        };
        
        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.filterDetails = function (search) {
//            $scope.searchDetails = {};
            if (search.from_date != undefined) {
                var today = new Date(search.from_date);
                  var day = today.getDate().toString();
                if(day.length > 1){
                     search.from_date = (today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + today.getDate());
                }else{
                     search.from_date = (today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-0' + today.getDate());
                }
            }
            
            if (search.to_date != undefined) {
                var loginDate = new Date(search.to_date);
                
                var day = loginDate.getDate().toString();
                if(day.length > 1){
                    search.to_date = (loginDate.getFullYear() + '-' + ("0" + (loginDate.getMonth() + 1)).slice(-2) + '-' + loginDate.getDate());
                }else{
                    search.to_date = (loginDate.getFullYear() + '-' + ("0" + (loginDate.getMonth() + 1)).slice(-2) + '-0' + loginDate.getDate());
                }
                
                
            }
//            console.log(search);
            $scope.searchData = search;
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }
        
        
        $scope.clearToDate = function ()
        {
            $scope.request.to_date = '';
        }
        $scope.getEmployeesCC = function ()
        {
            Data.post('getEmployeesCC', {'id': $scope.request.application_to}).then(function (response) {
                $scope.employeeRowCC = response.records;
            });

        };

        $scope.view_description = function (list)
        {
            $scope.in_date = list.in_date;
            $scope.request_type = list.request_type;
            $scope.from_date = list.from_date;
            $scope.to_date = list.to_date;
            $scope.req_desc = list.req_desc;
            $scope.to_name = list.first_name + " " + list.last_name;
            $scope.id = list.id;
            $scope.status = list.status;
            Data.post('my-request/description', {id: $scope.id}).then(function (response) {
                if (response.status) {
                    $scope.cc_name = response.records.first_name + " " + response.records.last_name;
                }
            });
        };
        $scope.dorequestLeaveAction = function (request) {
            $scope.reqLeave = true;
            var date = new Date(request.from_date);
            $scope.from_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            var date = new Date(request.to_date);
            $scope.to_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            Data.post('request-leave/', {
                uid: $scope.request.application_to, cc: $scope.request.application_cc, from_date: $scope.from_date, to_date: $scope.to_date, req_desc: request.req_desc, request_type: "Leave", status: "1"}).then(function (response) {

                if (response.status) {
                    $scope.reqLeave = false;
                    toaster.pop('success', 'Manage request', "Request created successfully");
                    $state.go('myRequestIndex');
                }
            });
        };
        $scope.doOtherApprovalAction = function (request)
        {
            $scope.reqOtherLeave = true;
            Data.post('request-approval/other', {
                uid: request.application_to, cc: request.application_cc, req_desc: request.req_desc, request_type: "Approval", status: "1"}).then(function (response) {

                if (response.status) {
                    $scope.reqOtherLeave = false;
                    toaster.pop('success', 'Manage request', "Request created successfully");
                    $state.go('myRequestIndex');
                }
            });
        };
        $scope.getMyRequest = function ()
        {
            Data.post('my-request/getMyRequest', {
                uid: $scope.application_to, cc: $scope.application_cc, req_desc: $scope.req_desc}).then(function (response) {
                $scope.myRequest = response.records;
            });
        };
        $scope.getRequestForMe = function ()
        {
            Data.get('my-request/getRequestForMe').then(function (response) {
                $scope.myRequest = response.records;

            });
        }
        $scope.changeStatus = function ()
        {
            Data.post('request-for-me/changeStatus', {
                status: $scope.status, reply: $scope.reply, id: $scope.id}).then(function (response) {
                if (response.status)
                {
                    $('#newModal').modal('toggle');
                    toaster.pop('success', 'Manage request', "Request status changed successfully");
                    $scope.myRequest.splice($scope.index, 1);
                    $scope.myRequest.splice($scope.index, 0, {in_date: $scope.in_date, status: $scope.status,
                        status: $scope.status, id: $scope.id, request_type: $scope.request_type, first_name: $scope.first_name, last_name: $scope.last_name, from_date: $scope.from_date, to_date: $scope.to_date, req_desc: $scope.req_desc});
                }
            });
        }
        $scope.statusChange = function (list, index)
        {
            $scope.id = list.id;
            $scope.index = index;
            $scope.in_date = list.in_date;
            $scope.request_type = list.request_type;
            $scope.first_name = list.first_name;
            $scope.last_name = list.last_name;
            $scope.from_date = list.from_date;
            $scope.to_date = list.to_date;
            $scope.req_desc = list.req_desc;
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);