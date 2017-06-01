/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

app.controller('reportsController', ['$rootScope', '$scope', '$state', 'Data', 'Upload', '$timeout', '$parse', '$window', 'toaster', '$filter', function ($rootScope, $scope, $state, Data, Upload, $timeout, $parse, $window, toaster, $filter) {

        $scope.myEnquiryReport = function (employee_id) { //manoj
            $scope.categoryShow = true;
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            $scope.sourcelabels = [];
            $scope.sourcedata = [];
            $scope.sourcecolors = [];
            $scope.source_total = 0;
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
            Data.post('reports/getProjectWiseCategoryReport', {
            project_id:project_id, employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
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
                    $scope.categorycolors = ['#DCDCDC', '#FF0000', '#FFA500', '#FFA400', '#00ADF9',];
                    $scope.categoryoptions = {
                    cutoutPercentage: 60,
                            animation: {
                            animatescale: true
                            }
                    };
            }
        })
        
        
        
        
          Data.post('reports/getProjectWiseStatusReport', {
            project_id:project_id, employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
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
                    $scope.statuscolors = ['#DCDCDC', '#FF0000', '#FFA500', '#FFA400', '#00ADF9',];
                    $scope.statusoptions = {
                    cutoutPercentage: 60,
                            animation: {
                            animatescale: true
                            }
                    };
            }
        })
        
        
        
        
        
        
         Data.post('reports/getProjectWiseSourceReport', {
            project_id:project_id, employee_id: employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
            }).then(function (response) {
            
            console.log(response)
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
                    $scope.sourcecolors = ['#DCDCDC', '#FF0000', '#FFA500', '#FFA400', '#00ADF9',];
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
//                    $scope.teamstatuslabels = ["New Enquiry", "Open", "Booked", "Lost"];
//                    $scope.teamstatusdata = [$scope.stotalNew, $scope.stotalOpen, $scope.stotalBooked, $scope.stotalLost];
//                    $scope.teamstatuscolors = ['#ff7a81', '#FFFF00', '#00d4c3', '#b3a0fa'];
//                    $scope.teamstatusoptions = {
//                        cutoutPercentage: 60,
//                        animation: {
//                            animatescale: true
//                        }
//                   
//                }
            });

        }

        $scope.getteamfollowupReport = function (followup, index, user_id) {

            $scope.subteam_followup_report = followup;
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            var newIndex = index;
            $scope.emp_name = followup.name;
            $scope.employee_id = followup.employee_id;

            if (user_id != $scope.employee_id && followup.flag != 1 && followup.is_parent == 1) {
                // alert();
                $scope.total = 0;
                $scope.totalSame = 0;
                $scope.totalSecond = 0;
                $scope.totalThird = 0;
                $scope.totalAfter = 0;
                followup.flag = 1;
                Data.post('reports/getTeamfollowupreports', {
                    employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
                }).then(function (response) {
                    angular.forEach(response.Teams_followups, function (objct) {
                        newIndex = newIndex + 1;
                        objct.flag = 0;
                        $scope.team_followup_report.splice(newIndex, 0, objct);
                    });

                    for (var i = 0; i < $scope.team_followup_report.length; i++) {
                        $scope.totalSame += $scope.team_followup_report[i].sameday;
                        $scope.totalSecond += $scope.team_followup_report[i].secondday;
                        $scope.totalThird += $scope.team_followup_report[i].thirdday;
                        $scope.totalAfter += $scope.team_followup_report[i].afterthirdday;
                        $scope.total += $scope.team_followup_report[i].total;

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
        }




        $scope.teamcategoryEnquiryReport = function (category) {
//            console.log(category)
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
//                console.log(response)
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
            alert("asdsds")
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

            if (user_id != $scope.employee_id && sources.flag != 1 && sources.is_parent == 1) {
                $scope.team_source_total = 0;
                sources.flag = 1;
                Data.post('reports/getTeamsourcereports', {
                    employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
                }).then(function (response) {
                    angular.forEach(response.source_wise_report, function (objct) {
                        newIndex = newIndex + 1;
                        objct.flag = 0;
                        $scope.team_source_report.splice(newIndex, 0, objct);
                    });

                    for (var i = 0; i < $scope.team_source_report.length; i++) {
                        $scope.team_source_total += $scope.team_source_report[i].total;
                    }


                });
            }
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


        $scope.teamstatusReport = function (status, index, user_id) {
            $scope.subteam_status_report = status;

            //$scope.teamstatusdata = [];
            //$scope.teamstatuslabels = [];
            //$scope.teamstatusoptions = {};
            $scope.fromDate = "0000-00-00";
            $scope.toDate = new Date();
            $scope.reportFlag = '0';
            var newIndex = index;
            $scope.emp_name = status.name;
            $scope.employee_id = status.employee_id;

            if (user_id != $scope.employee_id && status.flag != 1 && status.is_parent == 1) {
                // alert();
                $scope.stotal = 0;
                $scope.stotalNew = 0;
                $scope.stotalOpen = 0;
                $scope.stotalBooked = 0;
                $scope.stotalLost = 0;
                status.flag = 1;
                Data.post('reports/getTeamstatusreports', {
                    employee_id: $scope.employee_id, from_date: $scope.fromDate, to_date: $scope.toDate, flag: $scope.reportFlag,
                }).then(function (response) {
                    angular.forEach(response.status_wise_report, function (objct) {
                        newIndex = newIndex + 1;
                        objct.flag = 0;
                        $scope.team_status_report.splice(newIndex, 0, objct);
                    });

                    for (var i = 0; i < $scope.team_status_report.length; i++) {
                        $scope.stotalNew += $scope.team_status_report[i].new;
                        $scope.stotalOpen += $scope.team_status_report[i].open;
                        $scope.stotalBooked += $scope.team_status_report[i].booked;
                        $scope.stotalLost += $scope.team_status_report[i].lost;
                        $scope.stotal += $scope.team_status_report[i].total;
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

        }





    }]);