app.controller('testimonialsCtrl', ['$scope', 'Data', 'Upload', 'toaster', '$parse', '$state', '$modal', function ($scope, Data, Upload, toaster, $parse, $state, $modal) {

        $scope.itemsPerPage = 30;
        $scope.noOfRows = 1;
        $scope.testimonial_id = 0;
        $scope.testimonialsBtn = false;
        $scope.testimonial = [];
        $scope.testimonial.approve_status = $scope.testimonial.web_status = '1';
        $scope.testimonials = function () {
            $scope.showloader();
            Data.post('testimonials/getDisapproveList').then(function (response) {
                if (response.success) {
                    $scope.ApprovedTestimonialsRow = response.records;
                    $scope.exportData = response.exportData;
                    $scope.deleteDisApprove = response.deleteDisApprove;
                    $scope.hideloader();
                } else {
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
            });
        };
        $scope.checkMobileValue = function () {
            if (typeof $scope.testimonial.mobile_number === 'undefined' || $scope.testimonial.mobile_number === '') {
                $scope.mobileNoErr = false;
            } else {
                var regMobile = /^[789]/;
                if (!regMobile.test($scope.testimonial.mobile_number)) {
                    $scope.mobileNoErr = true;
                } else {
                    $scope.mobileNoErr = "";
                    $scope.mobileNoErr = false;
                }
            }
        }
        $scope.checkMobileValue1 = function () {
            if (typeof $scope.testimonial.mobile_number === 'undefined' || $scope.testimonial.mobile_number === '') {
                $scope.mobileNoErr = false;
            } else {
                var regMobile = /^[789]/;
                if (!regMobile.test($scope.testimonial.mobile_number)) {
                    $scope.mobileNoErr = true;
                } else {
                    $scope.mobileNoErr = "";
                    $scope.mobileNoErr = false;
                }
            }
        }
        $scope.showHelpManageTestimonial = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Manage Testimonials</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }
        $scope.showHelpApproveTestimonial = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Approve Testimonials</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }

        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.searchDetails = {};
        $scope.searchData = {};
        $scope.filterDetails = function (search) {
            $scope.searchData = search;
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }


        $scope.manageTestimonials = function () {
            $scope.showloader();
            Data.post('testimonials/getApprovedList').then(function (response) {
                if (response.success) {
                    $scope.ApprovedTestimonialsRow = response.records;
                    $scope.exportDetails = response.exportData;
                    $scope.deleteApprove = response.deleteApprove;
                    $scope.hideloader();
                } else {
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }

            });
        }

        $scope.deleteDisApprovedList = function (id, index) {
            Data.post('testimonials/deleteDisApprovedList', {
                'testimonial_id': id}).then(function (response) {
//                toaster.pop('success', 'Testimonials', 'Testimonial deleted successfully');
                $scope.ApprovedTestimonialsRow.splice(index, 1);
            });
        }

        $scope.deleteApprovedList = function (id, index) {
            Data.post('testimonials/deleteApprovedList', {
                'testimonial_id': id}).then(function (response) {
//                toaster.pop('success', 'Testimonials', 'Testimonial deleted successfully');
                $scope.ApprovedTestimonialsRow.splice(index, 1);
            });
        }

        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteApprovedList(args['id'], args['index']);

        });
        $scope.$on("deleteItems", function (event, args) {
            $scope.deleteDisApprovedList(args['id'], args['index']);
        });

        $scope.manageTestimonialDisapproveExportToExcel = function () {
            $scope.getexcel = window.location = "/testimonials/manageTestimonialDisapproveExportToExcel";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting');
            } else {
                toaster.pop('error', '', 'Exporting fails');
            }
        }


        $scope.manageTestimonialApproveExportToExcel = function () {
            $scope.getexcel = window.location = "/testimonials/manageTestimonialApproveExportToExcel";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting');
            } else {
                toaster.pop('error', '', 'Exporting fails');
            }
        }


        $scope.doTestimonialsAction = function (photo_url, testimonial) {
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
                var data = {_method: 'PUT', 'testimonial_id': $scope.testimonial_id, 'testimonial': testimonial, 'photo_url': photo_url
                }
            }

            photo_url.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            });
            photo_url.upload.then(function (response) {
                if (response.data.success) {
                    $scope.testimonialsBtn = false;
                    if ($scope.testimonial_id == 0) {
                        toaster.pop('success', 'Testimonials', 'Record successfully created');
                        if (response.data.records.approve_status == '1') {
                            $state.go('testimonialsManage');
                        } else {
                            $state.go('testimonialsIndex');
                        }
                    } else {
                        toaster.pop('success', 'Testimonials', 'Record successfully updated');
                        if (response.data.records.approve_status == '1') {
                            $state.go('testimonialsManage');
                        } else {
                            $state.go('testimonialsIndex');
                        }
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
            }, function (response) {
                $scope.testimonialsBtn = false;
                if (response.status !== 200) {
                    $scope.errMsg = "Please Select image for upload";
                }
            });
        }
        $scope.getTestimonialData = function (testimonial_id) {
            $scope.showloader();
            Data.post('testimonials/getTestimonialData', {'testimonial_id': testimonial_id}).then(function (response) {
                $scope.testimonial = response.records;
                $scope.testimonial_id = testimonial_id;
                $scope.hideloader();
            });
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
    }]);
