# wignetube-CDA

Je dois pouvoir réaliser le clone de Youtube, pour cela je dois avoir un système d'inscription,de reinitialisation de
mot de passe de connexion, pouvoir attribuer un rôle.
Je dois savoir uploader des vidéos, mettre des commentaires.


    Table User
        id
        clé de validation
        validation
        email
        prenom
        nom
        mot de passe
        

Je définis le rôle

    Table Role
        admin
        user

Je gère la réinitialisation du MDP
    
    Table reset-password
        id  
        email
        token
        date-add

Je gère l'upload de vidéos 
        
    Table Videos
        id
        titre de la vidéo
        contenu
        
Je permet d'ajouter un commentaire

    Table commentaire
        id
        contenu
