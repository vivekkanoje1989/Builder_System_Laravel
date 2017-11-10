/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';
var app = angular.module('app', ['ngRoute', 'ngFileUpload']);
angular.module('app').config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {

        $routeProvider.
                when('/', {
                    templateUrl: 'website/index',
                    controller: 'AppCtrl'
                })
                .when('/about', {
                    templateUrl: 'website/about',
                    controller: 'AppCtrl'
                })
                .when('/testimonial', {
                    templateUrl: 'website/testimonial',
                    controller: 'AppCtrl'
                })
                .when('/testimonials', {
                    templateUrl: 'website/testimonials',
                    controller: 'AppCtrl'
                })
                .when('/contact', {
                    templateUrl: 'website/contact',
                    controller: 'AppCtrl'
                })
                .when('/careers', {
                    templateUrl: 'website/careers',
                    controller: 'AppCtrl'
                })
                .when('/blogs', {
                    templateUrl: 'website/blogs',
                    controller: 'AppCtrl'
                })
                .when('/blog-details/:blogId', {
                    templateUrl: function (urlattr) {
                        return 'website/blog-details/' + urlattr.blogId;
                    },
                    controller: 'AppCtrl'
                })
                .when('/news-details/:newsId', {
                    templateUrl: function (urlattr) {
                        return 'website/news-details/' + urlattr.newsId;
                    },
                    controller: 'AppCtrl'
                })
                .when('/event-details/:id', {
                    templateUrl: function (urlattr) {
                        return 'website/event-details/' + urlattr.id;
                    },
                    controller: 'AppCtrl'
                })
                .when('/press-release-details/:Id', {
                    templateUrl: function (urlattr) {
                        return 'website/press-release-details/' + urlattr.Id;
                    },
                    controller: 'AppCtrl'
                })
                .when('/project-details/:projectId', {
                    templateUrl: function (urlattr) {
                        return 'website/project-details/' + urlattr.projectId;
                    },
                    controller: 'AppCtrl'
                })
                .when('/news', {
                    templateUrl: 'website/news',
                    controller: 'AppCtrl'
                })
                .when('/press-release', {
                    templateUrl: 'website/press-release',
                    controller: 'AppCtrl'
                })
                .when('/events', {
                    templateUrl: 'website/events',
                    controller: 'AppCtrl'
                })
                .when('/projects', {
                    templateUrl: 'website/projects',
                    controller: 'AppCtrl'
                })

                .otherwise({
                    redirectTo: '/'
                });
        $locationProvider.html5Mode({enabled: true, requireBase: true});
    }]);
