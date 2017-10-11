app.controller('themesController', ['$scope', 'Data', 'Upload', '$timeout', 'toaster', '$parse', '$window', '$location', '$rootScope', function ($scope, Data, Upload, $timeout, toaster, $parse, $window, $location, $rootScope) {

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

        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.manageThemes = function () {
            $scope.showloader();
            Data.post('website/getThemes').then(function (response) {
                $scope.hideloader();
                $scope.themesRow = response.records;
                $scope.exportData = response.exportData;
                $scope.deleteBtn = response.delete;

            });
        };

        $scope.applyTheme = function (id) {
            Data.post('website/applyTheme', {
                'id': id}).then(function (response) {
//                alert('apply')
            });
        }
        $scope.closeWindow = function () {
            window.close();
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
//                        $location.path('/website/themes');
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