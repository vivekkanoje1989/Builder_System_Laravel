'use strict';
app.controller('empDeviceController', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout', '$parse', 'toaster', function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout, $parse, toaster) {
        $scope.currentPage = $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;

        $scope.manageDevice = function (id, action)
        {
            Data.post('employee-device/manageDevice', {
                id: id,
            }).then(function (response) {
                if (id === 'index')
                {
                    $scope.listDevices = response.records;
                }
                if (id > 0)
                {
                    $scope.btnLable = 'Save'
                    $scope.deviceData = angular.copy(response.records[0]);
                }
                if (id === 0)
                {
                    $scope.btnLable = 'Create';
                }
            })
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
                        toaster.pop('error', 'Employee Device', 'Something went wrong.');
                    } else
                    {
                        toaster.pop('success', 'Employee Device', 'Device Added successfully.');
                        $state.go(getUrl + '.employeeDeviceIndex');
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
                        $state.go(getUrl + '.employeeDeviceIndex');

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