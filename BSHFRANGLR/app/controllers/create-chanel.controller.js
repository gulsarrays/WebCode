angular.module('bushfireApp').
controller('CreateChanelController', ['$scope', 'chanelservice', '$location', '$routeParams','$timeout',
    function CreateChanelController($scope, chanelservice, $location, $routeParams, $timeout) {

        $scope.createModel = {};

        $scope.char_remaining = 50;
        $scope.imageerrormsg = false;
        $scope.classIsSet = false;


        $scope.clear = function () {
            $scope.filesUpload = null;
        };
        $scope.checkCharactersLeft = function($event){
            var curelem = angular.element($event.currentTarget).val().length;
            $scope.char_remaining = 50-curelem;
        }
         $scope.close = function(){
           $('#errormodal').addClass('display-none');
           $('#errormodal').removeClass('modal');
         }

        $scope.submitForm = function() {

            var form_data = new FormData();
            if ($scope.filesUpload){
            form_data.append('files', $scope.filesUpload)
            form_data.append('channels', JSON.stringify($scope.createModel));
 
            }
            else{
              alert("select image");
            }
             chanelservice.createChannnel(form_data).
            then(function(response) {
                $location.path("/channel-detail/" + response.data.channelId);
                // $location.path("/home");
            }, function(error) {

            });

        };
        $scope.profilepicupload = function() {
          var fr = new FileReader;
          fr.onload = function() {
             var img = new Image;
             img.onload = function() {
               if (img.width > 600 || img.height != img.width){
                $('#errormodal').addClass('modal');
                $scope.imageerrormsg = true;
                $scope.clear();
                 return;
               }
              $scope.imageUrl = img.src;
             };
              img.src = fr.result;
          };
          fr.readAsDataURL($scope.filesUpload);

        }


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
    }
]);
