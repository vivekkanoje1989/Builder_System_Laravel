'use strict';
app.controller('apiController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', 'toaster', '$filter', '$stateParams', 'SweetAlert', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $window, toaster, $filter, $stateParams, SweetAlert) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.btnheading = 'Add';
        $scope.employees1 = [];
        $scope.pushApiData = {};
        $scope.employeesDatas = [];
        $scope.manageApis = function () {
            Data.get('pushapi/listApis').then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                     $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                } else {
                    $scope.listApis = response.records;
                    $scope.exportData = response.export;
                }
            });
        }

        $scope.searchDetails = {};
        $scope.searchData = {};
        $scope.filterDetails = function (search) {
            $scope.searchData = search;
            $('#showFilterModal').modal('hide');
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }

        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
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
        $scope.ApiExportToxls = function () {
            $scope.getexcel = window.location = "/pushapi/apiExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
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
console.log(response);
                $scope.pushApiData = angular.copy(response.result);
                $scope.pushApiData.employee_id = [];
                $scope.pushApiData.first_name_mandatory = response.result.first_name_mandatory == '1' ? true : false;
                $scope.pushApiData.last_name_mandatory = response.result.last_name_mandatory == '1' ? true : false;
                $scope.pushApiData.mobile_number_mandatory = response.result.mobile_number_mandatory == '1' ? true : false;
                $scope.pushApiData.email_id_mandatory = response.result.email_id_mandatory == '1' ? true : false;
                $scope.pushApiData.country_code_mandatory = response.result.country_code_mandatory == '1' ? true : false;
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
                        $scope.employeesDatas = response.records;
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

            $scope.pushApiData.customer_email_template = '<table dir="ltr" style="background-color: #ffffff; border: 1px solid #e9e9e9; border-bottom: none; border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; max-width: 600px; padding: 0; width: 600px;" align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">'

                    + '<tbody><tr>'
                    + '<td dir="ltr" style="background-color: #efefef; border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 15px 29px;" bgcolor="#f5f5f5" width="100%">'
                    + '<table dir="ltr" style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-weight: normal; margin: 0px; padding: 0px; width: 370px;" align="left" border="0" cellpadding="0" cellspacing="0">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 10px 0 0; font-size: 25px; color: #666;" align="left" width="100%">[#companyMarketingName#]</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '<table style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-weight: normal; margin: 0px; padding: 0px; width: 150px;" dir="ltr" align="left" border="0" cellpadding="0" cellspacing="0">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; color: #656565; font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; line-height: 18px; margin: 0; padding: 0;" dir="ltr" align="right" width="100%"><img src="[#companyLogo#]" style="display: block; max-width: 150px; height: auto; max-height: 80px;" border="0" class="CToWUd" /></td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '<table dir="ltr" style="background-color: #ffffff; border: 1px solid #e9e9e9; border-collapse: collapse; border-top: none; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; max-width: 600px; padding: 0; width: 600px;" align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">'
                    + '    <tbody>'
                    + '        <tr>'
                    + '            <td style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 15px 29px;" align="left" bgcolor="#f6f6f6" width="100%">'
                    + '                <table style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-weight: normal; margin: 0px; padding: 0px; width: 100%;" align="left" border="0" cellpadding="0" cellspacing="0">'
                    + '                    <tbody>'
                    + '                        <tr>'
                    + '                            <td style="border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 16px; font-weight: normal; line-height: 28px; margin: 0; padding: 0; text-align: left;" align="left" width="100%">Dear [#customerName#],</td>'
                    + '                        </tr>'
                    + '                        <tr>'
                    + '                            <td style="border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 13px; font-weight: normal; line-height: 18px; margin: 0; padding: 5px 0; text-align: left;" align="left" width="100%">Thanks a lot for expressing interest for below property in [#projectName#]</td>'
                    + '                        </tr>'
                    + '                        <tr>'
                    + '                            <td style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 15px 0 0;" align="left" width="100%">'
                    + '                                <table style="background-color: #ffffff; border: 1px solid #e9e9e9; border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; min-height: 110px; padding: 0; width: 260px;" align="left" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">'
                    + '                                    <tbody>'
                    + '                                        <tr>'
                    + '                                            <td style="border-bottom: 1px solid #e9e9e9; border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: bold; line-height: 16px; margin: 0; padding: 8px 10px; text-align: center;" align="center" width="100%" height="30">CONTACT DETAILS</td>'
                    + '                                        </tr>'
                    + '                                        <tr>'
                    + '                                            <td style="border-bottom: 1px solid #e9e9e9; border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 11px; font-weight: normal; line-height: 15px; margin: 0; padding: 18px 5px; text-align: center;" align="center" width="100%" height="40">[#employeeName#]<br /><a style="color: #1155cc; font-size: 13px; font-weight: bold; text-decoration: none; white-space: nowrap;">[#employeeEmail#]</a><br /><b> &nbsp;</b>[#employeeMobile#]</td>'
                    + '                                        </tr>'
                    + '                                    </tbody>'
                    + '                                </table>'
                    + '                                <table style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-weight: normal; margin: 0px; padding: 0px; width: 16px;" align="left" border="0" cellpadding="0" cellspacing="0">'
                    + '                                    <tbody>'
                    + '                                        <tr>'
                    + '                                            <td style="background-color: #f6f6f6; border: none; border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 0;" bgcolor="#f6f6f6" width="16">&nbsp;</td>'
                    + '                                        </tr>'
                    + '                                    </tbody>'
                    + '                                </table>'
                    + '                                <table style="background-color: #ffffff; border: 1px solid #e9e9e9; border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; min-height: 110px; padding: 0; width: 260px;" align="left" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">'
                    + '                                    <tbody>'
                    + '<tr>'
                    + '<td style="border-bottom: 1px solid #e9e9e9; border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: bold; line-height: 16px; margin: 0; padding: 8px 10px; text-align: center; text-transform: uppercase;" align="center" width="100%" height="30">[#projectName#]</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td style="border-bottom: 1px solid #e9e9e9; border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 11px; font-weight: normal; line-height: 15px; margin: 0; padding: 18px 5px; text-align: center;" align="center" width="100%" height="40"><a href="[#projectBroucher#]" target="_blank" style="color: #1155cc; font-size: 13px; font-weight: bold; text-decoration: none; white-space: nowrap;">Download Brochure</a><br />[#projectBlockType#]</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 15px 0 0;" align="left" width="100%">'
                    + '<table style="background-color: #ffffff; border: 1px solid #e9e9e9; border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-weight: normal; margin: 0px; min-height: 200px; padding: 0px; width: 260px; height: 180px;" align="left" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td style="border-bottom: 1px solid #e9e9e9; border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: bold; line-height: 16px; margin: 0; padding: 8px 10px; text-align: center;" align="center" width="100%">PROJECT ADDRESS</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: bold; margin: 0; padding: 17px 0 0; text-align: center;" align="center" width="100%">[#projectAddress#]</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 0 15px;" align="left" width="100%">'
                    + '<table style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-weight: normal; margin: 0px; padding: 0px; width: 100%;" align="center" border="0" cellpadding="0" cellspacing="0">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; border-top: 1px solid #e9e9e9; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 15px 0 0;" width="100%"></td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; line-height: 18px; margin: 0; padding: 0 0 15px; text-align: center;" align="center" width="100%">[#projectShortDesc#]</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '<table style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-weight: normal; margin: 0px; min-height: 200px; padding: 0px; width: 270px; height: 180px;" align="right" border="0" cellpadding="0" cellspacing="0">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-size: 0; font-weight: normal; line-height: 0; margin: 0; padding: 0;" valign="top">'
                    + '<table style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-weight: normal; margin: 0px; padding: 0px; width: 10px;" align="left" border="0" cellpadding="0" cellspacing="0">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-size: 0; font-weight: normal; line-height: 0; margin: 0; padding: 0;" height="78">&nbsp;</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 0;" align="right" width="10"><img src="https://ci5.googleusercontent.com/proxy/nW6xusTqNw1ulXhAkvSFEs3LzjGR29c4HbBWoiHA9oqDOZlbcLAAl8y6_P1mZedmr9EVFYHX7Pn551J0Y4IrWy1aroxGQlJ7nmzzvuwkI8lWVGE=s0-d-e1-ft#https://www.gstatic.com/gmktg/mtv-img/cpr_todo_arrow_left.png" alt="arrow" title="arrow" style="display: block; max-width: 10px;" border="0" width="10" class="CToWUd" /></td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '<td style="background-color: #ddd; border-collapse: collapse; color: #ffffff; font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; line-height: 18px; margin: 0; min-height: 0; padding: 20px;" align="left" bgcolor="#4385f5" width="255"><img src="[#projectLogo#]" style="width: 100%; max-height: 215px; height: auto;" /></td>'
                    + '<td style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-size: 0; font-weight: normal; line-height: 0; margin: 0; padding: 0;" width="5">&nbsp;</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td style="background-color: #f6f6f6; border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 15px 29px;" align="left" bgcolor="#f6f6f6" width="100%">'
                    + '<table style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-weight: normal; margin: 0px; padding: 0px; width: 100%;" align="left" border="0" cellpadding="0" cellspacing="0">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 13px; font-weight: normal; line-height: 18px; margin: 0; padding: 5px 0;" align="left" width="50%"><a href="[#projectLink#]" style="color: #1155cc; text-decoration: none;" target="_blank">More Details : Click Here</a></td>'
                    + '<td style="border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 13px; font-weight: normal; line-height: 18px; margin: 0; padding: 5px 0;" align="right" width="50%"><a href="[#projectGoogleMap#]" style="color: #1155cc; text-decoration: none;" target="_blank">Google Map : Click Here</a></td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td style="background-color: #ffffff; border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-weight: normal; margin: 0; padding: 15px 29px;" align="left" bgcolor="#ffffff" width="100%">'
                    + '<table style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif; font-weight: normal; margin: 0px; padding: 0px; width: 100%;" align="left" border="0" cellpadding="0" cellspacing="0">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 17px; text-align: center; font-weight: normal; line-height: 28px; margin: 0; padding: 0;" align="left" width="100%">Our Address</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td style="border-collapse: collapse; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 13px; font-weight: normal; line-height: 18px; margin: 0; padding: 5px 0;" align="left" width="100%">[#companyAddress#]</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>';
        }


        $scope.employee_email_template = function () {

            $scope.pushApiData.employee_email_template = '<p><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />'
                    + '<title></title>'
                    + '</p>'
                    + '<table bgcolor="#f6f4f5" align="center" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="preheader" style="padding: 20px; width: 400px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td>'
                    + '<table style="border: 3px solid #999; padding: 5px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td width="100%">'
                    + '<table align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" style="background: #dddcdd; width: 400px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td width="400">'
                    + '<table align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="width: 400px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td width="160" st-title="fulltext-title" style="border: none;"><img src="[#companyLogo#]" style="float: left; margin-left: 10px; max-width: 160px; padding: 10px 0; max-height: 75px;" /></td>'
                    + '<td width="10" style="border: none;">&nbsp;</td>'
                    + '<td width="230" style="border: none; font-family: Helvetica, arial, sans-serif; font-size: 23px; color: #000; text-align: left; line-height: 20px; font-weight: bold; padding-bottom: 5px;">'
                    + '<p style="float: left;">[#companyMarketingName#]</p>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td width="100%">'
                    + '<table bgcolor="#fff" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit" style="border-top: 0px; width: 400px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td width="400">'
                    + '<table align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="width: 400px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td width="400">'
                    + '<table cellpadding="5" cellspacing="0" border="0" align="center" class="devicewidth" style="width: 400px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td width="400" style="font-family: Helvetica, arial, sans-serif; font-size: 20px; color: #000; text-align: center; line-height: 20px; font-weight: bold; padding-bottom: 5px;" st-title="fulltext-title">'
                    + '<p style="margin: 10px 0; padding-left: 5px; font-size: 18px;">New enquiry for [#projectName#] from [#enquirySource#]</p>'
                    + '</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td width="400" align="left" valign="middle" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #000;" st-content="preheader">&nbsp;Dear <span><b> [#employeeName#],</b>&nbsp;</span>'
                    + '<p style="margin-left: 5px; margin-top: 15px; font-size: 15px;">We have received an enquiry from [#enquirySource#], Please go through the below details for necessary action.<br /> Customer Name: [#customerName#],<br /> Contact number: [#customerMob1#], <br /> Email : [#customerEmail1#], <br /> Project details: [#projectName#] , <br /> Block Type [#projectBlockType#].<br /><br /> Please get back &amp; update the followup in BMS system.</p>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td width="400">'
                    + '<table align="left" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="width: 400px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td>'
                    + '<table cellpadding="0" cellspacing="0" border="0" align="left" class="devicewidth" style="width: 100%;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td valign="middle" align="left" width="100%" style="font-family: Helvetica, Arial, sans-serif; font-size: 15px; padding: 10px; color: #000;" class="logo">'
                    + '<div>'
                    + '<p>Regards,<br /> [#companyMarketingName#]</p>'
                    + '</div>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td width="100%">'
                    + '<table align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" style="background: #ffffff; width: 400px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td width="100%" height="10"></td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td width="400">'
                    + '<table align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="width: 400px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td><img src="[#dividerLogo#]" /></td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '<tr>'
                    + '<td width="100%">'
                    + '<table align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" style="padding: 5px; width: 400px;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td width="400" style="background: #dddcdd;">'
                    + '<table align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidth" style="width: 100%;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td>'
                    + '<table align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner" style="table-layout: fixed; width: 100%;">'
                    + '<tbody>'
                    + '<tr>'
                    + '<td width="170" style="border: none;">'
                    + '<p style="color: #000; font-weight: 600; margin: 0;"><a href="http://edynamics.co.in/" target="_blank"> <img src="../../common/images/edynamicstemplatelogo.jpg" style="margin: 5px; width: 25px;" /> </a></p>'
                    + '</td>'
                    + '<td style="text-align: right; border: none;" width="230" st-title="3col-title3"><span style="float: left; margin-top: 10px; color: #000;">Sent using BMS system &nbsp;</span> <a href="http://edynamics.co.in/" target="_blank"><img src="[#bmsLogo#]" alt="BMS" width="auto" height="30" style="color: #fff; margin-top: 5px;" /></a></td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>'
                    + '</td>'
                    + '</tr>'
                    + '</tbody>'
                    + '</table>';

        }

        $scope.getEmailConfiguration = function () {
            Data.get('pushapi/getEmailConfiguration').then(function (response) {
                $scope.salesstatus = response.result;
            })
        }



    }]);
