app.controller("listesCtrl", function ($scope,$routeParams,ListesFactory, Login,Session,$http,Upload) {
    $scope.session =  Session.isLogged();
    try {
        var tri = $scope.session.trigramme;
        var num_liste = $routeParams.num;
        var codeA=$routeParams.codeA;
        $scope.num_liste=$routeParams.num;
    } catch (error) {
            console.log(error)
    }

    try {
        ListesFactory.LoadListes(tri).then(function (response) {

               $scope.listes= response.data;
               // console.log(response.data);
        });
    } catch (ex) {
     console.error(ex)
    }
    try {
        ListesFactory.LoadEvents().then(function (response) {
               $scope.events= response.data;
               // console.log(response.data);
        });
    } catch (ex) {
        console.error(ex);
    }

     try{
        if (num_liste) {
            ListesFactory.LoadListeDetails(num_liste).then(function (response) {
                $scope.listesdetails= response.data;
                for(var k =0 ;  k < $scope.listesdetails.length ; ++k) {
                    if( $scope.listesdetails[k].photo !== null) {
                        $scope.listesdetails[k].photo = BASE_FILE +""+$scope.listesdetails[k].photo;
                    } else {
                        $scope.listesdetails[k].photo = BASE_FILE +"icon-standard.png";
                    }
                }
                console.log($scope.listesdetails);
                Login.getParameters().then(function (res) {
                    if(res.data.success){
                        $scope.parameters = res.data.data;
                        if($scope.listesdetails.length==parseInt($scope.parameters.nombre_article)){
                            $scope.burnOut=true;
                        } else {
                            $scope.burnOut=false;
                        }

                        if($scope.listesdetails.length==0){
                            $scope.empty = true;
                        } else {
                            $scope.empty = false;
                        }
                    } else {
                        $scope.burnOut=false;
                    }
                });
            });
        }
    } catch (ex) {
        console.error(ex);
    }

    try {
        ListesFactory.loadListeDetailsElement(codeA).then(function (response) {
            $scope.thisarticle=response.data[0];
            console.log("le thisarticle trouve est ");
            console.log(response.data[0]);
            //window.location.href
        });
    } catch (ex) {
        console.error(ex);
    }

    $scope.DeleteListe= function(num_liste){
        try{
            ListesFactory.DeleteListe(num_liste).then(function (response) {
                // if(response.data.valide){
                //     toaster.pop({
                //         type: 'sucess',
                //         title: 'Parfait !',
                //         body: response.data.message,
                //         timeout: 1500
                //     });
                // }
                console.log(response.data);
                //window.location.href
                notif('success','C\'est parfait !','SUPPRESSION DE LISTE','toast-top-full-width');
                window.location.href="#/listes";
            });
        } catch (ex) {
            console.error(ex);
        }
     }
     $scope.DeleteListeDetails= function(codeA){
        try{
        ListesFactory.DeleteListeDetails(codeA).then(function (response) {
                // if(response.data.valide){
                //     toaster.pop({
                //         type: 'sucess',
                //         title: 'Parfait !',
                //         body: response.data.message,
                //         timeout: 1500
                //     });
                // }
                console.log(response.data);
                notif('success','Suppression effectuée avec succès !','SUPPRESSION D\'ARTICLE','toast-top-full-width');
                //console.log("fksdngksj");
                //window.location.href="#/listes/"+num_liste;
            });
        }catch (ex){
            console.error(ex);
        }
     }

    $scope.AddListe= function(nom_liste){
         console.log(" Je suis dans la fonction add du controller et le nom de la liste est ");
         console.log(nom_liste);
         console.log(tri);
        try {
        ListesFactory.Addliste(tri,nom_liste).then(function (response) {

                // if(response.data.valide){
                //     toaster.pop({
                //         type: 'sucess',
                //         title: 'Parfait !',
                //         body: response.data.message,
                //         timeout: 1500
                //     });
                // }
                console.log(response.data);
                notif('success','Liste ajoutée avec succès !','AJOUT DE LISTE','toast-top-full-width');
                window.location.href="#/listes";
            });
        } catch (ex) {
            console.error(ex)
        }
    };

    $scope.AddListeDetails= function(data){
         data.num_liste = num_liste;
         data.prix= parseInt(data.prix);
         if($scope.verifyData(data)){
             console.log($scope);
             $scope.upload($scope.file, data);
         }
    };

    function matchXly(data , regex) {
    for(var k=0 ; k < data.length ; ++k){
        if(data[k].match(regex) === null){
            return false ;
        }
    }

        return true;
    };

     $scope.verifyData = function (data) {
        var regex = /[X S M L]/g ;
        var regexcom = /'|"/g;
        data.taille = data.taille.toUpperCase();
        data.commentaire = data.commentaire.replace(regexcom," ");
        if(isNaN(parseInt(data.prix)) || parseInt(data.prix)=== undefined || ! matchXly(data.taille ,regex)) {
            notif('error','Veuillez renseigner les champs recquis','Form','toast-top-right');

            return false;
        }

         return true;
     };

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
                $('#blah').css('background-image',  e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
        console.log("on change");
    });

    $scope.EditListeDetails= function(description,prix,taille,commentaire){
        console.log(" Je suis dans la fonction edit liste detail du controller ET NUM LISTE EST xxx");
        console.log(description);
        try{
           ListesFactory.EditListeDetails(codeA,description,prix,taille,commentaire).then(function (response) {

                   console.log(response.data);
                   notif('success','Article modifié avec succès !','MODIFICATION D\'ARTICLE','toast-top-full-width');
               });
        } catch (ex) {
            console.error(ex);
        }
    };

    $scope.MajListeStatut= function(num_liste,eventselect){
        console.log(" Je suis dans la fonction maj  du controller ET event EST ");
        console.log(eventselect);
       try{
           ListesFactory.MajListeStatut(num_liste,eventselect).then(function (response) {
                   console.log(response.data);
                   notif('success','Soumission faite avec succès !','SOUMISSION DE LISTE','toast-top-full-width');
                   window.location.href="#/listes";
               });
        } catch(ex) {
            console.error(ex)
        }
    };

    $scope.changeStatus = function (data) {
        data.action="UPDATE";
        data.critere="statut";
        data.statut="FOURNI";
        ListesFactory.setUpdateArticle(data).then(function (response) {
            if(response.data.success){
                notif('success',response.data.message,'Article','toast-top-full-width');
            }else{
                notif('error',response.data.message,'Article','toast-top-full-width')
            }
        });
    };

    $scope.upload = function (file , object) {
        Upload.upload({
            url:  BASE_URL +'article.php',
            data: {file: file, action:'FILE', data:object}
        }).then(function (resp) {
            if(resp.data.success){
                notif('success','Article ajouté avec succès !','AJOUT D\'ARTICLE','toast-top-full-width');
                window.location.href="#/listes/"+num_liste;
            } else {
                notif('error','Erreur d\'ajout ','AJOUT D\'ARTICLE','toast-top-full-width');
            }
        }, function (resp) {
            console.log('Error status: ' + resp.status);
        }, function (evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            // console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });
    };

    $(document).ready(function() {
        $('form').parsley();
    });

    if ($('#paypal-button-container').length) {
        ListesFactory.LoadListeDetails(num_liste).then(function (response) {
            var listeDetails = response.data;
            var total = 0;

            // Le vendeur doit payer x euros par articles qu'il compte mettre en vente.
            Login.getParameters().then(function (res) {
                total = listeDetails.length * res.data.data.montant_article;
            });

            paypal.Buttons({
                createOrder: function(data, actions) {
                    // Set up the transaction
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: total
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    // Capture the funds from the transaction
                    return actions.order.capture().then(function(details) {
                        ListesFactory.addPaiement(num_liste, $scope.session.trigramme, total, 'paypal');
                        var query = {};
                        query.numListe = num_liste;
                        query.action = "UPDATE";
                        query.critere = "statut";
                        query.type = "ONLYONE";
                        query.statut = "acceptee";
                        ListesFactory.setUpdate(query);
                        window.location.href="#/listes";
                    });
                }
            }).render('#paypal-button-container');
        });
    }

    // for(var i=0;i=5;i++){
    //     console.log(i);
    // }

});
