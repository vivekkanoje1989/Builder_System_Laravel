app.controller('projectpaymentController', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {

        $scope.noOfRows = 1;
        $scope.itemsPerPage = 30;
        $scope.proPayStage = false;
        $scope.fix_stage = 1;
        $scope.manageProjectPaymentStages = function () {
            Data.post('project-payment/manageProjectPaymentStages').then(function (response) {
                $scope.ProjectPaymentStagesRow = response.records;
            });
        };
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


        $scope.initialModal = function (id, stage_name, project_type_id, fix_stage, index, index1) {
            if (id == 0)
            {
                $scope.heading = 'Add payment stages';
                $scope.id = '0';
                $scope.action = 'submit';
            } else {
                $scope.heading = 'Edit payment stages';
                $scope.action = 'Update';
            }
            $scope.id = id;
            $scope.stage_name = stage_name;
            $scope.project_type_id = project_type_id;
            $scope.fix_stage = fix_stage;
            $scope.sbtBtn = false;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
        }
        $scope.getProjectTypes = function ()
        {
            Data.post('project-payment/manageProjectTypes').then(function (response) {
                $scope.ProjectTypesRow = response.records;
            });
        }
        $scope.doprojectpaymentAction = function () {
            $scope.errorMsg = '';
            $scope.proPayStage = true;
            if ($scope.id == 0) //for create
            {
                $scope.proPayStage = false;
                Data.post('project-payment', {
                    stage_name: $scope.stage_name, project_type_id: $scope.project_type_id, fix_stage: $scope.fix_stage}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {

                        toaster.pop('success', 'Payment Stages', "record created successfully");
                        $('#projectpaymentModal').modal('toggle');
                        $scope.ProjectPaymentStagesRow.push({'stage_name': $scope.stage_name, 'id': response.lastinsertid, 'status': $scope.status, 'project_type_id': $scope.project_type_id, fix_stage: $scope.fix_stage});
                    }
                });
            } else { //for update
                $scope.proPayStage = false;
                Data.put('project-payment/' + $scope.id, {
                    stage_name: $scope.stage_name, id: $scope.id, project_type_id: $scope.project_type_id, fix_stage: $scope.fix_stage}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        toaster.pop('success', 'Payment Stages', "Record updated successfully");
                        $scope.ProjectPaymentStagesRow.splice($scope.index, 1);
                        $scope.ProjectPaymentStagesRow.splice($scope.index, 0, {
                            stage_name: $scope.stage_name, id: $scope.id, 'project_type_id': $scope.project_type_id, fix_stage: $scope.fix_stage});
                        $('#projectpaymentModal').modal('toggle');
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
