app.controller('statesCtrl', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {

        $scope.itemsPerPage = 30;
        $scope.pageNumber = 1;
        $scope.noOfRows = 1;
        $scope.flagForChange = 0;
//        $scope.pageChanged = function (pageNo, functionName, id) {
//            $scope[functionName](id, pageNo, $scope.itemsPerPage);
//            $scope.pageNumber = pageNo;
//        };
        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
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
        $scope.manageStates = function (empId, pageNumber, itemPerPage) {
            $scope.showloader();
            Data.post('manage-states/manageStates').then(function (response) {
                $scope.hideloader();
                $scope.statesRow = response.records;
                $scope.statesRowLength = response.totalCount;
                $scope.exportData = response.exportData;
                $scope.deleteBtn = response.delete;
                $scope.flagForChange = 0;
            });
        };

        $scope.deleteStates = function (id, index) {
            Data.post('manage-states/deleteStates', {
                'id': id}).then(function (response) {
                toaster.pop('success', 'Manage States', 'State deleted successfully');
                $scope.statesRow.splice(index, 1);
            });
        }

        $scope.statesExportToxls = function () {
            $scope.getexcel = window.location = "manage-states/statesExportToxls";
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
//            Data.post('manage-states/filteredData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords}).then(function (response) {
//                if (response.success)
//                {
//                    $scope.statesRow = response.records;
//                    $scope.statesRowLength = response.totalCount;
//                } else
//                {
//                    $scope.statesRow = response.records;
//                    $scope.statesRowLength = 0;
//                }
//                $('#showFilterModal').modal('hide');
//                $scope.showFilterData = $scope.filterData;
//                $scope.hideloader();
//                $scope.flagForChange = 0;
//                return false;
//
//            });
//        }

        $scope.removeDataFromFilter = function (keyvalue)
        {
            delete $scope.filterData[keyvalue];
            $scope.filteredData($scope.filterData, 1, 30);
        }


        $scope.manageCountry = function () {
            Data.get('manage-states/manageCountry').then(function (response) {
                $scope.countryRow = response.records;
            });
        };
        $scope.initialModal = function (id, name, country, country_id, index, index1) {

            if (id == 0)
            {
                $scope.heading = 'Add state';
                $scope.action = "Submit";
            } else {
                $scope.heading = 'Edit state';
                $scope.action = "Update";
            }
            $scope.id = id;
            $scope.name = name;
            $scope.statesForm.index = index * ($scope.noOfRows - 1) + (index1 + 1);
            $scope.country = country;
            $scope.country_id = country_id;
        }
        $scope.doStatesAction = function () {

            $scope.errorMsg = '';
            if ($scope.id == 0) //for create
            {
                Data.post('manage-states/', {
                    name: $scope.name, country_id: $scope.country_id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#statesModal').modal('toggle');
                        $scope.statesRow.push({'name': $scope.name, 'id': response.lastinsertid, 'country_id': $scope.country_id, 'country_name': response.country_name});
                        //$scope.success("State details created successfully");
                    }
                });
            } else {      //for update
                Data.put('manage-states/' + $scope.id, {
                    name: $scope.name, id: $scope.id, country_id: $scope.country_id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#statesModal').modal('toggle');
                        $scope.statesRow.splice($scope.statesForm.index - 1, 1);
                        $scope.statesRow.splice($scope.statesForm.index - 1, 0, {
                            name: $scope.name, id: $scope.id, country_name: $scope.country, 'country_id': $scope.country_id, 'country_name': response.country_name});
                        //$scope.success("State details updated successfully");
                    }
                });
            }
        }
        $scope.success = function (message) {
            Flash.create('success', message);
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);