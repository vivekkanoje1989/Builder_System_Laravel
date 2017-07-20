app.controller('themesController', ['$scope', 'Data', 'Upload', '$timeout', 'toaster', function ($scope, Data, Upload, $timeout, toaster) {

        $scope.noOfRows = 1;
        $scope.itemsPerPage = 30;
        $scope.manageThemes = function () {
            Data.post('website/getThemes').then(function (response) {
                $scope.themesRow = response.records;
                console.log($scope.themesRow)

            });
        };
        $scope.initialModal = function (id, theme_name, image, index, index1) {

            if (id == 0)
            {
                $scope.heading = 'Add Themes';
                $scope.id = '0';
                $scope.theme_name = '';
                $scope.action = 'Submit';
                $scope.require = true;
                $scope.image = '';
            } else {
                $scope.require = false;
                $scope.heading = 'Edit Themes';
                $scope.id = id;
                $scope.theme_name = theme_name;
                $scope.image = image;
               
                $scope.action = 'Update';
            }

            $scope.sbtBtn = false;
            $scope.index = index * ($scope.noOfRows - 1) + (index1);
        }
        $scope.doThemesAction = function (imageUrl) {
            $scope.errorMsg = '';
            if ($scope.id == '0')
            {
                var url = '/website-themes/';
                var data = {
                    'theme_name': $scope.theme_name, 'imageUrl': imageUrl}
            } else {
                var url = '/website-themes/update/' + $scope.id;

                if (typeof imageUrl === 'undefined') {
                    imageUrl = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var data = {
                    'theme_name': $scope.theme_name, 'imageUrl': imageUrl, 'image': $scope.image}
            }
            imageUrl.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            imageUrl.upload.then(function (response) {
               
                if (response.data.success) {
                    $timeout(function () {
                        if ($scope.id == '0')
                        {
                            $scope.themesRow.push({'theme_name': $scope.theme_name, 'id': response.data.lastinsertid, 'image_url': response.data.image});
                            toaster.pop('success', 'Manage website themes', 'Record successfully created');

                        } else {
                            $scope.themesRow.splice($scope.index, 1);
                            $scope.themesRow.splice($scope.index, 0, {
                                theme_name: $scope.theme_name, id: $scope.id, 'image_url': response.data.image});
                            toaster.pop('success', 'Manage website themes', 'Record successfully updated');
                        }
                        $scope.image_url_preview = {};
                        $scope.Theme = {};
                        $('#themesModal').modal('toggle');
                    });
                } else {
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