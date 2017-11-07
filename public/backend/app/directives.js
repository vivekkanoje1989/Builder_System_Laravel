/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

app.directive('ngLoading', function ($compile) {

    var loadingSpinner = "<div class='sk-cube-grid'><div class='></div></div>";

    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var originalContent = element.html();
            element.html(loadingSpinner);
            scope.$watch(attrs.ngLoading, function (val) {
                if (val) {
                    element.html(originalContent);
                    $compile(element.contents())(scope);
                } else {
                    element.html(loadingSpinner);
                }
            });
        }
    }
});
app.directive('resetOnClick', function () {
    return {
        link: function (scope, elt, attrs) {
            scope.reset = function () {
                elt.html('');
            };
        }
    }
});

app.directive('focusMe', ['$timeout', function ($timeout) {
        return {
            link: function (scope, element, attrs) {
                if (attrs.focusMeDisable === "true") {
                    return;
                }
                $timeout(function () {
                    element[0].focus();
//                    if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard) {
//                        cordova.plugins.Keyboard.show(); //open keyboard manually
//                    }
                }, 350);
            }
        };
    }]);


app.directive('capitalization', function (uppercaseFilter, $parse) {
    return {
        require: 'ngModel',
        link: function ($scope, $element, $attrs, $modelCtrl) {

            var capitalize = function (inputValue) {
                if (!!inputValue) {
                    var capitalized = angular.uppercase(inputValue.substring(0, 1)) + inputValue.substring(1);
                    if (capitalized !== inputValue) {
                        $modelCtrl.$setViewValue(capitalized);
                        $modelCtrl.$render();
                    }
                    return capitalized;
                }
                return inputValue;
            };
            $modelCtrl.$parsers.push(capitalize);
            capitalize($scope[$attrs.ngModel]); // capitalize initial value
        }
    };
});

var compareTo = function () {
    return {
        require: "ngModel",
        scope: {
            otherModelValue: "=compareTo"
        },
        link: function (scope, element, attributes, ngModel) {
            ngModel.$validators.compareTo = function (modelValue) {
                if ((typeof modelValue !== 'undefined') && modelValue !== '') {
                    return modelValue == scope.otherModelValue;
                }

            };
            scope.$watch("otherModelValue", function (modelValue) {
                if ((typeof modelValue !== 'undefined') && modelValue !== '') {
                    ngModel.$validate();
                }
            });
        }
    };
};
app.directive("compareTo", compareTo);

app.directive('checkLoginCredentials', function ($timeout, $q, Data, $http) {
    return {
        restrict: 'AE',
        require: 'ngModel',
        link: function ($scope, element, attributes, model) {
            model.$asyncValidators.wrongCredentials = function () {
                var mobile = $scope.loginData.mobile;
                var password = (typeof $scope.loginData.password === 'undefined') ? "" : $scope.loginData.password;
                var securityPassword = (typeof $scope.loginData.securityPassword === 'undefined') ? "" : $scope.loginData.securityPassword;
                return Data.post('checkUserCredentials', {
                    data: {mobileData: mobile, passwordData: password, securityPasswordData: securityPassword},
                }).then(function (response) {
                    +
                            $timeout(function () {
                                model.$setValidity('wrongCredentials', !!response.success);
                                $scope.errMsg = response.message;
                            }, 200);
                    if (response.success) {

                        $scope.fullName = response.message.fullName;
                        $scope.user_profile = response.photo;
                    }
                });
            };
        }
    }
});

