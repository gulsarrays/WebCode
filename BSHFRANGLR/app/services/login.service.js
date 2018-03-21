// login.service.js
angular.module('bushfireApp').
service('loginservice', ['$http', '$q', '$cookieStore', 'AppConstant', '$rootScope', '$location',
    function($http, $q, $cookieStore, AppConstant, $rootScope, $location) {

    // Create channel API
    this.checklogin = function(createModel) {

        var defer = $q.defer();
        $http({
            method: "post",
            url: AppConstant.superAdminUrl + "api/v1/user/login",
            data: createModel,
            headers: {
                'Content-Type': undefined
            },
            transformRequest: angular.identity
        }).then(function(response) {
            defer.resolve(response);
        }, function(error) {
            defer.reject(response)
        });
        return defer.promise;
    };

    this.getUser = function() {
        if ($cookieStore.get('loggedin')) {

            if($cookieStore.get('accountType') == 'Business Account'){
                var home = '/home';
            }else{
                var home = '/ads-home';
            }

            var path = $location.path();
            // alert(path);
            if(path == '/ads-home' && $cookieStore.get('accountType') == 'Business Account'){
                $location.path(home); 
            }
            if(path == '/home' && $cookieStore.get('accountType') != 'Business Account'){
                $location.path(home); 
            }
            if(path == '/create-chanel' && !($rootScope.permissions.indexOf('create-channel') > -1)){
                alert('Permission denied!');
                $location.path(home);                
            }
            else if(path == '/subscribed-users' && !($rootScope.permissions.indexOf('subscribed-users') > -1)){                
                alert('Permission denied!');
                $location.path(home);                
            }
            else if(path == '/chats' && !($rootScope.permissions.indexOf('chat') > -1)){
                alert('Permission denied!');
                $location.path(home);                
            }
            else if(path == '/create-ads' && !($rootScope.permissions.indexOf('create-ad') > -1)){
                alert('Permission denied!');
                $location.path(home);                
            }
            
            return true;
        } else {
            return false;
        }
    };

}]);