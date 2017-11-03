'use strict';
app.controller('logdetailController', ['$scope', 'Data', '$filter', 'Upload', '$window', '$timeout', '$state', '$rootScope', 'toaster', function ($scope, Data, $filter, Upload, $window, $timeout, $state, $rootScope, toaster) {
        $scope.pageHeading = 'Logs Details';

        $scope.btnsend = false;
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.smslogslist = [];
        $scope.smslogslistdetail = [];
        $scope.flagForChange = 0;
        $scope.filterData = {};
        $scope.teamtype = '';
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

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

        $scope.pageChanged = function (pageNo, type, functionName, itemsPerPage) {
            $scope.flagForChange++;

            if ($scope.flagForChange == 1) {
                if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                    $scope.getDetailFilteredData($scope.filterData, pageNo, $scope.itemsPerPage);

                } else {

                    $scope[functionName](type, pageNo, itemsPerPage);

                }
            }
            $scope.pageNumber = pageNo;
        };



        $scope.getProcName = $scope.type = '';

        $scope.procName = function (procedureName, type) {
            $scope.getProcName = angular.copy(procedureName);
            $scope.type = type;
        }


        $scope.removeDataFromFilter = function (keyvalue) {
            $scope.showloader();
            delete $scope.filterData[keyvalue];
            $scope.getDetailFilteredData($scope.filterData, 1, 30);
            $scope.hideloader();
            return false;
        }


        /* Detail logs functionality*/

        $scope.logdetail = function (tranid, empid) {
            $scope.tranid = tranid;
            $scope.empid = empid;

        }

        $scope.managedetailLogs = function (type, pageNumber, itemPerPage) {

            Data.post('/promotionalsms/getalllogdetail', {
                externalId1: $scope.tranid, employee_id: $scope.empid, pageNumber: pageNumber, itemPerPage: itemPerPage
            }).then(function (response) {
                if (response.success) {
                    $scope.smslogslistdetail = response.records;
                    $scope.smslogslength = response.totalCount;
                    $scope.logDetailsExport = response.logDetailsExport;

                }else{
                     $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
                $scope.flagForChange = 0;
            });
        }

        $scope.logDetailsExportToxls = function () {
//            alert( $scope.tranid);
            $scope.getexcel = window.location = "/promotionalsms/logDetailsExportToxls/"+$scope.tranid;
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }


        $scope.getDetailFilteredData = function (filterData, page, noOfRecords) {
            $scope.showloader();
            if (typeof filterData.fromDate !== 'undefined') {
                var fdate = new Date(filterData.fromDate);
                $scope.filterData.fromDate = (fdate.getFullYear() + '-' + ("0" + (fdate.getMonth() + 1)).slice(-2) + '-' + fdate.getDate());
            }
            if (typeof filterData.toDate !== 'undefined') {
                var tdate = new Date(filterData.toDate);
                $scope.filterData.toDate = (tdate.getFullYear() + '-' + ("0" + (tdate.getMonth() + 1)).slice(-2) + '-' + tdate.getDate());
            }


            Data.post('/promotionalsms/getDetailFilterdata', {filterData: filterData, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords, externalId1: $scope.tranid, employee_id: $scope.empid}).then(function (response) {
                //  console.log(filterData);
                if (response.success)
                {
                    $scope.smslogslistdetail = response.records;
                    $scope.smslogslength = response.totalCount;

                } else
                {
                    $scope.smslogslistdetail = '';
                    $scope.smslogslength = 0;

                }
                $('#showFilterModal').modal('hide');
                $scope.showFilterData = $scope.filterData;
                $scope.hideloader();
                $scope.flagForChange = 0;
                return false;
            });
        }


    }]);