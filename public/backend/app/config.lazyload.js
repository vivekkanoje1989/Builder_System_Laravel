angular.module('app')
    .config([
        '$ocLazyLoadProvider', function ($ocLazyLoadProvider) {
            $ocLazyLoadProvider.config({
                debug: true,
                events: true,
                modules: [
                    {
                        name: 'toaster',
                        files: [
                            '/backend/lib/modules/angularjs-toaster/toaster.css',
                            '/backend/lib/modules/angularjs-toaster/toaster.js'
                        ]
                    },
                    {
                        name: 'ui.select',
                        files: [
                            '/backend/lib/modules/angular-ui-select/select.css',
                            '/backend/lib/modules/angular-ui-select/select.js'
                        ]
                    },
                    {
                        name: 'ngTagsInput',
                        files: [
                            '/backend/lib/modules/ng-tags-input/ng-tags-input.js'
                        ]
                    },
                    {
                        name: 'daterangepicker',
                        serie: true,
                        files: [
                            '/backend/lib/modules/angular-daterangepicker/moment.js',
                            '/backend/lib/modules/angular-daterangepicker/daterangepicker.js',
                            '/backend/lib/modules/angular-daterangepicker/angular-daterangepicker.js'
                        ]
                    },
                    {
                        name: 'vr.directives.slider',
                        files: [
                            '/backend/lib/modules/angular-slider/angular-slider.min.js'
                        ]
                    },
                    {
                        name: 'minicolors',
                        files: [
                            '/backend/lib/modules/angular-minicolors/jquery.minicolors.js',
                            '/backend/lib/modules/angular-minicolors/angular-minicolors.js'
                        ]
                    },
                    {
                        name: 'textAngular',
                        files: [
                            '/backend/lib/modules/text-angular/textAngular-sanitize.min.js',
                            '/backend/lib/modules/text-angular/textAngular-rangy.min.js',
                            '/backend/lib/modules/text-angular/textAngular.min.js'
                        ]
                    },
                    {
                        name: 'ng-nestable',
                        files: [
                            '/backend/lib/modules/angular-nestable/jquery.nestable.js',
                            '/backend/lib/modules/angular-nestable/angular-nestable.js'
                        ]
                    },
                    {
                        name: 'angularBootstrapNavTree',
                        files: [
                            '/backend/lib/modules/angular-bootstrap-nav-tree/abn_tree_directive.js'
                        ]
                    },
                    {
                        name: 'ui.calendar',
                        files: [
                            '/backend/lib/jquery/fullcalendar/jquery-ui.custom.min.js',
                            '/backend/lib/jquery/fullcalendar/moment.min.js',
                            '/backend/lib/jquery/fullcalendar/fullcalendar.js',
                            '/backend/lib/modules/angular-ui-calendar/calendar.js'
                        ]
                    },
                    {
                        name: 'ngGrid',
                        files: [
                            '/backend/lib/modules/ng-grid/ng-grid.min.js',
                            '/backend/lib/modules/ng-grid/ng-grid.css'
                        ]
                    },
                    {
                        name: 'dropzone',
                        files: [
                            '/backend/lib/modules/angular-dropzone/dropzone.min.js',
                            '/backend/lib/modules/angular-dropzone/angular-dropzone.js'
                        ]
                    }
                ]
            });
        }
    ]);