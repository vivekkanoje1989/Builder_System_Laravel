/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*app.factory('Auth', function(){
var user;

return{
    setUser : function(aUser){
        user = aUser;
    },
    isLoggedIn : function(){
        return(user)? user : false;
    }
  }
});*/

app.factory("Data", ['$http', 
    function ($http) { // This service connects to our REST API
 
        var serviceBase = 'admin/';
 
        var obj = {};
        obj.get = function (q) {
            return $http.get(serviceBase + q,{
                headers : {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) { // q = URL, object = Post values
            return $http.post(serviceBase + q, object,{
                headers : {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (results) {
                return results.data;
            });
        };
        obj.put = function (q, object) {
            return $http.put(serviceBase + q, object,{
            }).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q,{
                headers : {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (results) {
                return results.data;
            });
        };
        return obj;
}]);
