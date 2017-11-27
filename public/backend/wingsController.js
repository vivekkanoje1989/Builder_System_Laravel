app.controller('wingsController', ['$scope', '$state', 'Data', 'toaster', function ($scope, $state, Data, toaster) {
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.wingData = {};

        $scope.manageWings = function (id)
        {
            Data.post('wings/getWingList', {id: id}).then(function (response) {
                if (id < 0)
                { // For Index
                    if (response.success) {
                        $scope.listWings = response.records;
                        $scope.exportData = response.exportData;
                        $scope.deleteBtn = response.deletePermission;
                    }else{
                        $scope.totalCount = 0;
                    }

                }
                if (id > 0)
                { // For Update
                    $scope.pageHeading = "Update Wing";
                    $scope.savebtn = "Save";
                    $scope.wingData = angular.copy(response.records[0]);
                }
                if (id === 0)
                { // For Craete
                    $scope.pageHeading = "Create Wing";
                    $scope.savebtn = "Create";
                }
            })

        }
         $scope.deleteWing = function (id, index) {
            Data.post('wings/deleteWing', {
                'id': id}).then(function (response) {
                toaster.pop('success', 'Careers', 'Project wing deleted successfully');
                $scope.listWings.splice(index, 1);
            });
        }
        
        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteWing(args['id'], args['index']);
        });
        
        
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
        
        
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
           $scope.projectWingsExportToxls = function () {
            $scope.getexcel = window.location = "/wings/projectWingsExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }

        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.saveWingsInfo = function (wingData, id) {
            wingData.wing_status = (typeof wingData.wing_status === 'undefined') ? 2 : wingData.wing_status;
            wingData.wing_status_for_enquiries = (typeof wingData.wing_status_for_enquiries === 'undefined') ? 2 : wingData.wing_status_for_enquiries;
            wingData.wing_status_for_bookings = (typeof wingData.wing_status_for_bookings === 'undefined') ? 2 : wingData.wing_status_for_bookings;
            if (id === 0)
            { // For Create
                Data.post('wings', {wingData: wingData}).then(function (response) {
                    if (!response.success)
                    {
                        toaster.pop('error', 'Project Wings', 'Something Went Wrong');
                    } else
                    {
                        toaster.pop('success', 'Project Wings', 'Wing Created Successfully.');
                        $state.go('wingsIndex');
                    }
                })
            } else
            { // For Update 
                Data.put('wings/' + id, {wingData: wingData}).then(function (response) {
                    if (!response.success)
                    {
                        toaster.pop('error', 'Project Wings', 'Something Went Wrong');
                    } else
                    {
                        toaster.pop('success', 'Project Wings', 'Wing Updated Successfully.');
                        $state.go('wingsIndex');
                    }
                })
            }
        }
    }]);