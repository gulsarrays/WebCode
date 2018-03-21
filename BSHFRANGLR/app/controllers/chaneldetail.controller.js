angular.module('bushfireApp').
controller('ChannelDetailController', ['$http', 'AppConstant', '$scope', 'chanelservice', '$location', '$routeParams',
 'Upload', '$timeout','$window',

    function ChannelDetailController($http, AppConstant, $scope, chanelservice, $location, $routeParams, Upload, $timeout, $window) {

        $scope.imageUrl = '../img/bushimgs/default-thumbnail.jpg';
        $scope.adminUrl = AppConstant.adminUrl;

        $scope.UploadContentShow = false;
        $scope.EditContentShow = false;
        $scope.EditChannelShow = false;
        $scope.editChannel = {};

        chanelservice.getChannelDetailList($routeParams.channelId).then(function(response) {
            $scope.chaneldetails = response.data.data.item;
            console.log($scope.chaneldetails);
            $scope.editChannel.channelTitle = $scope.chaneldetails.channelTitle;
            $scope.editChannel.channelDescription = $scope.chaneldetails.channelDescription;
            $scope.editChannel.ageGroupId = $scope.chaneldetails.ageGroup.ageGroupId;
            $scope.editChannel.categoryId = $scope.chaneldetails.category.categoryId;

        }, function(error) {

        });

        chanelservice.getContentLsting($routeParams.channelId).then(function(response) {
            $scope.contentlistings = response.data.data.item;
            
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

         $scope.selectEditChannelImage = function(image) {
            // $scope.imageUrl = null;
            var fr = new FileReader;
            fr.onload = function() {
            var img = new Image;
            img.onload = function() {
                // $scope.imageUrl = img.src;
            }
            img.src = fr.result;
            };
            fr.readAsDataURL($scope.editContentModel.filesUpload);
        }
        $scope.setFiles = function(element) {
            $scope.$apply(function($scope) {
              // Turn the FileList object into an Array
                $scope.files = [];
                for (var i = 0; i < element.files.length; i++) {
                  $scope.files.push(element.files[i]);
                  
                }
              $scope.progressVisible = false;
              });
        };
        $scope.clearfile = function () {
            $scope.files = null;
            $scope.filesUpload = null;
        };

        $scope.removeContent = function(id) {

            chanelservice.delContent(id).then(function(response) {
                chanelservice.getContentLsting($routeParams.channelId).then(function(response) {
                    $scope.contentlistings = response.data.data.item;
                });
            }, function(error) {

            });

        }

       $scope.showDetailPopUp = function(img_src,contentPath, contentType, contentTitle, contentDesc){
            
            $scope.uploadedImg_path = img_src+contentPath;
            $scope.UploadContentTitle = contentTitle;
            $scope.UploadContentText = contentDesc;

            if(contentType == 'image/jpeg' || contentType == 'image/png'){
                $scope.CType = 'image';
            }

            else if(contentType == 'audio/mpeg' || contentType == 'audio/mp3' || contentType == 'audio/x-wav' ){
                $scope.CType = 'audio';
                // $("audio")[0].load();
                // // $("audio")[0].play();
            }

            else if(contentType == 'video/mp4' || contentType == 'video/quicktime'){
                $scope.CType = 'video';
                // $("video")[0].load();
                // $("video")[0].play();
            }
            else{
                $scope.CType = 'text';
            }
            $scope.UploadContentShow = true;
        }

        $scope.editContent = function(img_src,contentPath, contentType, contentTitle, contentDesc,contentId){
            $scope.editContentModel = {};
            $scope.uploadedImg_path = img_src+contentPath;
            $scope.editContentModel.contentId = contentId;
            $scope.editContentModel.contentTitle = contentTitle;
            $scope.editContentModel.contentText = contentDesc;
            $scope.editContentModel.contentDescription = contentDesc;

            if(contentType == 'image/jpeg' || contentType == 'image/png'){
                $scope.CType = 'image';
            }

            else if(contentType == 'audio/mpeg' || contentType == 'audio/mp3' || contentType == 'audio/x-wav' ){
                $scope.CType = 'audio';
            }

            else if(contentType == 'video/mp4'  || contentType == 'video/quicktime'){
                $scope.CType = 'video';
            }
            else{
                $scope.CType = 'text';
            }
            $scope.EditContentShow = true;
            
        }

        $scope.hideDetailPopUp = function($event, CType){

            if(CType == 'audio'){
                $("audio")[0].pause();
            }
            if(CType == 'video'){
                $("video")[0].pause();
            }

            $scope.UploadContentShow = false;
            $scope.EditContentShow = false;
        }    

        $scope.hideContentEdit = function($event){
            $scope.EditChannelShow = false;
        }

        $scope.updateContent = function(){           
            console.log($scope.editContentModel);
            chanelservice.updateContent($scope.editContentModel).
            then(function(response) {

                if (response.data.status === 1)
                    $scope.EditContentShow = false;
                $window.location.reload();
            },
            function(error) {
                
            });
        }

        $scope.editChannelPopup = function(){

            $scope.EditChannelShow = true;
        }

        $scope.updateChannel = function(){ 

            var form_data = new FormData();
            form_data.append('files', $scope.filesUpload);
            chanelservice.updateChannel(JSON.stringify($scope.editChannel), $routeParams.channelId,
                form_data).
            then(function(response) {

                if (response.data.status === 1)
                    $scope.EditChannelShow = false;
                $window.location.reload();
            },
            function(error) {
                // $scope.fUpload_Success = false;
            });
            
        }

    }
]);
