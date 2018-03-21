angular.module('bushfireApp')
.controller('CreateAdsController', ['$scope', 'chanelservice', '$location', '$cookieStore', '$routeParams', '$filter','$timeout', 'AppConstant', '$q', '$route',

    function CreateAdsController($scope, chanelservice,$location, $cookieStore, $routeParams,$filter, $timeout, AppConstant, $q, $route) {

        $scope.showLoader=false;
        $scope.adminUrl = AppConstant.adminUrl;

        $scope.createAdModel = {};
        $scope.error_msg = false;
        $scope.adfile = false;
        $scope.usercount = 0;
        $scope.adaudiofile = false;
        $scope.advideofile = false;
        $scope.imageerrormsg = false;
        $scope.viewerrormsg = false;

        $scope.getUsercount = function() {

            var ids = null;
            var ageids = null;
            var gendids = null;

            for(var i = 0; i < $scope.categorylist.length; i++){

                if(ids != null){
                    ids = ids + "," + $scope.categorylist[i].categoryId;
                }else{
                    ids = $scope.categorylist[i].categoryId;
                }

            }

            for(var i = 0; i < $scope.ageGrouplist.length; i++){
                if(ageids != null){
                    ageids = ageids + "," + $scope.ageGrouplist[i].ageGroupId;
                }else{
                    ageids = $scope.ageGrouplist[i].ageGroupId;
                }
            }

            for(var i = 0; i < $scope.genderlist.length; i++){
                if(gendids != null){
                    gendids = gendids + "," + $scope.genderlist[i].genderName;
                }else{
                    gendids = $scope.genderlist[i].genderName;
                }
            }

            // ageids = $scope.ageGrouplist;
            // ids = $scope.categorylist;
            // gendids = $scope.genderlist;

            chanelservice.userCount(ids, ageids, gendids).
            then(function(response) {
                    if (response.data.status === 1)
                        $scope.usercount = response.data.count;
                },
                function(error) {

                });
        }

          $scope.close = function(){
           $('#errormodal').addClass('display-none');
           $('#errormodal').removeClass('modal');
         }
        $scope.closedate = function () {
           $('#errordatemodal').addClass('display-none');
           $('#errordatemodal').removeClass('modal');
           $route.reload();
        }
         $scope.toggleFileupload = function() {
            var currentSelected = $filter('filter')($scope.ratecards, {rateCardId: $scope.createAdModel.rateCardId})[0];

            if(currentSelected.contentType == 'Image'){
                $scope.adfile = true;
            }else{
                $scope.adfile = false;
            }
            if(currentSelected.contentType == 'Audio'){
                $scope.adaudiofile  = true;
            }else{
                $scope.adaudiofile  = false;
            }
            if(currentSelected.contentType == 'Video'){
                $scope.advideofile  = true;
            }else{
                $scope.advideofile  = false;
            }
        }


        $scope.updateAmount = function() {
            chanelservice.ratecardAmount($scope.createAdModel.rateCardId, $scope.createAdModel.viewsToPost).
            then(function(response) {
                    if (response.data.status === 1)
                        $scope.createAdModel.amount = response.data.content.amount;
                },
                function(error) {

                });
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



    $scope.uploadFile = function() {
        var fd = new FormData();
        for (var i in $scope.files) {
            fd.append("uploadedFile", $scope.files[i])
        }
        var xhr = new XMLHttpRequest()
        xhr.upload.addEventListener("progress", uploadProgress, false);
        xhr.addEventListener("load", uploadComplete, false);
        xhr.addEventListener("error", uploadFailed, false);
        xhr.addEventListener("abort", uploadCanceled, false);
        xhr.open("POST", "/fileupload");
        $scope.progressVisible = true;
        xhr.send(fd);
    }

    function uploadProgress(evt) {
        $scope.$apply(function(){
            if (evt.lengthComputable) {
                $scope.progress = Math.round(evt.loaded * 100 / evt.total);
            } else {
                $scope.progress = 'unable to compute';
            }
        })
    }

    function uploadComplete(evt) {
        /* This event is raised when the server send back a response */
       // alert(evt.target.responseText)
    }

    function uploadFailed(evt) {
        // alert("There was an error attempting to upload the file.")
    }

    function uploadCanceled(evt) {
        $scope.$apply(function(){
            $scope.progressVisible = false;
        })
        // alert("The upload has been canceled by the user or the browser dropped the connection.")
    }

    $scope.clearfile = function () {
            $scope.files = null;
            $scope.filesUpload = null;
        };

    $scope.uploadcontentchange = function(image){
        
        if($scope.createAdModel.rateCardId == '4e1c29d4-da6a-4f6c-9456-dd127d7e6fe9'){
            var fr = new FileReader;
            fr.onload = function() {
               var img = new Image;
               img.onload = function() {
                 if (img.width != 700  || img.height != 90){
                    $('#errormodal').addClass('modal');
                      $scope.imageerrormsg = true;
                      $scope.clearfile();
                      return;
                 }
                 else{
                 }
                 $scope.imageUrl = img.src;
               };

                 img.src = fr.result;
            };
            fr.readAsDataURL($scope.filesUpload);
        }
    }

    $scope.scrollToTop = function(id) {
       document.getElementById(id).scrollIntoView(true);
    }

    $scope.submitForm  = function($event) 
    {
            var ids = null;
            var ageids = null;
            var gendids = null;
            $scope.createAdModel.adStartDate = $filter('date')($scope.createAdModel.input_adStartDate, "yyyy-MM-dd");
            $scope.createAdModel.adEndDate = $filter('date')($scope.createAdModel.input_adEndDate, "yyyy-MM-dd");
          
            if($scope.createAdModel.adEndDate < $scope.createAdModel.adStartDate){
                $scope.error_msg = true;
                $scope.cat_not_selected = "Start-Date should be less than End-Date";
                return;
            }
            else if($scope.categorylist==undefined){
                $scope.error_msg = true;
                $scope.cat_not_selected = "Atleast one Category";
                $scope.scrollToTop('globalADform');
                return;
            }
            else if($scope.genderlist==undefined){
                $scope.error_msg = true;
                $scope.cat_not_selected = "Gender";
                $scope.scrollToTop('globalADform');
                return;
            }
            else if($scope.ageGrouplist==undefined){
                $scope.error_msg = true;
                $scope.cat_not_selected = "Atleast one Age Group";
                $scope.scrollToTop('globalADform');
                return;
            }
            else{
                $scope.error_msg = false;
                $scope.cat_not_selected = " ";
            }

            for(var i = 0; i < $scope.categorylist.length; i++){
                if(ids != null){
                    ids = ids + "," + $scope.categorylist[i].categoryId;
                }else{
                    ids = $scope.categorylist[i].categoryId;
                }
            }
            for(var i = 0; i < $scope.ageGrouplist.length; i++){
                if(ageids != null){
                    ageids = ageids + "," + $scope.ageGrouplist[i].ageGroupId;
                }else{
                    ageids = $scope.ageGrouplist[i].ageGroupId;
                }
            }
            for(var i = 0; i < $scope.genderlist.length; i++){
                if(gendids != null){
                    gendids = gendids + "," + $scope.genderlist[i].genderId;
                }else{
                    gendids = $scope.genderlist[i].genderId;
                }
            }

            //$scope.uContentModel.channelId = $routeParams.channelId;
            var fileVal = $('#file').val();
            if(fileVal!='')
            {
                $scope.uploadFile();
            }

            var form_data = new FormData();
            
            $scope.createAdModel.ageGroupId = ageids; //'156bcba5-03d4-4b00-b3c0-b44974239fa4';
            $scope.createAdModel.categoryId = ids; //'31cb2d4a-bcac-4322-91d4-a89728c8dbe2';
            $scope.createAdModel.genderId = gendids; //'male';

            // $scope.createAdModel.ageGroupId = $scope.ageGrouplist; //'156bcba5-03d4-4b00-b3c0-b44974239fa4';
            // $scope.createAdModel.categoryId = $scope.categorylist; //'31cb2d4a-bcac-4322-91d4-a89728c8dbe2';
            // $scope.createAdModel.gender = $scope.genderlist; //'male';
            
            form_data.append('files', $scope.filesUpload);
            form_data.append('adModel', JSON.stringify($scope.createAdModel));
            console.log($scope.createAdModel);

            $scope.showLoader=true;
            chanelservice.adsUpload(form_data).
            then(function(response) {
                if(response == undefined){
                    $scope.showLoader=false;
                    $scope.viewerrormsg = true;
                }
                if (response.data.status === 200)
                $timeout(function(){
                  $scope.showLoader=false;
                  $location.path("/ads-home");
                },4000);

            },
            function(error) {
                alert(error);
            });

        };

        $scope.closeviewerror = function(){
            $scope.viewerrormsg = false;
        }

        $scope.cancel = function() {
           $location.path("/ads-home");
        };
          $scope.char_remaining = 50;
        $scope.adscheckCharactersLeft = function($event){
            var curelem = angular.element($event.currentTarget).val().length;
            $scope.char_remaining = 50-curelem;
        }

        chanelservice.getGenderList().then(function(response) {
            $scope.gendergps = response.data.data.item;
        }, function(error) {

        });

        // rate card list API
        chanelservice.getRatecardList().then(function(response) {
            $scope.ratecards = response.data.data.item;
            console.log( $scope.ratecards);
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
    }
]);
