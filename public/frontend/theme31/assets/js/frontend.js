var app = angular.module('app', ['ngMessages', 'ngFileUpload']);

var getUrl = 'website';

app.controller('webAppController', ['$scope', 'Data', 'Upload', '$timeout', function ($scope, Data, Upload, $timeout) {

        $scope.submitted = true;
       $scope.empl = true;
        $scope.getPostsDropdown = function () {
            Data.get('../jobPost').then(function (response) {
                $scope.jobPostRow = response.result;
            });
        };


        $scope.getProjects = function () {
            Data.get('../getCurrentProjectDetails').then(function (response) {
                $scope.current = response.current;
            });
        };

        $scope.getProjectsAllProjects = function () {
            Data.get('../getProjectsAllProjects').then(function (response) {
                $scope.current = response.current;
                console.log($scope.current);
            });
        };


        $scope.getBackGroundImages = function ()
        {

            Data.get('../background').then(function (response) {
                $scope.backgroundImages = response.result.banner_images.split(',');
            });
        }

        $scope.getAboutPageContent = function ()
        {
            Data.get('../getAboutPageContent').then(function (response) {
                $scope.aboutUs = response.result;
                $scope.banner_images = $scope.aboutUs.banner_images.split(',');
            });
        }

        $scope.getEmployees = function()
        {
            Data.get('../getEmployees').then(function (response) {
                console.log(response.records);
                   $scope.employee = response.records;
            });
        }

        $scope.getContactDetails = function ()
        {
            Data.get('../getContactDetails').then(function (response) {
                $scope.contacts = response.result;
            });
        }

        $scope.doContactAction = function (contact) {
            var v = grecaptcha.getResponse();
            if (v.length != '0') {

            }
        }
        $scope.doApplicantAction = function (career, resumeFileName, photoUrl)
        {
            var v = grecaptcha.getResponse();
            if (v.length != '0') {
                var url = 'register_applicant';
                var data = {'career': career, 'resumeFileName': resumeFileName, 'photoUrl': photoUrl, '_token': $scope._token};
                resumeFileName.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                });
                resumeFileName.upload.then(function (response) {
                    $timeout(function () {
                        $scope.career = {};
                        $scope.careerForm.$setPristine();
                        $scope.submitted = false;
                        grecaptcha.reset();
                    });
                }, function (response) {
                    if (response.status !== 200) {
                        $scope.err_msg = "Please Select image for upload";
                    }
                });
            } else {
                $scope.recaptcha = "Please revalidate captcha";
            }
        }
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

app.directive('validFile', function () {
    return {
        require: 'ngModel',
        link: function (scope, el, attrs, ngModel) {
            ngModel.$render = function () {
                ngModel.$setViewValue(el.val());
            };

            el.bind('change', function () {
                scope.$apply(function () {
                    ngModel.$render();
                });
            });
        }
    };
});

app.filter('htmlToPlaintext', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
}
);