<?php

use App\Model\Entity\Commentary;
use App\Model\Entity\Video;
use App\Model\Manager\CommentaryManager;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $stmt = "SELECT * FROM mdf58_article WHERE id =" . $_GET['id'];

} else {
    header('Location: home');
}

/* @var Video $video */
$video = $data['video'];

// Getting connected user.
$user = null;
if($_SESSION['user']) {
    $user = $_SESSION['user'];
}?>

    <div id="show-video">
        <div id="title-video">
            <h1><?= $video->getTitle() ?></h1>
            <div class="video-actions"> <?php
                // Admin buttons.
                if (AbstractController::verifyRole()) { ?>
                    <a class="btn btn-danger" href="/index.php?c=video&a=delete-video&id=<?= $video->getId() ?>">Supprimer</a>   <?php
                } ?>

            </div>
        </div>

        <div class="video-summary">
            <div class="videos">
                <img src="/uploads/<?= $video->getContent() ?>" alt="">
            </div>
            <div class="video-content">
                <?= $video->getContent() ?>
            </div>
        </div>

        <div id="content">
            <?= html_entity_decode($video->getContent()) ?>
        </div>

    </div>

    <div id="comment">
        <span id="comments">Commentaires:</span><?php
        foreach (CommentaryManager::getCommentaryByVideo($video) as $item) {
            /* @var Commentary $item */ ?>
            <div>
            <p id="author-comment"><?= $item->getUser()->getFirstname() ?></p>
            <p><?= $item->getContent() ?></p>
            </div><?php

            if (AbstractController::verifyRole() || ($user !== null && $video->getUser()->getId() === $user->getId())) { ?>
                <div id="remove-comment">
                <a class="btn btn-danger" href="/index.php?c=commentary&a=delete-commentary&id=<?= $item->getId() ?>">Supprimer</a>
                </div><?php
            } ?>
            <hr> <?php
        }
        ?>
        <a class="btn btn-primary" href="/index.php?c=commentary&a=add-commentary&id=<?= $video->getId() ?>">Ajouter un commentaire</a>
    </div>
<?php
