app.controller('statesCtrl', ['$scope', 'Data', '$rootScope','$timeout', function ($scope, Data, $rootScope,$timeout) {
        $scope.noOfRows = 1;
        $scope.itemsPerPage = 4;
        $scope.manageStates = function () {
            Data.get('manage-states/manageStates').then(function (response) {
                $scope.statesRow = response.records;
            });
        };
        $scope.manageCountry = function () {
            Data.get('manage-states/manageCountry').then(function (response) {
                $scope.countryRow = response.records;
            });
        };
        $scope.initialModal = function (id, name, country,country_id, index, index1) {

            $scope.heading = ' Manage states';
            $scope.id = id;
            $scope.name = name;
            $scope.statesForm.index = index * ($scope.noOfRows - 1) + (index1 + 1);
            $scope.country = country;
            $scope.country_id = country_id;
        }
        $scope.doStatesAction = function () {
          
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-states/', {
                    name: $scope.name,country_id:$scope.country_id}).then(function (response) {
                   
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#statesModal').modal('toggle');
                         $scope.statesRow.push({'name': $scope.name,'id':response.lastinsertid,'country_id':$scope.country_id,'country_name':response.country_name});
                         //$scope.success("State details created successfully");
                    }
                });
            } else {      //for update
                Data.put('manage-states/'+$scope.id, {
                    name: $scope.name, id: $scope.id,country_id:$scope.country_id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                           $('#statesModal').modal('toggle');
                        $scope.statesRow.splice($scope.statesForm.index - 1, 1);
                        $scope.statesRow.splice($scope.statesForm.index - 1, 0, {
                            name: $scope.name, id: $scope.id, country_name: $scope.country,'country_id':$scope.country_id,'country_name':response.country_name});
                        //$scope.success("State details updated successfully");
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