'use strict';
app.controller('promotionalsmsController',['$scope', 'Data','$filter','Upload','$window','$timeout','$state','$rootScope','toaster', function($scope, Data, $filter,Upload, $window,$timeout,$state,$rootScope,toaster) {
$scope.pageHeading = 'Promotional SMS';
$scope.promotionalsmsData = {};
$scope.btnsend=false;
$scope.itemsPerPage = 30;
$scope.pageNumber = 1;
$scope.smslogslist = [];
$scope.flagForChange = 0;
$scope.filterData = {};
$scope.salesEnqSubCategoryList = [];
$scope.subsalesStatusList = [];
$scope.subSourceList = [];
$scope.teamtype='';
$scope.customertotalcount='0';       

        $scope.pageChanged = function (pageNo,type, functionName,itemsPerPage) { 
           $scope.flagForChange++;
          
          if ($scope.flagForChange == 1){
           if ($scope.filterData && Object.keys($scope.filterData).length > 0) {
              $scope.getFilteredData($scope.filterData, pageNo, $scope.itemsPerPage);
               
           }
            else{
                $scope[functionName](type, pageNo, itemsPerPage);

            }
         }
              $scope.pageNumber = pageNo;
        };
        
               
        
        $scope.sendPromotionalSMS = function (promotionalsmsData,numberFile) {
            $scope.submitted = true;
            $scope.btnsend=true;
           // console.log(numberFile);
            //return false;
                    var url = '/promotionalsms';
                    var data = {promotionalsmsData: promotionalsmsData, numberFile: numberFile};
                    numberFile.upload = Upload.upload({
                        url: url,
                        headers: {enctype: 'multipart/form-data'},
                        data: data
                    }).then(function (response,evt) {
                        toaster.pop('success','Promotional SMS',"SMS Send Successfully");   
                        $timeout(function () {
                            $scope.promotionalsmsData = {};
                            $scope.promotionalsmsData.send_sms_type =1;
                            $scope.promotionalsmsData.sms_type =1;
                            $scope.promotionalsmsData.mobilenumbers="";
                            $scope.customertotalcount='0'; 
                            $scope.step1 = false;
                            $('#totalsms').html(1);
                            $("#totalnumbers").html(0);
                            $('#totalcharacters').html(0);
                            $scope.btnsend=false;
                            $state.go('promotionalsms');
                        });
                    });

        };
  
    
         $scope.getProcName = $scope.type = '';
         
         $scope.procName = function (procedureName,type) {
            $scope.getProcName = angular.copy(procedureName);
            $scope.type=type;
        }
         $scope.getFilteredData = function (filterData, page, noOfRecords) {
              $scope.showloader();
             if (typeof filterData.fromDate !== 'undefined') {
                var fdate = new Date(filterData.fromDate);
                $scope.filterData.fromDate = (fdate.getFullYear() + '-' + ("0" + (fdate.getMonth() + 1)).slice(-2) + '-' + fdate.getDate());
            }  if (typeof filterData.toDate !== 'undefined') {
                var tdate = new Date(filterData.toDate);
                $scope.filterData.toDate = (tdate.getFullYear() + '-' + ("0" + (tdate.getMonth() + 1)).slice(-2) + '-' + tdate.getDate());
            }
            
            
            Data.post('/promotionalsms/getFilterdata', {filterData: filterData, getProcName: $scope.getProcName, pageNumber: page, itemPerPage: noOfRecords, isTeam: $scope.type}).then(function (response) {
              //  console.log(filterData);
                if (response.success)
                {
                   if($scope.type==1){
                     $scope.teamsmslogslist = response.records;
                     $scope.teamsmslogslength = response.totalCount; 
                       
                   }
                   else{
                       $scope.smslogslist = response.records;
                       $scope.smslogslength = response.totalCount;
                   } 
                   
                } else
                {
                    $scope.smslogslist = '';
                    $scope.smslogslength = 0;
                    $scope.teamsmslogslist='';
                    $scope.teamsmslogslength=0; 
                }
                $('#showFilterModal').modal('hide');
                $scope.showFilterData = $scope.filterData;
                $scope.hideloader();
                $scope.flagForChange = 0;
                return false;
            });
         }
         
          $scope.removeDataFromFilter = function (keyvalue) {
            $scope.showloader();
            delete $scope.filterData[keyvalue];
            $scope.getFilteredData($scope.filterData, 1, 30);
            $scope.hideloader();
            return false;
        }
        
        $scope.managesmsLogs = function(type,pageNumber, itemPerPage){
             $scope.showloader();
        Data.post('/promotionalsms/getSmslogs', {
                isTeam: type,pageNumber: pageNumber, itemPerPage: itemPerPage,
            }).then(function (response) {
                if (response.success) {
                   // console.log(response);
                    if(type == 1 ){
                        $scope.teamsmslogslist = response.records;
                        $scope.teamsmslogslength = response.totalCount;
                    }else if(type == 0){
                         $scope.smslogslist = response.records;
                        $scope.smslogslength = response.totalCount;
                    }
            
                }
                
                $scope.flagForChange = 0;
                 $scope.hideloader();
            });
    }
    
    $scope.getCustomerFilteredData=function(filterData){
         
             $scope.showloader();
             if (typeof filterData.fromDate !== 'undefined') {
                var fdate = new Date(filterData.fromDate);
                $scope.filterData.fromDate = (fdate.getFullYear() + '-' + ("0" + (fdate.getMonth() + 1)).slice(-2) + '-' + fdate.getDate());
            }  if (typeof filterData.toDate !== 'undefined') {
                var tdate = new Date(filterData.toDate);
                $scope.filterData.toDate = (tdate.getFullYear() + '-' + ("0" + (tdate.getMonth() + 1)).slice(-2) + '-' + tdate.getDate());
            }
             
            Data.post('/promotionalsms/getcustomerFilterdata', {filterData: filterData, getProcName: $scope.getProcName}).then(function (response) {
               
                if (response.success)
                {
                         
                 $scope.promotionalsmsData.mobilenumbers = response.url;
                 $scope.customertotalcount = response.totalCount; 
                                  
                } else
                {
                    
                    $scope.customertotalcount=0; 
                }
                
                $('#showFilterModal').modal('hide');
                $scope.hideloader();
               return false;
            });
            
     
     
    }
  
      
      
}]);