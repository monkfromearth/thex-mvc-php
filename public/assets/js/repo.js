$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip(); 

});

// Created Functions

// Get Cookies

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

// Notifications

document.addEventListener('DOMContentLoaded', function () {
    if (Notification.permission !== "granted")
        Notification.requestPermission();
});

function notify(title, message, link) {
    if (!Notification) {
        return;
    }
    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        var notification = new Notification(title, {
            icon:icon,
            body:message,
        });
        notification.onclick = function () {
            window.open(link);      
        };
    }
}