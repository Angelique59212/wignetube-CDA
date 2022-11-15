<div id="title-addVideo">
    <h1>Ajouter une Vidéo</h1>
</div>

<div id="form-addVideo">
    <form action="/index.php?c=video&a=add-video" method="post" enctype="multipart/form-data">
        <div>
            <label for="title">Titre de la vidéo</label>
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="video">Chemin d'accès</label>
            <input type="file" name="video" id="video">
        </div>
        <input id="btn-addArticle" type="submit" name="save" value="Enregistrer" class="btn btn-secondary">
    </form>
</div>