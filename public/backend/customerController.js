'use strict';
app.controller('customerController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', 'toaster', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $window, toaster) {
        $scope.pageHeading = 'Create Customer';
        $scope.customerData = {};
        $scope.contactData = {};
        $scope.searchData = {};
        $scope.currentPage = $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.customerData.sms_privacy_status = 1;
        $scope.customerData.email_privacy_status = 1;
        $scope.contacts = [];
        resetContactDetails();
        $scope.contactData.mobile_number = $scope.contactData.landline_number = '+91-';
        $scope.showDiv = false;
        $scope.showDivCustomer = false;
        $scope.searchData.customerId = 0;
        var sessionContactData = $scope.contactData.index = "";
        $window.sessionStorage.setItem("sessionContactData", "");
        $scope.checkValue = function () {
            if ($scope.customerData.searchWithMobile === '' || $scope.customerData.searchWithEmail === '') {
                $scope.showDiv = false;
                $scope.showDivCustomer = false;
            }
        }
        $scope.pageChangeHandler = function(num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        $scope.validateMobileNumber = function (value) {
            var regex = /^(\+\d{1,4}-)\d{10}$/;
            if (!regex.test(value)) {
                $scope.errMobile = "Mobile number should be 10 digits and pattern should be for ex. +91-9999999999";
                $scope.applyClassMobile = 'ng-active';
            } else {
                $scope.errMobile = "";
                $scope.applyClassMobile = 'ng-inactive';
            }
        };
        $scope.validateLandlineNumber = function (value) {
            var regex = /^(\+\d{1,4}-\d{1,4})\d{6}$/;
            if (value !== "+91-") {
                if (!regex.test(value)) {
                    $scope.errLandline = "Landline number should be 12 digits and pattern should be for ex. +91-1234999999";
                    $scope.applyClass = 'ng-active';
                } else {
                    $scope.errLandline = "";
                    $scope.applyClass = 'ng-inactive';
                }
            }
        };
        $scope.editContactDetails = function (index) {
            $scope.contactData.index = index;
            $scope.contactData = $scope.contacts[index];
            $window.sessionStorage.setItem("sessionContactData", JSON.stringify($scope.contacts));
            $scope.contactData.index = index;
        }
        $scope.addRow = function (contactData) {alert($scope.contactData.index);
            if ($scope.contactData.index === "" || typeof $scope.contactData.index === "undefined") {
                $('#errContactDetails').text("");
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
            } else {
                var i = $scope.contactData.index;
                angular.forEach($scope.contacts, function (data, index) {
                    if (index === i) {
                        $scope.contacts.splice(index, 1); //Remove index
                        $scope.contacts.splice(index, 0, contactData);  //Update new value and returns array
                        $scope.contactData = {};
                    }
                });
            }
            sessionContactData = $window.sessionStorage.setItem("sessionContactData", JSON.stringify($scope.contacts));
            $scope.contactData = {};
            $scope.modalForm.$setPristine();
            $scope.modalForm.$setUntouched();
            $('#contactDataModal').modal('toggle');
        };
        function resetContactDetails() {
                $scope.contactData.mobile_number_lable = $scope.contactData.landline_lable =
                $scope.contactData.email_id_lable = $scope.contactData.address_type = 1;
                $scope.contactData.email_id = $scope.contactData.house_number =
                $scope.contactData.building_house_name = $scope.contactData.wing_name =
                $scope.contactData.area_name = $scope.contactData.lane_name =
                $scope.contactData.landmark = $scope.contactData.country_id =
                $scope.contactData.state_id = $scope.contactData.city_id = $scope.contactData.pin =
                $scope.contactData.google_map_link = $scope.contactData.other_remarks = '';
                $scope.contactData.mobile_number = $scope.contactData.landline_number = '+91-';
        }
        $scope.initContactModal = function () {
            $window.sessionStorage.setItem("sessionContactData", JSON.stringify($scope.contacts));
            resetContactDetails();
            $scope.modalSbtBtn = false;
        }
        $window.sessionStorage.setItem("sessionAttribute", "");
        $scope.createCustomer = function (enteredData, customerPhoto) {
            //console.log($window.sessionStorage.getItem("sessionContactData"));
            sessionContactData = JSON.parse($window.sessionStorage.getItem("sessionContactData"));
            if (sessionContactData === null || sessionContactData === '') {
                $('#errContactDetails').text(" - Please add contact details");
                return false;
            } else {
                sessionContactData = JSON.parse($window.sessionStorage.getItem("sessionContactData"));
            }
            var customerData = {};
            customerData = angular.fromJson(angular.toJson(enteredData));
            if (typeof customerPhoto === 'string' || typeof customerPhoto === 'undefined') {
                customerPhoto = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            if ($scope.searchData.customerId === 0 || $scope.searchData.customerId === '') {
                var url = getUrl + '/master-sales';
                var data = {customerData: customerData, image_file: customerPhoto, customerContacts: sessionContactData};
            } else {
                var url = getUrl + '/master-sales/' + $scope.searchData.customerId;
                var data = {_method: "PUT", customerData: customerData, image_file: customerPhoto, customerContacts: sessionContactData};
            }

            customerPhoto.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data,
            });
            customerPhoto.upload.then(function (response) {
                    $timeout(function () {
                    if (!response.data.success) {
                        var obj = response.data.message;
                        var selector = [];
                        var sessionAttribute = $window.sessionStorage.getItem("sessionAttribute");
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                            selector.push(key);
                        }
                        if (sessionAttribute === null || sessionAttribute === '') {
                            $window.sessionStorage.setItem("sessionAttribute", JSON.stringify(selector));
                        } else {
                            sessionAttribute = JSON.parse($window.sessionStorage.getItem("sessionAttribute"));
                        }
                        for (var key in sessionAttribute) {
                            var elementExist = selector.indexOf(sessionAttribute[key]);
                            if (selector.indexOf(sessionAttribute[key]) === -1)
                                $("." + sessionAttribute[key]).hide();
                            else
                                $("." + sessionAttribute[key]).show();
                        }
                    } else {
                        $('.errMsg').text('');
                        $window.sessionStorage.setItem("sessionContactData", "");
                        $scope.disableCreateButton = true;
                        var myEle = document.getElementById("enquiryDiv");
                        if (myEle === null) {
                            $state.go(".salesCreate");
//                            $window.history.back();
                        } else {
                            document.getElementById("enquiryDiv").style.display = 'block';
                        }
                        $scope.customer_id = response.data.customerId;
                        // $scope.enquiry_div = ($scope.tabs.length + 1);
                        if ($scope.searchData.customerId === 0 || $scope.searchData.customerId === '') {
                            toaster.pop('success', 'Customer', 'Record successfully created');
                        } else {
                            toaster.pop('success', 'Customer', 'Record successfully updated');
                        }
                    }
                });
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong. Check your internet connection";
                }
            }, function (evt, response) {});
        };

        $scope.addContactDetails = function () {
            $scope.modal = {};
        }
        $scope.createEnquiry = function () {
            Data.post('master-sales/getCustomerDetails', {
                data: {customerMobileNo: $scope.searchData.searchWithMobile, customerEmailId: $scope.searchData.searchWithEmail, showCustomer: 1},
            }).then(function (response) {
                $scope.showDiv = false;
                $scope.showDivCustomer = true;
                $scope.disableSource = true;               
                $scope.customerData = angular.copy(response.customerPersonalDetails[0]);
                $scope.contacts = angular.copy(response.customerContactDetails);
                $scope.contactData = angular.copy(response.customerContactDetails);
                //console.log(response.customerContactDetails.length);
                //$scope.customerData.marriage_date = $scope.customerData.birth_date = (new Date(), 'yyyy-MM-dd');
                for (var i = 0; i < 1; i++) {
                    if (response.customerContactDetails[i].mobile_calling_code === parseInt(0) || response.customerContactDetails[i].mobile_calling_code === '') {
                        $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = "+91-";
                    } else {
                        $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = '+' + parseInt(response.customerContactDetails[i].mobile_calling_code) + '-' + parseInt(response.customerContactDetails[i].mobile_number);
                    }
                    if (response.customerContactDetails[i].landline_calling_code === parseInt(0) || response.customerContactDetails[i].landline_calling_code === '' || response.customerContactDetails[i].landline_calling_code === null) {
                        $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = '+91-';
                    } else {
                        $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = '+' + parseInt(response.customerContactDetails[i].landline_calling_code) + '-' + parseInt(response.customerContactDetails[i].landline_number);
                    }
                    if (response.customerContactDetails[i].pin === 0)
                        $scope.contacts[i].pin = $scope.contactData[i].landline_number = '';
                    if (response.customerContactDetails[i].email_id === '' || response.customerContactDetails[i].email_id === 'null')
                        $scope.contacts[i].email_id = $scope.contactData[i].email_id = '';
                }
                Data.post('getEnquirySubSource', {
                    data: {sourceId: response.customerPersonalDetails[0].source_id}}).then(function (response) {
                    $scope.subSourceList = '';
                    if (!response.success) {
                        $scope.errorMsg = response.message;
                    } else {
                        $scope.subSourceList = response.records;
                    }
                });
                $window.sessionStorage.setItem("sessionContactData", JSON.stringify(angular.copy(response.customerContactDetails)));
                $scope.searchData.searchWithMobile = $scope.searchData.searchWithMobile;
                $scope.searchData.searchWithEmail = $scope.searchData.searchWithEmail;
                $scope.searchData.customerId = response.customerPersonalDetails[0].id;
                $scope.disableText = true;
            });
        }
        $scope.createNewEnquiry = function ()
        {
            $state.go(getUrl + '.salesCreate', {}, {reload: true});
        }
        $scope.getCustomerDataWithId = function (id)
        {
            Data.post('master-sales/getCustomerDataWithId', {
                data: {customerId: id},
            }).then(function (response) {
                $scope.customerData = angular.copy(response.customerPersonalDetails[0]);
                $scope.contacts = angular.copy(response.customerPersonalDetails.get_customer_contacts);
                $scope.contactData = angular.copy(response.customerPersonalDetails.get_customer_contacts);

                for (var i = 0; i < response.customerPersonalDetails.get_customer_contacts.length; i++) {
                    if (response.customerPersonalDetails.get_customer_contacts[i].mobile_calling_code === parseInt(0) || response.customerPersonalDetails.get_customer_contacts[i].mobile_calling_code === '') {
                        $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = "+91-";
                    } else {
                        $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = '+' + parseInt(response.customerPersonalDetails.get_customer_contacts[i].mobile_calling_code) + '-' + parseInt(response.customerPersonalDetails.get_customer_contacts[i].mobile_number);
                    }
                    if (response.customerPersonalDetails.get_customer_contacts[i].landline_calling_code === parseInt(0) || response.customerPersonalDetails.get_customer_contacts[i].landline_calling_code === '' || response.customerPersonalDetails.get_customer_contacts[i].landline_calling_code === null) {
                        $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = '+91-';
                    } else {
                        $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = '+' + parseInt(response.customerPersonalDetails.get_customer_contacts[i].landline_calling_code) + '-' + parseInt(response.customerPersonalDetails.get_customer_contacts[i].landline_number);
                    }
                    if (response.customerPersonalDetails.get_customer_contacts[i].pin === 0)
                        $scope.contacts[i].pin = $scope.contactData[i].landline_number = '';
                    if (response.customerPersonalDetails.get_customer_contacts[i].email_id === '' || response.customerPersonalDetails.get_customer_contacts[i].email_id === 'null')
                        $scope.contacts[i].email_id = $scope.contactData[i].email_id = '';
                    
                    $scope.contactData.index = i;
                }
                Data.post('getEnquirySubSource', {
                    data: {sourceId: response.customerPersonalDetails[0].source_id}}).then(function (response) {
                    $scope.subSourceList = '';
                    if (!response.success) {
                        $scope.errorMsg = response.message;
                    } else {
                        $scope.subSourceList = response.records;
                    }
                });
                $window.sessionStorage.setItem("sessionContactData", JSON.stringify(angular.copy(response.customerPersonalDetails.get_customer_contacts)));
                $scope.searchData.searchWithMobile = $scope.searchData.searchWithMobile;
                $scope.searchData.searchWithEmail = $scope.searchData.searchWithEmail;
                $scope.searchData.customerId = response.customerPersonalDetails[0].id;
                $scope.disableText = true;

            })
        }

    }]);

app.directive('checkMobileExist', function ($timeout, $q, Data) {
    return {
        restrict: 'AE',
        require: 'ngModel',
        link: function ($scope, element, attributes, model) {
            model.$asyncValidators.uniqueMobile = function (modelValue) {
                var mobileNumber = modelValue;
                var customerId = $scope.searchData.customerId;
                return Data.post('master-sales/checkMobileExist', {
                    data: {mobileNumber: mobileNumber, customerId: customerId},
                }).then(function (response) {
                    $timeout(function () {
                        model.$setValidity('uniqueMobile', !!response.success);
                    }, 1000);
                });
            };
        }
    }
});
