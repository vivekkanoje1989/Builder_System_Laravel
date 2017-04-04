'use strict';
app.controller('bloodGroupCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', function ($scope, Data, $rootScope, $timeout, toaster) {

        $scope.manageBloodGroup = function () {
            Data.post('blood-groups/manageBloodGroup').then(function (response) {
                $scope.bloodGrpRow = response.records;
            });
        };
        $scope.initialModal = function (id, name, index) {
            $scope.heading = 'Blood Group';
            $scope.id = id;
            $scope.blood_group = name;
            $scope.index = index;
            $scope.sbtBtn = false;
        }
        $scope.doBloodGroupAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('blood-groups/', {
                    blood_group: $scope.blood_group}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.bloodGrpRow.push({'blood_group': $scope.blood_group, 'id': response.lastinsertid});
                        $('#bloodGroupModal').modal('toggle');
                        toaster.pop('success', 'Blood group', 'Record successfully created');
                    }
                });
            } else {//for update
                Data.put('blood-groups/' + $scope.blood_group_id, {
                    blood_group: $scope.blood_group, id: $scope.id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.bloodGrpRow.splice($scope.index, 1);
                        $scope.bloodGrpRow.splice($scope.index, 0, {
                            blood_group: $scope.blood_group, id: $scope.id});
                        $('#bloodGroupModal').modal('toggle');
                        toaster.pop('success', 'Blood group', 'Record successfully updated');
                    }
                });
            }
        }

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
