app.controller('testimonialsCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'Upload', '$state','toaster', function ($scope, Data, $rootScope, $timeout, Upload, $state,toaster) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.testimonial_id = 0;
        $scope.web_status = '1';
        $scope.testimonials = function () {
            Data.post('testimonials/approve').then(function (response) {
                $scope.ApprovedTestimonialsRow = response.records;
            });
        };
        $scope.managedTestimonials = function () {
            Data.post('testimonials-approve/manageApproved').then(function (response) {
                $scope.ApprovedTestimonialsRow = response.records;
            });
        }
        $scope.doTestimonialsAction = function (photo_url) {
            $scope.errorMsg = '';
            $scope.err_msg = '';
            if ($scope.testimonial_id == 0) {
                var url = getUrl + '/testimonials-approve/';
                var data = {
                    'customer_name': $scope.customer_name, 'company_name': $scope.company_name, 'description': $scope.description,
                    'web_status': $scope.web_status, 'mobile_number': $scope.mobile_number, 'video_url': $scope.video_url, 'photo_url': {'photo_url': photo_url}}
                var successMsg = "Testimonial created successfully.";
            } else {
                var url = getUrl + '/testimonials-approve/update';

                if (typeof photo_url === 'undefined') {
                    photo_url = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var data = {'testimonial_id': $scope.testimonial_id,
                    'customer_name': $scope.customer_name, 'company_name': $scope.company_name, 'description': $scope.description,
                    'web_status': $scope.web_status, 'approve_status': $scope.approve_status, 'mobile_number': $scope.mobile_number, 'video_url': $scope.video_url, 'photo_url': {'photo_url': photo_url}}
                var successMsg = "Testimonial updated successfully.";
            }
            photo_url.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            photo_url.upload.then(function (response) {
                $timeout(function () {
                  if ($scope.testimonial_id == 0) {  
                     toaster.pop('success', 'Testimonials', 'Record successfully created');
                 }else{
                      toaster.pop('success', 'Testimonials', 'Record successfully updated');
                 }
                    $state.go(getUrl + '.testimonialsIndex');
                });
            }, function (response) {
                if (response.status !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        }
        $scope.getTestimonialData = function (testimonial_id) {
            Data.post('testimonials-approve/getTestimonialData', {'testimonial_id': testimonial_id}).then(function (response) {
                $scope.testimonialsData = response.records;
                $scope.company_name = $scope.testimonialsData.company_name;
                $scope.customer_name = $scope.testimonialsData.customer_name;
                $scope.video_url = $scope.testimonialsData.video_url;
                $scope.mobile_number = $scope.testimonialsData.mobile_number;
                $scope.description = $scope.testimonialsData.description;
                $scope.web_status = $scope.testimonialsData.web_status;
                $scope.testimonial_id = testimonial_id;
                $scope.approve_status = $scope.testimonialsData.approve_status;
                $scope.image_name = "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Testimonial/" + $scope.testimonialsData.photo_url;
            });
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
