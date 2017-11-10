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
                                        title: 'Dashboard',
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
                                        parent: 'userIndex',
                                        label: 'Add New User',
                                        title: 'Add New User',
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
                                        label: 'HR / User Management / Manage Users',
                                        title: 'Manage Users',
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
                                        parent: 'userIndex',
                                        label: 'Edit User',
                                        title: 'Edit User',
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
                                        parent: 'userIndex',
                                        label: 'Permission Wise Users',
                                        title: 'Permission Wise Users',
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
                                        label: 'HR / Role Management / Manage Roles',
                                        title: 'Manage Roles',
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
                                        label: 'HR / Role Management / Create Role',
                                        title: 'Create Role',
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
                                        parent: 'userIndex',
                                        label: 'User Permissions',
                                        title: 'User Permissions',
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
                                                                            '/backend/app/controllers/accordion.js',
                                                                            '/backend/hrController.js',
                                                                            '/backend/app/controllers/select2.js',
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
                                        parent: 'manageRoles',
                                        label: 'Role Permissions',
                                        title: 'Role Permissions',
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
                                        label: 'Sales / Detailed Enquiry',
                                        title: 'Detailed Enquiry',
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
                                        label: 'Sales/ Pre Sales / Quick Enquiry',
                                        title: 'Quick Enquiry',
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
                                        parent: function($rootScope){
                                            return $rootScope.parentBreadcrumbFlag;
                                        }, 
                                        label: 'Edit Customer',
                                        title: 'Edit Customer',
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
                                        parent:function($rootScope){
                                            return $rootScope.parentBreadcrumbFlag;
                                        },
                                        label: 'Edit Enquiry',
                                        title: 'Edit Enquiry',
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
                                        label: 'HR / User Management / Organization Chart',
                                        title: 'Organization Chart',
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
                                    url: '/projects/create',
                                    templateUrl: '/projects/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'manageProjectIndex',
                                        label: 'Create Project',
                                        title: 'Create Project',
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
                                    url: '/projects/webpageIndex',
                                    templateUrl: '/projects/webpageIndex',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        title: 'Project Configurations',
                                        label: 'Project Configurations',
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load().then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/projectController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('projectWebPageDetails', {
                                    url: '/projects/webpageDetails/:projectId',
                                    templateUrl: function (stateParams) {
                                        return '/projects/webpageDetails/' + stateParams.projectId;
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'manageProjectIndex',
                                        label: 'Project Details',
                                        title: 'Project Details',
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
                                .state('manageProjectIndex', {
                                    url: '/projects/index',
                                    templateUrl: '/projects/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Projects / Projects Management / Manage project',
                                        title: 'Manage project',
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
                                        title: 'Manage Wings',
                                        label: 'Manage Wings',
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
                                        parent: 'wingsIndex',
                                        title: 'Create Wings',
                                        label: 'Create Wings',
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
                                        parent: 'wingsIndex',
                                        title: 'Update Wings',
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
                                        label: 'Marketing / Promotional SMS / Send SMS',
                                        title: 'Send SMS',
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
                                        label: 'Marketing / Promotional SMS / SMS Logs',
                                        title: 'SMS Logs',
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
                                        label: 'Marketing / Promotional SMS / Team SMS Logs',
                                        title: 'Team SMS Logs',
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
                                        parent: 'smslogs',
                                        label: 'Sms logs details',
                                        title: 'Sms logs details',
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
                                        label: 'Sms Consumption',
                                        title: 'Sms Consumption',
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
                                        label: 'Sms Consumption',
                                        title: 'Sms Consumption',
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
                                        label: 'BMS / BMS Consumption / Sms Consumption',
                                        title: 'Sms Consumption',
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
                                .state('smsConsumptionlogs', {
                                    url: '/bmsConsumption/smsLogs',
                                    templateUrl: '/bmsConsumption/smsLogs',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'smsConsumption',
                                        label: 'SMS Logs',
                                        title: 'Sms Logs',
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
                                        label: 'BMS / BMS Consumption / Sms Details',
                                        title: 'Sms Details',
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
                                        label: 'Sms Consumption',
                                        title: 'Sms consumption',
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
                                    url: '/sales/importEnquiries',
                                    templateUrl: '/master-sales/import',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        title: 'Import Enquiries',
                                        label: 'Sales /  Customers Management / Import Enquiries',
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
                                        label: 'BMS / BMS Settings / Property Portals ',
                                        title: 'Create Project',
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
                                                                    });
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
                                        parent:'propertyPortalIndex',
                                        label: 'Accounts Details',
                                        title: 'Accounts Details',
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
                                        parent:'propertyPortalAccounts',
                                        label: 'Add Portal Accounts',
                                        title: 'Add Portal Accounts',
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
//                                        parent:'propertyPortalAccounts',
                                        label: 'Edit Portal Account',
                                        title: 'Edit Portal Account',
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
                                        label: 'BMS / Website Settings / Content Management',
                                        title: 'Content Management',
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
                                        parent: 'webPagesIndex',
                                        label: 'Edit Content',
                                        title: 'Edit Content',
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
                                        label: 'BMS / BMS Settings / Configure Email Accounts / Email Account Configuration'
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
                                        parent: 'emailConfigIndex',
                                        label: 'Edit Email Account Configuration'
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
                                        label: 'BMS / BMS Settings / Device Configuration / Employee Device Management',
                                        title: 'Employee Device Management',
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
                                        parent: 'employeeDeviceIndex',
                                        label: 'Add Device Details',
                                        title: 'Add Device Details',
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
                                        parent: 'employeeDeviceIndex',
                                        label: 'Edit Device Details',
                                        title: 'Edit Device Details'
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
                                        label: 'Update Customer',
                                        title: 'Update Customer',
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
                                        parent: 'customersIndex',
                                        label: 'Edit Customer',
                                        title: 'Edit Customer',
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
                                        label: 'Sales / Pre Sales / My Reassigned Enquiries',
                                        title: 'Reassigned Enquiries',
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
                                .state('enquiries', {
                                    url: '/sales/totalenquiries',
                                    templateUrl: '/master-sales/totalEnquiry/0',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sales / Pre Sales / My Total Enquiries',
                                        title: 'Total Enquiries',
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
                                        label: 'Sales / Pre Sales / My Lost Enquiries',
                                        title: 'Lost Enquiries',
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
                                                                            '/js/accordian.js',
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
                                        label: 'Sales / Pre Sales / My Booked Enquiry',
                                        title: 'Booked Enquiry',
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select','textAngular', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                            '/js/accordian.js',
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
                                        label: 'Sales / Pre Sales / My Today\'\s Followups',
                                        title: 'Today\'\s Followups',
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select','textAngular', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                            '/js/accordian.js',
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
                                        label: 'Sales / Pre Sales / My Pending Followups',
                                        title: 'Pending Followups',
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
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                            '/js/accordian.js',
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
                                        label: 'Sales / Pre Sales / My Previous Followups',
                                        title: 'Previous Followups',
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
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                            '/js/accordian.js',
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
                                    templateUrl: '/master-sales/teamTotalEnquiry/1',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sales / Pre Sales / Team\'\s Enquiries / Team\'\s Total Enquiries',
                                        title: 'Team\'\s Total Enquiries',
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['textAngular','ui.select', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/enquiryController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select.js',
                                                                            '/js/accordian.js',
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

                                .state('teamlostenquiries', {
                                    url: '/sales/teamlostenquiries',
                                    templateUrl: function () {
                                        return '/master-sales/teamLostEnquiries/1';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sales / Pre Sales / Team\'\s Enquiries / Team\'\s Lost Enquiries',
                                        title: 'Team\'\s Lost Enquiries',
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
                                                                            '/js/accordian.js',
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
                                        return '/master-sales/teamBookedEnquiries/1';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Sales / Pre Sales / Team\'\s Enquiries / Team\'\s Booked Enquiry',
                                        title: 'Team\'\s Booked Enquiry',
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
                                                                            '/js/accordian.js',
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
                                        label: 'Sales / Pre Sales / Team\'\s Enquiries / Team\'\s Today\'\s Followups',
                                        title: 'Team\'\s Today\'\s Followups',
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
                                                                            '/js/accordian.js',
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
                                        label: 'Sales / Pre Sales / Team\'\s Enquiries / Team\'\s Pending Followups',
                                        title: 'Team\'\s Pending Followups',
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
                                                                            '/js/accordian.js',
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
                                        label: 'Sales / Pre Sales / Team\'\s Enquiries / Team\'\s Previous Followups',
                                        title: 'Team\'\s Previous Followups',
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
                                                                            '/js/accordian.js',
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
                                .state('virtualnumberwiseusers', {
                                    url: '/cloudtelephony/virtualnumberwiseusers',
                                    templateUrl: '/cloudtelephony/showvirtualnumusers',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'virtualnumberslist',
                                        label: 'Virtual Number Wiseusers',
                                        title: 'Virtual Number Wiseusers',
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
                                                                            '/backend/cloudtelephonyController.js',
                                                                        ]
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('cloudtelephony', {
                                    url: '/cloudtelephony/create',
                                    templateUrl: '/cloudtelephony/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'numbersIndex',
                                        label: 'New Registration',
                                        title: 'New Registration',
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
                                        label: 'Cloud Telephony / Virtual Numbers / Manage Virtual Numbers',
                                        title: 'Manage Virtual Numbers',
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

                                .state('extensionemplist', {
                                    url: '/extensionemployee/index',
                                    templateUrl: '/extensionemployee/viewextemployee',
                                    controller: 'extensionemployeeController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Cloud Telephony / Virtual Numbers / Manage Extensions',
                                        title: 'Manage Extensions',
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
                                        label: 'Cloud Telephony / Telephony Registration / Manage',
                                        title: 'Manage',
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


                                .state('recordUpdate', {
                                    url: '/cloudtelephony/update/:id',
                                    templateUrl: function (stateParams) {
                                        return '/cloudtelephony/' + stateParams.id + '/edit';
                                    },
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'numbersIndex',
                                        label: 'Edit Registration',
                                        title: 'Edit Registration',
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
                                        parent: 'virtualnumberslist',
                                        label: 'Edit Virtual Number',
                                        title: 'Edit Virtual Number',
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
                                                                    '/backend/cloudtelephonyController.js',
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
                                        parent: 'virtualnumberslist',
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
                                                                    '/backend/cloudtelephonyController.js',
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
                                        parent: 'virtualnumberslist',
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
                                                                    '/backend/cloudtelephonyController.js',
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

                                /**************************** Alerts Routing *****************************/
                                .state('alertsIndex', {
                                    url: '/alerts/index',
                                    templateUrl: '/alerts/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'BMS / BMS Settings / SMS & Email Settings / Template Settings',
                                        title: 'Template Settings',
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
                                        parent: 'alertsIndex',
                                        label: 'Edit Template',
                                        title: 'Edit Template',
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
                                        label: 'BMS / BMS Settings / SMS & Email Settings / Manage Custom Templates',
                                        title: 'Manage Custom Templates',
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
                                        parent: 'customalertsIndex',
                                        label: 'Create Custom Template',
                                        title: 'Create Custom Template',
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
                                        parent: 'customalertsIndex',
                                        label: 'Edit Custom Template',
                                        title: 'Edit Custom Template',
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
                                        label: 'BMS / BMS Settings / SMS & Email Settings / Manage Default Templates',
                                        title: 'Manage Default Templates',
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
                                        parent: 'defaultalertsIndex',
                                        label: 'Edit Default Template',
                                        title: 'Edit Default Template',
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
                                        label: 'BMS / Website Settings / Contact Us',
                                        title: 'Contact Us',
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
                                        label: 'BMS / Website Settings / Blog Management',
                                        title: 'Blog Management',
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
                                        parent: 'manageblogIndex',
                                        label: 'Create blog',
                                        title: 'Create blog'
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
                                        parent: 'manageblogIndex',
                                        label: 'Edit Blog',
                                        title: 'Edit Blog',
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
                                        label: 'Response / Testimonials / Approve',
                                        title: 'Approved Testimonials',
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
                                        parent: 'testimonialsManage',
                                        label: 'Edit Testimonial',
                                        title: 'Edit Testimonial',
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
                                        parent: 'testimonialsIndex',
                                        label: 'Update Testimonial',
                                        title: 'Update Testimonial',
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
                                        parent: 'testimonialsManage',
                                        label: 'Create Testimonial',
                                        title: 'Create Testimonial',
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
                                        label: 'Response / Testimonials / Manage',
                                        title: 'Manage Testimonials',
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
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('manageJobIndex', {
                                    url: '/career/index',
                                    templateUrl: '/manage-job/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Careers / Manage',
                                        title: 'Manage',
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
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('createJobIndex', {
                                    url: '/career/create',
                                    templateUrl: '/manage-job/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'manageJobIndex',
                                        label: 'Add Job Details',
                                        title: 'Add Job Details',
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
                                                                    });
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('careerUpdate', {
                                    url: '/career/update/:jobId',
                                    templateUrl: function (stateParams) {
                                        return '/manage-job/' + stateParams.jobId + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'manageJobIndex',
                                        label: 'Edit Job Details',
                                        title: 'Edit Job Details',
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
                                    url: '/career/show/:jobId',
                                    templateUrl: function (stateParams) {
                                        return '/manage-job/' + stateParams.jobId + '/show';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'manageJobIndex',
                                        label: 'View Applications',
                                        title: 'View Applications',
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
                                        parent: 'myRequestIndex',
                                        label: 'Request Leave',
                                        title: 'Request Leave',
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
                                                                            '/backend/dashBoardController.js',
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
                                .state('requestOtherApprovalIndex', {
                                    url: '/request-approval/index',
                                    templateUrl: '/request-approval/index',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'myRequestIndex',
                                        label: 'Request other approval',
                                        title: 'Request other approval',
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
                                                                            '/backend/dashBoardController.js',
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
                                .state('requestForMeIndex', {
                                    url: '/request-for-me/index',
                                    templateUrl: '/request-for-me/index',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        parent: 'dashboard',
                                        label: 'Request For Me',
                                        title: 'Request For Me'
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
                                        parent: 'dashboard',
                                        label: 'My Requests',
                                        title: 'My Requests',
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
                                                                            '/backend/dashBoardController.js',
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
                                .state('operationalSettingIndex', {
                                    url: '/operational-setting/index',
                                    templateUrl: '/operational-setting/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'BMS / BMS Settings / Operational Settings / Manage operational settings',
                                        title: 'Manage operational settings',
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
                                        title: 'Manage Enquiry Location',
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
                                        title: 'Manage Designations',
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
                                        title: 'My Storage / Storage List',
                                        label: 'My Storage / Storage List',
                                        title: 'Storage List',
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
                                        title: 'My Storage / Shared With Me',
                                        label: 'My Storage / Shared With Me',
                                        title: 'Shared With Me',
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
                                        title: 'My Storage / Recycle Bin',
                                        label: 'My Storage / Recycle Bin',
                                        title: 'Recycle Bin',
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
                                        parent: 'storageListIndex',
                                        label: 'Storage Data',
                                        title: 'Storage Data',
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
                                        label: 'Storage Data',
                                        title: 'Storage Data',
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
                                        label: 'Storage Data',
                                        title: 'Storage Data',
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
                                        label: 'Storage Data',
                                        title: 'Storage Data',
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
                                        label: 'Storage Data',
                                        title: 'Storage Data',
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
                                        label: 'Storage Data',
                                        title: 'Storage Data',
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
                                        label: 'HR / User Documents / User Documents',
                                        title: 'User Documents',
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
                                        label: 'HR / Manage Documents / Manage Documents',
                                        title: 'Manage Documents',
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
                                        label: 'BMS / BMS Settings / Firms & Partners / Manage company',
                                        title: 'Manage company',
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
                                                                    });
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
                                        parent: 'companiesIndex',
                                        label: 'Add Company Details',
                                        title: 'Add Company Details',
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
                                        parent: 'companiesIndex',
                                        label: 'Edit Company Details',
                                        title: 'Edit Company Details',
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
                                        label: 'BMS / BMS Settings / Bank Accounts / Manage bank accounts',
                                        title: 'Manage bank accounts',
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
                                        label: 'Sales /  Customers Management / Manage Customers ',
                                        title: 'Manage Customers',
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
                                        title: 'Project Availability',
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
                                        parent: 'projectAvailability',
                                        title: 'Project Availability',
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
                                    url: '/website/modules',
                                    templateUrl: '/website/modules',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'BMS / Website Settings / Website Change Module',
                                        title: ' Website Change Module',
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', 'toaster', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/websiteThemes.js',
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
                                        label: 'BMS / Website Settings / Manage Website Themes',
                                        title: 'Manage Website Themes',
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

                                .state('themePreview', {
                                    url: '/theme/preview/id/:id',
                                    templateUrl: function (stateParams) {
                                        return '/theme/preview/id/' + stateParams.id;
                                    },
                                    requiredLogin: true,
                                    
                                    ncyBreadcrumb: {
                                        label: 'BMS / Website Settings /',
                                        title: 'Theme Preview',
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad,$scope) {
                                                        return $ocLazyLoad.load(['toaster']).then(
                                                                function () { 
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/websiteThemes.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })

                                .state('enquiryReport', {
                                    url: '/reports/enquiryReport',
                                    templateUrl: '/reports/getEnquiryReport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Reports / Pre Sales / My Reports / Enquiry Report',
                                        title: 'Enquiry Report',
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
                                        label: 'Reports / Pre Sales / My Reports /  Followup Report',
                                        title: 'Followup Report',
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
                                        label: 'Reports / Pre Sales / My Reports / Project Report',
                                        title: 'Project Report',
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
                                        label: 'Reports / Pre Sales / Team\'\s Report / Team\'\s Enquiry Report',
                                        title: 'Team\'\s Enquiry Report',
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
                                        label: 'Reports / Pre Sales / Team\'\s Report / Team\'\s Followup Report',
                                        title: 'Team\'\s Followup Reports',
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
                                        label: 'Reports / Pre Sales / Team\'\s Report / Project Wise Reports',
                                        title: 'Project Wise Reports',
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
                                        title: 'Project wise Reports',
                                        label: 'Project wise Reports',
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
                                        label: 'Cloud Telephony / Call Logs / My Incoming Call Logs',
                                        title: 'My Incoming Call Logs',
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
                                                                    '/backend/cloudtelephonyController.js',
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
                                        label: 'Cloud Telephony / Call Logs / Team\'\s Incoming Call Logs',
                                        title: 'Team\'\s Incoming Call Logs',
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
                                                                    '/backend/cloudtelephonyController.js',
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
                                        label: 'Cloud Telephony / Call Logs / My Outgoing Call Logs',
                                        title: 'My Outgoing Call Logs',
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
                                                                        '/backend/cloudtelephonyController.js',
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
                                        label: 'Cloud Telephony / Call Logs / Team\'\s Outgoing Logs',
                                        title: 'Team\'\s Outgoing Logs',
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
                                                                        '/backend/cloudtelephonyController.js',
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
                                        parent: 'userIndex',
                                        label: 'Add Quick User',
                                        title: 'Add Quick User',
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
                                        title: 'Profile',
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
                                /*--------------------------------------------customer care pre-sales------------------------------------------------------------*/
                                .state('customer-care-pre-sales-my-total', {
                                    url: '/customer-care/pre-sales/mytotal',
                                    templateUrl: '/customer-care/presales/total/0',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Customer Care/ Pre-Sales /My Total Followups',
                                        title: 'My Total Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customercarepresalesController.js',
                                                                            '/backend/outboundCallController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                            '/js/accordian.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })



                                .state('customer-care-pre-sales-team-total', {
                                    url: '/customer-care/pre-sales/teamtotal',
                                    templateUrl: '/customer-care/presales/total/1',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Customer Care/ Pre-Sales / Team\'\s Total Followups',
                                        title: 'Team\'\s Total Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customercarepresalesController.js',
                                                                            '/backend/outboundCallController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                            '/js/accordian.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })

                                .state('customer-care-pre-sales-my-completed', {
                                    url: '/customer-care/pre-sales/mycompleted',
                                    templateUrl: '/customer-care/presales/completed/0',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Customer Care/ Pre-Sales / My Completed Followups',
                                        title: 'My Completed Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customercarepresalesController.js',
                                                                            '/backend/outboundCallController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                            '/js/accordian.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })


                                .state('customer-care-pre-sales-team-completed', {
                                    url: '/customer-care/pre-sales/teamcompleted',
                                    templateUrl: '/customer-care/presales/completed/1',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Customer Care/ Pre-Sales / Team\'\s Completed Followups',
                                        title: 'Team\'\s Completed Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customercarepresalesController.js',
                                                                            '/backend/outboundCallController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                            '/js/accordian.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })

                                .state('customer-care-pre-sales-my-previous', {
                                    url: '/customer-care/pre-sales/myprevious',
                                    templateUrl: '/customer-care/presales/previous/0',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Customer Care/ Pre-Sales / My Previous Followups',
                                        title: 'My Previous Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customercarepresalesController.js',
                                                                            '/backend/outboundCallController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                            '/js/accordian.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })



                                .state('customer-care-pre-sales-team-previous', {
                                    url: '/customer-care/pre-sales/teamprevious',
                                    templateUrl: '/customer-care/presales/previous/1',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Customer Care/ Pre-Sales / Team\'\s Previous Followups',
                                        title: 'Team\'\s Previous Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customercarepresalesController.js',
                                                                            '/backend/outboundCallController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                            '/js/accordian.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })


                                .state('customer-care-pre-sales-my-today', {
                                    url: '/customer-care/pre-sales/mytoday',
                                    templateUrl: '/customer-care/presales/today/0',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Customer Care/ Pre-Sales / My Today\'\s Followups',
                                        title: 'My Today\'\s Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customercarepresalesController.js',
                                                                            '/backend/outboundCallController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                            '/js/accordian.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })

                                .state('customer-care-pre-sales-team-today', {
                                    url: '/customer-care/pre-sales/teamtoday',
                                    templateUrl: '/customer-care/presales/today/1',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Customer Care/ Pre-Sales / Team\'\s Today\'\s Followups',
                                        title: 'Team\'\s Today\'\s Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customercarepresalesController.js',
                                                                            '/backend/outboundCallController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                            '/js/accordian.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })


                                .state('customer-care-pre-sales-my-pending', {
                                    url: '/customer-care/pre-sales/mypending',
                                    templateUrl: '/customer-care/presales/pending/0',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Customer Care/ Pre-Sales / My Pending Followups',
                                        title: 'My Pending Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customercarepresalesController.js',
                                                                            '/backend/outboundCallController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                            '/js/accordian.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })


                                .state('customer-care-pre-sales-team-pending', {
                                    url: '/customer-care/pre-sales/teampending',
                                    templateUrl: '/customer-care/presales/pending/1',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Customer Care/ Pre-Sales / Team\'\s Pending Followups',
                                        title: 'Team\'\s Pending Followups'
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/customercarepresalesController.js',
                                                                            '/backend/outboundCallController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                            '/js/accordian.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                
                                .state('api', {
                                    url: '/pushapi/create',
                                    templateUrl: '/pushapi/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                      label: 'BMS / BMS Settings / API Management / New  API',
                                      title: 'New API',  
                                  
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/apiController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                 .state('apiUpdate', {
                                    url: '/pushapi/edit/:apiId',
                                    templateUrl: function (stateParams) {
                                        return '/pushapi/' + stateParams.apiId + '/update';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                    parent: 'apilist',
                                    label: 'Edit Push API',
                                    title: 'Edit Push API',
                                    
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster','textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/apiController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('apilist', {
                                    url: '/pushapi/manage',
                                    templateUrl: '/pushapi/manage',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                         label: 'BMS / BMS Settings / API Management / Manage  API',
                                         title: 'Manage API',
                                    },
                                    resolve: {
                                        deps:
                                                [
                                                    '$ocLazyLoad',
                                                    function ($ocLazyLoad) {
                                                        return $ocLazyLoad.load(['ui.select', 'toaster', 'textAngular']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
                                                                            '/js/intlTelInput.js',
                                                                            '/backend/apiController.js',
                                                                            '/backend/app/controllers/datepicker.js',
                                                                            '/backend/app/controllers/textangular.js',
                                                                            '/backend/app/controllers/timepicker.js',
                                                                            '/backend/app/controllers/select2.js',
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })








                                /*--------------------end customer care pre sales----------------------------------------------------------------- */
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
                                        label: 'Login',
                                        title: 'Login',
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
                                        label: 'Logout',
                                        title: 'Logout',
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
                        if (response.data !== '')
                            $rootScope.getMenu = response.data;
                        else
                            $rootScope.getMenu = [];
                    }, function (error) {
                        console.log('showMenu');
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