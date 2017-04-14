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
                ['$stateProvider', '$urlRouterProvider',
                    function ($stateProvider, $urlRouterProvider) {
                        $urlRouterProvider
                                .otherwise(getUrl + '/login');
                        $stateProvider
                                .state(getUrl, {
                                    abstract: true,
                                    url: '/' + getUrl,
                                    templateUrl: getUrl + '/layout',
                                })
                                .state(getUrl + '.dashboard', {
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
                                .state(getUrl + '.user', {
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
                                                return $ocLazyLoad.load(['ui.select','toaster']).then(
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
                                .state(getUrl + '.userIndex', {
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
                                .state(getUrl + '.userUpdate', {
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
                                                return $ocLazyLoad.load(['ui.select','toaster']).then(
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
                                .state(getUrl + '.manageRoles', {
                                    url: '/user/manageroles',
                                    templateUrl: getUrl + '/master-hr/manageRolesPermission',
                                    controller: 'hrController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Roles',
                                        description: ''
                                    },
                                })
                                .state(getUrl + '.userPermissions', {
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
                                .state(getUrl + '.rolePermissions', {
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
                                .state(getUrl + '.salesCreate', {
                                    url: '/sales/create',
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
                                })
                                .state(getUrl + '.enquiryCreate', {
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
                                                return $ocLazyLoad.load(['ui.select','toaster']).then(
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
                                                    }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state(getUrl + '.salesIndex', {
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
                                                            }
                                                            );
                                                        }
                                                );
                                            }
                                        ]
                                    }
                                })
                                .state(getUrl + '.userChart', {
                                    url: '/user/orgchart',
                                    templateUrl: getUrl + '/master-hr/orgchart',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Organization Chart',
                                        description: ''
                                    },
                                    resolve: {
                                        deps: [
                                            '$ocLazyLoad',
                                            function ($ocLazyLoad) {
                                                return $ocLazyLoad.load({
                                                    serie: true,
                                                    files: [
                                                        '/backend/app/controllers/chartloader.js',
                                                    ]
                                                });
                                            }
                                        ]
                                    }
                                })
                                .state(getUrl + '.projectCreate', {
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
                                .state(getUrl + '.projectWebPage', {
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
                                                        return $ocLazyLoad.load(['textAngular', 'toaster']).then(
                                                                function () {
                                                                    return $ocLazyLoad.load({
                                                                        serie: true,
                                                                        files: [
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
                                .state(getUrl + '.wingsIndex', {
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
                                .state(getUrl + '.wingsCreate', {
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

                                .state(getUrl + '.wingsUpdate', {
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
                                .state(getUrl + '.propertyPortalIndex', {
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
                                .state(getUrl + '.propertyPortalAccounts', {
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
                                .state(getUrl + '.createPortalAccounts', {
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
                                .state(getUrl + '.updatePortalAccounts', {
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
                                .state(getUrl + '.webPagesIndex', {
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
                                .state(getUrl + '.webPagesUpdate', {
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
                                .state(getUrl + '.emailConfigIndex', {
                                    url: '/emailConfig/index',
                                    templateUrl: getUrl + '/email-config/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Configure Email Accounts'
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
                                .state(getUrl + '.updateEmailConfig', {
                                    url: '/emailConfig/update/:id',
                                    templateUrl: function (setParams)
                                    {
                                        return getUrl + '/email-config/' + setParams.id + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Update Email Account'
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
                                .state(getUrl + '.createEmailConfig', {
                                    url: '/emailConfig/create/',
                                    templateUrl: getUrl + '/email-config/create',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create New Account'
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
                                .state(getUrl + '.employeeDeviceIndex', {
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
                                .state(getUrl + '.employeeDeviceCreate', {
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

                                .state(getUrl + '.employeeDeviceUpdate', {
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
                                /****************************UMA************************************/
                                /****************************MANDAR*********************************/
                                .state(getUrl + '.cloudtelephony', {
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

                                .state(getUrl + '.virtualnumberslist', {
                                    url: '/virtualnumber/index',
                                    templateUrl: getUrl + '/virtualnumber/',
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Virtual Numbers',
                                        description: ''
                                    },
                                })


                                .state(getUrl + '.numbersIndex', {
                                    url: '/cloudtelephony/index',
                                    templateUrl: getUrl + '/cloudtelephony/',
                                    controller: 'cloudtelephonyController',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage Virtual Numbers',
                                        description: ''
                                    },
                                })


                                .state(getUrl + '.recordUpdate', {
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
                                .state(getUrl + '.vnumberUpdate', {
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
                                .state(getUrl + '.extensionMenu', {
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
                                .state(getUrl + '.existingUpdate', {
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

                                .state(getUrl + '.promotionalsms', {
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
                                .state(getUrl + '.alertsIndex', {
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
                                .state(getUrl + '.alertsUpdate', {
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
                                .state(getUrl + '.customalertsIndex', {
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
                                .state(getUrl + '.customalertcreate', {
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
                                .state(getUrl + '.customalertsUpdate', {
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
                                .state(getUrl + '.defaultalertsIndex', {
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
                                .state(getUrl + '.dafaultalertcreate', {
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
                                .state(getUrl + '.defaultalertsUpdate', {
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
                                .state(getUrl + '.bloodGroupsIndex', {
                                    url: '/bloodgroups/index',
                                    templateUrl: getUrl + '/blood-groups/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create blood groups',
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
                                .state(getUrl + '.countryIndex', {
                                    url: '/country/index',
                                    templateUrl: getUrl + '/manage-country/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Country',
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
                                .state(getUrl + '.statesIndex', {
                                    url: '/states/index',
                                    templateUrl: getUrl + '/manage-states/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create State',
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
                                .state(getUrl + '.cityIndex', {
                                    url: '/city/index',
                                    templateUrl: getUrl + '/manage-city/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create City',
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

                                .state(getUrl + '.locationIndex', {
                                    url: '/location/index',
                                    templateUrl: getUrl + '/manage-location/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Location',
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
                                .state(getUrl + '.highesteducationIndex', {
                                    url: '/highesteducation/index',
                                    templateUrl: getUrl + '/highest-education/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create highest education Types',
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
                                .state(getUrl + '.departmentIndex', {
                                    url: '/department/index',
                                    templateUrl: getUrl + '/manage-department/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Department',
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
                                .state(getUrl + '.professionIndex', {
                                    url: '/profession/index',
                                    templateUrl: getUrl + '/manage-profession/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Profession',
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
                                .state(getUrl + '.paymentheadingIndex', {
                                    url: '/paymentheading/index',
                                    templateUrl: getUrl + '/payment-headings/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Payment Heading',
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
                                .state(getUrl + '.lostreasonsIndex', {
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
                                .state(getUrl + '.blockStagesIndex', {
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
                                .state(getUrl + '.enquirySourceIndex', {
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
                                .state(getUrl + '.discountheadingIndex', {
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
                                .state(getUrl + '.projectstagesIndex', {
                                    url: '/projectstages/index',
                                    templateUrl: getUrl + '/project-payment/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage project payment stages'
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
                                .state(getUrl + '.projecttypesIndex', {
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
                                .state(getUrl + '.blocktypesIndex', {
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
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state(getUrl + '.contactusIndex', {
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
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state(getUrl + '.socialwebsiteIndex', {
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
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state(getUrl + '.assignenquiryIndex', {
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
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state(getUrl + '.manageblogIndex', {
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
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state(getUrl + '.createBlog', {
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
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state(getUrl + '.blogUpdate', {
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
                                .state(getUrl + '.testimonialsIndex', {
                                    url: '/testimonials/index',
                                    templateUrl: getUrl + '/testimonials-approve/',
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
                                                                    }
                                                                    );
                                                                }
                                                        );
                                                    }
                                                ]
                                    }
                                })
                                .state(getUrl + '.testimonialUpdate', {
                                    url: '/testimonial-approve/update/:testimonialId',
                                    templateUrl: function (stateParams) {
                                        console.log("-" + stateParams)
                                        return getUrl + '/testimonial-approve/' + stateParams.testimonialId + '/edit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Edit Testimonials',
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

                                .state(getUrl + '.testimonialManage', {
                                    url: '/testimonial-manage/update/:testimonialId',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/testimonial-manage/' + stateParams.testimonialId + '/manageEdit';
                                    },
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Update Testimonials',
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
                                .state(getUrl + '.testimonialsCreate', {
                                    url: '/testimonials/create',
                                    templateUrl: getUrl + '/testimonials-create/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Create Testimonials',
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
                                .state(getUrl + '.testimonialsManage', {
                                    url: '/testimonials/manage',
                                    templateUrl: getUrl + '/testimonials-manage/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'manage Testimonials',
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
                                .state(getUrl + '.manageJobIndex', {
                                    url: '/manage-job/index',
                                    templateUrl: getUrl + '/manage-job/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Manage job posting',
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
                                .state(getUrl + '.createJobIndex', {
                                    url: '/createJob/index',
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
                                .state(getUrl + '.careerUpdate', {
                                    url: '/manage-job/update/:jobId',
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
                                .state(getUrl + '.careerShow', {
                                    url: '/manage-job/show/:jobId',
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
                                .state(getUrl + '.requestLeaveIndex', {
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
                                .state(getUrl + '.requestOtherApprovalIndex', {
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
                                .state(getUrl + '.requestForMeIndex', {
                                    url: '/request-forme/index',
                                    templateUrl: getUrl + '/request-forme/index',
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

                                .state(getUrl + '.myRequestIndex', {
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
                                .state(getUrl + '.operationalSettingIndex', {
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

                                .state(getUrl + '.enquirylocationIndex', {
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


                                .state(getUrl + '.designationsIndex', {
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
                                .state(getUrl + '.sharedWithMe', {
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
                                .state(getUrl + '.storageListIndex', {
                                    url: '/storage-list/index',
                                    templateUrl: getUrl + '/storage-list/',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                    }
                                })
                                .state(getUrl + '.recycleBin', {
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

                                .state(getUrl + '.allFiles', {
                                    url: '/storage-list/getAllList/:filename',
                                    templateUrl: function (stateParams) {
                                        return getUrl + '/storage-list/' + stateParams.filename + '/allfiles';
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

                                .state(getUrl + '.allMyFiles', {
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

                                .state(getUrl + '.getAllListToRestore', {
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
                                .state(getUrl + '.databoxes', {
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
                                .state(getUrl + '.widgets', {
                                    url: '/widgets',
                                    templateUrl: getUrl + '/widgets',
                                    requiredLogin: true,
                                    ncyBreadcrumb: {
                                        label: 'Widgets',
                                        description: 'flexible containers'
                                    }
                                })
                                .state(getUrl + '.easypiechart', {
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
                                .state(getUrl + '.chartjs', {
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
                                .state(getUrl + '.profile', {
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
                                .state(getUrl + '.inbox', {
                                    url: '/inbox',
                                    templateUrl: 'views/inbox.html',
                                    ncyBreadcrumb: {
                                        label: 'Beyond Mail'
                                    }
                                })
                                .state(getUrl + '.messageview', {
                                    url: '/viewmessage',
                                    templateUrl: 'views/message-view.html',
                                    ncyBreadcrumb: {
                                        label: 'Veiw Message'
                                    }
                                })
                                .state(getUrl + '.messagecompose', {
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
                                .state(getUrl + '.calendar', {
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
                                    url: '/' + getUrl + '/login',
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
                    }
                ]).run(function ($rootScope, $location, $state, Data, $http, $window, $stateParams) {
    $rootScope.authenticated = false;
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
    $rootScope.getMenu = {};
    $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams, next, current) {
        var nextUrl = $location.path();
        if ((toState.requiredLogin && $rootScope.authenticated === false) || (!toState.requiredLogin && $rootScope.authenticated === false)) { // true && false
            Data.get('session').then(function (results) {
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
                    var modifiedUrl = nextUrl.substr(nextUrl.lastIndexOf('/') + 0);
                    modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
                    if (nextUrl === '/' + getUrl + '/register' || nextUrl === '/' + getUrl + '/login' || nextUrl === '/' + getUrl + '/forgotPassword' || modifiedUrl === '/' + getUrl + '/resetPassword') {
                        $state.transitionTo(getUrl + ".dashboard");
                        event.preventDefault();
                        return false;
                    }
                } else {
                    var modifiedUrl = nextUrl.substr(nextUrl.lastIndexOf('/') + 0);
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
            $state.go(getUrl + '.dashboard');
            $state.reload();
            event.preventDefault();
            return false;
        }

        /*else {
         var nextUrl = $location.path();
         if (!toState.requiredLogin) {
         if (nextUrl === '/' + getUrl + '/register' || nextUrl === '/' + getUrl + '/login' || nextUrl === '/' + getUrl + '/forgotPassword' || nextUrl === '/' + getUrl + '/resetPassword') {
         $state.go('admin.dashboard');
         $state.reload();
         return false;
         }
         } else {
         var flag;
         console.log($rootScope.getMenu.actions + "====" + nextUrl);
         angular.forEach($rootScope.getMenu.actions, function (value, key) {
         if (value === nextUrl) {
         flag = true;
         } else {
         flag = false;
         }
         });
         if (flag === true) {
         alert("access");
         } else {
         alert("noaccess");
         }
         }
         }*/

    });
});

