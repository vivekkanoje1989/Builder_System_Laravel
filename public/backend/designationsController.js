app.controller('designationsCtrl', ['$scope', 'Data','toaster', function ($scope, Data,toaster) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageDesignations = function () {
            Data.post('manage-designations/manageDesignations').then(function (response) {
                $scope.designationsRow = response.records;

            });
        };
        $scope.initialModal = function (id, designation,status, index,index1) {
           
            $scope.heading = 'Manage Designations';
            $scope.id = id;
            $scope.designation = designation;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
            $scope.status = status;
            $scope.sbtBtn = false;
        };
        $scope.dodesignationsAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-designations/', {
                    designation: $scope.designation,status :$scope.status}).then(function (response) {
             
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.designationsRow.push({'designation': $scope.designation, 'id': response.lastinsertid,'status':$scope.status});
                        $('#designations').modal('toggle');
                       toaster.pop('success', 'Manage designations', 'Record successfully created');
                    }
                });
            } else { //for update

                Data.put('manage-designations/'+$scope.id, {
                    designation: $scope.designation,'status':$scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.designationsRow.splice($scope.index, 1);
                        $scope.designationsRow.splice($scope.index, 0, { designation: $scope.designation,'status':$scope.status,id:$scope.id});
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
