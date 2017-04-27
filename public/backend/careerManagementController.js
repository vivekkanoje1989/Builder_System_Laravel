app.controller('careerCtrl', ['$scope', 'Data', '$rootScope', '$timeout', '$state', 'toaster', function ($scope, Data, $rootScope, $timeout, $state, toaster) {

        $scope.display_portal = 1;
        $scope.id = 0;
        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.career = {};
        $scope.manageCareers = function () {
            Data.get('manage-job/manageCareers').then(function (response) {
                $scope.careerRow = response.records;
            });
        };
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
        }
        $scope.deleteJob = function (id, index) {
            Data.post('manage-job/deleteJob', {
                'id': id}).then(function (response) {
                toaster.pop('success', 'Careers', 'Job post deleted successfully');
                $scope.careerRow.splice(index, 1);
            });
        }

        $scope.dojobPostingAction = function (career) {
            var date = new Date(career.application_start_date);
            $scope.application_start_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            var date = new Date(career.application_close_date);
            $scope.application_close_date = (date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getDate());
            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-job/', {
                    job_title: career.job_title, job_eligibility: career.job_eligibility, job_locations: career.job_locations, job_role: career.job_role, application_start_date: $scope.application_start_date, application_close_date: $scope.application_close_date, number_of_positions: career.number_of_positions, job_responsibilities: career.job_responsibilities}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        toaster.pop('success', 'Careers', 'Job post created successfully');
                        $state.go(getUrl + '.manageJobIndex');
                    }
                });
            } else { //for update

                Data.put('manage-job/' + $scope.id, {
                    job_title: career.job_title, job_eligibility: career.job_eligibility, job_locations: career.job_locations, job_role: career.job_role, application_start_date: $scope.application_start_date, application_close_date: $scope.app_closing_date, number_of_positions: career.number_of_positions, job_responsibilities: career.job_responsibilities}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        toaster.pop('success', 'Careers', 'Job post updated successfully');
                        $state.go(getUrl + '.manageJobIndex');
                    }
                });
            }
        }
        $scope.viewApplicants = function (id)
        {
            Data.post('manage-job/viewapplicants', {
                'career_id': id}).then(function (response) {
                $scope.viewApplicantsRow = response.records;
            });
        }
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };


    }]);