app.factory("BlogdetailsFactory", function($q, $http){
    "use strict";
    var factory = {


        GetArticle: function(id_article){

            console.log(BASE_URL+ "blog.php");
            var deferred = $q.defer();
            $http.get(BASE_URL+ "blog.php?action=selected&id="+id_article).then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        },
        AddComment: function(name,email,texte,id_article){

            console.log(BASE_URL+ "blog.php");
            var deferred = $q.defer();
            $http.post(BASE_URL+ "blog.php", {action:"addcomment",id_art:id_article,name:name,email:email,texte:texte}).then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        },
        GetComment: function(id_article){

            console.log(BASE_URL+ "blog.php");
            var deferred = $q.defer();
            $http.get(BASE_URL+ "blog.php?action=selectedComment&id="+id_article).then(function(data, status){
                deferred.resolve(data);
            }).catch(function(data, status){
                deferred.reject("impossible de recevoir les data");
            });
            return deferred.promise;
        },

    };

    return factory;
});