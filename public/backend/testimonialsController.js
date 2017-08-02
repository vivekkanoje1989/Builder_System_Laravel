app.controller('testimonialsCtrl', ['$scope', 'Data', 'Upload', 'toaster', '$parse', function ($scope, Data, Upload, toaster, $parse) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.testimonial_id = 0;
        $scope.testimonialsBtn = false;
        $scope.testimonial = [];
        $scope.testimonial.approve_status = $scope.testimonial.web_status = '1';
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
        $scope.doTestimonialsAction = function (photo_url,testimonial) {
             $scope.testimonialsBtn = true;
            $scope.errorMsg = '';
            $scope.err_msg = '';
            if ($scope.testimonial_id == 0) {
                
                var url = '/testimonials/';
                var data = {
                    'testimonial': testimonial, 'photo_url': photo_url}
            } else {
                var url = '/testimonials/update/' + $scope.testimonial_id;

                if (typeof photo_url === 'undefined' || typeof photo_url === 'string') {
                    photo_url = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
                }
                var data = {_method: 'PUT', 'testimonial_id': $scope.testimonial_id,'testimonial': testimonial,'photo_url': photo_url
                    }
            }
         
            photo_url.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            photo_url.upload.then(function (response) {
                if (response.success) {
                     $scope.testimonialsBtn = false;
                    if ($scope.testimonial_id == 0) {
                        toaster.pop('success', 'Testimonials', 'Record successfully created');
                    } else {
                        toaster.pop('success', 'Testimonials', 'Record successfully updated');
                    }
                }
                 $scope.testimonialsBtn = false;
                var obj = response.data.message;
                var selector = [];
                for (var key in obj) {
                    var model = $parse(key);// Get the model
                    model.assign($scope, obj[key][0]);// Assigns a value to it
                    selector.push(key);
                }
//                window.history.back();
            }, function (response) {
                 $scope.testimonialsBtn = false;
                if (response.status !== 200) {
                    $scope.errMsg = "Please Select image for upload";
                }
            });
        }
        $scope.getTestimonialData = function (testimonial_id) {
            Data.post('testimonials/getTestimonialData', {'testimonial_id': testimonial_id}).then(function (response) {
                $scope.testimonial = response.records;
//                $scope.company_name = $scope.testimonialsData.company_name;
//                $scope.customer_name = $scope.testimonialsData.customer_name;
//                $scope.video_url = $scope.testimonialsData.video_url;
//                $scope.mobile_number = $scope.testimonialsData.mobile_number;
//                $scope.description = $scope.testimonialsData.description;
//                $scope.web_status = $scope.testimonialsData.web_status;
//                $scope.testimonial_id = testimonial_id;
//                $scope.approve_status = $scope.testimonialsData.approve_status;
//                $scope.photo_url = $scope.testimonialsData.photo_url;
            });
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);
