app.controller('manageDepartmentCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', function ($scope, Data, $rootScope, $timeout, toaster) {

        $scope.manageDepartment = function () {
            Data.post('manage-department/manageDepartment').then(function (response) {
                $scope.departmentRow = response.records;
            });
        };
        $scope.initialModal = function (id, department_name, vertical_id) {
            $scope.heading = 'Departments';
            $scope.id = id;
            if ($scope.id > 0)
            {
                $scope.vertical_id = vertical_id;
            }
            $scope.sbtBtn = false;
            $scope.department_name = department_name;
        };
        $scope.doDepartmentAction = function () {
            $scope.errorMsg = '';
            alert($scope.vertical_id);
            if ($scope.id === 0) //for create
            {
                Data.post('manage-department/', {
                    department_name: $scope.department_name, vertical_id: $scope.vertical_id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.departmentRow.push({'department_name': $scope.department_name, 'vertical_id': $scope.vertical_id, 'id': response.lastinsertid, name: response.vertical});
                        $('#departmentModal').modal('toggle');
                        toaster.pop('success', 'Manage department', 'Record successfully created');
                    }
                });
            } else { //for update
                Data.put('manage-department/' + $scope.id, {
                    department_name: $scope.department_name, vertical_id: $scope.vertical_id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.departmentRow.splice($scope.index, 1);
                        $scope.departmentRow.splice($scope.index, 0, {
                            department_name: $scope.department_name, id: $scope.id, 'vertical_id': $scope.vertical_id });
                        $('#departmentModal').modal('toggle');
                        toaster.pop('success', 'Manage department', 'Record successfully updated');
                    }
                });
            }
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);