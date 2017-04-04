app.controller('locationCtrl', ['$scope', 'Data', '$rootScope','$timeout','toaster', function ($scope, Data, $rootScope,$timeout,toaster) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageLocation = function () {
            Data.post('manage-location/manageLocation').then(function (response) {            
                $scope.locationRow = response.records;

            });
        };
        $scope.initialModal = function (id, name, index, index1,status) {

            $scope.heading = 'Location';
            $scope.id = id;
            $scope.name = name;
            $scope.index = index * ($scope.noOfRows - 1) + (index1 + 1);
            $scope.status = status;
            $scope.sbtBtn = false;
        }
        $scope.doLocationAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-location/', {
                    location_type: $scope.name,status:$scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.locationRow.push({'location_type': $scope.name,id:response.lastinsertid,status:$scope.status});
                        $('#LocationModal').modal('toggle');
                    toaster.pop('success', 'Manage location', 'Record successfully created');
                    }
                });
            } else { //for update
                Data.put('manage-location/'+$scope.id, {
                    location_type: $scope.name, id: $scope.id,status:$scope.status}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.locationRow.splice($scope.index - 1, 1);
                        $scope.locationRow.splice($scope.index - 1, 0, {
                            location_type: $scope.name, id: $scope.id,status:$scope.status});
                        $('#LocationModal').modal('toggle');
                         toaster.pop('success', 'Manage location', 'Record successfully created');
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);