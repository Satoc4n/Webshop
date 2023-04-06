<?php
    //session_start() creates a session or resumes the current one based
    // on a session identifier passed via a GET or POST request, or passed via a cookie.
    session_start();
    //session_destroy() destroys all data associated with the current session.
    session_destroy();
    //session_unset() destroys all variables
    session_unset();
    header("Location: index.php");
?>