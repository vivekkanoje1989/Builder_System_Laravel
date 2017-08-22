app.controller('reportsController', ['$scope', 'Data', '$timeout', function ($scope, Data, $timeout) {

        $scope.headingName = "";
        $scope.reportHeading = function (headingName) {
            $scope.headingName = headingName;
        }
        $scope.myEnquiryReport = function (employee_id) { //manoj
            $scope.categoryShow = true;
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.sourcelabels = [];
            $scope.sourcedata = [];
            $scope.sourcecolors = [];
            $scope.source_total = 0;
            $scope.projectShow = false;
            $scope.headingName = "Enquiry Category Report";
            $scope.empListTab = [];

            $scope.empListTab1 = [];
            $scope.empListTab2 = [];

            Data.post('reports/getCategoryReport', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.category_report = angular.copy(response.records);

                    $scope.categorylabels = ["New Enquiry", "Hot", "Warm", "Cold"];
                    $scope.categorydata = [$scope.category_report[0].New, $scope.category_report[0].Hot, $scope.category_report[0].Warm, $scope.category_report[0].Cold];
                    $scope.categorycolors = ['#DCDCDC', '#FF0000', '#FFA500', '#00ADF9'];
                    $scope.categoryoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };
                }
            });
            Data.post('reports/getSourceReport', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.Total = response.Total;
                    $scope.source_report = angular.copy(response.records);

                    $scope.sourcelabels = [];
                    $scope.sourcedata = [];
                    angular.forEach(response.records['0'], function (value, key) {

                        $scope.sourcelabels.push(key);
                        $scope.sourcedata.push(value);
                    });
                    $scope.sourcecolors = ['#DCDCDC', '#FF0000', '#FFA500', '#FFA400', '#00ADF9', '#F93910', '#EA6407', '#C0570F', '#D9D312', '#B2F00F', '#16D5A3', '#A916D5'];
                    $scope.sourceoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };
                }
            });

            Data.post('reports/getStatusReport', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.status_report = angular.copy(response.records);

                    $scope.statuslabels = ["New Enquiry", "Open", "Booked", "Lost"];
                    $scope.statusdata = [$scope.status_report[0].New, $scope.status_report[0].Open, $scope.status_report[0].Booked, $scope.status_report[0].Lost];
                    $scope.statuscolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                    $scope.statusoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };
                }
            });
        }


        $scope.projectWiseReport = function (project_id, employee_id)
        {
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.project_total = 0;
            $scope.projectShow = true;
            $scope.headingName = "Project - Category Report";
            Data.post('reports/getProjectWiseCategoryReport', {
                project_id: project_id, employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.Total = response.Total;
                    $scope.category_report = angular.copy(response.records);
                    $scope.categorylabels = [];
                    $scope.categorydata = [];
                    angular.forEach(response.records['0'], function (value, key) {

                        $scope.categorylabels.push(key);
                        $scope.categorydata.push(value);
                    });
                    $scope.categorycolors = ['#DCDCDC', '#FF0000', '#FFA500', '#FFA400', '#00ADF9', ];
                    $scope.categoryoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };
                }
            })

            Data.post('reports/getProjectWiseStatusReport', {
                project_id: project_id, employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.Total = response.Total;
                    $scope.status_report = angular.copy(response.records);
                    $scope.statuslabels = [];
                    $scope.statusdata = [];
                    angular.forEach(response.records['0'], function (value, key) {

                        $scope.statuslabels.push(key);
                        $scope.statusdata.push(value);
                    });
                    $scope.statuscolors = ['#DCDCDC', '#FF0000', '#FFA500', '#FFA400', '#00ADF9', ];
                    $scope.statusoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };
                }
            })

            Data.post('reports/getProjectWiseSourceReport', {
                project_id: project_id, employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.Total = response.Total;
                    $scope.source_report = angular.copy(response.records);
                    $scope.sourcelabels = [];
                    $scope.sourcedata = [];
                    angular.forEach(response.records['0'], function (value, key) {

                        $scope.sourcelabels.push(key);
                        $scope.sourcedata.push(value);
                    });
                    $scope.sourcecolors = ['#DCDCDC', '#FF0000', '#FFA500', '#FFA400', '#00ADF9', ];
                    $scope.sourceoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };
                }
            })
        };

        $scope.myFollowupReport = function (employee_id) {

            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.headingName = "Followup Report";
            Data.post('reports/followupReports', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.followup_report = angular.copy(response.records);
                    $scope.followuplabels = ["Same Day", "Second Day", "Third Day", "After Third Day"];
                    $scope.followupdata = [$scope.followup_report[0].same_day, $scope.followup_report[0].second_day, $scope.followup_report[0].third_day, $scope.followup_report[0].after_third_day];
                    $scope.followupcolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                    $scope.followupoptions = {
                        cutoutPercentage: 60,
                        animation: {
                            animatescale: true
                        }
                    };
                }
            });
        }

        $scope.teamEnquiryReport = function (employee_id) {
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.teamcategorydata = [];
            $scope.total = 0;
            $scope.totalNew = 0;
            $scope.totalHot = 0;
            $scope.totalWarm = 0;
            $scope.totalCold = 0;
            $scope.stotal = 0;
            $scope.stotalNew = 0;
            $scope.stotalOpen = 0;
            $scope.stotalBooked = 0;
            $scope.stotalLost = 0;
            $scope.stotalPreserved = 0;
            $scope.employee_id = employee_id;
            $scope.team_source_total = 0;
            $scope.headingName = "Team-wise Enquiry Category Report";
            Data.post('reports/getEmpcategoryreports', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                $scope.team_category_report = angular.copy(response.category_wise_report);

                $scope.categorylabels = ["New Enquiry", "Hot", "Warm", "Cold"];
                for (var i = 0; i < $scope.team_category_report.length; i++) {
                    $scope.totalNew += $scope.team_category_report[i].New;
                    $scope.totalHot += $scope.team_category_report[i].Hot;
                    $scope.totalWarm += $scope.team_category_report[i].Warm;
                    $scope.totalCold += $scope.team_category_report[i].Cold;
                    $scope.total += $scope.team_category_report[i].Total;
                }
                $scope.teamcategorydata = [$scope.totalNew, $scope.totalHot, $scope.totalWarm, $scope.totalCold];
                $scope.categorycolors = ['#DCDCDC', '#FF0000', '#FFA500', '#00ADF9'];
                $scope.categoryoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
            Data.post('reports/getsourcereports', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                $scope.team_source_report = angular.copy(response.source_wise_report);

                for (var i = 0; i < $scope.team_source_report.length; i++) {
                    $scope.team_source_report[i].flag = 0;
                    $scope.team_source_total += $scope.team_source_report[i].total;
                }
                $scope.getsourceReport({employee_id: employee_id, name: $scope.team_source_report[0].name});
                $scope.getSubSourceReport({employee_id: employee_id, name: $scope.team_source_report[0].name});
                $scope.teamsourceEmployees({employee_id: employee_id, name: $scope.team_source_report[0].name});
            });
            Data.post('reports/getEmpStatusreports', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                console.log(response)

                $scope.team_status_report = angular.copy(response.status_wise_report);
                for (var i = 0; i < $scope.team_status_report.length; i++) {
                    $scope.stotalNew += $scope.team_status_report[i].new;
                    $scope.stotalOpen += $scope.team_status_report[i].open;
                    $scope.stotalBooked += $scope.team_status_report[i].booked;
                    $scope.stotalLost += $scope.team_status_report[i].lost;
                    $scope.stotal += $scope.team_status_report[i].total;
                    $scope.stotalPreserved += $scope.team_status_report[i].preserved;
                    $scope.team_status_report[i].flag = 0;
                }
                $scope.teamstatuslabels = ["New Enquiry", "Open", "Booked", "Lost"];
                $scope.teamstatusdata = [$scope.stotalNew, $scope.stotalOpen, $scope.stotalBooked, $scope.stotalLost];
                $scope.teamstatuscolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.teamstatusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }

                }
            });
        }

        $scope.getteamfollowupReport = function (followup) {

            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.emp_name = followup.name;
            $scope.employee_id = followup.employee_id;
            $scope.empId = followup.employee_id;
            $scope.followUpTotal = 0;
            $scope.totalSame = 0;
            $scope.totalSecond = 0;
            $scope.totalThird = 0;
            $scope.totalAfter = 0;
            followup.flag = 1;
            Data.post('reports/getEmpFollowUpReports', {
                employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                $scope.sub_team_followup_report = response.Teams_followups;
                for (var i = 0; i < response.Teams_followups.length; i++) {
                    $scope.totalSame += response.Teams_followups[i].sameday;
                    $scope.totalSecond += response.Teams_followups[i].secondday;
                    $scope.totalThird += response.Teams_followups[i].thirdday;
                    $scope.totalAfter += response.Teams_followups[i].afterthirdday;
                    $scope.followUpTotal = parseInt($scope.followUpTotal) + parseInt(response.Teams_followups[i].total);
                }
                $scope.followupdata = [$scope.totalSame, $scope.totalSecond, $scope.totalThird, $scope.totalAfter];
                $scope.followupcolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.followupoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
            $timeout(function () {
                angular.forEach($scope.empListTab, function (object) {
                    if (object.employee_id == followup.employee_id) {
                        $("#tab" + followup.employee_id).addClass('active');
                    } else {
                        $("#tab" + object.employee_id).removeClass('active');
                    }
                });
            }, 500);
        }

        $scope.teamFollowUpEmployees = function (follow) {
            var flag = 0;
            if ($scope.empListTab.length != 0) {
                angular.forEach($scope.empListTab, function (item) {
                    if (item.employee_id == follow.employee_id) {
                        flag = 1;
                    }
                });
            }
            if (flag == 0) {
                $scope.empId = follow.employee_id;
                $scope.empListTab.push({'name': follow.name, 'employee_id': follow.employee_id, 'Cold': follow.cold, 'Hot': follow.hot, 'New': follow.New, 'Total': follow.Total, 'Warm': follow.Warm, 'is_parent': follow.is_parent});
            }
        }

        $scope.teamFollowupReport = function (employee_id) {
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.total = 0;
            $scope.totalSame = 0;
            $scope.totalSecond = 0;
            $scope.totalThird = 0;
            $scope.totalAfter = 0;
            $scope.employee_id = employee_id;
            $scope.headingName = "Team Followup Report";

            Data.post('reports/getTeamfollowupreports', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                $scope.team_followup_report = angular.copy(response.Teams_followups);
                $scope.followuplabelsLead = ["Same Day", "Second Day", "Third Day", "After Third Day"];
                for (var i = 0; i < $scope.team_followup_report.length; i++) {
                    $scope.totalSame += $scope.team_followup_report[i].sameday;
                    $scope.totalSecond += $scope.team_followup_report[i].secondday;
                    $scope.totalThird += $scope.team_followup_report[i].thirdday;
                    $scope.totalAfter += $scope.team_followup_report[i].afterthirdday;
                    $scope.total += $scope.team_followup_report[i].total;
                    $scope.team_followup_report[i].flag = 0;
                }
                $scope.followupdataLead = [$scope.totalSame, $scope.totalSecond, $scope.totalThird, $scope.totalAfter];
                $scope.followupcolorsLead = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.followupoptionsLead = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
        }
        $scope.closeFollowUpTab = function (empId) {
            var i = 0;
            angular.forEach($scope.empListTab, function (obj) {
                if (obj.employee_id == empId) {
                    $scope.empListTab.splice(i, 1);
                    $scope.j = i - 1;
                }
                i++;
            })
            if ($scope.empListTab[0]['employee_id'] != 'undefined') {
                $timeout(function () {
                    $("#tab" + $scope.empListTab[$scope.j]['employee_id']).addClass('active');
                    $scope.getteamfollowupReport($scope.empListTab[$scope.j]);
                }, 500);
            }

        }

        $scope.teamcategoryEnquiryReport = function (category) {
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.subtotal = 0;
            $scope.subtotalNew = 0;
            $scope.subtotalHot = 0;
            $scope.subtotalWarm = 0;
            $scope.subtotalCold = 0;
            $scope.subemployee_id = category.employee_id;
            $scope.emp_name = category.name;

            $("#catReport").css('display', 'none');
            Data.post('reports/getTeamcategoryreports', {
                employee_id: category.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                $scope.subteam_category_report = angular.copy(response.category_wise_report);

                for (var i = 0; i < $scope.subteam_category_report.length; i++) {
                    $scope.subtotalNew += $scope.subteam_category_report[i].New;
                    $scope.subtotalHot += $scope.subteam_category_report[i].Hot;
                    $scope.subtotalWarm += $scope.subteam_category_report[i].Warm;
                    $scope.subtotalCold += $scope.subteam_category_report[i].Cold;
                    $scope.subtotal += $scope.subteam_category_report[i].Total;
                }
                $scope.subteamcategorylabels = ["New Enquiry", "Hot", "Warm", "Cold"];
                $scope.subteamcategorydata = [$scope.subtotalNew, $scope.subtotalHot, $scope.subtotalWarm, $scope.subtotalCold];
                $scope.subcategorycolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.subcategoryoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
            $timeout(function () {
                angular.forEach($scope.empListTab, function (object) {
                    if (object.employee_id == category.employee_id) {
                        $("#tab" + category.employee_id).addClass('active');
                    } else {
                        $("#tab" + object.employee_id).removeClass('active');
                    }
                });
            }, 500);
        }

        $scope.getsourceReport = function (sources) {

            $scope.subteam_source_report = [];
            $scope.sub_source = [];
            $scope.team_sourcelabels = [];
            $scope.team_sourcedata = [];
            $scope.team_sourcecolors = [];
            $scope.teamEmp_source_report = [];
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.subEmpSourceTotal = 0;
            var subteam_source_total = 0;
            $scope.emp_name = sources.name;
            $scope.employee_id = sources.employee_id;
            $scope.empId1 = sources.employee_id;
            $scope.team_sub_source_total = 0;
            sources.flag = 1;
            var flagSource = 0;
            Data.post('reports/getTeamsourcereports', {
                employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                $scope.teamEmp_source_report = response.source_wise_report;
                for (var i = 0; i < $scope.teamEmp_source_report.length; i++) {
                    $scope.subEmpSourceTotal += $scope.teamEmp_source_report[i].total;
                }
            });
            $timeout(function () {
                angular.forEach($scope.empListTab1, function (object) {
                    if (object.employee_id == sources.employee_id) {
                        $("#tab1" + sources.employee_id).addClass('active');
                    } else {
                        $("#tab1" + object.employee_id).removeClass('active');
                    }
                });
            }, 500);
        }

        $scope.teamstatusReport = function (status) {

            $scope.subteam_status_report = status;
            $scope.sub_status = [];
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.emp_name = status.name;
            $scope.employee_id = status.employee_id;
            $scope.empId2 = status.employee_id;
            $scope.stotal = 0;
            $scope.stotalNew = 0;
            $scope.stotalOpen = 0;
            $scope.stotalBooked = 0;
            $scope.stotalLost = 0;
            status.flag = 1;
            $("#statusReport").css('display', 'none');
            Data.post('reports/getTeamstatusreports', {
                employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                console.log(response);
                $scope.sub_team_status_report = response.status_wise_report;
                for (var i = 0; i < $scope.sub_team_status_report.length; i++) {
                    $scope.stotalNew += $scope.sub_team_status_report[i].new;
                    $scope.stotalOpen += $scope.sub_team_status_report[i].open;
                    $scope.stotalBooked += $scope.sub_team_status_report[i].booked;
                    $scope.stotalLost += $scope.sub_team_status_report[i].lost;
                    $scope.stotal += $scope.sub_team_status_report[i].total;
                }
                $scope.steamstatuslabels = ["New Enquiry", "Open", "Booked", "Lost"];
                $scope.steamstatusdata = [$scope.stotalNew, $scope.stotalOpen, $scope.stotalBooked, $scope.stotalLost];
                $scope.steamstatuscolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.steamstatusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                }
            });
//            $timeout(function () {
            angular.forEach($scope.empListTab2, function (object) {
                if (object.employee_id == status.employee_id) {
                    $("#tab2" + status.employee_id).addClass('active');
                } else {
                    $("#tab2" + object.employee_id).removeClass('active');
                }
            });
//            }, 500);
            //            }
        }

        $scope.getSubStatus = function (status, sType, team_lead) {

            $scope.statusEmployee = status.name;
            $scope.subStatusTotal = 0;
            $scope.substatuslabels = [];
            $scope.substatusdata = [];
            $scope.status_id = sType;
            $scope.employee_id = status.employee_id;
            $("#statusReport").css('display', 'block');
            Data.post('reports/subStatusReport', {
                status_id: sType, status: status, team_lead: team_lead
            }).then(function (response) {

                $scope.sub_status = response.sub_status;
                angular.forEach(response.sub_status, function (sub_status) {
                    $scope.substatuslabels.push(sub_status.enquiry_sales_substatus);
                    $scope.substatusdata.push(sub_status.cnt);
                    $scope.subStatusTotal = parseInt($scope.subStatusTotal) + parseInt(sub_status.cnt);
                });
                $scope.substatuscolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.substatusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
        }

        $scope.teamProjectSourceEmpReport = function (source) {
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.SubsourceTotal = 0;
            $scope.subsourceApp = {};
            $scope.subteamsourcedata = [];
            $scope.subsourcecolors = [];
            $scope.subteamSourcelabels = [];
            $scope.SubsourceData = [];
            $scope.employee_id = source.employee_id;
            $scope.empId1 = source.employee_id;
            $scope.emp_name = source.name;
            Data.post('reports/teamProjectSourceEmpReport', {
                project_id: $scope.project_id, employee_id: source.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                $scope.subsource_wise_report = angular.copy(response.source_wise_report);
                angular.forEach($scope.subsource_wise_report, function (data) {
                    console.log(data);
                    $scope.SubsourceTotal = $scope.SubsourceTotal + data.count;
                });
                for (var i = 0; i < $scope.subsource_wise_report.length; i++)
                {
                    $scope.SubsourceData.push($scope.subsource_wise_report[i].source);
                }


                var myArray = $scope.SubsourceData;
                var newArray1 = [];
                var newObj = {};
                for (var i = 0; i < myArray.length; i++) {
                    for (var prop in myArray[i]) {
                        if (!newObj.hasOwnProperty(prop)) {
                            newObj[prop] = 0;
                        }
                        newObj[prop] += myArray[i][prop];
                    }
                }
                for (var prop in newObj) {
                    var obj = {};
                    obj[prop] = newObj[prop];
                    newArray1.push(obj);
                }
                $scope.newArray = newArray1;
                angular.forEach(newArray1, function (key, value) {
                    angular.forEach(key, function (key, value) {
                        var fields = {value: key}
                        $scope.subsourceApp[value] = key;
                        $scope.subteamsourcedata.push(key);
                        $scope.subteamSourcelabels.push(value.split("_").join(" "));

                    });
                });
                $scope.subsourcecolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.subsourceoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };

                $timeout(function () {
                    angular.forEach($scope.empListTab1, function (object) {
                        if (object.employee_id == source.employee_id) {
                            $("#tab1" + source.employee_id).addClass('active');
                        } else {
                            $("#tab1" + object.employee_id).removeClass('active');
                        }
                    });
                }, 500);
            });
        }


        $scope.projectWiseTeamReports = function (project_id, employee_id)
        {
            if (project_id == '') {
                return false;
            }
            $scope.project_id = project_id;
            $scope.employee_id = employee_id;
            $scope.totalNew = 0;
            $scope.totalHot = 0;
            $scope.totalWarm = 0;
            $scope.totalCold = 0;
            $scope.total = 0;
            $scope.Statustotal = 0;
            $scope.totalOpen = 0;
            $scope.totalBooked = 0;
            $scope.totalLost = 0;
            $scope.totalStatusNew = 0;
            $scope.SourceTotal = 0;
            $scope.totalPreserved = 0;

            Data.post('reports/TeamLeadProjectCategotyReport', {
                project_id: $scope.project_id, employee_id: $scope.employee_id
            }).then(function (response) {
                $scope.team_category_report = angular.copy(response.category_wise_report);
                $scope.categorylabels = ["New Enquiry", "Hot", "Warm", "Cold"];
                for (var i = 0; i < $scope.team_category_report.length; i++) {
                    $scope.totalNew += $scope.team_category_report[i].New;
                    $scope.totalHot += $scope.team_category_report[i].Hot;
                    $scope.totalWarm += $scope.team_category_report[i].Warm;
                    $scope.totalCold += $scope.team_category_report[i].Cold;
                    $scope.total += $scope.team_category_report[i].Total;
                }
                $scope.teamcategorydata = [$scope.totalNew, $scope.totalHot, $scope.totalWarm, $scope.totalCold];
                $scope.categorycolors = ['#DCDCDC', '#FF0000', '#FFA500', '#00ADF9'];
                $scope.categoryoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });

            Data.post('reports/TeamProjectStatusReport', {
                project_id: $scope.project_id, employee_id: $scope.employee_id
            }).then(function (response) {
                $scope.status_wise_report = angular.copy(response.status_wise_report);

                for (var i = 0; i < $scope.status_wise_report.length; i++) {

                    $scope.totalStatusNew += $scope.status_wise_report[i].new;
                    $scope.totalOpen += $scope.status_wise_report[i].open;
                    $scope.totalBooked += $scope.status_wise_report[i].booked;
                    $scope.totalLost += $scope.status_wise_report[i].lost;
                    $scope.Statustotal += $scope.status_wise_report[i].total;
                    $scope.totalPreserved += $scope.status_wise_report[i].preserved;
                }
                $scope.statusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
                $scope.statuslabels = ["New Enquiry", "Open", "Booked", "Lost", "preserved"];
                $scope.statusdata = [$scope.status_wise_report[0].new, $scope.status_wise_report[0].open, $scope.status_wise_report[0].booked, $scope.status_wise_report[0].lost];
                $scope.statuscolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa', '#ff0000'];
                $scope.statusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };

            });

            $scope.sourceData = [];
            $scope.sourceApp = {};
            $scope.teamsourcedata = [];
            $scope.teamSourcelabels = [];
            Data.post('reports/TeamProjectSourceReport', {
                project_id: $scope.project_id, employee_id: $scope.employee_id
            }).then(function (response) {
                $scope.source_wise_report = angular.copy(response.source_wise_report);
                angular.forEach($scope.source_wise_report, function (data) {

                    $scope.SourceTotal = $scope.SourceTotal + data.count;
                });
                for (var i = 0; i < $scope.source_wise_report.length; i++)
                {
                    $scope.sourceData.push($scope.source_wise_report[i].source);
                }

                $scope.sourcecolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.statusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };

                $scope.teamProjectSourceEmpReport(response.source_wise_report[0]);
                $scope.teamsourceEmployees(response.source_wise_report[0]);
                $scope.projectSourceReport(response.source_wise_report[0]);

            });

        }

        $scope.teamProjectCategoryReport = function (category) {

            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.subtotal = 0;
            $scope.subtotalNew = 0;
            $scope.subtotalHot = 0;
            $scope.subtotalWarm = 0;
            $scope.subtotalCold = 0;
            $scope.employee_id = category.employee_id;
            $scope.emp_name = category.name;
            Data.post('reports/teamProjectCategoryReport', {
                project_id: $scope.project_id, employee_id: category.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                $scope.subteam_category_report = angular.copy(response.category_wise_report);
                $scope.categorylabels = ["New Enquiry", "Hot", "Warm", "Cold"];
                for (var i = 0; i < $scope.subteam_category_report.length; i++) {
                    $scope.subtotalNew += $scope.subteam_category_report[i].New;
                    $scope.subtotalHot += $scope.subteam_category_report[i].Hot;
                    $scope.subtotalWarm += $scope.subteam_category_report[i].Warm;
                    $scope.subtotalCold += $scope.subteam_category_report[i].Cold;
                    $scope.subtotal += $scope.subteam_category_report[i].Total;
                }
                $scope.subteamcategorydata = [$scope.subtotalNew, $scope.subtotalHot, $scope.subtotalWarm, $scope.subtotalCold];
                $scope.subcategorycolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.subcategoryoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };

                $timeout(function () {
                    angular.forEach($scope.empListTab, function (object) {
                        if (object.employee_id == category.employee_id) {
                            $("#tab" + category.employee_id).addClass('active');
                        } else {
                            $("#tab" + object.employee_id).removeClass('active');
                        }
                    });
                }, 500);

            });
        }


        $scope.teamProjectStatusEmpReport = function (status) {

            $scope.subteam_status_report = status;
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.emp_name = status.name;
            $scope.employee_id = status.employee_id;
            $scope.subStatusTotal = 0;
            $scope.subTotalStatusNew = 0;
            $scope.subTotalOpen = 0;
            $scope.subTotalBooked = 0;
            $scope.subTotalPreserved = 0;
            $scope.subTotalLost = 0;
            status.flag = 1;
            Data.post('reports/teamProjectStatusEmpReport', {
                project_id: $scope.project_id, employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                $scope.sub_status_wise_report = angular.copy(response.status_wise_report);

                for (var i = 0; i < $scope.sub_status_wise_report.length; i++) {
                    $scope.subTotalStatusNew += $scope.sub_status_wise_report[i].new;
                    $scope.subTotalOpen += $scope.sub_status_wise_report[i].open;
                    $scope.subTotalBooked += $scope.sub_status_wise_report[i].booked;
                    $scope.subTotalLost += $scope.sub_status_wise_report[i].lost;
                    $scope.subTotalPreserved += $scope.sub_status_wise_report[i].preserved;
                    $scope.subStatusTotal += $scope.sub_status_wise_report[i].Total;
                }
                $scope.statusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
                $scope.substatuslabels = ["New Enquiry", "Open", "Booked", "Lost"];
                $scope.substatusdata = [$scope.sub_status_wise_report[0].new, $scope.sub_status_wise_report[0].open, $scope.sub_status_wise_report[0].booked, $scope.sub_status_wise_report[0].lost];
                $scope.substatuscolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.substatusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };

            });
            $timeout(function () {
                angular.forEach($scope.empListTab2, function (object) {
                    if (object.employee_id == status.employee_id) {
                        $("#tab2" + status.employee_id).addClass('active');
                    } else {
                        $("#tab2" + object.employee_id).removeClass('active');
                    }
                });
            }, 500);
        }

        $scope.overViewReport = function ()
        {
            Data.get('reports/overViewReport').then(function (response) {
                $scope.projectOverview = response.records;

            });
        }


        $scope.empListTab = [];
        $scope.teamEmployees = function (category) {

            var flag = 0;
            if ($scope.empListTab.length != 0) {
                angular.forEach($scope.empListTab, function (item) {
                    if (item.employee_id == category.employee_id) {
                        flag = 1;
                    }
                });
            }
            if (flag == 0) {
                $scope.empId = category.employee_id;
                $scope.empListTab.push(category);
            }
        }

        $scope.closeTab = function (empId) {

            var i = 0;
            angular.forEach($scope.empListTab, function (obj) {
                if (obj.employee_id == empId) {
                    $scope.empListTab.splice(i, 1);
                    $scope.j = i - 1;
                }
                i++;
            })
            if ($scope.empListTab[0]['employee_id'] != 'undefined') {
                $timeout(function () {
                    $("#tab" + $scope.empListTab[$scope.j]['employee_id']).addClass('active');
                    $scope.teamcategoryEnquiryReport($scope.empListTab[$scope.j]);
                }, 500);
            }
        }
        $scope.closeProjectsTab = function (empId) {
            var i = 0;
            angular.forEach($scope.empListTab, function (obj) {
                if (obj.employee_id == empId) {
                    $scope.empListTab.splice(i, 1);
                    $scope.j = i - 1;
                }
                i++;
            })
            if ($scope.empListTab[0]['employee_id'] != 'undefined') {
                $timeout(function () {
                    $("#tab" + $scope.empListTab[$scope.j]['employee_id']).addClass('active');
                    $scope.teamcategoryEnquiryReport($scope.empListTab[$scope.j]);
                    $scope.empId = $scope.empListTab[$scope.j]['employee_id'];
                }, 500);
            }
        }
        $scope.empListTab1 = [];

        $scope.closeSourceTab = function (empId) {
            var i = 0;
            angular.forEach($scope.empListTab1, function (obj) {
                if (obj.employee_id == empId) {
                    $scope.empListTab1.splice(i, 1);
                    $scope.j = i - 1;
                }
                i++;
            })
            if ($scope.empListTab1[0]['employee_id'] != 'undefined') {
                $timeout(function () {
                    $("#tab1" + $scope.empListTab1[$scope.j]['employee_id']).addClass('active');
                    $scope.getsourceReport($scope.empListTab1[$scope.j]);
                }, 500);
            }
        }

        $scope.closeProjectSourceTab = function (empId) {
            var i = 0;
            angular.forEach($scope.empListTab1, function (obj) {
                if (obj.employee_id == empId) {
                    $scope.empListTab1.splice(i, 1);
                    $scope.j = i - 1;
                }
                i++;
            })
            if ($scope.empListTab1[0]['employee_id'] != 'undefined') {
                $timeout(function () {
                    $("#tab1" + $scope.empListTab1[$scope.j]['employee_id']).addClass('active');
                    $scope.teamProjectSourceEmpReport($scope.empListTab1[$scope.j]);
                }, 500);
            }
        }




        $scope.closeStatusTab = function (empId) {
            var i = 0;
            angular.forEach($scope.empListTab2, function (obj) {
                if (obj.employee_id == empId) {
                    $scope.empListTab2.splice(i, 1);
                    $scope.j = i - 1;
                }
                i++;
            })
            if ($scope.empListTab2[0]['employee_id'] != 'undefined') {
                $timeout(function () {
                    $("#tab1" + $scope.empListTab2[$scope.j]['employee_id']).addClass('active');
                    $scope.teamstatusReport($scope.empListTab2[$scope.j]);
                    $scope.empId = $scope.empListTab2[$scope.j]['employee_id'];
                }, 500);
            }
        }


        $scope.closeProjectStatusTab = function (empId) {
            var i = 0;
            angular.forEach($scope.empListTab2, function (obj) {
                if (obj.employee_id == empId) {
                    $scope.empListTab2.splice(i, 1);
                    $scope.j = i - 1;
                }
                i++;
            })
            if ($scope.empListTab2[0]['employee_id'] != 'undefined') {
                $timeout(function () {
                    $("#tab1" + $scope.empListTab2[$scope.j]['employee_id']).addClass('active');
                    $scope.teamProjectStatusEmpReport($scope.empListTab2[$scope.j]);
                    $scope.empId = $scope.empListTab2[$scope.j]['employee_id'];
                }, 500);
            }
        }




        $scope.subCategoryReport = function (category, category_id, is_category_group) {
            $scope.catEmployee = category.name;
            $scope.subcategorylabels = [];
            $scope.subcategorydata = [];
            $scope.subCatTotal = 0;
            $scope.category_id = category_id;
            $("#catReport").css('display', 'block');
            Data.post('reports/subCategoryReport', {
                category_id: category_id, category: category, is_emp_group: is_category_group
            }).then(function (response) {
                $scope.sub_category_report = response.sub_category;
                angular.forEach(response.sub_category, function (object) {
                    $scope.subCatTotal = parseInt(object.cnt) + parseInt($scope.subCatTotal);
                    $scope.subcategorylabels.push(object.enquiry_sales_subcategory);
                    $scope.subcategorydata.push(object.cnt);
                })
                $scope.subcategorycolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.subcategoryoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
        }

        $scope.projectSourceReport = function (source) {
            $scope.sourcelabels = [];
            $scope.subsourcedata = [];
            $scope.sourceEmployee = source.name;
            $scope.sourceTotal = 0;
            Data.post('reports/projectSourceReport', {
                source: source, project_id: $scope.project_id
            }).then(function (response) {
                $scope.subteam_source_report = response.source_wise_report;
                angular.forEach(response.source_wise_report, function (object) {
                    $scope.sourcelabels.push(object.sales_source_name);
                    $scope.subsourcedata.push(object.cnt);
                    $scope.sourceTotal = object.cnt + parseInt($scope.sourceTotal);
                });

                $scope.subsourcecolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.subsourceoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
        }

        $scope.projectSubSourceReport = function (source) {
            $scope.subsourceTotal = 0;
            $scope.sub_sourcelabels = [];
            $scope.sub_sourcedata = [];
            Data.post('reports/projectSubSourceReport', {
                source: source, project_id: $scope.project_id, employee_id: $scope.employee_id
            }).then(function (response) {
                $scope.sub_source = response.sub_source_wise_report;
                angular.forEach(response.sub_source_wise_report, function (object) {
                    $scope.sub_sourcelabels.push(object.sub_source);
                    $scope.sub_sourcedata.push(object.cnt);
                    $scope.subsourceTotal = object.cnt + parseInt($scope.subsourceTotal);
                });

                $scope.sub_sourcecolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.sub_sourceoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
        }


        $scope.subProjectCategoryReport = function (category, category_id, is_category_group) {
            $scope.catEmployee = category.name;
            $scope.subcategorylabels = [];
            $scope.subcategorydata = [];
            $scope.subCatTotal = 0;
            $scope.category_id = category_id;
            $("#catReport").css('display', 'block');
            Data.post('reports/subProjectCategoryReport', {
                category_id: category_id, project_id: $scope.project_id, category: category, is_emp_group: is_category_group
            }).then(function (response) {
                $scope.sub_category_report = response.sub_category;
                angular.forEach(response.sub_category, function (object) {
                    $scope.subCatTotal = parseInt(object.cnt) + parseInt($scope.subCatTotal);
                    $scope.subcategorylabels.push(object.enquiry_sales_subcategory);
                    $scope.subcategorydata.push(object.cnt);
                });
                $scope.subcategorycolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.subcategoryoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
        }

        $scope.subProjectStatusReport = function (status, status_id, is_status_group) {
            $scope.statusEmployee = status.name;
            $scope.substatus_labels = [];
            $scope.substatus_data = [];
            $scope.subStatus_Total = 0;
            $scope.status_id = status_id;
            $("#statusReport").css('display', 'block');
            Data.post('reports/subProjectStatusReport', {
                status_id: status_id, project_id: $scope.project_id, status: status, is_emp_group: is_status_group
            }).then(function (response) {
                console.log(response.sub_status);
                $scope.sub_status_report = response.sub_status;

                angular.forEach(response.sub_status, function (object) {
                    console.log(object);
                    $scope.subStatus_Total = parseInt(object.cnt) + parseInt($scope.subStatus_Total);
                    $scope.substatus_labels.push(object.enquiry_sales_substatus);
                    $scope.substatus_data.push(object.cnt);
                });
                $scope.substatus_colors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.substatus_options = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
        }

        $scope.teamsourceEmployees = function (source) {
            var flag = 0;
            if ($scope.empListTab1.length != 0) {
                angular.forEach($scope.empListTab1, function (item) {
                    if (item.employee_id == source.employee_id) {
                        flag = 1;
                    }
                });
            }
            if (flag == 0) {
                $scope.empId = source.employee_id;
                $scope.empListTab1.push({'name': source.name, 'employee_id': source.employee_id, 'is_parent': source.is_parent, 'reportFlag': source.flag});
            }
        }
        $scope.empListTab2 = [];
        $scope.teamStatusEmployees = function (status) {
            var flag = 0;
            if ($scope.empListTab2.length != 0) {
                angular.forEach($scope.empListTab2, function (item) {
                    if (item.employee_id == status.employee_id) {
                        flag = 1;
                    }
                });
            }
            if (flag == 0) {
                $scope.empId = status.employee_id;
                $scope.empListTab2.push({'name': status.name, 'employee_id': status.employee_id, 'is_parent': status.is_parent, 'reportFlag': status.flag});
            }
        }

        $scope.getSubSourceReport = function (source,is_source_group) {
          
            $scope.sourceEmployee = source.name;
            $scope.team_sub_source_total = 0;
            $scope.team_sourcelabels = [];
            $scope.team_sourcedata = [];
            $scope.sub_source = [];
            $scope.is_source_group = 0;
            $scope.employee_id = source.employee_id;
            Data.post('reports/getSourceWiseReport', {
                source: source
            }).then(function (response) {

                $scope.subteam_source_report = response.source_report;
                angular.forEach(response.source_report, function (source) {
                    $scope.team_sourcelabels.push(source.sales_source_name);
                    $scope.team_sourcedata.push(source.cnt);
                    $scope.team_sub_source_total += source.cnt;
                })
                $scope.team_sourcecolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.team_sourceoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
        }



        $scope.getSubSourceGroupReport = function (source) {
            console.log(source)
            $scope.sourceEmployee = source.name;
            $scope.team_sub_source_total = 0;
            $scope.team_sourcelabels = [];
            $scope.team_sourcedata = [];
            $scope.sub_source = [];
            $scope.is_source_group = 1;
            Data.post('reports/getSourceWiseGroupReport', {
                source: source
            }).then(function (response) {

                $scope.subteam_source_report = response.source_report;
                angular.forEach(response.source_report, function (source) {
                    $scope.team_sourcelabels.push(source.sales_source_name);
                    $scope.team_sourcedata.push(source.cnt);
                    $scope.team_sub_source_total += source.cnt;
                })
                $scope.team_sourcecolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.team_sourceoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
        }


        $scope.subSourceReport = function (subSource) {
            $scope.source_id = subSource.id;
            $scope.subSourceTotal = 0;
            $scope.team_subsourcelabels = [];
            $scope.team_subsourcedata = [];
            Data.post('reports/subSourceReport', {
                employee_id: $scope.employee_id, source_id: subSource.id, source_emp_group: $scope.is_source_group
            }).then(function (response) {
                $scope.sub_source = response.sub_source;
                for (i = 0; i < $scope.sub_source.length; i++) {
                    var counter = $scope.sub_source[i];
                    $scope.team_subsourcelabels.push(counter.enquiry_subsource);
                    $scope.team_subsourcedata.push(counter.cnt);
                    $scope.subSourceTotal = parseInt($scope.subSourceTotal) + parseInt(counter.cnt);
                }
            });
            $scope.team_subsourcecolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
            $scope.team_subsourceoptions = {
                cutoutPercentage: 60,
                animation: {
                    animatescale: true
                }
            };
        };


        $scope.teamProjectCategoryEmployees = function (category) {
            var flag = 0;
            if ($scope.empListTab.length != 0) {
                angular.forEach($scope.empListTab, function (item) {
                    if (item.employee_id == category.employee_id) {
                        flag = 1;
                    }
                });
            }
            if (flag == 0) {
                $scope.empId = category.employee_id;
                $scope.empListTab.push({'name': category.name, 'employee_id': category.employee_id, 'Cold': category.cold, 'Hot': category.hot, 'New': category.New, 'Total': category.Total, 'Warm': category.Warm, 'is_parent': category.is_parent});
            }
        }


    }]);