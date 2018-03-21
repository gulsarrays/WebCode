angular.module('bushfireApp').
controller('ModelInstanceController', ['$scope', 'chanelservice', '$location', '$cookieStore', '$uibModalInstance', 'channelId', '$routeParams', '$window',
    function ModelInstanceController($scope, chanelservice, $location, $cookieStore, $uibModalInstance, channelId, $routeParams, $window) {


        $scope.uContentModel = {};
        $scope.fUpload_Success = false;
        $scope.upload_type = 'upld_txt';

        $scope.clearfile = function () {
            $scope.files = null;
            $scope.filesUpload = null;
        };

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
                fd.append("uploadedFile", $scope.files[i]);
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
            });
            // alert("The upload has been canceled by the user or the browser dropped the connection.")
        }


        $scope.changeContentType = function(c_type){

            if(c_type == 'upld_media'){
                $('#Ctext').removeAttr('required');
                $('#file').attr('required','required');
                $('#Desc').attr('required','required');
            }
            else{
                $('#file').removeAttr('required');
                $('#Desc').removeAttr('required');
                $('#Ctext').attr('required','required');
            }
        }
        $scope.uploadingchannelimages = function(image) {
          $scope.imageUrl = null;
          var fr = new FileReader;
          fr.onload = function() {
            var img = new Image;
            img.onload = function() {
                console.log(img.src)
                // $scope.imageUrl = img.src;
            }
            img.src = fr.result;
          };
          fr.readAsDataURL($scope.filesUpload);

         }
    

        $scope.char_remaining = 50;

        $scope.checkCharactersLeft = function($event){
            var curelem = angular.element($event.currentTarget).val().length;
            $scope.char_remaining = 50-curelem;
        }

        $scope.uploadsubmitForm = function(channelId,myForm) {

            $scope.uContentModel.channelId = $routeParams.channelId;
            $scope.uContentModel.listGroupId = [];

            if($scope.upload_type == 'upld_media')
            {
                var fileVal = $('#file').val();
                if(fileVal!='' && $('#title').val()!='' && $('#Desc').val()!='')
                {
                    $scope.fUpload_Success = true;
                    $scope.uploadFile();
                }
                else{
                    return;
                }
            }
            
           //$scope.fUpload_Success = true;
            var form_data = new FormData();

            form_data.append('user', $scope.userModel);

            if($scope.upload_type == 'upld_media'){
                form_data.append('files', $scope.filesUpload);

            }

            form_data.append('content-details', JSON.stringify($scope.uContentModel));
            console.log($scope.uContentModel);
            chanelservice.contentUpload(form_data).
            then(function(response) {

                    if (response.data.status === 1)
                        $uibModalInstance.dismiss('cancel');
                    $window.location.reload();
                },
                function(error) {
                        $scope.fUpload_Success = false;
                });
        };

        $scope.cancel = function() {
            $scope.fUpload_Success = false;
            $uibModalInstance.dismiss('cancel');

        };
        $scope.getContentLsting = function() {

        }




    }


]);
