app.controller('operationalCtrl', ['$scope', 'Data','toaster', function ($scope, Data,toaster) {

        $scope.manageCountry = function () {
            Data.post('contact-us/manageCountry').then(function (response) {
                $scope.countryRow = response.records;
            });
        };
        $scope.manageStates = function (country_id) {

            $scope.country_name_id = country_id;
            Data.post('contact-us/manageStates', {country_name_id: $scope.country_name_id}).then(function (response) {
                $scope.statesRow = response.records;
            });
        };
        $scope.manageCity = function (state_id) {


            Data.post('contact-us/manageCity', {state_id: state_id}).then(function (response) {
                $scope.cityRow = response.records;
            });
        };
        $scope.allowedenquiries = function (allowedenq)
        {
            Data.post('operational-setting/update', {data: allowedenq}).then(function (response) {
                $scope.allowedenq = allowedenq;
            });
        };
        $scope.budgetRange = function (startRange, endRange)
        {
            $min_budget = startRange + "00,000";
            $max_budget = endRange + "00,000";
            Data.post('operational-setting/budgetUpdate', {min_budget: startRange, max_budget: endRange}).then(function (response) {
                $scope.result = response;
            });

        };
        $scope.anniversaryFlag = function (value, type)
        {
            console.log(value + "  ===" + type);
        };
        $scope.birthdayFlag = function (value, type)
        {
            console.log(value + "  ===" + type);
        };
        $scope.manageLocation = function (city_id)
        {
            Data.post('operational-setting/manageLocation', {city_id: city_id}).then(function (response) {
                $scope.locationRow = response.records;
            });
        };
        $scope.opeartionalArea = function (location_id)
        {
            Data.post('operational-setting/opeartionalArea', {preferred_area: location_id}).then(function (response) {
                $scope.locationRow = response.records;
            });
        };
        $scope.getOperationalSettings = function ()
        {
            Data.post('operational-setting/getOperationalSettings').then(function (response) {
                $scope.allowedenq = response.records[0].data;
                $scope.startRange = parseInt(response.records[3].min_budget);
                $scope.endRange = parseInt(response.records[3].max_budget);
                $scope.locations_area = response.allArea;
            });
        };
        $scope.del_area = function (area_id)
        {
            Data.post('operational-setting/delArea', {area_id: area_id}).then(function (response) {
                $scope.locations_area = response.records;
            });
        }

    }]);
