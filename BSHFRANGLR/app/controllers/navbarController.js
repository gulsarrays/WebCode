angular.module('bushfireApp').
controller('navController', ['$scope', 'loginservice', '$location', '$cookieStore', '$rootScope', '$cookies',
    function($scope, loginservice, $location, $cookieStore, $rootScope, $cookies) {
        $rootScope.loginUser = $cookieStore.get('loggedin');
        $rootScope.userEmail = $cookieStore.get('userEmail');
        $rootScope.token = $cookieStore.get('token');
        $rootScope.leftnavbusi = $cookieStore.get('leftnavbusi');
        $rootScope.leftnavads = $cookieStore.get('leftnavads');
        $rootScope.permissions = $cookieStore.get('permissions');
        $scope.isActive = function (viewLocation) {
        return viewLocation === $location.path();
    };
    $scope.logout = function() {
        $rootScope.loginUser = false;
        $rootScope.userEmail = false;
        $rootScope.token = false;
        $rootScope.sender = false;
        $rootScope.leftnavbusi = false;
        $rootScope.leftnavads = false;
        $rootScope.permissions = '';
        var cookies = $cookies.getAll();
        angular.forEach(cookies, function(v, k) {
            $cookies.remove(k);
        });
        $location.path("/login");
    };

  }
]);
