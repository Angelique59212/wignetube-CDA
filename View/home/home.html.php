<?php

use App\Model\Entity\Video;

if (isset($data['video']))
{
    $video = $data['video'];?>

<div>
    <h1>Voici les 3 dernières vidéos postées</h1>
</div>
<div class="container-home"><?php
    foreach ($video as $vid) {
    /* @var Video $vid */ ?>
        <div>
            <div>
                <h2><?php $video->getContent() ?></h2>
            </div>
            <div>
                <h2><?php $video->getTitle() ?></h2>
            </div>
        </div><?php
    }?>

    <div>
        <a href="/index.php?c=video&a=list-video">Toutes les vidéos</a>
    </div>
</div><?php
}
