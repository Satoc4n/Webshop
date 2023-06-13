function openNav() {
    document.getElementById("mySidenav").style.width  = "250px";
}
function closeNav() {
    document.getElementById("mySidenav").style.width  = "0";
}
function toggleVisibility() {
    let x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    }
    else {
        x.type = "password";
    }
}
function callEnable2FA() {
    $.ajax({url: "enable2fa.php", success:function(result) {
        $("div").text(result);
        }})
}
// Compare password fields in register.html
function check () {
    let input = document.getElementById('password_confirm');
    if (input.value != document.getElementById('password').value) {
        input.setCustomValidity('Password must be matching');
    }
    else {
        input.setCustomValidity('');
    }
}
function updateUserActivity() {
    $.ajax({
        url: 'update_activity.php',
        method: 'POST',
        success: function (reponse) {

        }
    });
}
setInterval((updateUserActivity, 300));

function updateOnlineUsersCount() {
    $.ajax({
        url: 'get_online_users_count.php',
        method: 'GET',
        success: function (response) {
            $('#online-users-count').text(reponse);
        }
    });
}
updateOnlineUsersCount();
setInterval(updateOnlineUsersCount, 300);

let stillAlive = setInterval((async function ping() {
    await fetch("stillAlive.php");
    setTimeout(ping, 60000)
}));