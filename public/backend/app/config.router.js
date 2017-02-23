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
                .otherwise(getUrl+'/login'); 
            $stateProvider
                .state(getUrl, {
                    abstract: true,
                    url: '/'+getUrl,
                    templateUrl: getUrl+'/layout',
                })
                .state(getUrl+'.dashboard', {
                    url: '/dashboard',
                    templateUrl: getUrl+'/dashboard',
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
                .state(getUrl+'.user', {
                    url: '/user/create',
                    templateUrl: getUrl+'/master-hr/create',
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
                                        '/js/intlTelInput.js',
                                        '/backend/app/controllers/datepicker.js',
                                        '/backend/app/controllers/select.js',
                                    ]
                                }]);
                            }
                        ]
                    }
                })
                .state(getUrl+'.userIndex', {
                    url: '/user/index',
                    templateUrl: getUrl+'/master-hr/',
                    controller: 'hrController',
                    requiredLogin: true,
                    ncyBreadcrumb: {
                        label: 'Manage Users',
                        description: ''
                    },
                })
                .state(getUrl+'.userUpdate', {
                    url: '/user/update/:empId',
                    templateUrl:  function (stateParams){
                        return getUrl+'/master-hr/' + stateParams.empId + '/edit';
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
                                return $ocLazyLoad.load(['ui.select',{
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
                .state(getUrl+'.salesCreate', {
                    url: '/sales/create',
                    templateUrl: getUrl+'/master-sales/create',
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
                                        '/backend/customerController.js',
                                        '/js/intlTelInput.js',                                       
                                        '/backend/app/controllers/datepicker.js',
                                    ]
                                });
                            }
                        ]
                    }
                })
                .state(getUrl+'.salesIndex', {
                    url: '/sales/index',
                    templateUrl: getUrl+'/master-sales/',
                    requiredLogin: true,
                    ncyBreadcrumb: {
                        label: 'Manage Enquiries'
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
                .state(getUrl+'.databoxes', {
                    url: '/databoxes',
                    templateUrl: getUrl+'/databoxes',
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
                .state(getUrl+'.widgets', {
                    url: '/widgets',
                    templateUrl: getUrl+'/widgets',
                    requiredLogin: true,
                    ncyBreadcrumb: {
                        label: 'Widgets',
                        description: 'flexible containers'
                    }
                })
                .state(getUrl+'.easypiechart', {
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
                .state(getUrl+'.chartjs', {
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
                .state(getUrl+'.profile', {
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
                .state(getUrl+'.inbox', {
                    url: '/inbox',
                    templateUrl: 'views/inbox.html',
                    ncyBreadcrumb: {
                        label: 'Beyond Mail'
                    }
                })
                .state(getUrl+'.messageview', {
                    url: '/viewmessage',
                    templateUrl: 'views/message-view.html',
                    ncyBreadcrumb: {
                        label: 'Veiw Message'
                    }
                })
                .state(getUrl+'.messagecompose', {
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
                .state(getUrl+'.calendar', {
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
                    url: '/'+getUrl+'/login',
                    templateUrl: getUrl+'/login',//laravel slug
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
                    url: '/'+getUrl+'/logout',
                    templateUrl: getUrl+'/logout',
                    requiredLogin: false,
                    ncyBreadcrumb: {
                        label: 'Logout'
                    }
                })
                .state('forgotPassword', {
                    url: '/office/forgotPassword',
                    templateUrl: getUrl+'/password/resetLink/backend',
                    requiredLogin: false,
                    ncyBreadcrumb: {
                        label: 'Forgot Password'
                    }
                })
                .state('resetPassword', {
                    url: '/'+getUrl+'/resetPassword/:resetToken',
                    requiredLogin: false,
                    templateUrl: function (params) {
                        return getUrl+'/password/reset/' + params.resetToken + '/backend';
                    },
                    ncyBreadcrumb: {
                        label: 'Reset Password'
                    }
                })
                .state('register', {
                    url: '/'+getUrl+'/register',
                    templateUrl: getUrl+'/register',
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
                    templateUrl: getUrl+'/error500',
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
    if((toState.requiredLogin && $rootScope.authenticated === false) || (!toState.requiredLogin && $rootScope.authenticated === false)){ // true && false
        Data.get('session').then(function (results) {
            if (results.success === true) {
                $rootScope.authenticated = true;
                $rootScope.id = results.id;
                $rootScope.name = results.name;
                $rootScope.email = results.email;
                $window.sessionStorage.setItem("userLoggedIn",true);
                $http.get(getUrl+'/getMenuItems').then(function (response) {
                    $rootScope.getMenu = response.data;
                }, function (error) {
                    alert('Error');
                });
                var modifiedUrl = nextUrl.substr(nextUrl.lastIndexOf('/') + 0);
                modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
                if (nextUrl === '/'+getUrl+'/register' || nextUrl === '/'+getUrl+'/login' || nextUrl === '/'+getUrl+'/forgotPassword' || modifiedUrl === '/'+getUrl+'/resetPassword') {
                    $state.transitionTo(getUrl+".dashboard");
                    event.preventDefault();
                    return false;
                }
            }
            else {
                var modifiedUrl = nextUrl.substr(nextUrl.lastIndexOf('/') + 0);
                modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
                if (nextUrl === '/'+getUrl+'/register' || nextUrl === '/'+getUrl+'/login' || nextUrl === '/'+getUrl+'/forgotPassword' || modifiedUrl === '/'+getUrl+'/resetPassword') {
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
    if(!toState.requiredLogin && $rootScope.authenticated === true) //false && true
    {
        $state.go('admin.dashboard');
        $state.reload();
        event.preventDefault();
        return false;
    }
            
            
//            var modifiedUrl = nextUrl.substr(nextUrl.lastIndexOf('/') + 0);
//            modifiedUrl = nextUrl.replace(new RegExp(modifiedUrl), '');
//            if (nextUrl === '/'+getUrl+'/register' || nextUrl === '/'+getUrl+'/login' || nextUrl === '/'+getUrl+'/forgotPassword' || modifiedUrl === '/'+getUrl+'/resetPassword') {
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

