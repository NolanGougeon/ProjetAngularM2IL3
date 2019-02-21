app.controller("contactCtrl", function ($scope) {

    function initMap() {
        // The location of Uluru
        var GlazikGym = {lat: 48.098864, lng: -3.993857};
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 4, center: GlazikGym});
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({position: GlazikGym, map: map});
    }



    // try{
    //
    //     function initMap() {
    //
    //         var location = {
    //             lat: 48.098864,
    //             lng: -3.993857
    //         }; // Here is the Location lat, lng .
    //
    //         var map = new google.maps.Map(document.getElementById("map"), {
    //             zoom: 9,
    //             scrollwheel: false,
    //             center: location,
    //         });
    //         var marker = new google.maps.Marker({
    //             position: map.getCenter(),
    //             icon: '..public/img/icon/maplock.png',
    //             map: map
    //         });
    //     }
    // }catch (error){
    //     console.error(error);
    // }
        console.log(" hello Contoller Contact");
});