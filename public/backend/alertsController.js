'use strict';
app.controller('alertsController', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout', function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout) {
    $scope.pageHeading = 'Create User';
    $scope.buttonLabel = 'Create';
    $scope.alertData = {};
    $scope.listAlerts = [];
    $scope.Employees = [];
    $scope.alertData.gender = $scope.alertData.title = $scope.alertData.blood_group_id =
    $scope.alertData.physic_status_id = $scope.alertData.marital_status = $scope.alertData.highest_education_id =
    $scope.alertData.current_country_id = $scope.alertData.current_state_id = $scope.alertData.current_city_id =
    $scope.alertData.permenent_country_id = $scope.alertData.permenent_state_id = $scope.alertData.permenent_city_id = "";
    $scope.currentPage =  $scope.itemsPerPage = 4; 
    $scope.noOfRows = 1;
    
    $scope.checkDepartment = function () {
       if ($scope.alertData.department_id.length === 0) {
            $scope.emptyDepartmentId = true;
            $scope.applyClassDepartment = 'ng-active';
        } else {
            $scope.emptyDepartmentId = false;
            $scope.applyClassDepartment = 'ng-inactive';
         }
    }; 
    $scope.changeSmsStatus = function(val,index,id){
        Data.post('alerts/changeSmsStatus', {
            val: val,
            id: id
        }).then(function (response) {
            if (response.success) {
                var successMsg = response.successMsg;
                $scope.listAlerts[index].sms_status=val;
                $rootScope.alert('success', successMsg);
                $('.alert-delay').delay(3000).fadeOut("slow");
                $timeout(function () {
                    $state.go(getUrl+'.alertsIndex');
                }, 1000);
            } else {
                var errorMsg = response.errorMsg;
                $rootScope.alert('warning', successMsg);
                $('.alert-delay').delay(3000).fadeOut("slow");
                $timeout(function () {
                    $state.go(getUrl+'.alertsIndex');
                }, 1000);
            }
        });
    };
    $scope.changeTemplateStatus = function(val,index,id) {
       Data.post('alerts/changeTemplateStatus', {
            val: val,
            id: id
        }).then(function (response) {
            if (response.success) {
                var successMsg = response.successMsg;
                $scope.listAlerts[index].template_category = val;
                $rootScope.alert('success', successMsg);
                $('.alert-delay').delay(3000).fadeOut("slow");
                $timeout(function () {
                   
                }, 1000);
            } else {
                var errorMsg = response.errorMsg;
                $rootScope.alert('warning', errorMsg);
                $('.alert-delay').delay(3000).fadeOut("slow");
                $timeout(function () {
                   
                }, 1000);
            }
        });
    }
    $scope.changeSmsPrivacyStatus = function(val){
        $scope.alertData.sms_status=val;
    }

    $scope.changeEmailPrivacyStatus = function(val){
        $scope.alertData.email_status=val;
    }
    $scope.getTemplatesEvents = function(){
        Data.post('alerts/getTemplatesEvents').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.templateEvents = response.records;
            }
        });
    };
    $scope.getEmployees = function(){
        Data.post('alerts/getEmployees').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.Employees = response.records;
            }
        });
    };
    $scope.getEmailConfig = function (){
        Data.post('alerts/getEmailConfig').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.emailConfig = response.records;
            }
        });
    }; 
    $scope.changeEmailStatus = function(val,index,id){
        Data.post('alerts/changeEmailStatus', {
            val: val,
            id: id
        }).then(function (response) {
            if (response.success) {
                var successMsg = response.successMsg;
                $scope.listAlerts[index].email_status = val;
                $rootScope.alert('success', successMsg);
                $('.alert-delay').delay(3000).fadeOut("slow");
                $timeout(function () {
                    $state.go(getUrl+'.alertsIndex');
                }, 1000);
            } else {
                var errorMsg = response.errorMsg;
                $rootScope.alert('warning', successMsg);
                $('.alert-delay').delay(3000).fadeOut("slow");
                $timeout(function () {
                    $state.go(getUrl+'.alertsIndex');
                }, 1000);
            }
        });
    } 
    $scope.createAlert = function (enteredData, employeePhoto, alterId) {
        var alertData = {};        
        alertData = angular.fromJson(angular.toJson(enteredData));
        if(alterId === 0)
        {          
            
        }
        else{
            Data.post('alerts/updateAlerts', {
                alertData:alertData, id: alterId}).then(function (response) {
                console.log(response)
                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $rootScope.alert('success', response.message);
                    $('.alert-delay').delay(3000).fadeOut("slow");
                    $timeout(function(){
                        $state.go(getUrl+'.alertsIndex');
                    }, 1000);
                }
            });
        }
    };
    
    $scope.manageAlerts = function (id,action) { //edit/index action
        $scope.modal = {};
        Data.post('alerts/manageAlerts',{
            id: id,
        }).then(function (response) {
            if (response.success) {
                if(action === 'index'){
                    $scope.listAlerts = response.records.data;
                    $scope.listAlertsLength = response.records.total;
                }
                else if(action === 'edit'){
                    if(id !== '0'){
                        $scope.pageHeading = 'Edit Alert';
                        $scope.buttonLabel = 'Update';
                        $scope.alertData = angular.copy(response.records.data[0]);
                        $scope.alertData.email_cc_employees = []; 
                        $scope.alertData.sms_cc_employees = [];
                        var empId = response.records.data[0].email_cc_employees;
                        Data.post('alerts/getEmployeesToEdit', {
                            data: {empId: empId},
                            async:false,
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {
                                $scope.alertData.email_cc_employees = response.records; 
                            }
                        });
                        $scope.alertData.sms_cc_employees = [];
                        var empId = response.records.data[0].sms_cc_employees;
                        Data.post('alerts/getEmployeesToEdit', {
                            data: {empId: empId},
                            async:false,
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {
                                $scope.alertData.sms_cc_employees = response.records; 
                            }
                        });
                        $scope.alertData.email_bcc_employees = [];
                        var empId = response.records.data[0].email_bcc_employees;
                        Data.post('alerts/getEmployeesToEdit', {
                            data: {empId: empId},
                            async:false,
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {
                                $scope.alertData.email_bcc_employees = response.records; 
                            }
                        });
                    }
                }
                else{
                    $scope.modal.alterId = id;
                    $scope.modal.firstName = response.records.data[0].first_name;
                    $scope.modal.lastName = response.records.data[0].last_name;
                    $scope.modal.userName = response.records.data[0].username;
                }
            } else {
                $scope.errorMsg = response.message;
            }
        });
    };

    $scope.pageChangeHandler = function(num) {
        $scope.noOfRows = num;
        $scope.currentPage = num * $scope.itemsPerPage;
    };
    
}]);