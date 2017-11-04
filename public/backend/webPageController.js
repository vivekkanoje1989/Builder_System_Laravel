'use strict';
app.controller('contentPagesCtrl', ['$scope', 'Data', 'Upload', '$timeout', 'toaster', '$parse', '$rootScope', '$modal', function ($scope, Data, Upload, $timeout, toaster, $parse, $rootScope, $modal) {
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.subId = '0';
        $scope.exportData = '';
        $scope.submitted = true;
        $scope.sbtBtn = false;
        $scope.subcontentPage = {};
        $scope.subImagePage = {};
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        $scope.contentManagementExportToxls = function () {
            $scope.getexcel = window.location = "/web-pages/contentManagementExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        };
        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.showHelpContent = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Content Management</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }

        $scope.searchData = {};
        $scope.searchDetails = {};
        $scope.filterDetails = function (search) {
//            $scope.searchDetails = {};
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
        $scope.getWebPages = function () {
            $scope.showloader();
            Data.get('web-pages/getWebPages').then(function (response) {
                if (response.success) {
                    $scope.hideloader();
                    $scope.listPages = response.records.data;
                    $scope.exportData = response.records.exportData;
                    $scope.deleteBtn = response.records.delete;
                } else {
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }

            });
        }

        $scope.manageWebPage = function (pageid)
        {
            Data.post('web-pages/getEditWebPage', {
                Data: {pageId: pageid, },
            }).then(function (response) {
                $scope.contentPage = response.records[0];
            });
        }

        $scope.deletePage = function (id, index) {
            Data.post('web-pages/deletePage', {
                'id': id}).then(function (response) {
//                toaster.pop('success', 'Content Management', 'Web Page deleted successfully');
//                $scope.listPages.splice(index, 1);
                $("tr#" + id + "").remove();
            });
        }

        $scope.$on("deleteRecords", function (event, args) {
            $scope.deletePage(args['id'], args['index']);
        });

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
                        var obj = response.data.message;
                        var selector = [];
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                            selector.push(key);
                        }

                        //toaster.pop('error', 'Banner Image', 'Image not uploaded');
                    } else
                    {
                        Data.post('web-pages/getImages', {
                            Data: {pageId: pageId, },
                        }).then(function (response) {
                            var arraydata = response.records[0]['banner_images'].split(',');
                            $scope.imgs = arraydata;
                            toaster.pop('success', 'Content Management', 'records uploaded successfully.');
                        });
                    }
                });
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong. Check your internet connection";
                }
            });
        }

        $scope.editSubPage = function (list, index, pageId)
        {
            $scope.subcontentPage = list;
            $scope.subcontentPage['subpage_name'] = list.page_name;
            $scope.subcontentPage['subpage_title'] = list.page_title;
            if (list.banner_images != '') {
                var banner = list.banner_images.split(',');
            }

            $scope.subimgs = (banner);
            $scope.subId = list.id;
            $scope.index = index;
        }

        $scope.updateSubWebPage = function (subcontent, allimg, imageData, pageId)
        {

            if (typeof imageData === 'undefined') {
                imageData = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            $scope.err_msg = '';
            var imgCount = document.getElementById("subbanner_images").files.length;
            if ($scope.subId == 0) {
                var url = '/web-pages/storeSubWebPage';
                var data = {pageId: pageId, imageData: allimg, uploadImage: imageData, totalImages: imgCount, subcontentPages: subcontent};
            } else {
                var url = '/web-pages/updateSubWebPages';
                var data = {'id': $scope.subId, pageId: pageId, imageData: allimg, uploadImage: imageData, totalImages: imgCount, subcontentPage: subcontent};
            }
            imageData.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            imageData.upload.then(function (response) {
                var record = response.data.records;
                if (!response.data.success) {
                    var obj = response.data.message;
                    var selector = [];
                    for (var key in obj) {
                        var model = $parse(key);// Get the model
                        model.assign($scope, obj[key][0]);// Assigns a value to it
                        selector.push(key);
                    }
                    toaster.pop('error', 'Manage Webpage', 'Webpage failed to add');
                } else
                {
                    toaster.pop('success', 'Manage Webpage', 'Sub Page Added successfully.');
                }
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

                }
                $scope.subcontentPage = {};

                $scope.imageMgntForm.$setPristine();
                $scope.subImagePage.banner_images = '';
                $scope.subImagePage = {};
                $scope.submitted = true;


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
            }
        }
        $scope.removeSubImg = function (imgname, indeximg, pageId)
        {
            if (window.confirm("Are you sure want to remove this image?"))
            {
                alert(imgname);
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
