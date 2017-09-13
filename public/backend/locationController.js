app.controller('locationCtrl', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.pageNumber = 1;
        $scope.flagForPageChange = 0;

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

        $scope.manageLocation = function (empId, pageNumber, itemPerPage) {
             $scope.showloader();
            Data.post('manage-location/manageLocation').then(function (response) {
                 $scope.hideloader();
                $scope.locationRow = response.records;
                $scope.locationRowLength = response.totalCount;
                $scope.exportData = response.exportData;
                $scope.flagForPageChange = 0;
            });
        };
        
        $scope.deleteLocation = function (id, index) {
             Data.post('manage-location/deleteLocation', {
                'id': id}).then(function (response) {
                toaster.pop('success', 'Manage Location', 'Location deleted successfully');
                $scope.locationRow.splice(index, 1);
            });
        }
        
        
        $scope.locationsExportToxls = function () {
            $scope.getexcel = window.location = "/manage-location/locationsExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }
        

//        $scope.getProcName = $scope.type = '';
//        $scope.procName = function (procedureName, isTeam) {
//            $scope.getProcName = angular.copy(procedureName);
//            $scope.type = angular.copy(isTeam);
//        }
//
//
//        $scope.filterData = {};
//        $scope.data = {};
//
//        $scope.filteredData = function (data, page, noOfRecords) {
//            $scope.showloader();
//            Data.post('manage-location/filteredData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords}).then(function (response) {
//                if (response.success)
//                {
//                    $scope.locationRow = response.records;
//                    $scope.locationRowLength = response.totalCount;
//                } else
//                {
//                    $scope.locationRow = response.records;
//                    $scope.locationRowLength = 0;
//                }
//                $('#showFilterModal').modal('hide');
//                $scope.showFilterData = $scope.filterData;
//                $scope.hideloader();
//                $scope.flagForPageChange = 0;
//                return false;
//
//            });
//        }
//
//        $scope.removeDataFromFilter = function (keyvalue)
//        {
//            delete $scope.filterData[keyvalue];
//            $scope.filteredData($scope.filterData, 1, 30);
//        }

        $scope.initialModal = function (id, name, index, index1, status) {
            $scope.heading = 'Location';
            $scope.id = id;
            $scope.name = name;
            $scope.index = index * ($scope.noOfRows - 1) + (index1 + 1);
            $scope.status = status;
        }
        $scope.doLocationAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-location/', {
                    location: $scope.name, status: $scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.locationRow.push({'location': $scope.name, id: response.lastinsertid, status: $scope.status});
                        $('#LocationModal').modal('toggle');
                        toaster.pop('success', 'Manage location', 'Record successfully created');
                    }
                });
            } else { //for update
                Data.put('manage-location/' + $scope.id, {
                    location: $scope.name, id: $scope.id, status: $scope.status}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.locationRow.splice($scope.index - 1, 1);
                        $scope.locationRow.splice($scope.index - 1, 0, {
                            location: $scope.name, id: $scope.id, status: $scope.status});
                        $('#LocationModal').modal('toggle');
                        toaster.pop('success', 'Manage location', 'Record successfully updated');
                    }
                });
            }
        }


        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);