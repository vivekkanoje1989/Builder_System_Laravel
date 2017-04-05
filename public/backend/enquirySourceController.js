app.controller('enquirysourceCtrl', ['$scope', 'Data', '$rootScope','$timeout', function ($scope, Data, $rootScope,$timeout) {

        $scope.manageEnquirySource = function () {
            Data.post('enquiry-source/manageEnquirySource').then(function (response) {
                $scope.EnquirySourceRow = response.records;
            });
        };

        $scope.getSubSource = function (source_id) {
            Data.post('enquiry-source/manageSubEnquirySource', {"source_id": source_id}).then(function (response) {

                $scope.SubEnquirySourceRow = response.records;
            });
        }
        $scope.sourceinitialModal = function () {

            $scope.heading = 'Source';

        }
        $scope.initialModal = function (id, source_id, subsource, index) {

            $scope.heading = 'Sub Sources';
            $scope.subid = id;
            $scope.source_id = source_id;
            $scope.sub_source = subsource;
            $scope.index = index;
        }

        $scope.dosourceAction = function () {
            $scope.errorMsg = '';

            Data.post('enquiry-source/', {
                source_name: $scope.source_name}).then(function (response) {

                if (!response.success)
                {
                    $scope.errorMsg = response.errormsg;
                } else {
                    $('#sourceModal').modal('toggle');
                    $scope.EnquirySourceRow.push({'source_name': $scope.source_name, 'id': $scope.EnquirySourceRow.length + 1});
                     //$scope.success("Source details created successfully"); 

                }
            });
        }
        $scope.dosubsourceAction = function () {
            $scope.errorMsg = '';
            if ($scope.subid === 0) //for create
            {
                Data.post('enquiry-source/createSubEnquirySource',{
                    sub_source: $scope.sub_source, source_id: $scope.source_id}).then(function (response) {

                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $('#subsourceModal').modal('toggle');
                        $scope.SubEnquirySourceRow.push({'sub_source': $scope.sub_source, 'id': $scope.SubEnquirySourceRow.length + 1});
                       // $scope.success("Sub source details created successfully"); 

                    }
                });
            } else { //for update

                Data.post('enquiry-source/updateSubEnquirySource', {
                    sub_source: $scope.sub_source, source_id: $scope.source_id, id: $scope.subid}).then(function (response) {
                    if (!response.success)
                    {
                        $scope.errorMsg = response.errormsg;
                    } else {
                        $scope.SubEnquirySourceRow.splice($scope.index, 1);
                        $scope.SubEnquirySourceRow.splice($scope.index, 0, {
                            sub_source: $scope.sub_source, id: $scope.subid});
                        $('#subsourceModal').modal('toggle');
                         //$scope.success("Sub source details updated successfully"); 
                    }
                });
            }
        }
        $scope.success = function(message) {
               Flash.create('success', message);
           };
        $scope.pageChangeHandler = function (num) {
            $scope.noOfRows = num;
            $scope.currentPage = num * $scope.itemsPerPage;
        };
        
    }]);
