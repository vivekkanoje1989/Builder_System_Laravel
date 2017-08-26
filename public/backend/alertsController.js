'use strict';
app.controller('alertsController', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout', 'toaster',function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout,toaster) {
    $scope.pageHeading = 'Create User';
    $scope.buttonLabel = 'Create';
    $scope.alertData = {};
    $scope.listAlerts = [];
    $scope.Employees = [];
    $scope.alertData.gender = $scope.alertData.title = $scope.alertData.blood_group_id =
    $scope.alertData.physic_status_id = $scope.alertData.marital_status = $scope.alertData.highest_education_id =
    $scope.alertData.current_country_id = $scope.alertData.current_state_id = $scope.alertData.current_city_id =
    $scope.alertData.permenent_country_id = $scope.alertData.permenent_state_id = $scope.alertData.permenent_city_id = "";
    $scope.currentPage =  $scope.itemsPerPage = 30; 
    $scope.noOfRows = 1;
    $scope.custom_template_list=[];
    $scope.custom_template_id = {};
    $scope.custom_template_name = {};
    $scope.custom_template_disable = {};
    $scope.template_type_list={};
    $scope.template_email_status_list={};
    $scope.template_sms_status_list={};
    $scope.ddl_friendly_name_flag=0;
    
    $scope.pageNumber = 1;
    $scope.pageChanged = function (pageNo, functionName,id, type, pageNumber) { 
        $scope[functionName](id, type, pageNumber, $scope.itemsPerPage);
        $scope.pageNumber = pageNo;
    };
    
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
                $scope.template_sms_status_list[id]=val;
                toaster.pop('success', 'Template Settings', successMsg);               
            } else {
                var errorMsg = response.errorMsg;
                toaster.pop('error', 'Template Settings', errorMsg);
            }
        });
    };
    $scope.custom_template_dropdown_dispaly = function(id,val)
    {
        if(val==1)
        {
            $scope.custom_template_disable[id]=1;
            if($scope.custom_template_name[id] == undefined)
                $scope.template_type_list[id]=0;
            
        }  
        else
        { 
            $scope.custom_template_disable[id]=0;
            
        }
        
    }
    $scope.update_custome_template = function(index,id)
    {        
        $scope.custom_template_name[id] = $scope.custom_template_id[id].friendly_name;
        var custom_template_id = $scope.custom_template_id[id].id;
        $scope.custom_template_disable[id]=1;
        Data.post('alerts/changeTemplateStatus', {
            val: 1, id: id, custom_template_id : custom_template_id
        }).then(function (response) {
            if (response.success) {
                var successMsg = response.successMsg;
                $scope.listAlerts[index].template_type = 1;
                toaster.pop('success', 'Template Settings', successMsg);
                $timeout(function () {

                }, 1000);
            } else {
                var errorMsg = response.errorMsg;
                toaster.pop('error', 'Template Settings', errorMsg);
                $timeout(function () {

                }, 1000);
            }
        });        
    }
    $scope.changeTemplateStatus = function(val,index,id) {      
        if(val == 0)
        {    
            Data.post('alerts/changeTemplateStatus', {
                 val: val,
                 id: id,
                 custom_template_id:0
             }).then(function (response) {
                 if (response.success) {
                     var successMsg = response.successMsg;
                     $scope.custom_template_name[id] = null;
                     $scope.custom_template_disable[id]=0;
                     $scope.template_type_list[id] = val;
                     toaster.pop('success', 'Template Settings', successMsg);
                 } else {
                     var errorMsg = response.errorMsg;
                     toaster.pop('error', 'Template Settings', errorMsg);
                 }
             });
        }
        else
        {
            $scope.displayinit=false;
            if($scope.custom_template_name[id] == undefined)
                $scope.custom_template_disable[id]=0;
            else
                $scope.custom_template_disable[id]=1;
            
            $scope.template_type_list[id] = val;
            
        }    
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
                $scope.template_email_status_list[id] =val;
                toaster.pop('success', 'Template Settings', successMsg);
                
            } else {
                var errorMsg = response.errorMsg;
                toaster.pop('error', 'Template Settings', errorMsg);
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
                if (!response.success)
                {
                    toaster.pop('error', 'Template Settings', response.errorMsg);
                } else {
                    toaster.pop('success', 'Template Settings', response.successMsg);
                    $timeout(function(){
                        $state.go('alertsIndex');
                    }, 1000);
                }
            });
        }
    };
    
    $scope.manageAlerts = function (id,action, pageNumber= '', itemPerPage = '') { //edit/index action
        $scope.modal = {};
         $scope.showloader();
        Data.post('alerts/manageAlerts',{
            id: id, pageNumber: pageNumber, itemPerPage: itemPerPage,
        }).then(function (response) {
            if (response.success) {
                if(action === 'index'){
                    $scope.listAlerts = response.records.data;
                    $scope.listAlertsLength = response.records.total;
                    $scope.custom_template_list = response.records.customTemplates;
                    $scope.displayinit =true;
                      $scope.hideloader();
                }
                else if(action === 'edit'){
                      
                    if(id !== '0'){
                        $scope.pageHeading = 'Update Default Template';
                        $scope.buttonLabel = 'Update';
                        $scope.alertData = angular.copy(response.records.data[0]);
                        $scope.alertData.email_cc_employees = []; 
                        $scope.alertData.sms_cc_employees = [];
                        $scope.custom_template_list = response.records.customTemplates;
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
                 $scope.hideloader();
            } else {
                $scope.errorMsg = response.message;
            }
        });
    };

    $scope.pageChangeHandler = function(num) {
        $scope.noOfRows = num;
        $scope.currentPage = num * $scope.itemsPerPage;
    };
    
    /*update custom template*/
    
    $scope.updateCustomTemplate = function(alertData)
    {
        alertData.friendly_name = alertData.custom_template_id.friendly_name;     
        $scope.ddl_friendly_name_flag =0;
    }
    
    $scope.display_ddl_custom = function(val)
    {
        $scope.ddl_friendly_name_flag =val;
        
    }
    
    $scope.changeTemplateType = function(val,alertData){
        alertData.template_type=val;
        if(val==1)
        {    
            $scope.ddl_friendly_name_flag=1
        }
    }
            
            
            
    /*end*/        
    
    
}]);

app.filter('highlight', function() {
    
  function escapeRegexp(queryToEscape) {
      
    return queryToEscape.replace('/([.?*+^$[\]\\(){}|-])/g', '\\$1');
  }

  return function(obj, query) {
    return query && obj ? obj.toString().replace(new RegExp(escapeRegexp(query), 'gi'), '<span class="ui-select-highlight">$&</span>') : obj;
  };
});
