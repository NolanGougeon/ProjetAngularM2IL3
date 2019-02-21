var app = angular.module('App', ['ngRoute','ngFileUpload']);

app.config(function($routeProvider, $httpProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'accueil.html',
            controller: 'HomeCtrl'
        })
        // .when('/', {
        //     templateUrl: 'vendeur/listes.html',
        //     controller: 'listesCtrl'
        // })
        .when('/user-profile', {
            templateUrl: 'user-profile.html',
            controller: 'userProfilCtrl'
        })
        .when('/users-all', {
            templateUrl: 'admin/users-all.html',
            controller: 'usersCtrl'
        })
        .when('/user-create', {
            templateUrl: 'admin/user-create.html',
            controller: 'createUserCtrl'
        })
        .when('/user-detail/:trigramme', {
            templateUrl: 'admin/user-details.html',
            controller: 'userDetailsCtrl'
        })

        .when('/listes', {
            templateUrl: 'vendeur/listes.html',
            controller: 'listesCtrl'
        })
        .when('/addliste', {
            templateUrl: 'vendeur/addliste.html',
            controller: 'listesCtrl'
        })
        .when('/addlistedetails/:num', {
            templateUrl: 'vendeur/addlistedetails.html',
            controller: 'listesCtrl'
        })
        .when('/editlistedetails/:codeA', {
            templateUrl: 'vendeur/editlistedetails.html',
            controller: 'listesCtrl'
        })
        .when('/listes/:num', {
            templateUrl: 'vendeur/liste_details.html',
            controller: 'listesCtrl'
        })
        .when('/listes/:num/true', {
            templateUrl: 'vendeur/liste_details_true.html',
            controller: 'listesCtrl'
        })
        .when('/parametres', {
            templateUrl: 'admin/parametre.html',
            controller: 'parameterCtrl'
        })
        .when('/listes-view/:idListe', {
            templateUrl: 'vendeur/etiquette.html',
            controller: 'codeCtrl'
        })
        .when('/recap', {
            templateUrl: 'vendeur/recap.html',
            controller: 'recapCtrl'
        })
        .when('/listes-for-vide', {
            templateUrl: 'admin/list-for-vide.html',
            controller: 'WaitDemandeCtrl'
        })
        .when('/articles-sell', {
            templateUrl: 'admin/vendre.html',
            controller: 'vendreArticleCtrl'
        })
        .when('/events', {
            templateUrl: 'admin/events.html',
            controller: 'eventCtrl'
        })
        .when('/addevent', {
            templateUrl: 'admin/addevent.html',
            controller: 'eventCtrl'
        })
        .when('/editevent/:id', {
            templateUrl: 'admin/editevent.html',
            controller: 'eventCtrl'
        })
        .when('/edit', {
            templateUrl: 'admin/edit.html',
            controller: 'editCtrl'
        })
        .otherwise({ redirectTo: '/'});

    $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    $httpProvider.defaults.transformRequest.unshift(function (data, headersGetter) {
        var key, result = [];

        if (typeof data === "string")
            return data;

        for (key in data) {
            if (data.hasOwnProperty(key))
                result.push(encodeURIComponent(key) + "=" + encodeURIComponent(data[key]));
        }
        return result.join("&");
    });




});