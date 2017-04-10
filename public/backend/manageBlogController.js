
app.controller('blogsCtrl', ['$scope', 'Data', '$timeout', 'Upload', '$state', 'toaster', function ($scope, Data, $timeout, Upload, $state, toaster) {

        $scope.blogId = 0;
        $scope.manageBlogs = function () {
            Data.post('manage-blog/manageBlogs').then(function (response) {
                $scope.blogsRow = response.records;
            });
        };
        $scope.doblogscreateAction = function (bannerImage, galleryImage) {
            $scope.errorMsg = '';
            $scope.allimages = '';
            if (typeof bannerImage === 'undefined') {
                bannerImage = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            }
            if ($scope.blogId == '0')
            {
                var url = getUrl + '/manage-blog/';
                var data = {
                    'blog_title': $scope.title, 'blog_seo_url': $scope.blog_seo_url, 'blog_short_description': $scope.blog_short_description,
                    'blog_description': $scope.blog_description, 'meta_description': $scope.meta_description,
                    'blog_publish': $scope.blog_publish, 'meta_keywords': $scope.meta_Keywords, 'blogImages': {'blog_banner_images': bannerImage}, 'galleryImage': {'galleryImage': galleryImage}}
            } else {
                var url = getUrl + '/manage-blog/update/' + $scope.blogId;
                var successMsg = "Blog updated successfully.";
                if (typeof bannerImage === 'string') {
                    bannerImage = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var data = {'blog_title': $scope.title, 'blog_seo_url': $scope.blog_seo_url, 'blog_short_description': $scope.blog_short_description,
                    'blog_description': $scope.blog_description, 'meta_description': $scope.meta_description,
                    'blog_publish': $scope.blog_publish, 'meta_keywords': $scope.meta_Keywords, 'blogImages': {'blog_banner_images': bannerImage}, 'galleryImage': {'galleryImage': galleryImage}, 'allgallery': $scope.imgs, 'allbanner': $scope.bannerImg
                }
            }
            bannerImage.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            bannerImage.upload.then(function (response) {
                $scope.errormsg = response.errormsg;
                $timeout(function () {
                    if ($scope.blogId == '0')
                    {
                        toaster.pop('success', 'Manage blog', 'Record successfully created');
                    } else {
                        toaster.pop('success', 'Manage blog', 'Record successfully updated');
                    }
                    $state.go(getUrl + '.manageblogIndex');
                });
            }, function (response) {
                if (response.status !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        };

        $scope.editBlogs = function (blogId) {
            $scope.blogId = blogId;
            Data.post('manage-blog/getBlogsDetail', {blog_id: $scope.blogId}).then(function (response) {

                $scope.title = response.records.blog_title;
                $scope.blog_title = response.records.blog_title;
                $scope.blog_seo_url = response.records.blog_seo_url;
                $scope.blog_description = response.records.blog_description;
                $scope.meta_description = response.records.meta_description;
                $scope.meta_Keywords = response.records.meta_keywords;
                $scope.blog_publish = response.records.blog_publish;
                $scope.blog_banner_images = response.records.blog_banner_images;
                $scope.blog_short_description = response.records.blog_short_description;
                $scope.bannerImg = response.records.blog_banner_images;
                $scope.blog_banner_images = "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/blogBannerImages/" + response.records.blog_banner_images;

                var arraydata = response.records.blog_images.split(',');
                $scope.imgs = arraydata;
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

                        } else
                        {
                            // $state.go(getUrl+'.contentPagesIndex');
                        }
                    });
                }
            }
        }
    }]);
