
app.controller('blogsCtrl', ['$scope', 'Data', '$timeout', 'Upload', '$state', 'toaster', '$parse', function ($scope, Data, $timeout, Upload, $state, toaster, $parse) {

        $scope.blogId = 0;
        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.createBlog = false;
        $scope.updateBlog = false;
        $scope.blogData = {};
        $scope.manageBlogs = function () {
            Data.post('manage-blog/manageBlogs').then(function (response) {
                $scope.blogsRow = response.records;
            });
        };
        $scope.doblogscreateAction = function (bannerImage, galleryImage, blogData) {
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
                var data = {'blogData': blogData, 'blogImages': {'blog_banner_images': bannerImage},
                    'galleryImage': {'galleryImage': galleryImage}
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
                $scope.showloader();
                if (response.data.success) {
                    $scope.hideloader();
                    $timeout(function () {
                        if ($scope.blogId == '0')
                        {
                            toaster.pop('success', 'Manage blog', 'Record successfully created');
                        } else {
                            toaster.pop('success', 'Manage blog', 'Record successfully updated');
                        }
                    }, 1500);
                    $state.go('manageblogIndex');
                }else{
                    $scope.hideloader();
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
                $scope.blogData.blog_banner_images = "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Blog/blog_banner_images/" + response.records.blog_banner_images;
                $scope.blogData.blog_images = "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Blog/gallery_image/" + response.records.blog_images;

                var arraydata = response.records.blog_banner_images.split(',');
                $scope.bannerImage_preview = arraydata;

                var arraydata1 = response.records.blog_images.split(',');
                $scope.blog_images_preview = arraydata1;
            });
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

        $scope.removeImg = function (imgname, indeximg, blogId)
        {
            if (window.confirm("Are you sure want to remove this image?"))
            {
                if (indeximg > -1) {
                    $scope.imgs.splice(indeximg, 1);
                    Data.post('manage-blog/removeBlogImage', {
                        blogId: blogId, imageName: imgname, allimg: $scope.imgs,
                    }).then(function (response) {
                        if (!response.success)
                        {
                        }
                    });
                }
            }
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);
