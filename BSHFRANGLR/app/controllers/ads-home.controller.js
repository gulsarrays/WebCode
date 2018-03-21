angular.module('bushfireApp').
controller('AdsHomeController', ['$scope', 'chanelservice', '$location', '$routeParams','$rootScope','$filter',
    function AdsHomeController($scope, chanelservice, $location, $routeParams, $rootScope, $filter) {

        $scope.userCountModel = {};
        $scope.count = 0;

        $scope.countSearchClick = function() {

            var ids = null;
            var ageids = null;
            var gendids = null;


            for(var i = 0; i < $scope.userCountModel.categorylist.length; i++){

                if(ids != null){
                    ids = ids + "," + $scope.userCountModel.categorylist[i].categoryId;
                }else{
                    ids = $scope.userCountModel.categorylist[i].categoryId;
                }

            }

            for(var i = 0; i < $scope.userCountModel.ageGrouplist.length; i++){
                if(ageids != null){
                    ageids = ageids + "," + $scope.userCountModel.ageGrouplist[i].ageGroupId;
                }else{
                    ageids = $scope.userCountModel.ageGrouplist[i].ageGroupId;
                }
            }

            for(var i = 0; i < $scope.userCountModel.genderlist.length; i++){
                if(gendids != null){
                    gendids = gendids + "," + $scope.userCountModel.genderlist[i].gender;
                }else{
                    gendids = $scope.userCountModel.genderlist[i].gender;
                }
            }

            // $scope.userCountModel.ageGroupId = '8d71e6f3-73f8-40d2-a2c5-3eb32e725ca9';
            // $scope.userCountModel.categoryId = '31cb2d4a-bcac-4322-91d4-a89728c8dbe2';
            // $scope.userCountModel.gender = 'male';

            chanelservice.userCount(ids, ageids, gendids).
            // chanelservice.userCount(categoryId, ageGroupId, gender).
            then(function(response) {
                    if (response.data.status === 1)
                        $scope.count = response.data.count;
                },
                function(error) {

                });
        }

        $scope.gendergps = [
            {
                gender:'Male',
                genderName:'Male'
            },
            {
                gender:'Female',
                genderName:'Female'
            }
        ];


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

        // rate card list API
        chanelservice.getRatecardList().then(function(response) {
            $scope.ratecards = response.data.data.item;
        }, function(error) {

        });

        // ads list API
        chanelservice.getAdsList().then(function(response) {
            if(response.data.content){
                $scope.adslists = response.data.content;
                $scope.adslists.currentdate = $filter('date')(new Date(), 'dd-MM-yyyy');
            }else{
                $scope.adslists = null;
            }
            
        }, function(error) {

        });


        //ADVERTISEMENT status
        $scope.updateAdvertStatusFn=function(adval,adId){
            // alert(adval);
            if(adval == 1)
            {                
                chanelservice.activateAdvert(adId).then(function(response){
                    
                    if(response.status== 200){
                        
                        alert("Ad started successfully");
                    }else{
                        alert("Something went wrong please try again","danger"); 
                    }
                },function(error){
                    alert("Something went wrong please try again","danger");
                });

            }else
            {
               
                chanelservice.deActivateAdvert(adId).then(function(response){
                    
                    if(response.status== 200){
                        
                        alert("Ad stopped successfully");
                    }
                    else{
                        alert("Something went wrong please try again","danger"); 
                    }
                },function(error){
                    alert("Something went wrong please try again","danger");
                });
            }
        }

    }

]);
