app.controller('designationsCtrl', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {

        $scope.itemsPerPage = 30;
        $scope.desig_btn = false;
        $scope.noOfRows = 1;
        
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
        
        
        $scope.manageDesignations = function () {
            Data.post('manage-designations/manageDesignations').then(function (response) {
                $scope.designationsRow = response.records;

            });
        };
        $scope.initialModal = function (id, designation, status, index, index1) {
            $scope.id = id;
            if ($scope.id === 0) //for create
            {
                $scope.heading = 'Create Designation';
            } else {
                $scope.heading = 'Edit Designation';
            }
            $scope.designation = designation;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
            $scope.status = status;
            $scope.sbtBtn = false;
        };
        $scope.dodesignationsAction = function () {
            $scope.errorMsg = '';
            $scope.desig_btn = true;
            if ($scope.id === 0) //for create
            {
                $scope.desig_btn = false;
                Data.post('manage-designations/', {
                    designation: $scope.designation, status: $scope.status}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.designationsRow.push({'designation': $scope.designation, 'id': response.lastinsertid, 'status': $scope.status});
                        $('#designations').modal('toggle');
                        toaster.pop('success', 'Manage designations', 'Record successfully created');
                    }
                });
            } else { //for update
                $scope.desig_btn = false;
                Data.put('manage-designations/' + $scope.id, {
                    designation: $scope.designation, 'status': $scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        if ($scope.index != 0) {
                            $scope.designationsRow.splice($scope.index, 1);
                            $scope.designationsRow.splice($scope.index, 0, {designation: $scope.designation, 'status': $scope.status, id: $scope.id});
                        } else {
                            $scope.manageDesignations();
                        }
                        $('#designations').modal('toggle');
                        toaster.pop('success', 'Manage designations', 'Record successfully updated');
                    }
                });
            }
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
