<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WigneTube</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body> <?php

function getMessage(string $type) {
    if (isset($_SESSION[$type])) {?>
        <div class="message-<?= $type ?>">
            <p><?= $_SESSION[$type] ?></p>
            <button id="close">x</button>
        </div><?php
        unset($_SESSION[$type]);
    }
}

getMessage('error');
getMessage('success');

?>
<header>
    <div class="user-welcome"><?php
        if (isset($_SESSION['user'])) { ?>
            Hello <?= $_SESSION['user']->getFirstName() . " " . $_SESSION['user']->getLastname();
        } ?>
    </div>
    <div id="logout">
        <div>
            <i class="fa-solid fa-bars"></i>
        </div><?php

        if (!isset($_SESSION['user'])) { ?>
            <a href="/?c=home">Home</a>
            <a href="/?c=user&a=login">Login</a>
            <a href="/?c=user&a=register">Inscription</a>
            <a href="/?c=video">Vidéos</a><?php
        }
        else { ?>
            <a href="/?c=home">Home</a>
            <a href="/?c=user&a=show-user">Mon profil</a>
            <a href="/?c=video">Vidéo</a><?php

            if (AbstractController::verifyRole()) { ?>
                <a href="/index.php?c=video&a=add-video">Ajouter une video</a> <?php
            }?>

            <a href="/?c=user&a=disconnect">Déconnexion</a><?php
        }
        ?>
    </div>
</header>

<div id="title-menu">
    <i class="fa-brands fa-youtube"></i>
    <h1>Wignetube</h1>
</div>

<main><?= $html ?></main>

<footer>
    <div id="bottom">
        <a href="/?c=home">Home</a>
        <a href="/?c=user&a=save-form">Contact</a>
        <a href="/?c=confidentiality&a=confidentiality">Confidentialité</a>
        <p>&copy Angélique Dehainaut</p>
    </div>
</footer>


<script src="https://kit.fontawesome.com/9fe3f13f0a.js" crossorigin="anonymous"></script>
<script src="/assets/app.js"></script>
</body>