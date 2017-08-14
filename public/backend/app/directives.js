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
                if(val) {
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

app.directive('capitalizeFirst', function () {
    return {
        restrict: 'EA', //matches either element or attribute
        replace: true,
    }
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
                        if(response.success){
                           
                            $scope.fullName = response.message.fullName;
                            $scope.user_profile = response.photo;
                        }
                });
            };
        }
    }
});

app.directive('getCustomerDetailsDirective', function ($filter, $q, Data, $window, $location, $timeout) {
    function link($scope, element, attributes, model) {
        model.$asyncValidators.customerInputs = function () {
            var customerMobileNo = '';
            var customerEmailId = '';
            customerMobileNo = $scope.searchData.searchWithMobile;
            customerEmailId = $scope.searchData.searchWithEmail;            
            if (model.$isEmpty(customerMobileNo) && model.$isEmpty(customerEmailId))
                return $q.when();
            else{
                $scope.showloader();
                return Data.post('master-sales/getCustomerDetails', {
                    data: {customerMobileNo: customerMobileNo, customerEmailId: customerEmailId},
                }).then(function (response) {
                    if (response.success) { //response true
                        if (response.flag === 0)//if customer exist
                        {
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
                            $scope.customerData.marriage_date = $scope.customerData.birth_date = $filter('date')(new Date(), 'yyyy-MM-dd');
                            for (var i = 0; i < response.customerContactDetails.length; i++) {
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
                            $scope.searchData.searchWithMobile = customerMobileNo;
                            $scope.searchData.searchWithEmail = customerEmailId;
                            $scope.searchData.customerId = response.customerPersonalDetails[0].id;
                            $scope.hideloader();

                        } else{ //enquiry list of customer 
                            var url = $location.path();
                            if(url === "/sales/enquiry" || url === "/sales/quickEnquiry" ){
                                $scope.showDiv = true;
                                $scope.showDivCustomer = false;
                                $scope.backBtn = false;
                                $scope.listsIndex = response; 
                            }else{
                                $scope.disableText = true;
                                $scope.resetBtn = true;
                                $scope.backBtn = true;
                                $scope.disableSource = true;  
                            }
                            $scope.hideloader();
                        }
                    } else {//response false
                        $scope.locations = [];                         
                        $scope.showDiv = false;
                        $scope.showDivCustomer = true;
                        if ($scope.searchData.searchWithMobile === undefined) {
                            $scope.searchData.searchWithMobile = '';
                        }
                        $scope.searchData.customerId = '';
                        $scope.contacts = [{"mobile_number": '+91-' + $scope.searchData.searchWithMobile, "email_id_lable": 1, "email_id": $scope.searchData.searchWithEmail, "mobile_number_lable": 1, "landline_lable": 1, "landline_number": '+91-'}];
                        $window.sessionStorage.setItem("sessionContactData", JSON.stringify($scope.contacts));
                        $scope.customerData.title_id = $scope.customerData.first_name = $scope.customerData.middle_name =
                                $scope.customerData.last_name = $scope.customerData.birth_date =
                                $scope.customerData.marriage_date = $scope.customerData.monthly_income =
                                $scope.customerData.source_description = $scope.customerData.source_id = $scope.customerData.subsource_id =
                                $scope.contactData.house_number = $scope.contactData.building_house_name =
                                $scope.contactData.wing_name = $scope.contactData.area_name =
                                $scope.contactData.lane_name = $scope.contactData.landmark =
                                $scope.contactData.country_id = $scope.contactData.pin =
                                $scope.contactData.state_id = $scope.contactData.city_id =
                                $scope.contactData.google_map_link = $scope.contactData.other_remarks = '';
                        $scope.contactData.mobile_number = $scope.contactData.landline_number = '+91-';
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
                if(typeof personal_email1 == 'undefined'){
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
                if(ngModel.name === "importfile"){
                    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
                    var errmsg =  " is invalid file."
                }else{
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
                        $("#"+ngModel.name).val("");
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
                console.log($scope);
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
                    console.log(response);
                    $timeout(function () {
                        model.$setValidity('uniqueMobile', !!response.success);
                    }, 1000);

                });

            }
        }
    }
});