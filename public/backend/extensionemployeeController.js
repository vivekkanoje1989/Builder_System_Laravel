'use strict';
app.controller('extensionemployeeController', ['$scope', 'Data', '$filter', 'Upload', '$window', '$timeout', '$state', '$rootScope', '$stateParams', 'toaster', function ($scope, Data, $filter, Upload, $window, $timeout, $state, $rootScope, $stateParams, toaster) {
        $scope.pageHeading = 'Extension Employees';
        $scope.itemsPerPage = 30;
        $scope.btnSubmit = false;
        $scope.noOfRows = 1;

        $scope.manageExtEmpLists = function () {
            Data.get('getCtEmployeeExtension').then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.ct_employee_extlist = response.records;
                    $scope.exportEmpExtensionData = response.exportData;
                    $scope.deleteData = response.delete;
                }
            });
        }
        
        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }
        
        $scope.employeeExtExportToxls = function () {
            $scope.getexcel = window.location = "employeeExtExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }
        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.filterDetails = function (search) {
            $scope.searchData = search;
        }

        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }

        $scope.deleteEmpExt = function (id, index) {
            Data.post('deleteEmpExt', {
                'id': id}).then(function (response) {
//                toaster.pop('success', 'Manage Templates', 'Employee Extension deleted successfully');
                $scope.ct_employee_extlist.splice(index, 1);
            });
        }
        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteEmpExt(args['id'], args['index']);
        });
        

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        $scope.initExtensionModal = function (employeelist) {
            $scope.btnlable = "Add";
            $scope.heading = "Add Extension";
            Data.post('getExtensionEmployee', {
                employees: employeelist
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.ext_number = response.extesion_no;
                    $scope.ext_employee = response.records;
                    $scope.extensionData = {};
                }
            });
        }

        $scope.editExtensionModal = function (employeelist, listNumber) {
            $scope.btnlable = "Update";
            $scope.heading = "Edit Extension";
            employeelist = {};
            $scope.extensionData = {};
            Data.post('getExtensionEmployee', {
                employees: employeelist, listNumber: listNumber
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.ext_number = response.extesion_no;
                    $scope.ext_employee = response.records;
//                        $scope.ext_number.push(listNumber.extension_no);
                    $scope.extensionData.extension_no = listNumber.extension_no;
                    $scope.extensionData.employee_id = listNumber.employee_id;

                }
            });
        }

        $scope.createExtension = function (extensionData) {
            $scope.btnSubmit = true;
            Data.post('createExtEmployee', {
                extensionData: extensionData
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $timeout(function () {

                        if (response.flag == 'create') {
                            $scope.btnSubmit = false;
                            $scope.ext_employee = response.records;
                            toaster.pop('success', 'Extension Employee', 'Extension Created Successfully');
                            $('#addExtensionModal').modal('toggle');
                            $state.go('extensionemplist');
                            Data.get('getCtEmployeeExtension').then(function (response) {
                                if (!response.success) {
                                    $scope.errorMsg = response.message;
                                } else {
                                    $scope.ct_employee_extlist = response.records;
                                }
                            });
                        } else if (response.flag == 'update') {
                            $scope.btnSubmit = false;
                            toaster.pop('success', 'Extension Employee', 'Extension Updated Successfully!!');
                            $('#addExtensionModal').modal('toggle');
                            $state.go('extensionemplist');
                            Data.get('getCtEmployeeExtension').then(function (response) {
                                if (!response.success) {
                                    $scope.errorMsg = response.message;
                                } else {
                                    $scope.ct_employee_extlist = response.records;
                                }
                            });
                        }

                    }, 1000);

                }
            });
        }

        $scope.getEmployeeExtData = function () {

            Data.get('getEmployeeExtData').then(function (response) {
                $scope.extNumber = response.records;
            });
        }
    }]);





