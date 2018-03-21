angular.module('bushfireApp').
controller('LoginController', ['$scope', 'loginservice', '$location', '$cookieStore', '$rootScope', '$window',
    function LoginController($scope, loginservice, $location, $cookieStore, $rootScope, $window) {

        $cookieStore.put('loggedin', false);
        $cookieStore.put('userEmail', '');
        $cookieStore.put('token', '');
        $scope.userModel = {};

        $scope.submitLogin = function() {
            // if ($scope.alertform.$valid) { // OR self.form.$valid
            var form_data = new FormData();

            form_data.append('user', JSON.stringify($scope.userModel));
            console.log($scope.userModel);
            // return false;
            loginservice.checklogin(form_data).
            then(function(response) {

                if (response.data.data.user.user_type === 2) {

                    $cookieStore.put('loggedin', true);
                    $cookieStore.put('userEmail', response.data.data.user.email);
                    $cookieStore.put('token', response.data.data.token);
                    $rootScope.loginUser = true;
                    $rootScope.userEmail = response.data.data.user.email;
                    $rootScope.token = response.data.data.token;
                    $location.path("/home");
                } else {
                    $window.location.href = "http://bushfire.lan/staff";
                }

            }, function(error) {
                $location.path("/login");
            });
        };

    }
]);