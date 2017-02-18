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
                return modelValue == scope.otherModelValue;
            };
            scope.$watch("otherModelValue", function () {
                ngModel.$validate();
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
//            var deferred = $q.defer();
//            deferred.reject();
//            deferred.resolve();
            var customerMobileNo = '';
            var customerEmailId ='';
            customerMobileNo = $scope.customerData.searchWithMobile;
            customerEmailId = $scope.customerData.searchWithEmail;
            if (model.$isEmpty(customerMobileNo) && model.$isEmpty(customerEmailId))
                return $q.when();
            return Data.post('master-sales/getCustomerDetails', {
                data: {customerMobileNo: customerMobileNo,customerEmailId: customerEmailId},
            }).then(function (response) {
                $timeout(function () {
                    model.$setValidity('customerInputs', !!response.success);
                }, 1000);
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
        link: function ($scope, element, attributes, model) {
            model.$asyncValidators.uniqueEmail = function () {
                var email = $scope.userData.email;
                return Data.post('checkUniqueEmail', {
                    data: {emailData: email},
                }).then(function (response) {+
                    $timeout(function () {
                        model.$setValidity('uniqueEmail', !!response.success);
                    }, 1000);
                });
            };
        }
    }
});


//app.directive('uiSelectRequired', function() {
//  return {
//    require: 'ngModel',
//    link: function(scope, elm, attrs, ctrl, model) {
//      ctrl.$validators.uiSelectRequired = function(modelValue, viewValue) {
//        return modelValue && modelValue.length;
//      };
//    }
//  };
//});




