app.controller('smsController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$stateParams', 'toaster', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $stateParams, toaster) {
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.btnExport = true;
        $scope.dnExcelSheet = false;
        $scope.report_name;
        $scope.flagForChange = 0;
        $scope.filterData = {};
        $scope.smsLogsList = [];

        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.pageChanged = function (pageNo, functionName, id) {
            $scope.flagForChange++;
            if ($scope.flagForChange === 1)
            {
                if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                    $scope.filteredData($scope.filterData, pageNo, $scope.itemsPerPage);

                } else {
                    $scope[functionName](id, pageNo, $scope.itemsPerPage);
                }
            }
            $scope.noOfRows = pageNo;
        }

        $scope.searchDetails = {};
        $scope.searchData = {};
        $scope.filterDetails = function (search) {
//            $scope.searchDetails = {};
            $scope.searchData = search;
            $('#showFilterModal').modal('hide');
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

        $scope.smsLogsLists = function (empId, pageNumber, itemPerPage) {
            $scope.showloader();
            $scope.itemPerPage = itemPerPage;
            Data.post('bmsConsumption/allSmsLogs', {
                id: empId, pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                if (response.success) {
                    $scope.smsLogsList = response.records;
                    $scope.smsLogLength = response.totalCount;
                    $scope.exportSmsLogsData = response.exportSmsLogsData;
                } else {
                    $scope.errorMsg = response.message;
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
                $scope.hideloader();
                $scope.flagForChange = 0;
            });
        };



        $scope.smsLogsExportToxls = function () {
            $scope.getexcel = window.location = "/bmsConsumption/smsLogsExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }

        $scope.smsLogDetailsExportToxls = function (transId) {
            $scope.getexcel = window.location = "/bmsConsumption/smsLogDetailsExportToxls/" + transId;
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }


        $scope.smsLogsDetails = function (transactionId, pageNumber) {
            $scope.TransId = transactionId;
            Data.post('bmsConsumption/smsLogData', {
                id: transactionId, pageNumber: pageNumber,
            }).then(function (response) {
                if (response.success) {
                    $scope.smsLogsDetails = response.records;
                    $scope.smsLogDetailsData = response.smsLogDetailsData;
                    $scope.employee_name = response.employee_name;

                } else {
                    $scope.errorMsg = response.message;
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
            });
        }

        $scope.getProcName = $scope.type = '';
        $scope.procName = function (procedureName, isTeam) {
            $scope.getProcName = angular.copy(procedureName);
            $scope.type = angular.copy(isTeam);
        }


        $scope.filterData = {};
        $scope.filterReportData = {};
        $scope.data = {};

        $scope.filteredData = function (data, page, noOfRecords) {
            $scope.showloader();
            page = noOfRecords * (page - 1);
            Data.post('bmsConsumption/filteredData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords}).then(function (response) {
                if (response.success)
                {
                    $scope.smsLogsList = response.records;
                    $scope.smsLogLength = response.totalCount;
                } else
                {
                    $scope.smsLogsList = response.records;
                    $scope.smsLogLength = 0;
                }
                $('#showSmsFilterModal').modal('hide');
                $scope.showFilterData = $scope.filterData;
                $scope.hideloader();
                $scope.flagForChange = 0;
                return false;

            });
        }

        $scope.removeDataFromFilter = function (keyvalue)
        {
            delete $scope.filterData[keyvalue];
            $scope.filteredData($scope.filterData, 1, 30);
        }

        $scope.removeReportDataFromFilter = function (keyvalue)
        {
            delete $scope.filterReportData[keyvalue];
            $scope.filteredReportData($scope.filterReportData, 1, 30);
        }

        $scope.filteredReportData = function (data, page, noOfRecords) {
            $scope.showloader();
            page = noOfRecords * (page - 1);
            Data.post('bmsConsumption/filterReportData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords}).then(function (response) {

                if (response.success)
                {
                    $scope.totalSms = response.records;
                    $scope.smsPercentage = response.logsInPercentage;
                    $scope.smsReportLength = response.totalCount;
                    $scope.firstDateofThisMonth = response.firstDate;
                    $scope.currentDate = response.curentDate;
                    for (var j = 0; j < $scope.totalSms.length; j++) {
                        $scope.fail = response.records[j].fail;
                    }
                    $scope.categorylabels = ["Delivered", "Undelivered"];
                    $scope.categorydata = [$scope.totalSms[0].success, $scope.totalSms[0].fail];
                    $scope.categorycolors = ['#FFA500', '#DCDCDC'];
                    $scope.categoryoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };

                    $scope.categorylabels1 = ["Operator issue"];
                    $scope.categorydata1 = [$scope.fail];
                    $scope.categorycolors1 = ['#00ADF9'];
                    $scope.categoryoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };

                } else
                {
                    $scope.smsPercentage = response.logsInPercentage;
                    $scope.smsReportLength = 0;
                }

                $('#showSmsReportFilterModal').modal('hide');
                $scope.showFilterData = $scope.filterReportData;
                $scope.hideloader();
                return false;
            });
        }


        $scope.smsLogsReport = function (empId, pageNumber, itemPerPage) {
            Data.post('bmsConsumption/allSmsReports', {
                id: empId, pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                if (response.success) {
                    $scope.smsPercentage = response.logInPercentage;
                    $scope.totalSms = response.records;
                    $scope.firstDateofThisMonth = response.firstDate;
                    $scope.currentDate = response.currentDate;

                    $scope.fail = response.records[0].fail;
                    if ($scope.fail == 0) {
                        $scope.failP = '0';
                    } else {
                        $scope.failP = '100';
                    }

                    $scope.categorylabels = ["Delivered", "Undelivered"];
                    $scope.categorydata = [$scope.totalSms[0].success, $scope.totalSms[0].fail];
                    $scope.categorycolors = ['#FFA500', '#DCDCDC'];
                    $scope.categoryoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };

                    $scope.categorylabels1 = ["Operator issue"];
                    $scope.categorydata1 = [$scope.fail];
                    $scope.categorycolors1 = ['#00ADF9'];
                    $scope.categoryoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };
                } else {
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
            });
        }

    }]);


