'use strict';
var app = angular.module('app', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngSanitize',
    'ngTouch',
    'ngStorage',
    'ui.router',
    'ncy-angular-breadcrumb',
    'ui.bootstrap',
    'ui.utils',
    'oc.lazyLoad',
    'ngMessages',
]);

/*app.directive('ngRightClick', function() {
    return function(scope, element, attrs) {
        var rightClickDisabled=attrs.ngRightClick;        
        if(! rightClickDisabled){
            element.bind('contextmenu', function(event) {
                scope.$apply(function() {
                    event.preventDefault();
                });
            });
            element.bind('keydown', function(event) {
                scope.$apply(function() {
                    if ((event.which || event.keyCode) == 116){ // f5 keyCode
                        event.preventDefault();
                    }
                });
            });            
        }
    }
});*/