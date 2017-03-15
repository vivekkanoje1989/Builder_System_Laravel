'use strict';
/*******************************MANOJ*********************************/
app.controller('contactUsCtrl', ['$scope', 'Data', '$rootScope', '$timeout', function ($scope, Data, $rootScope, $timeout) {

        $scope.itemsPerPage = 4;
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
//        $scope.success = function (message) {
//            Flash.create('success', message);
//        };

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);

app.controller('socialwebsitesCtrl', ['$scope', 'Data', '$rootScope', '$timeout', function ($scope, Data, $rootScope,  $timeout ) {

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
//        $scope.success = function (message) {
//            Flash.create('success', message);
//        };

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
/*******************************MANOJ*********************************/
/*******************************UMA*********************************/
app.controller('contentPagesCtrl', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout', '$parse', function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout, $parse) {
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
                if (!response.success)
                {

                } else
                {
                    $state.go(getUrl + '.contentPagesIndex');
                }
            });
            //alert("update");
        }
        $scope.manageImagePage = function (pageId)
        {
            Data.post('website_settings/getImages', {
                Data: {pageId: pageId, },
            }).then(function (response) {
                //console.log(response.records[0]['banner_images']);
                //var imgs = JSON.parse("[" + response.records[0]['banner_images'] + "]");
                var arraydata = response.records[0]['banner_images'].split(',');
                $scope.imgs = arraydata;
                //  $scope.contentPage = response.records[0];
            });
        }
        $scope.updateimagePage = function (allimg, imageData, pageId)
        {
            console.log(imageData);
            if (typeof imageData !== 'undefined') {
                $scope.err_msg = '';
                allimg.push(imageData['name']);
                allimg.toString();
                var url = getUrl + '/website_settings/saveImagePageSettings';
                var data = {pageId: pageId, imageData: allimg, uploadImage: imageData};

                console.log(data);
                imageData.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                });
                imageData.upload.then(function (response) {
                    $timeout(function () {
                        if (!response.data.success) {
                           alert("wrong");
                        } else
                        {
                            console.log(response);
                        }
                    });
                }, function (response) {
                    if (response.status !== 200) {
                        $scope.errorMsg = "Something went wrong. Check your internet connection";
                    }
                });
//                Data.post('website_settings/saveImagePageSettings', {
//                    pageId: pageId, imageData: allimg, uploadImage: imageData,
//                }).then(function (response) {
//                    if (!response.success)
//                    {
//
//                    } else
//                    {
//                        // $state.go(getUrl+'.contentPagesIndex');
//                        $scope.imagePage.banner_images = '';
//                    }
//                });
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
                    if (!response.success)
                    {

                    } else
                    {
                        // $state.go(getUrl+'.contentPagesIndex');
                    }
                });
            }
        }

    }]);
/*******************************UMA*********************************/
