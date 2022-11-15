<?php

use App\Model\Entity\Video;

$video = $data['video'];


?>

<div class="container-home"><?php
    foreach ($video as $vid) {
        /* @var Video $vid */?>
        <div class="container-vo">
        <div class="card">
            <img class="card-img-top w-30" src="uploads/<?= $video->getVideo() ?>" alt="">

            <div class="card-body">
                <h2 class="card-title fw-bold"><?= $video->getTitle()?></h2> <?php
                // Admin buttons.
                if (AbstractController::verifyRole()) { ?>
                    <a class="btn btn-danger" href="/index.php?c=video&a=delete-video&id=<?= $video->getId() ?>">Supprimer</a>   <?php
                } ?>
            </div>
        </div>
        </div><?php
    } ?>
</div>