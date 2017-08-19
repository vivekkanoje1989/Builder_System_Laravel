app.controller('discountheadingController', ['$scope', 'Data', '$rootScope', 'toaster', function ($scope, Data, $rootScope, toaster) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.pageNumber = 1;

//        $scope.pageChanged = function (pageNo, functionName, id) {
//            $scope[functionName](id, pageNo, $scope.itemsPerPage);
//            $scope.pageNumber = pageNo;
//        };
//        $scope.pageChanged = function (pageNo, functionName, id, newpage) {
//            $scope.flagForChange++;
//
//            if ($scope.flagForChange == 1)
//            {
//                if (($scope.filterData && Object.keys($scope.filterData).length > 0)) {
//                    $scope.filteredData($scope.filterData, pageNo, $scope.itemsPerPage);
//                } else {
//                    $scope[functionName](id, pageNo, $scope.itemsPerPage);
//                }
//            }
//            $scope.pageNumber = pageNo;
//        }

        $scope.manageDiscountHeading = function (empId, pageNumber, itemPerPage) {

            Data.post('discount-headings/manageDiscountHeading').then(function (response) {
                $scope.DiscountHeadingRow = response.records;
                $scope.DiscountHeadingRowLength = response.totalCount;
            });
        };
        
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
        


//        $scope.getProcName = $scope.type = '';
//        $scope.procName = function (procedureName, isTeam) {
//            $scope.getProcName = angular.copy(procedureName);
//            $scope.type = angular.copy(isTeam);
//        }
//
//
//        $scope.filterData = {};
//        $scope.data = {};
//
//        $scope.filteredData = function (data, page, noOfRecords) {
//            $scope.showloader();
//            Data.post('discount-headings/filteredData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords}).then(function (response) {
//                if (response.success)
//                {
//                    $scope.DiscountHeadingRow = response.records;
//                    $scope.DiscountHeadingRowLength = response.totalCount;
//                } else
//                {
//                    $scope.DiscountHeadingRow = response.records;
//                    $scope.DiscountHeadingRowLength = 0;
//                }
//                $('#showFilterModal').modal('hide');
//                $scope.showFilterData = $scope.filterData;
//                $scope.hideloader();
//                return false;
//
//            });
//        }
//
//        $scope.removeDataFromFilter = function (keyvalue)
//        {
//            delete $scope.filterData[keyvalue];
//            $scope.filteredData($scope.filterData, 1, 30);
//        }


        $scope.initialModal = function (id, discount_name, status, index, index1) {

            if (id == 0)
            {
                $scope.heading = 'Add Discount Heading';
                $scope.action = 'submit';
            } else {
                $scope.heading = 'Edit Discount Heading';
                $scope.action = 'Update';
            }
            $scope.actionModal = id;
            $scope.discount_name = discount_name;
            $scope.status = status;
            $scope.sbtBtn = false;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
        }
        $scope.doDiscountHeadingAction = function () {
            $scope.errorMsg = '';
            if ($scope.actionModal === 0) //for create
            {
                Data.post('discount-headings/', {
                    discount_name: $scope.discount_name}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#discountheadingModal').modal('toggle');
                        $scope.DiscountHeadingRow.push({'discount_name': $scope.discount_name, 'id': response.lastinsertid, 'status': $scope.status});
                        toaster.pop('success', 'Manage Discount', 'Record Created Successfully');
                    }
                });
            } else { //for update
                Data.put('discount-headings/' + $scope.actionModal, {
                    discount_name: $scope.discount_name, status: $scope.status, id: $scope.actionModal}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.DiscountHeadingRow.splice($scope.index, 1);
                        $scope.DiscountHeadingRow.splice($scope.index, 0, {
                            discount_name: $scope.discount_name, 'status': $scope.status, id: $scope.id});
                        $('#discountheadingModal').modal('toggle');
                        toaster.pop('success', 'Manage Discount', 'Record Updated Successfully');
                    }
                });
            }
        }

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
