app.controller('careerCtrl', ['$scope', 'Data', '$rootScope', '$timeout', '$state', 'toaster', '$parse', '$modal', function ($scope, Data, $rootScope, $timeout, $state, toaster, $parse, $modal) {

        $scope.display_portal = 1;
        $scope.id = 0;
        $scope.itemsPerPage = 30;
        $scope.editjob = false;
        $scope.createJob = false;
        $scope.noOfRows = 1;
        $scope.career = {};
        $scope.manageCareers = function () {
            Data.post('manage-job/manageCareers').then(function (response) {
                if (response.success) {
                    $scope.careerRow = response.records;
                    $scope.exportData = response.exportData;
                    $scope.deleteBtn = response.delete;
                } else {
                    $scope.hideloader();
                    $scope.totalCount = 0;
                    $scope.disableBtn = true;
                }
            });
        };


        $scope.orderByField = function (keyname) {
            $scope.sortKey = keyname;
            $scope.reverseSort = !$scope.reverseSort;
        }

        $scope.clearToDate = function ()
        {
            $scope.career.application_close_date = '';
        }
        $scope.getCareer = function (id) {
            Data.post('manage-job/getCareer', {
                'id': id}).then(function (response) {
                $scope.career.job_eligibility = response.records.job_eligibility;
                $scope.career.job_title = response.records.job_title;
                $scope.career.job_locations = response.records.job_locations;
                $scope.career.job_responsibilities = response.records.job_responsibilities;
                $scope.career.job_role = response.records.job_role;
                $scope.career.application_start_date = response.records.application_start_date;
                $scope.career.application_close_date = response.records.application_close_date;
                $scope.career.number_of_positions = response.records.number_of_positions;
                $scope.id = id;
            });
        };

        $scope.jobPostingExportToxls = function () {
            $scope.getexcel = window.location = "/manage-job/jobPostingExportToxls";
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        }

        $scope.showHelpManageCareer = function () {
            $scope.optionModal = $modal.open({
                template: '<div class="modal-header" ng-mouseleave="close()"><h3 class="modal-title" style="text-align:center;">Welcome to the BMS Help Center<i class="fa fa-close" style="float:right; color: #ccc;" ng-click="closeModal()"></i></h3></div><div class="modal-body">Manage Careers</div><div class="modal-footer"> <button ng-click="closeModal()" class="btn btn-primary" style="float:right;">Close</button></div>',
                controller: [
                    '$scope', '$modalInstance', function ($scope, $modalInstance) {
                        $scope.closeModal = function () {
                            $modalInstance.dismiss();
                        };
                    }
                ]
            });
        }
        $scope.jobPostingApplicationExportToxls = function () {
            $scope.getexcel = window.location = "/manage-job/jobPostingApplicationExportToxls/" + $scope.careerId;
            if ($scope.getexcel) {
                toaster.pop('info', '', 'Exporting....');
            } else {
                toaster.pop('error', '', 'Exporting fails....');
            }
        };

        $scope.searchDetails = {};
        $scope.searchData = {};

        $scope.filterDetails = function (search) {
            if (search.application_start_date != undefined) {
                var today = new Date(search.application_start_date);
                var day = today.getDate().toString();
                if (day.length > 1) {
                    search.application_start_date = (today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + today.getDate());
                } else {
                    search.application_start_date = (today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-0' + today.getDate());
                }
            }

            if (search.application_close_date != undefined) {
                var loginDate = new Date(search.application_close_date);
                var day = loginDate.getDate().toString();
                if (day.length > 1) {
                    search.application_close_date = (loginDate.getFullYear() + '-' + ("0" + (loginDate.getMonth() + 1)).slice(-2) + '-' + loginDate.getDate());
                } else {
                    search.application_close_date = (loginDate.getFullYear() + '-' + ("0" + (loginDate.getMonth() + 1)).slice(-2) + '-0' + loginDate.getDate());
                }
            }


            $scope.searchData = search;
        }
        $scope.removeFilterData = function (keyvalue) {
            delete $scope.searchData[keyvalue];
            $scope.filterDetails($scope.searchData);
        }
        $scope.closeModal = function () {
            $scope.searchData = {};
        }

        $scope.deleteJob = function (id, index) {
            Data.post('manage-job/deleteJob', {
                'id': id}).then(function (response) {
//                toaster.pop('success', 'Careers', 'Job post deleted successfully');
                $scope.careerRow.splice(index, 1);
            });
        }
        $scope.$on("deleteRecords", function (event, args) {
            $scope.deleteJob(args['id'], args['index']);
        });
        $scope.dojobPostingAction = function (career) {
            $scope.editjob = true;
            $scope.createJob = true;
            var date = new Date(career.application_start_date);
            $scope.applicationStart_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            var date = new Date(career.application_close_date);
            $scope.applicationClose_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-job/', {
                    job_title: career.job_title, job_eligibility: career.job_eligibility, job_locations: career.job_locations, job_role: career.job_role, application_start_date: $scope.applicationStart_date, application_close_date: $scope.applicationClose_date, number_of_positions: career.number_of_positions, job_responsibilities: career.job_responsibilities}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.createJob = false;
                        $scope.errorMsg = response.errormsg;
                        var obj = response.message;
                        var selector = [];
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                            selector.push(key);
                        }
                    } else {

                        toaster.pop('success', 'Careers', 'Job post created successfully');
                        $state.go('manageJobIndex');
                    }
                });
            } else { //for update

                Data.put('manage-job/' + $scope.id, {
                    job_title: career.job_title, job_eligibility: career.job_eligibility, job_locations: career.job_locations, job_role: career.job_role, application_start_date: $scope.applicationStart_date, application_close_date: $scope.applicationClose_date, number_of_positions: career.number_of_positions, job_responsibilities: career.job_responsibilities}).then(function (response) {

                    if (!response.success)
                    {

                        $scope.editjob = false;
                        $scope.errorMsg = response.errormsg;
                        var obj = response.message;
                        var selector = [];
                        for (var key in obj) {
                            var model = $parse(key);// Get the model
                            model.assign($scope, obj[key][0]);// Assigns a value to it
                            selector.push(key);
                        }
                    } else {
                        toaster.pop('success', 'Careers', 'Job post updated successfully');
                        $state.go('manageJobIndex');
                    }
                });
            }
        }
        $scope.viewApplicants = function (id)
        {
            $scope.careerId = id;
            Data.post('manage-job/viewapplicants', {
                'career_id': id}).then(function (response) {
                $scope.viewApplicantsRow = response.records;
                $scope.exportApplicationData = response.exportApplicationData;
            });
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };


    }]);