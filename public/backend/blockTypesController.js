app.controller('blocktypesController', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', function ($scope, Data, $rootScope, $timeout, toaster) {

        $scope.noOfRows = 1;
        $scope.itemsPerPage = 4;
        $scope.manageBlockTypes = function () {
            Data.post('block-types/manageBlockTypes').then(function (response) {
                $scope.BlockTypesRow = response.records;
            });
        };
        $scope.getProjectNames = function () {
            Data.post('block-types/manageProjectTypes').then(function (response) {
                $scope.getProjectNamesRow = response.records;
            });
        }
        $scope.initialModal = function (id, block_name, project_type_id, index, index1) {

            if (id == 0)
            {
                $scope.heading = 'Add Project block types';
                $scope.action = 'submit';
                $scope.index = '';
            } else {
                $scope.heading = 'Edit Project block types';
                $scope.action = 'Update';
            }
            $scope.id = id;
            $scope.project_type_id = project_type_id;
            $scope.block_name = block_name;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
            $scope.sbtBtn = false;
        }
        $scope.doblocktypesAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('block-types/', {block_id: $scope.block_name,
                    project_type_id: $scope.project_type_id, block_name: $scope.block_name}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        toaster.pop('success', 'Manage block types', "record created successfully");
                        $('#blocktypesModal').modal('toggle');
                        $scope.BlockTypesRow.push({'block_name': $scope.block_name, 'id': response.lastinsertid, 'project_id': $scope.project_type_id});

                    }
                });
            } else { //for update
                Data.put('block-types/' + $scope.id, {
                    project_type_id: $scope.project_type_id, block_name: $scope.block_name, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        toaster.pop('success', 'Manage block types', "Record updated successfully");
                        $scope.BlockTypesRow.splice($scope.index, 1);
                        $scope.BlockTypesRow.splice($scope.index, 0, {
                            'block_name': $scope.block_name, 'id': $scope.id, 'project_id': $scope.project_type_id});
                        $('#blocktypesModal').modal('toggle');

                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);