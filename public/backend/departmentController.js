app.controller('manageDepartmentCtrl', ['$scope', 'Data', '$rootScope', '$timeout', function ($scope, Data, $rootScope, $timeout) {

        $scope.manageDepartment = function () {
            Data.post('manage-department/manageDepartment').then(function (response) {
                $scope.departmentRow = response.records;

            });
        };
        $scope.initialModal = function (id) {
            $scope.heading = 'Departments';
            if (id > 0)
            {
                Data.post('manage-department/getDepartment',{id:id}).then(function (response) {
                   console.log(response.records);
                    $("#department_name").val(response.records[0]['department_name']);
                    //document.getElementById("vertical_id").selectedIndex = 1;
                   // $("#vertical_id").val(response.records[0]['name'])
                });
               
                //$scope.departmentData.department_name="uma";
            }
            $scope.id = id;
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
                        $scope.departmentRow.push({'department_name': deptData.department_name, 'vertical_id': deptData.vertical_id, 'id': response.lastinsertid});
                        $('#departmentModal').modal('toggle');
                        //  $scope.success("Department details created successfully"); 
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
                        //  $scope.success("Department details updated successfully"); 
                    }
                });
            }
        }
        $scope.success = function (message) {
            Flash.create('success', message);
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);