app.controller('AppCtrl', ['$scope', 'Upload', '$timeout', '$http', '$location', '$rootScope', '$window', function ($scope, Upload, $timeout, $http, $location, $rootScope, $window) {
        $scope.submitted = false;
        $scope.empl = true;
        $scope.contact = {};
        $scope.career = {};
        $scope.projectsdata = [];
        //$scope.aminities = $scope.availble = $scope.projects = [];        
        var baseUrl = 'website/';

        $scope.getPostsDropdown = function () {
            $http.get(baseUrl + 'jobPost').then(function (response) {
                $scope.jobPostRow = response.data.result;
            });
        };
        $scope.random = function () {
            return 0.5 - Math.random();
        }
        $scope.selectedbBlogs = function (blogId)
        {
            $scope.blogId = blogId;
        }
        $scope.getProjectDetails = function (id)
        {
            $http.post(baseUrl + 'getProjectDetails', {'id': id}).then(function (response) {
                $scope.aminities = response.aminities;
                $scope.availble = response.data.availble;
                $scope.projects = response.projects;
                $scope.projectsdata = response.result;
                if (response.data.result.project_banner_images != null) {
                    $scope.bannerImgs = response.data.result.project_banner_images.split(',');
                }
                $scope.specification = response.data.result.specification_description;
                $scope.description = response.data.result.brief_description;
                $scope.layout_plan = JSON.parse(response.data.result.layout_plan_images);
                $scope.floor_plan = JSON.parse(response.data.result.floor_plan_images);
                $scope.project_logo = response.data.result.project_logo;
                $scope.location_map_images = response.data.result.location_map_images;
                //$scope.google_map_iframe = response.result.google_map_iframe;
                if (response.data.result.specification_images != 0) {
                    $scope.specification_images = JSON.parse(response.data.result.specification_images);
                }
                if (response.data.result.amenities_images != null) {
                    $scope.amenities_images = response.data.result.amenities_images.split(',');
                }
                $scope.project_address = response.data.result.project_address;
                $scope.email_sending_id = response.data.result.email_sending_id;
                $scope.project_brochure = response.data.result.project_brochure;
                $scope.project_contact_numbers = response.data.result.project_contact_numbers;
                if (response.data.result.amenities_images != null) {
                    $scope.gallery = response.data.result.project_gallery.split(',');

                }
                $scope.projects = response.data.projects;
                $scope.googleMap = response.data.result.google_map_iframe;
                $scope.project_name = response.data.result.project_name;
            });
        }

        $scope.createTestimonials = function (testimonial, photo_url)
        {
            var v = grecaptcha.getResponse();
            if (v.length != '0') {
                var url = baseUrl + 'create_testimonials';
                var data = {'testimonial': testimonial, 'photoUrl': photo_url};
                $("#experienceMessageBtn").attr("disabled", true);
                photo_url.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                });
                photo_url.upload.then(function (response) {
                    if (response.data.status == true) {
                        $scope.submitted = true;
                        $timeout(function () {
                            $scope.submitted = false;
                        }, 3000);

                        $timeout(function () {
                            $scope.testimonial = {};
                            $scope.photo_url = '';
                            $scope.testimonialForm.$setPristine();
//                            $scope.submitted = true;
                            $scope.sbtBtn = false;
                            grecaptcha.reset();
                            $scope.recaptcha = '';
                        });
                    }
                }, function (response) {
                    if (response.status !== 200) {
                        $scope.err_msg = "Please Select image for upload";
                    }
                });
            } else {
                $scope.recaptcha = "Please revalidate captcha";
            }
        }

        $scope.getSubBlock = function (block_id, project_id)
        {
            $http.post(baseUrl + 'getAvailbility', {'block_id': block_id, 'project_id': project_id}).then(function (response) {
                $scope.blockRow = response.result;
            });
        }
        $scope.getMenus = function ()
        {
            $http.get(baseUrl + 'getMenus').then(function (response) {
                $scope.getMenus = response.data.result;
            });
        }
        $scope.getProjects = function () {
            $http.get(baseUrl + 'getCurrentProjectDetails').then(function (response) {
                $scope.current = response.data.current;
            });
        };


        $scope.getemployee = function (empid)
        {
            $http.post('website/getemployeedetails', {
                data: {empId: empid},
            }).then(function (response) {

                if (!response.data.success) {
                    $scope.errorMsg = response.data.message;
                } else {
                    $scope.userData = response.data.records;
                    var current_country = response.data.records.current_country_id;
                    var current_state = response.data.records.current_state_id;
                    $scope.userData.permenent_city_id = "";
                    $scope.userData.permenent_country_id = "";
                    $scope.userData.permenent_pin = "";
                    $scope.userData.permenent_state_id = "";
                    $scope.userData.current_city_id = "";
                    $scope.userData.current_country_id = "";
                    $scope.userData.current_pin = "";
                    $scope.userData.current_state_id = "";
                    $scope.userData.highest_education_id = "";
                    $scope.userData.gender_id = "";
                    $scope.userData.marital_status = "";
                    $scope.userData.blood_group_id = "";
                    $scope.userData.physic_status = "";
                    $scope.userData.date_of_birth = "";
                    $scope.userData.marriage_date = "";
                    $http.post('website/getfStates', {
                        data: {countryId: current_country},
                    }).then(function (response) {
                        if (!response.data.success) {
                            $scope.errorMsg = response.message;
                        } else {
                            $scope.stateList = response.data.records;
                            $http.post('website/getfCities', {
                                data: {stateId: current_state},
                            }).then(function (response) {
                                if (!response.data.success) {
                                    $scope.errorMsg = response.data.message;
                                } else {
                                    $scope.cityList = response.data.records;
                                    $timeout(function () {
                                        $scope.userData.permenent_state_id = angular.copy($scope.userData.current_state_id);
                                        $scope.userData.permenent_city_id = angular.copy($scope.userData.current_city_id);
                                    }, 500);
                                }
                            });
                        }
                    });
                }
            });
        };


        $scope.updateemployee = function (userdata, empid)
        {
            $scope.isDisabled = true;
            $scope.pls_wait = true;
            if (userdata.date_of_birth != "")
            {
                userdata.date_of_birth = $("#date_of_birth").val();
            }
            if (userdata.marital_status == 2)
            {
                userdata.marriage_date = $("#marriagedate").val();
            } else
            {
                userdata.marriage_date = "";
            }

            if (typeof userdata.employee_photo_file_name == "undefined" || typeof userdata.employee_photo_file_name == "string")
            {
                userdata.employee_photo_is_available = 0;
                userdata.employee_photo_file_name = new File([""], "fileNotSelected", {type: "text/jpg", lastModified: new Date()});
            } else
            {
                userdata.employee_photo_is_available = 1;
            }

            var data = {data: userdata, empId: empid}
            var url = '/website/updateemployeedetails';
            userdata.employee_photo_file_name.upload = Upload.upload({
                url: url,
                headers: {enctype: 'multipart/form-data'},
                data: data
            })

            userdata.employee_photo_file_name.upload.then(function (response) {
                console.log(response);
                $scope.isDisabled = false;
                $scope.pls_wait = false;
                if (response.data.success) {
                    $window.location.href = 'website/thanking-you';
                } else
                {
                    $scope.regerror = "Something went wrong please try again";
                }
            },
                    function (response) {



                    });
        }


        $scope.getTestimonials = function () {

            $http.get(baseUrl + 'getTestimonials').then(function (response) {
                $scope.testimonial = response.data.result;
            });
        };
        $scope.getProjectsAllProjects = function () {
            $http.get(baseUrl + 'getProjectsAllProjects').then(function (response) {
                $scope.current = response.data.current;
                $scope.completed = response.data.completed;
                $scope.upcoming = response.data.upcoming;
            });
        };
        $scope.getBackGroundImages = function ()
        {

            $http.get(baseUrl + 'background').then(function (response) {
                $scope.backgroundImages = response.data.result.banner_images.split(',');
            });
        }
        $scope.getAboutPageContent = function ()
        {
            $http.get(baseUrl + 'getAboutPageContent').then(function (response) {
                $scope.aboutUs = response.data.result;
                if ($scope.aboutUs != null) {
                    $scope.banner_images = $scope.aboutUs.banner_images.split(',');
                }
            });
        }

        $scope.getEmployees = function ()
        {
            $http.get(baseUrl + 'getEmployees').then(function (response) {

                $scope.employee = response.data.records;
            });
        }

        $scope.getContactDetails = function ()
        {
            $http.get(baseUrl + 'getContactDetails').then(function (response) {
                $scope.contacts = response.data.result;
            });
        }
        $scope.cancelProjectDivCurrent = function (projectid) {
            $("#slidingDivcurrent" + projectid).hide();
        }
        $scope.cancelProjectDivCompleted = function (projectid) {
            $("#slidingDivcompleted" + projectid).hide();
        }
        $scope.cancelProjectDivUpcoming = function (projectid) {
            $("#slidingDivupcoming" + projectid).hide();
        }
        $scope.getCareers = function ()
        {
            $http.get(baseUrl + 'getCareers').then(function (response) {
                $scope.careers = response.data.result;
            });
        }

        $scope.getBlogs = function ()
        {
            $http.get(baseUrl + 'getBlogs').then(function (response) {
                $scope.blogs = response.data.records;
            });
        }

        $scope.getBlogDetails = function (blog_id)
        {
            $http.post(baseUrl + 'getBlogDetails', {'blog_id': blog_id}).then(function (response) {
                $scope.blogDetail = response.data.result;
                $scope.blog_images = $scope.blogDetail.blog_images.split(',');
            });
        }

        $scope.getNews = function ()
        {
            $http.get(baseUrl + 'getNews').then(function (response) {
                $scope.news = response.data.result;
            });
        }

        $scope.getNewsDetails = function (news_id)
        {
            $http.post(baseUrl + 'getNewsDetails', {'news_id': news_id}).then(function (response) {
                $scope.newsDetail = response.data.result;
                $scope.news_images = $scope.newsDetail.news_images.split(',');
            });
        }


        $scope.getpressRelease = function ()
        {
            $http.get(baseUrl + 'getpressRelease').then(function (response) {
                $scope.pressRelease = response.data.result;
            });
        }

        $scope.getpressReleaseDetails = function (id)
        {
            $http.post(baseUrl + 'getpressReleaseDetails', {'id': id}).then(function (response) {
                $scope.pressReleaseDetails = response.data.result;

                $scope.images = JSON.parse($scope.pressReleaseDetails.images);

            });
        }

        $scope.getEvents = function ()
        {
            $http.get(baseUrl + 'getEvents').then(function (response) {
                $scope.events = response.data.result;
            });
        }

        $scope.getEventDetails = function (id)
        {
            $http.post(baseUrl + 'getEventDetails', {'id': id}).then(function (response) {
                $scope.eventDetails = response.data.result;
                $scope.images = JSON.parse($scope.eventDetails.gallery);

            });
        }

        $scope.select = function (id) {
            $scope.selected = id;
        };

        $scope.isActive = function (id) {
            return $scope.selected === id;
        };



        $scope.getTestimonialDetails = function (id)
        {
            $http.post(baseUrl + 'getTestimonialDetails', {'testimonial_id': id}).then(function (response) {
                $scope.testimonialDetails = response.data.result;
            });
        }
        $scope.doContactAction = function (contact) {

            $http.post(baseUrl + 'addContact',
                    {contactData: contact}).then(function (response) {
                if (response.data.status == true) {
                    $scope.submitted = true;
                    $timeout(function () {
                        $scope.submitted = false;
                    }, 3000);

                    $timeout(function () {
                        $scope.contact = {};
                        $scope.contactForm.$setPristine();
                        $scope.sbtBtn = false;
                    });
                }
            }, function (response) {
                if (response.status !== 200) {
                    $scope.err_msg = "Please Select image for upload";
                }
            });
        }
        $scope.doApplicantAction = function (career, resumeFileName, photoUrl)
        {

            var v = grecaptcha.getResponse();
            if (v.length != '0') {
                var url = baseUrl + 'register_applicant';
                var data = {'career': career, 'resumeFileName': resumeFileName, 'photoUrl': photoUrl};
                resumeFileName.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                });
                resumeFileName.upload.then(function (response) {
                    if (response.data.status == true) {
                        $scope.submitted = true;
                        $timeout(function () {
                            $scope.submitted = false;
                        }, 3000);

                        $timeout(function () {
                            $scope.career = {};
                            $scope.careerForm.$setPristine();
                            grecaptcha.reset();
                            $scope.sbtBtn = false;
                            $scope.recaptcha = '';
//                        $scope.loginAlertMessage = true;
                        });
                    }
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
                } else {
                    $(".imageFile").val("");
                    $scope.invalidImage = "Invalid file format. File type should be jpg or jpeg or png or bmp format only.";
                    $scope.frmRegistration.$valid = false;
                }
            }
        };

        // uma
        $scope.scrollTo = function (id) {
            $timeout(function () {
                $location.hash(id);
                $anchorScroll();
            });
        }
    }]);



