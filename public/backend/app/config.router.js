'use strict';
angular.module('app')
        .run(
                [
                    '$rootScope', '$state', '$stateParams',
                    function ($rootScope, $state, $stateParams) {
                    }
                ]
                )
        .config(
                ['$stateProvider', '$urlRouterProvider', '$locationProvider',
                    function ($stateProvider, $urlRouterProvider, $locationProvider) {

                        $urlRouterProvider
                                .otherwise('/login');
                        $stateProvider
//                                .state(getUrl, {
//                                    abstract: true,
//                                    url: '/' + getUrl,
//                                    templateUrl: '/layout',
//                                })
                                .state('dashboard', {
                                    url: '/dashboard',
                                    templateUrl: '/dashboard',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Dashboard',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/lib/jquery/charts/sparkline/jquery.sparkline.js',
                                                                    '/backend/lib/jquery/charts/easypiechart/jquery.easypiechart.js',
                                                                    '/backend/lib/jquery/charts/flot/jquery.flot.js',
                                                                    '/backend/lib/jquery/charts/flot/jquery.flot.resize.js',
                                                                    '/backend/lib/jquery/charts/flot/jquery.flot.pie.js',
                                                                    '/backend/lib/jquery/charts/flot/jquery.flot.tooltip.js',
                                                                    '/backend/lib/jquery/charts/flot/jquery.flot.orderBars.js',
                                                                    '/backend/app/controllers/dashboard.js',
                                                                    '/backend/app/directives/realtimechart.js'
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state('user', {
                                    url: '/user/create',
                                    templateUrl: '/master-hr/create',
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create User',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('userIndex', {
                                    url: '/user/index',
                                    templateUrl: '/master-hr/',
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Users',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select','toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/hrController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('userUpdate', {
                                    url: '/user/update/:empId',
                                    templateUrl: function (stateParams) {
                                        return '/master-hr/' + stateParams.empId + '/edit';
                                    },
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit User',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                            '/backend/hrController.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('showpermissions', {
                                    url: '/user/showpermissions',
                                    templateUrl: '/master-hr/showpermissions',
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Permissions',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/hrController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('manageRoles', {
                                    url: '/user/manageroles',
                                    templateUrl: '/master-hr/manageRolesPermission',
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Roles',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/hrController.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('createrole', {
                                    url: '/user/createrole',
                                    templateUrl: '/master-hr/createrole',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Role Permissions',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/app/controllers/select.js',
                                                                            '/backend/hrController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('userPermissions', {
                                    url: '/user/permissions/:empId',
                                    templateUrl: function (stateParams) {
                                        return '/master-hr/userPermissions/' + stateParams.empId;
                                    },
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'User Permissions',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/app/controllers/accordion.js',
                                                                            '/backend/hrController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('rolePermissions', {
                                    url: '/role/permissions/:empId',
                                    templateUrl: function (stateParams) {
                                        return '/master-hr/rolePermissions/' + stateParams.empId;
                                    },
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Role Permissions',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/app/controllers/accordion.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('salesCreate', {
                                    url: '/sales/enquiry',
                                    templateUrl: '/master-sales/create',
                                    controller: 'customerController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'New Enquiry'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customerController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            //'/backend/enquiryController.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                
                                .state('createQuickEnquiry', {
                                    url: '/sales/quickEnquiry',
                                    templateUrl: '/master-sales/createQuickEnquiry',
                                    controller: 'customerController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Quick Enquiry'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customerController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            //'/backend/enquiryController.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                /*.state('enquiryCreate', {
                                 url: '/sales/createEnquiry/:customerId',
                                 templateUrl: function (stateParams) {
                                 return '/master-sales/showEnquiry/' + stateParams.customerId;
                                 },
                                 requiredLogin: true,
                                 ncyBreadcrumb: {
                                 label: 'Create New Enquiry'
                                 },
                                 resolve: {
                                 deps:
                                 [
                                 '$ocLazyLoad',
                                 function ($ocLazyLoad) {
                                 return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                 function () {
                                 return $ocLazyLoad.load({
                                 serie: true,
                                 files: [
                                 '/backend/enquiryController.js',
                                 '/backend/app/controllers/datepicker.js',
                                 '/backend/app/controllers/select.js',
                                 '/backend/app/controllers/timepicker.js',
                                 ]
                                 });
                                 })
                                 }   
                                 ]    
                                 }
                                 })*/
                                /*.state('salesIndex', {
                                 templateUrl: '/master-sales/create',
                                 controller: 'customerController',
                                 requiredLogin: true,
                                 ncyBreadcrumb: {
                                 label: 'Customer Details'
                                 },
                                 resolve: {
                                 deps:
                                 [
                                 '$ocLazyLoad',
                                 function ($ocLazyLoad) {
                                 return $ocLazyLoad.load('toaster').then(
                                 function () {
                                 return $ocLazyLoad.load({
                                 serie: true,
                                 files: [
                                 '/js/intlTelInput.js',
                                 '/backend/customerController.js',
                                 '/backend/app/controllers/datepicker.js',
                                 ]
                                 });
                                 }
                                 );
                                 }
                                 ]
                                 }
                                 })*/
                                .state('salesUpdateCustomer', {
                                    url: '/sales/update/cid/:customerId',
                                    templateUrl: function (stateParams) {
                                        return '/master-sales/editCustomer/cid/' + stateParams.customerId;
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Customer'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customerController.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('salesUpdateEnquiry', {
                                    url: '/sales/update/cid/:customerId/eid/:enquiryId',
                                    templateUrl: function (stateParams) {
                                        return '/master-sales/editEnquiry/cid/' + stateParams.customerId + '/eid/' + stateParams.enquiryId;
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Enquiry'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customerController.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/select.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('userChart', {
                                    url: '/user/orgchart',
                                    templateUrl: '/master-hr/orgchart',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Organization Chart',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/app/controllers/chartloader.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]

                                    }
                                })
                                .state('projectCreate', {
                                    url: '/project/create',
                                    templateUrl: '/projects/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Project'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/projectController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('projectWebPage', {
                                    url: '/project/webpage',
                                    templateUrl: '/projects/webPage',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Project Configurations'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'textAngular', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/app/controllers/select.js',
                                                                            '/backend/projectController.js',
                                                                            '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                /*.state('projectWebPageId', {
                                 url: '/project/webpage/:projectId',
                                 templateUrl: function (stateParams) {
                                 return '/projects/getProjectDetails/' + stateParams.projectId;
                                 },
                                 requiredLogin: true,
                                 ncyBreadcrumb: {
                                 label: 'Project Configurations'
                                 },
                                 resolve: {
                                 deps: [
                                 '$ocLazyLoad',
                                 function ($ocLazyLoad) {
                                 return $ocLazyLoad.load({
                                 serie: true,
                                 files: [
                                 ]
                                 });
                                 }
                                 ]
                                 }
                                 })*/
                                .state('manageProjectIndex', {
                                    url: '/project/index',
                                    templateUrl: '/projects/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage project',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/projectController.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('wingsIndex', {
                                    url: '/wings/index',
                                    templateUrl: '/wings/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Wings'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/wingsController.js'
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('wingsCreate', {
                                    url: '/wings/create',
                                    templateUrl: '/wings/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Wings'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/wingsController.js'
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('wingsUpdate', {
                                    url: '/wings/update/:id',
                                    templateUrl: function (setParams)
                                    {
                                        return '/wings/' + setParams.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Update Wings'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/wingsController.js'
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                /*************************** Promotional SMS ****************/

                                .state('promotionalsms', {
                                    url: '/promotionalsms/index',
                                    templateUrl: '/promotionalsms/',
                                    controller: 'promotionalsmsController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Promotional SMS',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster', 'ui.select']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/app/controllers/select2.js',
                                                                ]
                                                            });
                                                        }
                                                );

                                            }
                                        ]
                                    }
                                })
                                .state('smslogs', {
                                    url: '/promotionalsms/smslogs',
                                    templateUrl: '/promotionalsms/smslogs',
                                    controller: 'promotionalsmsController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'SMS Logs',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );

                                            }

                                        ]
                                    }
                                })
                                .state('teamsmslogs', {
                                    url: '/promotionalsms/teamsmslogs',
                                    templateUrl: '/promotionalsms/teamsmslogs',
                                    controller: 'promotionalsmsController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team SMS Logs',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );

                                            }

                                        ]
                                    }
                                })

                                .state('detaillog', {
                                    url: '/promotionalsms/detaillog/:id/:eid',
                                    templateUrl: function (stateParams) {
                                        return '/promotionalsms/detaillog/' + stateParams.id + '/' + stateParams.eid;
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sms logs details',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/detaillogController.js',
                                                                        '/backend/app/controllers/select.js',
                                                                        '/backend/app/controllers/datepicker.js',
                                                                    ]
                                                                }]);
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })

                                .state('detailsmsconsumption', {
                                    url: '/promotionalsms/detailsmsconsumption/:id/:eid',
                                    templateUrl: function (stateParams) {
                                        return '/promotionalsms/detailsmsconsumption/' + stateParams.id + '/' + stateParams.eid;
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sms consumption',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/detaillogController.js',
                                                                        '/backend/app/controllers/select.js',
                                                                        '/backend/app/controllers/datepicker.js',
                                                                    ]
                                                                }]);
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })
//                                ------------------SMS Consumption-----------------------------

                                .state('smsLogDetails', {
                                    url: '/bmsConsumption/smsLogDetails/:id',
                                    templateUrl: function (stateParams) {
                                        return '/bmsConsumption/smsLogDetails/' + stateParams.id;
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sms consumption',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/smsConsumptionController.js',
                                                                        '/backend/app/controllers/select.js',
                                                                        '/backend/app/controllers/datepicker.js',
                                                                    ]
                                                                }]);
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })

                                .state('smsConsumption', {
                                    url: '/bmsConsumption/smsConsumption',
                                    templateUrl: '/bmsConsumption/smsConsumption',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sms Consumption'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/smsConsumptionController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('smsDetails', {
                                    url: '/bmsConsumption/smsLogDetails/:transactionId',
                                    templateUrl: function (stateParams) {
                                        return '/bmsConsumption/smsLogDetails/' + stateParams.transactionId;
                                    },
                                    controller: 'smsController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sms Details',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/smsConsumptionController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('smsReport', {
                                    url: '/bmsConsumption/smsReport',
                                    templateUrl: '/bmsConsumption/smsReport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sms Consumption'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/smsConsumptionController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('importEnquiryIndex', {
                                    url: '/sales/importEnquiry',
                                    templateUrl: '/master-sales/import',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Import Enquiry'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/enquiryController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                /************************************ UMA ******************************/
                                .state('propertyPortalIndex', {
                                    url: '/portalaccounts/index',
                                    templateUrl: '/propertyportals/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Project'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster', 'ui.select']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/propertyPortalsController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('propertyPortalAccounts', {
                                    url: '/portalaccounts/:portalTypeId',
                                    templateUrl: function (stateParams) {
                                        return '/propertyportals/' + stateParams.portalTypeId + '/showPortalAccounts';
                                    },
                                    controller: 'propertyPortalsController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Portal Accounts',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster', 'ui.select']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/propertyPortalsController.js',
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/app/controllers/select.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state('createPortalAccounts', {
                                    url: '/portalaccounts/create/:portalTypeId',
                                    templateUrl: function (stateParams) {
                                        return '/propertyportals/' + stateParams.portalTypeId + '/createAccount';
                                    },
                                    controller: 'propertyPortalsController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Add Portal Accounts',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster', 'ui.select']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/propertyPortalsController.js',
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/app/controllers/select.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state('updatePortalAccounts', {
                                    url: '/portalaccounts/update/:portaltypeId/:accountId',
                                    templateUrl: function (stateParams) {
                                        return '/propertyportals/' + stateParams.portaltypeId + '/' + stateParams.accountId + '/updatePortalAccount';
                                    },
                                    controller: 'propertyPortalsController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Portal Account',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster', 'ui.select']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/propertyPortalsController.js',
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/app/controllers/select.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state('webPagesIndex', {
                                    url: '/webpages/index',
                                    templateUrl: '/web-pages/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Web Page Management',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/webPageController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('webPagesUpdate', {
                                    url: '/webpages/update/:id',
                                    templateUrl: function (stateParams) {
                                        return '/web-pages/' + stateParams.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Web Page Management',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['textAngular', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/webPageController.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('emailConfigIndex', {
                                    url: '/emailConfig/index',
                                    templateUrl: '/email-config/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Email Account Configuration'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load(['ui.select', {
                                                                            serie: true,
                                                                            files: [
                                                                                '/backend/emailConfigController.js',
                                                                            ]
                                                                        }]
                                                                            );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('updateEmailConfig', {
                                    url: '/emailConfig/update/:id',
                                    templateUrl: function (setParams)
                                    {
                                        return '/email-config/' + setParams.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Email Account Configuration'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/emailConfigController.js',
                                                                    ]
                                                                }]);
                                                        });
                                            }
                                        ]
                                    }
                                })
                                .state('createEmailConfig', {
                                    url: '/emailConfig/create/',
                                    templateUrl: '/email-config/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Email Account Configuration'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load(['ui.select', {
                                                                            serie: true,
                                                                            files: [
                                                                                '/backend/emailConfigController.js',
                                                                            ]
                                                                        }]
                                                                            );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('employeeDeviceIndex', {
                                    url: '/employeeDevice/index',
                                    templateUrl: '/employee-device/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Employee Device Management'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load(['ui.select', {
                                                                            serie: true,
                                                                            files: [
                                                                                '/backend/employeeDeviceController.js',
                                                                            ]
                                                                        }]
                                                                            );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('employeeDeviceCreate', {
                                    url: '/employeeDevice/create',
                                    templateUrl: '/employee-device/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Add Device'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load(['ui.select', {
                                                                            serie: true,
                                                                            files: [
                                                                                '/backend/employeeDeviceController.js',
                                                                            ]
                                                                        }]
                                                                            );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('employeeDeviceUpdate', {
                                    url: '/employeeDevice/update/:id',
                                    templateUrl: function (setParam)
                                    {
                                        return '/employee-device/' + setParam.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Employee Device Management'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load(['ui.select', {
                                                                            serie: true,
                                                                            files: [
                                                                                '/backend/employeeDeviceController.js',
                                                                            ]
                                                                        }]
                                                                            );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('customerUpdate', {
                                    url: '/sales/updateCustomer/:id',
                                    templateUrl: function (setParams) {
                                        return '/master-sales/updateCustomer/' + setParams.id;
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Update Customer'

                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customerController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('manageCustomerUpdate', {
                                    url: '/customers/update/:custId',
                                    templateUrl: function (stateParams) {
                                        return '/customers/' + stateParams.custId + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Customer',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/CustomerDataController.js',
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })

                                .state('reassignenquiries', {
                                    url: '/sales/reassignenquiries',
                                    templateUrl: '/master-sales/reassignEnquiry/0',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Reassign Enquiries'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'textAngular', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('enquiries', {
                                    url: '/sales/totalenquiries',
                                    templateUrl: '/master-sales/totalEnquiry/0',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Total Enquiries'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'textAngular', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                            '/js/accordian.js', 
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('lostenquiries', {
                                    url: '/sales/lostenquiries',
                                    templateUrl: function () {
                                        return '/master-sales/lostEnquiries/0';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Lost Enquiries'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('bookedenquiries', {
                                    url: '/sales/bookedenquiries',
                                    templateUrl: function () {
                                        return '/master-sales/bookedEnquiries/0';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Booked Enquiry'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('todaysfollowups', {
                                    url: '/sales/todaysfollowups',
                                    templateUrl: function () {
                                        return '/master-sales/showTodaysFollowups/0';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Todays Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('pendingfollowups', {
                                    url: '/sales/pendingfollowups',
                                    templateUrl: function () {
                                        return '/master-sales/showPendingFollowups/0';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Pending Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('previousfollowups', {
                                    url: '/sales/previousfollowups',
                                    templateUrl: function () {
                                        return '/master-sales/showPreviousFollowups/0';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Previous Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('teamtotalenquiries', {
                                    url: '/sales/teamtotalEnquiries',
                                    templateUrl: '/master-sales/totalEnquiry/1',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Total Enquiries'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('teamlostenquiries', {
                                    url: '/sales/teamlostenquiries',
                                    templateUrl: function () {
                                        return '/master-sales/lostEnquiries/1';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Lost Enquiries'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('teambookedenquiries', {
                                    url: '/sales/teambookedenquiries',
                                    templateUrl: function () {
                                        return '/master-sales/bookedEnquiries/1';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Booked Enquiry'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('teamtodayfollowups', {
                                    url: '/sales/teamtodayfollowups',
                                    templateUrl: function () {
                                        return '/master-sales/showTodaysFollowups/1';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Todays Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]

                                    }
                                })
                                .state('teampendingfollowups', {
                                    url: '/sales/teampendingfollowups',
                                    templateUrl: function () {
                                        return '/master-sales/showPendingFollowups/1';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Pending Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('teampreviousfollowups', {
                                    url: '/sales/teampreviousfollowups',
                                    templateUrl: function () {
                                        return '/master-sales/showPreviousFollowups/1';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Previous Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })


                                /****************************UMA************************************/
                                /****************************MANDAR*********************************/
                                .state('cloudtelephony', {
                                    url: '/cloudtelephony/create',
                                    templateUrl: '/cloudtelephony/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Virtual Number Registration',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                    function () {
                                                        return $ocLazyLoad.load({
                                                            serie: true,
                                                            files: [
                                                                '/backend/cloudtelephonyController.js',
                                                                '/backend/app/controllers/datepicker.js',
                                                                '/backend/app/controllers/select.js',
                                                            ]
                                                        });
                                                    }
                                                );
                                            }
                                        ]
                                    }
                                })

                                .state('virtualnumberslist', {
                                    url: '/virtualnumber/index',
                                    templateUrl: '/virtualnumber/',
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Virtual Numbers',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );

                                            }

                                        ]
                                    }
                                })
                                
                                .state('extensionemplist', {
                                    url: '/extensionemployee/index',
                                    templateUrl: '/extensionemployee/viewextemployee',
                                    controller: 'extensionemployeeController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Extension Employees',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                         '/js/intlTelInput.js',
                                                                             '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                            '/backend/extensionemployeeController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                    ]
                                                                }]);
                                                        }
                                                );
                                            }

                                        ]
                                    }
                                })
                                
                               .state('numbersIndex', {

                                    url: '/cloudtelephony/index',
                                    templateUrl: '/cloudtelephony/',
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Virtual Numbers',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster']).then(
                                                   
                                                );
                                            }
                                        ]
                                    }
                                })


                                .state('recordUpdate', {
                                    url: '/cloudtelephony/update/:id',
                                    templateUrl: function (stateParams) {
                                        return '/cloudtelephony/' + stateParams.id + '/edit';
                                    },
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Number',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster']).then(
                                                    function () {
                                                        return $ocLazyLoad.load({
                                                            serie: true,
                                                            files: [
                                                                '/backend/app/controllers/datepicker.js',
                                                            ]
                                                        });
                                                    }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state('vnumberUpdate', {
                                    url: '/virtualnumber/update/:id',
                                    templateUrl: function (stateParams) {
                                        return '/virtualnumber/' + stateParams.id + '/edit';
                                    },
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Virtual Number',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                    '/backend/app/controllers/select.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );

                                            }

                                        ]
                                    }
                                })
                                .state('extensionMenu', {
                                    url: '/extensionmenu/view/:id',
                                    templateUrl: function (stateParams) {
                                        return '/extensionmenu/' + stateParams.id + '/viewData';
                                    },
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Extension Settings',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                    '/backend/app/controllers/select.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state('existingUpdate', {
                                    url: '/virtualnumber/existingupdate/:id',
                                    templateUrl: function (stateParams) {
                                        return '/virtualnumber/' + stateParams.id + '/existingUpdate';
                                    },
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Existing Customer Settings',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                    '/backend/app/controllers/select.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state('nonworkingUpdate', {
                                    url: '/virtualnumber/nonworkinghoursupdate/:id',
                                    templateUrl: function (stateParams) {
                                        return '/virtualnumber/' + stateParams.id + '/nonworkinghoursUpdate';
                                    },
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Non Working Hours',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                    '/backend/app/controllers/select.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );

                                            }

                                        ]
                                    }
                                })

//                                /**************************** Alerts Routing *****************************/
//                                .state('alertsIndex', {
//                                    url: '/alerts/index',
//                                    templateUrl: '/alerts/',
//                                    requiredLogin: true,
//                                    ncyBreadcrumb: {
//                                        label: 'Alerts'
//                                    },
//                                    resolve: {
//                                        deps: [
//                                            '$ocLazyLoad',
//                                            function ($ocLazyLoad) {
//                                                return $ocLazyLoad.load({
//                                                    serie: true,
//                                                    files: [
//                                                        '/backend/alertsController.js',
//                                                    ]
//                                                });
//                                            }
//                                        ]
//                                    }
//                                })
//                                .state('alertsUpdate', {
//                                    url: '/alerts/update/:id',
//                                    templateUrl: function (stateParams) {
//                                        return '/alerts/' + stateParams.id + '/edit';
//                                    },
//                                    requiredLogin: true,
//                                    ncyBreadcrumb: {
//                                        label: 'Edit Alert',
//                                        description: ''
//                                    },
//                                    resolve: {
//                                        deps: [
//                                            '$ocLazyLoad',
//                                            function ($ocLazyLoad) {
//                                                return $ocLazyLoad.load(['ui.select', {
//                                                        serie: true,
//                                                        files: [
//                                                            '/backend/alertsController.js',
//                                                            '/backend/app/controllers/select.js',
//                                                        ]
//                                                    }]);
//                                            }
//                                        ]
//                                    }
//                                })
//                                .state('customalertsIndex', {
//                                    url: '/customalerts/index',
//                                    templateUrl: '/customalerts/',
//                                    requiredLogin: true,
//                                    ncyBreadcrumb: {
//                                        label: 'Custome Alters'
//                                    },
//                                    resolve: {
//                                        deps: [
//                                            '$ocLazyLoad',
//                                            function ($ocLazyLoad) {
//                                                return $ocLazyLoad.load({
//                                                    serie: true,
//                                                    files: [
//                                                        '/backend/customalertsController.js',
//                                                    ]
//                                                });
//                                            }
//                                        ]
//                                    }
//                                })
//                                .state('customalertcreate', {
//                                    url: '/customalerts/create',
//                                    templateUrl: '/customalerts/create',
//                                    requiredLogin: true,
//                                    ncyBreadcrumb: {
//                                        label: 'Create Custome Alert',
//                                        description: ''
//                                    },
//                                    resolve: {
//                                        deps: [
//                                            '$ocLazyLoad',
//                                            function ($ocLazyLoad) {
//                                                return $ocLazyLoad.load(['ui.select', {
//                                                        serie: true,
//                                                        files: [
//                                                            '/backend/customalertsController.js',
//                                                            '/backend/app/controllers/select.js',
//                                                        ]
//                                                    }]);
//                                            }
//                                        ]
//                                    }
//                                })
//                                .state('customalertsUpdate', {
//                                    url: '/customalerts/update/:id',
//                                    templateUrl: function (stateParams) {
//                                        return '/customalerts/' + stateParams.id + '/edit';
//                                    },
//                                    requiredLogin: true,
//                                    ncyBreadcrumb: {
//                                        label: 'Edit Custome Alert',
//                                        description: ''
//                                    },
//                                    resolve: {
//                                        deps: [
//                                            '$ocLazyLoad',
//                                            function ($ocLazyLoad) {
//                                                return $ocLazyLoad.load(['ui.select', {
//                                                        serie: true,
//                                                        files: [
//                                                            '/backend/customalertsController.js',
//                                                            '/backend/app/controllers/select.js',
//                                                        ]
//                                                    }]);
//                                            }
//                                        ]
//                                    }
//                                })
//                                .state('defaultalertsIndex', {
//                                    url: '/defaultalerts/index',
//                                    templateUrl: '/defaultalerts/',
//                                    requiredLogin: true,
//                                    ncyBreadcrumb: {
//                                        label: 'Custome Alters'
//                                    },
//                                    resolve: {
//                                        deps: [
//                                            '$ocLazyLoad',
//                                            function ($ocLazyLoad) {
//                                                return $ocLazyLoad.load({
//                                                    serie: true,
//                                                    files: [
//                                                        '/backend/defaultalertsController.js',
//                                                    ]
//                                                });
//                                            }
//                                        ]
//                                    }
//                                })
//                                .state('dafaultalertcreate', {
//                                    url: '/dafaultalerts/create',
//                                    templateUrl: '/defaultalerts/create',
//                                    requiredLogin: true,
//                                    ncyBreadcrumb: {
//                                        label: 'Create Custome Alert',
//                                        description: ''
//                                    },
//                                    resolve: {
//                                        deps: [
//                                            '$ocLazyLoad',
//                                            function ($ocLazyLoad) {
//                                                return $ocLazyLoad.load(['ui.select', {
//                                                        serie: true,
//                                                        files: [
//                                                            '/backend/defaultalertsController.js',
//                                                        ]
//                                                    }]);
//                                            }
//                                        ]
//                                    }
//                                })
//                                .state('defaultalertsUpdate', {
//                                    url: '/defaultalerts/update/:id',
//                                    templateUrl: function (stateParams) {
//                                        return '/defaultalerts/' + stateParams.id + '/edit';
//                                    },
//                                    requiredLogin: true,
//                                    ncyBreadcrumb: {
//                                        label: 'Edit Default Alert',
//                                        description: ''
//                                    },
//                                    resolve: {
//                                        deps: [
//                                            '$ocLazyLoad',
//                                            function ($ocLazyLoad) {
//                                                return $ocLazyLoad.load(['ui.select', {
//                                                        serie: true,
//                                                        files: [
//                                                            '/backend/defaultalertsController.js',
//                                                        ]
//                                                    }]);
//                                            }
//                                        ]
//                                    }
//                                })
//                                /**************************** Alerts Routing *****************************/


                                /**************************** Alerts Routing *****************************/
                                .state('alertsIndex', {
                                    url: '/alerts/index',
                                    templateUrl: '/alerts/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Template Settings'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['textAngular', 'toaster', 'ui.select']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/app/controllers/select.js',
                                                                    '/backend/alertsController.js',
                                                                ]
                                                            });
                                                        }
                                                );

                                            }
                                        ]
                                    }
                                })
                                .state('alertsUpdate', {
                                    url: '/alerts/update/:id',
                                    templateUrl: function (stateParams) {
                                        return '/alerts/' + stateParams.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Template Settings',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/alertsController.js',
                                                                    '/backend/app/controllers/select.js',
                                                                ]
                                                            });

                                                        }
                                                );

                                            }
                                        ]
                                    }
                                })
                                .state('customalertsIndex', {
                                    url: '/customalerts/index',
                                    templateUrl: '/customalerts/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Custom Templates'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster', 'textAngular']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/customalertsController.js',
                                                                    '/backend/app/controllers/textangular.js',
                                                                ]
                                                            });
                                                        });
                                            }
                                        ]
                                    }
                                })
                                .state('customalertcreate', {
                                    url: '/customalerts/create',
                                    templateUrl: '/customalerts/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Custom Templates',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster', 'textAngular']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/customalertsController.js',
                                                                        '/backend/app/controllers/select.js',
                                                                        '/backend/app/controllers/textangular.js',
                                                                    ]
                                                                }]);
                                                        });
                                            }
                                        ]
                                    }
                                })
                                .state('customalertsUpdate', {
                                    url: '/customalerts/update/:id',
                                    templateUrl: function (stateParams) {
                                        return '/customalerts/' + stateParams.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Custom Templates',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster', 'textAngular']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/customalertsController.js',
                                                                        '/backend/app/controllers/select.js',
                                                                        '/backend/app/controllers/textangular.js',
                                                                    ]
                                                                }]);
                                                        });
                                            }
                                        ]
                                    }
                                })
                                .state('defaultalertsIndex', {
                                    url: '/defaultalerts/index',
                                    templateUrl: '/defaultalerts/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Default Templates'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/backend/defaultalertsController.js',
                                                                ]
                                                            });
                                                        });
                                            }
                                        ]
                                    }
                                })
                                .state('dafaultalertcreate', {
                                    url: '/dafaultalerts/create',
                                    templateUrl: '/defaultalerts/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Custom Templates',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/defaultalertsController.js',
                                                                    ]
                                                                }]);
                                                        });
                                            }
                                        ]
                                    }
                                })
                                .state('defaultalertsUpdate', {
                                    url: '/defaultalerts/update/:id',
                                    templateUrl: function (stateParams) {
                                        return '/defaultalerts/' + stateParams.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Default Templates',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/defaultalertsController.js',
                                                                    ]
                                                                }]);
                                                        });
                                            }
                                        ]
                                    }
                                })
                                /**************************** Alerts Routing *****************************/
                                /****************************MANDAR*********************************/
                                /****************************MANOJ*********************************/
                                .state('bloodGroupsIndex', {
                                    url: '/bloodgroups/index',
                                    templateUrl: '/blood-groups/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage blood groups',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/bloodGroupsController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('countryIndex', {
                                    url: '/country/index',
                                    templateUrl: '/manage-country/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Country',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/countryController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('statesIndex', {
                                    url: '/states/index',
                                    templateUrl: '/manage-states/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage State',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/statesController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('cityIndex', {
                                    url: '/city/index',
                                    templateUrl: '/manage-city/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage City',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/cityController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('locationIndex', {
                                    url: '/location/index',
                                    templateUrl: '/manage-location/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Location',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/locationController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('highesteducationIndex', {
                                    url: '/highesteducation/index',
                                    templateUrl: '/highest-education/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Highest Education',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/highestEducationController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('departmentIndex', {
                                    url: '/department/index',
                                    templateUrl: '/manage-department/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Department',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/departmentController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('professionIndex', {
                                    url: '/profession/index',
                                    templateUrl: '/manage-profession/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Profession',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/professionController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('paymentheadingIndex', {
                                    url: '/paymentheading/index',
                                    templateUrl: '/payment-headings/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Payment Heading',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/projectPaymentController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('lostreasonsIndex', {
                                    url: '/lostreasons/index',
                                    templateUrl: '/lost-reasons/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Lost Reasons'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/lostReasonController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('blockStagesIndex', {
                                    url: '/blockstages/index',
                                    templateUrl: '/block-stages/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage block stages'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/blockStagesController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('enquirySourceIndex', {
                                    url: '/enquirySource/index',
                                    templateUrl: '/enquiry-source/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage enquiry source'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/enquirySourceController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('discountheadingIndex', {
                                    url: '/discountheading/index',
                                    templateUrl: '/discount-headings/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Discount Heading'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/discountHeadingController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('projectstagesIndex', {
                                    url: '/projectstages/index',
                                    templateUrl: '/project-payment/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage payment stages'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/projectPaymentStagesController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('projecttypesIndex', {
                                    url: '/projecttypes/index',
                                    templateUrl: '/project-types/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Project Types'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/projectTypesController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('blocktypesIndex', {
                                    url: '/blocktypes/index',
                                    templateUrl: '/block-types/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Block Types'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/blockTypesController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('contactusIndex', {
                                    url: '/contactus/index',
                                    templateUrl: '/contact-us/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Contact Us'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/contactUsController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('socialwebsiteIndex', {
                                    url: '/social-website/index',
                                    templateUrl: '/social-website/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage social website'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/socialWebsiteController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('assignenquiryIndex', {
                                    url: '/assignenquiry/index',
                                    templateUrl: '/assign-enquiry/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage auto assign web enquiries'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/AssignWebEnquiryController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('manageblogIndex', {
                                    url: '/blog/index',
                                    templateUrl: '/manage-blog/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Blog Management'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/manageBlogController.js',                                                  
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('createBlog', {
                                    url: '/blog/create',
                                    templateUrl: '/manage-blog/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create blog',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['textAngular', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/manageBlogController.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('blogUpdate', {
                                    url: '/blog/update/:blogId',
                                    templateUrl: function (stateParams) {
                                        return '/manage-blog/' + stateParams.blogId + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Blog',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['textAngular', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/manageBlogController.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('testimonialsIndex', {
                                    url: '/testimonials/index',
                                    templateUrl: '/testimonials/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Approve Testimonials',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/testimonialsController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('testimonialUpdate', {
                                    url: '/testimonials/update/:testimonialId',
                                    templateUrl: function (stateParams) {
                                        return '/testimonials/' + stateParams.testimonialId + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Testimonial',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/testimonialsController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('testimonialManage', {
                                    url: '/testimonials-manage/update/:testimonialId',
                                    templateUrl: function (stateParams) {
                                        return '/testimonials/' + stateParams.testimonialId + '/editApproved';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Update Testimonial',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/testimonialsController.js',
                                                                        ]
                                                                    });
                                                                })
                                                    }

                                                ]
                                    }
                                })
                                .state('testimonialsCreate', {
                                    url: '/testimonials/create',
                                    templateUrl: '/testimonials/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Testimonial',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/testimonialsController.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('testimonialsManage', {
                                    url: '/testimonials/manage',
                                    templateUrl: '/testimonials/manage',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Testimonials',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/testimonialsController.js',
                                                                            '/backend/app/controllers/datepicker.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('manageJobIndex', {
                                    url: '/job-posting/index',
                                    templateUrl: '/manage-job/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Career',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/careerManagementController.js',
                                                                            '/backend/app/controllers/datepicker.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('createJobIndex', {
                                    url: '/job-posting/create',
                                    templateUrl: '/create-Job/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create job posting',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/careerManagementController.js',
                                                                            '/backend/app/controllers/datepicker.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('careerUpdate', {
                                    url: '/job-posting/update/:jobId',
                                    templateUrl: function (stateParams) {
                                        return '/manage-job/' + stateParams.jobId + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Update career',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/careerManagementController.js',
                                                                            '/backend/app/controllers/datepicker.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('careerShow', {
                                    url: '/job-posting/show/:jobId',
                                    templateUrl: function (stateParams) {
                                        return '/manage-job/' + stateParams.jobId + '/show';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'View application',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/careerManagementController.js',
                                                                            '/backend/app/controllers/datepicker.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('requestLeaveIndex', {
                                    url: '/request-leave/index',
                                    templateUrl: '/request-leave/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Request leave',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/dashBoardController.js',
                                                                            '/backend/app/controllers/datepicker.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('requestOtherApprovalIndex', {
                                    url: '/request-approval/index',
                                    templateUrl: '/request-approval/index',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Request other approval',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/dashBoardController.js',
                                                                            '/backend/app/controllers/datepicker.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('requestForMeIndex', {
                                    url: '/request-for-me/index',
                                    templateUrl: '/request-for-me/index',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Request for me',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/dashBoardController.js',
                                                                            '/backend/app/controllers/datepicker.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('myRequestIndex', {
                                    url: '/my-request/index',
                                    templateUrl: '/my-request/index',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'My request',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/dashBoardController.js',
                                                                            '/backend/app/controllers/datepicker.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('operationalSettingIndex', {
                                    url: '/operational-setting/index',
                                    templateUrl: '/operational-setting/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage operational settings',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/opeartionalSettingsController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('enquirylocationIndex', {
                                    url: '/enquiry-location/index',
                                    templateUrl: '/enquiry-location/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Enquiry Location',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/enquiryLocationController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })


                                .state('designationsIndex', {
                                    url: '/manage-designations/index',
                                    templateUrl: '/manage-designations/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Designations',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/designationsController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('storageListIndex', {
                                    url: '/storage-list/index',
                                    templateUrl: '/storage-list/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Storage',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/storageController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('sharedWithMe', {
                                    url: '/sharedwith-me/index',
                                    templateUrl: '/sharedwith-me/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Storage',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/storageController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('recycleBin', {
                                    url: '/recycle-bin/index',
                                    templateUrl: '/recycle-bin/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Storage',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/storageController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('allFiles', {
                                    url: '/storage-list/getAllList/:folderId',
                                    templateUrl: function (stateParams) {
                                        return '/storage-list/' + stateParams.folderId + '/allfiles';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Storage',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/storageController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('allMyFiles', {
                                    url: '/storage-list/getAllMyList/:filename',
                                    templateUrl: function (stateParams) {
                                        return '/storage-list/' + stateParams.filename + '/allmyfiles';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Storage',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/storageController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('getSubFolderImages', {
                                    url: '/storage-list/getSubFolderImages/:filename',
                                    templateUrl: function (stateParams) {

                                        return '/storage-list/' + stateParams.filename + '/getSubFolderImages';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Storage',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/storageController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('getAllListToRestore', {
                                    url: '/storage-list/getAllListToRestore/:filename',
                                    templateUrl: function (stateParams) {
                                        return '/storage-list/' + stateParams.filename + '/getAllListToRestore';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Storage',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/storageController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('SubFolderRestore', {
                                    url: '/storage-list/SubFolderRestore/:filename',
                                    templateUrl: function (stateParams) {
                                        return '/storage-list/' + stateParams.filename + '/SubFolderRestore';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Storage',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/storageController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('getMySubFolderImages', {
                                    url: '/storage-list/getMySubFolderImages/:filename',
                                    templateUrl: function (stateParams) {
                                        return '/storage-list/' + stateParams.filename + '/getMySubFolderImages';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Storage',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/storageController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('userDocument', {
                                    url: '/user-document/index',
                                    templateUrl: '/user-document/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'User Documents',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/userDocumentController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('documentIndex', {
                                    url: '/employee-document/index',
                                    templateUrl: '/employee-document/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Employee Documents',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/EmployeeDocumentController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })


                                .state('companiesIndex', {
                                    url: '/companies/index',
                                    templateUrl: '/manage-companies/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage company',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/FirmsAndPartnersController.js'
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('companiesCreate', {
                                    url: '/companies/create',
                                    templateUrl: '/manage-companies/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage company',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/FirmsAndPartnersController.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })

                                .state('companiesUpdate', {
                                    url: '/companies/edit/:companyId',
                                    templateUrl: function (stateParams) {

                                        return '/manage-companies/' + stateParams.companyId + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage company',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/FirmsAndPartnersController.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })


                                .state('bankAccountsIndex', {
                                    url: '/bank-accounts/index',
                                    templateUrl: '/bank-accounts/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage bank accounts',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/BankAccountsController.js',
                                                                            '/backend/app/controllers/select.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })

                                .state('customersIndex', {
                                    url: '/customers/index',
                                    templateUrl: '/customers/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Customers',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/CustomerDataController.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('projectAvailability', {
                                    url: '/manage-project/availability',
                                    templateUrl: '/projects/availability',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Project Availability',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/projectController.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })

//                                .state('manageProjectIndex', {
//                                    url: '/manage-project/index',
//                                    templateUrl: '/projects/manage',
//                                    requiredLogin: true,
//                                    ncyBreadcrumb: {
//                                        label: 'Manage project',
//                                        description: ''
//                                    },
//                                    resolve: {
//                                        deps:
//                                                [
//                                                    '$ocLazyLoad',
//                                                    function ($ocLazyLoad) {
//                                                        return $ocLazyLoad.load(['toaster']).then(
//                                                                function () {
//                                                                    return $ocLazyLoad.load({
//                                                                        serie: true,
//                                                                        files: [
//                                                                            '/backend/projectController.js',
//                                                                        ]
//                                                                    });
//                                                                });
//                                                    }
//                                                ]
//                                    }
//                                })
                                .state('availbleProjects', {
                                    url: '/projects/availability/:projectId',
                                    templateUrl: function (stateParams) {
                                        return '/projects/' + stateParams.projectId + '/availability';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Project Availability',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/projectController.js',
                                                            '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })

                                .state('webChangeModuleIndex', {
                                    url: '/website/change-module',
                                    templateUrl: '/website/change-module',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Website Change Module',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/websiteChangeModule.js',
                                                            '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('webThemesIndex', {
                                    url: '/website/themes',
                                    templateUrl: '/website-themes/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Website Themes',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/websiteThemes.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })

                                .state('enquiryReport', {
                                    url: '/reports/enquiryReport',
                                    templateUrl: '/reports/getEnquiryReport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Enquiry Report'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/reportsController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                });
                                                    }
                                                ]
                                    }
                                })

                                .state('followupReport', {
                                    url: '/reports/followupReport',
                                    templateUrl: '/reports/followupReport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Followup Report'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/reportsController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })

                                .state('projectwiseReport', {
                                    url: '/reports/projectwiseReport',
                                    templateUrl: '/reports/projectwiseReport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sales Report'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/reportsController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('teamenquiryReport', {
                                    url: '/reports/teamEnquiryReport',
                                    templateUrl: '/reports/getTeamEnquiryreports',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Enquiry Report'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/reportsController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('teamfollowupReport', {
                                    url: '/reports/teamFollowupReport',
                                    templateUrl: '/reports/teamfollowupReport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Followup Reports'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/reportsController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('projectwiseTeamreport', {
                                    url: '/reports/projectwiseTeamReport',
                                    templateUrl: '/reports/projectwiseTeamreport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Project wise Reports'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/reportsController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })

                                .state('projectOverviewReport', {
                                    url: '/reports/projectOverviewReport',
                                    templateUrl: '/reports/projectOverviewReport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Project wise Reports'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load('toaster').then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/reportsController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                /****************************MANOJ*********************************/
                                /****************************Archana*********************************/

                                .state('inboundLogs', {
                                    url: '/cloudcallinglogs/myIncomingLogs',
                                    templateUrl: function (stateParams) {
                                        return '/cloudcallinglogs/myIncomingLogs';
                                    },
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'My Inbound Logs',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster','ui.select']).then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/app/controllers/datepicker.js',
                                                                        '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                        '/backend/app/controllers/select.js',
                                                                    ]
                                                                });
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })

                                .state('teaminboundLogs', {
                                    url: '/cloudcallinglogs/teamIncomingLogs',
                                    templateUrl: function (stateParams) {
                                        return '/cloudcallinglogs/teamIncomingLogs';
                                    },
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Inbound Logs',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster','ui.select']).then(
                                                        function () {
                                                            return $ocLazyLoad.load( {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/app/controllers/datepicker.js',
                                                                        '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                        '/backend/app/controllers/select.js',
                                                                    ]
                                                                });
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })

                                .state('outboundLogs', {
                                    url: '/cloudcallinglogs/myOutgoingLogs',
                                    templateUrl: function (stateParams) {
                                        return '/cloudcallinglogs/myOutgoingLogs';
                                    },
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'My Outbound Logs',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/app/controllers/datepicker.js',
                                                                        '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                        '/backend/app/controllers/select2.js',
                                                                    ]
                                                                }]);
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })

                                .state('teamoutboundLogs', {
                                    url: '/cloudcallinglogs/teamOutgoingLogs',
                                    templateUrl: function (stateParams) {
                                        return '/cloudcallinglogs/teamOutgoingLogs';
                                    },
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Outbound Logs',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['toaster']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(['ui.select', {
                                                                    serie: true,
                                                                    files: [
                                                                        '/backend/app/controllers/datepicker.js',
                                                                        '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                                        '/backend/app/controllers/select2.js',
                                                                    ]
                                                                }]);
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })


                                /****************************Rohit*********************************/
                                .state('quickUser', {
                                    url: '/user/quickuser',
                                    templateUrl: '/master-hr/quickuser',
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: ' User Management ',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/hrController.js',
                                                                            '/backend/app/controllers/select.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                        ]
                                                                    }
                                                                    );
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('userProfile', {
                                    url: '/user/profile',
                                    templateUrl: function (stateParams) {
                                        return '/master-hr/profile';
                                    },
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Profile',
                                        description: ''
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/hrController.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                /****************************Rohit*********************************/
                                .state('underconstruction', {
                                    url: '/underconstruction',
                                    templateUrl: '/undercConstruction',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Page Under Construction'
                                    },
                                })
                                .state('login', {
                                    url: '/login',
                                    templateUrl: '/login', //laravel slug
                                    requiredLogin: false,
                                    ncyBreadcrumb: {
                                        label: 'Login'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(
                                                        {
                                                            serie: true,
                                                            files: [
                                                                '/backend/assets/css/login.css'
                                                            ]
                                                        });
                                            }
                                        ]
                                    }
                                })
                                .state('logout', {
                                    url: '/logout',
                                    templateUrl: '/logout',
                                    requiredLogin: false,
                                    ncyBreadcrumb: {
                                        label: 'Logout'
                                    }
                                })

                                .state('forgotPassword', {
                                    url: '/office/forgotPassword',
                                    templateUrl: '/password/resetLink/backend',
                                    requiredLogin: false,
                                    ncyBreadcrumb: {
                                        label: 'Forgot Password'
                                    }
                                })
                                .state('resetPassword', {
                                    url: '/resetPassword/:resetToken',
                                    requiredLogin: false,
                                    templateUrl: function (params) {
                                        return '/password/reset/' + params.resetToken + '/backend';
                                    },
                                    ncyBreadcrumb: {
                                        label: 'Reset Password'
                                    }
                                })
                                .state('register', {
                                    url: '/register',
                                    templateUrl: '/register',
                                    requiredLogin: false,
                                    ncyBreadcrumb: {
                                        label: 'Register'
                                    }
                                })
                                .state('lock', {
                                    url: '/lock',
                                    templateUrl: 'views/lock.html',
                                    ncyBreadcrumb: {
                                        label: 'Lock Screen'
                                    }
                                })
                                .state('error404', {
                                    url: '/error404',
                                    templateUrl: 'views/error-404.html',
                                    ncyBreadcrumb: {
                                        label: 'Error 404 - The page not found'
                                    }
                                })
                                .state('error500', {
                                    url: '/error500',
                                    templateUrl: '/error500',
                                    ncyBreadcrumb: {
                                        label: 'Error 500 - something went wrong'
                                    }
                                });
                        // $locationProvider.html5Mode(true);
                    }
                ]).run(function ($rootScope, $location, $state, Data, $http, $window, $stateParams) {
    var nextUrl = $location.path();
    $rootScope.authenticated = false;
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
    $rootScope.getMenu = {};
    $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams, next, current) {
        if ((toState.requiredLogin && $rootScope.authenticated === false) || (!toState.requiredLogin && $rootScope.authenticated === false)) { // true && false
            Data.get('session').then(function (results) {
                var modifiedUrl = nextUrl.substr(nextUrl.lastIndexOf('/') + 0);
                if (results.success === true) {
                    $rootScope.authenticated = true;
                    $rootScope.id = results.id;
                    $rootScope.name = results.name;
                    $rootScope.email = results.email;
                    $window.sessionStorage.setItem("userLoggedIn", true);
                    $http.get('/getMenuItems').then(function (response) {
                        $rootScope.getMenu = response.data;
                    }, function (error) {
                        alert('Error');
                    });
                    modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
                    if (nextUrl === '/register' || nextUrl === '/login' || nextUrl === '/forgotPassword' || modifiedUrl === '/resetPassword') {
                        $state.transitionTo("dashboard");
                        event.preventDefault();
                        return false;
                    }
                } else {
                    modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
                    if (nextUrl === '/register' || nextUrl === '/login' || nextUrl === '/forgotPassword' || modifiedUrl === '/resetPassword') {
                        event.preventDefault();
                        return false;
                    } else {
                        $state.go('login');
                        event.preventDefault();
                        return false;
                    }
                }
            });
        }
        if (!toState.requiredLogin && $rootScope.authenticated === true) //false && true
        {
            $state.go('dashboard');
            $state.reload();
            event.preventDefault();
            return false;
        }
    });
});