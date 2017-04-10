'use strict';
app.controller('promotionalsmsController',['$scope', 'Data','$filter','Upload','$window','$timeout','$state','$rootScope', function($scope, Data, $filter,Upload, $window,$timeout,$state,$rootScope) {
$scope.pageHeading = 'Promotional SMS';
$scope.promotionalsmsData = {};

    $scope.sendPromotionalSMS = function (promotionalsmsData,numberFile) {
        console.log(promotionalsmsData);
        $scope.submitted = true;
//        if($scope.promotionalsmsData.send_sms_type==1){
//            Data.post('promotionalsms', {
//                data: {promotionalsmsData: promotionalsmsData},
//            }).then(function (response,evt) {
//                if (!response.success) {
//                    $scope.errorMsg = response.message;
//                } else {
//
//                    $scope.promotionalsmsData = {};
//                    $scope.promotionalsmsData.send_sms_type =1;
//                    $scope.promotionalsmsData.sms_type =1;
//                    $scope.step1 = false;
//                    $('#totalsms').html(1);
//                    $("#totalnumbers").html(0);
//                    $('#totalcharacters').html(0);
//                    $rootScope.alert('success', response.message);
//                    $('.alert-delay').delay(1000).fadeOut("slow");
//                    $timeout(function () {
//                        $state.go(getUrl+'.promotionalsms');
//                    }, 1000);
//
//
//                }
//            });
//        }else if($scope.promotionalsmsData.send_sms_type==2){
                var url = getUrl+'/promotionalsms';
                var data = {promotionalsmsData: promotionalsmsData, numberFile: numberFile};
                numberFile.upload = Upload.upload({
                    url: url,
                    headers: {enctype: 'multipart/form-data'},
                    data: data
                }).then(function (response,evt) {
                    $timeout(function () {
                        $scope.promotionalsmsData = {};
                        $scope.promotionalsmsData.send_sms_type =1;
                        $scope.promotionalsmsData.sms_type =1;
                        $scope.step1 = false;
                        $('#totalsms').html(1);
                        $("#totalnumbers").html(0);
                        $('#totalcharacters').html(0);
                        $rootScope.alert('success', response.message);
                        $('.alert-delay').delay(1000).fadeOut("slow");
                        $state.go(getUrl+'.promotionalsms');
                    });
                });
        //}
    };
    
}]);