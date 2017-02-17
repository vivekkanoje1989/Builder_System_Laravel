/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';
app.controller('customerController', function ($rootScope, $scope, $location, $http, $state, Data) {
    
    $scope.customerData = {};
    
    $scope.getCustomerDetails = function (customerData) {
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
    
});

