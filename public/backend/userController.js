/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


app.controller('userController', function($scope, Data, $filter) {
$scope.pageHeading = 'Create User';

$scope.userData = {};
$scope.userData.gender = "0";
$scope.userData.title = "0";
$scope.userData.blood_group_id = "0";
$scope.userData.physic_status_id = "0";
$scope.userData.marital_status = "0";
$scope.userData.dt = $filter('date')(new Date(), 'yyyy-MM-dd');
$scope.userData.joining_date = $filter('date')(new Date(), 'yyyy-MM-dd');
$scope.userData.highest_education_id = "0";
$scope.userData.employee_status = "1";
$scope.userData.current_city_id = $scope.userData.permenent_city_id = "0";
$scope.userData.current_state_id = $scope.userData.permenent_state_id = "0";
$scope.userData.current_country_id = $scope.userData.permenent_country_id = "0";
$scope.departments = [];

$scope.createUser = function (userData) {
    console.log(userData);
    Data.post('user', {
        data: userData
    }).then(function (response) {
        if(!response.success){
            $scope.errorMsg = response.message;
        }
        else{                
        }
    });
};
   
});