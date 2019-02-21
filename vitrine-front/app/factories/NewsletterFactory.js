app.factory("NewsletterFactory", function($q, $http){
    "use strict";
    var factory = {


        addMail: function(datanewsletteremail){
            
            console.log(BASE_URL+ "newsletter.php");
            var deferred = $q.defer();
            $http.get(BASE_URL+ "newsletter.php?mail="+datanewsletteremail).then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        }
    };

    return factory;
});

