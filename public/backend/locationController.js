app.controller('locationCtrl', ['$scope', 'Data', function ($scope, Data) {

        $scope.itemsPerPage = 30;
        $scope.pageNumber = 1;
        $scope.flagForPageChange = 0;

        $scope.pageChanged = function (pageNo, functionName, id, newpage) {
            $scope.flagForPageChange++;
            if ($scope.flagForPageChange == 1)
            {
                if (($scope.filterData && Object.keys($scope.filterData).length > 0)) {
                    $scope.filteredData($scope.filterData, pageNo, $scope.itemsPerPage);
                } else {
//                    $scope[functionName](id, pageNo, $scope.itemsPerPage);
                    $scope[functionName](id, pageNo, $scope.itemsPerPage);
                }
            }
            $scope.pageNumber = pageNo;

        }
        $scope.manageLocation = function (empId, pageNumber, itemPerPage) {
            Data.post('manage-location/manageLocation', {
                id: empId, pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                $scope.locationRow = response.records;
                $scope.locationRowLength = response.totalCount;
                $scope.flagForPageChange = 0;
            });
        };

        $scope.getProcName = $scope.type = '';
        $scope.procName = function (procedureName, isTeam) {
            $scope.getProcName = angular.copy(procedureName);
            $scope.type = angular.copy(isTeam);
        }


        $scope.filterData = {};
        $scope.data = {};

        $scope.filteredData = function (data, page, noOfRecords) {
            $scope.showloader();
            Data.post('manage-location/filteredData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords}).then(function (response) {
                if (response.success)
                {
                    $scope.locationRow = response.records;
                    $scope.locationRowLength = response.totalCount;
                } else
                {
                    $scope.locationRow = response.records;
                    $scope.locationRowLength = 0;
                }
                $('#showFilterModal').modal('hide');
                $scope.showFilterData = $scope.filterData;
                $scope.hideloader();
                $scope.flagForPageChange = 0;
                return false;

            });
        }

        $scope.removeDataFromFilter = function (keyvalue)
        {
            delete $scope.filterData[keyvalue];
            $scope.filteredData($scope.filterData, 1, 30);
        }

        $scope.initialModal = function (id, name, index, index1, status) {
            console.log(name);
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
                    location_type: $scope.name, status: $scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.locationRow.push({'location_type': $scope.name, id: response.lastinsertid, status: $scope.status});
                        $('#LocationModal').modal('toggle');
                        toaster.pop('success', 'Manage location', 'Record successfully created');
                    }
                });
            } else { //for update
                Data.put('manage-location/' + $scope.id, {
                    location_type: $scope.name, id: $scope.id, status: $scope.status}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.locationRow.splice($scope.index - 1, 1);
                        $scope.locationRow.splice($scope.index - 1, 0, {
                            location_type: $scope.name, id: $scope.id, status: $scope.status});
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