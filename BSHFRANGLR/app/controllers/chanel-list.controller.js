angular.module('bushfireApp').
controller('ChanelListController', ['$scope', 'chanelservice', '$location','$cookieStore','$rootScope',
    function ChanelListController($scope, chanelservice, $location, $cookieStore, $rootScope) {
               
        //Chanel list
        console.log($rootScope.permissions)
        chanelservice.getChannelList().then(function(response) {
            $scope.chanels = response.data.data.item;
        }, function(error) {

        });


        //Chanel list Age dropdown
        chanelservice.getAgeList().then(function(response) {
            $scope.ages = response.data.data.item;
        }, function(error) {

        });


        //Chanel list Category dropdown
        chanelservice.getCategoryList().then(function(response) {
            $scope.categories = response.data.data.item;
        }, function(error) {

        });


        // function to route the with channel id 
        $scope.chaneldetail = function(channelId) {
            $location.path("/channel-detail/" + channelId);

        }

        this.orderPropAge = 'ageGroupDescription';
        this.orderPropCategory = 'categoryName';
    }


]);