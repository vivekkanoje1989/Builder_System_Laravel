/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';
app.controller('customerController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse) {
    $scope.pageHeading = 'Create Customer';
    $scope.customerData = {};
    $scope.customerData.sms_privacy_status = 1;
    $scope.customerData.email_privacy_status = 1;
        
    $('[data-toggle="tooltip"]').tooltip();   
    $scope.checkImageExtension = function (customerPhoto) {
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
    };
      
    $scope.createCustomer = function (enteredData, customerPhoto) {
        console.log($scope.container);console.log(enteredData);
        var customerData = {};
        customerData = angular.fromJson(angular.toJson(enteredData));        
        customerPhoto.upload = Upload.upload({
                url: getUrl+'/master-sales',
                headers: {enctype: 'multipart/form-data'},
                data: {customerData: customerData, image_file: customerPhoto, customerContacts: $scope.container},
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
                    } else
                    {
                        $scope.disableCreateButton = true;
                        customerPhoto.result = response.data;
                        $rootScope.alert('success', "Employee registeration successfully.");
                        $('.alert-delay').delay(3000).fadeOut("slow");
                        $timeout(function () {
                            $state.go('admin.userIndex');
                        }, 1000);
                    }
                });
            }, function (response) {
                if (response.status !== 200) {console.log(response.status);
                    $scope.errorMsg = "Something went wrong. Check your internet connection";
                }
            }, function (evt, response) {});
    };
    
    $scope.addContactDetails = function () { 
        $scope.modal = {};
    }
    /*$scope.getCustomerDetails = function (customerData) {
        var customerData = $scope.customerData.searchWithMobile;
        customerData = (typeof $scope.customerData.searchWithMobile === 'undefined') ? $scope.customerData.searchWithEmail : $scope.customerData.searchWithMobile;   
        if(customerData !== undefined){alert("in if"+customerData);
            Data.post('master-sales/getCustomerDetails', {
                data: customerData
            }).then(function (response) {
                if (response.success) {
                    $rootScope.authenticated = false;
                    $state.go('login');
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        }
    }*/
    
}]);

