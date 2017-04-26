'use strict';
app.controller('contentPagesCtrl', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout', '$parse', 'toaster', function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout, $parse, toaster) {
        $scope.currentPage = $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;

        Data.get('web-pages/getWebPages').then(function (response) {
            $scope.listPages = response.records.data;
        });
        $scope.manageWebPage = function (pageid)
        {
            Data.post('web-pages/getEditWebPage', {
                Data: {pageId: pageid, },
            }).then(function (response) {
                $scope.contentPage = response.records[0];
            });
        }
        $scope.updateWebPage = function (contentdata, pageId)
        {
            Data.post('web-pages/updateWebPage', {
                pageId: pageId, contentData: contentdata,
            }).then(function (response) {
                if (!response.success)
                {
                    toaster.pop('error', 'Web Page', 'Something Went Wrong!!');
                } else
                {
                    toaster.pop('success', 'Web Page', 'Page updated successfully.');
                    $state.go(getUrl + '.webPagesIndex');
                }
            });
        }
        $scope.manageImagePage = function (pageId)
        {
            Data.post('web-pages/getImages', {
                Data: {pageId: pageId, },
            }).then(function (response) {
                var arraydata = response.records[0]['banner_images'].split(',');
                $scope.imgs = arraydata;
            });
        }
        $scope.updateImagePage = function (allimg, imageData, pageId)
        {
            if (typeof imageData !== 'undefined') {
                console.log(imageData);
                $scope.err_msg = '';
                var imgCount = document.getElementById("banner_images").files.length;
                allimg.push(imageData['name']);

                var url = getUrl + '/web-pages/updateWebPageImage';

                var data = {pageId: pageId, imageData: allimg, uploadImage: imageData, totalImages: imgCount};

                imageData.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                });
                imageData.upload.then(function (response) {
                    $timeout(function () {
                        if (!response.data.success) {
                            toaster.pop('error', 'Banner Image', 'Image not uploaded');
                        } else
                        {
                            Data.post('web-pages/getImages', {
                                Data: {pageId: pageId, },
                            }).then(function (response) {
                                var arraydata = response.records[0]['banner_images'].split(',');
                                $scope.imgs = arraydata;
                                toaster.pop('success', 'Banner Image', 'Image uploaded successfully.');
                            });
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
        $scope.removeImg = function (imgname, indeximg, pageId)
        {
            if (window.confirm("Are you sure want to remove this image?"))
            {
                if (indeximg > -1) {
                    $scope.imgs.splice(indeximg, 1);
                    Data.post('web-pages/removeWebPageImage', {
                        pageId: pageId, imageName: imgname, allimg: $scope.imgs,
                    }).then(function (response) {
                        if (!response.success)
                        {
                            toaster.pop('success', 'Banner Image', 'Image remove successfully.');
                        } else
                        {
                            toaster.pop('success', 'Banner Image', 'Image remove successfully.');
                        }
                    });
                }
            } else
            {

            }
        }
    }]);