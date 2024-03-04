<?php

function is_authenticate_user()
{

    if (isset($_SESSION['is_authenticate_user']) && $_SESSION['is_authenticate_user'] == true) {
        return true;
    }

    return false;
}


function is_authenticate()
{

    if (isset($_SESSION['is_authenticate']) && $_SESSION['is_authenticate'] == true) {
        return true;
    }

    return false;
}




function show_message_admin()
{

    // for success message
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) { ?>

        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
            <strong>
                <?php

                echo $_SESSION['success'];
                unset($_SESSION['success'])

                ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    <?php

    } // closing of if condition

    // for error message
    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) { ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <strong>
                <?php

                echo $_SESSION['error'];
                unset($_SESSION['error'])

                ?>
            </strong>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
        </div>

    <?php

    } // closing of if condition

} // closing of function block

function show_message()
{

    // for success message
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) { ?>


        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
            <strong>
                <?php

                echo $_SESSION['success'];
                unset($_SESSION['success'])

                ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>


    <?php

    } // closing of if condition

    // for error message
    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) { ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <strong>
                <?php

                echo $_SESSION['error'];
                unset($_SESSION['error'])

                ?>
            </strong>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
        </div>

<?php

    } // closing of if condition

} // closing of function block




function redirect($url)
{

    header("Location: $url");
    exit;
}


function login_admin_name()
{

    if (isset($_SESSION['admin_name']) && !empty($_SESSION['admin_name'])) {
        return $_SESSION['admin_name'];
    }

    return '';
}

function login_name()
{

    if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
        return $_SESSION['name'];
    }

    return '';
}

function login_admin_user_name()
{

    if (isset($_SESSION['admin_user_name']) && !empty($_SESSION['admin_user_name'])) {
        return $_SESSION['admin_user_name'];
    }

    return '';
}

function login_user_name()
{

    if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
        return $_SESSION['user_name'];
    }

    return '';
}

function login_email()
{

    if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
        return $_SESSION['email'];
    }

    return '';
}

function login_user_profile_image()
{

    if (isset($_SESSION['profile_image']) && !empty($_SESSION['profile_image'])) {
        return $_SESSION['profile_image'];
    }

    return '';
}

function login_admin_id()
{

    if (isset($_SESSION['login_admin_id']) && !empty($_SESSION['login_admin_id'])) {
        return $_SESSION['login_admin_id'];
    }

    return '';
}

function login_id()
{

    if (isset($_SESSION['login_id']) && !empty($_SESSION['login_id'])) {
        return $_SESSION['login_id'];
    }

    return '';
}

?>