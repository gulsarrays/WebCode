angular.module('bushfireApp').
service('chanelservice', ['$http', '$q', 'AppConstant',
    function($http, $q, AppConstant) {



        // Content Upload API
        this.contentUpload = function(uContentModel, id) {

            var defer = $q.defer();
            console.log(uContentModel.filesUpload);
            $http({
                method: "post",
                url: AppConstant.AppUrl + "channel/content/upload",
                data: uContentModel,
                headers: {
                    "Content-Type": undefined,
                },
                transformRequest: angular.identity
            }).then(function(response) {
                console.log(response);
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(response)
            });
            return defer.promise;
        }




        // Content fetch API 
        this.updateContent = function(updateContentValues) {
            var defer = $q.defer();
            $http({
                method: "put",
                url: AppConstant.AppUrl + "channel/content/update",
                data: updateContentValues,
                header: { "Content-Type": "application/json" }
            }).then(function(response) {
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(response)
            });
            return defer.promise;
        }


        // Create channel API
        this.createChannnel = function(createModel) {

            var defer = $q.defer();
            $http({
                method: "post",
                url: AppConstant.AppUrl + "channel/createChannel",
                data: createModel,
                headers: {
                    'Content-Type': undefined,
                },
                transformRequest: angular.identity
            }).then(function(response) {
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(response)
            });
            return defer.promise;
        }


        this.updateChannel = function(updatemodel, chid, form_data) {
            var defer = $q.defer();
            $http({
                method: "put",
                url: AppConstant.AppUrl + "channel/update",
                params: {'channelModel': updatemodel,'channelId' : chid},
                data: form_data,
                headers: { 'Content-Type': undefined }
            }).then(function(response) {
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(response)
            });
            return defer.promise;
        }



        // Chanel list API 
        this.getChannelList = function() {
            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AppUrl + "channel/myChannel",
                headers: {
                    "Content-Type": "application/json",
                }
            }).then(function(response) {
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }



        // channel detail API
        this.getChannelDetailList = function(id) {

            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AppUrl + "channel/retreiveChannel?channel_id=" + id,
                headers: {
                    "Content-Type": "application/json",
                }
            }).then(function(response) {
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response);
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }

        // Content listing API
        this.getContentLsting = function(id) {

            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AppUrl + "channel/content/channel-id/list?channelId=" + id,
                headers: {
                    "content-Type": "application/json",
                }
            }).then(function(response) {
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }


        // Content listing API
        this.delContent = function(id) {
            var contentId = id;
            var defer = $q.defer();
            $http({
                method: "Delete",
                url: AppConstant.AppUrl + "channel/content/delete?contentId=" + id,
                headers: {
                    "content-Type": "application/json",
                }
            }).then(function(response) {
                console.log(response);
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }




        // Chanel list Age drop down API
        this.getAgeList = function() {
            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AppUrl + "channel/age-group/all",
                headers: {
                    "Content-Type": "application/json",
                }
            }).then(function(response) {
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });

            return defer.promise;
        }

        this.getGenderList = function() {
            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AppUrl + "channel/gender/allActive",
                headers: {
                    "Content-Type": "application/json",
                }
            }).then(function(response) {
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });

            return defer.promise;
        }





        // Chanel list Category drop down API
        this.getCategoryList = function() {
            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AppUrl + "channel/category/all",

                headers: {
                    "Content-Type": "application/json",
                }
            }).then(function(response) {
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }




        // total subscriber chanel list  API
        this.getSubscriberChanelList = function() {
            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AppUrl + "channel/myChannel",
                // data: createModel,
                headers: {
                    "Content-Type": "application/json",
                }
            }).then(function(response) {
                console.log(response);
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }





        // Chat listing API
        this.getChatList = function() {

            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AppUrl + "channel/myChannel",
                headers: {
                    "content-Type": "application/json",
                }
            }).then(function(response) {
                console.log(response);
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }



        //chat Subscriber listing API
        this.getSubscribersList = function(id) {

            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AppUrl + "channel/userdetails/channel-id/?channelId=" + id,
                headers: {
                    "content-Type": "application/json",
                }
            }).then(function(response) {
                if (response.data.status === 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }



        // Chat subscribers listing API
        this.getchannelUsers = function(channelid) {

            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AppUrl + 'channel/userdetails/channel-id?channelId=' + channelid,
                headers: {
                    "content-Type": "application/json",
                }
            }).then(function(response) {
                defer.resolve(response);
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }


        this.pushChatMessage = function(sender, receiver, message) {

            var data = JSON.stringify({ 'message_from': sender, 'message': message, 'message_to': receiver });

            var form_data = new FormData();
            form_data.append('data', data);

            var defer = $q.defer();
            $http({
                method: "post",
                url: AppConstant.superAdminUrl + "api/v1/message/send",
                data: form_data,
                headers: {
                    "content-Type": undefined,
                },
                transformRequest: angular.identity
            }).then(function(response) {
                defer.resolve(response);
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }

        // -----------------------------------------------------------------------------------------------------------------------
        // Advertisement model APIs starts
        //------------------------------------------------------------------------------------------------------------------------


        // Ads Upload API
        this.adsUpload = function(createAdModel) {

            var defer = $q.defer();
            $http({
                method: "post",
                url: AppConstant.AdsUrl + "process/ad/createAdvertisement",
                data: createAdModel,
                headers: {
                    "Content-Type": undefined,
                },
                transformRequest: angular.identity
            }).then(function(response) {
                console.log(response);
                defer.resolve(response);
                // if (response.data.status == 200) {
                //     defer.resolve(response);
                // } else {
                //     defer.reject(response)
                // }
            },function(error, status) {                
                defer.reject(error);
            });

            return defer.promise;

        }


        // Ads list API 
        this.getAdsList = function() {
            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AdsUrl + "process/ad/myAds",
                headers: {
                    "Content-Type": "application/json",
                }
            }).then(function(response) {
                if (response.data.status == 200) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }


        // User Count API
        this.userCount = function(categoryId, ageGroupId, gender) {
            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AdsUrl + "process/ad/usersCount?categoryId=" + categoryId + "&" + "ageGroupId=" + ageGroupId + "&" + "gender=" + gender,
                headers: {
                    "Content-Type": "application/json",
                }
            }).then(function(response) {
                console.log(response);
                if (response.data.status == 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }


        // ratecard list API 
        this.getRatecardList = function() {
            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AdsUrl + "ad/ratecard/listRateCards?status=1",
                headers: {
                    "Content-Type": "application/json",
                }
            }).then(function(response) {
                console.log(response);
                if (response.data.status == 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }

        // Rate Card amount API
        this.ratecardAmount = function(rateCardId, noOfViews) {
            var defer = $q.defer();
            $http({
                method: "GET",
                url: AppConstant.AdsUrl + "ad/ratecard/getMatchedRate?rateCardId=" + rateCardId + "&" + "noOfViews=" + noOfViews,
                headers: {
                    "Content-Type": "application/json",
                }
            }).then(function(response) {
                console.log(response);
                if (response.data.status == 1) {
                    defer.resolve(response);
                } else {
                    defer.reject(response)
                }
            }, function(error) {
                defer.reject(error)
            });
            return defer.promise;
        }


    //Addvartise status active
        this.activateAdvert = function (adId) {

            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: AppConstant.AdsUrl +"process/ad/start?adId="+adId,
                headers: {
                    "content-Type": undefined,
                },
                transformRequest: angular.identity
            }).then(function(response) {
                console.log(response);
                    deferred.resolve(response);
                },
                function(response) { // optional
                    deferred.reject(response);
                });
            return deferred.promise;
        }

    //Addvartise status deactive
        this.deActivateAdvert= function (adId) {

            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: AppConstant.AdsUrl +"process/ad/stop?adId="+adId,
                headers: {
                    "content-Type": undefined,
                },
                transformRequest: angular.identity
            }).then(function(response) {
                console.log(response);
                    deferred.resolve(response);
                },
                function(response) { // optional
                    deferred.reject(response);
                });
            return deferred.promise;
        }


    }
]);