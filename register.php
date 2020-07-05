<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/User.php");

// if register form is submitted and not empty
if (!empty($_POST['register'])) {
    // check if email is filled out
    if (!empty($_POST['email'])) {
        // check for thomas more email
        $verifyEmail = new User();
        $email = $_POST['email'];
        $verifyEmail->setEmail($email);
        $resultEmail = $verifyEmail->validateEmail($email);

        // if thomas more email = ok
        if ($resultEmail == 1) {
            // check if email is not taken
            $emailAvailable = new User();
            $emailAvailable->setEmail($email);
            $available = $emailAvailable->emailAvailable($email);
            if ($available == 1) {
                // check if password and verifypassword are the same
                if (!empty($_POST['password']) && $_POST['password'] === $_POST['confirmPassword']) {
                    //check if password length is ok
                    $verifyPassword = new User();
                    $password = $_POST['password'];
                    $verifyPassword->setPassword($password);
                    $resultPassword = $verifyPassword->validatePassword($password);

                    if ($resultPassword == 1) {
                        // register the user
                        $user = new User();
                        $firstname = $_POST['firstname'];
                        $lastname = $_POST['lastname'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $user->setFirstname($firstname);
                        $user->setLastname($lastname);
                        $user->setEmail($email);
                        $user->setPassword($password);
                        $register = $user->register($email, $password, $firstname, $lastname);

                        // start a session for the currently logged in user
                        session_start();
                        $_SESSION['user'] = $userID;
                        header("Location: index.php");
                    } else {
                        echo "Password too short.";
                    }
                } else {
                    echo "Password doesn't match.";
                }
            } else {
                echo "Email taken.";
            }
        } else {
            echo "Only Thomas More emails please.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="firstname">First name</label>
            <input type="text" name="firstname" id="firstname">
        </div>

        <div>
            <label for="lastname">Last name</label>
            <input type="text" name="lastname" id="lastname">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <div>
            <label for="confirmPassword">Confirm password</label>
            <input type="password" name="confirmPassword" id="confirmPassword">
        </div>

        <div>
            <input type="submit" value="Sign up" name="register" id="register">
        </div>
    </form>
</body>

</html>