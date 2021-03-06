'use strict';
app.controller('defaultalertsController', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout', 'toaster','$modal', function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout, toaster, $modal) {
        $scope.pageHeading = 'Create Custome Alert';
        $scope.buttonLabel = 'Create';
        $scope.defaultAlertData = {};
        $scope.listdefaultAlerts = [];
        $scope.templateEvents = [];
        $scope.currentPage = $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.exportData = '';

        $scope.getTemplatesEvents = function () {
            Data.post('alerts/getTemplatesEvents').then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.templateEvents = response.records;
                }
            });
        };
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

        $scope.showHelpDefaultTemplate = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Default Template Settings</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }

        $scope.deleteDefaultTemplate = function (id, index) {
            Data.post('defaultalerts/deleteDefaultTemplate', {
                'id': id}).then(function (response) {
//                toaster.pop('success', 'Manage Default Template', 'Default Template deleted successfully');
//                $scope.listdefaultAlerts.splice(index, 1);
                $("tr#" + id + "").remove();
            });
        }

        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteDefaultTemplate(args['id'], args['index']);
        });

        $scope.defaultTemplatesExportToxls = function () {
            $scope.getexcel = window.location = "/defaultalerts/defaultTemplatesExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }
        $scope.createAlert = function (enteredData, alterId) {
            var defaultAlertData = {};
            defaultAlertData = angular.fromJson(angular.toJson(enteredData));
            if (alterId === 0)
            {
                Data.post('defaultalerts/', {
                    defaultAlertData: defaultAlertData}).then(function (response) {

                    if (!response.success)
                    {
                        toaster.pop('error', 'Default Template', response.errormsg);
                    } else {
                        toaster.pop('success', 'Default Template', response.successMsg);
                        $timeout(function () {
                            $state.go('defaultalertsIndex');
                        }, 1000);
                    }
                });
            } else {

                Data.post('defaultalerts/updateDefaultAlerts', {
                    defaultAlertData: defaultAlertData, id: alterId}).then(function (response) {
                    if (!response.success)
                    {
                        toaster.pop('error', 'Default Template', response.errorMsg);
                    } else {
                        toaster.pop('success', 'Default Template', response.successMsg);
                        $timeout(function () {
                            $state.go('defaultalertsIndex');
                        }, 1000);
                    }
                });
            }
        };

        $scope.manageDafaultAlerts = function (id, action) { //edit/index action
            $scope.modal = {};
            $scope.showloader();
            Data.post('defaultalerts/manageDafaultAlerts', {
                id: id,
            }).then(function (response) {
                if (response.success) {
                    if (action === 'index') {
                        $scope.listdefaultAlerts = response.records.data;
                        $scope.exportData = response.records.exportData;
                        $scope.deleteBtn = response.records.delete;
                        $scope.listdefaultAlertsLength = response.records.total;
                    } else if (action === 'edit') {
                        if (id !== '0') {
                            $scope.pageHeading = 'Default Template';
                            $scope.buttonLabel = 'Update';
                            $scope.defaultAlertData = angular.copy(response.records.data[0]);
                        }
                    }
                } else {
                    $scope.errorMsg = response.message;
                }
                $scope.hideloader();
            });
        };

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
