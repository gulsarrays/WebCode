angular.module('bushfireApp').controller('datepickerController', function($scope) {
    'use strict';
    $scope.adStartDate = new Date();
    $scope.adStartDatePickerOpen = false;
    $scope.adEndDate = new Date();
    $scope.adEndDatePickerOpen = false;

    $scope.openAdStartDatePicker = function($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.adStartDatePickerOpen = !$scope.adStartDatePickerOpen;
    };

    $scope.openAdEndDatePicker = function($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.adEndDatePickerOpen = !$scope.adEndDatePickerOpen;
    };
});