/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';
app.controller('customerController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $window) {
        $scope.pageHeading = 'Create Customer';
        $scope.customerData = {};
        $scope.contactData = {};
        $scope.customerData.sms_privacy_status = 1;
        $scope.customerData.email_privacy_status = 1;
        $scope.contacts = [];
        resetContactDetails();
        $scope.contactData.mobile_number = $scope.contactData.landline_number = '+91-';
        var sessionContactData = $window.sessionStorage.getItem("sessionContactData");
        $scope.editContactDetails = function (index) {
            if(sessionContactData !== ""){
                sessionContactData = JSON.parse($window.sessionStorage.getItem("sessionContactData"));
                $scope.contactData = sessionContactData[index];
            }
            else{
                $scope.contactData = $scope.contacts[index];
                $scope.contactData.index=index;
                console.log($scope.contactData);
            }
        }
        $scope.addRow = function () {
            if(typeof sessionContactData !== "undefined"){
                $scope.contacts.push({
                    'mobile_number_lable': $scope.contactData.mobile_number_lable,
                    'mobile_number': $scope.contactData.mobile_number,
                    'landline_lable': $scope.contactData.landline_lable,
                    'landline_number': $scope.contactData.landline_number,
                    'email_id_lable': $scope.contactData.email_id_lable,
                    'email_id': $scope.contactData.email_id,
                    'address_type': $scope.contactData.address_type,
                    'house_number': $scope.contactData.house_number,
                    'building_house_name': $scope.contactData.building_house_name,
                    'wing_name': $scope.contactData.wing_name,
                    'area_name': $scope.contactData.area_name,
                    'lane_name': $scope.contactData.lane_name,
                    'landmark': $scope.contactData.landmark,
                    'pin': $scope.contactData.pin,
                    'country_id': $scope.contactData.country_id,
                    'state_id': $scope.contactData.state_id,
                    'city_id': $scope.contactData.city_id,
                    'google_map_link': $scope.contactData.google_map_link,
                    'other_remarks': $scope.contactData.other_remarks,
                });
            }
            else{
                var i = $scope.contactData.index;
                console.log(i);
                $scope.contacts[0] = $scope.contactData;   //make dynamic index -- need to correct           
            }
            $window.sessionStorage.setItem("sessionContactData", JSON.stringify($scope.contacts));
            var sessionContactData = JSON.parse($window.sessionStorage.getItem("sessionContactData"));
            console.log(sessionContactData);
            resetContactDetails();
            $('#contactDataModal').modal('toggle');
        };
        function resetContactDetails() {
            $scope.contactData.mobile_number_lable = $scope.contactData.landline_lable =
            $scope.contactData.email_id_lable = $scope.contactData.email_id = 
            $scope.contactData.address_type = $scope.contactData.house_number = 
            $scope.contactData.building_house_name = $scope.contactData.wing_name = 
            $scope.contactData.area_name = $scope.contactData.lane_name = 
            $scope.contactData.landmark = $scope.contactData.country_id = 
            $scope.contactData.state_id = $scope.contactData.city_id = $scope.contactData.pin =
            $scope.contactData.google_map_link = $scope.contactData.other_remarks = '';
            $scope.contactData.mobile_number = $scope.contactData.landline_number = '+91-';
        }
        $scope.closeModal = function () {
            $scope.contactData.mobile_number = $scope.contactData.landline_number = '+91-';
        }
        $scope.initContactModal = function () {
            resetContactDetails();
        }

        $scope.createCustomer = function (enteredData, customerPhoto) {
            var sessionContactData = JSON.parse($window.sessionStorage.getItem("sessionContactData"));
            console.log(sessionContactData);
            console.log(enteredData);
            var customerData = {};
            customerData = angular.fromJson(angular.toJson(enteredData));
            if (typeof customerPhoto === 'string' || typeof customerPhoto === 'undefined') {
                customerPhoto = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            customerPhoto.upload = Upload.upload({
                url: getUrl + '/master-sales',
                headers: {enctype: 'multipart/form-data'},
                data: {customerData: customerData, image_file: customerPhoto, customerContacts: sessionContactData},
            });
            customerPhoto.upload.then(function (response) {
                $timeout(function () {
                    if (!response.data.success) {
                        var obj = response.data.message;
                        $('.errMsg').text('');
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                        }
                    } else {
                        $window.sessionStorage.setItem("sessionContactData", "");
                        $scope.disableCreateButton = true;
                        customerPhoto.result = response.data;
                        $rootScope.alert('success', "Customer added successfully.");
                        $('.alert-delay').delay(3000).fadeOut("slow");
                        $timeout(function () {
                            $state.go(getUrl + '.userIndex');
                        }, 1000);
                    }
                });
            }, function (response) {
                if (response.status !== 200) {
                    console.log(response.status);
                    $scope.errorMsg = "Something went wrong. Check your internet connection";
                }
            }, function (evt, response) {});
        };

        $scope.addContactDetails = function () {
            $scope.modal = {};
        }
        
        /*$scope.checkImageExtension = function (customerPhoto) {
            if (typeof customerPhoto !== 'undefined' || typeof customerPhoto !== 'object') {
                var ext = customerPhoto.name.match(/\.(.+)$/)[1];
                if (angular.lowercase(ext) === 'jpg' || angular.lowercase(ext) === 'jpeg' || angular.lowercase(ext) === 'png' || angular.lowercase(ext) === 'bmp' || angular.lowercase(ext) === 'gif' || angular.lowercase(ext) === 'svg') {
                    $scope.invalidImage = "";
                    $scope.altName = customerPhoto.name;
                } else {
                    $(".imageFile").val("");
                    $scope.invalidImage = "Invalid file format. Image should be jpg or jpeg or png or bmp format only.";
                }
            }
        };*/
    }]);

