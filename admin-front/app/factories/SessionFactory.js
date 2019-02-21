app.factory("Session" , function($q, $http, $location){

    var factory = {

        isLogged :  function () {
            try {

                var session = JSON.parse(window.localStorage.getItem("user_session"));
                if(session === null) {
                    window.location.href="/Gla-Vide-Grenier/vitrine-front/";
                    // $location.path("/Gla-Vide-Grenier/vitrine-front/");
                }
                session = session[0];
                return session;
            } catch (error) {
                console.log(error)
            }
        },

    };
    return factory;
});