app.directive('getCustomerDetailsDirective', function ($filter, $q, Data, $window, $location, $timeout, $rootScope) {
    function link($scope, element, attributes, model) {
        model.$asyncValidators.customerInputs = function () {
            var customerMobileNo = '';
            var customerEmailId = '';
            customerMobileNo = $scope.searchData.searchWithMobile;
            customerEmailId = $scope.searchData.searchWithEmail;
            if (model.$isEmpty(customerMobileNo) && model.$isEmpty(customerEmailId))
                return $q.when();
            else {
                //$scope.showloader();
                return Data.post('master-sales/getCustomerDetails', {
                    data: {customerMobileNo: customerMobileNo, customerEmailId: customerEmailId},
                }).then(function (response) {  
                    if (response.success) { //response true
                        if (response.flag === 0)//if customer exist
                        {
                            $scope.company_list = [];
                            var result = '';
                            $scope.showDiv = false;
                            $scope.showDivCustomer = true;
                            $scope.btnLabelC = "Update";
                            $scope.disableSource = true;
                            $scope.customerData = angular.copy(response.customerPersonalDetails[0]);
                            $scope.customer_id = response.customerPersonalDetails[0].id;
                            $scope.contacts = angular.copy(response.customerContactDetails);
                            $scope.contactData = angular.copy(response.customerContactDetails);
                            $scope.enquiryData.first_name = angular.copy(response.customerPersonalDetails[0].first_name);
                            $scope.enquiryData.last_name = angular.copy(response.customerPersonalDetails[0].last_name);
                            $scope.enquiryData.title_id = angular.copy(response.customerPersonalDetails[0].title_id);

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
                                    $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = '';
                                    $scope.contacts[i].landline_calling_code = $scope.contactData[i].landline_calling_code = '';
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
                            $scope.searchData.searchWithMobile = customerMobileNo;
                            $scope.searchData.searchWithEmail = customerEmailId;
                            $scope.searchData.customerId = response.customerPersonalDetails[0].id;
                            $timeout(function () {
                                $scope.customerData.gender_id = angular.copy(response.customerPersonalDetails[0].gender_id);
                                $("#gender_id").val(response.customerPersonalDetails[0].gender_id);
                                $scope.customerData.profession_id = angular.copy(response.customerPersonalDetails[0].profession_id);
                                $("#profession_id").val(response.customerPersonalDetails[0].profession_id);

                                if (response.customerPersonalDetails[0].corporate_customer == '1') {
                                    $scope.customerData.corporate_customer = true;
                                    if (response.customerPersonalDetails[0].company_id != '') {
                                        $scope.companyInput = true;
                                        Data.get('getCompanyList').then(function (response) {
                                            if (!response.success) {
                                                $scope.company_list = [];
                                                $scope.errorMsg = response.message;
                                            } else {
                                                $scope.company_list = response.records;
                                                result = $.grep($scope.company_list, function (e) {
                                                    return e.id == 2;
                                                });
                                                $scope.customerData.company_name = result['0']['company_name'];
                                            }
                                        });
                                    }
                                } else {
                                    $scope.customerData.corporate_customer = false;
                                }
                                $scope.customerData.company_id = response.customerPersonalDetails[0].company_id;

                            }, 200);
                            $scope.hideloader();
                        } else { //enquiry list of customer 

                            var url = $location.path();
                            if (url === "/sales/enquiry" || url === "/sales/quickEnquiry") {
                                $scope.showDiv = true;
                                $scope.showDivCustomer = false;
                                $scope.backBtn = false;
                                $scope.listsIndex = response;
                            } else {
                                $rootScope.newEnqFlag = 0; //update existing data
                                $scope.disableText = true;
                                $scope.resetBtn = true;
                                $scope.backBtn = true;
                                $scope.disableSource = true;
                                return false;
                            }
                            $scope.hideloader();
                        }
                    } else {//response false                        
                        $scope.locations = [];
                        $scope.showDiv = false;
                        $scope.showDivCustomer = true;
                        $rootScope.newEnqFlag = 1;
                        if ($scope.searchData.searchWithMobile === undefined) {
                            $scope.searchData.searchWithMobile = '';
                        }
                        $scope.searchData.customerId = '';
                        $scope.contacts = [{"mobile_calling_code": "+91", "mobile_number": $scope.searchData.searchWithMobile, "email_id_lable": 1, "email_id": $scope.searchData.searchWithEmail, "mobile_number_lable": 1, "landline_lable": 1, "landline_number": ''}];
                        $window.sessionStorage.setItem("sessionContactData", JSON.stringify($scope.contacts));
                        $scope.customerData.title_id = $scope.customerData.first_name = $scope.customerData.middle_name =
                                $scope.customerData.last_name = 
                                $scope.customerData.marriage_date = $scope.customerData.monthly_income =
                                $scope.customerData.source_description = $scope.customerData.source_id = $scope.customerData.subsource_id =
                                $scope.contactData.house_number = $scope.contactData.building_house_name =
                                $scope.contactData.wing_name = $scope.contactData.area_name =
                                $scope.contactData.lane_name = $scope.contactData.landmark =
                                $scope.contactData.country_id = $scope.contactData.pin =
                                $scope.contactData.state_id = $scope.contactData.city_id =
                                $scope.contactData.google_map_link = $scope.contactData.other_remarks = '';
                                var date = new Date($scope.customerData.birth_date);
                                $scope.customerData.birth_date = ((date.getFullYear() - 100) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
                                $scope.customerData.birth_date = "1990-01-01";
                        $scope.hideloader();
                    }
                });
            }
        };
    }
    return {
        restrict: 'A',
        require: 'ngModel',
        link: link
    }
});
app.directive('checkUniqueEmail', function ($timeout, $q, Data) {
    return {
        restrict: 'AE',
        require: 'ngModel',
        link: function ($scope, element, attributes, model) {
            model.$asyncValidators.uniqueEmail = function () {
                var personal_email1 = $scope.userData.personal_email1;
                if (typeof personal_email1 == 'undefined') {
                    var personal_email1 = $("#personal_email1").val();
                }
                var employeeId = (typeof $scope.userData.id === "undefined" || $scope.userData.id === "0") ? "0" : $scope.userData.id;
                return Data.post('checkUniqueEmail', {
                    data: {emailData: personal_email1, id: employeeId},
                }).then(function (response) {
                    $timeout(function () {
                        model.$setValidity('uniqueEmail', !!response.success);
                    }, 1000);
                });
            };
        }
    }
});


app.directive('ngConfirmClick', [
    function () {
        return {
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.confirmedClick;
                element.bind('click', function (event) {
                    if (window.confirm(msg)) {
                        scope.$eval(clickAction)
                    }
                });
            }
        };
    }])


