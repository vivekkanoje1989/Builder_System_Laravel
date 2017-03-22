/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
                if((typeof modelValue !== 'undefined') && modelValue !== ''){
                    return modelValue == scope.otherModelValue;
                }
                
            };
            scope.$watch("otherModelValue", function (modelValue) {
                if((typeof modelValue !== 'undefined') && modelValue !== ''){
                    ngModel.$validate();
                }
            });
        }
    };
};
app.directive("compareTo", compareTo);

app.directive('checkLoginCredentials', function ($timeout, $q, Data) {
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
                }).then(function (response) {+
                    $timeout(function () {
                        model.$setValidity('wrongCredentials', !!response.success);
                        $scope.errMsg = response.message;
                    }, 200);
                });
            };
        }
    }
});

app.directive('getCustomerDetailsDirective', function ($filter, $q, Data, $window) {
    function link($scope, element, attributes, model) {
        model.$asyncValidators.customerInputs = function () {
            var customerMobileNo = '';
            var customerEmailId ='';
            customerMobileNo = $scope.searchData.searchWithMobile;
            customerEmailId = $scope.searchData.searchWithEmail;
            if (model.$isEmpty(customerMobileNo) && model.$isEmpty(customerEmailId))
                return $q.when();
            return Data.post('master-sales/getCustomerDetails', {
                data: {customerMobileNo: customerMobileNo,customerEmailId: customerEmailId},
            }).then(function (response) {
                if(response.success){
                    $scope.showDiv=true;
                    $scope.customerData = angular.copy(response.customerPersonalDetails[0]);
                    $scope.contacts = angular.copy(response.customerContactDetails);
                    $scope.contactData = angular.copy(response.customerContactDetails);                    
                    $scope.customerData.marriage_date = $scope.customerData.birth_date = $filter('date')(new Date(),'yyyy-MM-dd');
                    for(var i=0; i < response.customerContactDetails.length; i++){
                        if(response.customerContactDetails[i].mobile_calling_code === parseInt(0) || response.customerContactDetails[i].mobile_calling_code === ''){
                            $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = "+91-";
                        }else{
                            $scope.contacts[i].mobile_number = $scope.contactData[i].mobile_number = '+' + parseInt(response.customerContactDetails[i].mobile_calling_code) + '-' + parseInt(response.customerContactDetails[i].mobile_number);}
                        if(response.customerContactDetails[i].landline_calling_code === parseInt(0) || response.customerContactDetails[i].landline_calling_code === '' || response.customerContactDetails[i].landline_calling_code === NULL){ 
                            $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = '+91-';
                        }else{
                            $scope.contacts[i].landline_number = $scope.contactData[i].landline_number = '+' + parseInt(response.customerContactDetails[i].landline_calling_code) + '-' + parseInt(response.customerContactDetails[i].landline_number);
                        }
                        if(response.customerContactDetails[i].pin === 0)
                            $scope.contacts[i].pin = $scope.contactData[i].landline_number = '';
                    }
                    $window.sessionStorage.setItem("sessionContactData", JSON.stringify(angular.copy(response.customerContactDetails)));
                    $scope.searchData.searchWithMobile = customerMobileNo;
                    $scope.searchData.searchWithEmail = customerEmailId;
                    $scope.searchData.customerId = response.customerPersonalDetails[0].id;
                    $scope.disableText = true; 
                }
                else{
                    $scope.showDiv=true;
                    if($scope.searchData.searchWithMobile === undefined){
                        $scope.searchData.searchWithMobile = '';
                    }
                    $scope.searchData.customerId = '';
                    $scope.contacts = [{"mobile_number": '+91-' + $scope.searchData.searchWithMobile,"email_id_lable": 1, "email_id":$scope.searchData.searchWithEmail, "mobile_number_lable": 1, "landline_lable": 1, "landline_number": '+91-'}];
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
                }
            });
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
        link: function($scope, element, attributes, model) {
            model.$asyncValidators.uniqueEmail = function() {               
                var email = $scope.userData.email;
                var employeeId = (typeof $scope.userData.id === "undefined" || $scope.userData.id === "0") ? "0" : $scope.userData.id;        
                return Data.post('checkUniqueEmail',{
                    data:{emailData: email,id:employeeId},
                }).then(function(response){
                  $timeout(function(){
                    model.$setValidity('uniqueEmail', !!response.success); 
                  }, 1000);              
                });                           
            };
        }
    } 
});

app.directive('intlTel', function(){
  return{
    replace:true,
    restrict: 'AE',
    require: 'ngModel',
    link: function(scope,element,attrs,ngModel){
        element.intlTelInput({
          dropdownContainer: 'body',
          scrollListener: '.form-control',
        });
    }
  }
});



