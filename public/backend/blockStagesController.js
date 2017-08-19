app.controller('blockstagesCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'toaster', '$parse', function ($scope, Data, $rootScope, $timeout, toaster, $parse) {
        $scope.block = {};
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.submitbtn = false;

        $scope.pageNumber = 1;
        $scope.pageChanged = function (pageNo, functionName, id) {
            $scope[functionName](id, pageNo, $scope.itemsPerPage);
            $scope.pageNumber = pageNo;
        };

        $scope.blockStages = function (empId, pageNumber, itemPerPage) {
            $scope.showloader();
            Data.post('block-stages/manageBlockStages').then(function (response) {
                $scope.hideloader();
                $scope.BlockStageRow = response.records;
                $scope.BlockStageLength = response.totalCount;
            });
        };

//        $scope.getProcName = $scope.type = '';
//        $scope.procName = function (procedureName, isTeam) {
//            $scope.getProcName = angular.copy(procedureName);
//            $scope.type = angular.copy(isTeam);
//        }

        $scope.searchData = {};
        $scope.searchDetails = {};
        $scope.filterDetails = function (search) {
//            $scope.searchDetails = {};
//            console.log(search);
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

//        $scope.filterData = {};
//        $scope.data = {};
//
//        $scope.filteredData = function (data, page, noOfRecords) {
//            $scope.showloader();
//            page = noOfRecords * (page - 1);
//            Data.post('block-stages/filteredData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords}).then(function (response) {
//                if (response.success)
//                {
//                    $scope.BlockStageRow = response.records;
//                    $scope.BlockStageLength = response.totalCount;
//                } else
//                {
//                    $scope.BlockStageRow = response.records;
//                    $scope.BlockStageLength = 0;
//                }
//                $('#showFilterModal').modal('hide');
//                $scope.showFilterData = $scope.filterData;
//                $scope.hideloader();
//                return false;
//
//            });
//        }
//
//        $scope.removeDataFromFilter = function (keyvalue)
//        {
//            delete $scope.filterData[keyvalue];
//            $scope.filteredData($scope.filterData, 1, 30);
//        }



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
            $scope.submitbtn = true;
            if ($scope.id === 0) //for create
            {
                Data.post('block-stages/', {
                    block: block}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.submitbtn = false;
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
                        $scope.submitbtn = false;
                    }
                });
            } else { //for update
                Data.put('block-stages/' + $scope.id, {
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
                        $scope.submitbtn = false;
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
