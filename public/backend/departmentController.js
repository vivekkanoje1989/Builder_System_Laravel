app.controller('manageDepartmentCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', function ($scope, Data, $rootScope, $timeout, toaster) {
        $scope.departmentData = {};
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.deptBtn = false;
        $scope.manageDepartment = function () {
            Data.post('manage-department/manageDepartment').then(function (response) {
                $scope.departmentRow = response.records;
            });
        };
        $scope.initialModal = function (id, list, index, index1) {
            if (id == 0)
            {
                $scope.heading = 'Add Departments';
                $scope.action = 'Add';
            } else {
                $scope.heading = 'Edit Departments';
                $scope.action = 'Update';
                $scope.departmentData.department_name = list.department_name;
                $scope.departmentData.vertical_id = list.vertical.id;
            }
            $scope.id = id;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);

        }

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

        
        $scope.doDepartmentAction = function (deptData) {
            $scope.errorMsg = '';
            $scope.deptBtn = true;
            if ($scope.id === 0) //for create
            {
                $scope.deptBtn = false;
                Data.post('manage-department/', {
                    department_name: deptData.department_name, vertical_id: deptData.vertical_id, }).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                        toaster.pop('error', 'Manage department', 'Something Went Wrong!!');
                    } else {
                        $scope.departmentRow.push({'department_name': deptData.department_name, 'vertical_id': deptData.vertical_id, 'id': response.lastinsertid});
                        $('#departmentModal').modal('toggle');
                        toaster.pop('success', 'Manage department', 'Record added successfully');
                    }
                });
            } else { //for update
                $scope.deptBtn = false;
                Data.put('manage-department/' + $scope.id, {
                    department_name: deptData.department_name, vertical_id: deptData.vertical_id, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        toaster.pop('error', 'Manage department', 'Something Went Wrong!!');
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.vertical = {'id': deptData.vertical_id, 'name': response.vertical.name, };
                        $scope.departmentRow.splice($scope.index, 1);
                        $scope.departmentRow.splice($scope.index, 0, {
                            department_name: deptData.department_name, vertical: $scope.vertical, id: $scope.id});
                        $('#departmentModal').modal('toggle');
                        toaster.pop('success', 'Manage department', 'Record updated successfully');
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);