(function(name, definition) {
    if (typeof module != 'undefined') {
      module.exports = definition();
    } else if (typeof define == 'function' && typeof define.amd == 'object') {
      define(definition);
    } else {
      this[name] = definition();
    }
  }('Router', function() {
  return {
    routes: [{"uri":"\/","name":"landing"},{"uri":"rates","name":"rates"},{"uri":"services","name":"services"},{"uri":"services\/create","name":"services.create"},{"uri":"services\/{id}","name":"services.show"},{"uri":"services\/{id}\/edit","name":"services.edit"},{"uri":"services","name":"services.store"},{"uri":"csv2db","name":"csv2db"},{"uri":"listContracts","name":"listContracts"},{"uri":"listSearchContracts","name":"listSearchContracts"},{"uri":"addContract","name":"addContract"},{"uri":"updateContract","name":"updateContract"},{"uri":"showContract","name":"showContract"},{"uri":"saveContract","name":"saveContract"},{"uri":"getResionsForSupplier","name":"getResionsForSupplier"},{"uri":"getSuppliersForResion","name":"getSuppliersForResion"},{"uri":"getServiceDataForContract","name":"getServiceDataForContract"},{"uri":"getServiceDataForSeason","name":"getServiceDataForSeason"},{"uri":"getServiceDataForSeasonPeriod","name":"getServiceDataForSeasonPeriod"},{"uri":"getAllChargingPolicies","name":"getAllChargingPolicies"},{"uri":"getAllMealPlans","name":"getAllMealPlans"},{"uri":"getServiceSeasonPeriodsData","name":"getServiceSeasonPeriodsData"},{"uri":"getAllCurrencies","name":"getAllCurrencies"},{"uri":"getAllOccupancies","name":"getAllOccupancies"},{"uri":"viewService","name":"viewService"},{"uri":"getPriceBandAndWeekPriceData","name":"getPriceBandAndWeekPriceData"},{"uri":"linkOptionsWithExtras","name":"linkOptionsWithExtras"},{"uri":"getExtrasWithIsMandatoryForOption","name":"getExtrasWithIsMandatoryForOption"},{"uri":"deleteWeekPrices","name":"deleteWeekPrices"},{"uri":"deletePriceBands","name":"deletePriceBands"}],
    route: function(name, params) {
      var route = this.searchRoute(name),
          rootUrl = this.getRootUrl(),
          result = "",
          compiled = "";

      if (route) {
        compiled = this.buildParams(route, params);
        result = this.cleanupDoubleSlashes(rootUrl + '/' + compiled);
        result = this.stripTrailingSlash(result);
        return result;
      }

    },
    searchRoute: function(name) {
      for (var i = this.routes.length - 1; i >= 0; i--) {
        if (this.routes[i].name == name) {
          return this.routes[i];
        }
      }
    },
    buildParams: function(route, params) {
      var compiled = route.uri,
          queryParams = {};

      for (var key in params) {
        if (compiled.indexOf('{' + key + '?}') != -1) {
          if (key in params) {
            compiled = compiled.replace('{' + key + '?}', params[key]);
          }
        } else if (compiled.indexOf('{' + key + '}') != -1) {
          compiled = compiled.replace('{' + key + '}', params[key]);
        } else {
          queryParams[key] = params[key];
        }
      }

      compiled = compiled.replace(/\{([^\/]*)\?}/g, "");

      if (!this.isEmptyObject(queryParams)) {
        return compiled + this.buildQueryString(queryParams);
      }

      return compiled;
    },
    getRootUrl: function() {
      return window.location.protocol + '//' + window.location.host;
    },
    buildQueryString: function(params) {
      var ret = [];
      for (var key in params) {
        ret.push(encodeURIComponent(key) + "=" + encodeURIComponent(params[key]));
      }
      return '?' + ret.join("&");
    },
    isEmptyObject: function(obj) {
      var name;
      for (name in obj) {
        return false;
      }
      return true;
    },
    cleanupDoubleSlashes: function(url) {
      return url.replace(/([^:]\/)\/+/g, "$1");
    },
    stripTrailingSlash: function(url) {
      if(url.substr(-1) == '/') {
        return url.substr(0, url.length - 1);
      }
      return url;
    }
  };
}));