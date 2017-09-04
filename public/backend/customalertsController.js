'use strict';
app.controller('customalertsController', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout','toaster', function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout,toaster) {
    $scope.pageHeading = 'Create Custom Template';
    $scope.buttonLabel = 'Create';
    $scope.customAlertData = {};
    $scope.listcustomAlerts = [];
    $scope.templateEvents = [];
    $scope.isDisabled = false;
    $scope.customAlertData.client_id = 1;
    $scope.currentPage =  $scope.itemsPerPage = 30; 
    $scope.noOfRows = 1;
   
    $scope.pageNumber = 1;
    $scope.pageChanged = function (pageNo, functionName,id, type, pageNumber) { 
        $scope[functionName](id, type, pageNumber, $scope.itemsPerPage);
        $scope.pageNumber = pageNo;
    };
    
    $scope.getTemplatesEvents = function(){
        Data.post('alerts/getTemplatesEvents').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.templateEvents = response.records;
            }
        });
    };
    $scope.createAlert = function (enteredData, alterId) {
        var customAlertData = {};        
        $scope.isDisabled = true;
        customAlertData = angular.fromJson(angular.toJson(enteredData));
        if(alterId === 0)
        {          
           Data.post('customalerts/', {
                customAlertData:customAlertData}).then(function (response) {
                $scope.isDisabled = false;
                if (!response.success)
                {
                    toaster.pop('error', 'Custom Template', response.message);
                } else {
                    toaster.pop('success', 'Custom Template', response.message);
                    $timeout(function(){
                        $state.go('customalertsIndex');
                    }, 1000);
                }
            }); 
        }
        else{
            Data.post('customalerts/updateCustomAlerts', {
                customAlertData:customAlertData, id: alterId}).then(function (response) {
                $scope.isDisabled = false;
                if (!response.success)
                {
                    toaster.pop('error', 'Custom Template', response.message);
                } else {
                    toaster.pop('success', 'Custom Template', response.message);
                    $timeout(function(){
                        $state.go('customalertsIndex');
                    }, 1000);
                }
            });
        }
    };
    
    $scope.manageAlerts = function (id,action, pageNumber= '', itemPerPage = '') { //edit/index action
        $scope.modal = {};
            $scope.showloader();
        Data.post('customalerts/manageCustomAlerts',{
            id: id,pageNumber: pageNumber, itemPerPage: itemPerPage,
        }).then(function (response) {
            if (response.success) {
                if(action === 'index'){
                    $scope.listcustomAlerts = response.records.data;
                    $scope.listcustomAlertsLength = response.records.total;
                }
                else if(action === 'edit'){
                    if(id !== '0'){
                        $scope.pageHeading = 'Update Custom Template';
                        $scope.buttonLabel = 'Update';
                        $scope.isDisabled =true;
                        $scope.customAlertData = angular.copy(response.records.data[0]);
                    }
                }
            } else {
                $scope.errorMsg = response.message;
            }
            $scope.hideloader();
        });
    };

    $scope.pageChangeHandler = function(num) {
        $scope.noOfRows = num;
        $scope.currentPage = num * $scope.itemsPerPage;
    };
    
}]);
app.directive('ckEditor', function() {
    return {
        require : '?ngModel',
        link : function($scope, elm, attr, ngModel) {

            var ck = CKEDITOR.replace(elm[0]);
           

            ck.on('instanceReady', function() {
                ck.setData(ngModel.$viewValue);
            });

            ck.on('pasteState', function() {
                $scope.$apply(function() {
                    ngModel.$setViewValue(ck.getData());
                });
            });

            ngModel.$render = function(value) {
                ck.setData(ngModel.$modelValue);
            };
        }
    };
});
app.filter('htmlToPlaintext', function()
{
    return function(text)
    {
        var temp = text ? String(text).replace(/<[^>]+>/gm, '') : '' ;
        temp = temp ? String(temp).replace(/  /g, '&nbsp; '):'';
        return  temp;
    };
});
