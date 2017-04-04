app.controller('manageDepartmentCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', function ($scope, Data, $rootScope, $timeout, toaster) {

        $scope.manageDepartment = function () {
            Data.post('manage-department/manageDepartment').then(function (response) {
                $scope.departmentRow = response.records;
            });
        };
        $scope.initialModal = function (id, vertical_id) {
            alert(vertical_id);
            $scope.heading = 'Departments';
            $scope.id = id;
            $scope.vertical = vertical_id;
            $scope.sbtBtn = false;
            if (id > 0)
            {
                Data.post('manage-department/getDepartment', {id: id}).then(function (response) {
                    console.log(response.records);
                    $("#department_name").val(response.records[0]['department_name']);

                });
            }
        }


        $scope.doDepartmentAction = function (deptData) {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-department/', {
                    department_name: deptData.department_name, vertical_id: deptData.vertical_id, }).then(function (response) {
                   
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.departmentRow.push({'department_name': deptData.department_name, 'vertical_id': deptData.vertical_id, 'id': response.lastinsertid, name: response.vertical});
                        $('#departmentModal').modal('toggle');
                        toaster.pop('success', 'Manage department', 'Record successfully created');
                    }
                });
            } else { //for update

                Data.put('manage-department/' + $scope.id, {
                    department_name: deptData.department_name, vertical_id: deptData.vertical_id, id: $scope.id, }).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.departmentRow.splice($scope.index, 1);
                        $scope.departmentRow.splice($scope.index, 0, {
                            department_name: $scope.department_name, id: $scope.id});
                        $('#departmentModal').modal('toggle');
                        toaster.pop('success', 'Manage department', 'Record successfully updated');
                    }
                });
            }
        }

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);