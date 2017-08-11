'use strict';
app.controller('cloudtelephonyController', ['$scope', 'Data', '$filter', 'Upload', '$window', '$timeout', '$state', '$rootScope', 'toaster', function ($scope, Data, $filter, Upload, $window, $timeout, $state, $rootScope, toaster) {
        $scope.pageHeading = 'Virtual Number';
        $scope.registrationData = {};
        $scope.registrationData.client = "";
        $scope.registrationData.incoming_call_status = '1';
        $scope.registrationData.outbound_call_status = '0';
        $scope.registrationData.incoming_pulse_duration = '60';
        $scope.registrationData.outbound_pulse_duration = '60';
        $scope.registrationData.rent_duration = '1';
        $scope.registrationData.default_number = false;
        $scope.itemsPerPage = 30;
        $scope.cls;
        $scope.virtualno;
        /* Export excel  */
        $scope.btnExport = true;
        $scope.dnExcelSheet = false;
        $scope.report_name;
        $scope.filterData = {};
        /*export Excel*/
        $scope.registrationData.id = $scope.registrationData.forwarding_type_id = '';
        $scope.pageNumber = 1;

        $scope.pageChanged = function (pageNo, functionName, id) {
            if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
                $scope.filteredData($scope.filterData, pageNo, $scope.itemsPerPage);
            } else {
                $scope[functionName](id, pageNo, $scope.itemsPerPage);
            }
            $scope.pageNumber = pageNo;
        }

        $scope.registrationNumber = function (registrationData) {
            var date = new Date($scope.registrationData.activation_date);
            $scope.registrationData.activation_date = (date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
            $scope.submitted = true;
            
            Data.post('cloudtelephony', {
                data: {registrationData: registrationData},
            }).then(function (response, evt) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.registrationData = {};
                    $scope.registrationData.incoming_call_status = '1';
                    $scope.registrationData.outbound_call_status = '0';
                    $scope.registrationData.incoming_pulse_duration = '60';
                    $scope.registrationData.outbound_pulse_duration = '60';
                    $scope.registrationData.rent_duration = '1';
                    $scope.step1 = false;   
                    toaster.pop('success', '',response.message);
                    $timeout(function () {                        
                        $state.go('numbersIndex');
                    }, 1000);
                }
            });

        };

        $scope.createExtNumber = function (extData1, welcomeTuneAudio, mscwelcomeTuneAudio, ct_settings_id) {
            $scope.submitted = true;
            extData1.ct_settings_id = ct_settings_id;

            if (extData1.msc_facility_status == true) {
                extData1.msc_facility_status = 1;
            } else {
                extData1.msc_facility_status = 0;
            }
            if (extData1.id == "" || extData1.id == 0)
            {
                var url = '/extensionmenu';
                var data = {extData1: extData1, welcomeTuneAudio: welcomeTuneAudio, mscwelcomeTuneAudio: mscwelcomeTuneAudio};
                welcomeTuneAudio.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                }).then(function (response, evt) {
                    $timeout(function () {
                        $scope.manageextLists(extData1.ct_settings_id, 'view');
                        if (response.data.success == true) {
                            $scope.extData1 = {};
                            document.getElementById('welcomeaudio').src = "";
                            document.getElementById('mscaudio').src = "";
                            document.getElementById('holdaudio').src = "";
                            $scope.extData1.msc_facility_status = '0';
                            $scope.extData1.msc_employee_type = '0';
                            $scope.step2 = false;
                            toaster.pop('success', 'Extension menu setting added successfully');
                            $timeout(function () {
                                $state.go('extensionMenu');
                            }, 1000);
                        } else {
                            toaster.pop('success', 'Something went wrong please try again');
                            $timeout(function () {
                                $state.go('extensionMenu');
                            }, 1000);
                        }

                    });
                });
            } else if (extData1.id > 0) {
                var url = '/extensionmenu/' + extData1.id;
                var data = {_method: 'PUT', extData1: extData1, welcomeTuneAudio: welcomeTuneAudio, mscwelcomeTuneAudio: mscwelcomeTuneAudio};
                welcomeTuneAudio.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                }).then(function (response, evt) {
                    $timeout(function () {
                        $scope.manageextLists(extData1.ct_settings_id, 'view');
                        if (response.data.success == true) {
                            document.getElementById('welcomeaudio').src = "";
                            document.getElementById('mscaudio').src = "";
                            document.getElementById('holdaudio').src = "";
                            $scope.extData1 = {};
                            $scope.extData1.msc_facility_status = '0';
                            $scope.extData1.msc_employee_type = '0';
                            $scope.step2 = false;

                            toaster.pop('success', 'Extension menu setting updated successfully');
                            $timeout(function () {
                                $state.go('extensionMenu');
                            }, 1000);
                        } else {
                            toaster.pop('success', 'Something went wrong please try again');
                            $timeout(function () {
                                $state.go('extensionMenu');
                            }, 1000);
                        }
                    });
                });
            }
        }

        $scope.updateVirtualNumber = function (vnumberData, welcomeTuneAudio, holdTuneAudio) {
            if (vnumberData.menu_status == true) {
                vnumberData.menu_status = 1;
            } else {
                vnumberData.menu_status = 0;
                if (vnumberData.employees1.length === 0) {
                    $scope.emptyEmployees = true;
                    $scope.applyClassEmployee = 'ng-active';
                    return false;
                } else {
                    $scope.emptyEmployees = false;
                    $scope.applyClassEmployee = 'ng-inactive';
                }
            }

            if (vnumberData.missed_call_insert_enquiry == true) {
                vnumberData.missed_call_insert_enquiry = 1;
            } else {
                vnumberData.missed_call_insert_enquiry = 0;
            }
            $scope.submitted = true;
            var url = '/virtualnumber';
            var data = {vnumberData: vnumberData, welcomeTuneAudio: welcomeTuneAudio, holdTuneAudio: holdTuneAudio};
            welcomeTuneAudio.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            }).then(function (response, evt) {
                $timeout(function () {
                    if (vnumberData.menu_status == 0) {
                        toaster.pop('success', 'New Customer Setting Updated Successfully');
                        $timeout(function () {

                            $state.go('existingUpdate', {'id': vnumberData.id});
                        }, 1000);

                    } else {
                        toaster.pop('success', 'New Customer Setting Updated Successfully');
                        $timeout(function () {
                            $state.go('extensionMenu', {'id': vnumberData.id});
                        }, 1000);
                    }
                });

            });
        }

        $scope.updateNonWorkingSetting = function (nonworkingData, thankyouTuneAudio) {

            var url = '/virtualnumber/updateNonworkinghours';
            var data = {nonworkingData: nonworkingData, thankyouTuneAudio: thankyouTuneAudio};
            thankyouTuneAudio.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            }).then(function (response, evt) {
                $timeout(function () {
                    if (response.data.success == true)
                        toaster.pop('success', 'Non Working Hours Setting Updated Successfully');
                    $timeout(function () {
                        $state.go('virtualnumberslist');
                    }, 1000);
                });
            });
        }

        $scope.extesionstep = function (menustatus, id) {
            if (menustatus == true) {
                var vnumberId = id;
                $state.go('extensionMenu', {'id': vnumberId});
            }
        }

        $scope.newcustomerstep = function (id) {
            if (id != '') {
                var vnumberId = id;
                $state.go('vnumberUpdate', {'id': vnumberId});
            }
        }

        $scope.existingcustomerstep = function (id) {
            if (id != '') {
                var vnumberId = id;
                $state.go('existingUpdate', {'id': vnumberId});
            }
        }

        $scope.nonworkinghoursstep = function (id) {
            if (id != '') {
                var vnumberId = id;
                $state.go('nonworkingUpdate', {'id': vnumberId});
            } else {
                console.log('Id blank');
            }
        }

        $scope.updateExisting = function (vnumberData, welcomeTuneAudio, holdTuneAudio) {

            $scope.submitted = true;
            var url = '/virtualnumber/' + vnumberData.id;
            var data = {_method: 'PUT', vnumberData: vnumberData, welcomeTuneAudio: welcomeTuneAudio, holdTuneAudio: holdTuneAudio};
            welcomeTuneAudio.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            }).then(function (response, evt) {
                $timeout(function () {
                    if (response.data.success == true)
                        toaster.pop('success', 'Existing Customer Setting Updated Successfully');
                    $timeout(function () {
                        $state.go('nonworkingUpdate', {'id': vnumberData.id});
                    }, 1000);
                });

            });
        }

        $scope.outboundStatus = function () {
            if ($scope.registrationData.outbound_call_status == '0') {
                $scope.registrationData.outbound_call_status = '1';
                $scope.registrationData.default_number = true;
            } else {
                $scope.registrationData.outbound_call_status = '0';
                $scope.registrationData.default_number = false;
            }
        };

        $scope.menuStatus = function () {
            if ($scope.registrationData.welcome_tune_type_id <= '1') {
                $scope.registrationData.menu_status = false;
            }
        };

        $scope.manageLists = function (id, action) { //edit/index page
            Data.post('cloudtelephony/manageLists', {
                id: id,
            }).then(function (response) {
                if (response.success) {
                    if (action === 'index') {

                        $scope.listNumbers = response.records.data;
                        $scope.listNumbersLength = response.records.total;
                        $scope.currentPage = 1;
                        $scope.itemsPerPage = 30;
                    } else if (action === 'edit') {
                        if (id !== '0') {
                            $scope.pageHeading = 'Edit Number';
                            $timeout(function () {
                                //alert(response.records.data[0]['default_number']);return false;
                                if (response.records.data[0]['default_number'] == 1) {
                                    response.records.data[0]['default_number'] = true;
                                } else {
                                    response.records.data[0]['default_number'] = false;
                                }
                                $scope.registrationData = angular.copy(response.records.data[0]);
                                if ($scope.registrationData.menu_status)
                                    $scope.cls = 'active';
                                else
                                    $scope.cls = '';
                            }, 500);
                        }
                    } else {
                        $scope.registrationData.id = id;
                    }
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        };

        $scope.managevLists = function (id, action) { //edit/index page
            Data.post('virtualnumber/manageLists', {
                id: id,
                action: action
            }).then(function (response) {
                if (response.success) {

                    if (action === 'index') {

                        $scope.listNumbers = response.records.data;
                        $scope.listNumbersLength = response.records.total;
                        $scope.currentPage = 1;
                        $scope.itemsPerPage = 30;
                    } else if (action === 'edit') {
                        if (id !== '0') {
                            $scope.pageHeading = 'Update New Customer Setting For Virtual Number';

                            $timeout(function () {

                                if (response.records.data[0]['default_number'] == 1) {
                                    response.records.data[0]['default_number'] = true;
                                } else {
                                    response.records.data[0]['default_number'] = false;
                                }
                                if (response.records.data[0]['missed_call_insert_enquiry'] == 1) {
                                    response.records.data[0]['missed_call_insert_enquiry'] = true;
                                } else {
                                    response.records.data[0]['missed_call_insert_enquiry'] = false;
                                }
                                if (response.records.data[0]['menu_status'] == 1) {
                                    response.records.data[0]['menu_status'] = true;
                                } else {
                                    response.records.data[0]['menu_status'] = false;
                                }

                                var srcurl = response.s3Path + "/caller_tunes/";//"https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/caller_tunes/";

                                $scope.registrationData = angular.copy(response.records.data[0]);

                                $scope.virtualno = $scope.registrationData.virtual_display_number;
                                ;

                                if ($scope.registrationData.menu_status)
                                    $scope.cls = 'active';
                                else
                                    $scope.cls = '';

                                if ($scope.registrationData.welcome_tune_type_id == 3) {
                                    $scope.welcome_url = srcurl + $scope.registrationData.welcome_tune;
                                    document.getElementById('welcomeaudio').src = $scope.welcome_url;
                                }
                                if ($scope.registrationData.hold_tune_type_id == 3) {
                                    $scope.hold_url = srcurl + $scope.registrationData.hold_tune;
                                    document.getElementById('holdaudio').src = $scope.hold_url;
                                }

                                Data.post('virtualnumber/getEmployeelist', {
                                    ids: response.records.data[0]['employees'],
                                }).then(function (response) {

                                    $scope.registrationData.employees1 = response.records;
                                });


                                Data.post('virtualnumber/getEmployeelist', {
                                    ids: response.records.data[0]['msc_default_employee_id'],
                                }).then(function (response) {

                                    $scope.registrationData.msc_default_employee_id = response.records;
                                });

                                var current_salesource_id = $scope.registrationData.source_id;
                                Data.post('getEnquirySubSource', {
                                    data: {sourceId: current_salesource_id},
                                }).then(function (response) {
                                    if (!response.success) {
                                        $scope.errorMsg = response.message;
                                    } else {
                                        $scope.subSourceList = response.records;
                                    }
                                });
                            }, 500);
                        }
                    } else if (action === 'existingedit') {
                        $scope.pageHeading = 'Update Existing Customer Setting For Virtual Number';

                        $scope.registrationData = angular.copy(response.records.data[0]);
                        $scope.virtualno = $scope.registrationData.virtual_display_number;

                        if ($scope.registrationData.menu_status)
                            $scope.cls = 'active';
                        else
                            $scope.cls = '';

                        var srcurl = response.s3Path + "/caller_tunes/";//"https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/caller_tunes/";

                        $scope.registrationData = angular.copy(response.records.data[0]);
                        if ($scope.registrationData.ec_welcome_tune_type_id == 3) {
                            $scope.welcome_url = srcurl + $scope.registrationData.ec_welcome_tune;
                            document.getElementById('ecwelcomeaudio').src = $scope.welcome_url;
                        }
                        if ($scope.registrationData.hold_tune_type_id == 3) {
                            $scope.hold_url = srcurl + $scope.registrationData.ec_hold_tune;
                            document.getElementById('echoldaudio').src = $scope.hold_url;
                        }
                    } else {
                        $scope.registrationData.id = id;
                    }
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        };

        $scope.managenonworkingLists = function (id, action) { //edit/index page
            Data.post('virtualnumber/manageLists', {
                id: id,
                action: action
            }).then(function (response) {
                if (response.success) {

                    if (action === 'index') {
                        $scope.listNumbers = response.records.data;
                        $scope.listNumbersLength = response.records.total;
                        $scope.currentPage = 1;
                        $scope.itemsPerPage = 30;
                    } else if (action === 'editnonworking') {
                        if (id !== '0') {

                            $scope.pageHeading = 'Update Non Working Hours Setting For Virtual Number';

                            $timeout(function () {
                                var srcurl = response.s3Path + "/caller_tunes/";//"https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/caller_tunes/";

                                $scope.registrationData = angular.copy(response.records.data[0]);

                                $scope.virtualno = $scope.registrationData.virtual_display_number;

                                if ($scope.registrationData.menu_status)
                                    $scope.cls = 'active';
                                else
                                    $scope.cls = '';

                                if ($scope.registrationData.nwh_welcome_tune_type_id == 3) {
                                    $scope.nwh_url = srcurl + $scope.registrationData.nwh_welcome_tune;
                                    document.getElementById('nwhaudio').src = $scope.nwh_url;
                                }


                            }, 500);
                        }
                    }
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        };

        $scope.manageextLists = function (id, action) {
            Data.post('extensionmenu/manageextLists', {
                id: id,
            }).then(function (response) {
                if (response.success) {
                    $scope.extnumber1 = [];
                    $scope.ext_number = [];
                    if (action === 'view') {
                        $scope.pageHeading = 'Update Extension Setting For Virtual Number';
                        $scope.listNumbers = response.records.data;
                        console.log($scope.listNumbers);
                        $scope.listNumbersLength = response.records.total;

                        for (i = 0; i < $scope.listNumbersLength; i++) {
                            $scope.ext = $scope.listNumbers[i].ext_number;
                            $scope.extnumber1.push($scope.ext);
                        }
                        $scope.user1 = [1, 2, 3, 4, 5, 6, 7, 8, 9];
                        $scope.ext_number = $scope.user1.filter(function (num) {
                            if ($scope.extnumber1.indexOf(num) === -1)
                                return 'Ext ' + num;
                        });
                        $scope.virtualno = response.records.virtualno;
                        $scope.currentPage = 1;
                        $scope.itemsPerPage = 30;
                    }
                } else {
                    $scope.ext_number = [1, 2, 3, 4, 5, 6, 7, 8, 9];
                    $scope.errorMsg = response.message;
                    $scope.virtualno = response.virtualno;
                }
            });
        };


        $scope.manageextUpdate = function (id, action) {
            Data.post('extensionmenu/manageextUpdate', {
                id: id,
            }).then(function (response) {
                if (response.success) {
                    $scope.extnumber1 = [];
                    $scope.ext_number = [];
                    if (action === 'edit') {
                        $scope.extData1 = angular.copy(response.records.data[0]);
                        console.log($scope.extData1);
                        for (i = 0; i < $scope.listNumbersLength; i++) {
                            $scope.ext = $scope.listNumbers[i].ext_number;
                            $scope.extnumber1.push($scope.ext);
                        }
                        $scope.user1 = [1, 2, 3, 4, 5, 6, 7, 8, 9];
                        $scope.ext_number = $scope.user1.filter(function (num) {
                            if ($scope.extnumber1.indexOf(num) === -1)
                                return 'Ext ' + num;
                        });
                        $scope.ext_number.unshift($scope.extData1.ext_number);

                        var srcurl = response.s3Path + "/caller_tunes/";//"https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/caller_tunes/";
                        if ($scope.extData1.welcome_tune_type_id == 3) {
                            $scope.welcome_url = srcurl + $scope.extData1.welcome_tune;
                            document.getElementById('welcomeaudio').src = $scope.welcome_url;
                        }
                        if ($scope.extData1.hold_tune_type_id == 3) {
                            $scope.hold_url = srcurl + $scope.extData1.hold_tune;
                            document.getElementById('holdaudio').src = $scope.hold_url;
                        }

                        if ($scope.extData1.msc_welcome_tune_type_id == 3) {
                            $scope.msc_url = srcurl + $scope.extData1.msc_welcome_tune;
                            document.getElementById('mscaudio').src = $scope.msc_url;
                        }

                        if ($scope.extData1.msc_facility_status == 1) {
                            $scope.extData1.msc_facility_status = true;
                        } else {
                            $scope.extData1.msc_facility_status = false;
                        }

                        var current_salesource_id = $scope.extData1.source_id;
                        Data.post('getEnquirySubSource', {
                            data: {sourceId: current_salesource_id},
                        }).then(function (response) {
                            if (!response.success) {
                                $scope.errorMsg = response.message;
                            } else {
                                $scope.subSourceList = response.records;
                            }
                        });
                        Data.post('extensionmenu/getEmployeelist', {
                            ids: response.records.data[0]['employees'],
                        }).then(function (response) {
                            $scope.extData1.employees1 = response.records;
                        });
                    }
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        };

        $scope.inboundLists = function (empId, pageNumber, itemPerPage) {
            $scope.report_name = "Inbound Logs";
            Data.post('cloudcallinglogs/myInboundLogs', {
                id: empId, pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                if (response.success) {
                    $scope.inboundList = response.records;
                    $scope.inboundLength = response.totalCount;
                    $timeout(function () {
                        for (i = 0; i < $scope.inboundList.length; i++) {
                            if ($scope.inboundList[i].customer_call_status == "Connected") {
                                document.getElementById("object_" + $scope.inboundList[i].id).src = $scope.inboundList[i].call_recording_url;
                            }
                        }
                    }, 1000);
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        };

        $scope.setAudio = function () {
            $timeout(function () {
                for (i = 0; i < $scope.inboundList.length; i++) {
                    if ($scope.inboundList[i].customer_call_status == "Connected") {
                        //var inboundindex='object'+i;
                        //alert(inboundindex);
                        // document.getElementById("object_"+$scope.inboundList[i].id).src = $scope.inboundList[i].call_recording_url;
                        $("#object_" + $scope.inboundList[i].id).attr("src", $scope.inboundList[i].call_recording_url);
                    }
                }
            }, 1000);
        }

        $scope.teaminboundLists = function (empId, pageNumber, itemPerPage) {
            $scope.report_name = "Team Inbound Logs";
            Data.post('cloudcallinglogs/teamInboundLogs', {
                id: empId, pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                if (response.success) {
                    $scope.teaminboundList = response.records;
                    $scope.teaminboundLength = response.totalCount;
                    $timeout(function () {
                        for (i = 0; i < $scope.teaminboundList.length; i++) {
                            if ($scope.teaminboundList[i].customer_call_status == "Connected") {
                                document.getElementById("teamobject_" + $scope.teaminboundList[i].id).src = $scope.teaminboundList[i].call_recording_url;
                            }
                        }
                    }, 1000);

                } else {
                    $scope.errorMsg = response.message;
                }
            });
        };

        $scope.setteamAudio = function () {
            $timeout(function () {
                for (i = 0; i < $scope.teaminboundList.length; i++) {
                    if ($scope.teaminboundList[i].customer_call_status == "Connected") {
                        $("#teamobject_" + $scope.teaminboundList[i].id).attr("src", $scope.teaminboundList[i].call_recording_url);
                    }
                }
            }, 1000);
        }

        $scope.inLogexportReport = function (result) {

            Data.post('cloudcallinglogs/inLogexportToExcel', {result: result, reportName: $scope.report_name.replace(/ /g, "_")}).then(function (response) {
                window.location.href = response.fileUrl;
                $scope.sheetName = response.sheetName;
                toaster.pop('success', '', response.message);
                $scope.btnExport = true;
                $scope.dnExcelSheet = false;
            });
        }


        $scope.outLogexportReport = function (result) {

            Data.post('cloudcallinglogs/outLogexportToExcel', {result: result, reportName: $scope.report_name.replace(/ /g, "_")}).then(function (response) {
                window.location.href = response.fileUrl;
                $scope.sheetName = response.sheetName;
                toaster.pop('success', '', response.message);
                $scope.btnExport = true;
                $scope.dnExcelSheet = false;
            });
        }
        //out bound call listing

        $scope.outboundLists = function (empId, pageNumber, itemPerPage) {
            $scope.report_name = "Outbound Logs";
            Data.post('cloudcallinglogs/myOutboundLogs', {
                id: empId, pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                if (response.success) {
                    $scope.outboundList = response.records;
                    $scope.outboundLength = response.totalCount;
                    $timeout(function () {
                        for (i = 0; i < $scope.outboundList.length; i++) {
                            if ($scope.outboundList[i].customer_call_status == "Connected") {
                                document.getElementById("objectout_" + $scope.outboundList[i].id).src = $scope.outboundList[i].call_recording_url;
                            }
                        }
                    }, 1000);
                } else {
                    $scope.errorMsg = response.message;
                }
            });
        };

        $scope.teamoutboundLists = function (empId, pageNumber, itemPerPage) {
            $scope.report_name = "Team Outbound Logs";
            Data.post('cloudcallinglogs/teamOutboundLogs', {
                id: empId, pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                if (response.success) {
                    $scope.teamoutboundList = response.records;
                    $scope.teamoutboundLength = response.totalCount;
                    $timeout(function () {
                        for (i = 0; i < $scope.teamoutboundList.length; i++) {
                            if ($scope.teamoutboundList[i].customer_call_status == "Connected") {
                                document.getElementById("teamobjectout_" + $scope.teamoutboundList[i].id).src = $scope.teamoutboundList[i].call_recording_url;
                            }
                        }
                    }, 1000);

                } else {
                    $scope.errorMsg = response.message;
                }
            });
        };

        //end outbound call listing
        $scope.getsubsource = function (source_id) {
            $scope.enquirysubsources = {};
            Data.post('virtualnumber/getSubsources', {
                source_id: source_id,
            }).then(function (response) {

                $scope.enquirysubsources = response.records;
            });
        }

        $scope.enquirysources = function () {
            $scope.enquirysubsources = {};
            Data.post('virtualnumber/getSources', {
                success: true,
            }).then(function (response) {
                $scope.enquirysources = response.records;
            });
        }

        $scope.cttunetype = function () {
            Data.get('getCttunetype').then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.ct_tune_types = response.records;
                }
            });
        };

        $scope.cttunetype1 = function () {
            Data.get('getCttunetype').then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.ct_tune_types1 = response.records;
                }
            });
        };

        $scope.cttunetype2 = function () {
            Data.get('getCttunetype').then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.ct_tune_types2 = response.records;
                }
            });
        };

        $scope.ct_forwarding_types = function () {
            Data.get('getCtforwardingtypes').then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.ct_forwarding_types = response.records;
                }
            });
        };

        $scope.changeEmployees = function (employees) {
            $scope.employees1 = [];
            $timeout(function () {
                Data.post('virtualnumber/changeEmployees', {employees: employees}).then(function (response) {
                    if (!response.success) {
                        $scope.errorMsg = response.message;
                    } else {
                        $scope.employees1 = response.employees;
                    }
                });
            }, 1000);
        }

        $scope.getProcName = $scope.type = '';
        $scope.procName = function (procedureName, isTeam) {
            $scope.getProcName = angular.copy(procedureName);
            $scope.type = angular.copy(isTeam);
            $timeout(function () {                
                $("input[name=customer_number]").trigger("click");
            },200);
        }

        $scope.filterData = {};
        $scope.data = {};

        $scope.filteredData = function (data, page, noOfRecords) {
            $scope.showloader();
            page = noOfRecords * (page - 1);
            Data.post('cloudcallinglogs/filteredData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords, isTeamType: $scope.type}).then(function (response) {
                if (response.success)
                {
                    if ($scope.type == 1) {
                        $scope.teaminboundList = response.records;
                        $scope.teaminboundLength = response.totalCount;

                        $timeout(function () {
                            for (i = 0; i < $scope.teaminboundList.length; i++) {
                                if ($scope.teaminboundList[i].customer_call_status == "Connected") {
                                    document.getElementById("teamobject_" + $scope.teaminboundList[i].id).src = $scope.teaminboundList[i].call_recording_url;
                                }
                            }
                        }, 1000);
                    } else if ($scope.type == 0) {
                        $scope.inboundList = response.records;
                        $scope.inboundLength = response.totalCount;
                        $timeout(function () {
                            for (i = 0; i < $scope.inboundList.length; i++) {
                                if ($scope.inboundList[i].customer_call_status == "Connected") {
                                    document.getElementById("object_" + $scope.inboundList[i].id).src = $scope.inboundList[i].call_recording_url;
                                }
                            }
                        }, 1000);
                    }
                } else
                {
                    $scope.teaminboundList = '';
                    $scope.teaminboundLength = 0;
                    $scope.inboundList = response.records;
                    $scope.inboundLength = 0;
                }
                $('#showFilterModal').modal('hide');
                $scope.showFilterData = $scope.filterData;
                $scope.hideloader();
                return false;
            });
        }

        $scope.removeDataFromFilter = function (keyvalue)
        {
            delete $scope.filterData[keyvalue];
            $scope.filteredData($scope.filterData, 1, 30);
        }


        $scope.filteredoutboundData = function (data, page, noOfRecords) {
            $scope.showloader();
            page = noOfRecords * (page - 1);
            Data.post('cloudcallinglogs/filteredoutboundData', {filterData: data, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords, isTeamType: $scope.type}).then(function (response) {
                if (response.success)
                {
                    console.log($scope.type);
                    if ($scope.type == 1) {
                        $scope.teamoutboundList = response.records;
                        $scope.teamoutboundLength = response.totalCount;
                        $timeout(function () {
                            for (i = 0; i < $scope.teamoutboundList.length; i++) {
                                if ($scope.teamoutboundList[i].customer_call_status == "Connected") {
                                    document.getElementById("teamobjectout_" + $scope.teamoutboundList[i].id).src = $scope.teamoutboundList[i].call_recording_url;
                                }
                            }
                        }, 1000);
                    } else if ($scope.type == 0) {
                        $scope.outboundList = response.records;
                        $scope.outboundLength = response.totalCount;
                        $timeout(function () {
                            for (i = 0; i < $scope.outboundList.length; i++) {
                                if ($scope.outboundList[i].customer_call_status == "Connected") {
                                    document.getElementById("objectout_" + $scope.outboundList[i].id).src = $scope.outboundList[i].call_recording_url;
                                }
                            }
                        }, 1000);
                    }
                } else
                {
                    $scope.teamoutboundList = '';
                    $scope.teamoutboundLength = 0;
                    $scope.outboundList = response.records;
                    $scope.outboundLength = 0;
                }
                $('#showFilterModal').modal('hide');
                $scope.showFilterData = $scope.filterData;
                $scope.hideloader();
                return false;

            });
        }

        $scope.removeoutboundDataFromFilter = function (keyvalue)
        {
            delete $scope.filterData[keyvalue];
            $scope.filteredoutboundData($scope.filterData, 1, 30);
        }
    }]);

app.controller('virtualnumberCtrl', function ($scope, Data) {
    Data.get('getVirtualnumbers').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.virtualnolist = response.records;
            $scope.statuscall = response.callstatus;
        }
    });
});
app.controller('employeesWiseTeamCtrl', function ($scope, Data,$timeout) {
    $scope.employeesData = [];
    Data.post('getTeamEmployees', {
        data: {empId: ''},
    }).then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
            $scope.employeesData = response.records;
        } else {
            $timeout(function () {console.log($("input[name=customer_number]"));
                
                $scope.employeesData = response.records;
            },1000);
            
        }
    });
});