app.controller('projecttypesController', ['$scope', 'Data', '$rootScope','$timeout', function ($scope, Data, $rootScope,$timeout) {

        $scope.manageProjectTypes = function () {
            Data.post('project-types/manageProjectTypes').then(function (response) {
                $scope.ProjectTypesRow = response.records;
            });
        };
        $scope.initialModal = function (project_type_id, project_type_name, index) {

            $scope.heading = 'Project Types';
            $scope.project_type_id = project_type_id;
            $scope.project_type_name = project_type_name;
            $scope.index = index;
        }


        $scope.doProjectTypesAction = function () {
            $scope.errorMsg = '';
            if ($scope.project_type_id === 0) //for create
            {
                Data.post('project-types/', {
                    project_type_name: $scope.project_type_name}).then(function (response) {
                    
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#projecttypesModal').modal('toggle');
                        $scope.ProjectTypesRow.push({'project_type_name': $scope.project_type_name, 'project_type_id':response.lastinsertid});
                       
                   // $scope.success("Project type created successfully");   
                    }
                });
            } else { //for update

                Data.put('project-types/'+$scope.project_type_id, {
                    project_type_name: $scope.project_type_name, project_type_id: $scope.project_type_id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                       // $scope.success("Project type updated successfully");   
                        $scope.ProjectTypesRow.splice($scope.index, 1);
                        $scope.ProjectTypesRow.splice($scope.index, 0, {
                            project_type_name: $scope.project_type_name, project_type_id: $scope.project_type_id});
                        $('#projecttypesModal').modal('toggle');
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