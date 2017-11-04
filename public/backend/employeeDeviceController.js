'use strict';
app.controller('empDeviceController', ['$scope', '$state', 'Data', 'toaster', '$parse', '$modal', function ($scope, $state, Data, toaster, $parse, $modal) {
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.filterDetails = function (search) {
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
        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.showHelpEmployeeDevice = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Employee Devices</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }

        $scope.employeeDeviceExportToxls = function () {
            $scope.getexcel = window.location = "/employee-device/employeeDeviceExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }

        $scope.deleteEmployeeDevice = function (id, index) {
            Data.post('employee-device/deleteEmployeeDevice', {
                'id': id}).then(function (response) {
                $scope.listDevices.splice(index, 1);
            });
        }

        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteEmployeeDevice(args['id'], args['index']);
        });

        $scope.manageDevice = function (id, action)
        {
            Data.post('employee-device/manageDevice', {
                id: id,
            }).then(function (response) {
                if (id === 'index')
                {
                    if (response.success) {
                        $scope.listDevices = response.records;
                        $scope.exportData = response.exportData;
                        $scope.deleteBtn = response.delete;
                    } else {
                        $scope.hideloader();
                        $scope.totalCount = 0;
                        $scope.disableBtn = true;
                    }
                }
                if (id > 0)
                {
                    $scope.btnLable = 'Update';
                    $scope.heading = 'Edit Device Details';
                    $scope.deviceData = angular.copy(response.records[0]);
                }
                if (id === 0)
                {
                    $scope.heading = 'Add Device Details';
                    $scope.btnLable = 'Add';
                }
            });
        }
        $scope.saveDeviceConfig = function (id, data)
        {
            if (id === 0)
            {
                Data.post('employee-device/', {
                    id: id, data: data,
                }).then(function (response) {
                    if (!response.success)
                    {
                        var obj = response.message;
                        var selector = [];
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                            selector.push(key);

                        }
                    } else
                    {
                        toaster.pop('success', 'Employee Device', 'Device Added successfully.');
                        $state.go('employeeDeviceIndex');
                    }
                })
            } else
            {
                Data.put('employee-device/' + id, {
                    id: id, data: data,
                }).then(function (response) {
                    if (!response.success)
                    {
                        toaster.pop('error', 'Employee Device', 'Something went wrong.');
                    } else
                    {
                        toaster.pop('success', 'Employee Device', 'Device updated successfully.');
                        $state.go('employeeDeviceIndex');

                    }
                })
            }
        }
    }]);

app.controller('getAllEmployeesCtrl', function ($scope, Data) {
    $scope.employeeList = [];
    Data.get('employee-device/getAllEmployeesList').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.employeeList = response.records;
        }
    });
});