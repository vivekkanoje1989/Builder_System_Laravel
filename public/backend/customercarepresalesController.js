'use strict';
app.controller('customercarepresalesController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', 'toaster', '$filter', '$stateParams','SweetAlert', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $window, toaster, $filter, $stateParams,SweetAlert) {
    $scope.enquiriesLength;
    $scope.pageNumber = 1;
    $scope.flagForPage = 0;
    $scope.enquiries = {};
    $scope.btnExport = true;
    $scope.filter = {};
    $scope.showfilterData = {};
    $scope.getProcName;
    $scope.btn_todayremark_disable =  false;
    $scope.history_enquiryId;
    $scope.initmoduelswisehisory = [2];
    $scope.contact_permission;
    $scope.email_permission;
    $scope.client_id;
    $scope.login_user_id;
    $scope.loginmobile;
    $scope.ccpresalessubStatusList = [];
    $scope.ccpresalesSubCategoriesList = [];
    $scope.subSourceList = [];
    $scope.projectList = [];
    $scope.initHistoryDataModal = function (enquiry_id,moduelswisehisory,init) 
    {
        if(init == 1 )
        {
            /*using the enquiry history modal*/
            $(':checkbox.chk_followup_history_all').prop('checked', true);
            $(':checkbox#chk_enquiry_history').prop('checked', true);
        }
        
        
        Data.post('customer-care/presales/getenquiryHistory', {
            enquiryId: enquiry_id,moduelswisehisory:moduelswisehisory
        }).then(function (response) {
            $scope.history_enquiryId = enquiry_id;
            $scope.chk_followup_history_all = true;
            if (response.success) {
                $scope.historyList = angular.copy(response.records);
                $timeout(function () {
                    for (i = 0; i < $scope.historyList.length; i++) {
                        if ($scope.historyList[i].call_recording_url != "" && $scope.historyList[i].call_recording_url != "None") {
                            document.getElementById("recording_" + $scope.historyList[i].id).src = $scope.historyList[i].call_recording_url;
                        }
                    }
                }, 1000);
            }
            else
            {
                $scope.historyList = angular.copy(response.records);
                
            }    
        });
    }  
    
    $scope.getModulesWiseHistory = function(enquiry_id,opt)
    {
        var moduelswisehisory = new Array();
        if(opt == 1)
        {
            if($('#chk_enquiry_history').is(":checked"))
            {
                $(':checkbox.chk_followup_history_all').prop('checked', true);
            }
            else
            {
                $(':checkbox.chk_followup_history_all').prop('checked', false);
            } 
        }
        
        $(".chk_followup_history_all").each(function(){            
            if($(this).is(":checked"))
            {
                moduelswisehisory.push($(this).data("id"))    
            }   
        });
        
        if( moduelswisehisory.length == 2)
        {
            $(':checkbox#chk_enquiry_history').prop('checked', true);
        }    
        else
        {
           $(':checkbox#chk_enquiry_history').prop('checked', false);
        }    
                
        $scope.initHistoryDataModal(enquiry_id,moduelswisehisory,0)            
    }
        
    $scope.initTodayHistoryDataModal = function (enquiry_id,moduelswisehisory,init) 
    {
        
        if(init == 1 )
        {   
            /*using the today remark popup history tap*/
            $(':checkbox.chk_today_remark_history_all').prop('checked', true);
            $(':checkbox#chk_today_remark_history').prop('checked', true);
        }
          
        
        Data.post('customer-care/presales/getenquiryHistory', {
            enquiryId: enquiry_id,moduelswisehisory:moduelswisehisory
        }).then(function (response) {
            $scope.history_enquiryId = enquiry_id;
            $scope.chk_followup_history_all = true;
            if (response.success) {
                $scope.historyList = angular.copy(response.records);
                $timeout(function () {
                    for (i = 0; i < $scope.historyList.length; i++) {
                        if ($scope.historyList[i].call_recording_url != "" && $scope.historyList[i].call_recording_url != "None") {
                            document.getElementById("recording_today_remark_1_" + $scope.historyList[i].id).src = $scope.historyList[i].call_recording_url;
                        }
                    }
                }, 1000);
            }
            else
            {
                $scope.historyList = angular.copy(response.records);
                
            }    
        });
    }
    
    
    
    $scope.getModulesWiseHistory_Today = function(enquiry_id,opt)
    {
        var moduelswisehisory = new Array();        
        if(opt == 1)
        {
            if($('#chk_today_remark_history').is(":checked"))
            {
                $(':checkbox.chk_today_remark_history_all').prop('checked', true);
            }   
            else
            {
                $(':checkbox.chk_today_remark_history_all').prop('checked', false);
            } 
        }   
        
        $(".chk_today_remark_history_all").each(function(){
            if($(this).is(":checked"))
            {
                moduelswisehisory.push($(this).data("id"))    
            }   
        });
        
        if( moduelswisehisory.length == 2)
        {
            $(':checkbox#chk_today_remark_history').prop('checked', true);
        }    
        else
        {
           $(':checkbox#chk_today_remark_history').prop('checked', false);
        }    
                
        $scope.initTodayHistoryDataModal(enquiry_id,moduelswisehisory,0)            
    }
    $scope.procName = function (procedureName,listType) {
            $scope.getProcName = angular.copy(procedureName);
            $scope.listType = listType;
            
    }
        
    $scope.removefilter = function (key) {
            $scope.showloader();
            delete $scope.filter[key];
            $scope.ccfilter($scope.filter, 1, 30);
            $('#slideout').toggleClass('on');
            $scope.hideloader();
            return false;
    }
    $scope.ccfilter = function(filter,page, noOfRecords)
    {
        $scope.showloader();
        page = noOfRecords * (page - 1);
        Data.post('customer-care/presales/ccfilter', 
            {
                    filter: filter,getProcName: $scope.getProcName, pageNumber: page, 
                    itemPerPage: noOfRecords, type: $scope.type
            })
            .then(function (response) 
            {
                if (response.success)
                {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                } 
                else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.showfilterData = filter;
                $('#slideout').toggleClass('on');
                if ($(".wrap-filter-form").hasClass("on")) {
                    $(".mainDiv").css("opacity", "0.2");
                    $(".mainDiv").css("pointer-events", "none");
                } else {
                    $(".mainDiv").css("opacity", "");
                    $(".mainDiv").css("pointer-events", "visible");
                }
                $scope.hideloader();
                $scope.flagForPage = 0;
                return false;
            });                
    }
    
    $scope.pageChanged = function (pageNo, functionName, id, type, pageNumber) 
    {
        
        $scope.flagForPage++;
        if($scope.flagForPage == 1){
            if ($scope.filter && Object.keys($scope.filter).length > 0) {
                $scope.ccfilter($scope.filter, pageNo, $scope.itemsPerPage);
                $('#slideout').toggleClass('on');
            } else {
                $scope[functionName](id, type, pageNo, $scope.itemsPerPage);
            }
            
            $scope.pageNumber = pageNo;
        }
    }
    
    
    
    $scope.total= function (id, type, pageNumber, itemPerPage,listType) 
    {
          
        $scope.itemsPerPage = itemPerPage;
        $scope.type = type;
        $scope.listType = listType;
        $scope.getProcName = 'proc_cc_presales_total';
        var action = '';
        action = 'getTotal';
        if (type == 0)
        {
            $scope.pagetitle = "My Total Followups";
        } 
        else 
        {
            $scope.pagetitle = "Team`s Total Followups ";
        }
        Data.post('customer-care/presales/' + action, {
            empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage,'type':type,
        }).then(function (response) {
             if (response.success) {
                $scope.enquiries = response.records;
                $scope.enquiriesLength = response.totalCount;     
            } 
            else
            {
                $scope.enquiries = '';
                $scope.enquiriesLength = 0;
            }
            $scope.flagForPage = 0;
        });
                 
    };
        
    $scope.completed= function (id, type, pageNumber, itemPerPage,listType) 
    {
       
       $scope.itemsPerPage = itemPerPage;
       $scope.type = type;
       $scope.listType = listType;
       $scope.getProcName = 'proc_cc_presales_completed';
       var action = '';
       action = 'getCompleted';
       if (type == 0)
       {
           
           $scope.pagetitle = "My Completed Followups";
       } 
       else 
       {
           $scope.pagetitle = "Team`s Completed Followups ";
       }
       Data.post('customer-care/presales/' + action, {
           empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage,'type':type,
       }).then(function (response) {
            if (response.success) {
               $scope.enquiries = response.records;
               $scope.enquiriesLength = response.totalCount;     
           } 
           else
           {
               $scope.enquiries = '';
               $scope.enquiriesLength = 0;
           }
           $scope.flagForPage = 0;
          
       });

   };

    $scope.previous= function (id, type, pageNumber, itemPerPage,listType) 
    {

       $scope.itemsPerPage = itemPerPage;
       $scope.type = type;
       $scope.listType = listType;
       var action = '';
       action = 'getPrevious';
       $scope.getProcName = 'proc_cc_presales_previous';
       if (type == 0)
       {
           
           $scope.pagetitle = "My Previous Followups";
       } 
       else 
       {
           $scope.pagetitle = "Team`s Previous Followups";
       }
       Data.post('customer-care/presales/' + action, {
           empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage,'type':type,
       }).then(function (response) {
            if (response.success) {
               $scope.enquiries = response.records;
               $scope.enquiriesLength = response.totalCount;     
           } 
           else
           {
               $scope.enquiries = '';
               $scope.enquiriesLength = 0;
           }
           $scope.flagForPage = 0;
       });

   };
        
    $scope.today= function (id, type, pageNumber, itemPerPage,listType) 
    {

       $scope.itemsPerPage = itemPerPage;
       $scope.type = type;
       $scope.listType = listType;
       $scope.getProcName = 'proc_cc_presales_today';
       var action = '';
       action = 'getToday';
       if (type == 0)
       {
          
           $scope.pagetitle = "My Today`s Followups";
       } 
       else 
       {
           $scope.pagetitle = "Team`s Today`s Followups";
       }
       Data.post('customer-care/presales/' + action, {
           empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage,'type':type,
       }).then(function (response) {
            if (response.success) {
               $scope.enquiries = response.records;
               $scope.enquiriesLength = response.totalCount;     
           } 
           else
           {
               $scope.enquiries = '';
               $scope.enquiriesLength = 0;
           }
           $scope.flagForPage = 0;
       });

   };
   
   $scope.pending= function (id, type, pageNumber, itemPerPage,listType) 
    {

       $scope.itemsPerPage = itemPerPage;
       $scope.type = type;
       $scope.listType = listType;
       var action = '';
       action = 'getPending';
       $scope.getProcName = 'proc_cc_presales_pending';
       if (type == 0)
       {
           
           $scope.pagetitle = "My Pending Followups";
       } 
       else 
       {
           $scope.pagetitle = "Team`s Pending Followups";
       }
       Data.post('customer-care/presales/' + action, {
           empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage,'type':type,
       }).then(function (response) {
            if (response.success) {
               $scope.enquiries = response.records;
               $scope.enquiriesLength = response.totalCount;     
           } 
           else
           {
               $scope.enquiries = '';
               $scope.enquiriesLength = 0;
           }
           $scope.flagForPage = 0;
       });

   };

   
    
    /*today remark*/
    
    $scope.gettodayremarksEnquiry = function (id) {
            $scope.chk_followup_history_all = true;
            $scope.minDate = new Date();
            var time = new Date();
            if (id !== '') {
                $scope.pageHeading = 'Today`s Remark';
                Data.post('customer-care/presales/getPresalesTodayremarksEnquiry', {
                    enquiryId: id,
                }).then(function (response) {
                    if (!response.success) 
                    {
                        $scope.errorMsg = response.message;
                    }
                    else 
                    {
                        
                        $scope.contact_permission = response.contact_permission;
                        $scope.email_permission = response.email_permission;
                        $scope.client_id = response.client_id;
                        $scope.login_user_id = response.login_user_id;
                        $scope.loginmobile = response.loginmobile;
                        $scope.remarkData = angular.copy(response.enquiryDetails[0]);   
                                                
                        if (response.enquiryDetails[0].title_id == 0 || response.enquiryDetails[0].title_id == null)
                        {
                            $scope.remarkData.title_id = '';
                        }
                        if (time.getHours() > 19 || time.getHours() < 9) {
                            time.setHours(9);
                        }
                        var minuteStr = time.getMinutes().toString();
                        if (minuteStr.length == 1 && minuteStr != '0') {
                            minuteStr = '0' + minuteStr;
                        } else {
                            var minuteStr = time.getMinutes();
                        }
                        if (minuteStr == 0) {
                            time.setHours(time.getHours());
                            time.setMinutes("00");
                        } else if (minuteStr > 0 && minuteStr <= 15) {
                            time.setMinutes(15);
                        } else if (minuteStr > 15 && minuteStr <= 30) {
                            time.setMinutes(30);
                        } else if (minuteStr > 30 && minuteStr <= 45) {
                            time.setMinutes(45);
                        } else {
                            time.setHours(time.getHours() + 1);
                            time.setMinutes("00");
                        }

                        $scope.remarkData.next_followup_time = time;
                        $scope.useremail = angular.copy(response.useremail);
                        $scope.mobileList = response.enquiryDetails.mobileNumber;
                        $scope.emailList = response.enquiryDetails.emailId;
                        var source = (response.enquiryDetails[0].sales_source_name == null) ? ' ' : response.enquiryDetails[0].sales_source_name;
                        var subsource = (response.enquiryDetails[0].enquiry_subsource == null) ? ' ' : ' / ' + response.enquiryDetails[0].enquiry_subsource;
                        $scope.sourceDetails = source + subsource;
                        $scope.remarkData.enquiryId = id;
                       
                        if($scope.remarkData.cc_presales_status_id == null)
                            $scope.remarkData.cc_presales_status_id = '';
                        
                        
                        if($scope.remarkData.cc_presales_category_id == null)
                            $scope.remarkData.cc_presales_category_id = '';

                        $scope.customer_address = (response.enquiryDetails[0].customer_address == '') ? '' : response.enquiryDetails[0].customer_address;
                        $scope.remarkData.followup_by = {"id": response.enquiryDetails[0].followup_by, "first_name": response.enquiryDetails[0].first_name + " " + response.enquiryDetails[0].last_name};

                        
                        var d = new Date();
                        if(d.getDate() < 10){
                        $scope.remarkData.next_followup_date = (("0" + d.getDate()) + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear());
                        }else{
                            $scope.remarkData.next_followup_date = ((d.getDate()) + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear());
                        }
                        
                        $scope.todayremarkTimeChange(d);
                        $scope.remarkData.next_followup_time=''
                        
                        Data.post('getccpresalesSubtatus', {
                            data: {statusId: response.enquiryDetails[0].cc_presales_status_id},
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } 
                            else 
                            {
                                $scope.ccpresalessubStatusList = response.records;                              
                                if ($scope.remarkData.cc_presales_substatus_id == 0 || $scope.remarkData.cc_presales_substatus_id== null || $scope.remarkData.cc_presales_substatus_id === undefined) 
                                {
                                    $scope.remarkData.cc_presales_substatus_id = "";
                                } 
                                
                                $("#cc_presales_substatus_id").val($scope.remarkData.cc_presales_substatus_id);
                            }
                        });
                        
                        
                        Data.post('getccPreSalesSubCategory', {
                            data: {statusId: response.enquiryDetails[0].cc_presales_subcategory_id},
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {

                                $scope.ccpresalesSubCategoriesList = response.records;
                                if ($scope.remarkData.cc_presales_subcategory_id == 0 || $scope.remarkData.cc_presales_subcategory_id == null || $("#cc_presales_subcategory_id").val() === undefined) {
                                    $scope.remarkData.cc_presales_subcategory_id = "";
                                } 
                                $("#sales_subcategory_id").val($scope.remarkData.sales_subcategory_id);
                               
                            }
                        });
                        
                        
                      
                        if ($scope.remarkData.customer_fname !== '') {
                            $scope.custInfo = true;
                            $scope.editableCustInfo = false;
                            
                        } else {
                            $scope.custInfo = false;
                            $scope.editableCustInfo = true;
                        }
                        
                        
                        if ($scope.remarkData.sales_source_id != '' || $scope.remarkData.sales_source_id != '0') {
                            $scope.source = false;
                        } else {
                            $scope.source = true;
                        }
                        
                        
                        
                    }
                });
                $timeout(function () {
                    $("li#remarkTab a").trigger('click');
                }, 200);
            }
        }
    
    $scope.todayremarkTimeChange = function(selectedDate)
    {
        var currentDate = new Date();
        $scope.currentDate = (currentDate.getFullYear() + '-' + ("0" + (currentDate.getMonth() + 1)).slice(-2) + '-' + currentDate.getDate());
        var selectedDate = new Date(selectedDate);
        $scope.selectedDate = (selectedDate.getFullYear() + '-' + ("0" + (selectedDate.getMonth() + 1)).slice(-2) + '-' + selectedDate.getDate());
        Data.post('getnextfollowupTime', {
            data: {currentDate: $scope.currentDate, selectedDate: $scope.selectedDate},
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.timeList = response.records;
            }
        });
        
    }
    
   
    $scope.insertCcPreSalesTodayRemark = function(remarkData)
    {
        $scope.btn_todayremark_disable = true;
        Data.post('customer-care/presales/insertCcPreSalesRemark', {
                            data:remarkData ,
        })
        .then(function (response) 
        {
            $scope.btn_todayremark_disable = false;
            if (!response.success) {
                toaster.pop('error', '', response.message);
                $scope.errorMsg = response.message;
            } else {
                    $('#todayremarkDataModal').modal('toggle');
                    toaster.pop('success', '', response.message);
                    $state.transitionTo($state.current, $stateParams, {
                        reload: true, //reload current page
                        inherit: false, //if set to true, the previous param values are inherited
                        notify: true //reinitialise object
                    });
                    $(".modal-backdrop").hide();
                    
            }
        });      
    }
    
}]);

app.filter('removeHTMLTags', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});

app.filter('split', function() {
       return function(input, splitChar, splitIndex) {
           return input.split(splitChar)[splitIndex];
    }
});

