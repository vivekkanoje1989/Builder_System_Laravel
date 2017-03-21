'use strict';
/*******************************MANOJ*********************************/
app.controller('testimonialsCtrl', ['$scope', 'Data', '$rootScope', '$timeout', 'Upload', function ($scope, Data, $rootScope, $timeout, Upload) {

        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.testimonial_id = 0;
        $scope.testimonials = function () {
            Data.post('testimonials/approve').then(function (response) {
                $scope.ApprovedTestimonialsRow = response.records;

            });
        };

        $scope.managedTestimonials = function(){
             Data.post('testimonials-approve/manageApproved').then(function (response) {
                $scope.ApprovedTestimonialsRow = response.records;
            });
        } 
        $scope.doTestimonialsAction = function (photo_src) {
            $scope.errorMsg = '';
            if($scope.testimonial_id == 0){
             
            var url = getUrl + '/testimonials-approve/';
            var data = {
                'person_name': $scope.person_name, 'company_name': $scope.company_name, 'testimonial': $scope.testimonial,
                'is_shown': $scope.is_shown, 'mobile_no': $scope.mobile_no, 'video_url': $scope.video_url, 'photo_src': {'photo_src': photo_src}}
            var successMsg = "Testimonial created successfully.";
           }else{
               photo_src = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
               var url = getUrl + '/testimonials-approve/update/'+$scope.testimonial_id;
               method:"put";
            var data = {
                'person_name': $scope.person_name, 'company_name': $scope.company_name, 'testimonial': $scope.testimonial,
                'is_shown': $scope.is_shown,'is_approved':$scope.is_approved, 'mobile_no': $scope.mobile_no, 'video_url': $scope.video_url, 'photo_src': {'photo_src': photo_src}}
            var successMsg = "Testimonial updated successfully.";
           }    
            photo_src.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            photo_src.upload.then(function (response) {
            
                $timeout(function () {
                    if (!response.data.success) {
                        var obj = response.data.message;
                       // var arr = Object.keys(obj).map(function (k) {
                       //    return obj[k];
                      //  });
                       
                        //var err = [];
                     //   var j = 0;
                       // for (var i = 0; i < arr.length; i++) {
                        //    err.push(arr[j++].toString());
                        //}
                       // $scope.errorMsg = err;
                    } else
                    {
                        photo_src.result = response.data;
                    }
                }); 
            }, function (response) {
                if (response.status !== 200) {
                    $scope.errorMsg = "Something went wrong. Check your internet connection";
                }
            }, function (evt, response) {
                //employeePhoto.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }

        $scope.getTestimonialData = function (testimonial_id) {
            Data.post('testimonials-approve/getTestimonialData',{'testimonial_id':testimonial_id}).then(function (response) {
                $scope.testimonialsData = response.records;
                $scope.company_name = $scope.testimonialsData.company_name;
                $scope.person_name = $scope.testimonialsData.person_name;
                $scope.video_url = $scope.testimonialsData.video_url;
                $scope.mobile_no = $scope.testimonialsData.mobile_no;
                $scope.testimonial = $scope.testimonialsData.testimonial;
                $scope.is_shown = $scope.testimonialsData.is_shown;
                $scope.testimonial_id = testimonial_id;
            });
        };

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

    }]);
