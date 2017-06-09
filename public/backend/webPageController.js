'use strict';
app.controller('contentPagesCtrl', ['$scope', 'Data', 'Upload', '$timeout', 'toaster', function ($scope, Data, Upload, $timeout, toaster) {
        $scope.currentPage = $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.subId = '0';
        $scope.submitted = true;
        $scope.sbtBtn = false;

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

        $scope.getSubPages = function (pageid)
        {
            Data.post('web-pages/getSubPages', {
                Data: {pageId: pageid, },
            }).then(function (response) {
                $scope.subPage = response.records;
            });
        }

        $scope.updateWebPage = function (contentdata, allimg, imageData, pageId)
        {
            if (typeof imageData === 'undefined') {
                imageData = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            $scope.err_msg = '';
            var imgCount = document.getElementById("banner_images").files.length;
            var url = '/web-pages/updateWebPage';
            var data = {pageId: pageId, imageData: allimg, uploadImage: imageData, totalImages: imgCount, contentData: contentdata};

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
        }

        $scope.editSubPage = function (list, index)
        {
            $scope.subcontentPage = list;
            if(list.banner_images != ''){
            var banner = list.banner_images.split(',');
            }
            $scope.subimgs = (banner);
            $scope.subId = list.id;
            $scope.index = index;
        }

        $scope.updateSubWebPage = function (subcontentPage, allimg, imageData, pageId)
        {
            if (typeof imageData === 'undefined') {
                imageData = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            $scope.err_msg = '';
            var imgCount = document.getElementById("subbanner_images").files.length;
            if ($scope.subId == 0){
                var url = '/web-pages/storeSubWebPage';
                var data = {pageId: pageId, imageData: allimg, uploadImage: imageData, totalImages: imgCount, subcontentPage: subcontentPage};
            } else {
                var url = '/web-pages/updateSubWebPage';
                var data = {'id': $scope.subId, pageId: pageId, imageData: allimg, uploadImage: imageData, totalImages: imgCount, subcontentPage: subcontentPage};
            }
            imageData.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            imageData.upload.then(function (response) {
                var record = response.data.records;
                if ($scope.subId == 0)
                {
                    $scope.subPage.push({'page_name': record.page_name, 'page_title': record.page_title, 'seo_url': record.seo_url, 'seo_page_title': record.seo_page_title,
                        'meta_description': record.meta_description, 'meta_keywords': record.meta_keywords, 'canonical_tag': record.canonical_tag, 'child_page_position': record.child_page_position,
                        'status': record.status, 'id': response.data.id, 'banner_images': record.banner_images});

                } else {
                    $scope.subPage.splice($scope.index, 1);
                    $scope.subPage.splice($scope.index, 0, {'page_name': record.page_name, 'page_title': record.page_title, 'seo_url': record.seo_url, 'seo_page_title': record.seo_page_title,
                        'meta_description': record.meta_description, 'meta_keywords': record.meta_keywords, 'canonical_tag': record.canonical_tag, 'child_page_position': record.child_page_position,
                        'status': record.status, 'id': response.data.id, id: $scope.subId});
                    $scope.subcontentPage = {};
                }
                $scope.subcontentPage = {};
                $scope.imageMgntForm.$setPristine();
                $scope.subImagePage.banner_images = '';
                $scope.submitted = true;
                $timeout(function () {
                    if (!response.data.success) {
                        toaster.pop('error', 'Manage Webpage', 'Webpage failed to add');
                    } else
                    {
                        toaster.pop('success', 'Manage Webpage', 'Sub Page Added successfully.');
                    }
                });
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong. Check your internet connection";
                }
            });
        }
        $scope.manageImagePage = function (pageId)
        {
            Data.post('web-pages/getImages', {
                Data: {pageId: pageId, },
            }).then(function (response) {
                if (response.records[0]['banner_images'] != null) {
                    var arraydata = response.records[0]['banner_images'].split(',');
                    $scope.imgs = arraydata;
                } else {
                    $scope.imgs = {};
                }
            });
        }
        $scope.updateImagePage = function (allimg, imageData, pageId)
        {
            if (typeof imageData === 'undefined') {
                imageData = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            $scope.err_msg = '';
            var imgCount = document.getElementById("banner_images").files.length;
            allimg.push(imageData['name']);
            var url = '/web-pages/updateWebPageImage';
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
            }         }
        $scope.removeSubImg = function (imgname, indeximg, pageId)
        {
            if (window.confirm("Are you sure want to remove this image?"))
            {
                if (indeximg > -1) {
                    $scope.subimgs.splice(indeximg, 1);
                    Data.post('web-pages/removeSubWebPageImage', {
                        pageId: $scope.subId, imageName: imgname, subimgs: $scope.subimgs,
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
            }
        }
    }]);