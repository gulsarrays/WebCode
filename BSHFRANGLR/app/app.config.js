'use strict';

angular.module('bushfireApp')
.config(['$locationProvider', function($locationProvider) {
    $locationProvider.hashPrefix('');
}]);

angular.module('bushfireApp').
config(['$locationProvider', '$routeProvider', '$httpProvider', 'userResolve',
    function config($locationProvider, $routeProvider, $httpProvider, userResolve) {
        $httpProvider.interceptors.push('HttpInterceptor');
        // $locationProvider.hashPrefix('!');

        $routeProvider.
        when('/', {
            templateUrl: 'views/login.template.html',
            controller: 'LoginController'
        }).
        when('/home', {
            templateUrl: 'views/chanel-list.template.html',
            controller: 'ChanelListController',
            resolve: userResolve
        }).
        when('/ads-home', {
            templateUrl: 'views/ads-home.template.html',
            controller: 'AdsHomeController',
            resolve: userResolve
        }).
        when('/create-ads', {
            templateUrl: 'views/create-ads.template.html',
            controller: 'CreateAdsController',
            resolve: userResolve
        }).
        when('/create-chanel', {
            templateUrl: 'views/create-chanel.html',
            controller: 'CreateChanelController',
            resolve: userResolve
        }).
        when('/channel-detail/:channelId', {
            templateUrl: 'views/chaneldetail.template.html',
            controller: 'ChannelDetailController',
            resolve: userResolve
        }).
        when('/subscribed-users', {
            templateUrl: 'views/subscribed-users.template.html',
            controller: 'SubscribListController',
            resolve: userResolve
        }).
        when('/chats', {
            templateUrl: 'views/chatlist.template.html',
            controller: 'ChatListController',
            resolve: userResolve
        }).
        when('/logout', {
            templateUrl: 'views/login.template.html',
            controller: 'navController'
        }).
        otherwise('/');
    }
]);