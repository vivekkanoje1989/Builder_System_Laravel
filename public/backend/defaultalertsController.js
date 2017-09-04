'use strict';
app.controller('defaultalertsController', ['$rootScope', '$scope', '$state', 'Data', '$filter', 'Upload', '$timeout','toaster', function ($rootScope, $scope, $state, Data, $filter, Upload, $timeout,toaster) {
    $scope.pageHeading = 'Create Custome Alert';
    $scope.buttonLabel = 'Create';
    $scope.defaultAlertData = {};
    $scope.listdefaultAlerts = [];
    $scope.templateEvents = [];
    $scope.currentPage =  $scope.itemsPerPage = 30; 
    $scope.noOfRows = 1;
   
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
        var defaultAlertData = {};        
        defaultAlertData = angular.fromJson(angular.toJson(enteredData));
        if(alterId === 0)
        {          
           Data.post('defaultalerts/', {
                defaultAlertData:defaultAlertData}).then(function (response) {
               
                if (!response.success)
                {
                    toaster.pop('error', 'Default Template', response.errormsg);
                } else {
                    toaster.pop('success', 'Default Template', response.successMsg);
                    $timeout(function(){
                        $state.go('defaultalertsIndex');
                    }, 1000);
                }
            }); 
        }
        else{
             
            Data.post('defaultalerts/updateDefaultAlerts', {
                defaultAlertData:defaultAlertData, id: alterId}).then(function (response) {
                console.log(response)
                if (!response.success)
                {
                    toaster.pop('error', 'Default Template', response.errorMsg);
                } else {
                    toaster.pop('success', 'Default Template', response.successMsg);
                    $timeout(function(){
                        $state.go('defaultalertsIndex');
                    }, 1000);
                }
            });
        }
    };
    
    $scope.manageDafaultAlerts = function (id,action) { //edit/index action
        $scope.modal = {};
         $scope.showloader();
        Data.post('defaultalerts/manageDafaultAlerts',{
            id: id,
        }).then(function (response) {
            if (response.success) {
                if(action === 'index'){
                    $scope.listdefaultAlerts = response.records.data;
                   
                    $scope.listdefaultAlertsLength = response.records.total;
                }
                else if(action === 'edit'){
                    if(id !== '0'){
                        $scope.pageHeading = 'Default Template';
                        $scope.buttonLabel = 'Update';
                        $scope.defaultAlertData = angular.copy(response.records.data[0]);
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
