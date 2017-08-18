app.controller('enquiryController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', 'toaster', '$filter', '$stateParams', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $window, toaster, $filter, $stateParams) {
        $scope.projectsDetails = [];
        $scope.searchData = {};
        $scope.filterData = {};
        $scope.tempFilterData = {};
        $scope.listsIndex = {};
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
        $scope.salesEnqSubCategoryList = [];
        $scope.getProcName = $scope.type = $scope.getFunctionName = '';
        $scope.flagForChange = 0;
        $scope.minBudget = $scope.maxBudget = 0;
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
            Data.post('master-sales/exportToExcel', {result: result, reportName: $scope.pageHeading.replace(/ /g, "_")}).then(function (response) {
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
        $scope.pageChanged = function (pageNo, functionName, id, type, newpage) {
            $scope.flagForChange++;
            if ($scope.flagForChange == 1)
            {
                if (($scope.filterData && Object.keys($scope.filterData).length > 0) || ($scope.maxBudget > 0)) {
                    $scope.getFilteredData($scope.filterData, $scope.minBudget, $scope.maxBudget, pageNo, $scope.itemsPerPage);
                } else {
                    $scope[functionName](id, type, pageNo, $scope.itemsPerPage);
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
        $scope.getTotalEnquiries = function (id, type, pageNumber, itemPerPage)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            $scope.showloader();
            //$scope.listType = listType;
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
        $scope.todaysFollowups = function (id, type, pageNumber, itemPerPage)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            //$scope.listType = listType;
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
        $scope.pendingsFollowups = function (id, type, pageNumber, itemPerPage)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            //$scope.listType = listType;
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
        $scope.previousFollowups = function (id, type, pageNumber, itemPerPage)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            //$scope.listType = listType;
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
        $scope.lostEnquiries = function (id, type, pageNumber, itemPerPage)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            //$scope.listType = listType;
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
        $scope.bookedEnquiries = function (id, type, pageNumber, itemPerPage)
        {
            $scope.itemsPerPage = itemPerPage;
            $scope.type = type;
            //$scope.listType = listType;
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
        $scope.hstep = 1;
        $scope.mstep = 15;
        $scope.enquiryId = $scope.followupId = $scope.customerId = '';

        $scope.text = function () {
            $scope.divText = true;
            $scope.divSms = false;
            $scope.divEmail = false;
            $scope.email_id_arr = $scope.mobile_number = [];
            $scope.remarkData.msgRemark = $scope.remarkData.subject = $scope.remarkData.email_content = '';
            $('.clsMobile').prop("checked", false);
            $('.clsEmail').prop("checked", false);
            $scope.sbtBtn1 = $scope.sbtBtn2 = false;
        }
        $scope.sms = function () {
            $scope.divText = false;
            $scope.divSms = true;
            $scope.divEmail = false;
            $scope.email_id_arr = [];
            $scope.remarkData.textRemark = $scope.remarkData.subject = $scope.remarkData.email_content = '';
            $('.clsEmail').prop("checked", false);
            $scope.sbtBtn2 = $scope.sbtBtn3 = false;
        }
        $scope.email = function () {
            $scope.divText = false;
            $scope.divSms = false;
            $scope.divEmail = true;
            $scope.mobile_number = [];
            $scope.remarkData.msgRemark = $scope.remarkData.textRemark = '';
            $('.clsMobile').prop("checked", false);
            $scope.sbtBtn1 = $scope.sbtBtn3 = false;
        }

        $scope.todayRemark = function (enquiryId, followupId, customerId) {
            Data.post('master-sales/getDataForTodayRemark', {enquiryId: enquiryId}).then(function (response) {
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

        $scope.checkedMobileNo = function (mobileNo, inc) {
            if ($('#mob_' + inc).is(':checked')) {
                $scope.mobile_number.push(mobileNo);
            } else {
                var mobIndex = $scope.mobile_number.indexOf(mobileNo);
                if (mobIndex > -1) {
                    $scope.mobile_number.splice(mobIndex, 1);
                }
            }
        }
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
        $scope.insertRemark = function (modalData) {
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
        };


        /**************************Budget Range Bar*************************/
        $scope.min = 0;
        $scope.max = 0;
        $scope.visSlider = {
            options: {
                floor: 200000,
                ceil: 20000000,
                step: 1
            }
        };

        $scope.rangeValidateMin = function (minVal) {
            if (typeof minVal == 'undefined' || minVal < 200000) {
                $scope.min = 200000;
            } else if (minVal > 20000000) {
                $scope.min = 20000000;
            } else if (minVal > $scope.max) {
                $scope.min = $scope.max;
            }
        }
        $scope.rangeValidateMax = function (maxVal) {
            if (typeof maxVal == 'undefined' || maxVal > 20000000) {
                $scope.max = 20000000;
            } else if (maxVal < 200000) {
                $scope.max = $scope.min;
            } else if (maxVal < $scope.min) {
                $scope.max = $scope.min;
            }

        }
        /**************************Budget Range Bar*************************/

        $scope.procName = function (procedureName, functionName) {
            $scope.getProcName = angular.copy(procedureName);
            $scope.getFunctionName = angular.copy(functionName);
        }
        $scope.getFilteredData = function (filterData, minBudget, maxBudget, page, recordsperpage)
        {
            Object.keys($scope.filterData).forEach(function (key) {
                if ($scope.filterData[key] == '')
                {
                    delete $scope.filterData[key];
                }
            });
            $scope.minBudget = $scope.min = minBudget;
            $scope.maxBudget = $scope.max = maxBudget;
            $scope.showloader();
            if (typeof filterData.fromDate !== 'undefined') {
                var fdate = new Date(filterData.fromDate);
                $scope.filterData.fromDate = (fdate.getFullYear() + '-' + ("0" + (fdate.getMonth() + 1)).slice(-2) + '-' + fdate.getDate());
            } else if (typeof filterData.toDate !== 'undefined') {
                var tdate = new Date(filterData.toDate);
                $scope.filterData.toDate = (tdate.getFullYear() + '-' + ("0" + (tdate.getMonth() + 1)).slice(-2) + '-' + tdate.getDate());
            }
            Data.post('master-sales/filteredData', {filterData: filterData, minBudget: minBudget, pageNumber: page, itemPerPage: $scope.itemsPerPage, maxBudget: maxBudget, getProcName: $scope.getProcName, teamType: $scope.type}).then(function (response) {
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
            $scope.showloader();


            if (keyvalue === 'min')
            {
                $scope.minBudget = $scope.min = $scope.maxBudget = $scope.max = maxBudget = 0;
                $scope.min = 0;
                $scope.max = 0;
            }
            delete $scope.filterData[keyvalue];
            $scope.getFilteredData($scope.filterData, $scope.min, $scope.max, 1, 30);
            $scope.hideloader();
            return false;
        }

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


app.filter('split', function () {
    return function (input, splitChar, splitIndex) {
        // do some bounds checking here to ensure it has that index
        return input.split(splitChar)[splitIndex];
    }
});

$(document).ready(function () {
    $('.toggleForm').click(function () {
        alert("hi");
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