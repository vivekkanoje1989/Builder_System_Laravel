'use strict';
app.controller('customerController', ['$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', 'toaster', '$location','SweetAlert', function ($scope, $state, Data, Upload, $timeout, $parse, $window, toaster, $location,SweetAlert) {
        $scope.pageHeading = 'Detailed Enquiry';
        $scope.customerData = [];
        $scope.contactData = {};
        $scope.searchData = {};
        $scope.enquiryData = {};
        $scope.btnLabelC = $scope.btnLabelE = "Save";
        $scope.projectsDetails = [];
        $scope.locations = [];
        $scope.projectList = [];
        $scope.blockTypeList = [];
        $scope.contacts = [];
        $scope.enqType = '';
        $scope.errMobile = '';
        $scope.customerData.sms_privacy_status = $scope.customerData.email_privacy_status = 1;
        resetContactDetails();
        //$scope.contactData.mobile_number = $scope.contactData.landline_number = '+91-';
        $scope.showDiv = $scope.enquiryList = $scope.disableSource = $scope.showDivCustomer = false;
        $scope.searchData.customerId = 0;
        $scope.hstep = 1;
        $scope.mstep = 15;
        var today = new Date();
        today.setYear(today.getFullYear() - 20);
        $scope.maxDates = new Date(today.getFullYear(), today.getMonth(), today.getDate());

        $scope.showaddress = true;
        $scope.hideaddress = false;
        $scope.customerAddress = false;
        $scope.showAddress = function () {
            $scope.showaddress = false;
            $scope.hideaddress = true;
            $scope.customerAddress = true;
        }

        $scope.hideAddress = function () {
            $scope.showaddress = true;
            $scope.hideaddress = false;
            $scope.customerAddress = false;
        }
        $scope.company_list = [];
        $scope.setCompany = function (company) {
            $scope.customerData.company_id = company.id;
            $scope.customerData.company_name = company.company_name;
            $scope.showComapnyList = false;
        }

        $scope.showComapnyList = false;
        $scope.getCompanyList = function (name) {
            if (name != null && name != '') {
                $scope.showComapnyList = true;
            } else {
                $scope.customerData.company_id = 0;
                $scope.showComapnyList = false;
            }
        }
        $scope.isChecked = function (corporateCust) {
            if (corporateCust == true) {
                $scope.companyInput = true;
                cache : false;
                Data.get('getCompanyList').then(function (response) {
                    if (!response.success) {
                        $scope.company_list = [];
                        $scope.showComapnyList = false;
                        $scope.errorMsg = response.message;
                    } else {
                        $scope.company_list = response.records;

                    }
                });
            } else {
                $scope.customerData.company_id == 0
                $scope.customerData.company_name = "";
                $scope.companyInput = false;
            }
        }
        $scope.changeSmsPrivacyStatus = function (val) {
            $scope.customerData.sms_privacy_status = val;
        }

        $scope.changeEmailPrivacyStatus = function (val) {
            $scope.customerData.email_privacy_status = val;
        }


        $scope.checkValue = function () {
            if ($scope.searchData.searchWithMobile === '' || $scope.searchData.searchWithEmail === '') {
                $scope.showDiv = false;
                $scope.errMobile = false;
                $scope.showDivCustomer = false;
            } else
            {
                var regMobile = /^[789]/;
                if (!regMobile.test($scope.searchData.searchWithMobile)) {
                    $scope.errMobile = true;
                } else {
                    $scope.errMobile = "";
                    $scope.errMobile = false;
                }
            }
        }
        var sessionContactData = $scope.contactData.index = "";
        $window.sessionStorage.setItem("sessionContactData", "");

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
        $scope.editContactDetails = function (index) {
            $scope.contactData.index = index;
            $scope.contactData = $scope.contacts[index];
            $window.sessionStorage.setItem("sessionContactData", JSON.stringify($scope.contacts));
            $scope.contactData.index = index;
        }
        $scope.addRow = function (contactData) {
            if ($scope.contactData.index === "" || typeof $scope.contactData.index === "undefined") {
                $('#errContactDetails').text("");
                $scope.contacts.push({
                    'mobile_number_lable': $scope.contactData.mobile_number_lable,
                    'mobile_calling_code': $scope.contactData.mobile_calling_code,
                    'mobile_number': $scope.contactData.mobile_number,
                    'landline_lable': $scope.contactData.landline_lable,
                    'landline_calling_code': $scope.contactData.landline_calling_code,
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
                if (i < $scope.contacts.length) {
                    angular.forEach($scope.contacts, function (data, index) {
                        if (index === i) {
                            $scope.contactData.mobile_calling_code = $("#mobile_calling_code").val();
                            $scope.contacts.splice(index, 1); //Remove index
                            $scope.contacts.splice(index, 0, contactData);  //Update new value and returns array
                            $scope.contactData = {};
                        }
                    });
                } else {
                    $scope.contacts.push({
                        'mobile_calling_code': $("#mobile_calling_code").val(),
                        'mobile_number_lable': $scope.contactData.mobile_number_lable,
                        'mobile_number': $scope.contactData.mobile_number,
                        'landline_calling_code': $scope.contactData.landline_calling_code,
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
                    })
                }
                console.log("3="+$scope.contacts[i].mobile_number);
                console.log("3="+$scope.contactData.mobile_calling_code+"-"+$("#mobile_calling_code").val() );
            }
            sessionContactData = $window.sessionStorage.setItem("sessionContactData", JSON.stringify($scope.contacts));
            $scope.contactData = {};
            $scope.modalForm.$setPristine();
            $scope.modalForm.$setUntouched();
            $('#contactDataModal').modal('toggle');
        };
        function resetContactDetails() {
            $timeout(function(){
                $scope.contactData.mobile_number_lable = $scope.contactData.landline_lable = 
                $scope.contactData.email_id_lable = $scope.contactData.address_type = 1;
            
                $scope.contactData.email_id = $scope.contactData.house_number =
                        $scope.contactData.building_house_name = $scope.contactData.wing_name =
                        $scope.contactData.area_name = $scope.contactData.lane_name =
                        $scope.contactData.landmark = $scope.contactData.country_id =
                        $scope.contactData.state_id = $scope.contactData.city_id = $scope.contactData.pin =
                        $scope.contactData.google_map_link = $scope.contactData.other_remarks = '';
                $scope.contactData.index = $scope.contacts.length;
            },200);
        }
        $scope.initContactModal = function () {
            $window.sessionStorage.setItem("sessionContactData", JSON.stringify($scope.contacts));
            resetContactDetails();
            $scope.contactData = {};
            $scope.modalForm.$setPristine();
            $scope.modalForm.$setUntouched();
//            $scope.contactData.mobile_calling_code = "+91";
            $scope.modalSbtBtn = false;
        }
        $window.sessionStorage.setItem("sessionAttribute", "");
        $scope.createCustomer = function (enteredData, customerPhoto) {

            sessionContactData = JSON.parse($window.sessionStorage.getItem("sessionContactData"));
            if (sessionContactData === null || sessionContactData === '') {
                $('#errContactDetails').text(" - Please add contact details");
                return false;
            } else {
                sessionContactData = JSON.parse($window.sessionStorage.getItem("sessionContactData"));
            }


            var customerData = {};
            customerData = (angular.toJson(enteredData));
            if (typeof customerPhoto === 'string' || typeof customerPhoto === 'undefined') {
                customerPhoto = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            if ($scope.searchData.customerId === 0 || $scope.searchData.customerId === '') {
                var url = '/master-sales';
                var data = {customerData: enteredData, image_file: customerPhoto, customerContacts: sessionContactData};
            } else {
                var url = '/master-sales/' + $scope.searchData.customerId;
                var data = {_method: "PUT", customerData: enteredData, image_file: customerPhoto, customerContacts: sessionContactData};
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
                        var url = $location.path();
                        if (url === "/office/sales/enquiry") {
                            $('.errMsg').text('');
                            $window.sessionStorage.setItem("sessionContactData", "");
                            $scope.disableCreateButton = true;
                        }
                        document.getElementById("enquiryDiv").style.display = 'block';
                        $("li#enquiryDiv a.ng-binding").trigger("click");
                        $scope.customer_id = response.data.customerId;
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
        $scope.backToListing = function (mobileNo, emailId) {
            $state.go("salesCreate");
            $timeout(function () {
                if (mobileNo !== '') {
                    $("input[name='searchWithMobile']").val(mobileNo);
                    $("input[name='searchWithMobile']").trigger("change");
                } else {
                    $("input[name='searchWithEmail']").val(emailId);
                    $("input[name='searchWithEmail']").trigger("change");
                }
            }, 500);
        }

        $scope.resetForm = function () {
            $state.go('salesCreate');
        }
        $scope.addContactDetails = function () {
            $scope.modal = {};
        }
        $scope.manageForm = function (customerId, enquiryId, enqType) {
            $scope.enqType = enqType;
            var date = new Date();
            $scope.enquiryData.sales_enquiry_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            $scope.enquiryData.sales_category_id = $scope.enquiryData.property_possession_type = "1";
            $scope.enquiryData.city_id = $scope.enquiryData.followup_by_employee_id = "";
            $scope.enquiryData.parking_required = $scope.enquiryData.finance_required = "0";
            date.setHours("10");
            date.setMinutes("00");
            $scope.enquiryData.next_followup_time = date;
            if (customerId !== 0 && enquiryId === 0) {
                $scope.showloader();
                Data.post('master-sales/getCustomerDataWithId', {
                    data: {customerId: customerId},
                }).then(function (response) {
                    $scope.pageHeading = 'Edit Customer';
                    $scope.btnLabelC = "Update";
                    $scope.showDivCustomer = true;
                    $scope.enquiryList = true;
                    $scope.disableDataOnEnqUpdate = true;


                    Data.post('getEnquirySubSource', {
                        data: {sourceId: response.customerPersonalDetails[0].source_id}}).then(function (response) {
                        $scope.subSourceList = '';
                        if (!response.success) {
                            $scope.errorMsg = response.message;
                        } else {
                            $scope.subSourceList = response.records;
                        }
                    });
                    $timeout(function () {
                        $scope.customerData = angular.copy(response.customerPersonalDetails[0]);
                        var bdate = new Date($scope.customerData.birth_date);
                        $scope.enquiryData.birth_date = (bdate.getFullYear() + '-' + ("0" + (bdate.getMonth() + 1)).slice(-2) + '-' + bdate.getDate());
                        $scope.contacts = angular.copy(response.customerPersonalDetails.get_customer_contacts);
                        $scope.contactData = angular.copy(response.customerPersonalDetails.get_customer_contacts);
                        $scope.searchData.searchWithMobile = response.customerPersonalDetails.get_customer_contacts[0].mobile_number;

                        if (response.customerPersonalDetails[0].monthly_income == "0")
                            $scope.customerData.monthly_income = "";
                        else
                            $scope.customerData.monthly_income = angular.copy(response.customerPersonalDetails[0].monthly_income);

                        if (response.customerPersonalDetails[0].birth_date === null || response.customerPersonalDetails[0].birth_date === "-0001-11-30 00:00:00") {
                            $scope.customerData.birth_date = "";
                        } else {
                            var bdt = new Date(response.customerPersonalDetails[0].birth_date);
                            if (bdt.getDate() < 10) {
                                $scope.customerData.birth_date = (bdt.getFullYear() + '-' + ("0" + (bdt.getMonth() + 1)).slice(-2) + '-' + ("0" + bdt.getDate()));
                            } else {
                                $scope.customerData.birth_date = (bdt.getFullYear() + '-' + ("0" + (bdt.getMonth() + 1)).slice(-2) + '-' + bdt.getDate());
                            }
                            $scope.maxDates = response.customerPersonalDetails[0].birth_date;
                        }

                        if (response.customerPersonalDetails[0].marriage_date === null || response.customerPersonalDetails[0].marriage_date === "-0001-11-30 00:00:00") {
                            $scope.customerData.marriage_date = "";
                        } else {
                            var marriage_date = new Date(response.customerPersonalDetails[0].marriage_date);
                            if (marriage_date.getDate() < 10) {
                                $scope.customerData.marriage_date = (marriage_date.getFullYear() + '-' + ("0" + (marriage_date.getMonth() + 1)).slice(-2) + '-' + ("0" + marriage_date.getDate()));
                            } else {
                                $scope.customerData.marriage_date = (marriage_date.getFullYear() + '-' + ("0" + (marriage_date.getMonth() + 1)).slice(-2) + '-' + marriage_date.getDate());
                            }
                        }

                        for (var i = 0; i < response.customerPersonalDetails.get_customer_contacts.length; i++) {
                            if (response.customerPersonalDetails.get_customer_contacts[i].mobile_number === '0' || response.customerPersonalDetails.get_customer_contacts[i].mobile_number === '' || response.customerPersonalDetails.get_customer_contacts[i].mobile_number === null || response.customerPersonalDetails.get_customer_contacts[i].mobile_number === "null") {
                                $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = "";
                            } else {
                                $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = parseInt(response.customerPersonalDetails.get_customer_contacts[i].mobile_number);
                                $scope.contacts[i].mobile_calling_code = $scope.contactData[i].mobile_calling_code = '+' + parseInt(response.customerPersonalDetails.get_customer_contacts[i].mobile_calling_code);
                            }
                            if (response.customerPersonalDetails.get_customer_contacts[i].landline_number === '0' || response.customerPersonalDetails.get_customer_contacts[i].landline_number === '' || response.customerPersonalDetails.get_customer_contacts[i].landline_number === null || response.customerPersonalDetails.get_customer_contacts[i].landline_number === "null") {
                                $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = "";
                            } else {
                                $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = parseInt(response.customerPersonalDetails.get_customer_contacts[i].landline_number);
                                $scope.contacts[i].landline_calling_code = $scope.contactData[i].landline_calling_code = '+' + parseInt(response.customerPersonalDetails.get_customer_contacts[i].landline_calling_code);
                            }
                            if (response.customerPersonalDetails.get_customer_contacts[i].pin === 0)
                                $scope.contacts[i].pin = $scope.contactData[i].landline_number = '';
                            if (response.customerPersonalDetails.get_customer_contacts[i].email_id === '' || response.customerPersonalDetails.get_customer_contacts[i].email_id === 'null')
                                $scope.contacts[i].email_id = $scope.contactData[i].email_id = '';

                            $scope.contactData.index = i;
                        }
                        $window.sessionStorage.setItem("sessionContactData", JSON.stringify(angular.copy(response.customerPersonalDetails.get_customer_contacts)));
                        $scope.searchData.customerId = response.customerPersonalDetails[0].id;
                    }, 500);
                    $scope.hideloader();
                });
            }
            if (customerId !== 0 && enquiryId !== 0) {
                $scope.pageHeading = 'Edit Enquiry';
                $scope.btnLabelC = $scope.btnLabelE = "Update";
                Data.post('master-sales/getEnquiryDetails', {
                    data: {customerId: customerId, enquiryId: enquiryId}}).then(function (response) {
                    if (!response.success) {
                        $scope.enquiryList = true;
                        $scope.showDivCustomer = true;
                        $scope.showDiv = true;
                        $scope.enquiryformDiv = true;
                    } else {
                        $scope.disableSource = true;
                        $scope.disableDataOnEnqUpdate = true;
                        $scope.enquiryData = angular.copy(response.enquiryDetails[0]);
                        var setTime = response.enquiryDetails[0].next_followup_time.split(":");
                        var location = response.enquiryDetails[0].enquiry_locations;
                        var d = new Date();
                        d.setHours(setTime[0]);
                        d.setMinutes(setTime[1]);
                        $scope.enquiryData.next_followup_time = d;
                        $scope.enquiryData.project_id = "";
                        $scope.enquiryData.block_id = $scope.enquiryData.sub_block_id = [];
                        $scope.hstep = 0;
                        $scope.mstep = 0;
                        $scope.customerData = angular.copy(response.customerPersonalDetails[0]);
                        $scope.contacts = angular.copy(response.customerContactDetails);
                        $scope.contactData = angular.copy(response.customerContactDetails);
                        $scope.searchData.searchWithMobile = response.customerContactDetails[0].mobile_number;
                        $scope.enquiryList = true;
                        $scope.showDivCustomer = true;

                        if (response.customerPersonalDetails[0].monthly_income == "0")
                            $scope.customerData.monthly_income = "";
                        else
                            $scope.customerData.monthly_income = angular.copy(response.customerPersonalDetails[0].monthly_income);

                        if (response.customerPersonalDetails[0].birth_date === null || response.customerPersonalDetails[0].birth_date === "-0001-11-30 00:00:00") {
                            $scope.customerData.birth_date = "";
                        } else {
                            var bdt = new Date(response.customerPersonalDetails[0].birth_date);
                            if (bdt.getDate() < 10) {
                                $scope.customerData.birth_date = (bdt.getFullYear() + '-' + ("0" + (bdt.getMonth() + 1)).slice(-2) + '-' + ("0" + bdt.getDate()));
                            } else {
                                $scope.customerData.birth_date = (bdt.getFullYear() + '-' + ("0" + (bdt.getMonth() + 1)).slice(-2) + '-' + bdt.getDate());
                            }
                            $scope.maxDates = response.customerPersonalDetails[0].birth_date;
                        }

                        if (response.customerPersonalDetails[0].marriage_date === null || response.customerPersonalDetails[0].marriage_date === "-0001-11-30 00:00:00") {
                            $scope.customerData.marriage_date = "";
                        } else {
                            var marriage_date = new Date(response.customerPersonalDetails[0].marriage_date);
                            if (marriage_date.getDate() < 10) {
                                $scope.customerData.marriage_date = (marriage_date.getFullYear() + '-' + ("0" + (marriage_date.getMonth() + 1)).slice(-2) + '-' + ("0" + marriage_date.getDate()));
                            } else {
                                $scope.customerData.marriage_date = (marriage_date.getFullYear() + '-' + ("0" + (marriage_date.getMonth() + 1)).slice(-2) + '-' + marriage_date.getDate());
                            }
                        }
                        for (var i = 0; i < response.customerContactDetails.length; i++) {
                            if (response.customerContactDetails[i].mobile_number === '0' || response.customerContactDetails[i].mobile_number === '' || response.customerContactDetails[i].mobile_number === null || response.customerContactDetails[i].mobile_number === "null") {
                                $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = "";
                                $scope.contacts[i].mobile_calling_code = $scope.contactData[i].mobile_calling_code = '';
                            } else {
                                $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = parseInt(response.customerContactDetails[i].mobile_number);
                                $scope.contacts[i].mobile_calling_code = $scope.contactData[i].mobile_calling_code = '+' + parseInt(response.customerContactDetails[i].mobile_calling_code);
                            }
                            if (response.customerContactDetails[i].landline_number === '0' || response.customerContactDetails[i].landline_number === '' || response.customerContactDetails[i].landline_number === null || response.customerContactDetails[i].landline_number === "null") {
                                $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = "";
                                $scope.contacts[i].landline_calling_code = $scope.contactData[i].landline_calling_code = "";
                            } else {
                                $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = parseInt(response.customerContactDetails[i].landline_number);
                                $scope.contacts[i].landline_calling_code = $scope.contactData[i].landline_calling_code = '+' + parseInt(response.customerContactDetails[i].landline_calling_code);
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
                        $scope.searchData.customerId = response.customerPersonalDetails[0].id;
//                        $scope.disableText = true; //disable mobile and email text box 

                        $timeout(function () {
                            $scope.hstep = $scope.mstep = 0;
                            $scope.projectsDetails = response.projectDetails;
                            $("li#enquiryDiv").css("display", "block");
                            $("li#enquiryDiv a.ng-binding").trigger("click");
                            $scope.enquiryData.city_id = angular.copy(response.city_id);
                            var selectedLocations = [];
                            Data.post('master-sales/getAllLocations', {
                                city_id: response.city_id,
                            }).then(function (response) {
                                $scope.locations = response.records;
                                console.log($scope.locations);
                                for (var i = 0; i < $scope.locations.length; i++) {
                                    if ($scope.locations[i]['id'] == location) {
                                        selectedLocations.push($scope.locations[i]);
                                        $scope.enquiryData.enquiry_locations = selectedLocations;
                                    }
                                }
                            });
                        }, 1000);
                    }
                });
            }
        }
        $scope.createEnquiry = function () {
            
            SweetAlert.swal({
                title: "Enquiry Already Exists!", //Bold text
                text: "Do you really want to create new enquiry?", //light text
                type: "warning", //type -- adds appropiriate icon
                showCancelButton: true, // displays cancel btton
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: true, //do not close popup after click on confirm, usefull when you want to display a subsequent popup
                closeOnCancel: true
            },
                    function (isConfirm) { //Function that triggers on user action.
                        if (isConfirm) {
                            
                        
            Data.post('master-sales/getCustomerDetails', {
                data: {customerMobileNo: $scope.searchData.searchWithMobile, customerEmailId: $scope.searchData.searchWithEmail, showCustomer: 1},
            }).then(function (response) {
                $scope.showDiv = false;
                $scope.showDivCustomer = true;
                $scope.disableSource = true;
                $scope.btnLabelC = "Update & Insert enquiry";
                $scope.btnLabelE = "Save";
                $scope.pageHeading = 'Update Customer';
                $scope.customerData = angular.copy(response.customerPersonalDetails[0]);
                $scope.contacts = angular.copy(response.customerContactDetails);
                $scope.contactData = angular.copy(response.customerContactDetails);

                if (response.customerPersonalDetails[0].monthly_income == "0")
                    $scope.customerData.monthly_income = "";
                else
                    $scope.customerData.monthly_income = angular.copy(response.customerPersonalDetails[0].monthly_income);

                if (response.customerPersonalDetails[0].birth_date === null || response.customerPersonalDetails[0].birth_date === "-0001-11-30 00:00:00") {
                    $scope.customerData.birth_date = "";
                } else {
                    var bdt = new Date(response.customerPersonalDetails[0].birth_date);
                    if (bdt.getDate() < 10) {
                        $scope.customerData.birth_date = (bdt.getFullYear() + '-' + ("0" + (bdt.getMonth() + 1)).slice(-2) + '-' + ("0" + bdt.getDate()));
                    } else {
                        $scope.customerData.birth_date = (bdt.getFullYear() + '-' + ("0" + (bdt.getMonth() + 1)).slice(-2) + '-' + bdt.getDate());
                    }
                    $scope.maxDates = response.customerPersonalDetails[0].birth_date;
                }

                if (response.customerPersonalDetails[0].marriage_date === null || response.customerPersonalDetails[0].marriage_date === "-0001-11-30 00:00:00") {
                    $scope.customerData.marriage_date = "";
                } else {
                    var marriage_date = new Date(response.customerPersonalDetails[0].marriage_date);
                    if (marriage_date.getDate() < 10) {
                        $scope.customerData.marriage_date = (marriage_date.getFullYear() + '-' + ("0" + (marriage_date.getMonth() + 1)).slice(-2) + '-' + ("0" + marriage_date.getDate()));
                    } else {
                        $scope.customerData.marriage_date = (marriage_date.getFullYear() + '-' + ("0" + (marriage_date.getMonth() + 1)).slice(-2) + '-' + marriage_date.getDate());
                    }
                }
                for (var i = 0; i < response.customerContactDetails.length; i++) {
                    if (response.customerContactDetails[i].mobile_number === '0' || response.customerContactDetails[i].mobile_number === '' || response.customerContactDetails[i].mobile_number === null || response.customerContactDetails[i].mobile_number === "null") {
                        $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = "";
                        $scope.contacts[i].mobile_calling_code = $scope.contactData[i].mobile_calling_code = '';
                    } else {
                        $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = parseInt(response.customerContactDetails[i].mobile_number);
                        $scope.contacts[i].mobile_calling_code = $scope.contactData[i].mobile_calling_code = '+' + parseInt(response.customerContactDetails[i].mobile_calling_code);
                    }
                    if (response.customerContactDetails[i].landline_number === '0' || response.customerContactDetails[i].landline_number === '' || response.customerContactDetails[i].landline_number === null || response.customerContactDetails[i].landline_number === "null") {
                        $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = "";
                        $scope.contacts[i].landline_calling_code = $scope.contactData[i].landline_calling_code = "";
                    } else {
                        $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = parseInt(response.customerContactDetails[i].landline_number);
                        $scope.contacts[i].landline_calling_code = $scope.contactData[i].landline_calling_code = '+' + parseInt(response.customerContactDetails[i].landline_calling_code);
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
                $scope.searchData.customerId = response.customerPersonalDetails[0].id;
//                $scope.disableText = true; //disable mobile and email text box 
            });
            }
            else {}
                });            
        }
        
         $scope.newEnquiryCreate = function () {
             $state.reload();
         }

        /****************************************Enquiry Controller*********************************************/

        $scope.historyList = {};
//        $scope.pageChangeHandler = function (num) {
//            $scope.noOfRows = num;
//            $scope.currentPage = num * $scope.itemsPerPage;
//        };
        $scope.saveEnquiryData = function (enquiryData)
        {
            var date = new Date($scope.enquiryData.next_followup_date);
            $scope.enquiryData.next_followup_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            if (typeof $scope.enquiryData.id === 'undefined') {
                var enqData = enquiryData;
                Data.post('master-sales/saveEnquiry', {
                    enquiryData: enquiryData, customer_id: $scope.customer_id, projectEnquiryDetails: $scope.projectsDetails, MobileNo: $scope.searchData.searchWithMobile, EmailId: $scope.searchData.searchWithEmail,
                }).then(function (response) {
                    if (response.success) {
                        toaster.pop('success', 'Enquiry', response.message);
                        $scope.disableFinishButton = true;
                        $state.reload();
                    }
//                    var obj = response.data.message;
//                    var selector = [];
//                    for (var key in obj) {
//                        var model = $parse(key);// Get the model
//                        model.assign($scope, obj[key][0]);// Assigns a value to it
//                        selector.push(key);
//                    }
                });
            } else {
                Data.put('master-sales/updateEnquiry/' + $scope.enquiryData.id, {
                    enquiryData: enquiryData, customer_id: $scope.customer_id, projectEnquiryDetails: $scope.projectsDetails,
                }).then(function (response) {
                    toaster.pop('success', 'Enquiry', response.message);
                });
            }
        }
        $scope.addProjectRow = function (projectId)
        {
            if ((projectId !== ""))
            {
                var totalSubBlocks = $scope.enquiryData.sub_block_id.length;
                var totalBlocks = $scope.enquiryData.block_id.length;
                $scope.subblockname = [];
                $scope.sub_block_id = [];
                $scope.blockname = [];
                $scope.block_id = [];
                for (var i = 0; i < totalSubBlocks; i++)
                {
                    $scope.subblockname.push($scope.enquiryData.sub_block_id[i].block_sub_type);
                    $scope.sub_block_id.push($scope.enquiryData.sub_block_id[i].id);
                }
                for (var j = 0; j < totalBlocks; j++)
                {
                    $scope.blockname.push($scope.enquiryData.block_id[j].block_name);
                    $scope.block_id.push($scope.enquiryData.block_id[j].id);
                }
                if ($scope.enquiryData.id === 'undefined') {
                    Data.post('master-sales/addEnquiryDetailRow', {
                        enquiry_id: $scope.enquiryData.id,
                        project_id: $scope.enquiryData.project_id.split('_')[0],
                        block_id: $scope.block_id.toString(),
                        sub_block_id: $scope.sub_block_id.toString()
                    }).then(function (response) {
                        $scope.projectsDetails.push({
                            'id': response.enqId,
                            'project_id': $scope.enquiryData.project_id.split('_')[0],
                            'project_name': $scope.enquiryData.project_id.split('_')[1],
                            'blocks': $scope.blockname.toString(),
                            'block_id': $scope.block_id.toString(),
                            'sub_block_id': $scope.sub_block_id.toString(),
                            'subblocks': $scope.subblockname.toString(),
                        })
                    });
                } else {
                    $scope.projectsDetails.push({
                        'project_id': $scope.enquiryData.project_id.split('_')[0],
                        'project_name': $scope.enquiryData.project_id.split('_')[1],
                        'blocks': $scope.blockname.toString(),
                        'block_id': $scope.block_id.toString(),
                        'sub_block_id': $scope.sub_block_id.toString(),
                        'subblocks': $scope.subblockname.toString(),
                    });
                }
                $("#projectBody").hide();
                $scope.enquiryData.block_id = {};
                $scope.enquiryData.sub_block_id = {};
                $scope.enquiryData.project_id = '';
            } else {
                if (projectId == "") {
                    $scope.emptyProjectId = true;
                }
                if (blockId == "") {
                    $scope.emptyBlockId = true;
                }
                if (subBlockId == "") {
                    $scope.emptySubBlockId = true;
                }
            }
        }
        $scope.removeRow = function (rowId, enquiryDetailId) {
            if (enquiryDetailId !== '') {
                Data.post('master-sales/delEnquiryDetailRow', {
                    enquiryDetailId: enquiryDetailId,
                }).then(function () {});
            }
            var index = -1;
            var comArr = eval($scope.projectsDetails);
            for (var i = 0; i < comArr.length; i++) {
                if (comArr[i].name === rowId) {
                    index = i;
                    break;
                }
            }
            $scope.projectsDetails.splice(index, 1);

        }
        $scope.changeLocations = function (cityId)
        {
            Data.post('master-sales/getAllLocations', {
                city_id: cityId,
            }).then(function (response) {
                $scope.enquiryData.enquiry_locations = [];
                $scope.locations = response.records;
            });
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
                        $scope.contacts.mobile_number = modelValue;
                    }, 1000);
                });
            };
        }
    }
});
app.directive('checkEmailExist', function ($timeout, $q, Data) {
    return {
        restrict: 'AE',
        require: 'ngModel',
        link: function ($scope, element, attributes, model) {
            model.$asyncValidators.uniqueEmail = function (modelValue) {
            if (model.$isEmpty(modelValue))
                return $q.when();
            else{
                //if(typeof modelValue !== 'undefined' || modelValue !== ''){
                var emailid = modelValue;console.log(emailid);
                var customerId = $scope.searchData.customerId;
                return Data.post('master-sales/checkEmailExist', {
                    data: {emailid: emailid, customerId: customerId},
                }).then(function (response) {
                    $timeout(function () {
                        model.$setValidity('uniqueEmail', !!response.success);
                    }, 1000);
                });
                
                }
            };
        }
    }
});

app.controller('getEmployeesCtrl', function ($scope, Data) {
    Data.get('master-sales/getEmployees').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.employeeList = response.records;
        }
    });
});
app.controller('financeEmployees', function ($scope, Data) {
    Data.get('master-sales/getFinanceEmployees').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.financeEmpList = response.records;
        }
    });
});
app.controller('agencyTieupCtrl', function ($scope, Data) {
    Data.get('getFinanceTieupAgency').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.agencyTieupList = response.records;
        }
    });
});
app.controller('enquiryCityCtrl', function ($scope, Data) {
    Data.get('master-sales/getEnquiryCity').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.cityList = response.records;
        }
    });
});
