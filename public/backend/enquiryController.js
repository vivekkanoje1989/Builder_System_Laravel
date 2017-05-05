app.controller('enquiryController', ['$scope', '$state', 'Data', 'Upload', '$timeout', 'toaster', '$stateParams', function ($scope, $state, Data, Upload, $timeout, toaster, $stateParams) {
        $scope.projectsDetails = [];
        $scope.locations = [];
        $scope.currentPage = $scope.itemsPerPage = 4;
        $scope.noOfRows = 1;
        $scope.historyList = {};
        $scope.saveEnquiryData = function (enquiryData, customer_id)
        {
            console.log($scope.enquiryData);
            Data.post('master-sales/saveEnquiryData', {
                enquiryData: enquiryData, customer_id: customer_id, projectEnquiryDetails: $scope.projectsDetails,
            }).then(function (response) {
                //console.log(response);
            });
        }

//        (enquiries[0].customer_id)
        $scope.addProjectRow = function (id)
        {
            if (typeof $scope.enquiryData.project_id !== 'undefined' && typeof $scope.enquiryData.block_id !== 'undefined' && typeof $scope.enquiryData.sub_block_id !== 'undefined')
            {
                var totalSubBlocks = $scope.enquiryData.sub_block_id.length;
                var totalBlocks = $scope.enquiryData.block_id.length;
                $scope.subblockname = [];
                $scope.sub_block_id = [];
                $scope.blockname = [];
                $scope.block_id = [];
                for (var i = 0; i < totalSubBlocks; i++)
                {
                    $scope.subblockname.push($scope.enquiryData.sub_block_id[i].block_sub_type);
                    $scope.sub_block_id.push($scope.enquiryData.sub_block_id[i].id);
                }
                for (var j = 0; j < totalBlocks; j++)
                {

                    $scope.blockname.push($scope.enquiryData.block_id[j].block_name);
                    $scope.block_id.push($scope.enquiryData.block_id[j].id);
                }
                $scope.projectsDetails.push({
                    'project_id': $scope.enquiryData.project_id.split('_')[0],
                    'project_name': $scope.enquiryData.project_id.split('_')[1],
                    'blocks': $scope.blockname.toString(),
                    'block_id': $scope.block_id.toString(),
                    'sub_block_id': $scope.sub_block_id.toString(),
                    'subblocks': $scope.subblockname.toString(),
                });
                $("#projectBody").hide();
                $scope.enquiryData.block_id = {};
                $scope.enquiryData.sub_block_id = {};
                $scope.enquiryData.project_id = '';
            } else
            {
                alert("Please select all project details");
            }
        }

        $scope.removeRow = function (id) {
            var index = -1;
            var comArr = eval($scope.projectsDetails);
            for (var i = 0; i < comArr.length; i++) {
                if (comArr[i].name === id) {
                    index = i;
                    break;
                }
            }
            if (index === -1) {
                alert("Something gone wrong");
            }
            $scope.projectsDetails.splice(index, 1);
        }
        $scope.changeLocations = function (cityId)
        {
            Data.post('master-sales/getAllLocations', {
                city_id: cityId,
            }).then(function (response) {
                $scope.enquiryData.enquiry_locations = [];
                $scope.locations = response.records;
            });
        }
        $scope.showAllEnquiries = function ()
        {
            Data.get('master-sales/getAllEnquiries').then(function (response) {
                if (response.success) {
                    $scope.listsIndex = response;
                } else {
                    document.getElementById("tblTotalEnquiry").innerHTML = response.CustomerEnquiryDetails;
                }
            });
        }
        $scope.showallLostEnquiries = function ()
        {
            Data.get('master-sales/getLostEnquiries').then(function (response) {
                if (response.success)
                {
                    $scope.listsIndex = response;
                } else
                {
                    document.getElementById("tblTotalEnquiry").innerHTML = response.CustomerEnquiryDetails;
                }
            });
        }
        $scope.showallCloseEnquiries = function ()
        {
            Data.get('master-sales/getCloseEnquiries').then(function (response) {
                if (response.success)
                {
                    $scope.listsIndex = response;
                } else
                {
                    document.getElementById("tblTotalEnquiry").innerHTML = response.CustomerEnquiryDetails;
                }
            });
        }
        $scope.customerDetails = function (mobNo)
        {
            alert("hi" + mobNo);
            $state.go(getUrl + '.salesCreate');
            alert($scope.searchData.searchWithMobile);
            //$scope.searchData.searchWithMobile = mobNo;
        }

        $scope.initHistoryDataModal = function (enquiry_id) {
           // alert("hii i am here !!!!!!"+enquiry_id);
            //alert($scope.historyList);
            Data.post('master-sales/getEnquiryHistory', {
                enquiryId: enquiry_id,
            }).then(function (response) {
                if (response.success) {
                    $scope.historyList = angular.copy(response.records);                    
                }
            });            
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