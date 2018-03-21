angular.module('bushfireApp').
controller('LoginController', ['$scope', 'loginservice', '$location','$cookieStore', '$rootScope', '$window', 'AppConstant','$timeout',
    function LoginController($scope, loginservice, $location, $cookieStore, $rootScope, $window, AppConstant, $timeout) {


        if($cookieStore.get('loggedin') === false || typeof $cookieStore.get('loggedin') === "undefined"){

            $scope.userentryerror = false;
            $cookieStore.put('loggedin', false);
            $cookieStore.put('userEmail', '');
            $cookieStore.put('token', '');
            $cookieStore.put('permissions', '');
            $cookieStore.put('accountType', '');
            $scope.userModel = {};
            $scope.userModel.accountType = 'Business Account';
            $cookieStore.put('leftnavbusi', false);
            $cookieStore.put('leftnavads', false);
            $scope.adminUrl = AppConstant.adminUrl;
            $scope.showLoaderonlogin = false;
            $scope.loginUser = false;
            $scope.userentryerror = false;

        }else if($cookieStore.get('loggedin') === true && $cookieStore.get('accountType') == 'Business Account'){

            $location.path("/home");
        }else if($cookieStore.get('loggedin') === true && $cookieStore.get('accountType') == 'Ad Account')
        {
            $location.path("/ads-home");
        }


        $scope.submitLogin = function() {
            var form_data = new FormData();
            form_data.append('user', JSON.stringify($scope.userModel));
            loginservice.checklogin(form_data).
            then(function(response) {

                if (response.data.status === 0) {
                    $scope.showLoaderonlogin = false;
                $timeout(function () {
                      $scope.userentryerror = false;
                       }, 2500);
                      $scope.userentryerror = true;

                } else if (response.data.status === 1) {
                    $scope.showLoaderonlogin = true;
                    $cookieStore.put('token', response.data.data.token);
                    $rootScope.token = response.data.data.token;
                    $cookieStore.put('loggedin', true);
                    $cookieStore.put('userEmail', response.data.data.user.email);
                    $rootScope.loginUser = true;
                    $rootScope.userEmail = response.data.data.user.email;
                    $rootScope.sender = response.data.data.user.mobile_number;
                    $cookieStore.put('sender', response.data.data.user.mobile_number);
                    $cookieStore.put('accountType', response.data.data.accountType);
                    $cookieStore.put('permissions', response.data.data.permissions);
                    $rootScope.permissions = $cookieStore.get('permissions');

                    if (response.data.data.accountType === 'Ad Account') {
                       $scope.showLoaderonlogin = false;
                        $cookieStore.put('leftnavbusi', false);
                        $cookieStore.put('leftnavads', true);

                        $rootScope.leftnavbusi = false;
                        $rootScope.leftnavads = true;
                        $location.path("/ads-home");

                    } else {
                        $scope.showLoaderonlogin = false;
                        $cookieStore.put('leftnavbusi', true);
                        $cookieStore.put('leftnavads', false);

                        $rootScope.leftnavbusi = true;
                        $rootScope.leftnavads = false;

                        $location.path("/home");
                    }
                    $scope.showLoaderonlogin = false;

                } else {
                    alert('Not an Admin user');
                }

            }, function(error) {
                alert('user not found');
            });
        };

    }
]);
