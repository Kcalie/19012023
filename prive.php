<?php 
session_start();
require('core/function.php');
if($_SESSION['connect'] != 1 && (empty($_COOKIE['login']) || empty($_COOKIE['password'])))
{
    $message = 'Vous devez vous reconnectez';
    header('location:membres.php?message='.urlencode($message));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur l'espace membres</title>
</head>
<body>
    
    <?php include('inc/header.php'); ?>

    <h1>bonjour <?php echo $_COOKIE['login']; ?></h1><!--This PHP code outputs the string "bonjour " followed by the value of a cookie named 'login'. If the cookie does not exist, it will output an error message. This can be used to personalize a greeting for a user on a website, for example, if the cookie is set after a successful login, it will greet the user by their username. It's important to note that the output of this code will depend on the client's cookies, and that it is necessary to check whether the cookie is set and if it is not, handle it accordingly.-->

    <?php 
    // on recup l'ensemble des fichiers
    $liste_fichiers = scandir('upload/'.$_COOKIE['login']);
    if($liste_fichiers)
    {
        echo '<ul>';
        $i=0;
        foreach($liste_fichiers as $fichier)
        {
            if($i>1)
            {
                echo '<li><a href="upload/'.$_COOKIE['login'].'/'.$fichier.'" target="_blank">'.$fichier.'</a><a href="action.php?e=deletefichier&fichier='.$fichier.'"><img src="assets/images/corbeille.png"><a/></li>';
            }
            $i++;
        }
        echo '<ul>';
    }
    ?><!--This PHP code uses the scandir function to get an array of all files in a directory called 'upload' and then the user's login name.It then checks if the list of files is not empty, if so, it creates an unordered list and loops through each file in the list.
    It starts at index 2, because the first two elements of the array returned by scandir are "." and ".." which are not actual files.
    For each file, it creates a list item with a link to the file and a link to delete the file. The link to the file is set to open in a new tab and target="_blank" and the delete link is calling the action.php file and passing the parameters e=deletefichier and fichier which presumably this script uses to delete the file.
    It is important to note that the code does not check for the authenticity of the user and therefore could be vulnerable to malicious users manipulating the cookies or the directory path. It is also important to validate the user's permission to access the files and validate the file type before displaying it.-->

    <form method="post" action="action.php?e=upload" enctype="multipart/form-data">
        <label for="fichier">ajouter un fichier</label>
        <input type="file" name="fichier" />
        <br />
        <label for="fichier2">Ajouter un fichier</label>
        <input type="file" name="fichier2">
        <button type="submit" name="submit">Envoyer</button>
    </form>

    <a href="action.php?e=deco">Se deconnecter</a><!--An HTML link that redirects the user to the "action.php" file and sends the GET parameter "e" with the value "deco". This link is likely used as a logout button or to disconnect the user from the website. The script in the action.php file could have a switch statement that checks for the value of "e" and performs different actions depending on the value. In this case, it's likely that it will destroy the session and/or cookies and redirects the user to the login page. It is important to validate the user is actually logged in before allowing them to log out and properly destroy the session and cookies to prevent session hijacking.-->
    <?php include('inc/footer.php'); ?>
    
</body>
</html>