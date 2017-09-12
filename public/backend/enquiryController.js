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
        }

        $scope.changeEmailPrivacyStatus = function (val) {
            $scope.remarkData.email_privacy_status = val;
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

        $scope.initHistoryDataModal = function (enquiry_id) {
            Data.post('master-sales/getEnquiryHistory', {
                enquiryId: enquiry_id,
            }).then(function (response) {
                if (response.success) {
                    $scope.historyList = angular.copy(response.records);
                }
            });
        }
        $scope.exportReport = function (result) {
            Data.post('master-sales/exportToExcel', {result: result, reportName: $scope.report_name.replace(/ /g, "_")}).then(function (response) {
                $("#downloadExcel").attr("href", response.fileUrl);
                $scope.sheetName = response.sheetName;

                $scope.btnExport = false;
                $scope.dnExcelSheet = true;
                //$timeout(function(){
                //angular.element('#downloadExcel').siblings('#exportExcel').trigger('click');
                //window.open($('#downloadExcel').attr('href'),"_blank");
//                  angular.element('#downloadExcel').trigger('click');

                // },500);
            });
        }
        /****************************ENQUIRIES****************************/
        $scope.pageChanged = function (pageNo, functionName, id, type, newpage, listType) {

            $('#all_chk_reassign_enq').prop('checked', false);
            $scope.BulkReasign = false;
            $(".chk_reassign_enq").prop('checked', false);
            $scope.flagForChange++;
            if ($scope.flagForChange == 1)
            {
                if (($scope.filterData && Object.keys($scope.filterData).length > 0) || ($scope.maxBudget > 0)) {
                    $scope.getFilteredData($scope.filterData, pageNo, $scope.itemsPerPage);
                    $('#slideout').toggleClass('on');
                } else {
                    $scope[functionName](id, type, pageNo, $scope.itemsPerPage, listType);
                }
            }
            $scope.pageNumber = pageNo;
        }
        $scope.reassignEnquiries = function (id, type, pageNumber, itemPerPage)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.showloader();
            //$scope.listType = listType;
            if (type == 0) {
                $scope.report_name = "Reassign Enquiries";
                $scope.pagetitle = "My Reassign Enquiries";
            } else {
                $scope.report_name = "Teams Reassign Enquiries";
                $scope.pagetitle = "Team`s Reassign Enquiries ";
            }
            Data.post('master-sales/getReassignEnquiry', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type,
            }).then(function (response) {
                if (response.success) {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                } else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.hideloader();
                $scope.flagForChange = 0;
            });
        }
        $scope.getTotalEnquiries = function (id, type, pageNumber, itemPerPage, listType)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.showloader();
            $scope.listType = listType;
            if (type == 0) {
                $scope.report_name = "Total Enquiries";
                $scope.pagetitle = "My Total Enquiries";
            } else {
                $scope.report_name = "Teams Total Enquiries";
                $scope.pagetitle = "Team`s Total Enquiries ";
            }
            Data.post('master-sales/getTotalEnquiries', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type,
            }).then(function (response) {
                if (response.success) {
                    $scope.enquiries = response.records;
                    $scope.enquiriesLength = response.totalCount;
                } else
                {
                    $scope.enquiries = '';
                    $scope.enquiriesLength = 0;
                }
                $scope.hideloader();
                $scope.flagForChange = 0;
            });
        }

        /****************************ENQUIRIES****************************/

        /****************************FOLLOWUPS****************************/
        $scope.todaysFollowups = function (id, type, pageNumber, itemPerPage, listType)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.listType = listType;
            if (type == 0) {
                $scope.report_name = "Today's Followups";
                $scope.pagetitle = "My Today's Followups";
            } else {
                $scope.report_name = "Team`s Today's Followups";
                $scope.pagetitle = "Team`s Today's Followups";
            }
            Data.post('master-sales/getTodaysFollowups', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type,
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
        }
        $scope.pendingsFollowups = function (id, type, pageNumber, itemPerPage, listType)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.listType = listType;
            if (type == 0) {
                $scope.report_name = "Pending Followups";
                $scope.pagetitle = "My Pending Followups";
            } else {
                $scope.report_name = "Team`s Pending Followups";
                $scope.pagetitle = "Team`s Pending Followups";
            }
            Data.post('master-sales/getPendingFollowups', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type,
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
        }
        $scope.previousFollowups = function (id, type, pageNumber, itemPerPage, listType)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.listType = listType;
            if (type == 0) {
                $scope.report_name = "Previous Followups";
                $scope.pagetitle = "My Previous Followups";
            } else {
                $scope.report_name = "Team`s Previous Followups";
                $scope.pagetitle = "Team`s Previous Followups";
            }
            Data.post('master-sales/previousFollowups', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type,
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
        }
        $scope.lostEnquiries = function (id, type, pageNumber, itemPerPage, listType)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.listType = listType;
            if (type == 0) {
                $scope.report_name = "Lost Enquiries";
                $scope.pagetitle = "My Lost Enquiries";
            } else {
                $scope.report_name = "Team`s Lost Enquiries";
                $scope.pagetitle = "Team`s Lost Enquiries";
            }
            Data.post('master-sales/getLostEnquiries', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type,
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
        }
        $scope.bookedEnquiries = function (id, type, pageNumber, itemPerPage, listType)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.listType = listType;
            if (type == 0) {
                $scope.report_name = "Booked Enquiries";
                $scope.pagetitle = "My Booked Enquiries";
            } else {
                $scope.report_name = "Team`s Booked Enquiries";
                $scope.pagetitle = "Team`s Booked Enquiries";
            }
            Data.post('master-sales/getBookedEnquiries', {
                empId: id, pageNumber: pageNumber, itemPerPage: itemPerPage, teamType: type,
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
        }
        /****************************FOLLOWUPS****************************/
        /****************************FILTER (UMA)***************************************/

        $scope.procName = function (procedureName, functionName) {
            $scope.getProcName = angular.copy(procedureName);
            $scope.getFunctionName = angular.copy(functionName);
        }

        $scope.getFilteredData = function (filterData, page, recordsperpage) {
            Object.keys($scope.filterData).forEach(function (key) {
                if ($scope.filterData[key] == '')
                {
                    delete $scope.filterData[key];
                }
            });
            //$scope.minBudget = $scope.min = minBudget;
            //$scope.maxBudget = $scope.max = maxBudget;
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
            Data.post('master-sales/filteredData', {filterData: filterData, pageNumber: page, itemPerPage: $scope.itemsPerPage, getProcName: $scope.getProcName, teamType: $scope.type}).then(function (response) {
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
            //$scope.showloader();
            if (keyvalue == 'bookingFromDate')
            {
                delete $scope.filterData.bookingToDate;
            }
            delete $scope.filterData[keyvalue];
            $scope.getFilteredData($scope.filterData, 1, 30);
            $('#slideout').toggleClass('on');
            $scope.hideloader();
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
            } else
            {
                $scope.BulkReasign = false;
            }
        }
        $scope.checkAll = function (result) {
            $(':checkbox.chk_reassign_enq').prop('checked', result);
            if (result == true) {
                $scope.BulkReasign = true;

            } else {
                $scope.BulkReasign = false;
            }

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
            //console.log($scope.Bulkflag);return false;
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
                    $scope.documentData = angular.copy(response.records);
                    if (response.records.customer_fname != "" || response.records.customer_lname != "")
                    {
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
                } else
                {
                    $scope.documentListData = {};
                }
            });
        }

        $scope.insertSendDocument = function (documentdata)
        {
            var flag = [];
            $(".chkDocList").each(function (key, value) {
                if ($(this).is(':checked')) {
                    var str = $(this).val();
                    flag.push(str);
                } else {
                }
            });
            $scope.SelectedDocs = flag;
            Data.post('master-sales/insertSendDocument', {documentData: documentdata, isUpdate: $scope.editableCustInfo, sendDocument: $scope.SelectedDocs, enquiry_id: $rootScope.enquiryId, }).then(function (response) {
                    if(response.success)
                    {
                        toaster.pop('success', 'Sent Documents', "Document Sent successfully");
                        $(".sendDocumentDataModal").hide('fast');
                        $state.reload();
                    }
                    else
                    {
                        toaster.pop('error', 'Sent Documents', "Error While Document Sent");
                    }
            });
        }
        $scope.sendingList = function ()
        {
            Data.post('master-sales/sendDocList', {enquiry_id: $rootScope.enquiryId, }).then(function (response) {
                if (response.success)
                {
                    $scope.sendList = response.records;
                    for(var i = 0 ;i < $scope.sendList.length ; i++)
                    {
                        $scope.sendList[i].send_documents = JSON.parse($scope.sendList[i].send_documents);
//                        for(j=0 ; j< $scope.sendList[i].send_documents.length ; j++){
//                            console.log($scope.sendList[i].send_documents[j]);
//                        }                             
                
                    }
                   
                } else
                {
                    $scope.sendList = [];
                    $scope.sendList.len = 0;
                }
            });
        }
        $scope.openImage = function(foldername,imagename)
        {
            window.open('https://storage.googleapis.com/bkt_bms_laravel/project/'+foldername+'/'+imagename+'');
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
            if (name != null && name != '') {
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
                console.log($scope.remarkData.company_id);
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
                $scope.divEmail = false;
                $scope.divSms = false;
                $scope.divText = true;
            } else {
                $(".checkLost").show();
                $scope.divText = true;
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
                        if (response.customerPersonalDetails[0].birth_date === null || response.customerPersonalDetails[0].birth_date === "-0001-11-30 00:00:00") {
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
        $scope.getTodayRemark = function (enqid, followupId) {
            $scope.minDate = new Date();
            $scope.booked = $scope.collected = true;
            var time = new Date();
            if (enqid !== '') {
                $scope.pageHeading = 'Today`s Remark';
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
                        $("#custId").val(response.enquiryDetails[0].customerId);
                        if (response.enquiryDetails[0].title_id == 0 || response.enquiryDetails[0].title_id == null) {
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
                        $scope.userpermissions = angular.copy(response.userpermissions);
//                        $scope.displaymobile = $scope.userpermissions.indexOf("1602");
//                        $scope.displayemail = $scope.userpermissions.indexOf("1601");
                        $scope.mobileList = response.enquiryDetails.mobileNumber;
                        $scope.emailList = response.enquiryDetails.emailId;
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
                        $scope.remarkData.followup_by = {"id": response.enquiryDetails[0].sales_employee_id, "first_name": response.enquiryDetails[0].first_name + " " + response.enquiryDetails[0].last_name};

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

                        Data.post('getSalesEnqSubStatus', {
                            statusId: response.enquiryDetails[0].sales_status_id
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {
                                $scope.salesEnqSubStatusList = response.records;
                                $("#sales_substatus_id").val(sales_substatus_id);
                                $scope.remarkData.sales_substatus_id = angular.copy(sales_substatus_id);

                                if ($scope.remarkData.sales_substatus_id == 0 || $scope.remarkData.sales_substatus_id == null || $scope.remarkData.sales_substatus_id === undefined) {
                                    $scope.remarkData.sales_substatus_id = "";
                                } else {
                                    $scope.remarkData.sales_substatus_id = angular.copy(sales_substatus_id);
                                }
                            }
                        });

                        Data.post('getSalesEnqSubCategory', {
                            categoryId: response.enquiryDetails[0].sales_category_id
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {

                                $scope.salesEnqSubCategoryList = response.records;
                                if ($scope.remarkData.sales_subcategory_id == 0 || $scope.remarkData.sales_subcategory_id == null || $("#sales_subcategory_id").val() === undefined) {
                                    $scope.remarkData.sales_subcategory_id = "";
                                } else {
                                    $("#sales_subcategory_id").val(sales_subcategory_id);
                                    $scope.remarkData.sales_subcategory_id = angular.copy(sales_subcategory_id);
                                }
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
        /*$scope.getTodayRemark = function (enquiryId, followupId, customerId) {
         Data.post('master-sales/getTodayRemark', {enquiryId: enquiryId}).then(function (response) {
         if (!response.success) {
         $scope.errorMsg = response.errorMsg;
         } else {
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
         }, 500);
         if ($scope.remarkData.customer_fname !== '') {
         $scope.custInfo = true;
         $scope.editableCustInfo = false;
         } else {
         $scope.custInfo = false;
         $scope.editableCustInfo = true;
         }
         if ($scope.remarkData.sales_source_id !== '' || $scope.remarkData.sales_source_id !== 0) {
         $scope.source = false;
         } else {
         $scope.source = true;
         }
         $scope.enquiryId = enquiryId;
         $scope.followupId = followupId;
         $scope.customerId = customerId;
         
         Data.post('getSalesEnqSubCategory', {categoryId: response.data[0].sales_category_id}).then(function (response) {
         if (!response.success) {
         $scope.errorMsg = response.message;
         } else {
         $scope.salesEnqSubCategoryList = response.records;
         }
         });
         Data.post('getSalesEnqSubStatus', {statusId: response.data[0].sales_status_id}).then(function (response) {
         if (!response.success) {
         $scope.errorMsg = response.message;
         } else {
         $scope.salesEnqSubStatusList = response.records;
         }
         });
         }
         });
         }*/

        /* $scope.insertRemark = function (modalData) {
         if ($scope.editableCustInfo === true) {
         var custInfo = {title_id: modalData.title_id, customer_fname: modalData.customer_fname, customer_lname: modalData.customer_lname};
         }
         if ($scope.source === true) {
         var sourceInfo = {source_id: modalData.source_id, sales_subsource_id: modalData.sales_subsource_id, sales_source_description: modalData.sales_source_description, };
         }
         
         var data = {enquiry_id: $scope.enquiryId,
         followupId: $scope.followupId,
         customerId: $scope.customerId,
         sales_category_id: modalData.sales_category_id,
         sales_subcategory_id: modalData.sales_subcategory_id,
         followup_by_employee_id: modalData.followup_by_employee_id,
         next_followup_date: modalData.next_followup_date,
         next_followup_time: modalData.next_followup_time,
         sales_status_id: modalData.sales_status_id,
         sales_substatus_id: modalData.sales_substatus_id,
         project_id: modalData.project_id,
         block_id: modalData.block_id,
         title_id: modalData.title_id,
         first_name: modalData.first_name,
         last_name: modalData.last_name,
         source_id: modalData.source_id,
         subsource_id: modalData.subsource_id,
         source_description: modalData.source_description,
         textRemark: modalData.textRemark,
         mobileNumber: $scope.mobile_number,
         msgRemark: modalData.msgRemark,
         email_id: modalData.email_id,
         email_id_arr: $scope.email_id_arr,
         email_content: modalData.email_content,
         subject: modalData.subject
         };
         
         Data.post('master-sales/insertTodayRemark', {data: data, custInfo: custInfo, sourceInfo: sourceInfo}).then(function (response) {
         if (!response.success) {
         $scope.errorMsg = response.errorMsg;
         } else {
         $('#todaysRemarkModal').modal('toggle');
         toaster.pop('success', '', response.message);
         }
         });
         };*/

        $scope.bookingId = '';
        $scope.insertTodayRemark = function (modalData) {
            if ($scope.editableCustInfo == true) {
                if (modalData.customer_fname == '' && modalData.customer_lname == '') {
                    toaster.pop('error', 'Required', 'Please update customer name');
                    return false;
                }
                var custInfo = {title_id: modalData.title_id, customer_fname: modalData.customer_fname, customer_lname: modalData.customer_lname};
            }
            var str = modalData.next_followup_time.toString();
            var splitTime = str.split(" ");

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
                followup_by: modalData.followup_by,
                next_followup_date: modalData.next_followup_date,
                next_followup_time: splitTime[4],
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
                        toaster.pop('success', 'Booking Details', response.message);
                    } else {
                        $('#todayremarkDataModal').modal('toggle');
                        toaster.pop('success', '', response.message);
                        /*if (typeof $scope.filterData !== 'undefined') {
                         $scope.getFilteredData($scope.filterData, 1, $scope.itemsPerPage);
                         } else {*/

                        $state.transitionTo($state.current, $stateParams, {
                            reload: true, //reload current page
                            inherit: false, //if set to true, the previous param values are inherited
                            notify: true //reinitialise object
                        });
//                        }
                        $(".modal-backdrop").hide();
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

        $scope.getModulesWiseHistory = function (enquiry_id, opt, htype)
        {
            /*
             * htype =  1 for the enquiryhistory popup
             * htype = 2 for the todayremark popup
             * 
             */

            var modules = new Array();
            if (opt == 1)
            {
                if ($('#chk_enquiry_history').is(":checked"))
                {
                    $(':checkbox.chk_followup_history_all').prop('checked', true);
                } else
                {
                    $(':checkbox.chk_followup_history_all').prop('checked', false);
                }
            }

            $(".chk_followup_history_all").each(function () {

                if ($(this).is(":checked"))
                {
                    modules.push($(this).data("id"))
                }
            });

            if (modules.length == 2)
            {
                $(':checkbox#chk_enquiry_history').prop('checked', true);
            } else
            {
                $(':checkbox#chk_enquiry_history').prop('checked', false);
            }

            $scope.gethisotryDataModal(enquiry_id, modules, htype)
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

