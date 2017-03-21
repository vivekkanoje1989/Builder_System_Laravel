app.controller('blockstagesCtrl', ['$scope', 'Data', '$rootScope', '$timeout', function ($scope, Data, $rootScope, $timeout) {

        $scope.blockStages = function () {
            Data.post('block-stages/manageBlockStages').then(function (response) {
                $scope.BlockStageRow = response.records;
            });
        };
        $scope.initialModal = function (id, blockStage, project_type_id, index) {
            $scope.heading = 'Block Stages';
            $scope.id = id;
            $scope.block_stages = blockStage;
            $scope.index = index;
            $scope.project_type_id = project_type_id;
        }
        $scope.getProjectTypes = function ()
        {
            Data.post('block-stages/manageProjectTypes').then(function (response) {
                $scope.ProjectTypesRow = response.records;
            });
        }
        $scope.doblockstagesAction = function () {
            $scope.errorMsg = '';

            if ($scope.id === 0) //for create
            {
                Data.post('block-stages/', {
                    block_stage_name: $scope.block_stages, project_type_id: $scope.project_type_id}).then(function (response) {
                    console.log(response);
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#blockstagesModal').modal('toggle');
                        $scope.BlockStageRow.push({'block_stage_name': $scope.block_stages, 'id': response.lastinsertid, 'project_type_id': $scope.project_type_id});
                    }
                });
            } else { //for update
                Data.put('block-stages/' + $scope.id, {
                    block_stage_name: $scope.block_stages, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.BlockStageRow.splice($scope.index, 1);
                        $scope.BlockStageRow.splice($scope.index, 0, {
                            block_stage_name: $scope.block_stages, id: $scope.id, 'project_type_id': $scope.project_type_id});
                        $('#blockstagesModal').modal('toggle');
                        // $scope.success("Block stage details updated successfully");
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
