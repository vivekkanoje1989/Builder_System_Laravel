app.controller('enquiryController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', 'toaster', '$filter', '$stateParams', 'SweetAlert', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $window, toaster, $filter, $stateParams, SweetAlert) {
        $scope.projectsDetails = [];
        $scope.searchData = {};
        $scope.filterData = {};
        $scope.documentData = {};
        $scope.documentListData = {};
        $scope.SelectedDoc = {};
        $scope.tempFilterData = {};
        $scope.listsIndex = {};
        $scope.documentData.project_id = 0;
        $scope.itemsPerPage = 3;
        $scope.noOfRows = 1;
        $scope.historyList = {};
        $scope.ct_presalesemployee = [];
        $scope.initmoduelswisehisory = [1, 2];
        $scope.history_enquiryId;
        $scope.divText = true;
        $scope.btnExport = true;
        $scope.dnExcelSheet = false;
        $scope.pagetitle;
        $scope.pageNumber = 1;
        $scope.locations = [];
        $scope.projectList = [];
        $scope.subSourceList = [];
        $scope.salesEnqSubStatusList = [];
        $scope.salesEnqSubCategoryList = [];
        $scope.getProcName = $scope.type = $scope.getFunctionName = '';
        $scope.flagForChange = 0;
        $scope.report_name;
        $scope.listType = 0;
        $scope.BulkReasign = false;
        $scope.bulkData = {};
        $scope.Bulkflag = [];
        $scope.remarkData = {};
        $scope.remarkData.sms_privacy_status = 1;
        $scope.remarkData.email_privacy_status = 1;        
        $scope.shared = $scope.sharedemployee = 0;
        $scope.sendDocDisable = false;
        $rootScope.newEnqFlag1 = 0;
        
        
        $scope.todayremarkTimeChange = function (selectedDate)
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

        $scope.cloudCallingLog = function (modules, employee_id, enquire_id, customer_id, sequence) {
            Data.post('cloudcallinglogs/outboundCalltrigger', {
                modules: modules, employee_id: employee_id, enquire_id: enquire_id, customer_id: customer_id, sequence: sequence
            }).then(function (response) {
                var successMsg = response.message;
                toaster.pop('success', 'Call Status', successMsg);
            });
        }

        $scope.changeSmsPrivacyStatus = function (val) {
            $scope.remarkData.sms_privacy_status = val;            
            Data.post('master-sales/privacyStatus', {
                data: {statusVal: val, customerId: $scope.remarkData.customerId, dbField:'SMS'},
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.timeList = response.records;
                }
            });
        }

        $scope.changeEmailPrivacyStatus = function (val) {
            $scope.remarkData.email_privacy_status = val;
            Data.post('master-sales/privacyStatus', {
                data: {statusVal: val, customerId: $scope.remarkData.customerId, dbField:'EMAIL'},
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.timeList = response.records;
                }
            });
        }

        $scope.items = function (num) {
            $scope.itemsPerPage = num;
        };

        $scope.clearToDate = function () {
            $scope.filterData.toDate = '';
        }
        $scope.pageChangeHandler = function (num) {

            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

        $scope.refreshSlider = function () {
            $timeout(function () {
                $scope.$broadcast('rzSliderForceRender');
            }, 200);
        }

        var mhistory = new Array(); 
        $scope.initHistoryDataModal = function (enquiry_id, moduelswisehisory, init)
        {
            if (init == 1)
            {
                /*using the enquiry history modal*/
                
                mhistory.push($('#chk_presales').data("id"));
                mhistory.push($('#chk_Customer_Care').data("id"));
                
                $(':checkbox.chk_followup_history_all').prop('checked', true);
                $(':checkbox.chk_enquiry_history').prop('checked', true);
            }
            Data.post('customer-care/presales/getenquiryHistory', {
                enquiryId: enquiry_id, moduelswisehisory: moduelswisehisory
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
                } else
                {
                    $scope.historyList = angular.copy(response.records);

                }
            });
        }

        $scope.gethisotryDataModal = function (enquiry_id, modules, htype)
        {
            /*
             * htype =  1 for the enquiryhistory popup
             * htype = 2 for the todayremark popup
             * 
             */
            Data.post('customer-care/presales/getenquiryHistory', {
                enquiryId: enquiry_id, moduelswisehisory: modules
            }).then(function (response) {
                $scope.history_enquiryId = enquiry_id;
                $scope.chk_followup_history_all = true;
                if (response.success) {


                    if (htype == 1)
                    {
                        $scope.historyList = angular.copy(response.records);
                        $timeout(function () {
                            for (i = 0; i < $scope.historyList.length; i++) {
                                if ($scope.historyList[i].call_recording_url != "" && $scope.historyList[i].call_recording_url != "None") {
                                    document.getElementById("recording_" + $scope.historyList[i].id).src = $scope.historyList[i].call_recording_url;
                                }
                            }
                        }, 1000);
                    } else if (htype == 2)
                    {
                        $scope.historyList1 = angular.copy(response.records);
                        $timeout(function () {
                            for (i = 0; i < $scope.historyList1.length; i++) {
                                if ($scope.historyList1[i].call_recording_url != "" && $scope.historyList1[i].call_recording_url != "None") {
                                    document.getElementById("recording1_" + $scope.historyList1[i].id).src = $scope.historyList1[i].call_recording_url;
                                }
                            }
                        }, 1000);
                    } else if (htype == 3)
                    {
                        $scope.historyList2 = angular.copy(response.records);
                        $timeout(function () {
                            for (i = 0; i < $scope.historyList2.length; i++) {
                                if ($scope.historyList2[i].call_recording_url != "" && $scope.historyList2[i].call_recording_url != "None") {
                                    document.getElementById("recording2_" + $scope.historyList2[i].id).src = $scope.historyList2[i].call_recording_url;
                                }
                            }
                        }, 1000);
                    }

                } else
                {
                    if (htype == 1)
                    {
                        $scope.historyList = angular.copy(response.records);
                    } else if (htype == 2)
                    {
                        $scope.historyList1 = angular.copy(response.records);
                    } else if (htype == 3)
                    {
                        $scope.historyList2 = angular.copy(response.records);
                    }
                }
            });
        }
        
        $scope.getModulesWiseHist = function (enquiry_id, opt)
        {
            
            if (opt == 1)
            {
                $('.chk_enquiry_history').click(function(){                     
                    if ($(this).is(":checked")){alert("if");
                        $(':checkbox.chk_followup_history_all').prop('checked', true);
                        console.log(mhistory);
                    } else{alert("else");
                        $(':checkbox.chk_followup_history_all').prop('checked', false);
                    }
                }); 
            }alert(mhistory.length);
            if (mhistory.length == 2)
            {
                $(':checkbox#chk_enquiry_history').prop('checked', true);
                mhistory.pop();
            } else
            {
                mhistory.push($('#chk_Customer_Care').data("id"));
                $(':checkbox#chk_enquiry_history').prop('checked', false);
            }
            /*if (opt == 1)
            {
                if ($('#chk_enquiry_history').is(":checked"))
                {
                    $(':checkbox.chk_followup_history_all').prop('checked', true);
                } else
                {
                    $(':checkbox.chk_followup_history_all').prop('checked', false);
                }
            }
            var mhistory = new Array();
            if ($('#chk_presales').is(":checked"))
            {
                mhistory.push($('#chk_presales').data("id"));
            }
            if ($('#chk_Customer_Care').is(":checked"))
            {
                mhistory.push($('#chk_Customer_Care').data("id"));
            }
            if (mhistory.length == 2)
            {
                $(':checkbox#chk_enquiry_history').prop('checked', true);
            } else
            {
                $(':checkbox#chk_enquiry_history').prop('checked', false);
            }*/
            //$scope.initHistoryDataModal(enquiry_id, mhistory, 0);
        };

        $scope.exportReport = function (result) {

            Data.post('master-sales/exportToExcel', {result: result, reportName: $scope.report_name.replace(/ /g, "_")}).then(function (response) {
                $("#downloadExcel").attr("href", response.fileUrl);

                window.location.href = response.fileUrl;
                $scope.sheetName = response.sheetName;
                //$scope.btnExport = false;
                $scope.dnExcelSheet = true;
            });
        }
        /****************************ENQUIRIES****************************/
        $scope.pageChanged = function (pageNo, functionName, id, type, newpage, listType, sharedemployee, presalesemployee) {

            $('#all_chk_reassign_enq').prop('checked', false);
            $scope.BulkReasign = false;
            $(".chk_reassign_enq").prop('checked', false);
            $scope.flagForChange++;
            if ($scope.flagForChange == 1)
            {
                if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                    $scope.getFilteredData($scope.filterData, pageNo, $scope.itemsPerPage);
                    $('#slideout').toggleClass('on');
                } else {
                    $scope[functionName](id, type, pageNo, $scope.itemsPerPage, listType, sharedemployee, presalesemployee);
                }
            }
            $scope.pageNumber = pageNo;
        }
        $scope.reassignEnquiries = function (id, type, pageNumber, itemPerPage, listType, shared)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.showloader();
            $scope.listType = listType;
            if (type == 0) {
                $scope.report_name = "Reassign Enquiries";
                $scope.pagetitle = "My Reassigned Enquiries";
            } else {
                $scope.report_name = "Teams Reassign Enquiries";
                $scope.pagetitle = "Team\'\s Reassign Enquiries ";
            }

            $scope.sharedemployee = shared;

            Data.post('master-sales/getReassignEnquiry', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type, shared: $scope.sharedemployee
            }).then(function (response) {
                if (response.success) {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                } else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.flagForChange = 0;
            });

            if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                $scope.getFilteredData($scope.filterData, 1, $scope.itemsPerPage);
                $('#slideout').toggleClass('on');
                return false;
            }
            $scope.hideloader();
        }

        $scope.getTotalEnquiries = function (id, type, pageNumber, itemPerPage, listType, shared)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.showloader();
            $scope.listType = listType;
            $scope.sharedemployee = shared;

            if (type == 0) {
                $rootScope.parentBreadcrumbFlag = "enquiries";
                $scope.report_name = "Total Enquiries";
                $scope.pagetitle = "My Total Enquiries";
            } else {
                $rootScope.parentBreadcrumbFlag = "teamtotalenquiries";
                $scope.report_name = "Teams Total Enquiries";
                $scope.pagetitle = "Team\'\s Total Enquiries ";
            }
            $scope.sharedemployee = shared;
            Data.post('master-sales/getTotalEnquiries', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type, shared: $scope.sharedemployee
            }).then(function (response) {
                if (response.success) {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                    $scope.callBtnPermission = response.callBtnPermission;
                    $scope.displayMobilePermission = response.displayMobilePermission;
                    $scope.displayEmailPermission = response.displayMobilePermission;
                } else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.flagForChange = 0;
            });
            if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                $scope.getFilteredData($scope.filterData, 1, $scope.itemsPerPage);
                $('#slideout').toggleClass('on');
                return false;
            }
            $scope.hideloader();
        }

        $scope.todaysFollowups = function (id, type, pageNumber, itemPerPage, listType, shared)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.listType = listType;
            $scope.showloader();
            if (type == 0) {
                $rootScope.parentBreadcrumbFlag = "todaysfollowups";
                $scope.report_name = "Today's Followups";
                $scope.pagetitle = "My Today's Followups";
            } else {
                $rootScope.parentBreadcrumbFlag = "teamtodaysfollowups";
                $scope.report_name = "Team\'\s Today's Followups";
                $scope.pagetitle = "Team\'\s Today's Followups";
            }

            $scope.sharedEmployees = shared;

            Data.post('master-sales/getTodaysFollowups', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type, shared: $scope.sharedEmployees
            }).then(function (response) {
                if (response.success) {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                    $scope.displayCallBtn = response.displayCallBtn;
                    $scope.MobileNopermissions = response.MobileNopermissions;
                    $scope.Emailpermissions = response.MobileNopermissions;
                } else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.flagForChange = 0;
            });

            if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                $scope.getFilteredData($scope.filterData, 1, $scope.itemsPerPage);
                $('#slideout').toggleClass('on');
                return false;
            }
            $scope.hideloader();
        }
        $scope.pendingsFollowups = function (id, type, pageNumber, itemPerPage, listType, shared)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.listType = listType;
            $scope.showloader();
            if (type == 0) {
                $rootScope.parentBreadcrumbFlag = "pendingfollowups";
                $scope.report_name = "Pending Followups";
                $scope.pagetitle = "My Pending Followups";
            } else {
                $rootScope.parentBreadcrumbFlag = "teampendingfollowups";
                $scope.report_name = "Team\'\s Pending Followups";
                $scope.pagetitle = "Team\'\s Pending Followups";
            }
            $scope.sharedemployee = shared;
            Data.post('master-sales/getPendingFollowups', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type, shared: $scope.sharedemployee
            }).then(function (response) {
                if (response.success) {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                    $scope.outBoundCallBtn = response.outBoundCall;
                    $scope.displayMobileNo = response.displayMobile;
                    $scope.displayEmailId = response.displayMobile;
                } else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.flagForChange = 0;
            });
            if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                $scope.getFilteredData($scope.filterData, 1, $scope.itemsPerPage);
                $('#slideout').toggleClass('on');
                return false;
            }
            $scope.hideloader();
        }
        $scope.previousFollowups = function (id, type, pageNumber, itemPerPage, listType, shared)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.listType = listType;
            $scope.showloader();
            if (type == 0) {
                $rootScope.parentBreadcrumbFlag = "previousfollowups";
                $scope.report_name = "Previous Followups";
                $scope.pagetitle = "My Previous Followups";
            } else {
                $rootScope.parentBreadcrumbFlag = "teampreviousfollowups";
                $scope.report_name = "Team\'\s Previous Followups";
                $scope.pagetitle = "Team\'\s Previous Followups";
            }
            
            $scope.sharedemployee = shared;
            
            Data.post('master-sales/previousFollowups', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type, shared: $scope.sharedemployee
            }).then(function (response) {
                if (response.success) {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                    $scope.displayMobileN = response.displayMobileN;
                    $scope.callBtnPermission = response.callBtnPermission;
                    $scope.emailPermission = response.emailPermission;
                } else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.flagForChange = 0;
            });
            if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                $scope.getFilteredData($scope.filterData, 1, $scope.itemsPerPage);
                $('#slideout').toggleClass('on');
                return false;
            }
            $scope.hideloader();
        }
        $scope.lostEnquiries = function (id, type, pageNumber, itemPerPage, listType, shared)
        {
            
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.listType = listType;
            $scope.showloader();
            if (type == 0) {
                $rootScope.parentBreadcrumbFlag = "lostenquiries";
                $scope.report_name = "Lost Enquiries";
                $scope.pagetitle = "My Lost Enquiries";
            } else {
                $rootScope.parentBreadcrumbFlag = "teamlostenquiries";
                $scope.report_name = "Team\'\s Lost Enquiries";
                $scope.pagetitle = "Team\'\s Lost Enquiries";
            }
            $scope.sharedemployee = shared;
            $scope.showloader();

            Data.post('master-sales/getLostEnquiries', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type, shared: $scope.sharedemployee
            }).then(function (response) {
                if (response.success) {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                    $scope.callBtnPermissions = response.callBtnPermissions;
                    $scope.displayMobile = response.displayMobile;
                    $scope.displayEmail = response.displayMobile;
                } else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.flagForChange = 0;                
            });
            if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                $scope.getFilteredData($scope.filterData, 1, $scope.itemsPerPage);
                $('#slideout').toggleClass('on');
                return false;
            }
            $scope.hideloader();
        }

        $scope.getEnquirySheredWith = function () {
            Data.get('master-sales/sharedEnquiriesEmployee').then(function (response) {
                $scope.presalesemployee = response.presales;
                $scope.postsalesemployee = response.postsales;
            });
        }

        $scope.bookedEnquiries = function (id, type, pageNumber, itemPerPage, listType, shared)
        {
            
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.listType = listType;
            if (type == 0) {
                $rootScope.parentBreadcrumbFlag = "bookedenquiries";
                $scope.report_name = "Booked Enquiries";
                $scope.pagetitle = "My Booked Enquiries";
            } else {
                $rootScope.parentBreadcrumbFlag = "teambookedenquiries";
                $scope.report_name = "Team\'\s Booked Enquiries";
                $scope.pagetitle = "Team\'\s Booked Enquiries";
            }
            $scope.sharedemployee = shared;
            $scope.showloader();
            Data.post('master-sales/getBookedEnquiries', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type, shared: $scope.sharedemployee
            }).then(function (response) {
                if (response.success) {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                    $scope.callBtnPermission = response.callBtnPermission;
                    $scope.displayMobileN = response.displayMobileN;
                    $scope.displayEmailID = response.displayMobileN;
                } else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.flagForChange = 0;
            });
            if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                $scope.getFilteredData($scope.filterData, 1, $scope.itemsPerPage);
                $('#slideout').toggleClass('on');
                return false;
            }
            $scope.hideloader();
        }



        /****************************FOLLOWUPS****************************/
        /****************************FILTER (UMA)***************************************/
        
        $scope.procName = function (procedureName, functionName, shared) {
            if( $("#customerfilter div").hasClass("panel-collapse collapse"))
            {
                $("#customerfilter div").removeClass("panel-collapse collapse").addClass(".panel-collapse collapse in");
                $("#customerfilter div").removeClass("accordion-toggle collapsed").addClass("accordion-toggle");
                $(".accordion.panel-group .panel .collapse").css("background-color", "#eee");
            }
            
            $scope.getProcName = angular.copy(procedureName);
            $scope.getFunctionName = angular.copy(functionName);
            $scope.shared = shared;
        }

        $scope.getFilteredData = function (filterData, page, recordsperpage) {

            Object.keys($scope.filterData).forEach(function (key) {
                if ($scope.filterData[key] == '')
                {
                    delete $scope.filterData[key];
                }
            });
            
            $scope.showloader();
            if (typeof filterData.fromDate !== 'undefined') {
                var fdate = new Date(filterData.fromDate);
                $scope.filterData.fromDate = (fdate.getFullYear() + '-' + ("0" + (fdate.getMonth() + 1)).slice(-2) + '-' + fdate.getDate());
            } else if (typeof filterData.toDate !== 'undefined') {
                var tdate = new Date(filterData.toDate);
                $scope.filterData.toDate = (tdate.getFullYear() + '-' + ("0" + (tdate.getMonth() + 1)).slice(-2) + '-' + tdate.getDate());
            }
            if (typeof filterData.bookingFromDate !== 'undefined') {
                var fbdate = new Date(filterData.bookingFromDate);
                $scope.filterData.bookingFromDate = (fbdate.getFullYear() + '-' + ("0" + (fbdate.getMonth() + 1)).slice(-2) + '-' + fbdate.getDate());
            } else if (typeof filterData.bookingToDate !== 'undefined') {
                var tbdate = new Date(filterData.tbdate);
                $scope.filterData.bookingToDate = (tbdate.getFullYear() + '-' + ("0" + (tbdate.getMonth() + 1)).slice(-2) + '-' + tbdate.getDate());
            }
            Data.post('master-sales/filteredData', {filterData: filterData, pageNumber: page, itemPerPage: $scope.itemsPerPage, getProcName: $scope.getProcName, teamType: $scope.type, shared: $scope.shared}).then(function (response) {
                if (response.success) {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                } else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.hideloader();
                $('#slideout').toggleClass('on');
                if ($(".wrap-filter-form").hasClass("on")) {
                    $(".mainDiv").css("opacity", "0.2");
                    $(".mainDiv").css("pointer-events", "none");
                } else {
                    $(".mainDiv").css("opacity", "");
                    $(".mainDiv").css("pointer-events", "visible");
                }
                $scope.showFilterData = $scope.filterData;
                $scope.flagForChange = 0;
            });
        }

        $scope.removeDataFromFilter = function (keyvalue) {
            if (keyvalue == 'bookingFromDate')
            {
                delete $scope.filterData.bookingToDate;
            }
            delete $scope.filterData[keyvalue];
            $scope.getFilteredData($scope.filterData, 1, 30);
            $('#slideout').toggleClass('on');
            return false;
        }

        $scope.singleSelect = function ()
        {
            var result = false;
            var cnt = 0;
            $(".chk_reassign_enq").each(function () {
                if ($(this).is(':checked'))
                {
                    result = true;
                    cnt++;
                }
            });
            if (cnt === $scope.enquiries.length)
            {
                $('#all_chk_reassign_enq').prop('checked', true);
            } else
            {
                $('#all_chk_reassign_enq').prop('checked', false);
            }
            if (result === true)
            {
                $scope.BulkReasign = true;
                $scope.shareWith = true;
            } else
            {
                $scope.BulkReasign = false;
                $scope.shareWith = false;
            }
        }
        $scope.checkAll = function (result) {
            $(':checkbox.chk_reassign_enq').prop('checked', result);
            if (result == true) {
                $scope.BulkReasign = true;
                $scope.shareWith = true;

            } else {
                $scope.BulkReasign = false;
                $scope.shareWith = false;
            }
        }
        $scope.ct_presalesemployee = [];
        $scope.getAllEmployeeData = function (employee_id) {
            Data.post('master-sales/getEmployeeData').then(function (response) {
                $scope.ct_presalesemployee = response.presalesemprecords;
            });
        };

        $scope.predata = [];
        $scope.preSalesShareEnquiry = function (employees) {

            Data.post('master-sales/preSalesShareEnquiry', {employees: employees, enquiry_id: $scope.Bulkflag}).then(function (response) {
                $('#shareWith').modal('toggle');
                toaster.pop('success', 'Enquiries Sharing', "Enquiry shared successfully");
            });
        }

        $scope.initBulkModal = function () {
            var flag = [];
            $(".chk_reassign_enq").each(function (key, value) {
                if ($(this).is(':checked')) {
                    var str = $(this).val();
                    flag.push(str);
                } else {
                }
            });
            $scope.Bulkflag = flag;
        }

        $scope.bulkreasignemployee = function (bulkData) {
            $scope.reassignBtn = true;
            Data.post('master-sales/BulkReasignEmployee', {
                employee_id: bulkData, enquiry_id: $scope.Bulkflag
            }).then(function (response) {
                var successMsg = response.message;
                toaster.pop('success', 'Bulk Reassign Enquiries', successMsg);
                $('#BulkModal').modal('toggle');
                $(".modal-backdrop").hide();
                $scope.Bulkflag = {};
                $state.transitionTo($state.current, $stateParams, {
                    reload: true, //reload current page
                    inherit: false, //if set to true, the previous param values are inherited
                    notify: true //reinitialise object
                });

            });
        }
        $scope.dropevent = function (e)
        {
            var span = document.querySelector('.fa-sort-desc');
            span.addEventListener('click', function (event) {

            });
        }
        
        $scope.sendDocuments = function (id)
        {
            $rootScope.enquiryId = id;
            $timeout(function () {
                $("li#historyTab").removeClass('active');
                $("li#documentTab").addClass('active');
                $("#documentTab a").trigger("click");
                $scope.documentList(0);
            }, 200);
            Data.post('master-sales/sendDocuments', {enquiryId: id}).then(function (response) {
                if (response.success)
                {
                    var flag  = 0;
                    $scope.documentData = angular.copy(response.records);
                    console.log(response.records);
                    alert(response.records.customer_email_id);
                    var allemails = response.records.customer_email_id.split(",");
                    for(var i=1;i<= allemails.length ; i++)
                    {
                       if(allemails[i] !=='' || allemails[i] !== null || allemails[i] !=='null') 
                       {
                           flag = 1;
                       }
                    }                    
                    if (response.records.customer_fname !== "" && response.records.customer_lname !== "" && flag == 0)
                    {
                        alert("if");
                        $scope.custInfo = true;
                        $scope.documentData.project_id = 0;
                        $scope.editableCustInfo = false; 
                    } else {
                        $scope.custInfo = false;
                        $scope.editableCustInfo = true;
                    }
                }
            });
        }

        $scope.documentList = function (projectId)
        {
            Data.post('master-sales/getDocumentsList', {projectId: projectId}).then(function (response) {
                if (response.success)
                {
                    $scope.documentListData = response.records[0];
                    $scope.sendDocDisable = true;                    
                    if($scope.documentListData.location_map_images != null && $scope.documentListData.floor_plan_images != null && $scope.documentListData.layout_plan_images!= null && $scope.documentListData.amenities_images!= null && $scope.documentListData.project_brochure!= null && $scope.documentListData.specification_images!= null && $scope.documentListData.video_link!= null) 
                    {
                        $scope.sendDocDisable = false;
                    }
                    
                } else
                {
                    $scope.documentListData = {};
                    $scope.sendDocDisable = true;
                }                 
            });            
        }

        $scope.insertSendDocument = function (documentdata)
        {
            console.log(documentdata);
            var flag = [];
            $(".chkDocList").each(function (key, value) {
                if ($(this).is(':checked')) {
                    var str = $(this).val();
                    flag.push(str);
                } else {
                }
            });
            $scope.sendDocDisable = true;
            $scope.SelectedDocs = flag;
            Data.post('master-sales/insertSendDocument', {documentData: documentdata, isUpdate: $scope.editableCustInfo, sendDocument: $scope.SelectedDocs, enquiry_id: $rootScope.enquiryId, }).then(function (response) {
                $scope.sendDocDisable = false;
                if (response.success)
                {
                    toaster.pop('success', 'Sent Documents', "Document Sent successfully");
                    $("#sendDocumentDataModal").toggle('fast');
                    //$('#sendDocumentDataModal').modal('toggle');
                    $state.transitionTo($state.current, $stateParams, {
                        reload: true, //reload current page
                        inherit: false, //if set to true, the previous param values are inherited
                        notify: true //reinitialise object
                    });
                    $(".modal-backdrop").hide();
                } else
                {
                    toaster.pop('error', 'Sent Documents', "Error While Document Sent");
                    $('#sendDocumentDataModal').modal('hide');
                     $state.transitionTo($state.current, $stateParams, {
                        reload: true, //reload current page
                        inherit: false, //if set to true, the previous param values are inherited
                        notify: true //reinitialise object
                    });
                     $(".modal-backdrop").hide();
                }
            });
        }
        $scope.sendingList = function ()
        {
            Data.post('master-sales/sendDocList', {enquiry_id: $rootScope.enquiryId, }).then(function (response) {
                if (response.success)
                {
                    $scope.sendList = response.records;
                    for (var i = 0; i < $scope.sendList.length; i++)
                    {
                        $scope.sendList[i].send_documents = JSON.parse($scope.sendList[i].send_documents);
                    }
                } else
                {
                    $scope.sendList = [];
                    $scope.sendList.len = 0;
                }
            });
        }
        $scope.openImage = function (foldername, imagename)
        {
            window.open('https://storage.googleapis.com/bkt_bms_laravel/project/' + foldername + '/' + imagename + '');
        }
        $scope.chkallDocuments = function ()
        {
            if ($("#allselect").is(':checked'))
            {
                $(':checkbox.chkDocList').prop('checked', true);
            } else
            {
                $(':checkbox.chkDocList').prop('checked', false);
            }
        }

        $scope.updateCustInfo = function (custId)
        {
            $state.go("salesUpdateCustomer", {'customerId': custId,'onlyupdate' : 1});
        }
        $scope.updateEnq = function (custId, enqId)
        {
            $rootScope.newEnqFlag = 1;
            $rootScope.newEnqFlag1 = 1;
            $state.go("salesUpdateEnquiry", {'customerId': custId, 'enquiryId': enqId});
        }
        /* ********************* uma End ******************************** */
        /*********************TODAY REMARK (GEETA)*********************/
        $scope.projectList = [];
        $scope.blockTypeList = [];
        $scope.mobileList = [];
        $scope.mobile_number = [];
        $scope.email_id_arr = [];
        $scope.custInfo = $scope.editableCustInfo = $scope.source = false;
        var d = new Date();
        $scope.hstep = 1;
        $scope.mstep = 15;
        $scope.enquiryId = $scope.followupId = $scope.customerId = '';
        var selectedMobKey;
        var selectedEmKey;
        //display all mobile numbers for customer info 
        $scope.manageMobText = function (key, num) {
            $scope.addMob = true;
            selectedMobKey = key;
            if (num !== '') {
                $timeout(function () {
                    $("#prevMob").val(num);
                    $("#mobile_number").val(num);
                    $scope.remarkData.mobile_number = angular.copy(num);
                }, 200);
            } else {
                $("#prevMob").val('');
                $("#pkid").val('');
                $scope.remarkData.mobile_number = '';
            }
        }
        $scope.manageEmailText = function (key, emailid) {
            $scope.addEmail = true;
            selectedEmKey = key;
            if (emailid !== '') {
                $timeout(function () {
                    $("#prevEmail").val(emailid);
                    $("#email_id").val(emailid);
                    $scope.remarkData.email_id = angular.copy(emailid);
                }, 200);
            } else {
                $("#prevEmail").val('');
                $("#pkid").val('');
                $scope.remarkData.email_id = '';
            }
        }

        //close mobile/email textbox 
        $scope.closeMobText = function () {
            $scope.addMob = false;
        }
        $scope.closeEmailText = function () {
            $scope.addEmail = false;
        }

        //add new mobile number or email address
        $scope.addInfo = function (custId, callingCode, attrVal, elem) {
            var callingCode1 = parseInt(callingCode);
            $scope.flag = false;
            if (elem === "mobile_number") {
                var regex = /^[789]\d{9}$/;
                if (attrVal == '') {
                    $("#pkid").val();
                } else if (!regex.test(attrVal)) {
                    $scope.mobErr = "Please Enter Valid Mobile Number";
                    return false;
                } else {
                    $scope.mobErr = "";
                    $scope.flag = true;
                }
            }
            if (elem === "email_id") {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (attrVal == '') {
                    $("#pkid").val();
                } else if (!regex.test(attrVal)) {
                    $scope.emailErr = "Please Enter Valid Email Address";
                    return false;
                } else {
                    $scope.emailErr = "";
                    $scope.flag = true;
                }
            }

            if ($scope.flag) {
                $timeout(function () {
                    Data.post('/master-sales/addInfo', {
                        custId: $("#custId").val(), callingCode: callingCode1, attrVal: attrVal, elem: elem, pkid: $("#pkid").val(), prevMob: $("#prevMob").val(), prevEmail: $("#prevEmail").val(),
                    }).then(function (response) {
                        if (!response.success) {
                            if (elem === "mobile_number") {
                                $scope.mobErr = response.message;
                            }
                            if (elem === "email_id") {
                                $scope.emailErr = response.message;
                            }
                            return false;
                        } else {
                            $scope.mobErr = "";
                            $scope.pkid = response.pkid;
                            $("#pkid").val(response.pkid);
                            if (elem === "email_id") {
                                $scope.emailIcon = true;
                                $scope.addEmail = false;
                                if (response.updated) {
                                    $scope.emailList[selectedEmKey] = attrVal;
                                } else
                                    $scope.emailList[$scope.emailList.length] = attrVal;
                            }
                            if (elem === "mobile_number") {
                                $scope.mobileIcon = true;
                                $scope.addMob = false;
                                if (response.updated)
                                    $scope.mobileList[selectedMobKey] = attrVal;
                                else
                                    $scope.mobileList[$scope.mobileList.length] = attrVal;
                            }
                            toaster.pop('success', 'Customer Details', "Record updated successfully");
                        }
                    });
                }, 3000);
            }
        }
        //add new company or update company
        $scope.company_list = [];
        $scope.setCompany = function (company) {
            $scope.remarkData.company_id = company.id;
            $scope.remarkData.company_name = company.company_name;
            $scope.showComapnyList = false;

            if (company.id !== '') {
                $timeout(function () {
                    Data.post('/master-sales/addInfo', {
                        custId: $("#custId").val(), corporate_customer: 1, company_id: company.id, elem: 'company_details'
                    }).then(function (response) {
                        if (response.updated)
                            toaster.pop('success', 'Company Details', "Record updated successfully");
                    });
                }, 3000);
            }
        }
        $scope.showComapnyList = false;
        $scope.getCompanyList = function (name) {
            if (name != null || name != '' || name == 'undefined') {
                $scope.remarkData.company_id = 0;
                $scope.showComapnyList = true; //show ul li
                $scope.remarkData.corporateCust = true; //show checkbox
            } else {
                $scope.remarkData.company_id = 0;
                $scope.showComapnyList = false; //hide ul li
                $scope.remarkData.corporateCust = false; //hide checkbox
            }
        }
        $scope.isChecked = function (corporateCust) {
            if (corporateCust == true) {
                $scope.companyInput = true;
                Data.get('getCompanyList').then(function (response) {
                    if (!response.success) {
                        $scope.company_list = [];
                        $scope.showComapnyList = false;
                        $scope.errorMsg = response.message;
                    } else {
                        $scope.company_list = response.records;
                    }
                });
            } else {
                $scope.companyInput = false;
                $scope.remarkData.company_id = 0;
                $scope.remarkData.company_name = "";

                $timeout(function () {
                    if ($scope.remarkData.company_id == '') {
                        Data.post('/master-sales/addInfo', {
                            custId: $("#custId").val(), corporate_customer: 0, company_id: '', elem: 'company_details'
                        }).then(function (response) {
                        });
                    }
                }, 2000);

            }
        }

        $scope.gotoCustomerTab = function () {

            $("li#remarkTab").removeClass('active');
            $("li#customerTab").addClass('active');
            $timeout(function () {
                $("li#customerTab a").trigger('click');
            }, 200);
            return false;
        }

        //display all mobile numbers on today remark box - for send message to selected mobile numbers
        $scope.checkedMobileNo = function (mobileNo, inc) {
            if ($('#mob_' + inc).is(':checked')) {
                $scope.mobile_number.push(mobileNo);
            } else {
                var mobIndex = $scope.mobile_number.indexOf(mobileNo);
                if (mobIndex > -1) {
                    $scope.mobile_number.splice(mobIndex, 1);
                }
            }
        };

        $scope.checkedEmailId = function (emailId, inc) {
            if ($('#email_' + inc).is(':checked')) {
                $scope.email_id_arr.push(emailId);
            } else {
                var mobIndex = $scope.email_id_arr.indexOf(emailId);
                if (mobIndex > -1) {
                    $scope.email_id_arr.splice(mobIndex, 1);
                }
            }
        }

        //hide message and email icon when enquiry status is booked or lost
        $scope.hideIcon = function (id) {
            if (id == 3 || id == 4) {
                $(".checkLost").hide();
                if (id != 4){
                    $("#footerContent").hide();
                }
                $scope.divEmail = false;
                $scope.divSms = false;
                $scope.divText = true;
            } else {
                $(".checkLost").show();
                $("#footerContent").show();
            }
        }

        $scope.getTodayRemarkCustomerModal = function (cid) {
            Data.post('master-sales/getCustomerDataWithId', {
                data: {customerId: cid},
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $timeout(function () {
                        $scope.customerData = response.customerPersonalDetails[0];
                        $scope.customerContacts = response.customerPersonalDetails.get_customer_contacts[0];

                        if (response.customerPersonalDetails[0].aadhar_number === "null" || response.customerPersonalDetails[0].aadhar_number === 0) {
                            $scope.customerData.aadhar_number = "";
                        }
                        if (response.customerPersonalDetails[0].pan_number === "null" || response.customerPersonalDetails[0].pan_number === 0) {
                            $scope.customerData.pan_number = "";
                        }
                        if (response.customerPersonalDetails[0].birth_date === null || response.customerPersonalDetails[0].birth_date === "-0001-11-30 00:00:00" || response.customerPersonalDetails[0].birth_date === 'NaN-aN-NaN') {
                            $scope.customerData.birth_date = "";
                        } else {
                            var bdt = new Date(response.customerPersonalDetails[0].birth_date);
                            if (bdt.getDate() < 10) {
                                $scope.customerData.birth_date = (bdt.getFullYear() + '-' + ("0" + (bdt.getMonth() + 1)).slice(-2) + '-' + ("0" + bdt.getDate()));
                            } else {
                                $scope.customerData.birth_date = (bdt.getFullYear() + '-' + ("0" + (bdt.getMonth() + 1)).slice(-2) + '-' + bdt.getDate());
                            }
                            $scope.maxDates = response.customerPersonalDetails[0].birth_date;
                        }

                        if (response.customerPersonalDetails[0].marriage_date === null || response.customerPersonalDetails[0].marriage_date === "-0001-11-30 00:00:00") {
                            $scope.customerData.marriage_date = "";
                        } else {
                            var marriage_date = new Date(response.customerPersonalDetails[0].marriage_date);
                            if (marriage_date.getDate() < 10) {
                                $scope.customerData.marriage_date = (marriage_date.getFullYear() + '-' + ("0" + (marriage_date.getMonth() + 1)).slice(-2) + '-' + ("0" + marriage_date.getDate()));
                            } else {
                                $scope.customerData.marriage_date = (marriage_date.getFullYear() + '-' + ("0" + (marriage_date.getMonth() + 1)).slice(-2) + '-' + marriage_date.getDate());
                            }
                        }

                        Data.post('getStates', {
                            data: {countryId: $scope.customerContacts.country_id},
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {

                                $scope.stateList = response.records;
                                $timeout(function () {
                                    $("#current_state_id").val($scope.customerContacts.state_id);
                                    $scope.customerContacts.state_id = angular.copy($scope.customerContacts.state_id);
                                }, 200);
                            }
                        });

                        if ($scope.customerContacts.state_id !== undefined && $scope.customerContacts.state_id !== '0') {
                            Data.post('getCities', {
                                data: {stateId: $scope.customerContacts.state_id},
                            }).then(function (cityresult) {
                                if (!cityresult.success) {
                                    $scope.errorMsg = cityresult.message;
                                } else {
                                    $scope.cityList = cityresult.records;
                                    $timeout(function () {
                                        $("#current_city_id").val($scope.customerContacts.city_id);
                                        $scope.customerContacts.city_id = angular.copy($scope.customerContacts.city_id);
                                    }, 200);
                                }
                            });
                        }
                    }, 350);
                }
            });

        }

        $scope.updateTodayRemarkCustomerModal = function (customerData, customerContacts, customerId, customerPhoto) { //Customer Details tab inseide today remark popup
            var contactArr = [];
            contactArr[0] = customerContacts;

            if (typeof customerPhoto === 'string' || typeof customerPhoto === 'undefined') {
                customerPhoto = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            var url = '/master-sales/' + customerId;
            var data = {_method: "PUT", customerData: customerData, customerContacts: contactArr, image_file: customerPhoto};

            customerPhoto.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data,
            });
            customerPhoto.upload.then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    toaster.pop('success', 'Customer Details', "Record updated successfully");
                    $('#contactDataModal').modal('toggle');
                    return false;
                }
            });
        }

        $scope.text = function () {
            $scope.divText = true;
            $scope.divSms = false;
            $scope.divEmail = false;
            $scope.email_id_arr = $scope.mobile_number = [];
            $scope.remarkData.msgRemark = $scope.remarkData.subject = $scope.remarkData.email_content = '';
            $('.clsMobile').prop("checked", false);
            $('.clsEmail').prop("checked", false);
            $('#footerContent').removeClass("content2");
            $scope.sbtBtn1 = $scope.sbtBtn2 = false;
        };
        $scope.sms = function () {
            $scope.divText = false;
            $scope.divSms = true;
            $scope.divEmail = false;
            $scope.email_id_arr = [];
            $scope.remarkData.textRemark = $scope.remarkData.subject = $scope.remarkData.email_content = '';
            $('.clsEmail').prop("checked", false);
            $('#footerContent').removeClass("content2");
            $scope.sbtBtn2 = $scope.sbtBtn3 = false;
        };
        $scope.email = function () {
            $scope.divText = false;
            $scope.divSms = false;
            $scope.divEmail = true;
            $scope.mobile_number = [];
            $scope.remarkData.msgRemark = $scope.remarkData.textRemark = '';
            $('.clsMobile').prop("checked", false);
            $('#footerContent').addClass("content2");
            $scope.sbtBtn1 = $scope.sbtBtn3 = false;
        };
        /******************************************************************************/
        $scope.editExistingFollowup = false;
        $scope.editRemark = function (enqid, followupId) {
            $timeout(function () {
                $('li#remarkTab a').trigger('click');
            }, 500);
            $("li#historyTab").removeClass("active");
            $("li#remarkTab").addClass("active");
            $scope.editExistingFollowup = true;
            $scope.getTodayRemark(enqid, followupId);
        }
        $scope.getTodayRemark = function (enqid, followupId, sharedemployee) {

            $scope.minDate = new Date();
            $scope.booked = $scope.collected = true;
            
            var time = new Date();
            if (enqid !== '') {
                $scope.pageHeading = 'Today\'\s Remark';
                Data.post('master-sales/getTodayRemark', {
                    enquiryId: enqid, followupId: followupId
                }).then(function (response) {
                    if (!response.success) {
                        $scope.errorMsg = response.message;
                    } else {
                        $scope.addEmail = false;
                        $scope.addMob = false;
                        $scope.remarkData = angular.copy(response.enquiryDetails[0]);
                        $scope.remarkData.customerId = angular.copy(response.enquiryDetails[0].customerId);
                        $scope.userpermissions = angular.copy(response.userpermissions);
                        $scope.displayCallBtn = $scope.userpermissions.indexOf("01403");console.log("=="+$scope.displayCallBtn);
                        $("#custId").val(response.enquiryDetails[0].customerId);
                        
                        if (response.enquiryDetails[0].title_id == 0 || response.enquiryDetails[0].title_id == null) {
                            $scope.remarkData.title_id = '';
                        }
                    
                        $scope.useremail = angular.copy(response.useremail);
                        $scope.userpermissions = angular.copy(response.userpermissions);
                        $scope.displaymobile = $scope.userpermissions.indexOf("01406");
                        $scope.displayemail = $scope.userpermissions.indexOf("01406");
                        $scope.mobileList = response.enquiryDetails.mobileNumber;
                        $scope.emailList = response.enquiryDetails.emailId;
          
                        if($scope.emailList=='null'){
                            $scope.emailList = '';
                        }
                        
                        var source = (response.enquiryDetails[0].sales_source_name == null) ? ' ' : response.enquiryDetails[0].sales_source_name;
                        var subsource = (response.enquiryDetails[0].enquiry_subsource == null) ? ' ' : ' / ' + response.enquiryDetails[0].enquiry_subsource;
                        $scope.sourceDetails = source + subsource;
                        $scope.remarkData.enquiryId = enqid;
                        if (response.enquiryDetails[0].corporate_customer == '1') {
                            $scope.remarkData.corporateCust = true;
                            $scope.isChecked(true);
                        } else {
                            $scope.remarkData.corporateCust = false;
                            $scope.companyInput = false;
                            $scope.remarkData.company_id = 0;
                            $scope.remarkData.company_name = "";
                        }

                        $scope.remarkData.company_id = response.enquiryDetails[0].company_id;
                        $scope.remarkData.company_name = response.enquiryDetails[0].company_name;
                        $scope.customer_area_name = response.enquiryDetails[0].customer_area_name;
                        $scope.customer_address = (response.enquiryDetails[0].customer_address == '') ? '' : response.enquiryDetails[0].customer_address;
                        $scope.remarkData.followup_by_employee_id = {"id": response.enquiryDetails[0].sales_employee_id, "first_name": response.enquiryDetails[0].first_name + " " + response.enquiryDetails[0].last_name};
console.log("next_followup_time"+response.enquiryDetails[0].next_followup_time);
                        if ($scope.editExistingFollowup == true) {
                            $scope.remarkData.textRemark = response.enquiryDetails[0].remarks;
                        }
                        if (response.enquiryDetails[0].sales_status_id == 1) {
                            $scope.remarkData.sales_status_id = "";
                        } else {
                            $scope.remarkData.sales_status_id = response.enquiryDetails[0].sales_status_id;
                        }
                        if (response.enquiryDetails[0].sales_category_id == 1) {
                            $scope.remarkData.sales_category_id = "";
                        } else {
                            $scope.remarkData.sales_category_id = response.enquiryDetails[0].sales_category_id;
                        }

                        var sales_substatus_id = response.enquiryDetails[0].sales_substatus_id;
                        var sales_subcategory_id = response.enquiryDetails[0].sales_subcategory_id;

                        if (d.getDate() < 10) {
                            $scope.remarkData.next_followup_date = (("0" + d.getDate()) + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear());
                            $scope.remarkData.booking_date = (("0" + d.getDate()) + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear());
                        } else {
                            $scope.remarkData.next_followup_date = ((d.getDate()) + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear());
                            $scope.remarkData.booking_date = ((d.getDate()) + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear());
                        }
                        $scope.todayremarkTimeChange(time);
                        
                        Data.post('getSalesEnqSubStatus', {
                            statusId: response.enquiryDetails[0].sales_status_id
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {
                                $scope.salesEnqSubStatusList = response.records;
                                $("#sales_substatus_id").val(sales_substatus_id);
                                $scope.remarkData.sales_substatus_id = angular.copy(sales_substatus_id);
                                
                                if ($scope.remarkData.sales_status_id == '' || $scope.remarkData.sales_substatus_id == 0 || $scope.remarkData.sales_substatus_id == null || $scope.remarkData.sales_substatus_id === undefined) {
                                    $scope.remarkData.sales_substatus_id = "";
                                } else {
                                    $scope.remarkData.sales_substatus_id = angular.copy(sales_substatus_id);
                                }
                            }
                        });
                        
                        if(response.enquiryDetails[0].sales_category_id !== 1){
                            Data.post('getSalesEnqSubCategory', {
                                categoryId: response.enquiryDetails[0].sales_category_id
                            }).then(function (response) {
                                if (!response.success) {
                                    $scope.errorMsg = response.message;
                                } else {
                                    $scope.salesEnqSubCategoryList = response.records;

                                    $scope.remarkData.sales_subcategory_id = angular.copy(sales_subcategory_id);

                                    if ($scope.remarkData.sales_category_id == '' ||$scope.remarkData.sales_subcategory_id == 0 || $scope.remarkData.sales_subcategory_id == null || $("#sales_subcategory_id").val() === undefined) {
                                        $scope.remarkData.sales_subcategory_id = "";
                                    } else {
                                        $("#sales_subcategory_id").val(sales_subcategory_id);
                                        $scope.remarkData.sales_subcategory_id = angular.copy(sales_subcategory_id);
                                    }
                                }
                            });
                        }else{$scope.remarkData.sales_subcategory_id = "";}
                        
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
                        $scope.shared = sharedemployee;
                    }
                });
                $timeout(function () {
                    $scope.remarkData.next_followup_time = '';
                    $("li#remarkTab a").trigger('click');        
                }, 200);
            }
        }

        $scope.bookingId = '';        
        $scope.insertTodayRemark = function (modalData, sharedemployee) {
            if ($scope.editableCustInfo == true) {
                if (modalData.customer_fname == '' && modalData.customer_lname == '') {
                    toaster.pop('error', 'Required', 'Please update customer name');
                    return false;
                }
                var custInfo = {title_id: modalData.title_id, customer_fname: modalData.customer_fname, customer_lname: modalData.customer_lname};
            }
            var data = {enquiry_id: modalData.enquiry_id,
                bookingId: modalData.bookingId,
                customerId: modalData.customerId,
                engine_id: modalData.engine_id,
                followupId: modalData.followupId,
                sales_category_id: modalData.sales_category_id,
                sales_subcategory_id: modalData.sales_subcategory_id,
                company_id: modalData.company_id,
                corporate_customer: modalData.corporateCust,
                company_name: $scope.remarkData.company_name,
                followup_by_employee_id: modalData.followup_by_employee_id,
                next_followup_date: modalData.next_followup_date,
                next_followup_time: modalData.next_followup_time,
                sales_status_id: modalData.sales_status_id,
                sales_substatus_id: modalData.sales_substatus_id,
                sales_lost_reason_id: modalData.sales_lost_reason_id,
                sales_lost_sub_reason_id: modalData.sales_lost_sub_reason_id,
                textRemark: modalData.textRemark,
                mobileNumber: $scope.mobile_number,
                msgRemark: modalData.msgRemark,
                email_id: modalData.email_id,
                email_id_arr: $scope.email_id_arr,
                email_content: modalData.email_content,
                subject: modalData.subject,
                editExistingFollowup: $scope.editExistingFollowup,
                booking: {project_id: $("#project_id").val(),
                    block_id: $("#block_id").val(),
                    sub_block_id: $("#sub_block_id").val(),
                    wing_id: $("#wing_id").val(),
                    booking_date: modalData.booking_date,
                    booked_vehicle_id: modalData.booked_vehicle_id,
                    total_recievable_amount: modalData.total_recievable_amount,
                    booking_status_id: modalData.booking_status_id,
                    booking_confirmation_status_id: modalData.booking_confirmation_status_id,
                    collection_stage_id: modalData.collection_stage_id,
                    collection_amount: modalData.collection_amount,
                    payment_status_id: modalData.payment_status_id,
                }
            };
            $scope.sbtbtndis = true;            
            Data.post('master-sales/insertTodayRemark', {
                data: data, custInfo: custInfo
            }).then(function (response) {
                $scope.sbtbtndis = false;
                if (!response.success) {
                    $scope.errorMsg = response.errorMsg;
                } else {
                    if (modalData.sales_status_id == 3 && response.bookingId != 0) {
                        $("#bookingId").val(response.bookingId);
                        $scope.bookingId = response.bookingId;
                        $scope.booked = false;
                        $scope.collectedTab = true;
                        $timeout(function () {
                            $('li#collectedTab a').trigger('click');
                        }, 500);
                        $("li#bookingTab").removeClass('active');
                        $("li#collectedTab").addClass('active');
                        $('#todayremarkDataModal').modal('toggle');
                        toaster.pop('success', 'Booking Details', response.message);                        
                        if (!angular.equals($scope.filterData, {}) && typeof $scope.filterData !== 'undefined' && $scope.filterData !== '' && Object.keys($scope.filterData).length > 0) {
                            $scope.getFilteredData($scope.filterData, 1, $scope.itemsPerPage);
                            $('#slideout').toggleClass('on');
                        }
                    } else {
                        $('#todayremarkDataModal').modal('toggle');
                        toaster.pop('success', '', response.message);
                        
                        if (!angular.equals($scope.filterData, {}) && typeof $scope.filterData !== 'undefined' && $scope.filterData !== '' && Object.keys($scope.filterData).length > 0) {
                            $scope.getFilteredData($scope.filterData, 1, $scope.itemsPerPage);
                            $('#slideout').toggleClass('on');
                        } else {
                            $state.transitionTo($state.current, $stateParams, {
                                reload: true, //reload current page
                                inherit: false, //if set to true, the previous param values are inherited
                                notify: true //reinitialise object
                            });
                        }
                        $(".modal-backdrop").hide();
                    }
                    if(sharedemployee == true){                        
                        $scope.sharedemployee = angular.copy(sharedemployee);
                        $('#statuschk1').prop('checked', true);
                    }                    
                }
                return false;
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


        /*********************TODAY REMARK (GEETA)*********************/
        /*********************IMPORT ENQUIRIES (GEETA)*********************/
        $scope.ImportEnquiryData = function (importfile) {
            $scope.showhisrtory = false;
            $scope.btnupload = true;

            var url = 'master-sales/importEnquiry';
            var data = {importfile: importfile};
            importfile.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            }).then(function (response, evt) {
                //console.log(response);
                if (response.data.success) {

                    toaster.pop({
                        type: 'success',
                        title: 'Import Enquiries',
                        body: response.data.message,
                        timeout: 3000
                    });
                    $scope.inserted = response.data.inserted;
                    $scope.alredyexist = response.data.alredyexist;
                    $scope.total = response.data.total;
                    $scope.invalidfilecount = response.data.invalidfilecount;
                    $scope.invalidfileurl = response.data.invalidfileurl;
                    $scope.employeeundercount = response.data.return_record_split.split(',');
                    $scope.showhisrtory = true;
                    $timeout(function () {
                        $scope.EnquiryData.importfile = "";
                        $scope.btnupload = false;
                        $scope.sbtBtn = false;
                    }, 500);
                } else {
                    toaster.pop({
                        type: 'error',
                        title: 'Invalid File',
                        body: response.data.message,
                        timeout: 3000
                    });
                    $scope.btnupload = false;
                    $scope.sbtBtn = false;
                }
            });
        }

        $scope.ShowimportHistory = function () {

            Data.post('master-sales/getImportHistory', {}).then(function (response) {
                if (response.success) {
                    $scope.showhistoryList = response.records;
                    //console.log($scope.showhistoryList);
                }
            });
        }

        /*********************IMPORT ENQUIRIES (GEETA)*********************/

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
        Data.post('master-sales/getAllLocations', {city_id: cityId, }).then(function (response) {
            $scope.locations = response.records;
        });
    }
});

app.filter('myDateFormat', function myDateFormat($filter) {
    return function (text) {
        var tempdate = new Date(text.replace(/-/g, "/"));
        return $filter('date')(tempdate, "dd-MM-yyyy");
    }
});

app.filter('removeHTMLTags', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});



$(document).ready(function () {
    $('.toggleForm').click(function () {
        $('#slideout').toggleClass('on');
        if ($(".wrap-filter-form").hasClass("on")) {
            $(".mainDiv").css("opacity", "0.2");
            $(".mainDiv").css("pointer-events", "none");
        } else {
            $(".mainDiv").css("opacity", "");
            $(".mainDiv").css("pointer-events", "visible");
        }
    });
});

