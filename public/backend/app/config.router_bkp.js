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
                ['$stateProvider', '$urlRouterProvider','$locationProvider',
                    function ($stateProvider, $urlRouterProvider,$locationProvider) {
                       
                        $urlRouterProvider
                                .otherwise('/login');
                        $stateProvider
//                                .state(getUrl, {
//                                    abstract: true,
//                                    url: '/',
//                                    templateUrl: getUrl + '/layout',
//                                })
                                .state('dashboard', {
                                    url: '/dashboard',
                                    templateUrl: getUrl + '/dashboard',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Dashboard',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
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
                                                });
                                            }
                                        ]
                                    }
                                })
                                .state('user', {
                                    url: '/user/create',
                                    templateUrl: getUrl + '/master-hr/create',
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
                                    templateUrl: getUrl + '/master-hr/',
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
                                .state('userUpdate', {
                                    url: '/user/update/:empId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/master-hr/' + stateParams.empId + '/edit';
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
                                                                        ]
                                                                    });
                                                                });
                                                    }
                                                ]
                                    }
                                })
                                .state('manageRoles', {
                                    url: '/user/manageroles',
                                    templateUrl: getUrl + '/master-hr/manageRolesPermission',
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Roles',
                                        description: ''
                                    },
                                })
                                .state('userPermissions', {
                                    url: '/user/permissions/:empId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/master-hr/userPermissions/' + stateParams.empId;
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
                                        return getUrl + '/master-hr/rolePermissions/' + stateParams.empId;
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
                                .state('.salesCreate', {
                                    url: '/sales/enquiry',
                                    templateUrl: getUrl + '/master-sales/create',
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
                                /*.state('.enquiryCreate', {
                                    url: '/sales/createEnquiry/:customerId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/master-sales/showEnquiry/' + stateParams.customerId;
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
                                /*.state('.salesIndex', {
                                    templateUrl: getUrl + '/master-sales/create',
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
                                .state('.salesUpdateCustomer', {
                                    url: '/sales/update/cid/:customerId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/master-sales/editCustomer/cid/' + stateParams.customerId;
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
                                .state('.salesUpdateEnquiry', {
                                    url: '/sales/update/cid/:customerId/eid/:enquiryId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/master-sales/editEnquiry/cid/' + stateParams.customerId + '/eid/'+ stateParams.enquiryId;
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
                                .state('.userChart', {
                                    url: '/user/orgchart',
                                    templateUrl: getUrl + '/master-hr/orgchart',
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
                                .state('.projectCreate', {
                                    url: '/project/create',
                                    templateUrl: getUrl + '/projects/create',
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
                                .state('.projectWebPage', {
                                    url: '/project/webpage',
                                    templateUrl: getUrl + '/projects/webPage',
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
                                /*.state('.projectWebPageId', {
                                    url: '/project/webpage/:projectId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/projects/getProjectDetails/' + stateParams.projectId;
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
                                .state('.manageProjectIndex', {
                                   url: '/project/index',
                                   templateUrl: getUrl + '/projects/',
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
                                .state('.wingsIndex', {
                                    url: '/wings/index',
                                    templateUrl: getUrl + '/wings/',
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
                                .state('.wingsCreate', {
                                    url: '/wings/create',
                                    templateUrl: getUrl + '/wings/create',
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

                                .state('.wingsUpdate', {
                                    url: '/wings/update/:id',
                                    templateUrl: function (setParams)
                                    {
                                        return getUrl + '/wings/' + setParams.id + '/edit';
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
                                /************************************ UMA ******************************/
                                .state('.propertyPortalIndex', {
                                    templateUrl: getUrl + '/projects/create',
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
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('.propertyPortalAccounts', {
                                    url: '/portalaccounts/:portalTypeId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/propertyportals/' + stateParams.portalTypeId + '/showPortalAccounts';
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
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/propertyPortalsController.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('.createPortalAccounts', {
                                    url: '/portalaccounts/create/:portalTypeId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/propertyportals/' + stateParams.portalTypeId + '/createAccount';
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
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/propertyPortalsController.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('.updatePortalAccounts', {
                                    url: '/portalaccounts/update/:portaltypeId/:accountId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/propertyportals/' + stateParams.portaltypeId + '/' + stateParams.accountId + '/updatePortalAccount';
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
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/propertyPortalsController.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('.webPagesIndex', {
                                    url: '/webpages/index',
                                    templateUrl: getUrl + '/web-pages/',
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
                                .state('.webPagesUpdate', {
                                    url: '/webpages/update/:id',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/web-pages/' + stateParams.id + '/edit';
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
                                .state('.emailConfigIndex', {
                                    url: '/emailConfig/index',
                                    templateUrl: getUrl + '/email-config/',
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
                                .state('.updateEmailConfig', {
                                    url: '/emailConfig/update/:id',
                                    templateUrl: function (setParams)
                                    {
                                        return getUrl + '/email-config/' + setParams.id + '/edit';
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
                                .state('.createEmailConfig', {
                                    url: '/emailConfig/create/',
                                    templateUrl: getUrl + '/email-config/create',
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
                                .state('.employeeDeviceIndex', {
                                    url: '/employeeDevice/index',
                                    templateUrl: getUrl + '/employee-device/',
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
                                .state('.employeeDeviceCreate', {
                                    url: '/employeeDevice/create',
                                    templateUrl: getUrl + '/employee-device/create',
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

                                .state('.employeeDeviceUpdate', {
                                    url: '/employeeDevice/update/:id',
                                    templateUrl: function (setParam)
                                    {
                                        return getUrl + '/employee-device/' + setParam.id + '/edit';
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
                                .state('.customerUpdate', {
                                    url: '/sales/updateCustomer/:id',
                                    templateUrl: function (setParams) {
                                        return getUrl + '/master-sales/updateCustomer/'+ setParams.id ;
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
                                
                                .state('.manageCustomerUpdate', {
                                    url: '/customers/update/:custId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/customers/' + stateParams.custId + '/edit';
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
                                .state('.enquiries', {
                                    url: '/sales/totalenquiries',
                                    templateUrl: getUrl + '/master-sales/totalEnquiries',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Total Enquiries'
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

                                .state('.lostenquiries', {
                                    url: '/sales/lostenquiries',
                                    templateUrl: function () {
                                        return getUrl + '/master-sales/lostEnquiries';
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
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/enquiryController.js',
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
                                .state('.closedenquiries', {
                                    url: '/sales/closedenquiries',
                                    templateUrl: function () {
                                        return getUrl + '/master-sales/closeEnquiries';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Closed Enquiry'
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
                                                                    '/backend/enquiryController.js',
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
                                .state('.todaysfollowups', {
                                    url: '/sales/todaysfollowups',
                                    templateUrl: function () {
                                        return getUrl + '/master-sales/showTodaysFollowups';
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
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/enquiryController.js',
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
                                .state('.pendingfollowups', {
                                    url: '/sales/pendingfollowups',
                                    templateUrl: function () {
                                        return getUrl + '/master-sales/showPendingFollowups';
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
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/enquiryController.js',
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
                                .state('.previousfollowups', {
                                    url: '/sales/previousfollowups',
                                    templateUrl: function () {
                                        return getUrl + '/master-sales/showPreviousFollowups';
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
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/enquiryController.js',
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
                                .state('.teamtotalenquiries', {
                                    url: '/sales/teamtotalenquiries',
                                    templateUrl: getUrl + '/master-sales/teamTotalEnquiries',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Total Enquiries'
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
                                                                    '/backend/enquiryController.js',
                                                                    '/backend/app/controllers/datepicker.js',
                                                                    '/backend/app/controllers/timepicker.js',
                                                                ]
                                                            }
                                                            );
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })

                                .state('.teamlostenquiries', {
                                    url: '/sales/teamlostenquiries',
                                    templateUrl: function () {
                                        return getUrl + '/master-sales/teamLostEnquiries';
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
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/enquiryController.js',
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
                                .state('.teamclosedenquiries', {
                                    url: '/sales/teamclosedenquiries',
                                    templateUrl: function () {
                                        return getUrl + '/master-sales/teamClosedEnquiries';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Team Closed Enquiry'
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
                                                                    '/backend/enquiryController.js',
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
                                .state('.teamtodayfollowups', {
                                    url: '/sales/teamtodayfollowups',
                                    templateUrl: function () {
                                        return getUrl + '/master-sales/teamTodayFollowups';
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
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/enquiryController.js',
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
                                .state('.teampendingfollowups', {
                                    url: '/sales/teampendingfollowups',
                                    templateUrl: function () {
                                        return getUrl + '/master-sales/teamPendingFollowups';
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
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/enquiryController.js',
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
                                .state('.teampreviousfollowups', {
                                    url: '/sales/teampreviousfollowups',
                                    templateUrl: function () {
                                        return getUrl + '/master-sales/teamPreviousFollowups';
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
                                                return $ocLazyLoad.load('toaster').then(
                                                        function () {
                                                            return $ocLazyLoad.load({
                                                                serie: true,
                                                                files: [
                                                                    '/js/intlTelInput.js',
                                                                    '/backend/enquiryController.js',
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


                                /****************************UMA************************************/
                                /****************************MANDAR*********************************/
                                .state('.cloudtelephony', {
                                    url: '/cloudtelephony/create',
                                    templateUrl: getUrl + '/cloudtelephony/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Virtual Number Registration',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/cloudtelephonyController.js',
                                                            '/backend/app/controllers/datepicker.js',
                                                            '/backend/app/controllers/select.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })

                                .state('.virtualnumberslist', {
                                    url: '/virtualnumber/index',
                                    templateUrl: getUrl + '/virtualnumber/',
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Virtual Numbers',
                                        description: ''
                                    },
                                })


                                .state('.numbersIndex', {
                                    url: '/cloudtelephony/index',
                                    templateUrl: getUrl + '/cloudtelephony/',
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Virtual Numbers',
                                        description: ''
                                    },
                                })


                                .state('.recordUpdate', {
                                    url: '/cloudtelephony/update/:id',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/cloudtelephony/' + stateParams.id + '/edit';
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
                                                return $ocLazyLoad.load([{
                                                        serie: true,
                                                        files: [
                                                            '/backend/app/controllers/datepicker.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('.vnumberUpdate', {
                                    url: '/virtualnumber/update/:id',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/virtualnumber/' + stateParams.id + '/edit';
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
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/app/controllers/datepicker.js',
                                                            '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                            '/backend/app/controllers/select.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('.extensionMenu', {
                                    url: '/extensionmenu/view/:id',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/extensionmenu/' + stateParams.id + '/viewData';
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
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/app/controllers/datepicker.js',
                                                            '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                            '/backend/app/controllers/select.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('.existingUpdate', {
                                    url: '/virtualnumber/existingupdate/:id',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/virtualnumber/' + stateParams.id + '/existingUpdate';
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
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/app/controllers/datepicker.js',
                                                            '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                                            '/backend/app/controllers/select.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })


                                /*************************** Promotional SMS ****************/

                                .state('.promotionalsms', {
                                    url: '/promotionalsms/index',
                                    templateUrl: getUrl + '/promotionalsms/',
                                    controller: 'promotionalsmsController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Promotional SMS',
                                        description: ''
                                    },
                                })

                                /**************************** Alerts Routing *****************************/
                                .state('.alertsIndex', {
                                    url: '/alerts/index',
                                    templateUrl: getUrl + '/alerts/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Alerts'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load({
                                                    serie: true,
                                                    files: [
                                                        '/backend/alertsController.js',
                                                    ]
                                                });
                                            }
                                        ]
                                    }
                                })
                                .state('.alertsUpdate', {
                                    url: '/alerts/update/:id',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/alerts/' + stateParams.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Alert',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/alertsController.js',
                                                            '/backend/app/controllers/select.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('.customalertsIndex', {
                                    url: '/customalerts/index',
                                    templateUrl: getUrl + '/customalerts/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Custome Alters'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load({
                                                    serie: true,
                                                    files: [
                                                        '/backend/customalertsController.js',
                                                    ]
                                                });
                                            }
                                        ]
                                    }
                                })
                                .state('.customalertcreate', {
                                    url: '/customalerts/create',
                                    templateUrl: getUrl + '/customalerts/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Custome Alert',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/customalertsController.js',
                                                            '/backend/app/controllers/select.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('.customalertsUpdate', {
                                    url: '/customalerts/update/:id',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/customalerts/' + stateParams.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Custome Alert',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/customalertsController.js',
                                                            '/backend/app/controllers/select.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('.defaultalertsIndex', {
                                    url: '/defaultalerts/index',
                                    templateUrl: getUrl + '/defaultalerts/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Custome Alters'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load({
                                                    serie: true,
                                                    files: [
                                                        '/backend/defaultalertsController.js',
                                                    ]
                                                });
                                            }
                                        ]
                                    }
                                })
                                .state('.dafaultalertcreate', {
                                    url: '/dafaultalerts/create',
                                    templateUrl: getUrl + '/defaultalerts/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Custome Alert',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/defaultalertsController.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                .state('.defaultalertsUpdate', {
                                    url: '/defaultalerts/update/:id',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/defaultalerts/' + stateParams.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Default Alert',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.select', {
                                                        serie: true,
                                                        files: [
                                                            '/backend/defaultalertsController.js',
                                                        ]
                                                    }]);
                                            }
                                        ]
                                    }
                                })
                                /**************************** Alerts Routing *****************************/

                                /****************************MANDAR*********************************/
                                /****************************MANOJ*********************************/
                                .state('.bloodGroupsIndex', {
                                    url: '/bloodgroups/index',
                                    templateUrl: getUrl + '/blood-groups/',
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
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('.countryIndex', {
                                    url: '/country/index',
                                    templateUrl: getUrl + '/manage-country/',
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
                                .state('.statesIndex', {
                                    url: '/states/index',
                                    templateUrl: getUrl + '/manage-states/',
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
                                .state('.cityIndex', {
                                    url: '/city/index',
                                    templateUrl: getUrl + '/manage-city/',
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

                                .state('.locationIndex', {
                                    url: '/location/index',
                                    templateUrl: getUrl + '/manage-location/',
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
                                .state('.highesteducationIndex', {
                                    url: '/highesteducation/index',
                                    templateUrl: getUrl + '/highest-education/',
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
                                .state('.departmentIndex', {
                                    url: '/department/index',
                                    templateUrl: getUrl + '/manage-department/',
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
                                .state('.professionIndex', {
                                    url: '/profession/index',
                                    templateUrl: getUrl + '/manage-profession/',
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
                                .state('.paymentheadingIndex', {
                                    url: '/paymentheading/index',
                                    templateUrl: getUrl + '/payment-headings/',
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
                                .state('.lostreasonsIndex', {
                                    url: '/lostreasons/index',
                                    templateUrl: getUrl + '/lost-reasons/',
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
                                .state('.blockStagesIndex', {
                                    url: '/blockstages/index',
                                    templateUrl: getUrl + '/block-stages/',
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
                                .state('.enquirySourceIndex', {
                                    url: '/enquirySource/index',
                                    templateUrl: getUrl + '/enquiry-source/',
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
                                .state('.discountheadingIndex', {
                                    url: '/discountheading/index',
                                    templateUrl: getUrl + '/discount-headings/',
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
                                .state('.projectstagesIndex', {
                                    url: '/projectstages/index',
                                    templateUrl: getUrl + '/project-payment/',
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
                                .state('.projecttypesIndex', {
                                    url: '/projecttypes/index',
                                    templateUrl: getUrl + '/project-types/',
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
                                .state('.blocktypesIndex', {
                                    url: '/blocktypes/index',
                                    templateUrl: getUrl + '/block-types/',
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
                                .state('.contactusIndex', {
                                    url: '/contactus/index',
                                    templateUrl: getUrl + '/contact-us/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Contact us'
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
                                .state('.socialwebsiteIndex', {
                                    url: '/social-website/index',
                                    templateUrl: getUrl + '/social-website/',
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
                                .state('.assignenquiryIndex', {
                                    url: '/assignenquiry/index',
                                    templateUrl: getUrl + '/assign-enquiry/',
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
                                .state('.manageblogIndex', {
                                    url: '/blog/index',
                                    templateUrl: getUrl + '/manage-blog/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Blogs'
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
                                .state('.createBlog', {
                                    url: '/manage-blog/create',
                                    templateUrl: getUrl + '/manage-blog/create',
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
                                .state('.blogUpdate', {
                                    url: '/manage-blog/update/:blogId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/manage-blog/' + stateParams.blogId + '/edit';
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
                                .state('.testimonialsIndex', {
                                    url: '/testimonials/index',
                                    templateUrl: getUrl + '/testimonials/',
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
                                .state('.testimonialUpdate', {
                                    url: '/testimonials/update/:testimonialId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/testimonials/' + stateParams.testimonialId + '/edit';
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

                                .state('.testimonialManage', {
                                    url: '/testimonials-manage/update/:testimonialId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/testimonials/' + stateParams.testimonialId + '/editApproved';
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
                                .state('.testimonialsCreate', {
                                    url: '/testimonials/create',
                                    templateUrl: getUrl + '/testimonials/create',
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
                                .state('.testimonialsManage', {
                                    url: '/testimonials/manage',
                                    templateUrl: getUrl + '/testimonials/manage',
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
                                                            ]
                                                        }
                                                        );
                                                    }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state('.manageJobIndex', {
                                    url: '/job-posting/index',
                                    templateUrl: getUrl + '/manage-job/',
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
                                                                        ]
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state('.createJobIndex', {
                                    url: '/job-posting/create',
                                    templateUrl: getUrl + '/create-Job/',
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
                                .state('.careerUpdate', {
                                    url: '/job-posting/update/:jobId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/manage-job/' + stateParams.jobId + '/edit';
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
                                .state('.careerShow', {
                                    url: '/job-posting/show/:jobId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/manage-job/' + stateParams.jobId + '/show';
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
                                .state('.requestLeaveIndex', {
                                    url: '/request-leave/index',
                                    templateUrl: getUrl + '/request-leave/',
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
                                .state('.requestOtherApprovalIndex', {
                                    url: '/request-approval/index',
                                    templateUrl: getUrl + '/request-approval/index',
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
                                .state('.requestForMeIndex', {
                                    url: '/request-for-me/index',
                                    templateUrl: getUrl + '/request-for-me/index',
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

                                .state('.myRequestIndex', {
                                    url: '/my-request/index',
                                    templateUrl: getUrl + '/my-request/index',
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
                                .state('.operationalSettingIndex', {
                                    url: '/operational-setting/index',
                                    templateUrl: getUrl + '/operational-setting/',
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

                                .state('.enquirylocationIndex', {
                                    url: '/enquiry-location/index',
                                    templateUrl: getUrl + '/enquiry-location/',
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


                                .state('.designationsIndex', {
                                    url: '/manage-designations/index',
                                    templateUrl: getUrl + '/manage-designations/',
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
                                .state('.storageListIndex', {
                                    url: '/storage-list/index',
                                    templateUrl: getUrl + '/storage-list/',
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
                                .state('.sharedWithMe', {
                                    url: '/sharedwith-me/index',
                                    templateUrl: getUrl + '/sharedwith-me/',
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
                                .state('.recycleBin', {
                                    url: '/recycle-bin/index',
                                    templateUrl: getUrl + '/recycle-bin/',
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

                                .state('.allFiles', {
                                    url: '/storage-list/getAllList/:folderId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/storage-list/' + stateParams.folderId + '/allfiles';
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

                                .state('.allMyFiles', {
                                    url: '/storage-list/getAllMyList/:filename',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/storage-list/' + stateParams.filename + '/allmyfiles';
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

                                .state('.getSubFolderImages', {
                                    url: '/storage-list/getSubFolderImages/:filename',
                                    templateUrl: function (stateParams) {

                                        return getUrl + '/storage-list/' + stateParams.filename + '/getSubFolderImages';
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
                                .state('.getAllListToRestore', {
                                    url: '/storage-list/getAllListToRestore/:filename',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/storage-list/' + stateParams.filename + '/getAllListToRestore';
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

                                .state('.SubFolderRestore', {
                                    url: '/storage-list/SubFolderRestore/:filename',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/storage-list/' + stateParams.filename + '/SubFolderRestore';
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

                                .state('.getMySubFolderImages', {
                                    url: '/storage-list/getMySubFolderImages/:filename',
                                    templateUrl: function (stateParams) {
                                        alert(stateParams.filename);
                                        return getUrl + '/storage-list/' + stateParams.filename + '/getMySubFolderImages';
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

                                .state('.userDocument', {
                                    url: '/user-document/index',
                                    templateUrl: getUrl + '/user-document/',
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

                                .state('.documentIndex', {
                                    url: '/employee-document/index',
                                    templateUrl: getUrl + '/employee-document/',
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


                                .state('.companiesIndex', {
                                    url: '/manage-company/index',
                                    templateUrl: getUrl + '/manage-companies/',
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
                                .state('.companiesCreate', {
                                    url: '/manage-companies/create',
                                    templateUrl: getUrl + '/manage-companies/create',
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

                                .state('.companiesUpdate', {
                                    url: '/manage-companies/edit/:companyId',
                                    templateUrl: function (stateParams) {

                                        return getUrl + '/manage-companies/' + stateParams.companyId + '/edit';
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


                                .state('.bankAccountsIndex', {
                                    url: '/bank-accounts/index',
                                    templateUrl: getUrl + '/bank-accounts/',
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

                                .state('.customersIndex', {
                                    url: '/customers/index',
                                    templateUrl: getUrl + '/customers/',
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
                                .state('.projectAvailability', {
                                    url: '/manage-project/availability',
                                    templateUrl: getUrl + '/projects/availability',
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

//                                .state('.manageProjectIndex', {
//                                    url: '/manage-project/index',
//                                    templateUrl: getUrl + '/projects/manage',
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
                                .state('.availbleProjects', {
                                    url: '/projects/availability/:projectId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/projects/' + stateParams.projectId + '/availability';
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

                                .state('.webChangeModuleIndex', {
                                    url: '/website/change-module',
                                    templateUrl: getUrl + '/website/change-module',
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
                                 .state('.webThemesIndex', {
                                    url: '/website/themes',
                                    templateUrl: getUrl + '/website-themes/',
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
                                
                                 .state('.enquiryReport', {
                                    url: '/report/enquiryreport',
                                    templateUrl: getUrl + '/reports/getEnquiryReport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'My Enquiry Report'
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

                                .state('.followupReport', {
                                    url: '/report/followupReport',
                                    templateUrl: getUrl + '/report/followupReport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'My Followup Report'
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

                                .state('.projectwiseReport', {
                                    url: '/report/projectwiseReport',
                                    templateUrl: getUrl + '/reports/projectwiseReport',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'My Sale`s Report'
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


                                
                                .state('.teamenquiryReport', {
                                    url: '/reports/teamenquiryreport',
                                    templateUrl: getUrl + '/reports/getTeamEnquiryreports',
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


                                .state('.teamFollowupReport', {
                                    url: '/reports/teamfollowupreport',
                                    templateUrl: getUrl + '/reports/teamFollowupreports',
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
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                 .state('.projectwiseMyPreSales', {
                                    url: '/reports/projectwiseMyPreSales',
                                    templateUrl: getUrl + '/reports/projectwiseMyPreSales',
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
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                /****************************MANOJ*********************************/
                                .state('persian', {
                                    abstract: true,
                                    url: '/persian',
                                    templateUrl: 'views/layout-persian.html'
                                })
                                .state('persian.dashboard', {
                                    url: '/dashboard',
                                    templateUrl: 'views/dashboard-persian.html',
                                    ncyBreadcrumb: {
                                        label: 'داشبورد'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
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
                                                });
                                            }
                                        ]
                                    }
                                })
                                .state('.databoxes', {
                                    url: '/databoxes',
                                    templateUrl: getUrl + '/databoxes',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Databoxes',
                                        description: 'beyond containers'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load({
                                                    serie: true,
                                                    files: [
                                                        '/backend/app/directives/realtimechart.js',
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.js',
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.orderBars.js',
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.tooltip.js',
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.resize.js',
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.selection.js',
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.crosshair.js',
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.stack.js',
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.time.js',
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.pie.js',
                                                        '/backend/lib/jquery/charts/morris/raphael-2.0.2.min.js',
                                                        '/backend/lib/jquery/charts/chartjs/chart.js',
                                                        '/backend/lib/jquery/charts/morris/morris.js',
                                                        '/backend/lib/jquery/charts/sparkline/jquery.sparkline.js',
                                                        '/backend/lib/jquery/charts/easypiechart/jquery.easypiechart.js',
                                                        '/backend/app/controllers/databoxes.js'
                                                    ]
                                                });
                                            }
                                        ]
                                    }
                                })
                                .state('.widgets', {
                                    url: '/widgets',
                                    templateUrl: getUrl + '/widgets',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Widgets',
                                        description: 'flexible containers'
                                    }
                                })
                                .state('.easypiechart', {
                                    url: '/easypiechart',
                                    templateUrl: 'views/easypiechart.html',
                                    ncyBreadcrumb: {
                                        label: 'Easy Pie Charts',
                                        description: 'lightweight charts'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load({
                                                    serie: true,
                                                    files: [
                                                        '/backend/lib/jquery/charts/easypiechart/jquery.easypiechart.js'
                                                    ]
                                                });
                                            }
                                        ]
                                    }
                                })
                                .state('.chartjs', {
                                    url: '/chartjs',
                                    templateUrl: 'views/chartjs.html',
                                    ncyBreadcrumb: {
                                        label: 'ChartJS',
                                        description: 'Cool HTML5 Charts'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load({
                                                    serie: true,
                                                    files: [
                                                        '/backend/lib/jquery/charts/chartjs/chart.js',
                                                        '/backend/app/controllers/chartjs.js'
                                                    ]
                                                });
                                            }
                                        ]
                                    }
                                })
                                .state('.profile', {
                                    url: '/profile',
                                    templateUrl: 'views/profile.html',
                                    ncyBreadcrumb: {
                                        label: 'User Profile'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load({
                                                    serie: true,
                                                    files: [
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.js',
                                                        '/backend/lib/jquery/charts/flot/jquery.flot.resize.js',
                                                        '/backend/app/controllers/profile.js'
                                                    ]
                                                });
                                            }
                                        ]
                                    }
                                })
                                .state('.inbox', {
                                    url: '/inbox',
                                    templateUrl: 'views/inbox.html',
                                    ncyBreadcrumb: {
                                        label: 'Beyond Mail'
                                    }
                                })
                                .state('.messageview', {
                                    url: '/viewmessage',
                                    templateUrl: 'views/message-view.html',
                                    ncyBreadcrumb: {
                                        label: 'Veiw Message'
                                    }
                                })
                                .state('.messagecompose', {
                                    url: '/composemessage',
                                    templateUrl: 'views/message-compose.html',
                                    ncyBreadcrumb: {
                                        label: 'Compose Message'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['textAngular']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(
                                                                    {
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/app/controllers/textangular.js'
                                                                        ]
                                                                    });
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state('.calendar', {
                                    url: '/calendar',
                                    templateUrl: 'views/calendar.html',
                                    ncyBreadcrumb: {
                                        label: 'Full Calendar'
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load(['ui.calendar']).then(
                                                        function () {
                                                            return $ocLazyLoad.load(
                                                                    {
                                                                        serie: true,
                                                                        files: [
                                                                            '/backend/app/controllers/fullcalendar.js'
                                                                        ]
                                                                    });
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state('login', {
                                    url: '/login',
                                    templateUrl: getUrl + '/login', //laravel slug
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
                                    url: '/' + getUrl + '/logout',
                                    templateUrl: getUrl + '/logout',
                                    requiredLogin: false,
                                    ncyBreadcrumb: {
                                        label: 'Logout'
                                    }
                                })
                                .state('forgotPassword', {
                                    url: '/office/forgotPassword',
                                    templateUrl: getUrl + '/password/resetLink/backend',
                                    requiredLogin: false,
                                    ncyBreadcrumb: {
                                        label: 'Forgot Password'
                                    }
                                })
                                .state('resetPassword', {
                                    url: '/' + getUrl + '/resetPassword/:resetToken',
                                    requiredLogin: false,
                                    templateUrl: function (params) {
                                        return getUrl + '/password/reset/' + params.resetToken + '/backend';
                                    },
                                    ncyBreadcrumb: {
                                        label: 'Reset Password'
                                    }
                                })
                                .state('register', {
                                    url: '/' + getUrl + '/register',
                                    templateUrl: getUrl + '/register',
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
                                    templateUrl: getUrl + '/error500',
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
//        var nextUrl = $location.path();
        if ((toState.requiredLogin && $rootScope.authenticated === false) || (!toState.requiredLogin && $rootScope.authenticated === false)) { // true && false
            Data.get('session').then(function (results) {
                var modifiedUrl = nextUrl.substr(nextUrl.lastIndexOf('/') + 0);
                if (results.success === true) {
                    $rootScope.authenticated = true;
                    $rootScope.id = results.id;
                    $rootScope.name = results.name;
                    $rootScope.email = results.email;
                    $window.sessionStorage.setItem("userLoggedIn", true);
                    $http.get(getUrl + '/getMenuItems').then(function (response) {
                        $rootScope.getMenu = response.data;
                    }, function (error) {
                        alert('Error');
                    });                    
                    modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
                    if (nextUrl === '/' + getUrl + '/register' || nextUrl === '/' + getUrl + '/login' || nextUrl === '/' + getUrl + '/forgotPassword' || modifiedUrl === '/' + getUrl + '/resetPassword') {
                        $state.transitionTo(getUrl + ".dashboard");
                        event.preventDefault();
                        return false;
                    }
                } else {                    
                    modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
                    if (nextUrl === '/' + getUrl + '/register' || nextUrl === '/' + getUrl + '/login' || nextUrl === '/' + getUrl + '/forgotPassword' || modifiedUrl === '/' + getUrl + '/resetPassword') {
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
            $state.go('.dashboard');
            $state.reload();
            event.preventDefault();
            return false;
        }
    });
});