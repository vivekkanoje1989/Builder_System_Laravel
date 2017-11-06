app.controller('dashboardCtrl', ['$scope', 'Data', 'toaster', '$state', '$location', '$modal', function ($scope, Data, toaster, $state, $location, $modal) {

        $scope.itemsPerPage = 30;
        $scope.reqLeave = false;
        $scope.reqOtherLeave = false;
        $scope.noOfRows = 1;
        $scope.exportMyRequest = '';
        $scope.exportData = '';
        $scope.request = {};
        $scope.employeeRow = [];
        $scope.employeeRow = [];
        $scope.disableBtn = false;
        $scope.getEmployees = function () {

            Data.get('request-leave/getEmployees').then(function (response) {
                $scope.employeeRow = response.records;
            });
        };
        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.ExportToxls = function () {
            $scope.getexcel = window.location = "/my-request/exportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        };


        $scope.requestForMeExportToxls = function () {
            $scope.get_excel = window.location = "/request-for-me/requestForMeExportToxls";
            if ($scope.get_excel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        };

        $scope.resetForm = function (form) {
            angular.copy({}, form);
        }
        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.filterDetails = function (search, type) {
            if (search.in_date != undefined) {
                var today = new Date(search.in_date);
                var day = today.getDate().toString();
                if (day.length > 1) {
                    search.in_date = (today.getDate() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + today.getFullYear());
                } else {
                    search.in_date = (today.getDate() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-0' + today.getFullYear());
                }
            }
            if (search.from_date != undefined) {
                 if (type == 2) {
                    var today = search.from_date.toString();
                    
                }
                if (type != 2) {
                var today = new Date(search.from_date);
                var day = today.getDate().toString();
                if (day.length > 1) {
                    search.from_date = (today.getDate() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + today.getFullYear());
                } else {
                    search.from_date = ("0" + today.getDate() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + today.getFullYear());
                }
            }
            }

            if (search.to_date != undefined) {
                if (type == 2) {
                    var loginDate = search.to_date.toString();
                    
                }
                if (type != 2) {
                    var loginDate = search.to_date;
                    var day = loginDate.getDate().toString();
                    if (day.length > 1) {
                        search.to_date = (loginDate.getDate() + '-' + ("0" + (loginDate.getMonth() + 1)).slice(-2) + '-' + loginDate.getFullYear());
                    } else {
                        search.to_date = ("0" + loginDate.getDate() + '-' + ("0" + (loginDate.getMonth() + 1)).slice(-2) + '-' + loginDate.getFullYear());
                    }
                }

            }

            $scope.searchData = search;
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData, 2);
        }

        $scope.closeModal = function () {
            $scope.searchData = {};
        }


        $scope.clearToDate = function ()
        {
            $scope.request.to_date = '';
        }
        $scope.employeeRowCC = [];
        $scope.getEmployeesCC = function ()
        {
            $scope.empID = [];
            var i;
            for (i = 0; i < $scope.request.application_to.length; i++) {
                $scope.empID.push($scope.request.application_to[i].id);
            }

            Data.post('getEmployeesCC', {'id': $scope.empID}).then(function (response) {
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
//            $scope.to_name = list.first_name + " " + list.last_name;
            $scope.id = list.id;
            $scope.reply = list.reply;
            $scope.status = list.status;
            $scope.statusDescription = list.status;
            Data.post('my-request/description', {id: $scope.id}).then(function (response) {

                if (response.status) {
                    $scope.cc_name = response.ccEmp;
                    $scope.to_name = response.toEmp;
                }
            });
        };
        $scope.dorequestLeaveAction = function (request) {
            $scope.reqLeave = true;
            $('.firstDiv').css('opacity', '0.1').css("pointer-events", "none");
            $('.pleaseWait').css("display", "block").css("z-index", "9999");
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
                } else {
                    $scope.reqLeave = false;
                }
            });
        };
        $scope.doOtherApprovalAction = function (request)
        {
            $('.firstDiv').css('opacity', '0.1').css("pointer-events", "none");
            $('.pleaseWait').css("display", "block").css("z-index", "9999");
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
            $scope.showloader();
            Data.post('my-request/getMyRequest', {
                uid: $scope.application_to, cc: $scope.application_cc, req_desc: $scope.req_desc}).then(function (response) {
                if (response.status) {
                    $scope.hideloader();
                    $scope.myRequest = response.records;
                    $scope.exportMyRequest = response.exportData;
                    $scope.myRequestCount = response.totalCount;
                } else {
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
            });
        };
        $scope.getRequestForMe = function ()
        {
            $scope.showloader();
            Data.get('my-request/getRequestForMe').then(function (response) {

                if (response.status) {
                    $scope.hideloader();
//                    console.log(response);
                    $scope.statusDescription = response.status;
                    $scope.myRequest = response.records;
                    $scope.exportData = response.exportData;
                    $scope.totalCount = $scope.myRequest.length;
                    $scope.searchLength = $scope.myRequest.length;
                } else {
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
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
//        $scope.statusChange = function (list, index)
//        {
//            $scope.id = list.id;
//            $scope.index = index;
//            $scope.in_date = list.in_date;
//            $scope.request_type = list.request_type;
//            $scope.first_name = list.first_name;
//            $scope.last_name = list.last_name;
//            $scope.from_date = list.from_date;
//            $scope.to_date = list.to_date;
//            $scope.req_desc = list.req_desc;
//        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);