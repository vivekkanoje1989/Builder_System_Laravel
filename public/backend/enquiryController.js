app.controller('enquiryController', ['$scope', '$state', 'Data', 'Upload', '$timeout', 'toaster', '$stateParams', '$filter', function ($scope, $state, Data, Upload, $timeout, toaster, $stateParams, $filter) {
        $scope.projectsDetails = [];
        $scope.locations = [];
        $scope.searchData = {};
        $scope.currentPage = $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.historyList = {};

        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };

        $scope.sms = function (){
            $scope.divSms = true;
            $scope.divEmail = false;
            $scope.divText = false;
        }
        $scope.email = function (){
            $scope.divSms = false;
            $scope.divEmail = true;
            $scope.divText = false;
        }
        $scope.text = function (){
            $scope.divSms = false;
            $scope.divEmail = false;
            $scope.divText = true;
        }
        
//        $scope.saveEnquiryData = function (enquiryData)
//        {
//            Data.post('master-sales/saveEnquiryData', {
//                enquiryData: enquiryData, customer_id: $scope.customer_id, projectEnquiryDetails: $scope.projectsDetails,
//            }).then(function (response) {
//                toaster.pop('success', 'Enquiry', 'Enquiry successfully created');
//                $scope.disableFinishButton = true;
//            });
//        }
//        $scope.addProjectRow = function (id)
//        {
//            if (typeof $scope.enquiryData.project_id !== 'undefined' && typeof $scope.enquiryData.block_id !== 'undefined' && typeof $scope.enquiryData.sub_block_id !== 'undefined')
//            {
//                var totalSubBlocks = $scope.enquiryData.sub_block_id.length;
//                var totalBlocks = $scope.enquiryData.block_id.length;
//                $scope.subblockname = [];
//                $scope.sub_block_id = [];
//                $scope.blockname = [];
//                $scope.block_id = [];
//                for (var i = 0; i < totalSubBlocks; i++)
//                {
//                    $scope.subblockname.push($scope.enquiryData.sub_block_id[i].block_sub_type);
//                    $scope.sub_block_id.push($scope.enquiryData.sub_block_id[i].id);
//                }
//                for (var j = 0; j < totalBlocks; j++)
//                {
//
//                    $scope.blockname.push($scope.enquiryData.block_id[j].block_name);
//                    $scope.block_id.push($scope.enquiryData.block_id[j].id);
//                }
//                $scope.projectsDetails.push({
//                    'project_id': $scope.enquiryData.project_id.split('_')[0],
//                    'project_name': $scope.enquiryData.project_id.split('_')[1],
//                    'blocks': $scope.blockname.toString(),
//                    'block_id': $scope.block_id.toString(),
//                    'sub_block_id': $scope.sub_block_id.toString(),
//                    'subblocks': $scope.subblockname.toString(),
//                });
//                $("#projectBody").hide();
//                $scope.enquiryData.block_id = {};
//                $scope.enquiryData.sub_block_id = {};
//                $scope.enquiryData.project_id = '';
//            } else
//            {
//                alert("Please select all project details");
//            }
//        }
//
//        $scope.removeRow = function (id) {
//            var index = -1;
//            var comArr = eval($scope.projectsDetails);
//            for (var i = 0; i < comArr.length; i++) {
//                if (comArr[i].name === id) {
//                    index = i;
//                    break;
//                }
//            }
//            if (index === -1) {
//                alert("Something gone wrong");
//            }
//            $scope.projectsDetails.splice(index, 1);
//        }
//        $scope.changeLocations = function (cityId)
//        {
//            Data.post('master-sales/getAllLocations', {
//                city_id: cityId,
//            }).then(function (response) {
//                $scope.enquiryData.enquiry_locations = [];
//                $scope.locations = response.records;
//            });
//        }
//        $scope.initHistoryDataModal = function (enquiry_id) {
//            Data.post('master-sales/getEnquiryHistory', {
//                enquiryId: enquiry_id,
//            }).then(function (response) {
//                if (response.success) {
//                    $scope.historyList = angular.copy(response.records);
//                }
//            });
//        }
        
        /****************************ENQUIRIES****************************/
        $scope.getTotalEnquiries = function ()
        {
            Data.post('master-sales/getTotalEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getLostEnquiries = function ()
        {
            Data.post('master-sales/getLostEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getClosedEnquiries = function ()
        {
            Data.post('master-sales/getClosedEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        /****************************ENQUIRIES****************************/
        
        /****************************FOLLOWUPS****************************/
        $scope.showTodaysFollowups = function ()
        {
            Data.post('master-sales/getTodaysFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.showPendingsFollowups = function ()
        {
            Data.post('master-sales/getPendingFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.showPreviousFollowups = function ()
        {
            Data.post('master-sales/getPreviousFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        /****************************FOLLOWUPS****************************/
        
        /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
        $scope.getTeamTotalEnquiries = function ()
        {
            Data.post('master-sales/getTeamTotalEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getTeamLostEnquiries = function ()
        {
            Data.post('master-sales/getTeamLostEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getTeamClosedEnquiries = function ()
        {
            Data.post('master-sales/getTeamClosedEnquiries').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getTeamTodayFollowups = function ()
        {
            Data.post('master-sales/getTeamTodayFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getTeamPendingFollowups = function ()
        {
            Data.post('master-sales/getTeamPendingFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        $scope.getTeamPreviousFollowups = function ()
        {
            Data.post('master-sales/getTeamPreviousFollowups').then(function (response) {
                $scope.listsIndex = response;
            });
        }
        /*********************TEAM ENQUIRIES & FOLLOWUPS*********************/
        
        $scope.updateEnquiryDetails = function (mobNo, email)
        {
            $state.go(getUrl + '.salesCreate', {"mobNo": mobNo, "email": email});
            $scope.searchData.searchWithMobile = mobNo;
            $scope.searchData.searchWithEmail = email;
        }
    }]);

app.controller('getEmployeesCtrl', function ($scope, Data) {
    Data.get('master-sales/getEmployees').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.employeeList = response.records;
        }
    });
});
app.controller('financeEmployees', function ($scope, Data) {
    Data.get('master-sales/getFinanceEmployees').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.financeEmpList = response.records;
        }
    });
});
app.controller('agencyTieupCtrl', function ($scope, Data) {
    Data.get('getFinanceTieupAgency').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.agencyTieupList = response.records;
        }
    });
});
app.controller('enquiryCityCtrl', function ($scope, Data) {
    Data.get('master-sales/getEnquiryCity').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.cityList = response.records;
        }
    });
});