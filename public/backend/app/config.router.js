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
                        templateUrl: 'admin/layout',
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
                        url: '/user/create',
                        templateUrl: 'admin/master-hr/create',
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
                                    return $ocLazyLoad.load(['ui.select',{
                                        serie: true,
                                        files: [
//                                            '/backend/app/ng-file-upload.js',
//                                            '/backend/hrController.js',
                                            '/js/intlTelInput.js',
//                                            '/backend/lib/jquery/fuelux/wizard/wizard-custom.js',
                                            '/backend/app/controllers/datepicker.js',
                                            '/backend/app/controllers/select.js',
                                        ]
                                    }]);
                                }
                            ]
                        }
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
                    .state('login', {
                        url: '/admin/login',
                        templateUrl: 'admin/login',//laravel slug
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
                    .state('error404', {
                        url: '/error404',
                        templateUrl: 'views/error-404.html',
                        ncyBreadcrumb: {
                            label: 'Error 404 - The page not found'
                        }
                    })
                    .state('error500', {
                        url: '/error500',
                        templateUrl: 'admin/error500',
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
        /*Data.get('checkDevice').then(function (response) {
            if(!response.success){
                console.log(response.message);
                $state.go('error500');
                event.preventDefault();
                return false;
            }
        }, function (error) {
            alert('Error - Something went wrong.');
        });*/
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

