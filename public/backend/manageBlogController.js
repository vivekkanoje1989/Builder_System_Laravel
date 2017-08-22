
app.controller('blogsCtrl', ['$scope', 'Data', '$timeout', 'Upload', '$state', 'toaster', '$parse', '$rootScope', function ($scope, Data, $timeout, Upload, $state, toaster, $parse, $rootScope) {

        $scope.blogId = 0;
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.createBlog = false;
        $scope.updateBlog = false;
         $scope.searchDetails = {};
         $scope.searchData = {};
       
        $scope.filterDetails = function (search) {
//             $scope.searchDetails = {};
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
        
        $scope.blogData = {};
        $scope.manageBlogs = function () {
            Data.post('manage-blog/manageBlogs').then(function (response) {
                $scope.blogsRow = response.records;
            });
        };
        $scope.doblogscreateAction = function (bannerImage, galleryImage, blogData, blogimgs) {

            $scope.errorMsg = '';
            $scope.createBlog = true;
            $scope.updateBlog = true;
            $scope.allimages = '';
            if (typeof bannerImage === 'undefined') {
                bannerImage = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            if ($scope.blogId == '0')
            {
                var url = '/manage-blog/';
                var data = {
                    'blogData': blogData, 'blogImages': {'blog_banner_images': bannerImage},
                    'galleryImage': {'galleryImage': galleryImage}, blog_code: $scope.code, blog_status: $scope.status}

            } else {
                var url = '/manage-blog/update/' + $scope.blogId;
                var successMsg = "Blog updated successfully.";
                if (typeof bannerImage === 'string') {
                    bannerImage = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                if (typeof galleryImage === 'string') {
                    galleryImage = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var data = {'blogData': blogData, 'blogImages': {'blog_banner_images': bannerImage},
                    'galleryImage': {'galleryImage': galleryImage}, blogimgs: blogimgs
                }
            }
            bannerImage.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            bannerImage.upload.then(function (response) {
                $scope.createBlog = false;
                $scope.updateBlog = false;
                $scope.errormsg = response.data.errormsg;

                if (response.data.success) {
                    $scope.showloader();

                    $timeout(function () {

                        if ($scope.blogId == '0')
                        {
                            $scope.hideloader();
                            toaster.pop('success', 'Manage blog', 'Record successfully created');
                        } else {
                            $scope.hideloader();
                            toaster.pop('success', 'Manage blog', 'Record successfully updated');
                        }
                    }, 1500);
                    $state.go('manageblogIndex');
                } else {
                    var obj = response.data.message;
                    var selector = [];
                    for (var key in obj) {
                        var model = $parse(key);// Get the model
                        model.assign($scope, obj[key][0]);// Assigns a value to it
                        selector.push(key);
                    }
                }
            }, function (response) {
                if (response.status !== 200) {
                    $scope.createBlog = false;
                    $scope.updateBlog = false;
                    $timeout(function () {
                        toaster.pop('error', 'Please Select gallery image for upload');
                    }, 1500);
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        };

        $scope.editBlogs = function (blogId) {
            $scope.blogId = blogId;
            Data.post('manage-blog/getBlogsDetail', {blog_id: $scope.blogId}).then(function (response) {
                $scope.blogData = response.records;
                $scope.blogData.blog_banner_images = response.records.blog_banner_images;
                $scope.blogData.blog_images = response.records.blog_images;

                var arraydata = response.records.blog_banner_images.split(',');
                $scope.bannerImage_preview = arraydata;

                var arraydata1 = response.records.blog_images.split(',');
                $scope.galleryImage_preview = arraydata1;
            });
        }
        $scope.editBlogData = function (list, index, pageId)
        {
           
            
            $scope.blogData = list;
            if (list.blog_images != '') {
                var blog = list.blog_images.split(',');
                
            }
            if (list.blog_banner_images != '') {
                var blog_banner = list.blog_banner_images.split(',');
            }
            $scope.bannerImage_preview = (blog_banner);

            $scope.galleryImage_preview = (blog);
            $scope.index = index;
            
        }

        $scope.checkImageExtension = function (galleryImage) {
            if (typeof galleryImage !== 'undefined' || typeof galleryImage !== 'object') {
                var ext = galleryImage.match(/\.(.+)$/)[1];
                if (angular.lowercase(ext) === 'jpg' || angular.lowercase(ext) === 'jpeg' || angular.lowercase(ext) === 'png' || angular.lowercase(ext) === 'bmp' || angular.lowercase(ext) === 'gif' || angular.lowercase(ext) === 'svg') {
                    $scope.invalidImage = "";
                    $scope.altName = employeePhoto.name;
                } else {
                    $(".imageFile").val("");
                    $scope.invalidImage = "Invalid file format. Image should be jpg or jpeg or png or bmp format only.";
                }
            }
        };

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
        $scope.removeGalleryImg = function (imgname, indeximg, pageId)
        {
           
            if (window.confirm("Are you sure want to remove this image?"))
            {
                if (indeximg > -1) {
                    $scope.galleryImage_preview.splice(indeximg, 1);
                    Data.post('manage-blog/removeImage', {
                        pageId:$scope.blogId , imageName: imgname, galleryImage_preview: $scope.galleryImage_preview,
                    }).then(function (response) {
                        if (!response.success)
                        {
                            toaster.pop('success', 'Gallery Image', 'Image remove successfully.');
                        } else
                        {
                            toaster.pop('success', 'Gallery Image', 'Image remove successfully.');
                        }
                    });
                }
            }
        }
    }]);
