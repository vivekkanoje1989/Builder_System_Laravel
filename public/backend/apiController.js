'use strict';
app.controller('apiController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', 'toaster', '$filter', '$stateParams', 'SweetAlert', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $window, toaster, $filter, $stateParams, SweetAlert) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.btnheading = 'Create';
        $scope.employees1 = [];
        $scope.pushApiData = {};
        $scope.manageApis = function () {
            Data.get('pushapi/listApis').then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.listApis = response.records;
                }
            });
        }

        $scope.updateApis = function (id) {
            if (!id) {
                $scope.pushApiData.first_name_mandatory = true;
                $scope.pushApiData.last_name_mandatory = true;
                $scope.pushApiData.mobile_number_mandatory = true;
                $scope.pushApiData.existing_open_customer_action = true;
                $scope.pushApiData.existing_lost_customer_action = true;
                $scope.pushApiData.send_sms_customer = true;
                $scope.pushApiData.send_email_customer = true;
                $scope.pushApiData.send_sms_employee = true;
                $scope.pushApiData.send_email_employee = true;
            } 
        }

        $scope.createApi = function (pushApiData) {

            Data.post('pushapi/createApi', {pushApiData: pushApiData}).then(function (response) {
                if (response.success) {
                    $state.go('apilist');
                    toaster.pop('success', 'Push Api', 'Api Created Successfully');
                }
            })
        };
        
        $scope.updateApi = function (pushApiData) {

            Data.post('pushapi/updateApi', {pushApiData: pushApiData}).then(function (response) {
                if (response.success) {
                    $state.go('apilist');
                    toaster.pop('success', 'Push Api', 'Api Updated Successfully');
                }
            })
        }

        $scope.getapiData = function (id) {
            
            $scope.employeeId = id;
            Data.post('pushapi/getapiData', {id: id}).then(function (response) {

                $scope.pushApiData = angular.copy(response.result);
                $scope.pushApiData.employee_id = [];
                $scope.pushApiData.first_name_mandatory = response.result.first_name_mandatory == '1' ? true : false;
                $scope.pushApiData.last_name_mandatory = response.result.last_name_mandatory == '1' ? true : false;
                $scope.pushApiData.mobile_number_mandatory = response.result.mobile_number_mandatory == '1' ? true : false;
                $scope.pushApiData.email_id_mandatory = response.result.email_id_mandatory == '1' ? true : false;

                $scope.pushApiData.send_sms_customer = response.result.send_sms_customer == '1' ? true : false;
                $scope.pushApiData.send_email_customer = response.result.send_email_customer == '1' ? true : false;
                $scope.pushApiData.send_sms_employee = response.result.send_sms_employee == '1' ? true : false;
                $scope.pushApiData.send_email_employee = response.result.send_email_employee == '1' ? true : false;
                $scope.pushApiData.dial_outbound_call = response.result.dial_outbound_call == '1' ? true : false;
                $scope.pushApiData.mobile_verification = response.result.mobile_verification == '1' ? true : false;
                $scope.pushApiData.email_verification = response.result.email_verification == '1' ? true : false;

                $scope.pushApiData.existing_open_customer_action = response.result.existing_open_customer_action == '1' ? true : false;
                $scope.pushApiData.existing_lost_customer_action = response.result.existing_lost_customer_action == '1' ? true : false;

                $scope.pushApiData.from_email_id = response.result.from_email_id;
                var employee = response.result.employee_id;
                Data.post('pushapi/getemployees', {
                    data: {employee: employee},
                    async: false,
                }).then(function (response) {
                    $scope.pushApiData.employee_id = response.records;
                });

                
                Data.post('pushapi/getEmployeesOther', {
                    data: {employee: employee},
                    async: false,
                }).then(function (response) {
                    if (!response.success) {
                        $scope.errorMsg = response.message;
                    } else {
                        $scope.employees1 = response.records;
                    }
                });



            })
        }

        $scope.defaultcustsmstemplate = function () {
            var smscustval = $('#customer_default_sms_template').text();
//            $('#customer_sms_template').val(smscustval);
            $scope.pushApiData.customer_sms_template = smscustval;
        }

        $scope.defaultempsmstemplate = function () {

            var smsemptval = $('#employee_default_sms_template').text();
//            $('#employee_sms_template').val(smsemptval);
            $scope.pushApiData.employee_sms_template = smsemptval;
        }

        $scope.customer_email_template = function () {
            var emailempval = $('#customer_email_template').text();
            $scope.pushApiData.customer_email_template = emailempval;
        }


        $scope.employee_email_template = function () {
            var emailcusttval = $('#employee_email_template').text();
            $scope.pushApiData.employee_email_template = emailcusttval;
        }

        $scope.getEmailConfiguration = function () {
            Data.get('pushapi/getEmailConfiguration').then(function (response) {
                $scope.salesstatus = response.result;
            })
        }



    }]);
