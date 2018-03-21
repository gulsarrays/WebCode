angular.module('bushfireApp').factory("HttpInterceptor", ['$rootScope', function($rootScope) {

    return {
        request: function(config) {
            var token = $rootScope.token;
            config.headers.Authorization = 'Bearer ' + token;
            return config;
        },
        responseError: function(rejection) {

        }
    };
}])