<?php
session_start();
$permissions = ["guest", "instructor", "admin"];

if (isset($page_permission)) {
    // Check if the user is logged in and has a valid user role
    if (isset($_SESSION["userrole"]) && in_array($_SESSION["userrole"], $permissions)) {
        $current_permission = array_search($_SESSION["userrole"], $permissions);

        // Check if the user has the required permission to access the page
        if ($current_permission < $page_permission) {
            echo '<script>
                window.onload = function() {
                    swal_callback("Access Denied!", "You don\'t have permission to access this page.\nPlease login as an '. $permissions[(int)$page_permission] .'.", "warning", "Go Back", function(confirmed) {
                        if (confirmed) {
                            window.location.href = (document.referrer !== "") ? document.referrer : "/login/";
                        }
                    });
                    var tableContent = document.getElementById("table_content");
                    if (tableContent) {
                        tableContent.parentNode.removeChild(tableContent);
                    }
                };
            </script>';
        }
    } else {
        // Handle the case where the user is not logged in or has an invalid role
        echo '<script>
            window.onload = function() {
                swal_callback("Access Denied!", "You must be logged in with a valid role to access this page.", "warning", "Go Back", function(confirmed) {
                    if (confirmed) {
                        window.location.href = (document.referrer !== "") ? document.referrer : "/login/";
                    }
                });
                var tableContent = document.getElementById("table_content");
                if (tableContent) {
                    tableContent.parentNode.removeChild(tableContent);
                }
            };
        </script>';
    }
}
?>
