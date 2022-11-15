<?php

require __DIR__ .'/Config.php';
require __DIR__ .'/Model/Connect.php';

require __DIR__ .'/Model/Entity/AbstractEntity.php';
require __DIR__ .'/Model/Entity/User.php';
require __DIR__ .'/Model/Entity/Role.php';
require __DIR__ .'/Model/Entity/Commentary.php';
require __DIR__ .'/Model/Entity/Video.php';

require __DIR__ .'/Model/Manager/UserManager.php';
require __DIR__ .'/Model/Manager/RoleManager.php';
require __DIR__ .'/Model/Manager/CommentaryManager.php';
require __DIR__ .'/Model/Manager/VideoManager.php';


require __DIR__ .'/Controller/AbstractController.php';
require __DIR__ .'/Controller/ErrorController.php';
require __DIR__ .'/Controller/UserController.php';
require __DIR__ .'/Controller/VideoController.php';
require __DIR__ .'/Controller/CommentaryController.php';
require __DIR__ .'/Controller/ConfidentialityController.php';


require __DIR__ . '/Router.php';