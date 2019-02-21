app.factory("ListesFactory", function ($q, $http) {

    var factory = {
        // list of services in an agency
        LoadListes: function (trigramme) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "listes.php?action=all&tri="+trigramme).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        
        LoadListesGain: function (trigramme) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "listes.php?action=allGain&tri="+trigramme).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        LoadEvents: function () {
            var deferred = $q.defer();
            $http.get(BASE_URL + "listes.php?action=loadevents").then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        DeleteListe: function (num_liste) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "listes.php?action=delete&num="+num_liste).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        DeleteListeDetails: function (codeA) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "listes.php?action=deletedetails&num="+codeA).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        Addliste: function (trigramme,nom_liste) {
            console.log(" Je suis dans la fonction add du factory et le nom de la liste et le trigramme sont: ");
            console.log(nom_liste);
            console.log(trigramme);
            var deferred = $q.defer();
            $http.post(BASE_URL + "listes.php",{action:"add",trigramme:trigramme,nom_liste:nom_liste,statut:"en cours"}).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        AddListeDetails: function (num_liste,description,prix,taille,commentaire) {
            console.log(" Je suis dans la fonction POUR AJOUTER UN ARTICLE du factory ");
            var deferred = $q.defer();
            $http.post(BASE_URL + "listes.php",{action:"adddetail",num_liste:num_liste,description:description,prix:prix,taille:taille,commentaire:commentaire,statut:"NON FOURNI"}).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        EditListeDetails: function (codeA,description,prix,taille,commentaire) {
            console.log(" Je suis dans la fonction POUR modifier UN ARTICLE du factory ");
            var deferred = $q.defer();
            $http.post(BASE_URL + "listes.php",{action:"editdetail",codeA:codeA,description:description,prix:prix,taille:taille,commentaire:commentaire,statut:"NON FOURNI"}).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        
        LoadListeDetails: function (num_liste) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "listes.php?action=listedetails&num="+num_liste).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        LoadListeBystatus: function (value) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "listes.php?"+value).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        setUpdate: function (data) {
            var deferred = $q.defer();
            $http.post(BASE_URL + "listes.php",data).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },

        setUpdateArticle: function (data) {
            var deferred = $q.defer();
            $http.post(BASE_URL + "article.php",data).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },

        MajListeStatut: function (num_liste,eventselect) {
            console.log(" Je suis dans la fonction maj statut  du factory ET event EST ");
            console.log(eventselect);
            var deferred = $q.defer();
            $http.get(BASE_URL + "listes.php?action=majlistestatut&event="+eventselect+"&num="+num_liste).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
        loadListeDetailsElement: function (codeA) {
            var deferred = $q.defer();
            $http.get(BASE_URL + "listes.php?action=listedetailselement&codeA="+codeA).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },

        setVente: function (data) {
            var deferred = $q.defer();
            $http.post(BASE_URL + "article.php",data).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },

        setRetrait: function (data) {
            var deferred = $q.defer();
            $http.post(BASE_URL + "article.php",data).then(function (data, status) {
                deferred.resolve(data);
            }).catch(function (data) {
                deferred.reject("Impossible de recupere les donnees");
            });
            return deferred.promise;
        },
    };


    return factory;
});