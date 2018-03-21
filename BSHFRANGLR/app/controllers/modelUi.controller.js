angular.module('bushfireApp').
controller('ModelUiController', ['$scope', 'chanelservice', '$location', '$cookieStore', '$uibModal', '$log', '$document', 'AppConstant',
    function ModelUiController($scope, chanelservice, $location, $cookieStore, $uibModal, $log, $document, AppConstant) {


        var $ctrl = this;
        $scope.img_url = AppConstant.AppUrl+AppConstant.image_url;


        $ctrl.animationsEnabled = true;

        $ctrl.open = function(channelId, size, parentSelector) {
            var parentElem = parentSelector ?
                angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;
            var modalInstance = $uibModal.open({
                animation: $ctrl.animationsEnabled,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                templateUrl: 'myModalContent.html',
                controller: 'ModelInstanceController',
                controllerAs: '$ctrl',
                size: size,
                appendTo: parentElem,
                resolve: {
                    channelId: function() {
                        return channelId;
                    }
                }

            }).result.then(function(success) {

            }, function(error) {

            });


        };
        $ctrl.toggleAnimation = function() {
            $ctrl.animationsEnabled = !$ctrl.animationsEnabled;
        };



    }


]);
