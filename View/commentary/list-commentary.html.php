<?php

use App\Model\Entity\Commentary;

$commentary = $data['commentary'];

foreach ($commentary as $comment) {
    /* @var Commentary $comment */ ?>

    <p><?= $comment->getContent() ?></p>

    <a class="btn btn-alert" href="/index.php?c=commentary&a=delete-commentary&id=<?= $comment->getId() ?>">Supprimer</a><?php
}