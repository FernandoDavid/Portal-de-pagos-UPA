<?php
if (isset($_SESSION["toast"])) {
    $toast = explode("/", $_SESSION["toast"]);
    echo '
        <script>
            Toast.fire({
                icon: "' . $toast[0] . '",
                title: "' . $toast[1] . '"
            });
        </script>';
    unset($_SESSION["toast"]);
}
