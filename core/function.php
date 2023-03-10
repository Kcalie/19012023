<?php
$menu_footer = array(
    'mentions.php' => 'Mentions légales',
    'contact.php' => 'Nous contacter'
);/*This is a PHP code that creates an array called $menu_footer. The array contains two elements, each element is a key-value pair.
The first element has the key "mentions.php" and the value "Mentions légales", the second element has the key "contact.php" and the value "Nous contacter".
It's likely that this array is used to create a menu or a navigation list in the website's footer. The keys of the array are probably used as the URLs of the links and the values are used as the labels of the links.
It's important to note that this array is static, so if you want to add or modify the links, you will have to do it in the code and not dynamically.*/

// on définit l'emplacement par défaut dans le header
function afficheMenu($emplacement='header')
{
    $str = '<ul>';
    if($emplacement=='header')
    {
        $menu_header = array(
            'index.php' => 'Accueil',
            'membres.php' => 'Espaces membres',
            'contact.php' => 'Nous Contacter'
        );
        // boucle for each: dans menu header chercher lien retourner titre selon le modèle du tableau
        foreach($menu_header as $lien => $titre)
        {
            $str.= '<li><a href="'.$lien.'">'.$titre.'</a></li>';
        }
    }
    else if($emplacement=='footer')
    {
        global $menu_footer;
        foreach($menu_footer as $lien => $titre)
        {
            $str.= '<li><a href="'.$lien.'">'.$titre.'</a></li>'; 
        }
    }
    $str.= '<ul>';
    return $str;
}/*PHP function named "afficheMenu" that takes an optional parameter "emplacement" with a default value of "header".The function starts by creating an empty string variable named $str, then it concatenates an opening <ul> tag to it.
It then checks the value of the "emplacement" parameter, if it's equal to "header", it creates a local array called $menu_header which contains three elements, each element is a key-value pair.
The first element has the key "index.php" and the value "Accueil", the second element has the key "membres.php" and the value "Espaces membres", the third element has the key "contact.php" and the value "Nous Contacter".
The function then uses a foreach loop to go through each element of the array, it concatenates an <li> tag containing an <a> tag with the key as the href attribute and the value as the inner HTML to the $str variable.
If the "emplacement" parameter is "footer" the function uses the global $menu_footer array and use a foreach loop to go through each element of the array, it concatenates an <li> tag containing an <a> tag with the key as the href attribute and the value as the inner HTML to the $str variable.
At the end of the function, it concatenates a closing <ul> tag to the $str variable and return the final string.
This function is likely used to create a navigation menu in the website's header or footer, it takes the emplacement parameter to decide which menu array to use, and returns a string that contains the HTML code for the menu.
It's important to note that the function doesn't check the emplacement parameter and create the appropriate menu, but it doesn't check if the emplacement parameter passed is a valid one, it only checks if it's "header" or "footer". If a different value is passed, it will not create any menu. It is also important to validate user's permission to see certain links, and check if the user is authenticated before displaying certain links.*/

$identifiants = array('admin','kevin','jessica');
$motdepasses = array('12345','css');
function verifConnect($login,$password)
{
    global $identifiants;
    global $motdepasses;
    if(in_array($login,$identifiants) && in_array($password,$motdepasses))
    {
        return true;
    }
    else{
        return false;
    }
}/*This is a PHP code that defines two arrays: $identifiants and $motdepasses, and a function called verifConnect.The $identifiants array contains three strings: 'admin', 'kevin', and 'jessica'. The $motdepasses array contains two strings: '12345' and 'css'
The verifConnect function takes two parameters: $login and $password. It starts by using the global statement to bring the $identifiants and $motdepasses arrays into the function's scope.
Then it uses the in_array() function to check if the $login and $password passed as arguments are present in the $identifiants and $motdepasses arrays, respectively.
If both values are present in the arrays, it returns true. If either of them is not present, it returns false.
This function is likely used to verify user's credentials (username and password) during login. It's important to note that this function doesn't use a secure way of storing the usernames and passwords and it's not recommended to use plain text for storing sensitive information in the application. Also, it's not recommended to use only one password for multiple users, it's recommended to use a password hashing function and compare the hash of the provided password with the stored one.*/ 

$extensions = array('.pdf','.png','.jpg','.mp4','.gif'); // sensible a la casse !!!! mettre aussi en majuscules
function uploadFichier($fichier)
{
    global $extensions;
    $verif_extension = strrchr($fichier['name'],'.');
            // on génère une clé
        $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789AZERTYUIOPQSDFGHJKLMWXCVBN';
        $longueur = rand(10,16);
        $key = '';
        for($i=0;$i < $longueur;$i++)
        {
            // le point à la fin pour incrémenter
            $key.= $chaine[rand(0,strlen($chaine)-1)];
        }
    if(in_array($verif_extension,$extensions))
    {
        // verif si le dossier de l'user existe
        if(!is_dir('upload/'.$_COOKIE['login']))
        {
            // si il existe âs on le créer
            mkdir('upload/'.$_COOKIE['login']);
        }
        // On transfère notre fichier dans son dossier, la condition sert à retourner si l'envoi a bien été effectué
        if(move_uploaded_file($fichier['tmp_name'],'upload/'.$_COOKIE['login'].'/'.$key.'_'.$fichier['name']))
        {
            return true;
        }
    }
}
?><!--PHP code that defines an array called $extensions that contains file extensions and a function called uploadFichier. The $extensions array contains five strings: '.pdf', '.png', '.jpg', '.mp4', and '.gif'.
The uploadFichier function takes one parameter: $fichier. It starts by using the global statement to bring the $extensions array into the function's scope.
It then uses the strrchr() function to check if the file extension of the uploaded file is present in the $extensions array by getting the last occurrence of '.' in the file name.
If the file extension is present in the $extensions array, it checks if a directory exists with the same name as the user's login name in the "upload" directory. If not, it creates the directory using the mkdir() function.
Then it uses the move_uploaded_file() function to move the uploaded file to the user's directory and renames the file by adding a random string generated by for loop and concatenating it with the original file name.
If the file is successfully moved, it returns true. If not, it returns nothing.
It's important to note that this function does not check for the authenticity of the user and therefore could be vulnerable to malicious users manipulating the cookies or the directory path. It is also important to validate the user's permission to upload the files, and the type of file before uploading it. It's also important to check if the user is authenticated before allowing them to upload files.-->