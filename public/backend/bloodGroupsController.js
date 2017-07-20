'use strict';
app.controller('bloodGroupCtrl', ['$scope', 'Data', '$rootScope', '$timeout', function ($scope, Data, $rootScope, $timeout) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.manageBloodGroup = function () {
            Data.post('blood-groups/manageBloodGroup').then(function (response) {
                $scope.bloodGrpRow = response.records;
            });
        };
        $scope.initialModal = function (id, name, index, index1) {
            if (id == 0)
            {
                $scope.heading = 'Add blood group';
                $scope.action = 'Submit';
            }else{ $scope.heading = 'Edit blood group'; $scope.action = 'Update'; }
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
