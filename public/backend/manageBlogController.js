
app.controller('blogsCtrl', ['$scope', 'Data', '$rootScope', '$timeout','Upload','$state', function ($scope, Data, $rootScope, $timeout, Upload, $state) {

        $scope.blogId = 0;

        $scope.manageBlogs = function () {
            Data.post('manage-blog/manageBlogs').then(function (response) {
                $scope.blogsRow = response.records;
            });
        };

        $scope.doblogscreateAction = function (bannerImage) {
            $scope.errorMsg = '';
           
            if ($scope.blogId == '0')
            {
                var url = getUrl + '/manage-blog/';
                var data = {
             'blog_title': $scope.title, 'blog_seo_url': $scope.blog_seo_url,'blog_short_description':$scope.shortDescription,
             'blog_description':$scope.blog_description,'meta_description':$scope.meta_description,'meta_keywords':$scope.meta_keywords,
             'blog_publish':$scope.blog_publish,'blogImages':{ 'blog_banner_images':bannerImage } }
                var successMsg = "Blog created successfully.";
            } else {
                var url = getUrl + '/manage-blog/update/'+$scope.blogId;
                var successMsg = "Blog updated successfully.";
                if (typeof bannerImage === 'string') {
                    bannerImage = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var data = { blog_banner_images : bannerImage, blog_id: $scope.blogId,
             'blog_title': $scope.title, 'blog_seo_url': $scope.blog_seo_url,'blog_short_description':$scope.shortDescription,'blog_description':$scope.blog_description,'meta_description':$scope.meta_description,'meta_Keywords':$scope.meta_Keywords,'blog_publish':$scope.blog_publish
                }
            }
            bannerImage.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            bannerImage.upload.then(function (response) {
               $timeout(function () {
                    if (!response.data.success) {
                        var obj = response.data.message;
                        var arr = Object.keys(obj).map(function (k) {
                            return obj[k]
                        });
                        var err = [];
                        var j = 0;
                        for (var i = 0; i < arr.length; i++) {
                            err.push(arr[j++].toString());
                        }
                        $scope.errorMsg = err;
                    } else
                    {
                        $scope.disableCreateButton = true;
                        bannerImage.result = response.data;
                        $rootScope.alert('success', successMsg);
                        $('.alert-delay').delay(3000).fadeOut("slow");
                        $timeout(function () {
                            $state.go(getUrl+'.manageblogIndex');
                        }, 1000);
                    }
                });
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong. Check your internet connection";
                }
            }, function (evt, response) {
                //employeePhoto.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
          
            /* if($scope.blogId === '0'){
             Data.post('website_settings/createBlogs', {
             'blog_title': $scope.title, 'blog_seo_url': $scope.blog_seo_url,'blog_short_description':$scope.shortDescription,'blog_description':$scope.blog_description,'meta_description':$scope.meta_description,'meta_Keywords':$scope.meta_Keywords,'blog_publish':$scope.blog_publish}).then(function (response) {
             console.log(response);
             if (!response.success)
             {
             $scope.errorMsg = response.errormsg;
             } else {
             console.log(response);
             }
             });
             }else{
             
             Data.post('website_settings/updateBlogs', {'blog_id':$scope.blogId,
             'blog_title': $scope.title, 'blog_seo_url': $scope.blog_seo_url,'blog_short_description':$scope.shortDescription,'blog_description':$scope.blog_description,'meta_description':$scope.meta_description,'meta_Keywords':$scope.meta_Keywords,'blog_publish':$scope.blog_publish}).then(function (response) {
             console.log(response);
             if (!response.success)
             {
             $scope.errorMsg = response.errormsg;
             } else {
             console.log(response);
             }
             });
             }     */
        };

        $scope.editBlogs = function (blogId) {
            $scope.blogId = blogId;
            Data.post('manage-blog/getBlogsDetail', {blog_id: $scope.blogId}).then(function (response) {
                console.log(response.records);
                $scope.title = response.records.blog_title;
                $scope.blog_title = response.records.blog_title;
                $scope.blog_seo_url = response.records.blog_seo_url;
                $scope.shortDescription = response.records.blog_short_description;
                $scope.blog_description = response.records.blog_description;
                $scope.meta_description = response.records.meta_description;
                $scope.meta_Keywords = response.records.meta_Keywords;
                $scope.blog_publish = response.records.blog_publish;
                $scope.blog_banner_images = response.records.blog_banner_images;
                console.log($scope.blog_banner_images);
            });
        }
        $scope.success = function (message) {
            Flash.create('success', message);
        };

        $scope.checkImageExtension = function (employeePhoto) {
            if (typeof employeePhoto !== 'undefined' || typeof employeePhoto !== 'object') {
                var ext = employeePhoto.name.match(/\.(.+)$/)[1];
                if (angular.lowercase(ext) === 'jpg' || angular.lowercase(ext) === 'jpeg' || angular.lowercase(ext) === 'png' || angular.lowercase(ext) === 'bmp' || angular.lowercase(ext) === 'gif' || angular.lowercase(ext) === 'svg') {
                    $scope.invalidImage = "";
                    $scope.altName = employeePhoto.name;
                } else {
                    $(".imageFile").val("");
                    $scope.invalidImage = "Invalid file format. Image should be jpg or jpeg or png or bmp format only.";
                }
            }
        };

    }]);
