app.controller('contactUsCtrl', ['$scope', 'Data', 'toaster', '$rootScope','$modal', function ($scope, Data, toaster, $rootScope,$modal) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.exportData = '';
        $scope.contactUs = false;

        $scope.searchData = {};
        $scope.searchDetails = {};
        $scope.filterDetails = function (search) {
            $scope.searchData = search;
            $('#showFilterModal').modal('hide');
        }

        $scope.contactUsExportToxls = function () {
            $scope.getexcel = window.location = "/contact-us/contactUsExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        };
       
        
         $scope.showHelpContactUs = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Contact Us</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }
        
         $scope.deleteContact = function (id, index) {
            Data.post('contact-us/deleteContact', {
                'id': id}).then(function (response) {
                $scope.contactUsRow.splice(index, 1);
            });
        }
        
        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteContact(args['id'], args['index']);
        });
        
        
         $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }

        $scope.manageContactUs = function () {
            $scope.showloader();
            Data.post('contact-us/manageContactUs').then(function (response) {
                if(response.success){
                $scope.contactUsRow = response.records;
                $scope.exportData = response.exportData;
                $scope.deleteBtn = response.deleteBtn;
                $scope.hideloader();
            }
            else{
                 $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
            }
            });
        };
        $scope.initialModal = function (id, index) {

            $scope.heading = 'Edit Contact';
            $scope.id = id;
            $scope.index = index;
            Data.post('contact-us/getContactUsRow', {id: $scope.id}).then(function (response) {
                $scope.contactRow = response.records;
                $scope.country_id = $scope.contactRow.country_id
                $scope.location_id = $scope.contactRow.location_type_id
                $scope.address = $scope.contactRow.address
                $scope.contact_number1 = $scope.contactRow.contact_number1
                $scope.contact_number2 = $scope.contactRow.contact_number2
                $scope.contact_number3 = $scope.contactRow.contact_number3
                $scope.pin_code = $scope.contactRow.pin_code
                $scope.email = $scope.contactRow.email
                $scope.google_map_url = $scope.contactRow.google_map_url
                $scope.manageStates(1, $scope.country_id);
                $scope.state_id = $scope.contactRow.state_id;
                $scope.manageCity(1, $scope.state_id);
                $scope.city_id = $scope.contactRow.city_id;
                $scope.manageLocationRow($scope.city_id);
                $scope.location_id = $scope.contactRow.location_type_id;
                $scope.contact_person_name = $scope.contactRow.contact_person_name;

            });
            $scope.sbtBtn = false;
        }
        $scope.manageStates = function ($id, country_id) {

            if ($id == 1)
            {
                $scope.country_name_id = country_id;
            } else {
                $scope.country_name_id = $scope.countryRow[$scope.country_id - 1].id;
            }
            Data.post('contact-us/manageStates', {country_name_id: $scope.country_name_id}).then(function (response) {
                $scope.statesRow = response.records;
            });
        };
        $scope.manageCountry = function () {
            Data.post('contact-us/manageCountry').then(function (response) {
                $scope.countryRow = response.records;
            });
        };
        
        $scope.manageCity = function ($id, state_id) {

            if ($id == 1)
            {
                $scope.state_id = state_id;
            }
            Data.post('contact-us/manageCity', {state_id: $scope.state_id}).then(function (response) {
                $scope.cityRow = response.records;
            });
        };

        $scope.manageLocationRow = function (city_id) {

            Data.post('contact-us/manageLocation', {'city_id': city_id}).then(function (response) {
                $scope.locationRow = response.records;
            });
        };
        $scope.doContactusAction = function () {
            $scope.contactUs = true;
            $scope.errorMsg = '';
            Data.put('contact-us/' + $scope.id, {country_id: $scope.country_id, state_id: $scope.state_id, city_id: $scope.city_id, location_type_id: $scope.location_id, contact_number1: $scope.contact_number1, contact_number2: $scope.contact_number2, contact_number3: $scope.contact_number3, google_map_url: $scope.google_map_url,
                address: $scope.address, pin_code: $scope.pin_code, id: $scope.id, 'contact_person_name': $scope.contact_person_name, 'email': $scope.email}).then(function (response) {

                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $scope.contactUsRow.splice($scope.index, 1);
                    $scope.contactUsRow.splice($scope.index, 0, {country_id: $scope.country_id, state_id: $scope.state_id, city_id: $scope.city_id, location_type_id: $scope.location_id, contact_number1: $scope.contact_number1, contact_number2: $scope.contact_number2, contact_number3: $scope.contact_number3, google_map_url: $scope.google_map_url,
                        address: $scope.address, pin_code: $scope.pin_code, id: $scope.id, 'contact_person_name': $scope.contact_person_name, 'email': $scope.email});
                    $('#contactUsModal').modal('toggle');
                    toaster.pop('success', 'Office address', 'Record successfully updated');
                    $scope.contactUs = false;
                }
            });
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);