app.controller('titleCtrl', function ($scope, $http) {
    $http.get('website/getfTitle').then(function (response) {
        if (!response.data.success) {
            $scope.errorMsg = response.data.message;
        } else {
            $scope.titles = response.data.records;
        }
    });
});

app.controller('genderCtrl', function ($scope, $http) {
    $http.get('website/getfGender').then(function (response) {
        if (!response.data.success) {
            $scope.errorMsg = response.data.message;
        } else {
            $scope.genders = response.data.records;
        }
    });
});

app.controller('bloodGroupCtrl', function ($scope, $http) {
    $http.get('website/getfBloodGroup').then(function (response) {
        if (!response.data.success) {
            $scope.errorMsg = response.data.message;
        } else {
            $scope.bloodGroups = response.data.records;
        }
    });
});


app.controller('educationListCtrl', function ($scope, $http) {
    $http.get('website/getfEducationList').then(function (response) {
        if (!response.data.success) {
            $scope.errorMsg = response.data.message;
        } else {
            $scope.educationList = response.data.records;
        }
    });
});


app.controller('currentCountryListCtrl', function ($scope, $http) {

    $http.get('website/getfCountries').then(function (response) {
        if (!response.data.success) {
            $scope.errorMsg = response.data.message;
        } else {
            $scope.countryList = response.data.records;
        }
    });
    $scope.onCountryChange = function () {//for state list
        $scope.stateList = "";
        $http.post('website/getfStates', {
            data: {countryId: $("#current_country_id").val()},
        }).then(function (response) {
            if (!response.data.success) {
                $scope.errorMsg = response.data.message;
            } else {
                $scope.stateList = response.data.records;
            }
        });
    };
    $scope.onStateChange = function () {//for city list
        $scope.cityList = "";
        $http.post('website/getfCities', {
            data: {stateId: $("#current_state_id").val()},
        }).then(function (response) {
            if (!response.data.success) {
                $scope.errorMsg = response.data.message;
            } else {
                $scope.cityList = response.data.records;
            }
        });
    };
});



app.controller('permanentCountryListCtrl', function ($scope, $timeout, $http) {
    $http.get('website/getfCountries').then(function (response) {
        if (!response.data.success) {
            $scope.errorMsg = response.data.message;
        } else {
            $scope.countryList = response.data.records;
        }
    });
    $scope.onPCountryChange = function () {
  
        $scope.stateList = "";
        $http.post('website/getfStates', {
            data: {countryId: $scope.userData.permenent_country_id},
        }).then(function (response) {

            if (!response.data.success) {
                $scope.errorMsg = response.data.message;
            } else {
                $scope.stateList = response.data.records;
            }
        });
    };
    $scope.onPStateChange = function () {
        $scope.cityList = "";
        $http.post('website/getfCities', {
            data: {stateId: $scope.userData.permenent_state_id},
        }).then(function (response) {
            if (!response.data.success) {
                $scope.errorMsg = response.data.message;
            } else {
                $scope.cityList = response.data.records;
            }
        });
    };
});


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
});