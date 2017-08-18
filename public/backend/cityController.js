app.controller('citiesCtrl', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
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


        $scope.manageCities = function () {
            Data.get('manage-city/manageCity').then(function (response) {
                $scope.citiesRow = response.records;
            });
        };
        $scope.manageStates = function ($id, country_id) {
            if ($id == 1)
            {
                $scope.country_name_id = country_id;

            } else {
                $scope.country_id = $scope.countryRow[$scope.country_id - 1].id;

            }
            Data.post('manage-city/manageStates', {country_id: $scope.country_id}).then(function (response) {
                $scope.statesRow = response.records;
            });
        };
        $scope.manageCountry = function () {
            Data.get('manage-city/manageCountry').then(function (response) {
                $scope.countryRow = response.records;
            });
        };
        $scope.initialModal = function (ids, city_id, list, index, index1) {
            $scope.country_id = list.country_id;
            $scope.id = city_id;
            $scope.name = list.name;
            if ($scope.id !== 0) {
                $scope.heading = 'Edit City';
                $scope.action = 'Update';
                $scope.manageStates(1, $scope.country_id);
            } else {
                $scope.heading = 'Add City';
                $scope.action = 'Submit';
            }
            $scope.state_id = list.state_id;
            $scope.states = list.state_id;
            $scope.index = index * ($scope.noOfRows - 1) + (index1 + 1);
            $scope.sbtBtn = false;
        }
        $scope.doCitiesAction = function () {
            $scope.errorMsg = '';
            if ($scope.id == 0) //for create
            {
                Data.post('manage-city/', {
                    'name': $scope.name, 'state_id': $scope.state_id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.citiesRow.push({'name': $scope.name, 'state_id': $scope.state_id, 'country_id': $scope.country_id, id: response.lastinsertid, 'country_name': response.country_name, 'state_name': response.state_name});
                        $('#cityModal').modal('toggle');
                        toaster.pop('success', 'Manage city ', 'Record successfully created');
                    }
                });
            } else {//for update

                Data.put('manage-city/' + $scope.id, {
                    name: $scope.name, id: $scope.id, state_id: $scope.state_id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.citiesRow.splice($scope.index - 1, 1);
                        $scope.citiesRow.splice($scope.index - 1, 0, {
                            name: $scope.name, id: $scope.id, country_id: $scope.country_id, state_id: $scope.state_id, state_name: response.state_name});
                        $('#cityModal').modal('toggle');
                        toaster.pop('success', 'Manage city ', 'Record successfully updated');
                    }
                });
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);