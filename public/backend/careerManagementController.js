app.controller('careerCtrl', ['$scope', 'Data', '$rootScope', '$timeout', '$state', function ($scope, Data, $rootScope, $timeout, $state) {

        $scope.display_portal = 1;
        $scope.id = 0;
        $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.manageCareers = function () {
            Data.get('manage-job/manageCareers').then(function (response) {
                $scope.careerRow = response.records;

            });
        };
        $scope.getCareer = function (id) {
            Data.post('manage-job/getCareer', {
                'id': id}).then(function (response) {

                $scope.job_eligibility = response.records.job_eligibility;
                $scope.job_title = response.records.job_title;
                $scope.job_locations = response.records.job_locations;
                $scope.job_responsibilities = response.records.job_responsibilities;
                $scope.job_role = response.records.job_role;
                $scope.model.application_start_date = response.records.application_start_date;
                $scope.model.application_close_date = response.records.application_close_date;
                $scope.number_of_positions = response.records.number_of_positions;
                $scope.id = id;
            });
        }
        $scope.deleteJob = function (id, index) {

            Data.post('manage-job/deleteJob', {
                'id': id}).then(function (response) {
                console.log(response);
                $scope.careerRow.splice(index, 1);
            });
        }
        $scope.model = {application_start_date: new Date(), application_close_date: new Date()};

        $scope.format = 'DD.MM.YYYY';
        $scope.dojobPostingAction = function () {

            $scope.errorMsg = '';
            if ($scope.id === 0) //for create
            {
                Data.post('manage-job/', {
                    job_title: $scope.job_title, job_eligibility: $scope.job_eligibility, job_locations: $scope.job_locations, job_role: $scope.job_role, application_start_date: $scope.model.application_start_date, application_close_date: $scope.model.application_close_date, number_of_positions: $scope.number_of_positions, job_responsibilities: $scope.job_responsibilities}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $state.go(getUrl + '.manageJobIndex');
                    }
                });
            } else { //for update

                Data.put('manage-job/' + $scope.id, {
                    job_title: $scope.job_title, job_eligibility: $scope.job_eligibility, job_locations: $scope.job_locations, job_role: $scope.job_role, application_start_date: $scope.model.application_start_date, application_close_date: $scope.model.app_closing_date, number_of_positions: $scope.number_of_positions, job_responsibilities: $scope.job_responsibilities}).then(function (response) {

                    console.log(response);
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
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
        $scope.success = function (message) {
            Flash.create('success', message);
        };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };


    }]);