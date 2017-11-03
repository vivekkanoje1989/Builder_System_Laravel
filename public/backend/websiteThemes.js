app.controller('themesController', ['$scope', 'Data', 'Upload', '$timeout', 'toaster', '$parse', '$window', '$rootScope', '$modal', function ($scope, Data, Upload, $timeout, toaster, $parse, $window, $rootScope, $modal) {
        $rootScope.previewFullPage = false;
        $scope.noOfRows = 1;
        $scope.webTheme = false;
        $scope.exportData = '';
        $scope.theme = {};
        $scope.itemsPerPage = 30;

        $scope.searchData = {};
        $scope.searchDetails = {};
        $scope.filterDetails = function (search) {
            $scope.searchData = search;
            $('#showFilterModal').modal('hide');
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }

        $scope.showHelpWebThemes = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Webpage Themes</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }


        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.manageThemes = function () {
            $scope.showloader();
            Data.post('website/getThemes').then(function (response) {
                if (response.status) {
                    $scope.hideloader();
                    $scope.themesRow = response.records;
                    $scope.exportData = response.exportData;
                    $scope.deleteBtn = response.delete;
                } else {
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
            });
        };
        $scope.targetToNewTab = function (listid) {
            location.reload();
            $window.open('office.php#/theme/preview/id/' + listid, '_blank');
        };
        $scope.themeName = function () {
            $rootScope.previewFullPage = true;
        }
        $scope.applyTheme = function (id) {
            Data.post('website/applyTheme', {
                'id': id}).then(function (response) {
                toaster.pop('Website Theme', '', 'Theme applied successfully');
            });
        }
        $scope.closeWindow = function () {
            Data.get('theme/themePrevSession').then(function (response) {
                window.close();
            });
        }

        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteTheme(args['id'], args['index']);
        });

        $scope.deleteTheme = function (id, index) {
            Data.post('website/deleteTheme', {
                'id': id}).then(function (response) {
//                toaster.pop('success', 'Themes', 'Theme deleted successfully');
                $scope.themesRow.splice(index, 1);
            });
        }
        $scope.initialModal = function (id, theme_name, image, index, index1) {
            if (id == 0)
            {
                $scope.heading = 'Add Theme';
                $scope.id = '0';
                $scope.theme.theme_name = '';
                $scope.action = 'Add';
                $scope.require = true;
                $scope.image = '';
            } else {
                $scope.require = false;
                $scope.heading = 'Edit Theme';
                $scope.id = id;
                $scope.theme.theme_name = theme_name;
                $scope.image = image;
                $scope.action = 'Update';
            }
            $scope.sbtBtn = false;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
        }


        $scope.themeExportToxls = function () {
            $scope.getexcel = window.location = "/website-themes/themeExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        };

        $scope.doThemesAction = function (imageUrl, themeData) {
            $scope.errorMsg = '';
            if ($scope.id == '0')
            {
                var url = '/website-themes/';
                var data = {
                    'themeData': themeData, 'imageUrl': imageUrl}
            } else {
                var url = '/website-themes/update/' + $scope.id;

                if (typeof imageUrl === 'undefined') {
                    imageUrl = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var data = {
                    'themeData': themeData, 'imageUrl': imageUrl}
            }
            imageUrl.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            imageUrl.upload.then(function (response) {
                $scope.webTheme = false;
                if (response.data.success) {

                    $timeout(function () {
                        if ($scope.id == '0')
                        {
                            toaster.pop('success', 'Manage website themes', 'Record successfully created');

                        } else {
                            toaster.pop('success', 'Manage website themes', 'Record successfully updated');
                        }
                        $scope.image_url_preview = {};
                        $scope.Theme = {};
                        $('#themesModal').modal('toggle');
                        $window.location.reload();
                    });

                } else {
                    $scope.webTheme = false;
                    var obj = response.data.message;
                    var selector = [];
                    for (var key in obj) {
                        var model = $parse(key);// Get the model
                        model.assign($scope, obj[key][0]);// Assigns a value to it
                        selector.push(key);
                    }
                    $scope.errorMsg = response.data.errormsg;
                }
            }, function (response) {
                if (response.status !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);