app.directive('intlTel', function () {
    return{
        replace: true,
        restrict: 'AE',
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            element.intlTelInput({
                dropdownContainer: 'body',
                scrollListener: '.form-control',
            });
        }
    }
});

app.directive("ngfSelect", [function () {
        return {
            restrict: 'AE',
            require: 'ngModel',
            link: function ($scope, el, ngModel) {

                el.bind("change", function (e) {
                    if (ngModel.name === "importfile") {
                        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
                        var errmsg = " is invalid file."
                    } else if (ngModel.name === "welcome_tune_audio" || ngModel.name === "hold_tune_audio") {
                        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.mp3)$/;
                        var errmsg = " is invalid file."
                    } else if (ngModel.name === "project_brochure") {
                        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.pdf)$/;
                        var errmsg = " is invalid file. Please upload pdf file only."
                    } else {
                        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp|.svg|.xls)$/;
                        var errmsg = " is not a valid image file."
                    }
                    $scope[ngModel.name + "_preview"] = [];
                    var fileLength = $($(this)[0].files).length;
                    $($(this)[0].files).each(function () {
                        $scope[ngModel.name + "_err"] = "";
                        var file = $(this);
                        var imgName = file[0].name;
                        if (regex.test(file[0].name.toLowerCase())) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $scope[ngModel.name + "_avtar"] = true;
                                $scope[ngModel.name + "_preview"].push(e.target.result);
                            }
                            reader.readAsDataURL(file[0]);
                        } else {
                            $scope[ngModel.name + "_err"] = imgName + errmsg;
                            $scope[ngModel.name + "_preview"] = "";
                            $("#" + ngModel.name).val("");
                            return false;
                        }
                    });
                })
            }
        }
    }]);

app.directive('checkOldPassword', function ($timeout, $q, Data) {
    return {
        restrict: 'AE',
        require: 'ngModel',
        link: function ($scope, element, attributes, model) {
            model.$asyncValidators.checkOldPassword = function () {
                var old_password = $scope.profileData.oldPassword;
                return Data.post('checkOldPassword', {
                    data: {old_password: old_password},
                }).then(function (response) {
                    $timeout(function () {
                        model.$setValidity('compareOldPassword', !!response.success);
                    }, 1000);
                });
            };
        }
    }
});

app.directive('checkUniqueMobile', function ($timeout, $q, Data) {
    return {
        restrict: 'AE',
        require: 'ngModel',
        link: function ($scope, element, attributes, model) {
            model.$asyncValidators.uniqueMobile = function () {
                var personal_mobile1 = $scope.userData.personal_mobile1;
                var employeeId = (typeof $scope.userData.id === "undefined" || $scope.userData.id === "0") ? "0" : $scope.userData.id;
                return Data.post('checkUniqueMobile', {
                    data: {mobileData: personal_mobile1, id: employeeId},
                }).then(function (response) {
                    $timeout(function () {
                        model.$setValidity('uniqueMobile', !!response.success);
                    }, 1000);
                });
            };
        }
    }
});

//app.directive('checkUniqueMobiles', function ($timeout, $q, Data) {
//    return {
//        restrict: 'AE',
//        require: 'ngModel',
//        link: function ($scope, element, attributes, model) {
//            model.$asyncValidators.uniqueMobile = function () {
//                var defer = $q.defer()
//                var personal_mobile1 = $scope.userData.personal_mobile1
//           
//                var emp_id = $("#employeeId").val();
//                var employeeId = (typeof emp_id === "undefined" || emp_id === "0") ? "0" : emp_id
//           
//                return Data.post('checkUniqueMobile1', {
//                    data: {mobileData: personal_mobile1, id: employeeId},
//                }).then(function (response) {
//                    $timeout(function () {
//                        model.$setValidity('uniqueMobile', !!response.success);
//                    }, 1000);
//
//                });
//
//            }
//        }
//    }
//});


app.directive('checkUniqueMobiles', function ($timeout, $q, Data) {

    return {
        restrict: 'AE',
        require: 'ngModel',
        link: function ($scope, element, attributes, model) {
            model.$asyncValidators.uniqueMobile = function () {
                var defer = $q.defer()
                var personal_mobile1 = $scope.userContact.personal_mobile1

                var emp_id = $("#employeeId").val();
                var employeeId = (typeof emp_id === "undefined" || emp_id === "0") ? "0" : emp_id

                return Data.post('checkUniqueMobile1', {
                    data: {mobileData: personal_mobile1, id: employeeId},
                }).then(function (response) {
                    $timeout(function () {
                        model.$setValidity('uniqueMobile', !!response.success);
                    }, 1000);

                });

            }
        }
    }
});