'use strict';
app.controller('promotionalsmsController', ['$scope', 'Data', 'Upload', '$timeout', '$state', 'toaster', '$modal', function ($scope, Data, Upload, $timeout, $state, toaster, $modal) {
        $scope.pageHeading = 'Promotional SMS';
        $scope.promotionalsmsData = {};
        $scope.btnsend = false;
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.smslogslist = [];
        $scope.flagForChange = 0;
        $scope.filterData = {};
        $scope.salesEnqSubCategoryList = [];
        $scope.subsalesStatusList = [];
        $scope.subSourceList = [];
        $scope.teamtype = '';
        $scope.customertotalcount = '0';

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

        $scope.pageChanged = function (pageNo, type, functionName, itemsPerPage) {
            $scope.flagForChange++;

            if ($scope.flagForChange == 1) {
                if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                    $scope.getFilteredData($scope.filterData, pageNo, $scope.itemsPerPage);

                } else {
                    $scope[functionName](type, pageNo, itemsPerPage);

                }
            }
            $scope.pageNumber = pageNo;
        };



        $scope.showHelpSmsLogs = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Sms Logs</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }
        $scope.showHelpTeamSmsLogs = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Team Sms Logs</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
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
            $scope.searchData = search;
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }

        $scope.sendPromotionalSMS = function (promotionalsmsData, numberFile) {
            $scope.submitted = true;
            $scope.btnsend = true;
            var url = '/promotionalsms';
            var data = {promotionalsmsData: promotionalsmsData, numberFile: numberFile};
            numberFile.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            }).then(function (response, evt) {
                toaster.pop('success', 'Promotional SMS', "SMS Send Successfully");
                $timeout(function () {
                    $scope.promotionalsmsData = {};
                    $scope.promotionalsmsData.send_sms_type = 1;
                    $scope.promotionalsmsData.sms_type = 1;
                    $scope.promotionalsmsData.mobilenumbers = "";
                    $scope.customertotalcount = '0';
                    $scope.step1 = false;
                    $('#totalsms').html(1);
                    $("#totalnumbers").html(0);
                    $('#totalcharacters').html(0);
                    $scope.btnsend = false;
                    $state.go('promotionalsms');
                });
            });

        };

        $scope.managesmsLogs = function (type, pageNumber, itemPerPage) {
            $scope.showloader();
            Data.post('/promotionalsms/getSmslogs', {
                isTeam: type, pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                if (response.success) {
                    if (type == 1) {
                        $scope.teamsmslogslist = response.records;
                        $scope.teamsmslogslength = response.totalCount;
                        $scope.teamSmsExport = response.exportSmsLogs;
                    } else if (type == 0) {
                        $scope.smslogslist = response.records;
                        $scope.smslogslength = response.totalCount;
                        $scope.exportSmsLogs = response.exportSmsLogs;
                    }
                } else {
                    $scope.teamsmslogslength = response.totalCount;
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;

                }
                $scope.flagForChange = 0;
                $scope.hideloader();
            });
        }

        $scope.teamSmsLogsExpotToxls = function () {
            $scope.getexcel = window.location = "/promotionalsms/teamSmsLogsExpotToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting');
            } else {
                toaster.pop('error', '', 'Exporting fails');
            }
        }

        $scope.smsLogsExpotToxls = function () {
            $scope.getexcel = window.location = "/promotionalsms/smsLogsExpotToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }
    }]);