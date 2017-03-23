'use strict';
/*******************************MANOJ*********************************/
app.controller('testimonialsCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'Upload', '$state', function ($scope, Data, $rootScope, $timeout, Upload, $state) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.testimonial_id = 0;
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
        $scope.doTestimonialsAction = function (photo_src) {
            $scope.errorMsg = '';
            $scope.err_msg = '';
            if ($scope.testimonial_id == 0) {

                var url = getUrl + '/testimonials-approve/';
                var data = {
                    'person_name': $scope.person_name, 'company_name': $scope.company_name, 'testimonial': $scope.testimonial,
                    'is_shown': $scope.is_shown, 'mobile_no': $scope.mobile_no, 'video_url': $scope.video_url, 'photo_src': {'photo_src': photo_src}}
                var successMsg = "Testimonial created successfully.";
            } else {
                var url = getUrl + '/testimonials-approve/update';
                var data = {'testimonial_id': $scope.testimonial_id,
                    'person_name': $scope.person_name, 'company_name': $scope.company_name, 'testimonial': $scope.testimonial,
                    'is_shown': $scope.is_shown, 'is_approve': $scope.is_approve, 'mobile_no': $scope.mobile_no, 'video_url': $scope.video_url, 'photo_src':  {'photo_src': photo_src}}
                var successMsg = "Testimonial updated successfully.";
            }
            photo_src.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            photo_src.upload.then(function (response) {
                console.log(response);
                $timeout(function () {
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
                $scope.person_name = $scope.testimonialsData.person_name;
                $scope.video_url = $scope.testimonialsData.video_url;
                $scope.mobile_no = $scope.testimonialsData.mobile_no;
                $scope.testimonial = $scope.testimonialsData.testimonial;
                $scope.is_shown = $scope.testimonialsData.is_shown;
                $scope.testimonial_id = testimonial_id;
                $scope.is_approve = $scope.testimonialsData.is_approve;
                $scope.image_name = "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Testimonial/" + $scope.testimonialsData.photo_src;

            });
        };

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
