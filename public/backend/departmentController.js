app.controller('manageDepartmentCtrl', ['$scope', 'Data', '$rootScope','$timeout', function ($scope, Data, $rootScope,$timeout) {

        $scope.manageDepartment = function () {
            Data.post('manage-department/manageDepartment').then(function (response) {
                $scope.departmentRow = response.records;

            });
        };
        $scope.initialModal = function (id, department_name, index) {

            $scope.heading = 'Department';
            $scope.id = id;
            $scope.department_name = department_name;
            $scope.index = index;
        }
        $scope.dodepartmentAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-department/', {
                    department_name: $scope.department_name}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.departmentRow.push({'department_name': $scope.department_name,'id':response.lastinsertid});
                        $('#departmentModal').modal('toggle');
                      //  $scope.success("Department details created successfully"); 
                    }
                });
            } else { //for update

                Data.put('manage-department/'+$scope.id, {
                    department_name: $scope.department_name, id: $scope.id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.departmentRow.splice($scope.index, 1);
                        $scope.departmentRow.splice($scope.index, 0, {
                            department_name: $scope.department_name, id: $scope.id});
                        $('#departmentModal').modal('toggle');
                      //  $scope.success("Department details updated successfully"); 
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);