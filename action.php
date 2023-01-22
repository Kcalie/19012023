<?php 
session_start();
require('core/function.php');
switch($_GET['e'])
{
    case 'connexion':
        if(isset($_POST['submit']))
        {
            if(!empty($_POST['login']) && !empty($_POST['password']))
            {
                // regarde si le login et le password existe
                if(verifConnect($_POST['login'],$_POST['password']))
                {
                    $_SESSION['connect'] = 1;
                    setcookie('login',$_POST['login'],(time()+3600));
                    setcookie('password',$_POST['password'],(time()+3600));
                    header('location:prive.php');
                    exit;
                }  
                else
                {
                    $message = 'login ou mot de passe incorrect';
                }
            }
            else
            {
                $message = 'Veuillez renseigner un login et mot de passe';
            }
            header('location:membres.php?message='.urlencode($message));
            exit;
        }/*This is a switch statement in PHP that checks the value of the "e" GET parameter. It checks if the value of the "e" parameter is "connexion". If the "e" parameter is "connexion", it then checks if the "submit" POST parameter is set. If the submit parameter is set, it checks if the "login" and "password" POST parameters are not empty.
If they are not empty, then it calls a function named "verifConnect" with the "login" and "password" POST parameters as arguments.
The function verifConnect is likely to check if the login and password provided by the user match with a user in the database, it returns true if the login and password match, otherwise returns false.
If the verifConnect function returns true, it sets the "connect" key in the $_SESSION superglobal variable to 1, sets the "login" and "password" cookies with the login and password provided by the user, and then redirects the user to the "prive.php" page.
If the verifConnect function returns false, it sets the $message variable to "login ou mot de passe incorrect" and redirects the user to the "membres.php" page with the message variable as a GET parameter.
If the "login" and "password" POST parameters are empty, it sets the $message variable to "Veuillez renseigner un login et mot de passe" and redirects the user to the "membres.php" page with the message variable as a GET parameter.
This code is likely used to handle user login, it's important to note that it is not secure to store the password in a cookie and it is recommended to use a secure way of storing the user's session such as using secure tokens or a secure session management library. It's also important to validate the user input and use a secure way of storing the password in the database such as using a secure hashing algorithm.*/ 

    break;

    case 'deco':

        $_SESSION['connect'] = 0;
        setcookie('login',null,(time()-10));
        setcookie('password',null,(time()-10));
        header('location:membres.php');

        break;/*This is a case statement in the switch block that checks if the value of the "e" GET parameter is "deco". If the case statement is entered, it sets the "connect" key in the $_SESSION superglobal variable to 0, sets the "login" and "password" cookies to null and the time to a negative value, this effectively deletes the cookies.
        Then it redirects the user to the "membres.php" page.
        This code is likely used as a logout function, it's important to note that it only sets the session and cookies to null but it doesn't destroy the session or unset the variables, this could make the session vulnerable to session hijacking.
        It's also important to validate the user is actually logged in before allowing them to log out and properly destroy the session and cookies.
        It's also important to note that the time value of -10 is not a recommended way of deleting cookies as it may not work in all browsers, it's recommended to use the setcookie function with an expired date in the past or use the unset() function.*/ 

    case 'upload':

        if(isset($_POST['submit']))
        {
            // verif si un fichier a été envoyer
            if(is_uploaded_file($_FILES['fichier']['tmp_name']) || is_uploaded_file($_FILES['fichier2']['tmp_name']))
            {
                $etat_fichier = uploadFichier($_FILES['fichier']);
                $etat_fichier2 = uploadFichier($_FILES['fichier2']);
                if($etat_fichier && $etat_fichier2)
                {
                    $message = 'Fichiers envoyés avec succès';
                    header('location:prive.php?message='.urlencode($message));
                }
            }
            else if(is_uploaded_file($_FILES['fichier']['tmp_name']) && !is_uploaded_file($_FILES['fichier2']['tmp_name']))
                {
                    $etat_fichier = uploadFichier($_FILES['fichier']);
                    if($etat_fichier)
                    {
                        $message = 'Le fichier a été envoyé avec succès';
                        header('location:prive.php?message='.urlencode($message));
                    }
                }
            else if(!is_uploaded_file($_FILES['fichier']['tmp_name']) && is_uploaded_file($_FILES['fichier2']['tmp_name']))
            {
                $etat_fichier = uploadFichier($_FILES['fichier2']);
                if($etat_fichier2)
                {
                    $message = 'Le fichier a été envoyé avec succès';
                    header('location:prive.php?message='.urlencode($message));
                }
            }
            $message = 'Il y a un problème avec l\'envoi des fichiers';
            header('location:prive.php?message='.urlencode($message));
        }
        break;/*This is a case statement in the switch block that checks if the value of the "e" GET parameter is "upload". If the case statement is entered, it checks if the "submit" POST parameter is set. If the "submit" POST parameter is set, it then checks if the "fichier" and "fichier2" files have been uploaded using the PHP built-in function is_uploaded_file().
        If both files have been uploaded, it calls a function named "uploadFichier" with the "fichier" and "fichier2" as arguments.
        Then it checks if both the returned values of the function are true, if so, it sets the message variable to "Fichiers envoyés avec succès" and redirects the user to the "prive.php" page with the message variable as a GET parameter.
        If only the first file has been uploaded, it calls the function "uploadFichier" with the "fichier" as argument, then it checks if the returned value of the function is true, if so, it sets the message variable to "Le fichier a été envoyé avec succès" and redirects the user to the "prive.php" page with the message variable as a GET parameter.
        If only the second file has been uploaded, it calls the function "uploadFichier" with the "fichier2" as argument, then it checks if the returned value of the function is true, if so, it sets the message variable to "Le fichier a été envoyé avec succès" and redirects the user to the "prive.php" page with the message variable as a GET parameter.
        If none of the files have been uploaded, it sets the message variable to "Il y a un problème avec l'envoi des fichiers" and redirects the user to the "prive.php" page with the message variable as a GET parameter.
        This code is likely used to handle file uploads, it's important to note that it does not check for the file type, size and extension before uploading, it's recommended to do this validation before uploading the files to prevent any security issues such as file injection or buffer overflow. It's also important to check if the user is authenticated before allowing them to upload files and to use a secure way to store the files on the server.*/ 

    case 'deletefichier':
            if(!empty($_GET['fichier']))
            {
                unlink('upload/'.$_COOKIE['login'].'/'.$_GET['fichier']);
                header('location:prive.php');
                exit;
            }
        break;/*This is a case statement in the switch block that checks if the value of the "e" GET parameter is "deletefichier". If the case statement is entered, it checks if the "fichier" GET parameter is not empty.
        If the "fichier" GET parameter is not empty, it uses the PHP built-in function unlink() to delete the file from the "upload" directory followed by the user's login name, which is retrieved from the cookie, and the file name is passed as a parameter to the function. It then redirects the user to the "prive.php" page.
        This code is likely used to handle file deletion, it's important to note that it does not check for the authenticity of the user and therefore could be vulnerable to malicious users manipulating the cookies or the directory path. It is also important to validate the user's permission to delete the files, and the type of file before deleting it. It's also important to check if the user is authenticated before allowing them to delete files.*/
}
?>
