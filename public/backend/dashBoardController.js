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
            $scope.desc = req_desc;
            $scope.to_name = to_fname + " " + to_lname;
            $scope.id = id;


            Data.post('my-request/description', {
                id: $scope.id}).then(function (response) {
                $scope.cc_name = response.records.first_name + " " + response.records.last_name;
            });
        }
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
        
        $scope.change_status= function(id){
            alert(id);
            alert($scope.newStatus);
        }
        $scope.success = function (message) {
            Flash.create('success', message);
        };

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);