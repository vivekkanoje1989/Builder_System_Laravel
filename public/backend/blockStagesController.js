app.controller('blockstagesCtrl', ['$scope', 'Data', '$rootScope', '$timeout', function ($scope, Data, $rootScope, $timeout) {

        $scope.blockStages = function () {
            Data.post('block-stages/manageBlockStages').then(function (response) {
                $scope.BlockStageRow = response.records;
            });
        };
        $scope.initialModal = function (id, blockStage, index) {
            $scope.heading = 'Block Stages';
            $scope.id = id;
            $scope.block_stages = blockStage;
            $scope.index = index;
        }
        $scope.doblockstagesAction = function () {
            $scope.errorMsg = '';
            console.log($scope.id);
            if ($scope.id === 0) //for create
            {
                Data.post('block-stages/', {
                    block_stages: $scope.block_stages}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#blockstagesModal').modal('toggle');
                        $scope.BlockStageRow.push({'block_stages': $scope.block_stages, 'id': $scope.BlockStageRow.length + 1});
                    }
                });
            } else { //for update
                Data.put('block-stages/' + $scope.id, {
                    block_stages: $scope.block_stages, id: $scope.id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.BlockStageRow.splice($scope.index, 1);
                        $scope.BlockStageRow.splice($scope.index, 0, {
                            block_stages: $scope.block_stages, id: $scope.id});
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
