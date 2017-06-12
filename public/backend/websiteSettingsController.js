'use strict';
/*******************************MANOJ*********************************/
app.controller('contactUsCtrl', ['$scope', 'Data', function ($scope, Data) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.manageContactUs = function () {
            Data.get('website_settings/manageContactUs').then(function (response) {
                $scope.contactUsRow = response.records;

            });
        };
        $scope.initialModal = function (id, address, telephone, email, index) {

            $scope.heading = 'Update office address';
            $scope.id = id;
            $scope.address = address;
            $scope.index = index;
            $scope.telephone = telephone;
            $scope.email = email;
        }
        $scope.doContactusAction = function () {
            $scope.errorMsg = '';
            Data.post('website_settings/updateContactUs', {
                address: $scope.address, id: $scope.id, 'telephone': $scope.telephone, 'email': $scope.email}).then(function (response) {

                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $scope.contactUsRow.splice($scope.index - 1, 1);
                    $scope.contactUsRow.splice($scope.index - 1, 0, {
                        address: $scope.address, id: $scope.id, name: $scope.name, 'telephone': $scope.telephone, 'email': $scope.email});

                    $('#contactUsModal').modal('toggle');
                    $scope.success("Contact details updated successfully");
                }
            });
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);

app.controller('socialwebsitesCtrl', ['$scope', 'Data', function ($scope, Data) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageSocialWebsite = function () {
            Data.get('website_settings/manageSocialWebsite').then(function (response) {
                $scope.socialwebsiteRow = response.records;

            });
        };
        $scope.initialModal = function (id, name, link, status, index) {

            $scope.heading = 'Update social website';
            $scope.id = id;
            $scope.name = name;
            $scope.index = index;
            $scope.link = link;
            $scope.status = status;
        }
        $scope.dosocialwebsiteAction = function () {
            $scope.errorMsg = '';

            Data.post('website_settings/updateSocialWebsite', {
                name: $scope.name, id: $scope.id, link: $scope.link, status: $scope.status}).then(function (response) {
                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $scope.socialwebsiteRow.splice($scope.index, 1);
                    $scope.socialwebsiteRow.splice($scope.index, 0, {
                        name: $scope.name, id: $scope.id, link: $scope.link, status: $scope.status});
                    $('#contactUsModal').modal('toggle');
                    $scope.success("Social website details updated successfully");
                }
            });
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
/*******************************MANOJ*********************************/
/*******************************UMA*********************************/
app.controller('contentPagesCtrl', ['$scope', '$state', 'Data', 'Upload', '$timeout', function ($scope, $state, Data, Upload, $timeout) {
        $scope.currentPage = $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;

        Data.get('website_settings/managePages').then(function (response) {
            $scope.listPages = response.records.data;
            $scope.listUsersLength = response.records.total;
        });

        $scope.manageContentPage = function (pageid)
        {
            Data.post('website_settings/getContentPage', {
                Data: {pageId: pageid, },
            }).then(function (response) {
                $scope.contentPage = response.records[0];
            });
        }
        $scope.updatecontentPage = function (contentdata, pageId)
        {
            Data.post('website_settings/saveContentPageSettings', {
                pageId: pageId, contentData: contentdata,
            }).then(function (response) {
                if (response.success) {
                    $state.go('contentPagesIndex');
                }
            });
        }
        $scope.manageImagePage = function (pageId)
        {
            Data.post('website_settings/getImages', {
                Data: {pageId: pageId, },
            }).then(function (response) {
                var arraydata = response.records[0]['banner_images'].split(',');
                $scope.imgs = arraydata;
            });
        }
        $scope.updateimagePage = function (allimg, imageData, pageId)
        {
            if (typeof imageData !== 'undefined') {
                $scope.err_msg = '';
                allimg.push(imageData['name']);
                allimg.toString();
                var url = '/website_settings/saveImagePageSettings';
                var data = {pageId: pageId, imageData: allimg, uploadImage: imageData};

                imageData.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                });
                imageData.upload.then(function (response) {
                    $timeout(function () {
                        if (!response.data.success) {
                            alert("wrong");
                        }
                    });
                }, function (response) {
                    if (response.status !== 200) {
                        $scope.errorMsg = "Something went wrong. Check your internet connection";
                    }
                });
            } else
            {
                $scope.err_msg = "Please Select image for upoad";
            }
        }
        $scope.removeimg = function (imgname, indeximg, pageId)
        {
            if (indeximg > -1) {
                $scope.imgs.splice(indeximg, 1);
                Data.post('website_settings/saveImagePageSettings', {
                    pageId: pageId, imageData: $scope.imgs,
                }).then(function (response) {
                });
            }
        }

    }]);
/*******************************UMA*********************************/
