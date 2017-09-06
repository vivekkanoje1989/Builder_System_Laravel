'use strict';
app.controller('outboundCallController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', 'toaster', '$filter', '$stateParams', 'SweetAlert', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $window, toaster, $filter, $stateParams, SweetAlert) {
      
        $scope.cloudCallingLog = function (modules, employee_id, enquire_id, customer_id, sequence) {
            Data.post('cloudcallinglogs/outboundCalltrigger', {
                modules: modules, employee_id: employee_id, enquire_id: enquire_id, customer_id: customer_id, sequence: sequence
            }).then(function (response) {
                var successMsg = response.message;
                toaster.pop('success', 'Call Status', successMsg);
            });
        }
}]);
