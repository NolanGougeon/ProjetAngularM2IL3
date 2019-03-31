app.factory("Session" , function($q, $http, $location){

    var factory = {

        isLogged :  function () {
            try {

                var session = JSON.parse(window.localStorage.getItem("user_session"));
                if(session === null) {
                    window.location.href="/ProjetAngularM2IL3/vitrine-front/";
                    // $location.path("/ProjetAngularM2IL3/vitrine-front/");
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
