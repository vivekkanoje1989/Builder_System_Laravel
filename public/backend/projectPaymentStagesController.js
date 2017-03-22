app.controller('projectpaymentController', ['$scope', 'Data', '$rootScope','$timeout', function ($scope, Data, $rootScope,$timeout) {

        $scope.manageProjectPaymentStages = function () {
            Data.post('project-payment/manageProjectPaymentStages').then(function (response) {
                $scope.ProjectPaymentStagesRow = response.records;
            });
        };
        $scope.initialModal = function (id, project_stages, project_type_id,index) {

            $scope.heading = 'Project payment stages';
            $scope.id = id;
            $scope.project_stages = project_stages;
            $scope.index = index;
            $scope.project_type = project_type_id;
        }
        $scope.getProjectTypes = function()
        {
             Data.post('project-payment/manageProjectTypes').then(function (response) {
                $scope.ProjectTypesRow = response.records;  
            });
        }
        $scope.doprojectpaymentAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('project-payment', {
                    project_stages: $scope.project_stages,project_type_id:$scope.project_type_id}).then(function (response) {
                  console.log(response);
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#projectpaymentModal').modal('toggle');
                        $scope.ProjectPaymentStagesRow.push({'project_stages': $scope.project_stages, 'id': response.lastinsertid, 'status': $scope.status,'project_type_id':$scope.project_type_id});
                       
                        // $scope.success("Project payment stages created successfully");   
                    }
                });
            } else { //for update

                Data.put('project-payment/'+$scope.id, {
                    project_stages: $scope.project_stages, id: $scope.id,project_type_id:$scope.project_type_id}).then(function (response) {
                   
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.ProjectPaymentStagesRow.splice($scope.index, 1);
                        $scope.ProjectPaymentStagesRow.splice($scope.index, 0, {
                            project_stages: $scope.project_stages, id: $scope.id,'project_type_id':$scope.project_type_id});
                        $('#projectpaymentModal').modal('toggle');
                       // $scope.success("Project payment stages updated successfully");   
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
