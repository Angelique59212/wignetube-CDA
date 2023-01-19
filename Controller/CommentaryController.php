<?php

namespace App\Controller;

use App\Model\Manager\CommentaryManager;
use App\Model\Manager\VideoManager;

class CommentaryController extends AbstractController
{
    /**
     * @return void
     */
    public function index()
    {
        $this->render('home/home');
    }

    /**
     * @param int $id
     * @return void
     */
    public function addComment(int $id)
    {
        if(self::verifyUserConnect() === false) {
            $_SESSION['error'] = "Vous devez être connecté";
            self::redirectIfNotConnected();
        }

        if($this->verifyFormSubmit()) {
            $userSession = $_SESSION['user'];
            $user = $userSession->getId();
            $content = $this->dataClean($this->getFormField('content'));

            CommentaryManager::addCommentary($content, $user, $id);
            header('Location: /index.php?c=video&a=show-video&id='.$id);
        }

        $this->render('commentary/add-commentary',[
            'video'=>VideoManager::getVideoById($id)
        ]);
    }

    /**
     * all comments
     * @return void
     */
    public function listComment() {
        $this->render('commentary/list-commentary', [
            'commentary' => CommentaryManager::findAll(),
        ]);
    }

    /**
     * Delete a comment.
     * @param int $id
     * @return void
     */
    public function deleteComment(int $id) {
        $this->redirectIfNotConnected();
        $user = $_SESSION['user'];

        if (CommentaryManager::commentaryExist($id)) {
            $comment = CommentaryManager::getCommentary($id);
            // If user is admin or user is the comment author, then canDelete is true.
            $canDelete = self::verifyRole() || $comment->getUser()->getId() === $user->getId();
            if ($comment && $canDelete && CommentaryManager::deleteCommentary($id)) {
                (new VideoController())->showVideo($comment->getVideo()->getId());
            }
        }

        (new VideoController())->index();
    }
}