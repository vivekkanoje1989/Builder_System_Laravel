/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('frontendapp')
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
                        
                        $stateProvider
                        .state('website', {
                                    url: '/website/',
                                    templateUrl: 'website/main',
                                });
                }]
        );
        