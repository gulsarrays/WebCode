angular.module('bushfireApp').
controller('SubscribListController', ['$scope', 'chanelservice',
    function SubscribListController($scope, chanelservice) {

        chanelservice.getSubscriberChanelList().then(function(response) {
            $scope.subscribusers = response.data.data.item;
        }, function(error) {

        });

    }

]);
