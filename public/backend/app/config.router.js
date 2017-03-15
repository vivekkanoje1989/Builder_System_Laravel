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
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load(['ui.select', {
                                    serie: true,
                                    files: [
                                        '/js/intlTelInput.js',
                                        '/backend/app/controllers/datepicker.js',
                                        '/backend/app/controllers/select.js',
                                    ]
                                }]);
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
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load(['ui.select', {
                                    serie: true,
                                    files: [
                                        '/js/intlTelInput.js',
                                        '/backend/app/controllers/datepicker.js',
                                        '/backend/app/controllers/select.js',
                                    ]
                                }]);
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
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/js/intlTelInput.js',
                                    '/backend/customerController.js',
                                    '/backend/app/controllers/datepicker.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.salesIndex', {
                url: '/sales/index',
                templateUrl: getUrl + '/master-sales/',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Manage Enquiries'
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
            /****************************UMA************************************/
             .state(getUrl+'.portalIndex', {
                    url: '/portals/index',
                    templateUrl: getUrl+'/propertyportals/',
                    controller: 'propertyPortalsController',
                    requiredLogin: true,
                    ncyBreadcrumb: {
                        label: 'Property Portals'
                    },
                    resolve: {
                        deps: [
                            '$ocLazyLoad',
                            function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    serie: true,
                                    files: [                                        
                                        '/backend/propertyPortalsController.js',
                                    ]
                                });
                            }
                        ]
                    }
                })
                .state(getUrl+'.portalAccounts', {
                    url: '/portalaccounts/:portalTypeId',
                    templateUrl:  function (stateParams){
                        return getUrl+'/propertyportals/' + stateParams.portalTypeId + '/showAccounts' ;
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
                                return $ocLazyLoad.load(['ui.select',{
                                    serie: true,
                                    files: [
                                         '/backend/propertyPortalsController.js',
                                    ]
                                }]);
                            }
                        ]
                    }
                })
                .state(getUrl+'.createPortalAccounts', {
                    url: '/createpropertyportals/:portalTypeId',
                    templateUrl:  function (stateParams){
                        return getUrl+'/propertyportals/' + stateParams.portalTypeId + '/createAccount' ;
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
                                return $ocLazyLoad.load(['ui.select',{
                                    serie: true,
                                    files: [
                                         '/backend/propertyPortalsController.js',
                                    ]
                                }]);
                            }
                        ]
                    }
                }) 
                .state(getUrl + '.portalupdate', {
                url: '/propertyportals/updatePortalAccount/:portaltypeId/:accountId',
                templateUrl: function (stateParams) {
                    return getUrl + '/propertyportals/' + stateParams.portaltypeId + '/'+stateParams.accountId+'/updatePortalAccount';
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
            .state(getUrl + '.contentPagesIndex', {
                url: '/website_settings/contentpages',
                templateUrl: getUrl + '/website_settings/getIndex',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Content Management',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/websiteSettingsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.contentPagesUpdate', {
                url: '/contentpages/:page_id',
                templateUrl: function(stateParams){
                    return getUrl + '/website_settings/' + stateParams.page_id + '/updateContentPage';
                },
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Content Management',
                    description: ''
                },
                resolve: {
                deps: [
                        '$ocLazyLoad',
                        function($ocLazyLoad) {
                        return $ocLazyLoad.load(['textAngular']).then(
                                function() {
                                return $ocLazyLoad.load(
                                {
                                serie: true,
                                        files: [
                                            '/backend/app/controllers/textangular.js',
                                            '/backend/websiteSettingsController.js',
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
            /****************************MANDAR*********************************/
            /****************************MANOJ*********************************/

            .state(getUrl + '.listBloodGroup', {
                url: '/list/bloodgroup',
                templateUrl: getUrl + '/bms_lists/bloodGroup',
                controller: 'bloodGroupCtrl',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Create User',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })

            .state(getUrl + '.listCreate', {
                url: '/list/create',
                templateUrl: getUrl + '/bms_lists/create',
                controller: 'bloodGroupCtrl',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Create User',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load(['ui.select', {
                                    serie: true,
                                    files: [
                                        '/js/intlTelInput.js',
                                        '/backend/app/controllers/datepicker.js',
                                        '/backend/app/controllers/select.js',
                                        '/backend/bmsListsController.js',
                                    ]
                                }]);
                        }
                    ]
                }
            })

            .state(getUrl + '.listStates', {
                url: '/list/states',
                templateUrl: getUrl + '/bms_lists/states',
                controller: 'statesCtrl',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Create State',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listCities', {
                url: '/list/cities',
                templateUrl: getUrl + '/bms_lists/cities',
                controller: 'citiesCtrl',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Create State',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listCountry', {
                url: '/list/country',
                templateUrl: getUrl + '/bms_lists/country',
                controller: 'countryCtrl',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Create Country',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listLocation', {
                url: '/list/location',
                templateUrl: getUrl + '/bms_lists/location',
                controller: 'locationCtrl',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Create Location',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listeducation', {
                url: '/list/highestEducation',
                templateUrl: getUrl + '/bms_lists/highestEducation',
                controller: 'highestEducationCtrl',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Create Block Types',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listdepartment', {
                url: '/list/department',
                templateUrl: getUrl + '/bms_lists/department',
                controller: 'manageDepartmentCtrl',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Create Department',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listprofession', {
                url: '/list/profession',
                templateUrl: getUrl + '/bms_lists/profession',
                controller: 'manageProfessionCtrl',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Create Profession',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listpaymentheading', {
                url: '/list/paymentheading',
                templateUrl: getUrl + '/bms_lists/paymentheading',
                controller: 'managePaymentHeadingCtrl',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Create Payment Heading',
                    description: ''
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.managelostreasons', {
                url: '/bmslists/managelostreasons',
                templateUrl: getUrl + '/bmslists/lostreason',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Manage Lost Reasons'
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listblockstages', {
                url: '/bmslists/blockstages',
                templateUrl: getUrl + '/bms_lists/blockstages',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Manage Lost Reasons'
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listEnquirySource', {
                url: '/bmslists/enquirysource',
                templateUrl: getUrl + '/bms_lists/enquirysource',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Manage Lost Reasons'
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                    '/backend/app/controllers/accordion.js',
                                    '/backend/app/controllers/tab.js'
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listDiscountHeading', {
                url: '/bmslists/managediscountheading',
                templateUrl: getUrl + '/bms_lists/discountheading',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Manage Discount Heading'
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                    '/backend/app/controllers/accordion.js',
                                    '/backend/app/controllers/tab.js'
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listProjectPayment', {
                url: '/bms_lists/projectpayment',
                templateUrl: getUrl + '/bms_lists/projectpayment',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Manage Discount Heading'
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                    '/backend/app/controllers/accordion.js',
                                    '/backend/app/controllers/tab.js'
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listprojecttypes', {
                url: '/bms_lists/projecttypes',
                templateUrl: getUrl + '/bms_lists/projecttypes',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Manage Project Types'
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                    '/backend/app/controllers/accordion.js',
                                    '/backend/app/controllers/tab.js'
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl + '.listBlockTypes', {
                url: '/bms_lists/blockTypes',
                templateUrl: getUrl + '/bms_lists/blockTypes',
                requiredLogin: true,
                ncyBreadcrumb: {
                    label: 'Manage Block Types'
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad',
                        function ($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    '/backend/bmsListsController.js',
                                    '/backend/app/controllers/accordion.js',
                                    '/backend/app/controllers/tab.js'
                                ]
                            });
                        }
                    ]
                }
            })
            .state(getUrl+'.contactUsIndex', {
                    url: '/website_settings/contactus',
                    templateUrl: getUrl+'/website_settings/contactus',
                    requiredLogin: true,
                    ncyBreadcrumb: {
                        label: 'Manage Office Addresses'
                    },
                    resolve: {
                        deps: [
                            '$ocLazyLoad',
                            function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    serie: true,
                                    files: [                                        
                                        '/backend/websiteSettingsController.js',
                                         '/backend/app/controllers/accordion.js',
                                           '/backend/app/controllers/tab.js'
                                    ]
                                });
                            }
                        ]
                    }
                })
                .state(getUrl+'.socialwebIndex', {
                    url: '/website_settings/socialweb',
                    templateUrl: getUrl+'/website_settings/socialweb',
                    requiredLogin: true,
                    ncyBreadcrumb: {
                        label: 'Manage Office Addresses'
                    },
                    resolve: {
                        deps: [
                            '$ocLazyLoad',
                            function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    serie: true,
                                    files: [                                        
                                        '/backend/websiteSettingsController.js',
                                         '/backend/app/controllers/accordion.js',
                                           '/backend/app/controllers/tab.js'
                                    ]
                                });
                            }
                        ]
                    }
                })
                .state(getUrl+'.autoWebEnquiries', {
                    url: '/assign_web_enquiries/index',
                    templateUrl: getUrl+'/assign_web_enquiries/index',
                    requiredLogin: true,
                    ncyBreadcrumb: {
                        label: 'Manage auto assign web enquiries'
                    },
                    resolve: {
                        deps: [
                            '$ocLazyLoad',
                            function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    serie: true,
                                    files: [                                        
                                        '/backend/bmsSettingsController.js',
                                         '/backend/app/controllers/accordion.js',
                                           '/backend/app/controllers/tab.js'
                                    ]
                                });
                            }
                        ]
                    }
                })
                 .state(getUrl+'.blogIndex', {
                    url: '/website_settings/index',
                    templateUrl: getUrl+'/website_settings/blogIndex',
                    requiredLogin: true,
                    ncyBreadcrumb: {
                        label: 'Manage Blogs'
                    },
                    resolve: {
                        deps: [
                            '$ocLazyLoad',
                            function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    serie: true,
                                    files: [                                        
                                        '/backend/websiteSettingsController.js',
                                         '/backend/app/controllers/accordion.js',
                                           '/backend/app/controllers/tab.js'
                                    ]
                                });
                            }
                        ]
                    }
                })
                 .state(getUrl+'.createBlog', {
                    url: '/website_settings/create',
                    templateUrl: getUrl+'/website_settings/blogCreate',
                    requiredLogin: true,
                    ncyBreadcrumb: {
                        label: 'Create blog',
                        description: ''
                    },
                     resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function($ocLazyLoad) {
                                    return $ocLazyLoad.load(['textAngular']).then(
                                        function() {
                                            return $ocLazyLoad.load(
                                            {
                                                serie: true,
                                                files: [
                                                     '/backend/app/controllers/textangular.js',
                                                     '/backend/websiteSettingsController.js',
                                                ]
                                            });
                                        }
                                    );
                                }
                            ]
                        }
                })
                 .state(getUrl+'.blogUpdate', {
                    url: '/website_settings/update/:blogId',
                    templateUrl:  function (stateParams){
                        return getUrl+'/website_settings/' + stateParams.blogId + '/edit';
                    },
                    requiredLogin: true,
                    ncyBreadcrumb: {
                        label: 'Edit User',
                        description: ''
                    },
                    resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function($ocLazyLoad) {
                                    return $ocLazyLoad.load(['textAngular']).then(
                                        function() {
                                            return $ocLazyLoad.load(
                                            {
                                                serie: true,
                                                files: [
                                                     '/backend/app/controllers/textangular.js',
                                                     '/backend/websiteSettingsController.js',
                                                ]
                                            });
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
         if (!toState.requiredLogin){
         if (nextUrl === '/'+getUrl+'/register' || nextUrl === '/'+getUrl+'/login' || nextUrl === '/'+getUrl+'/forgotPassword' || nextUrl === '/'+getUrl+'/resetPassword') {
         $state.go('admin.dashboard');  
         $state.reload();
         return false;
         }
         }
         else{
         var flag;
         console.log($rootScope.getMenu.actions+"===="+nextUrl);
         angular.forEach($rootScope.getMenu.actions, function (value, key) {
         if (value === nextUrl) {
         flag = true;
         }
         else {
         flag = false;
         }
         });
         if (flag === true) {
         alert("access");
         }
         else {
         alert("noaccess");
         }
         }
         }*/

    });
});

