

  function notif (type, text , titre, position) {
    var msg = text;
    var title = titre;
    var showDuration = '2000';
    var hideDuration = '1000';
    var timeOut = '3000';
    var extendedTimeOut = '1000';
    var showEasing = 'swing';
    var hideEasing = 'linear';
    var showMethod = 'fadeIn';
    var hideMethod = 'fadeOut';
    // var toastIndex = toastCount++;
    var addClear = false;

    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        // positionClass: 'toast-top-full-width',
        positionClass:position,
        preventDuplicates: false,
        onclick: null
    };


    if (showDuration) {
        toastr.options.showDuration = showDuration;
    }

    if (hideDuration) {
        toastr.options.hideDuration = hideDuration;
    }

    if (timeOut) {
        toastr.options.timeOut = addClear ? 0 : timeOut;
    }

    if (extendedTimeOut) {
        toastr.options.extendedTimeOut = addClear ? 0 : extendedTimeOut;
    }

    if (showEasing) {
        toastr.options.showEasing = showEasing
    }

    if (hideEasing) {
        toastr.options.hideEasing = hideEasing
    }

    if (showMethod) {
        toastr.options.showMethod = showMethod;
    }

    if (hideMethod) {
        toastr.options.hideMethod = hideMethod
    }


    var $toast = toastr[type](msg, title);

};
