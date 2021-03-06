'use strict';

angular.module('app')
        .controller('AppCtrl', [
            '$rootScope', '$localStorage', '$state', '$timeout', '$scope', 'SweetAlert',
            function ($rootScope, $localStorage, $state, $timeout, $scope, SweetAlert) {
                $rootScope.settings = {
                    skin: '',
                    color: {
                        themeprimary: '#2dc3e8',
                        themesecondary: '#fb6e52',
                        themethirdcolor: '#ffce55',
                        themefourthcolor: '#a0d468',
                        themefifthcolor: '#e75b8d'
                    },
                    rtl: false,
                    fixed: {
                        navbar: false,
                        sidebar: false,
                        breadcrumbs: false,
                        header: false
                    }
                };
                if (angular.isDefined($localStorage.settings))
                    $rootScope.settings = $localStorage.settings;
                else
                    $localStorage.settings = $rootScope.settings;

                $rootScope.$watch('settings', function () {
                    if ($rootScope.settings.fixed.header) {
                        $rootScope.settings.fixed.navbar = true;
                        $rootScope.settings.fixed.sidebar = true;
                        $rootScope.settings.fixed.breadcrumbs = true;
                    }
                    if ($rootScope.settings.fixed.breadcrumbs) {
                        $rootScope.settings.fixed.navbar = true;
                        $rootScope.settings.fixed.sidebar = true;
                    }
                    if ($rootScope.settings.fixed.sidebar) {
                        $rootScope.settings.fixed.navbar = true;


                        //Slim Scrolling for Sidebar Menu in fix state
                        var position = $rootScope.settings.rtl ? 'right' : 'left';
                        if (!$('.page-sidebar').hasClass('menu-compact')) {
                            $('.sidebar-menu').slimscroll({
                                position: position,
                                size: '3px',
                                color: $rootScope.settings.color.themeprimary,
                                height: $(window).height() - 90,
                            });
                        }
                    } else {
                        if ($(".sidebar-menu").closest("div").hasClass("slimScrollDiv")) {
                            $(".sidebar-menu").slimScroll({destroy: true});
                            $(".sidebar-menu").attr('style', '');
                        }
                    }

                    $localStorage.settings = $rootScope.settings;
                }, true);

                $rootScope.$watch('settings.rtl', function () {
                    if ($state.current.name != "persian.dashboard" && $state.current.name != "arabic.dashboard") {
                        switchClasses("pull-right", "pull-left");
                        switchClasses("databox-right", "databox-left");
                        switchClasses("item-right", "item-left");
                    }

                    $localStorage.settings = $rootScope.settings;
                }, true);

                $rootScope.$on('$viewContentLoaded',
                        function (event, toState, toParams, fromState, fromParams) {
                            if ($rootScope.settings.rtl && $state.current.name != "persian.dashboard" && $state.current.name != "arabic.dashboard") {
                                switchClasses("pull-right", "pull-left");
                                switchClasses("databox-right", "databox-left");
                                switchClasses("item-right", "item-left");
                            }
                            if ($state.current.name == 'error404') {
                                $('body').addClass('body-404');
                            }
                            if ($state.current.name == 'error500') {
                                $('body').addClass('body-500');
                            }
                            $timeout(function () {
                                if ($rootScope.settings.fixed.sidebar) {
                                    //Slim Scrolling for Sidebar Menu in fix state
                                    var position = $rootScope.settings.rtl ? 'right' : 'left';
                                    if (!$('.page-sidebar').hasClass('menu-compact')) {
                                        $('.sidebar-menu').slimscroll({
                                            position: position,
                                            size: '3px',
                                            color: $rootScope.settings.color.themeprimary,
                                            height: $(window).height() - 90,
                                        });
                                    }
                                } else {
                                    if ($(".sidebar-menu").closest("div").hasClass("slimScrollDiv")) {
                                        $(".sidebar-menu").slimScroll({destroy: true});
                                        $(".sidebar-menu").attr('style', '');
                                    }
                                }
                            }, 500);
                        });
                /*****************FOR CONTENT PAGE LOADER*********************/
                $scope.loader = {
                    loading: false,
                };

                $scope.showloader = function () {
                    $scope.loader.loading = true;
                }
                $scope.hideloader = function () {
                    $timeout(function () {
                        $scope.loader.loading = false;
                    }, 1000);
                }
                /*******************FOR FULL PAGE LOADER*******************/
                $rootScope.previewFullPage = false;
                $scope.loader1 = {
                    loading: false,
                };

                $scope.showloader1 = function () {
                    $scope.loader1.loading1 = true;
                }
                $scope.hideloader1 = function () {
                    $timeout(function () {
                        $scope.loader1.loading1 = false;
                    }, 1000);
                }

                $scope.confirm = function (id, index) {
                    SweetAlert.swal({
                        title: "Are you sure?", //Bold text
                        text: "Your will not be able to recover this record!", //light text
                        type: "warning", //type -- adds appropiriate icon
                        showCancelButton: true, // displays cancel btton
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: true, //do not close popup after click on confirm, usefull when you want to display a subsequent popup
                        closeOnCancel: true
                    },
                    function (isConfirm) { //Function that triggers on user action.
                        if (isConfirm) {
                            $scope.$broadcast("deleteRecords", {id, index});
                        }
                    });
                }
                
                $scope.confirmDelete = function (id, index) {
                    SweetAlert.swal({
                        title: "Are you sure?", //Bold text
                        text: "Your will not be able to recover this record!", //light text
                        type: "warning", //type -- adds appropiriate icon
                        showCancelButton: true, // displays cancel btton
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: true, //do not close popup after click on confirm, usefull when you want to display a subsequent popup
                        closeOnCancel: true
                    },
                            function (isConfirm) { //Function that triggers on user action.
                                if (isConfirm) {
                                    $scope.$broadcast("deleteItems", {id, index});
                                }
                            });
                }
            }
        ]);