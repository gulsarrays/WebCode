angular.module('bushfireApp').
controller('ChatListController', ['$scope', 'chanelservice', '$rootScope', '$cookieStore', '$routeParams',
    function ChatListController($scope, chanelservice, $rootScope,$cookieStore, $routeParams) {
    	$scope.chatchannelUsers = {};
    	$scope.activechat = false;
    	$scope.activeReceiver = '';
    	$scope.activeSender = '';
    	$scope.activemessage = '';

        chanelservice.getChatList().then(function(response) {
            $scope.chatchannels = response.data.data.item;
        }, function(error) {

        });

        $scope.getchannelUsers = function(channelid) {
        	chanelservice.getchannelUsers(channelid).then(function(response) {
	            $scope.chatchannelUsers = response.data.data.item;
	            $scope.activechat = false;

	        }, function(error) {

	        });
        }

        $scope.getuserchat = function(mobilenumber,name){
        	$scope.activeReceiver = mobilenumber;
        	angular.element(document.getElementById('chatwindowname')).html(name);
        	angular.element(document.getElementById('msgDiv')).html("");
        	$scope.activechat = true;
        }

        $scope.togglechatwindow = function(){
        	if($scope.activechat == true){
        		$scope.activechat = false;
        	}else{
        		$scope.activechat = true;
        	}
        }

        $scope.sendchat = function(){
        	// console.log($rootScope.sender + $cookieStore.get('sender'));
            if($scope.activemessage != ''){
            	chanelservice.pushChatMessage($cookieStore.get('sender'), $scope.activeReceiver, $scope.activemessage).then(function(response) {
    	            console.log(response);
    	        }, function(error) {

    	        });

            	var sentHtml1 = '<div class="row msg_container base_sent"><div class="col-xs-9"><div class="messages msg_sent">';
                var sentHtml2 ='<p>'+$scope.activemessage+'</p></div></div>';
                var sentHtml3 ='</div>';//'<time datetime="2009-11-13T20:00">2:28 pm</time></div>';
            	angular.element(document.getElementById('msgDiv')).append(sentHtml1+sentHtml2+sentHtml3);
            	$scope.activemessage = '';
            }

        }


        $scope.gotoSubscribers = function(channelId) {
            chanelservice.getSubscribersList(channelId).then(function(response) {
                $scope.chatsubscribers = response.data.data.item;
            }, function(error) {

            });
        }

        $scope.chatbox = false;
        $scope.showChat = function(userName) {
            $scope.chatbox = true;
        }


        $scope.closechat = function(userName) {
            $scope.chatbox = false;
        }
        $scope.enterbtnsub = function(){
          if(e.which === 13) {
            return alert('santhosh')
          }
        }

    }

]);
