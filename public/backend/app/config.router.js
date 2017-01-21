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
                    .otherwise('admin/login');
            $stateProvider
                    .state('admin', {
                        abstract: true,
                        url: '/admin',
                        templateUrl: '/layout',
                    })
                    .state('admin.dashboard', {
                        url: '/dashboard',
                        templateUrl: 'admin/dashboard',
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
                    .state('admin.user', {
                        url: '/user',
                        templateUrl: 'admin/user',
                        controller: 'userController',
                        requiredLogin: true,
                        ncyBreadcrumb: {
                            label: 'Create User',
                            description: ''
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load(['ui.select',{
                                        serie: true,
                                        files: [
                                            '/backend/userController.js',
//                                            '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
//                                            '/backend/app/controllers/select2.js',
                                            '/backend/app/controllers/datepicker.js',
                                        ]
                                    }]);
                                }
                            ]
                        }
                    })
                    
                    .state('admin.myBlog', {
                        url: '/myBlog',
                        templateUrl: 'admin/myBlog',requiredLogin: true,
                    })
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
                    .state('arabic', {
                        abstract: true,
                        url: '/arabic',
                        templateUrl: 'views/layout-arabic.html'
                    })
                    .state('arabic.dashboard', {
                        url: '/dashboard',
                        templateUrl: 'views/dashboard-arabic.html',
                        ncyBreadcrumb: {
                            label: 'لوحة القيادة'
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
                    .state('admin.databoxes', {
                        url: '/databoxes',
                        templateUrl: 'admin/databoxes',
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
                    .state('admin.widgets', {
                        url: '/widgets',
                        templateUrl: 'admin/widgets',
                        requiredLogin: true,
                        ncyBreadcrumb: {
                            label: 'Widgets',
                            description: 'flexible containers'
                        }
                    })
                    .state('admin.elements', {
                        url: '/elements',
                        templateUrl: 'views/elements.html',
                        ncyBreadcrumb: {
                            label: 'UI Elements',
                            description: 'Basics'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load({
                                        serie: true,
                                        files: [
                                            '/backend/app/controllers/pagination.js',
                                            '/backend/app/controllers/progressbar.js'
                                        ]
                                    });
                                }
                            ]
                        }
                    })
                    .state('admin.fontawesome', {
                        url: '/fontawesome',
                        templateUrl: 'views/font-awesome.html',
                        ncyBreadcrumb: {
                            label: 'FontAwesome',
                            description: 'Iconic Fonts'
                        }
                    })
                    .state('admin.glyphicons', {
                        url: '/glyphicons',
                        templateUrl: 'views/glyph-icons.html',
                        ncyBreadcrumb: {
                            label: 'GlyphIcons',
                            description: 'Sharp and clean symbols'
                        }
                    })
                    .state('admin.typicons', {
                        url: '/typicons',
                        templateUrl: 'views/typicons.html',
                        ncyBreadcrumb: {
                            label: 'Typicons',
                            description: 'Vector icons'
                        }
                    })
                    .state('admin.weathericons', {
                        url: '/weathericons',
                        templateUrl: 'views/weather-icons.html',
                        ncyBreadcrumb: {
                            label: 'Weather Icons',
                            description: 'Beautiful forcasting icons'
                        }
                    })
                    .state('admin.tabs', {
                        url: '/tabs',
                        templateUrl: 'views/tabs.html',
                        ncyBreadcrumb: {
                            label: 'Tabs',
                            description: 'Tabs and Accordions'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load({
                                        serie: true,
                                        files: [
                                            '/backend/app/controllers/accordion.js',
                                            '/backend/app/controllers/tab.js'
                                        ]
                                    });
                                }
                            ]
                        }
                    })
                    .state('admin.alerts', {
                        url: '/alerts',
                        templateUrl: 'views/alerts.html',
                        ncyBreadcrumb: {
                            label: 'Alerts',
                            description: 'Tooltips and Notifications'
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
                                                                '/backend/app/controllers/alert.js',
                                                                '/backend/app/controllers/toaster.js'
                                                            ]
                                                        }
                                                        );
                                                    }
                                            );
                                        }
                                    ]
                        }
                    })
                    .state('admin.modals', {
                        url: '/modals',
                        templateUrl: 'views/modals.html',
                        ncyBreadcrumb: {
                            label: 'Modals',
                            description: 'Modals and Wells'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load({
                                        serie: true,
                                        files: [
                                            '/backend/app/controllers/modal.js'
                                        ]
                                    });
                                }
                            ]
                        }
                    })
                    .state('admin.buttons', {
                        url: '/buttons',
                        templateUrl: 'views/buttons.html',
                        ncyBreadcrumb: {
                            label: 'Buttons'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load({
                                        serie: true,
                                        files: [
                                            '/backend/app/controllers/button.js',
                                            '/backend/app/controllers/dropdown.js'
                                        ]
                                    });
                                }
                            ]
                        }
                    })
                    .state('admin.nestablelist', {
                        url: '/nestablelist',
                        templateUrl: 'views/nestable-list.html',
                        ncyBreadcrumb: {
                            label: 'Nestable Lists',
                            description: 'Dragable list items'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load(['ng-nestable']).then(
                                            function () {
                                                return $ocLazyLoad.load(
                                                        {
                                                            serie: true,
                                                            files: [
                                                                '/backend/app/controllers/nestable.js'
                                                            ]
                                                        });
                                            }
                                    );
                                }
                            ]
                        }
                    })
                    .state('admin.treeview', {
                        url: '/treeview',
                        templateUrl: 'views/treeview.html',
                        ncyBreadcrumb: {
                            label: 'Treeview',
                            description: "Fuel UX's tree"
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load(['angularBootstrapNavTree']).then(
                                            function () {
                                                return $ocLazyLoad.load(
                                                        {
                                                            serie: true,
                                                            files: [
                                                                '/backend/app/controllers/treeview.js'
                                                            ]
                                                        });
                                            }
                                    );
                                }
                            ]
                        }
                    })
                    .state('admin.simpletables', {
                        url: '/simpletables',
                        templateUrl: 'views/tables-simple.html',
                        ncyBreadcrumb: {
                            label: 'Tables',
                            description: 'simple and responsive tables'
                        }
                    })
                    .state('admin.datatables', {
                        url: '/datatables',
                        templateUrl: 'views/tables-data.html',
                        ncyBreadcrumb: {
                            label: 'Datatables',
                            description: 'jquery plugin for data management'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load(['ngGrid']).then(
                                            function () {
                                                return $ocLazyLoad.load(
                                                        {
                                                            serie: true,
                                                            files: [
                                                                '/backend/app/controllers/nggrid.js',
                                                                '/backend/lib/jquery/datatable/dataTables.bootstrap.css',
                                                                '/backend/lib/jquery/datatable/jquery.dataTables.min.js',
                                                                '/backend/lib/jquery/datatable/ZeroClipboard.js',
                                                                '/backend/lib/jquery/datatable/dataTables.tableTools.min.js',
                                                                '/backend/lib/jquery/datatable/dataTables.bootstrap.min.js',
                                                                '/backend/app/controllers/datatable.js'
                                                            ]
                                                        });
                                            }
                                    );

                                }
                            ]
                        }

                    })
                    .state('admin.formlayout', {
                        url: '/formlayout',
                        templateUrl: 'views/form-layout.html',
                        ncyBreadcrumb: {
                            label: 'Form Layouts'
                        }
                    })
                    .state('admin.forminputs', {
                        url: '/forminputs',
                        templateUrl: 'views/form-inputs.html',
                        ncyBreadcrumb: {
                            label: 'Form Inputs'
                        }
                    })
                    .state('admin.formpickers', {
                        url: '/formpickers',
                        templateUrl: 'views/form-pickers.html',
                        ncyBreadcrumb: {
                            label: 'Form Pickers',
                            description: 'Data Pickers '
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load(['ui.select', 'ngTagsInput', 'daterangepicker', 'vr.directives.slider', 'minicolors', 'dropzone']).then(
                                            function () {
                                                return $ocLazyLoad.load(
                                                        {
                                                            serie: true,
                                                            files: [
                                                                '/backend/app/controllers/select2.js',
                                                                '/backend/app/controllers/tagsinput.js',
                                                                '/backend/app/controllers/datepicker.js',
                                                                '/backend/app/controllers/timepicker.js',
                                                                '/backend/app/controllers/daterangepicker.js',
                                                                '/backend/lib/jquery/fuelux/spinbox/fuelux.spinbox.js',
                                                                '/backend/lib/jquery/knob/jquery.knob.js',
                                                                '/backend/lib/jquery/textarea/jquery.autosize.js',
                                                                '/backend/app/controllers/slider.js',
                                                                '/backend/app/controllers/minicolors.js'
                                                            ]
                                                        });
                                            }
                                    );
                                }
                            ]
                        }
                    })
                    .state('admin.formwizard', {
                        url: '/formwizard',
                        templateUrl: 'views/form-wizard.html',
                        ncyBreadcrumb: {
                            label: 'Form Wizard'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load({
                                        serie: true,
                                        files: [
                                            '/backend/lib/jquery/fuelux/wizard/wizard-custom.js'
                                        ]
                                    });
                                }
                            ]
                        }
                    })
                    .state('admin.formvalidation', {
                        url: '/formvalidation',
                        templateUrl: 'views/form-validation.html',
                        ncyBreadcrumb: {
                            label: 'Form Validation',
                            description: 'Bootstrap Validator'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load({
                                        serie: true,
                                        files: [
                                            '/backend/app/controllers/validation.js'
                                        ]
                                    });
                                }
                            ]
                        }
                    })
                    .state('admin.formeditors', {
                        url: '/formeditors',
                        templateUrl: 'views/form-editors.html',
                        ncyBreadcrumb: {
                            label: 'Form Editors'
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
                    .state('admin.forminputmask', {
                        url: '/forminputmask',
                        templateUrl: 'views/form-inputmask.html',
                        ncyBreadcrumb: {
                            label: 'Form Input Mask'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load({
                                        serie: true,
                                        files: [
                                            '/backend/lib/jquery/inputmask/jasny-bootstrap.min.js'
                                        ]
                                    });
                                }
                            ]
                        }
                    })
                    .state('admin.flot', {
                        url: '/flot',
                        templateUrl: 'views/flot.html',
                        ncyBreadcrumb: {
                            label: 'Flot Charts',
                            description: 'attractive plotting'
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
                                            '/backend/app/controllers/flot.js'
                                        ]
                                    });
                                }
                            ]
                        }
                    })
                    .state('admin.morris', {
                        url: '/morris',
                        templateUrl: 'views/morris.html',
                        ncyBreadcrumb: {
                            label: 'Morris Charts',
                            description: 'simple & flat charts'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load({
                                        serie: true,
                                        files: [
                                            '/backend/lib/jquery/charts/morris/raphael-2.0.2.min.js',
                                            '/backend/lib/jquery/charts/morris/morris.js',
                                            '/backend/app/controllers/morris.js'
                                        ]
                                    });
                                }
                            ]
                        }
                    })
                    .state('admin.sparkline', {
                        url: '/sparkline',
                        templateUrl: 'views/sparkline.html',
                        ncyBreadcrumb: {
                            label: 'Sparkline',
                            description: 'inline charts'
                        },
                        resolve: {
                            deps: [
                                '$ocLazyLoad',
                                function ($ocLazyLoad) {
                                    return $ocLazyLoad.load({
                                        serie: true,
                                        files: [
                                            '/backend/lib/jquery/charts/sparkline/jquery.sparkline.js'
                                        ]
                                    });
                                }
                            ]
                        }
                    })
                    .state('admin.easypiechart', {
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
                    .state('admin.chartjs', {
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
                    .state('admin.profile', {
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
                    .state('admin.inbox', {
                        url: '/inbox',
                        templateUrl: 'views/inbox.html',
                        ncyBreadcrumb: {
                            label: 'Beyond Mail'
                        }
                    })
                    .state('admin.messageview', {
                        url: '/viewmessage',
                        templateUrl: 'views/message-view.html',
                        ncyBreadcrumb: {
                            label: 'Veiw Message'
                        }
                    })
                    .state('admin.messagecompose', {
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
                    .state('admin.calendar', {
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
                    .state('admin.timeline', {
                        url: '/timeline',
                        templateUrl: 'views/timeline.html',
                        ncyBreadcrumb: {
                            label: 'Responsive Timeline'
                        }
                    })
                    .state('admin.pricing', {
                        url: '/pricing',
                        templateUrl: 'views/pricing.html',
                        ncyBreadcrumb: {
                            label: 'Pricing Tables'
                        }
                    })
                    .state('admin.invoice', {
                        url: '/invoice',
                        templateUrl: 'views/invoice.html',
                        ncyBreadcrumb: {
                            label: 'Invoice Page'
                        }
                    })
                    .state('login', {
                        url: '/admin/login',
                        templateUrl: 'admin/login',//laravel slug
                        requiredLogin: false,
                        ncyBreadcrumb: {
                            label: 'Login'
                        }
                    })
                    .state('logout', {
                        url: '/admin/logout',
                        templateUrl: 'admin/logout',
                        requiredLogin: false,
                        ncyBreadcrumb: {
                            label: 'Logout'
                        }
                    })
                    .state('forgotPassword', {
                        url: '/admin/forgotPassword',
                        templateUrl: 'admin/password/resetLink/backend',
                        requiredLogin: false,
                        ncyBreadcrumb: {
                            label: 'Forgot Password'
                        }
                    })
                    .state('resetPassword', {
                        url: '/admin/resetPassword/:resetToken',
                        requiredLogin: false,
                        templateUrl: function (params) {
                            return 'admin/password/reset/' + params.resetToken + '/backend';
                        },
                        ncyBreadcrumb: {
                            label: 'Reset Password'
                        }
                    })
                    .state('register', {
                        url: '/admin/register',
                        templateUrl: 'admin/register',
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
                    .state('admin.typography', {
                        url: '/typography',
                        templateUrl: 'views/typography.html',
                        ncyBreadcrumb: {
                            label: 'Typography'
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
                        templateUrl: 'views/error-500.html',
                        ncyBreadcrumb: {
                            label: 'Error 500 - something went wrong'
                        }
                    })
                    .state('admin.blank', {
                        url: '/blank',
                        templateUrl: 'views/blank.html',
                        ncyBreadcrumb: {
                            label: 'Blank Page'
                        }
                    })
                    .state('admin.grid', {
                        url: '/grid',
                        templateUrl: 'views/grid.html',
                        ncyBreadcrumb: {
                            label: 'Bootstrap Grid'
                        }
                    })
                    .state('admin.versions', {
                        url: '/versions',
                        templateUrl: 'views/versions.html',
                        ncyBreadcrumb: {
                            label: 'BeyondAdmin Versions'
                        }
                    })
                    .state('admin.mvc', {
                        url: '/mvc',
                        templateUrl: 'views/mvc.html',
                        ncyBreadcrumb: {
                            label: 'BeyondAdmin Asp.Net MVC Version'
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
//    console.log("1." + toState.requiredLogin + "===" + $rootScope.authenticated);
//        if ((toState.requiredLogin && $rootScope.authenticated === false) || (toState.requiredLogin && $rootScope.authenticated === true)) // true && false || true && true
//        {
            if((toState.requiredLogin && $rootScope.authenticated === false) || (!toState.requiredLogin && $rootScope.authenticated === false)){ // true && false
                Data.get('session').then(function (results) {
                    if (results.success === true) {
//                        console.log("in if - if");
                        $rootScope.authenticated = true;
                        $rootScope.id = results.id;
                        $rootScope.name = results.name;
                        $rootScope.email = results.email;
                        $window.sessionStorage.setItem("userLoggedIn",true);
                        $http.get('admin/getMenuItems').then(function (response) {
                            $rootScope.getMenu = response.data;
                        }, function (error) {
                            alert('Error');
                        });
                        var modifiedUrl = nextUrl.substr(nextUrl.lastIndexOf('/') + 0);
                        modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
                        if (nextUrl === '/admin/register' || nextUrl === '/admin/login' || nextUrl === '/admin/forgotPassword' || modifiedUrl === '/admin/resetPassword') {
                            $state.transitionTo("admin.dashboard");
                            event.preventDefault();
                            return false;
                        }
                    }
                    else {
                        var modifiedUrl = nextUrl.substr(nextUrl.lastIndexOf('/') + 0);
                        modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
                        if (nextUrl === '/admin/register' || nextUrl === '/admin/login' || nextUrl === '/admin/forgotPassword' || modifiedUrl === '/admin/resetPassword') {
//                            console.log("in if - else - if");
                            event.preventDefault();
                            return false;
                        } else {
//                            console.log("in if - else - else");
                            $state.go('login');
                            event.preventDefault();
                            return false;
                        }
                    }
                });
            }
//        }
//        else if ((!toState.requiredLogin && $rootScope.authenticated === false) || (!toState.requiredLogin && $rootScope.authenticated === true))// false && false || false && true
          
//            console.log("else");
            if(!toState.requiredLogin && $rootScope.authenticated === true) //false && true
            {
//                console.log("else - if");
                $state.go('admin.dashboard');
                $state.reload();
                event.preventDefault();
                return false;
            }
            
            
//            var modifiedUrl = nextUrl.substr(nextUrl.lastIndexOf('/') + 0);
//            modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
//            if (nextUrl === '/admin/register' || nextUrl === '/admin/login' || nextUrl === '/admin/forgotPassword' || modifiedUrl === '/admin/resetPassword') {
//                $state.go('admin.dashboard');
//                $state.reload();
//                event.preventDefault();
//                return;
//            } else {
//                $state.go('login');
//                event.preventDefault();
//                return;
//            }
//        }
        
        /*else {
            
            var nextUrl = $location.path();
            if (!toState.requiredLogin){
                if (nextUrl === '/admin/register' || nextUrl === '/admin/login' || nextUrl === '/admin/forgotPassword' || nextUrl === '/admin/resetPassword') {
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

app.directive('action', function () {
    return {
        template: '<li ng-repeat="item in getMenu" ui-sref-active="{{ item.uiSrefActive }}"> <a ui-sref="{{ item.uiSref }}"><i class="menu-icon glyphicon glyphicon-home"></i><span class="menu-text"> {{ item.name }} </span></a></li>',
        restrict: 'E',
        states: '='
    }
});

var compareTo = function() {
    return {
      require: "ngModel",
      scope: {
        otherModelValue: "=compareTo"
      },
      link: function(scope, element, attributes, ngModel) {

        ngModel.$validators.compareTo = function(modelValue) {
          return modelValue == scope.otherModelValue;
        };

        scope.$watch("otherModelValue", function() {
          ngModel.$validate();
        });
      }
    };
  };
app.directive("compareTo", compareTo);

