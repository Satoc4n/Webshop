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