app.controller('blockstagesCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster','$parse', function ($scope, Data, $rootScope, $timeout, toaster, $parse) {
        $scope.block = [];
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.blockStages = function () {
            Data.post('block-stages/manageBlockStages').then(function (response) {
                $scope.BlockStageRow = response.records;
            });
        };
        $scope.initialModal = function (id, blockStage, project_type_id, index, index1) {
            if (id == 0)
            {
                $scope.heading = 'Add Block Stages';
                $scope.action = 'Submit';
            } else {
                $scope.heading = 'Edit Block Stages';
                $scope.action = 'Update';
            }
            $scope.id = id;
            $scope.block.block_stage_name = blockStage;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
            $scope.sbtBtn = false;
            $scope.block.project_type_id = project_type_id;
        }
        $scope.getProjectTypes = function ()
        {
            Data.post('block-stages/manageProjectTypes').then(function (response) {
                $scope.ProjectTypesRow = response.records;
            });
        }
        $scope.doblockstagesAction = function (block) {
            $scope.errorMsg = '';

            if ($scope.id === 0) //for create
            {
                Data.post('block-stages/', {
                    block: block}).then(function (response) {

                    if (!response.success)
                    {
                        var obj = response.data.message;
                        var selector = [];
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                            selector.push(key);
                        }
                        $scope.errorMsg = response.errormsg;
                    } else {
                        toaster.pop('success', 'Manage block stages', "Record created successfully");
                        $('#blockstagesModal').modal('toggle');
                        $scope.BlockStageRow.push({'block_stage_name': response.result.block_stage_name, 'id': response.lastinsertid, 'project_type_id': response.result.project_type_id});
                    }
                });
            } else { //for update
                console.log(block);
                Data.put('block-stages/'+$scope.id, {
                    block: block, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        var obj = response.message;
                        var selector = [];
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                            selector.push(key);
                        }
                        $scope.errorMsg = response.errormsg;
                    } else {
                        toaster.pop('success', 'Manage block stages', "Record updated successfully");
                        $scope.BlockStageRow.splice($scope.index, 1);
                        $scope.BlockStageRow.splice($scope.index, 0, {
                            block_stage_name: $scope.block.block_stage_name, id: $scope.id, 'project_type_id': $scope.block.project_type_id});
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
