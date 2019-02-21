
app.factory("BlogFactory", function($q, $http){
    "use strict";
    var factory = {


        LatestArticles: function(){

            console.log(BASE_URL+ "blog.php");
            var deferred = $q.defer();
            $http.get(BASE_URL+ "blog.php?action=latest").then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        },
        
        MostPopular: function(){

            console.log(BASE_URL+ "blog.php");
            var deferred = $q.defer();
            $http.get(BASE_URL+ "blog.php?action=mostpopular").then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        },

        AllArticles: function(){

            console.log(BASE_URL+ "blog.php");
            var deferred = $q.defer();
            $http.get(BASE_URL+ "blog.php?action=all").then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        }

    };

    return factory;
});