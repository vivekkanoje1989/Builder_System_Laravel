app.controller('enquiryController', ['$scope', '$state', 'Data', 'Upload', '$timeout', 'toaster', '$stateParams', function ($scope, $state, Data, Upload, $timeout, toaster, $stateParams) {
        $scope.projectsDetails = [];
        $scope.saveEnquiryData = function (enquiryData, customer_id)
        {
            Data.post('master-sales/saveEnquiryData', {
                enquiryData: enquiryData, customer_id: customer_id, projectEnquiryDetails: $scope.projectsDetails,
            }).then(function (response) {
                //console.log(response);
            });
        }

        $scope.addProjectRow = function (id)
        {
            console.log($scope.projectsDetails);
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

        $scope.removeRow = function(name){				
		var index = -1;		
		var comArr = eval( $scope.projectsDetails );
		for(var i = 0; i < comArr.length; i++ ) {
			if( comArr[i].name === name ) {
				index = i;
				break;
			}
		}
		if( index === -1 ) {
			alert("Something gone wrong" );
		}
		$scope.projectsDetails.splice( index, 1 );		
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