app.controller('projectpaymentController', ['$scope', 'Data','toaster', function ($scope, Data,toaster) {

        $scope.fix_stage = 1;
        $scope.manageProjectPaymentStages = function () {
            Data.post('project-payment/manageProjectPaymentStages').then(function (response) {
                $scope.ProjectPaymentStagesRow = response.records;
            });
        };
        $scope.initialModal = function (id, stage_name, project_type_id,fix_stage,index) {

            $scope.heading = 'Project payment stages';
            $scope.id = id;
            $scope.stage_name = stage_name;
            $scope.index = index;
            $scope.project_type_id = project_type_id;
            $scope.fix_stage = fix_stage;
            $scope.sbtBtn = false;
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
                    stage_name: $scope.stage_name,project_type_id:$scope.project_type_id,fix_stage:$scope.fix_stage}).then(function (response) {
                 
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#projectpaymentModal').modal('toggle');
                        $scope.ProjectPaymentStagesRow.push({'stage_name': $scope.stage_name, 'id': response.lastinsertid, 'status': $scope.status,'project_type_id':$scope.project_type_id,fix_stage:$scope.fix_stage});
                       toaster.pop('success', 'Manage project payment stages', 'Record successfully created');  
                    }
                });
            } else { //for update

                Data.put('project-payment/'+$scope.id, {
                    stage_name: $scope.stage_name, id: $scope.id,project_type_id:$scope.project_type_id,fix_stage:$scope.fix_stage}).then(function (response) {
                   
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.ProjectPaymentStagesRow.splice($scope.index, 1);
                        $scope.ProjectPaymentStagesRow.splice($scope.index, 0, {
                            stage_name: $scope.stage_name, id: $scope.id,'project_type_id':$scope.project_type_id,fix_stage:$scope.fix_stage});
                        $('#projectpaymentModal').modal('toggle');
                        toaster.pop('success', 'Manage project payment stages', 'Record successfully updated');  
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
       
    }]);
