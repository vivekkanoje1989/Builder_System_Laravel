app.controller('dashboardCtrl', ['$scope', 'Data', '$rootScope', '$timeout', '$state', function ($scope, Data, $rootScope, $timeout, $state) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.getEmployees = function () {
            Data.get('getEmployees').then(function (response) {
                $scope.employeeRow = response.records;
            });
        };
        $scope.getEmployeesCC = function ()
        {
            Data.post('getEmployeesCC', {'id': $scope.application_to}).then(function (response) {
                $scope.employeeRowCC = response.records;
            });

        };
        $scope.model = {from_date: new Date(), to_date: new Date()};

        $scope.format = 'DD.MM.YYYY';

        $scope.view_description = function (id, created_date, request_type, from_date, to_date, req_desc, to_fname, to_lname)
        {
            $scope.created_date = created_date;
            $scope.request_type = request_type;
            $scope.from_date = from_date;
            $scope.to_date = to_date;
            $scope.req_desc = req_desc;
            $scope.to_name = to_fname + " " + to_lname;
            $scope.id = id;
            Data.post('my-request/description', {id: $scope.id}).then(function (response) {
                if(response.status){
                    $scope.cc_name = response.records.first_name + " " + response.records.last_name;
                }                
            });
        };
        $scope.dorequestLeaveAction = function () {
            Data.post('request-leave/', {
                uid: $scope.application_to, cc: $scope.application_cc, from_date: $scope.model.from_date, to_date: $scope.model.to_date, req_desc: $scope.req_desc, request_type: "Leave", status: "1"}).then(function (response) {
                if (response.status) {
                    $state.go(getUrl + '.myRequestIndex');
                }
            });
        };
        $scope.doOtherApprovalAction = function ()
        {
            Data.post('request-approval/other', {
                uid: $scope.application_to, cc: $scope.application_cc, req_desc: $scope.req_desc, request_type: "Approval", status: "1"}).then(function (response) {
                if (response.status) {
                    $state.go(getUrl + '.myRequestIndex');
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
            Data.post('request-forme/changeStatus', {
                status: $scope.status, reply: $scope.reply, id: $scope.id}).then(function (response) {
                if (response.status)
                {
                    $('#newModal').modal('toggle');

                    $scope.myRequest.splice($scope.index, 1);
                    $scope.myRequest.splice($scope.index, 0, {
                        status: $scope.status, id: $scope.id, created_date: $scope.created_date, request_type: $scope.request_type, first_name: $scope.first_name, last_name: $scope.last_name, from_date: $scope.from_date, to_date: $scope.to_date, req_desc: $scope.req_desc});
                }
            });
        }
        $scope.statusChange = function (id, created_date, request_type, from_date, to_date, req_desc, first_name, last_name, index)
        {
            $scope.id = id;
            $scope.index = index;
            $scope.created_date = created_date;
            $scope.request_type = request_type;
            $scope.first_name = first_name;
            $scope.last_name = last_name;
            $scope.from_date = from_date;
            $scope.to_date = to_date;
            $scope.req_desc = req_desc;
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);