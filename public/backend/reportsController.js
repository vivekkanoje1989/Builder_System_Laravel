/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

app.controller('reportsController', ['$scope', 'Data', function ($scope, Data) {

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
            $scope.employee_id = employee_id;
            $scope.team_source_total = 0;
            Data.post('reports/getTeamcategoryreports', {
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
            Data.post('reports/getTeamsourcereports', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                $scope.team_source_report = angular.copy(response.source_wise_report);

                for (var i = 0; i < $scope.team_source_report.length; i++) {
                    $scope.team_source_report[i].flag = 0;
                    $scope.team_source_total += $scope.team_source_report[i].total;
                }
            });
            Data.post('reports/getTeamstatusreports', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                $scope.team_status_report = angular.copy(response.status_wise_report);
                for (var i = 0; i < $scope.team_status_report.length; i++) {
                    $scope.stotalNew += $scope.team_status_report[i].new;
                    $scope.stotalOpen += $scope.team_status_report[i].open;
                    $scope.stotalBooked += $scope.team_status_report[i].booked;
                    $scope.stotalLost += $scope.team_status_report[i].lost;
                    $scope.stotal += $scope.team_status_report[i].total;
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

            $scope.subteam_followup_report = followup;
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.subtotalSame = 0;
            $scope.subtotalSecond = 0;
            $scope.subtotalThird = 0;
            $scope.subtotalAfter = 0;
            $scope.subtotal = 0;
            $scope.subfollowupdata = [];
            $scope.subfollowuplabels = [];
            $scope.emp_name = followup.name;
            $scope.employee_id = followup.employee_id;
            $scope.total = 0;
            $scope.totalSame = 0;
            $scope.totalSecond = 0;
            $scope.totalThird = 0;
            $scope.totalAfter = 0;
            followup.flag = 1;
            Data.post('reports/getTeamfollowupreports', {
                employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                console.log(response)
                $scope.subteam_followup_report = angular.copy(response.Teams_followups);
                for (var i = 0; i < $scope.subteam_followup_report.length; i++) {
                    $scope.subtotalSame += $scope.subteam_followup_report[i].sameday;
                    $scope.subtotalSecond += $scope.subteam_followup_report[i].secondday;
                    $scope.subtotalThird += $scope.subteam_followup_report[i].thirdday;
                    $scope.subtotalAfter += $scope.subteam_followup_report[i].afterthirdday;
                    $scope.subtotal += $scope.subteam_followup_report[i].total;
                }
                $scope.subfollowuplabels = ["Same Day", "Second Day", "Third Day", "After Third Day"];
                $scope.subfollowupdata = [$scope.subtotalSame, $scope.subtotalSecond, $scope.subtotalThird, $scope.subtotalAfter];
                $scope.subfollowupcolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.subfollowupoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
            });
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
            //$scope.team_followup_report ={};
            $scope.employee_id = employee_id;

            Data.post('reports/getTeamfollowupreports', {
                employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                console.log(response)
                $scope.team_followup_report = angular.copy(response.Teams_followups);

                $scope.followuplabels = ["Same Day", "Second Day", "Third Day", "After Third Day"];
                for (var i = 0; i < $scope.team_followup_report.length; i++) {
                    $scope.totalSame += $scope.team_followup_report[i].sameday;
                    $scope.totalSecond += $scope.team_followup_report[i].secondday;
                    $scope.totalThird += $scope.team_followup_report[i].thirdday;
                    $scope.totalAfter += $scope.team_followup_report[i].afterthirdday;
                    $scope.total += $scope.team_followup_report[i].total;
                    $scope.team_followup_report[i].flag = 0;
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
            Data.post('reports/getTeamcategoryreports', {
                employee_id: category.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
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
            });
        }

        $scope.getsourceReport = function (sources, index, user_id) {

            $scope.subteam_source_report = sources.source_details;
            $scope.subteam_source_total = sources.total;
            $scope.team_sourcelabels = [];
            $scope.team_sourcedata = [];
            $scope.team_sourcecolors = [];
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            var newIndex = index;
            $scope.emp_name = sources.name;
            $scope.employee_id = sources.employee_id;
            $scope.team_source_total = 0;
            sources.flag = 1;
            Data.post('reports/getTeamsourcereports', {
                employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                console.log(response)
                $scope.team_source_report.splice(newIndex, 1);
                angular.forEach(response.source_wise_report, function (objct) {
                    newIndex = newIndex + 1;
                    objct.flag = 0;
                    $scope.team_source_report.splice(newIndex, 0, objct);
                });
                for (var i = 0; i < $scope.team_source_report.length; i++) {
                    $scope.team_source_total += $scope.team_source_report[i].total;
                }
            });

            for (var i = 0; i < $scope.subteam_source_report.length; i++) {
                $scope.team_sourcelabels.push($scope.subteam_source_report[i].source_name);
                $scope.team_sourcedata.push($scope.subteam_source_report[i].val);
            }
            $scope.team_sourcecolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
            $scope.team_sourceoptions = {
                cutoutPercentage: 60,
                animation: {
                    animatescale: true
                }
            };
        }

        $scope.teamstatusReport = function (status) {

            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.subtotalNew = 0;
            $scope.subtotalOpen = 0;
            $scope.subtotalLost = 0;
            $scope.subtotal = 0;
            $scope.subtotalBooked = 0;
            $scope.subteamstatusoptions = [];

            $scope.emp_name = status.name;
            $scope.employee_id = status.employee_id;
            status.flag = 1;
            Data.post('reports/getTeamstatusreports', {
                employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                console.log(response)
                $scope.subteam_status_report = response.status_wise_report;

                for (var i = 0; i < $scope.subteam_status_report.length; i++) {
                    $scope.subtotalNew += $scope.subteam_status_report[i].new;
                    $scope.subtotalOpen += $scope.subteam_status_report[i].open;
                    $scope.subtotalBooked += $scope.subteam_status_report[i].booked;
                    $scope.subtotalLost += $scope.subteam_status_report[i].lost;
                    $scope.subtotal += $scope.subteam_status_report[i].total;
                }

                $scope.subteamstatuslabels = ["New Enquiry", "Open", "Booked", "Lost"];
                $scope.subteamstatusdata = [$scope.subtotalNew, $scope.subtotalOpen, $scope.subtotalBooked, $scope.subtotalLost];
                $scope.subteamstatuscolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.subteamstatusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                }
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
            $scope.emp_name = source.name;
            Data.post('reports/teamProjectSourceEmpReport', {
                project_id: $scope.project_id, employee_id: source.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                $scope.subsource_wise_report = angular.copy(response.source_wise_report);
                angular.forEach($scope.subsource_wise_report, function (data) {
                    $scope.SubsourceTotal = $scope.SubsourceTotal + data.Total;
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
            });
        }


        $scope.projectWiseTeamReports = function (project_id, employee_id)
        {
            if (project_id == '')
            {
                return false;
            }
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
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
            Data.post('reports/TeamProjectCategotyReport', {
                project_id: $scope.project_id, employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
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
                project_id: $scope.project_id, employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                $scope.status_wise_report = angular.copy(response.status_wise_report);

                for (var i = 0; i < $scope.status_wise_report.length; i++) {

                    $scope.totalStatusNew += $scope.status_wise_report[i].new;
                    $scope.totalOpen += $scope.status_wise_report[i].open;
                    $scope.totalBooked += $scope.status_wise_report[i].booked;
                    $scope.totalLost += $scope.status_wise_report[i].lost;
                    $scope.Statustotal += $scope.status_wise_report[i].Total;
                }
                $scope.statusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };
                $scope.statuslabels = ["New Enquiry", "Open", "Booked", "Lost"];
                $scope.statusdata = [$scope.status_wise_report[0].new, $scope.status_wise_report[0].open, $scope.status_wise_report[0].booked, $scope.status_wise_report[0].lost];
                $scope.statuscolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
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
                project_id: $scope.project_id, employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {

                $scope.source_wise_report = angular.copy(response.source_wise_report);
                angular.forEach($scope.source_wise_report, function (data) {
                    $scope.SourceTotal = $scope.SourceTotal + data.Total;
                });
                for (var i = 0; i < $scope.source_wise_report.length; i++)
                {
                    $scope.sourceData.push($scope.source_wise_report[i].source);
                }
                var myArray = $scope.sourceData;
                var newArray = [];
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
                    newArray.push(obj);
                }
                $scope.newArray = newArray;
                angular.forEach(newArray, function (key, value) {
                    angular.forEach(key, function (key, value) {
                        var fields = {value: key}
                        $scope.sourceApp[value] = key;

                        $scope.teamsourcedata.push(key);
                        $scope.teamSourcelabels.push(value.split("_").join(" "));

                    });
                });
                $scope.sourcecolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
                $scope.statusoptions = {
                    cutoutPercentage: 60,
                    animation: {
                        animatescale: true
                    }
                };

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
            $scope.subemployee_id = category.employee_id;
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
            $scope.subTotalLost = 0;
            status.flag = 1;
            Data.post('reports/teamProjectStatusEmpReport', {
                project_id: $scope.project_id, employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
                console.log(response);
                $scope.sub_status_wise_report = angular.copy(response.status_wise_report);

                for (var i = 0; i < $scope.sub_status_wise_report.length; i++) {
                    $scope.subTotalStatusNew += $scope.sub_status_wise_report[i].new;
                    $scope.subTotalOpen += $scope.sub_status_wise_report[i].open;
                    $scope.subTotalBooked += $scope.sub_status_wise_report[i].booked;
                    $scope.subTotalLost += $scope.sub_status_wise_report[i].lost;
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
        }

        $scope.overViewReport = function ()
        {
            Data.get('reports/overViewReport').then(function (response) {
                 $scope.projectOverview = response.records;

            });
        }


    }]);