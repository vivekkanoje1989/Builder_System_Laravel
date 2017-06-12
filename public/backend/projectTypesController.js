app.controller('projecttypesController', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {

        $scope.noOfRows = 1;
        $scope.itemsPerPage = 30;
        $scope.manageProjectTypes = function () {
            Data.post('project-types/manageProjectTypes').then(function (response) {
                $scope.ProjectTypesRow = response.records;
            });
        };
        $scope.initialModal = function (id, project_type, index, index1) {
            if (id == 0){
                $scope.heading = 'Add Project Types';
                $scope.id = '0';
                $scope.project_type = '';
                $scope.action = 'Add';
            } else {
                $scope.heading = 'Edit Project Types';
                $scope.id = id;
                $scope.project_type = project_type;
                $scope.action = 'Update';
            }
            $scope.sbtBtn = false;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
        }
        $scope.doProjectTypesAction = function () {
            $scope.errorMsg = '';
            if ($scope.id == 0) //for create
            {
                Data.post('project-types/', {
                    project_type: $scope.project_type}).then(function (response) {
                    if (!response.success){
                        $scope.errorMsg = response.errormsg;
                    } else {

                        $('#projecttypesModal').modal('toggle');
                        $scope.ProjectTypesRow.push({'project_type': $scope.project_type, 'id': response.lastinsertid});
                        toaster.pop('success', 'Project types', 'Record successfully created');
                    }
                });
            } else { //for update
                Data.put('project-types/' + $scope.id, {
                    project_type: $scope.project_type, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.ProjectTypesRow.splice($scope.index, 1);
                        $scope.ProjectTypesRow.splice($scope.index, 0, {
                            project_type: $scope.project_type, id: $scope.id});
                        $('#projecttypesModal').modal('toggle');
                        toaster.pop('success', 'Project types', 'Record successfully updated');
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);