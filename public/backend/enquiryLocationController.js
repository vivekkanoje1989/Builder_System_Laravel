app.controller('enquiryLocationCtrl', ['$scope', 'Data', 'toaster', function ($scope, Data, toaster) {


        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.enquiryLocation = function () {
            Data.get('enquiry-location/enquiryLocation').then(function (response) {
                $scope.enquiryLocationRow = response.records;
            });
        };
        $scope.manageStates = function (country_id) {
            Data.post('enquiry-location/manageStates', {country_id: country_id}).then(function (response) {
                $scope.statesRow = response.records;
            });
        };
        $scope.manageCity = function (state_id)
        {
            Data.post('enquiry-location/manageCity', {'state_id': state_id}).then(function (response) {
                $scope.cityRow = response.records;
            });
        }
        $scope.manageCountry = function () {
            Data.get('enquiry-location/manageCountry').then(function (response) {
                $scope.countryRow = response.records;
            });
        };
        $scope.initialModal = function (ids, list, index, index1) {

            $scope.id = ids;
            if (ids !== 0) {
                $scope.EnqLocation = list;
                $scope.manageStates($scope.EnqLocation.country_id);
                $scope.states = parseInt(list.state_id);
                $scope.manageCity($scope.states);
                $scope.city = list.city_id;
                $scope.heading = 'Edit location';
                $scope.action = 'Update';
            } else {
                $scope.EnqLocation = {};
                $scope.heading = 'Add location';
                $scope.action = 'Add';
            }
            $scope.index = index * ($scope.noOfRows - 1) + (index1 + 1);
            $scope.sbtBtn = false;
        }
        $scope.doEnqLocationAction = function (EnqLocation) {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('enquiry-location/', {
                    'city_id': EnqLocation.city_id, 'state_id': EnqLocation.state_id, 'country_id': EnqLocation.country_id, 'location': EnqLocation.location}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.enquiryLocationRow.push({'location': EnqLocation.location, 'state_id': Number(EnqLocation.state_id), 'country_id': Number(EnqLocation.country_id), id: response.lastinsertid, 'city_name': response.city, 'city_id': Number(EnqLocation.city_id)});
                        $('#locationModal').modal('toggle');
                        toaster.pop('success', 'Manage enquiry location', 'Record successfully created');
                    }
                });
            } else { //for update

                Data.put('enquiry-location/' + $scope.id, {'location': EnqLocation.location,
                    name: EnqLocation.name, id: $scope.id, state_id: EnqLocation.state_id, city_id: EnqLocation.city_id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.enquiryLocationRow.splice($scope.index - 1, 1);
                        $scope.enquiryLocationRow.splice($scope.index - 1, 0, {'id': $scope.id,
                            'location': EnqLocation.location, 'state_id': Number(EnqLocation.state_id), 'country_id': Number(EnqLocation.country_id), 'city_id': Number(EnqLocation.city_id), 'city_name': response.city});
                        $('#locationModal').modal('toggle');
                        toaster.pop('success', 'Manage enquiry location', 'Record successfully updated');
                    }
                });
            }
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);