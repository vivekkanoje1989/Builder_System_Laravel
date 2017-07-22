app.controller('smsController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$stateParams', 'toaster', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $stateParams, toaster) {
        $scope.itemsPerPage = 30;
        $scope.pageNumber = 1;
        $scope.btnExport = true;
        $scope.dnExcelSheet = false;
        $scope.report_name;


        $scope.pageChanged = function (pageNo, functionName, id) {
            $scope[functionName](id, pageNo, $scope.itemsPerPage);
            $scope.pageNumber = pageNo;
        };


        $scope.smsLogsLists = function (empId, pageNumber, itemPerPage) {
            Data.post('bmsConsumption/allSmsLogs', {
                id: empId, pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                if (response.success) {
                    $scope.smsLogsList = response.records;
                    $scope.smsLogLength = response.totalCount;

                } else {
                    $scope.errorMsg = response.message;
                }
            });
        };
    }]);


