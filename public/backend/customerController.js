'use strict';
app.controller('customerController', ['$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', 'toaster', '$location', 'SweetAlert', '$rootScope', function ($scope, $state, Data, Upload, $timeout, $parse, $window, toaster, $location, SweetAlert, $rootScope) {
        $scope.pageHeading = 'Detailed Enquiry';
        $scope.customerData = [];
        $scope.contactData = [];
        $scope.searchData = {};
        $scope.enquiryData = {};
        $scope.historyList = {};
        $scope.btnLabelC = $scope.btnLabelE = "Save";
        $scope.projectsDetails = [];
        $scope.locations = [];
        $scope.projectList = [];
        $scope.blockTypeList = [];
        $scope.contacts = [];
        $scope.enqType = '';
        $scope.modalForm = {};
        $scope.editProBtnn = false;
        $scope.addProBtnn = true;
        $scope.initmoduelswisehisory = [1,2];
        $scope.errMobile = '';
        $scope.customerData.sms_privacy_status = $scope.customerData.email_privacy_status = 1;
        resetContactDetails();
        $scope.showDiv = $scope.enquiryList = $scope.disableSource = $scope.showDivCustomer = false;
        $scope.searchData.customerId = 0;
        $scope.hstep = 1;
        $scope.mstep = 15;
        var today = new Date();
        today.setYear(today.getFullYear() - 20);
        $scope.maxDates = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        var tdate= new Date();
        $scope.todaydate = (tdate.getFullYear()+ '-' + ("0" + (tdate.getMonth() + 1)).slice(-2) + '-' + tdate.getDate() );
        $scope.showaddress = true;
        $scope.hideaddress = false;
        $scope.customerAddress = false;
        $scope.salesBudgetList = [];
        
        $scope.onClickEnqTab = function(){ //firefox - design setting
            $(".demo-tab .tab-content").css("float","none");
        }
        $scope.onClickCustTab = function(){//firefox - design setting
            $(".demo-tab .tab-content").css("float","left");
        }
        $scope.todayremarkTimeChange = function (selectedDate)
        {
            if ($scope.enquiryData.id <= 0) {
                $scope.enquiryData.next_followup_time = '';
            }
            if (typeof selectedDate === 'undefined') {
                $scope.timeList = [];
                $scope.enquiryData.next_followup_time = '';
            } else {
                var currentDate = new Date();
                $scope.currentDate = (currentDate.getFullYear() + '-' + ("0" + (currentDate.getMonth() + 1)).slice(-2) + '-' + currentDate.getDate());
                var selectedDate = new Date(selectedDate);
                $scope.selectedDate = (selectedDate.getFullYear() + '-' + ("0" + (selectedDate.getMonth() + 1)).slice(-2) + '-' + selectedDate.getDate());
                Data.post('getnextfollowupTime', {
                    data: {currentDate: $scope.currentDate, selectedDate: $scope.selectedDate},
                }).then(function (response) {
                    if (!response.success) {
                        $scope.errorMsg = response.message;
                    } else {
                        $scope.timeList = response.records;
                        if ($scope.enquiryData.next_followup_time == '')
                            $scope.enquiryData.next_followup_time = '';
                    }
                });
            }
        }
        $scope.getModulesWiseHist_list = function (enquiry_id, opt, flag)
        {
            if (opt == 1)
            {
                if ($('.chk_enquiry_history_list').is(":checked"))
                {
                    $(':checkbox.chk_followup_history_all_list').prop('checked', true);
                } else
                {
                    $(':checkbox.chk_followup_history_all_list').prop('checked', false);
                }
            }
            var mhistory1 = [];
            if ($('.chk_presales_list').is(":checked"))
            {
                mhistory1.push($('#chk_presales_list').data("id"));
            }
            if ($('.chk_Customer_Care_list').is(":checked"))
            {
                mhistory1.push($('#chk_Customer_Care_list').data("id"));
            }
            if (mhistory1.length == 2)
            {
                $(':checkbox#chk_enquiry_history_list').prop('checked', true);
            } else
            {
                $(':checkbox#chk_enquiry_history_list').prop('checked', false);
            }
            $scope.initHistoryDataModal(enquiry_id, mhistory1, 0, flag);
        };

        $scope.initHistoryDataModal = function (enquiry_id, moduelswisehisory, init, flag)
        {
            if (flag === 'todayremarkFlag') {
                if (init === 1)
                {
                    $('.chk_followup_history_all_remark').prop('checked', true);
                    $('.chk_enquiry_history_remark').prop('checked', true);
                }
            } else if (flag === 'listFlag') {
                if (init === 1)
                {
                    $('.chk_followup_history_all_list').prop('checked', true);
                    $('.chk_enquiry_history_list').prop('checked', true);
                }
            } else {
                if (init === 1)
                {
                    $(':checkbox.chk_followup_history_all').prop('checked', true);
                    $(':checkbox.chk_enquiry_history').prop('checked', true);
                }
            }

            Data.post('customer-care/presales/getenquiryHistory', {
                enquiryId: enquiry_id, moduelswisehisory: moduelswisehisory
            }).then(function (response) {
                $scope.history_enquiryId = enquiry_id;
                $scope.chk_followup_history_all = true;
                $scope.chk_followup_history_all_remark = true;
                if (response.success) {
                    $scope.historyList = angular.copy(response.records);
                    $timeout(function () {
                        for (i = 0; i < $scope.historyList.length; i++) {
                            if ($scope.historyList[i].call_recording_url != "" && $scope.historyList[i].call_recording_url != "None") {
                                document.getElementById("recording_" + $scope.historyList[i].id).src = $scope.historyList[i].call_recording_url;
                            }
                        }
                    }, 1000);
                } else
                {
                    $scope.historyList = angular.copy(response.records);

                }
            });
        }


        $scope.manageQuickEnquiry = function (id) {
            $scope.searchData.mobile_calling_code = '+91';
            $(".countryClass ul li").click(function () {
                $("#searchWithMobile").val('');
                $('.showDivCustomer').hide();
                $('.showDiv').hide();
            });
        }

        $scope.readyPossession = function () {
            $scope.enquiryData.property_possession_date = '';
        }

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

        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
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

        $scope.checkEmailValue = function () {
            if (typeof $scope.searchData.searchWithEmail === 'undefined' || $scope.searchData.searchWithEmail === '') {
                $scope.errEmail = false;
                $scope.showDiv = false;                
                $scope.showDivCustomer = false;
            } else {
//                var reg = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (!reg.test($scope.searchData.searchWithEmail)) {
                    $scope.errEmail = true;
                    $scope.showDiv = false;
                    $scope.showDivCustomer = false;
                } else {
                    $scope.errEmail = "";
                    $scope.errEmail = false;
                    $scope.showDiv = true;
                    $scope.showDivCustomer = true;
                }
            }
            alert($scope.errEmail);
        }

        $scope.checkValue = function () {
            if (typeof $scope.searchData.searchWithMobile === 'undefined' || $scope.searchData.searchWithMobile === '' || $scope.searchData.searchWithEmail === '') {
                $scope.showDiv = false;
                $scope.errMobile = false;
                $scope.showDivCustomer = false;
            } else {
                var regMobile = /^[789]/;
                if (!regMobile.test($scope.searchData.searchWithMobile)) {
                    $scope.errMobile = true;
                } else {
                    $scope.errMobile = "";
                    $scope.errMobile = false;
                }
            }
        }
        $scope.checkMobileValue = function () {
            if (typeof $scope.contactData.mobile_number === 'undefined' || $scope.contactData.mobile_number === '') {
                $scope.errMobileNo = false;
            } else {
                var regMobile = /^[789]/;
                if (!regMobile.test($scope.contactData.mobile_number)) {
                    $scope.errMobileNo = true;
                } else {
                    $scope.errMobileNo = "";
                    $scope.errMobileNo = false;
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
            $scope.contactData.house_number = $scope.contactData.address_type == 'null' ? '' : $scope.contactData.address_type;
            $scope.contactData.house_number = $scope.contactData.house_number == 'null' ? '' : $scope.contactData.house_number;
            $scope.contactData.building_house_name = $scope.contactData.building_house_name == 'null' ? '' : $scope.contactData.building_house_name;
            $scope.contactData.wing_name = $scope.contactData.wing_name == 'null' ? '' : $scope.contactData.wing_name;
            $scope.contactData.lane_name = $scope.contactData.lane_name == 'null' ? '' : $scope.contactData.lane_name;
            $scope.contactData.landmark = $scope.contactData.landmark == 'null' ? '' : $scope.contactData.landmark;
            $scope.contactData.google_map_link = $scope.contactData.google_map_link == 'null' ? '' : $scope.contactData.google_map_link;
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
                            $scope.contactData.mobile_calling_code = $("#mobile_calling_code1").val();
                            $scope.contactData.landline_calling_code = $("#landline_calling_code").val();
                            $scope.contacts.splice(index, 1); //Remove index
                            $scope.contacts.splice(index, 0, contactData);  //Update new value and returns array
                            $scope.contactData = {};
                        }
                    });
                } else {
                    $scope.contacts.push({
                        'mobile_calling_code': $("#mobile_calling_code1").val(),
                        'mobile_number_lable': $scope.contactData.mobile_number_lable,
                        'mobile_number': $scope.contactData.mobile_number,
                        'landline_calling_code': $("#landline_calling_code").val(),
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

            }
            sessionContactData = $window.sessionStorage.setItem("sessionContactData", JSON.stringify($scope.contacts));
            $scope.contactData = {};
            $scope.modalForm.$setPristine();
            $scope.modalForm.$setUntouched();
            $('#contactDataModal').modal('toggle');
        };
        function resetContactDetails() {
            $timeout(function () {
                $scope.contactData.mobile_number_lable = $scope.contactData.landline_lable =
                        $scope.contactData.email_id_lable = $scope.contactData.address_type = 1;
                $scope.contactData.mobile_calling_code = '+91';
                $scope.contactData.landline_calling_code = '+91';
                $scope.contactData.email_id = $scope.contactData.house_number =
                        $scope.contactData.building_house_name = $scope.contactData.wing_name =
                        $scope.contactData.area_name = $scope.contactData.lane_name =
                        $scope.contactData.landmark = $scope.contactData.country_id =
                        $scope.contactData.state_id = $scope.contactData.city_id = $scope.contactData.pin =
                        $scope.contactData.google_map_link = $scope.contactData.other_remarks = '';
                $scope.contactData.index = $scope.contacts.length;
            }, 200);
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
            $scope.custSubmitBtn = true;
            if ($window.sessionStorage.getItem("sessionContactData") != '') {
                sessionContactData = JSON.parse($window.sessionStorage.getItem("sessionContactData"));
                if (sessionContactData === null || sessionContactData === '') {
                    $('#errContactDetails').text(" - Please add contact details");
                    return false;
                } else {
                    sessionContactData = JSON.parse($window.sessionStorage.getItem("sessionContactData"));
                }
            } else {
                sessionContactData = '';
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
                var url = '/master-sales/update/' + $scope.searchData.customerId;
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
                        $scope.custSubmitBtn = false;
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
                        if ($rootScope.newEnqFlag !== 0 && $rootScope.newEnqFlag1 !== 0) {
                            document.getElementById("enquiryDiv").style.display = 'block';
                            $("li#enquiryDiv a.ng-binding").trigger("click");
                        } else if ($rootScope.newEnqFlag !== 0 || $rootScope.newEnqFlag1 !== 0)
                        {
                            document.getElementById("enquiryDiv").style.display = 'block';
                            $("li#enquiryDiv a.ng-binding").trigger("click");
                        } else
                        {
                            $window.history.back();
                        }
                        $scope.customer_id = response.data.customerId;
                        if ($scope.searchData.customerId === 0 || $scope.searchData.customerId === '') {
                            toaster.pop('success', 'Customer', 'Record successfully created');
                            $scope.custSubmitBtn = true;
                        } else {
                            toaster.pop('success', 'Customer', 'Record successfully updated');
                            $scope.custSubmitBtn = false;
                        }
                    }
                });
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong. Check your internet connection";
                }
            }, function (evt, response) {});
        };
        $scope.backToListing = function (mobileNo, emailId, extraParam = '1') {
            if (extraParam == '0')
                $rootScope.newEnqFlag = extraParam;
            if ($rootScope.newEnqFlag !== '0')
            {
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
            } else {
                $window.history.back();
        }
        }

        $scope.resetForm = function () {
            $state.go('salesCreate');
        }
        $scope.addContactDetails = function () {
            $scope.modal = {};
        }
        $scope.manageForm = function (customerId, enquiryId, enqType) {
                // operational setting for enquiry days,preffered areas,max budget
            Data.post('operational-setting/getOperationalSettings').then(function (response) {
               var len = response.records.length;
                for(var i = 0;i < len ; i++)
                {
                //set enquiry creation date 
                if(response.records[i].id === 1){
                   var date = new Date();
                $scope.enqCreationDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - response.records[0].data);
                continue;
                }
                if(response.records[i].id === 4){
                    var min =  parseInt(response.records[i].min_budget);
                    var max =  parseInt(response.records[i].max_budget);
                    var result;
                    for(var i=min;i<max;i= i+10){
                        result = i + 10;
                        var x = i+"00000 - "+result+"00000";
                        $scope.salesBudgetList.push(x);
                    }
                }                    
                }
            });
            $scope.enqType = enqType;
            var date = new Date();            
            $scope.enquiryData.sales_category_id = $scope.enquiryData.property_possession_type = "1";
            $scope.enquiryData.city_id = $scope.enquiryData.followup_by_employee_id = "";
            $scope.enquiryData.parking_required = $scope.enquiryData.finance_required = "0";
            date.setHours("10");
            date.setMinutes("00");
            //$scope.enquiryData.next_followup_time = date;
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
                        var mdate = new Date($scope.customerData.marriage_date);
                        $scope.enquiryData.marriage_date = (mdate.getFullYear() + '-' + ("0" + (mdate.getMonth() + 1)).slice(-2) + '-' + mdate.getDate());
                        $scope.contacts = angular.copy(response.customerPersonalDetails.get_customer_contacts);
                        $scope.contactData = angular.copy(response.customerPersonalDetails.get_customer_contacts);
                        $scope.searchData.searchWithMobile = response.customerPersonalDetails.get_customer_contacts[0].mobile_number;
                        $scope.searchData.searchWithEmail = response.customerPersonalDetails.get_customer_contacts[0].email_id;
                        $scope.searchData.mobile_calling_code = "+" + response.customerPersonalDetails.get_customer_contacts[0].mobile_calling_code;
                        if (response.customerPersonalDetails[0].monthly_income == "0")
                            $scope.customerData.monthly_income = "";
                        else
                            $scope.customerData.monthly_income = angular.copy(response.customerPersonalDetails[0].monthly_income);

                        if (response.customerPersonalDetails[0].birth_date === '0000-00-00' || response.customerPersonalDetails[0].birth_date === 'NaN-aN-NaN') {
                            $scope.customerData.birth_date = '';
                           
                        } else {
                            $scope.customerData.birth_date = response.customerPersonalDetails[0].birth_date;
                            $scope.maxDates = response.customerPersonalDetails[0].birth_date;
                            
                        }
                        if (response.customerPersonalDetails[0].marriage_date === null || response.customerPersonalDetails[0].marriage_date === "-0001-11-30 00:00:00" || response.customerPersonalDetails[0].marriage_date === "0000-00-00" || response.customerPersonalDetails[0].marriage_date === 'NaN-aN-NaN') {
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
                                $scope.contacts[i].landline_calling_code = $scope.contactData[i].landline_calling_code = '+' + response.customerPersonalDetails.get_customer_contacts[i].landline_calling_code;


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

                        if (response.customerPersonalDetails[0].corporate_customer === 1) {
                            $scope.customerData.corporate_customer = true;
                            $scope.isChecked(true);
                        } else {
                            $scope.customerData.corporate_customer = false;
                            $scope.companyInput = false;
                            $scope.customerData.company_id = 0;
                            $scope.customerData.company_name = "";
                        }
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
                        $scope.enquiryData.four_wheeler_parkings_required = (response.enquiryDetails[0].four_wheeler_parkings_required == 0) ? '' : response.enquiryDetails[0].four_wheeler_parkings_required;
                        $scope.enquiryData.two_wheeler_parkings_required = (response.enquiryDetails[0].two_wheeler_parkings_required == 0) ? '' : response.enquiryDetails[0].two_wheeler_parkings_required;
                        if(response.enquiryDetails[0].max_budget !==0 && response.enquiryDetails[0].min_budget !== 0){
                            var maxbudget = response.enquiryDetails[0].min_budget+" - "+response.enquiryDetails[0].max_budget;
                            $scope.enquiryData.max_budget = (response.enquiryDetails[0].max_budget == 0) ? '' : maxbudget;
                        }                        
                        $scope.enquiryData.next_followup_date = (response.enquiryDetails[0].next_followup_date == '0000-00-00') ? '' : response.enquiryDetails[0].next_followup_date;
                        $scope.enquiryData.next_followup_time = response.enquiryDetails[0].next_followup_time;
//                        $scope.enquiryData.property_possession_date = (response.enquiryDetails[0].property_possession_date == '0000-00-00' || response.enquiryDetails[0].property_possession_date == undefined) ? '' : response.enquiryDetails[0].property_possession_date;
                        if(response.enquiryDetails[0].followup_by_employee_id === '')
                        {
                           response.enquiryDetails[0].followup_by_employee_id = $("#loginid").val(); 
                        }
                        if (response.enquiryDetails[0].property_possession_date === null || response.enquiryDetails[0].property_possession_date === "-0001-11-30 00:00:00" || response.enquiryDetails[0].property_possession_date === "0000-00-00" || response.enquiryDetails[0].property_possession_date == undefined) {
                          
                            $scope.enquiryData.property_possession_date = "";
                        } else {
                            $scope.enquiryData.property_possession_date = response.enquiryDetails[0].property_possession_date;
                        }
                        var setTime = response.enquiryDetails[0].next_followup_time.split(":");
                        var location = response.enquiryDetails[0].enquiry_locations;

                        var d = new Date();
                        d.setHours(setTime[0]);
                        d.setMinutes(setTime[1]);

                        if ($scope.enquiryData.next_followup_date !== "" && $scope.enquiryData.next_followup_date !== null)
                        {
                            $scope.todayremarkTimeChange($scope.enquiryData.next_followup_date);
                        }
                        $scope.enquiryData.project_id = "";
                        $scope.enquiryData.block_id = $scope.enquiryData.sub_block_id = [];
                        $scope.hstep = 0;
                        $scope.mstep = 0;
                        $scope.customerData = angular.copy(response.customerPersonalDetails[0]);
                        $scope.contacts = angular.copy(response.customerContactDetails);
                        $scope.contactData = angular.copy(response.customerContactDetails);
                        $scope.searchData.searchWithMobile = response.customerContactDetails[0].mobile_number;
                        $scope.searchData.searchWithEmail = response.customerContactDetails[0].email_id;
                        $scope.searchData.mobile_calling_code = "+" + response.customerContactDetails[0].mobile_calling_code;
//                        $scope.searchData.landline_calling_code = "+" + response.customerContactDetails[0].landline_calling_code;
                        $scope.enquiryList = true;
                        $scope.showDivCustomer = true;

                        if (response.customerPersonalDetails[0].monthly_income == "0")
                            $scope.customerData.monthly_income = "";
                        else
                            $scope.customerData.monthly_income = angular.copy(response.customerPersonalDetails[0].monthly_income);

                        if (response.customerPersonalDetails[0].birth_date === null || response.customerPersonalDetails[0].birth_date === "-0001-11-30 00:00:00" || response.customerPersonalDetails[0].birth_date === 'NaN-aN-NaN' || response.customerPersonalDetails[0].birth_date === '0000-00-00') {
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
                                $scope.contacts[i].landline_calling_code = $scope.contactData[i].landline_calling_code = "+" + response.customerContactDetails[i].landline_calling_code;
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
                        if (response.customerPersonalDetails[0].corporate_customer === 1) {
                            $scope.customerData.corporate_customer = true;
                            $scope.isChecked(true);
                        } else {
                            $scope.customerData.corporate_customer = false;
                            $scope.companyInput = false;
                            $scope.customerData.company_id = 0;
                            $scope.customerData.company_name = "";
                        }
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
                                for (var i = 0; i < $scope.locations.length; i++) {
                                    if ($scope.locations[i]['id'] == location) {
                                        selectedLocations.push($scope.locations[i]);
                                        $scope.enquiryData.enquiry_locations = selectedLocations;
                                    }
                                }
                            });
                            $rootScope.newEnqFlag = 1;
                            if (response.customerPersonalDetails[0].gender_id === 0) {
                                $scope.customerData.gender_id = "";
                            }
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
                                data: {customerMobileNo: $scope.searchData.searchWithMobile, customerCallingCode: $scope.searchData.mobile_calling_code.trim(), customerEmailId: $scope.searchData.searchWithEmail, showCustomer: 1},
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
                                $scope.customerData.company_name = (response.customerPersonalDetails[0].company_name !== '' && response.customerPersonalDetails[0].company_name !== 'null') ? angular.copy(response.customerPersonalDetails[0].company_name) : '';
