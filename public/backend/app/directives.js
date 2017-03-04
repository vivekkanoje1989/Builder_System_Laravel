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
                    }, 1000);
                });
            };
        }
    }
});

app.directive('getCustomerDetails', function ($timeout, $q, Data) {
    function link($scope, element, attributes, model) {
        model.$asyncValidators.customerInputs = function () {
            var customerMobileNo = '';
            var customerEmailId ='';
            customerMobileNo = $scope.customerData.searchWithMobile;
            customerEmailId = $scope.customerData.searchWithEmail;
            if (model.$isEmpty(customerMobileNo) && model.$isEmpty(customerEmailId))
                return $q.when();
            return Data.post('master-sales/getCustomerDetails', {
                data: {customerMobileNo: customerMobileNo,customerEmailId: customerEmailId},
            }).then(function (response) {
                console.log(response);
                if(response.success){
                    $scope.showDiv=true;
                    $scope.customerData = angular.copy(response.customerPersonalDetails[0]);
                    $scope.contacts = angular.copy(response.customerContactDetails);
                    $scope.contactData = angular.copy(response.customerContactDetails);
                    $scope.customerData.searchWithMobile = customerMobileNo;
                    $scope.customerData.searchWithEmail =customerEmailId;
                }
                else{
                    $scope.showDiv=false;
                    $scope.customerData = '';
                    $scope.contactData.mobile_number_lable = $scope.contactData.landline_lable =
                    $scope.contactData.email_id_lable = $scope.contactData.address_type =
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
/*app.directive('getCustomerDetails', function ($timeout, $q, Data) {
   function link($scope, element, attributes, model) {
       model.$asyncValidators.customerInputs = function () {
           var customerMobileNo = '';
           var customerEmailId ='';
           customerMobileNo = $scope.customerData.searchWithMobile;
           customerEmailId = $scope.customerData.searchWithEmail;
           if (model.$isEmpty(customerMobileNo) && model.$isEmpty(customerEmailId))
               return $q.when();
           return Data.post('master-sales/getCustomerDetails', {
               data: {customerMobileNo: customerMobileNo,customerEmailId: customerEmailId},
           }).then(function (response) {
                console.log(response);
                if(response.records[0]['customer_id'] !== '0')
                { 
                    console.log(response.customerContactDetails);
                    $scope.showPersonalDetails=true;
                    $scope.customerData =angular.copy(response.customerPersonalDetails[0]);
                    $scope.container = angular.copy(response.customerContactDetails[0]);
                    $scope.customerData.searchWithMobile=response.records[0]['mobile_number'];
                    $scope.customerData.searchWithEmail=response.records[0]['email_id'];
                }
                else
                {
                    var mob= $scope.customerData.searchWithMobile;
                    var email=$scope.customerData.searchWithEmail;
                    $scope.customerData={};
                    $scope.contactData={};
                    $scope.showPersonalDetails=true;
                    $scope.customerData.searchWithMobile=mob;
                    $scope.customerData.searchWithEmail=email;
                }
                model.$setValidity('customerInputs', !!response.success);
           });
       };
   }
   return {
       restrict: 'A',
       require: 'ngModel',
       link: link
   }
});
*/
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



