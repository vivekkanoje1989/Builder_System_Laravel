app.controller('testimonialsCtrl', ['$scope', 'Data', 'Upload', '$state', 'toaster', function ($scope, Data, Upload, $state, toaster) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.testimonial_id = 0;
        $scope.approve_status = $scope.web_status= '1';
        $scope.testimonials = function () {
            Data.post('testimonials/getDisapproveList').then(function (response) {
                $scope.ApprovedTestimonialsRow = response.records;
            });
        };
        $scope.manageTestimonials = function () {
            Data.post('testimonials/getApprovedList').then(function (response) {
                $scope.ApprovedTestimonialsRow = response.records;
            });
        }
        $scope.doTestimonialsAction = function (photo_url) {
            $scope.errorMsg = '';
            $scope.err_msg = '';
            if ($scope.testimonial_id == 0) {
                var url = getUrl + '/testimonials/';
                var data = {
                    'customer_name': $scope.customer_name, 'company_name': $scope.company_name, 'description': $scope.description,
                    'web_status': $scope.web_status, 'mobile_number': $scope.mobile_number, 'video_url': $scope.video_url, 'photo_url': photo_url}
            } else {
                var url = getUrl + '/testimonials/update/'+$scope.testimonial_id;

                if (typeof photo_url === 'undefined' || typeof photo_url === 'string') {
                    photo_url = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var data = {_method: 'PUT','testimonial_id': $scope.testimonial_id,
                    'customer_name': $scope.customer_name, 'company_name': $scope.company_name, 'description': $scope.description,
                    'web_status': $scope.web_status, 'approve_status': $scope.approve_status, 'mobile_number': $scope.mobile_number, 'video_url': $scope.video_url, 'photo_url': photo_url}
            }
            photo_url.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            photo_url.upload.then(function (response) {
                if ($scope.testimonial_id == 0) {
                    toaster.pop('success', 'Testimonials', 'Record successfully created');
                } else {
                    toaster.pop('success', 'Testimonials', 'Record successfully updated');
                }
                window.history.back();              
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errMsg = "Please Select image for upload";
                }
            });
        }
        $scope.getTestimonialData = function (testimonial_id) {
            Data.post('testimonials/getTestimonialData', {'testimonial_id': testimonial_id}).then(function (response) {
                $scope.testimonialsData = response.records;
                $scope.company_name = $scope.testimonialsData.company_name;
                $scope.customer_name = $scope.testimonialsData.customer_name;
                $scope.video_url = $scope.testimonialsData.video_url;
                $scope.mobile_number = $scope.testimonialsData.mobile_number;
                $scope.description = $scope.testimonialsData.description;
                $scope.web_status = $scope.testimonialsData.web_status;
                $scope.testimonial_id = testimonial_id;
                $scope.approve_status = $scope.testimonialsData.approve_status;
                $scope.photo_url = $scope.testimonialsData.photo_url;
            });
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);
