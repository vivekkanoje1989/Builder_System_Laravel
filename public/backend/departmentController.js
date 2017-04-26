app.controller('manageDepartmentCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', function ($scope, Data, $rootScope, $timeout, toaster) {
        $scope.departmentData = {};
        $scope.manageDepartment = function () {
            Data.post('manage-department/manageDepartment').then(function (response) {
                $scope.departmentRow = response.records;

            });
        };
        $scope.initialModal = function (id) {
            $scope.heading = 'Departments';
            $scope.id = id;
            if (id === 0)
            {
                $scope.departmentData = {};
            }
            if (id > 0)
            {
                Data.post('manage-department/getDepartment', {id: id}).then(function (response) {
                    $scope.departmentData.department_name = response.records[0]['department_name'];
                    $scope.departmentData.vertical_id = response.records[0]['vertical_id'];
                });
            }
        }

        $scope.doDepartmentAction = function (deptData) {
            console.log(deptData);
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-department/', {
                    department_name: deptData.department_name, vertical_id: deptData.vertical_id, }).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                        toaster.pop('error', 'Department Master', 'Something Went Wrong!!');
                    } else {
                        $scope.departmentRow.push({'department_name': deptData.department_name, 'vertical_id': deptData.vertical_id, 'id': response.lastinsertid});
                        $('#departmentModal').modal('toggle');
                        toaster.pop('success', 'Department Master', 'Department added successfully');
                    }
                });
            } else { //for update
                Data.put('manage-department/' + $scope.id, {
                    department_name: deptData.department_name, vertical_id: deptData.vertical_id, id: $scope.id, }).then(function (response) {
                    if (!response.success)
                    {
                        toaster.pop('error', 'Manage department', 'Something Went Wrong!!');
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.departmentRow.splice($scope.index, 1);
                        $scope.departmentRow.splice($scope.index, 0, {
                            department_name: $scope.department_name, id: $scope.id });
                        $('#departmentModal').modal('toggle');
                        toaster.pop('success', 'Manage department', 'Department updated successfully');
                        //$scope.departmentRow.push({'department_name': deptData.department_name, 'vertical_id': deptData.vertical_id, 'id': response.lastinsertid});
                        //  $scope.success("Department details updated successfully"); 
                    }
                });
            }
        }
//        $scope.success = function (message) {
//            Flash.create('success', message);
//        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);