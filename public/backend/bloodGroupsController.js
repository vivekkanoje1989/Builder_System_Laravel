'use strict';
app.controller('bloodsGroupCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', function ($scope, Data, $rootScope, $timeout, toaster) {


        $scope.itemsPerPage = 30;
        $scope.pageNumber = 1;
        $scope.pageChanged = function (pageNo, functionName, id) {
            $scope[functionName](id, pageNo, $scope.itemsPerPage);
            $scope.pageNumber = pageNo;
        };

        $scope.noOfRows = 1;
        $scope.manageBloodGroup = function (empId, pageNumber, itemPerPage) {
            $scope.showloader();
            Data.post('blood-groups/manageBloodGroup').then(function (response) {
                $scope.hideloader();
                $scope.bloodGrpRow = response.records;
                $scope.bloodGrpLength = response.totalCount;
            });
        };


        $scope.getProcName = $scope.type = '';
        $scope.procName = function (procedureName, isTeam) {
            $scope.getProcName = angular.copy(procedureName);
            $scope.type = angular.copy(isTeam);
        }

        $scope.searchDetails = {};
        $scope.searchData = {};
        $scope.filterDetails = function (search) {
//             $scope.searchDetails = {};
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

//        $scope.filterData = {};
//        $scope.data = {};
//
//        $scope.filteredData = function (data, page, noOfRecords) {
//            $scope.showloader();
//            page = noOfRecords * (page - 1);
//            Data.post('blood-groups/filteredData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords}).then(function (response) {
//                if (response.success)
//                {
//                    $scope.bloodGrpRow = response.records;
//                    $scope.bloodGrpLength = response.totalCount;
//                } else
//                {
//                    $scope.bloodGrpRow = response.records;
//                    $scope.bloodGrpLength = 0;
//                }
//                $('#showFilterModal').modal('hide');
//                $scope.showFilterData = $scope.filterData;
//                $scope.hideloader();
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


        $scope.initialModal = function (id, name, index, index1) {
            if (id == 0)
            {
                $scope.heading = 'Add blood group';
                $scope.action = 'Submit';
            } else {
                $scope.heading = 'Edit blood group';
                $scope.action = 'Update';
            }
            $scope.blood_group_id = id;
            $scope.blood_group = name;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
            $scope.sbtBtn = false;
        }
        $scope.doBloodGroupAction = function () {
            $scope.errorMsg = '';
            if ($scope.blood_group_id === 0) //for create
            {
                Data.post('blood-groups/', {
                    blood_group: $scope.blood_group}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {

                        $scope.bloodGrpRow.push({'blood_group': $scope.blood_group, 'id': response.lastinsertid});
                        $('#bloodGroupModal').modal('toggle');
                        toaster.pop('success', 'Manage Blood Group', 'Record Created Successfully');
                        //$scope.success("Blood group details created successfully");
                    }
                });
            } else {//for update
                Data.put('blood-groups/' + $scope.blood_group_id, {
                    blood_group: $scope.blood_group, id: $scope.blood_group_id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {

                        $scope.bloodGrpRow.splice($scope.index, 1);
                        $scope.bloodGrpRow.splice($scope.index, 0, {
                            blood_group: $scope.blood_group, id: $scope.id});
                        $('#bloodGroupModal').modal('toggle');
                        toaster.pop('success', 'Manage Blood Group', 'Record Updated Successfully');
                        // $scope.success("Blood group details updated successfully");
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);
