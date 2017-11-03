'use strict';
app.controller('customalertsController', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout', 'toaster','$modal', function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout, toaster, $modal) {
        $scope.pageHeading = 'Create Custom Template';
        $scope.buttonLabel = 'Create';
        $scope.customAlertData = {};
        $scope.listcustomAlerts = [];
        $scope.templateEvents = [];
        $scope.isDisabled = false;
        $scope.customAlertData.client_id = 1;
        $scope.currentPage = $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.exportData = '';
        $scope.pageNumber = 1;
        $scope.pageChanged = function (pageNo, functionName, id, type, pageNumber) {
            $scope[functionName](id, type, pageNumber, $scope.itemsPerPage);
            $scope.pageNumber = pageNo;
        };

        $scope.getTemplatesEvents = function () {
            Data.post('alerts/getTemplatesEvents').then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.templateEvents = response.records;
                }
            });
        };
             $scope.showHelpCustomTemplate = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Custom Template Settings</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }
        

        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
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

        $scope.deleteCustomTemplate = function (id, index) {
            Data.post('customalerts/deleteCustomTemplate', {
                'id': id}).then(function (response) {
//                toaster.pop('success', 'Custom template', 'Custom Template deleted successfully');
//                $scope.listcustomAlerts.splice(index, 1);
                $("tr#"+id+"").remove();
            });
        }

        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteCustomTemplate(args['id'], args['index']);
        });

        $scope.createAlert = function (enteredData, alterId) {
            var customAlertData = {};
            $scope.isDisabled = true;
            customAlertData = angular.fromJson(angular.toJson(enteredData));
            if (alterId === 0)
            {
                Data.post('customalerts/', {
                    customAlertData: customAlertData}).then(function (response) {
                    $scope.isDisabled = false;
                    if (!response.success)
                    {
                        toaster.pop('error', 'Custom Template', response.message);
                    } else {
                        toaster.pop('success', 'Custom Template', response.message);
                        $timeout(function () {
                            $state.go('customalertsIndex');
                        }, 1000);
                    }
                });
            } else {
                Data.post('customalerts/updateCustomAlerts', {
                    customAlertData: customAlertData, id: alterId}).then(function (response) {
                    $scope.isDisabled = false;
                    if (!response.success)
                    {
                        toaster.pop('error', 'Custom Template', response.message);
                    } else {
                        toaster.pop('success', 'Custom Template', response.message);
                        $timeout(function () {
                            $state.go('customalertsIndex');
                        }, 1000);
                    }
                });
            }
        };

        $scope.manageAlerts = function (id, action, pageNumber = '', itemPerPage = '') { //edit/index action
            $scope.modal = {};
            $scope.showloader();
            Data.post('customalerts/manageCustomAlerts', {
                id: id, pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                if (response.success) {
                    if (action === 'index') {
                        $scope.listcustomAlerts = response.records.data;
                        $scope.exportData = response.records.exportData;
                        $scope.deleteBtn = response.records.delete;
                        $scope.listcustomAlertsLength = response.records.total;
                    } else if (action === 'edit') {
                        if (id !== '0') {
                            $scope.pageHeading = 'Edit Custom Template';
                            $scope.buttonLabel = 'Update';
                            $scope.isDisabled = true;
                            $scope.customAlertData = angular.copy(response.records.data[0]);
                        }
                    }
                } else {
                    $scope.errorMsg = response.message;
                }
                $scope.hideloader();
            });
        };

        $scope.customTemplatesExportToxls = function () {
            $scope.getexcel = window.location = "/customalerts/customTemplatesExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
app.directive('ckEditor', function () {
    return {
        require: '?ngModel',
        link: function ($scope, elm, attr, ngModel) {

            var ck = CKEDITOR.replace(elm[0]);


            ck.on('instanceReady', function () {
                ck.setData(ngModel.$viewValue);
            });

            ck.on('pasteState', function () {
                $scope.$apply(function () {
                    ngModel.$setViewValue(ck.getData());
                });
            });

            ngModel.$render = function (value) {
                ck.setData(ngModel.$modelValue);
            };
        }
    };
});

