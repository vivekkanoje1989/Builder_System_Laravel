app.controller('enquiryController', ['$scope', 'Data', '$timeout', 'toaster', function ($scope, Data, $timeout, toaster) {
        $scope.projectsDetails = [];
        $scope.searchData = {};
        $scope.filterData = {};
        $scope.itemsPerPage = 10;
        $scope.noOfRows = 1;
        $scope.historyList = {};
        $scope.divText = true;
        $scope.btnExport = true;
        $scope.dnExcelSheet = false;
        $scope.pageHeading = '';
        
        $scope.locations = [];        
        $scope.projectList = [];
        $scope.subSourceList = [];
        $scope.salesEnqSubCategoryList = [];
        
        $scope.items = function (num) {
            $scope.itemsPerPage = num;
        };
        
        $scope.clearToDate = function(){
            $scope.filterData.toDate = '';
        }
        
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

        $scope.refreshSlider = function(){
            $timeout(function(){
                $scope.$broadcast('rzSliderForceRender');    
            },200);
        }

        $scope.initHistoryDataModal = function (enquiry_id) {
            Data.post('master-sales/getEnquiryHistory', {
                enquiryId: enquiry_id,
            }).then(function (response) {
                if (response.success) {
                    $scope.historyList = angular.copy(response.records);
                }
            });
        }    
        $scope.exportReport = function(result){            
            Data.post('master-sales/exportToExcel',{result:result, reportName:$scope.pageHeading.replace(/ /g,"_")}).then(function (response) {
                $("#downloadExcel").attr("href",response.fileUrl);
                console.log(response.sheetName);
                $scope.sheetName = response.sheetName;
                $timeout(function(){
                   // window.open($('#downloadExcel').attr('href'),"_blank");
//                  angular.element('#downloadExcel').trigger('click');
                    $scope.btnExport = false;
                    $scope.dnExcelSheet = true;
                },500);
            });
        }

        /****************************ENQUIRIES****************************/
        $scope.getTotalEnquiries = function ()
        {
            $scope.pageHeading = "Total Enquiries";
            Data.post('master-sales/getTotalEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getLostEnquiries = function ()
        {
            $scope.pageHeading = "Lost Enquiries";
            Data.post('master-sales/getLostEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getClosedEnquiries = function ()
        {
            $scope.pageHeading = "Closed Enquiries";
            Data.post('master-sales/getClosedEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        /****************************ENQUIRIES****************************/
        
        /****************************FOLLOWUPS****************************/
        $scope.showTodaysFollowups = function ()
        {
            $scope.pageHeading = "Today's Followups";
            Data.post('master-sales/getTodaysFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.showPendingsFollowups = function ()
        {
            $scope.pageHeading = "Pending Followups";
            Data.post('master-sales/getPendingFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.showPreviousFollowups = function ()
        {
            $scope.pageHeading = "Previous Followups";
            Data.post('master-sales/getPreviousFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        /****************************FOLLOWUPS****************************/
        
        /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
        $scope.getTeamTotalEnquiries = function ()
        {
            $scope.pageHeading = "Team Total Enquiries";
            Data.post('master-sales/getTeamTotalEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getTeamLostEnquiries = function ()
        {
            $scope.pageHeading = "Team Lost Enquiries";
            Data.post('master-sales/getTeamLostEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getTeamClosedEnquiries = function ()
        {
            $scope.pageHeading = "Team Closed Enquiries";
            Data.post('master-sales/getTeamClosedEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getTeamTodayFollowups = function ()
        {
            $scope.pageHeading = "Team Today's Followups";
            Data.post('master-sales/getTeamTodayFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getTeamPendingFollowups = function ()
        {
            $scope.pageHeading = "Team Pending Followups";
            Data.post('master-sales/getTeamPendingFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getTeamPreviousFollowups = function ()
        {
            $scope.pageHeading = "Team Previous Followups";
            Data.post('master-sales/getTeamPreviousFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
        $scope.projectList = [];
        $scope.blockTypeList = [];
        $scope.mobileList = [];
        $scope.mobile_number = [];
        $scope.email_id_arr = [];
        $scope.custInfo = $scope.editableCustInfo = $scope.source = false;
        var d = new Date();
        $scope.hstep = 1;$scope.mstep = 15; 
        $scope.enquiryId = $scope.followupId = $scope.customerId = '';
        
        $scope.text = function(){
            $scope.divText = true;
            $scope.divSms = false;
            $scope.divEmail = false;
            $scope.email_id_arr = $scope.mobile_number = [];
            $scope.remarkData.msgRemark = $scope.remarkData.subject = $scope.remarkData.email_content = '';
            $('.clsMobile').prop("checked",false);
            $('.clsEmail').prop("checked",false);
            $scope.sbtBtn1 = $scope.sbtBtn2 = false;
        }
        $scope.sms = function(){
            $scope.divText = false;
            $scope.divSms = true;
            $scope.divEmail = false;
            $scope.email_id_arr = [];
            $scope.remarkData.textRemark = $scope.remarkData.subject = $scope.remarkData.email_content = '';
            $('.clsEmail').prop("checked",false);
            $scope.sbtBtn2 = $scope.sbtBtn3 = false;
        }
        $scope.email = function(){
            $scope.divText = false;
            $scope.divSms = false;
            $scope.divEmail = true;
            $scope.mobile_number = [];
            $scope.remarkData.msgRemark = $scope.remarkData.textRemark = '';
            $('.clsMobile').prop("checked",false);
            $scope.sbtBtn1 = $scope.sbtBtn3 = false;
        }       
        
        $scope.todayRemark = function(enquiryId,followupId,customerId){
            Data.post('master-sales/getDataForTodayRemark',{enquiryId:enquiryId}).then(function (response) {
                if(!response.success){
                    $scope.errorMsg = response.errorMsg;
                }else{
                    var setTime = response.data[0].next_followup_time.split(":");
                    var setMin = setTime[1].split(" ");
                    d.setHours(setTime[0]);
                    d.setMinutes(setMin[0]);
                    response.data[0].next_followup_time = d;
                    $scope.remarkData = angular.copy(response.data[0]);
                    $scope.projectList = response.data.selectedProjects;
                    $scope.blockTypeList = response.data.selectedBlocks;
                    $scope.mobileList = response.data.mobileNumber;
                    $scope.emailList = response.data.emailId;
                    $scope.remarkData.next_followup_date = (d.getFullYear() + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + d.getDate());

                    $timeout(function () {
                        $scope.remarkData.project_id = response.data.selectedProjects;
                        $scope.remarkData.block_id = response.data.selectedBlocks;
                    },500);
                    if($scope.remarkData.customer_fname !== ''){
                        $scope.custInfo = true;
                        $scope.editableCustInfo = false;
                    }else{
                        $scope.custInfo = false;
                        $scope.editableCustInfo = true;
                    }
                    if($scope.remarkData.sales_source_id !== '' || $scope.remarkData.sales_source_id !== 0){
                        $scope.source = false;
                    }else{
                        $scope.source = true;
                    }
                    $scope.enquiryId = enquiryId;
                    $scope.followupId = followupId;
                    $scope.customerId = customerId;
                    
                    Data.post('getSalesEnqSubCategory',{categoryId:response.data[0].sales_category_id}).then(function (response) {
                        if (!response.success) {
                            $scope.errorMsg = response.message;
                        } else {
                            $scope.salesEnqSubCategoryList = response.records;
                        }
                    });
                    Data.post('getSalesEnqSubStatus',{statusId:response.data[0].sales_status_id}).then(function (response) {
                        if (!response.success) {
                            $scope.errorMsg = response.message;
                        } else {
                            $scope.salesEnqSubStatusList = response.records;
                        }
                    });
                }                
            });
        }
        $scope.checkProjectLength = function () {
            if ($scope.remarkData.project_id.length === 0) {
                $scope.emptyProjectId = true;
                $scope.applyClassProject = 'ng-active';
            } else {
                $scope.emptyProjectId = false;
                $scope.applyClassProject = 'ng-inactive';
            }
        };   
        $scope.checkBlockLength = function () {
            if ($scope.remarkData.block_id.length === 0) {
                $scope.emptyBlockId = true;
                $scope.applyClassProject = 'ng-active';
            } else {
                $scope.emptyBlockId = false;
                $scope.applyClassProject = 'ng-inactive';
            }
        };   
        
        $scope.checkedMobileNo = function(mobileNo,inc){
            if ($('#mob_'+inc).is(':checked')) {
                $scope.mobile_number.push(mobileNo);
            }else{
                var mobIndex = $scope.mobile_number.indexOf(mobileNo);
                if (mobIndex > -1) {
                   $scope.mobile_number.splice(mobIndex, 1);
                }
            }
        }
        $scope.checkedEmailId = function(emailId,inc){
            if ($('#email_'+inc).is(':checked')) {
                $scope.email_id_arr.push(emailId);
            }else{
                var mobIndex = $scope.email_id_arr.indexOf(emailId);
                if (mobIndex > -1) {
                   $scope.email_id_arr.splice(mobIndex, 1);
                }
            }
        }
        $scope.insertRemark = function(modalData){
            if($scope.editableCustInfo === true){
                var custInfo = {title_id:modalData.title_id,customer_fname:modalData.customer_fname,customer_lname:modalData.customer_lname};
            }
            if($scope.source === true){
                var sourceInfo = {source_id:modalData.source_id,sales_subsource_id:modalData.sales_subsource_id,sales_source_description:modalData.sales_source_description,};
            }
            
            var data = {enquiry_id:$scope.enquiryId, 
                followupId:$scope.followupId, 
                customerId:$scope.customerId, 
                sales_category_id:modalData.sales_category_id,
                sales_subcategory_id:modalData.sales_subcategory_id,
                followup_by_employee_id:modalData.followup_by_employee_id,
                next_followup_date:modalData.next_followup_date,
                next_followup_time:modalData.next_followup_time,
                sales_status_id:modalData.sales_status_id,
                sales_substatus_id:modalData.sales_substatus_id,
                project_id:modalData.project_id,
                block_id:modalData.block_id,
                title_id:modalData.title_id,
                first_name:modalData.first_name,
                last_name:modalData.last_name,
                source_id:modalData.source_id,
                subsource_id:modalData.subsource_id,
                source_description:modalData.source_description,                
                textRemark:modalData.textRemark,
                mobileNumber: $scope.mobile_number,
                msgRemark:modalData.msgRemark,
                email_id:modalData.email_id,
                email_id_arr:$scope.email_id_arr,
                email_content:modalData.email_content,
                subject:modalData.subject
            };

            Data.post('master-sales/insertTodayRemark',{data:data,custInfo:custInfo,sourceInfo:sourceInfo}).then(function (response) {
                if(!response.success){
                    $scope.errorMsg = response.errorMsg;
                }else{
                    $('#todaysRemarkModal').modal('toggle');
                    toaster.pop('success', '', response.message);
                }                
            });
        };
          
        
    /**************************Budget Range Bar*************************/
    $scope.min = 3000000;
    $scope.max = 7000000;
    $scope.visSlider = {
        options: {
            floor: 200000,
            ceil: 20000000,
            step: 1
        }
    };

    $scope.rangeValidateMin = function(minVal){
        if(typeof minVal == 'undefined' || minVal < 200000){
            $scope.min = 200000;
        }
        else if(minVal > 20000000){
             $scope.min = 20000000;
        }
        else if(minVal > $scope.max){
             $scope.min = $scope.max;
        }
    }
    $scope.rangeValidateMax = function(maxVal){
        if(typeof maxVal == 'undefined' || maxVal > 20000000){
            $scope.max = 20000000;
        }
        else if(maxVal < 200000){
             $scope.max = $scope.min;
        }
        else if(maxVal < $scope.min){
             $scope.max = $scope.min;
        }

    }
    /**************************Budget Range Bar*************************/
    $scope.getProcName = '';

    $scope.procName = function (name){
        $scope.getProcName = angular.copy(name);
    } 
    $scope.getFilteredData = function (filterData,minBudget,maxBudget)
    {
        if(typeof filterData.fromDate !== 'undefined'){
            var fdate = new Date(filterData.fromDate);
            $scope.filterData.fromDate = (fdate.getFullYear() + '-' + ("0" + (fdate.getMonth() + 1)).slice(-2) + '-' + fdate.getDate());
        }else if(typeof filterData.toDate !== 'undefined'){
            var tdate = new Date(filterData.toDate);
            $scope.filterData.toDate = (tdate.getFullYear() + '-' + ("0" + (tdate.getMonth() + 1)).slice(-2) + '-' + tdate.getDate());
        }
        
        Data.post('master-sales/filteredData', {filterData: filterData,minBudget:minBudget,maxBudget:maxBudget,getProcName:$scope.getProcName}).then(function (response) {
            $scope.locations = response.records;
        });
    }
}]);

app.controller('getEmployeesCtrl', function ($scope, Data) {
    Data.get('master-sales/getEmployees').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.employeeList = response.records;
        }
    });
});
app.controller('financeEmployees', function ($scope, Data) {
    Data.get('master-sales/getFinanceEmployees').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.financeEmpList = response.records;
        }
    });
});
app.controller('agencyTieupCtrl', function ($scope, Data) {
    Data.get('getFinanceTieupAgency').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.agencyTieupList = response.records;
        }
    });
});
app.controller('enquiryCityCtrl', function ($scope, Data) {
    Data.get('master-sales/getEnquiryCity').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.cityList = response.records;
        }
    });
    
    $scope.changeLocations = function (cityId)
    {
        Data.post('master-sales/getAllLocations', {city_id: cityId,}).then(function (response) {
            $scope.locations = response.records;
        });
    }
});