//                                $scope.customerData.corporate_customer = angular.copy(response.customerPersonalDetails[0].corporate_customer);
                                if (response.customerPersonalDetails[0].corporate_customer === 1) {
                                    $scope.customerData.corporate_customer = true;
                                    $scope.isChecked(true);
                                } else {
                                    $scope.customerData.corporate_customer = false;
                                    $scope.companyInput = false;
                                    $scope.customerData.company_id = 0;
                                    $scope.customerData.company_name = "";
                                }
                                if (response.customerPersonalDetails[0].monthly_income == "0")
                                    $scope.customerData.monthly_income = "";
                                else
                                    $scope.customerData.monthly_income = angular.copy(response.customerPersonalDetails[0].monthly_income);

                                if (response.customerPersonalDetails[0].birth_date === null || response.customerPersonalDetails[0].birth_date === "-0001-11-30 00:00:00" || response.customerPersonalDetails[0].birth_date === 'NaN-aN-NaN') {
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

                                $rootScope.newEnqFlag = 1;
//                $scope.disableText = true; //disable mobile and email text box 
                            });
                        } else {
                        }
                    });
        }

        $scope.newEnquiryCreate = function () {
            $state.reload();
        }

        /****************************************Enquiry Controller*********************************************/
        $scope.historyList = {};
        $scope.saveEnquiryData = function (enquiryData)
        {
            if(enquiryData.followup_by_employee_id === '')
            {
               enquiryData.followup_by_employee_id = $("#loginid").val(); 
            } 
            if(enquiryData.max_budget !== '' && enquiryData.max_budget !==0  && typeof enquiryData.max_budget !== 'undefined'){
                var arr = enquiryData.max_budget.split(" - ");
                enquiryData.min_budget = arr[0];
                enquiryData.max_budget = arr[1];
            }           
            $scope.disableFinishButton = true;
            var mobilecc = $("#mobile_calling_code").val();
            var date = new Date($scope.enquiryData.next_followup_date);
            $scope.enquiryData.next_followup_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            if($scope.enquiryData.property_possession_date !== "0000-00-00")
            {
                var tentativeDate = new Date($scope.enquiryData.property_possession_date);
                $scope.enquiryData.property_possession_date = (tentativeDate.getFullYear() + '-' + ("0" + (tentativeDate.getMonth() + 1)).slice(-2) + '-' + tentativeDate.getDate());
            }
            if (mobilecc != '') {
                enquiryData.mobile_calling_code = mobilecc;
            }

            if (typeof $scope.enquiryData.id === 'undefined') {
                var enqData = enquiryData;
                Data.post('master-sales/saveEnquiry', {
                    enquiryData: enquiryData, customer_id: $scope.customer_id, projectEnquiryDetails: $scope.projectsDetails, MobileNo: $scope.searchData.searchWithMobile, EmailId: $scope.searchData.searchWithEmail,
                }).then(function (response) {
                    if (response.success) {
                        $scope.disableFinishButton = true;
                        toaster.pop('success', 'Enquiry', response.message);
                        $state.go('enquiries');
                    } else {
                        $scope.disableFinishButton = false;
                        var obj = response.message;
                        var selector = [];
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                            selector.push(key);
                        }
                    }
                });
            } else {
                Data.put('master-sales/updateEnquiry/' + $scope.enquiryData.id, {
                    enquiryData: enquiryData, customer_id: $scope.customer_id, projectEnquiryDetails: $scope.projectsDetails,
                }).then(function (response) {
                    if (response.success)
                    {
                        toaster.pop('success', 'Enquiry', response.message);
                        $window.history.back();
                    } else
                    {
                        $scope.disableFinishButton = false;
                        var obj = response.message;
                        var selector = [];
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                            selector.push(key);
                        }
                    }
                });
            }
        }

        $scope.addProjectRow = function (projectId)
        {
            if (projectId !== "" && typeof projectId !== "undefined" && $scope.enquiryData.block_id.length > 0)
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
            }
        }

        $scope.editProjectRow = function (projectId)
        {
            $scope.projects_id = $scope.enquiryData.project_id.split('_')[0];
            $scope.projects_name = $scope.enquiryData.project_id.split('_')[1];
            var totalSubBlocks = $scope.enquiryData.sub_block_id.length;
            var totalBlocks = $scope.enquiryData.block_id.length;
            $scope.subblockname = [];
            $scope.sub_block_id = [];
            $scope.blockname = [];
            $scope.block_id = [];

            for (var j = 0; j < totalBlocks; j++)
            {
                $scope.blockname.push($scope.enquiryData.block_id[j].block_name);
                $scope.block_id.push($scope.enquiryData.block_id[j].id);
            }
            for (var i = 0; i < totalSubBlocks; i++)
            {
                $scope.subblockname.push($scope.enquiryData.sub_block_id[i].block_sub_type);
                $scope.sub_block_id.push($scope.enquiryData.sub_block_id[i].id);
            }
            Data.post('master-sales/addEnquiryDetailRow', {
                enquiry_id: $scope.enquiryData.id,
                project_id: $scope.enquiryData.project_id.split('_')[0],
                block_id: $scope.block_id.toString(),
                sub_block_id: $scope.sub_block_id.toString()
            }).then(function (response) {
                $scope.projectsDetails.splice($scope.index, 1);
                $scope.projectsDetails.splice($scope.index, 0, {
                    'id': response.enqId,
                    'project_id': $scope.projects_id,
                    'project_name': $scope.projects_name,
                    'blocks': $scope.blockname.toString(),
                    'block_id': $scope.block_id.toString(),
                    'sub_block_id': $scope.sub_block_id.toString(),
                    'subblocks': $scope.subblockname.toString(),
                })
            });
            $("#projectBody").hide();
            $scope.enquiryData.block_id = {};
            $scope.enquiryData.sub_block_id = {};
            $scope.enquiryData.project_id = "";
            $scope.editProBtnn = false;
            $scope.addProBtnn = true;
        }

        $scope.removeRow = function (rowId, enquiryDetailId, list, enquiry_id) {
            $scope.temp = [];
            if (enquiryDetailId !== '') {
                Data.post('master-sales/delEnquiryDetailRow', {
                    enquiryDetailId: enquiryDetailId, project_id: list.project_id, enquiry_id: enquiry_id
                }).then(function () {});
            }
            var index = -1;
            var comArr = eval($scope.projectsDetails);
            for (var i = 0; i < comArr.length; i++) {
                if (comArr[i].project_id != list.project_id) {
                    $scope.temp.push(comArr[i]);
                }
            }
            $scope.projectsDetails = $scope.temp;
        }

        $scope.editRow = function (list, index) {
            $scope.enquiryData.project_id = list.project_id + "_" + list.project_name;
            $scope.getBlockTypes(list.project_id, list.block_id);
            $timeout(function () {
                $scope.checkBlockLength(list.block_id, list.sub_block_id);
            }, 1600);
            $scope.index = index;
            $scope.addProBtnn = false;
            $scope.editProBtnn = true;
        }

        $scope.blockTypeList = [];
        $scope.subBlockList = [];

        $scope.getBlockTypes = function (projectId, blockId) {
            Data.post('master-sales/getBlockTypes', {projectId: projectId, blockId: blockId}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.blockTypeList = response.records;
                    $scope.enquiryData.block_id = response.records1;
                }
            });
        }

        $scope.checkBlockLength = function (blockId, subBlockId) {

            var blockTypeId = [];
            var projectId = $("#project_id").val().split('_')[0];
            angular.forEach(blockId, function (value, key) {
                blockTypeId.push(value.id);
            });

            var myJsonString = JSON.stringify(blockTypeId);
            if (blockId.length === 0) {
                $scope.emptyBlockId = true;
                $scope.applyClassBlock = 'ng-active';
                $scope.subBlockList = [];
            } else {
                $scope.emptyBlockId = false;
                $scope.applyClassBlock = 'ng-inactive';
                Data.post('master-sales/getSubBlocks/', {
                    data: {myJsonString, projectId: projectId, subBlockId: subBlockId, blockId: blockId}
                }).then(function (response) {
                    if (!response.success) {
                        $scope.errorMsg = response.message;
                    } else {
                        $scope.subBlockList = response.records;
                        $scope.enquiryData.sub_block_id = response.records1;
                    }
                });
            }
        };

        $scope.editproject_details = function (list) {
            $scope.enquiryData.project_id = angular.copy(list.project_id);
            $scope.enquiryData.block_id = angular.copy(list.block_id);
            $scope.enquiryData.sub_block_id = angular.copy(list.sub_block_id);
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
                 if (model.$isEmpty(modelValue))
                    return $q.when();
                else {
                    var mobileNumber = modelValue;
                    var customerId = ($scope.searchData.customerId) ? $scope.searchData.customerId : $scope.remarkData.customerId;
                    return Data.post('master-sales/checkMobileExist', {
                        data: {mobileNumber: mobileNumber, customerId: customerId},
                    }).then(function (response) {
                        $timeout(function () {
                            $scope.numNotExist = response.success;
                            model.$setValidity('uniqueMobile', !!response.success);
                            if($scope.remarkData.customerId != '')
                                $scope.remarkData.mobile_number = modelValue;
                            else
                                $scope.contacts.mobile_number = modelValue;
                        }, 100);
                    });
                }
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
                else {
                    //if(typeof modelValue !== 'undefined' || modelValue !== ''){
                    var emailid = modelValue;
                    var customerId = ($scope.searchData.customerId) ? $scope.searchData.customerId : $scope.remarkData.customerId;
                    return Data.post('master-sales/checkEmailExist', {
                        data: {emailid: emailid, customerId: customerId},
                    }).then(function (response) {
                        $timeout(function () {
                            $scope.emNotExist = response.success;
                            model.$setValidity('uniqueEmail', !!response.success);
                        }, 100);
                    });

                }
            };
        }
    }
});
app.filter('removeHTMLTags', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
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
app.filter('mobileHider', function () {
    return function (input) {
        if (input != '') {
            input = input.toString();
            var num = "xxxxxx" + (input.substring(input.length - 4, input.length));
            return num;
        } else {
            return '';
        }
    }
});