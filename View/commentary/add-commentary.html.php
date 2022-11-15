<?php

$video = $data['video'];
?>

<div id="title-commentary">
    <h1>Ajouter un commentaire</h1>
</div>

<div id="form-addCommentary">
    <form action="/index.php?c=commentary&a=add-commentary&id=<?= $video->getId() ?>" method="post" id="addCommentary">
        <div class="style-commentary">
            <label for="content"></label>
            <textarea name="content" id="content" cols="30" rows="10" required></textarea>
        </div>

        <div id="register">
            <input type="submit" name="save" value="Enregistrer">
        </div>
    </form>
</div>
