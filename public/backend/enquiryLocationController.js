app.controller('enquiryLocationCtrl', ['$scope', 'Data', '$rootScope', '$timeout','toaster', function ($scope, Data, $rootScope, $timeout,toaster) {


        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.enquiryLocation = function () {

            Data.get('enquiry-location/enquiryLocation').then(function (response) {
                $scope.enquiryLocationRow = response.records;
            });
        };
        $scope.manageStates = function ($id, country_id) {
            if ($id == 1)
            {
                $scope.country_name_id = country_id;

            } else {
                $scope.country_id = $scope.countryRow[$scope.country_id - 1].id;

            }
            Data.post('enquiry-location/manageStates', {country_id: $scope.country_id}).then(function (response) {
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

         console.log(list);
            $scope.heading = 'Enquiry location';
            $scope.country_id = list.country_id;
            $scope.location = list.location;
            $scope.id = ids;
            $scope.name = list.name;
            if (ids !== 0) {
                $scope.manageStates(1, $scope.country_id);
            }
            $scope.state_id = list.state_id;
            if (ids !== 0) {
                $scope.manageCity($scope.state_id);
            }
            $scope.city_id = list.city_id;
            $scope.index = index * ($scope.noOfRows - 1) + (index1 + 1);
            $scope.sbtBtn = false;
        }
        $scope.doEnqLocationAction = function () {
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('enquiry-location/', {
                    'city_id': $scope.city_id, 'state_id': $scope.state_id, 'country_id': $scope.country_id, 'location': $scope.location}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.enquiryLocationRow.push({'location': $scope.location, 'state_id': $scope.state_id, 'country_id': $scope.country_id, id: response.lastinsertid, 'city_name': $scope.city_name, 'city_id': $scope.city_id });
                        $('#locationModal').modal('toggle');
                        toaster.pop('success', 'Manage enquiry location', 'Record successfully created'); 
                    }
                });
            } else { //for update

                Data.put('enquiry-location/' + $scope.id, {'location': $scope.location,
                    name: $scope.name, id: $scope.id, state_id: $scope.state_id}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.enquiryLocationRow.splice($scope.index - 1, 1);
                        $scope.enquiryLocationRow.splice($scope.index - 1, 0, {'id': $scope.id,
                            'location': $scope.location, 'state_id': $scope.state_id, 'country_id': $scope.country_id, 'city_id': $scope.city_id, 'city_name': response.city_name});
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