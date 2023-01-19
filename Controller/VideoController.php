<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\Entity\Video;
use App\Model\Manager\VideoManager;

class VideoController extends AbstractController
{
    /**
     * @return void
     */
    public function index()
    {
        $this->render('home/home');
    }


    /**
     * redirect when clicked on read more
     * @param $action
     * @return void
     */
    public function page($action)
    {
        $this->render('video/' . $action);
    }


    /**
     * @return void
     */
    public function addVideo()
    {
        self::redirectIfNotConnected();
        if (!self::verifyRole()) {
            header('Location: /index.php?c=home');
        }

        if ($this->verifyFormSubmit()) {
            $video = $this->getFormFieldVideo('video');

            // Redirect if no video provided.
            if (!$video) {
                $_SESSION['error'] = "Vous n'avez pas fourni de Vidéo";
                header('location: /index.php?c=video&a=add-video');
                die();
            }

            $user = $_SESSION['user'];

            // Getting and securing form content.
            $title = $this->dataClean($this->getFormField('title'));
            $content = $this->dataCleanHtmlContent($this->getFormField('content'));

            $video = new Video();
            $video
                ->setTitle($title)
                ->setContent($content)
                ->setUser($user)
            ;

            if (VideoManager::addNewVideo($video)) {
                $_SESSION['success'] = "Votre video a bien été ajouté";
                header('Location: /index.php?c=home&a=home');
            }
        } else {
            $this->render('video/add-video');
        }
    }

    /**
     * @return void
     */
    public function listVideo() {
        $this->render('video/list-video', [
            'video' => VideoManager::findAll(),
        ]);
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function showVideo(int $id = null)
    {
        if (null === $id) {
            header("Location: /index.php?c=home");
        }
        if (VideoManager::videoExist($id)) {
            $this->render('video/show-video', [
                "video" => VideoManager::getVideoById($id),
            ]);
        } else {
            $this->index();
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteVideo(int $id) {
        $this->redirectIfConnected();
        if(!self::verifyRole()) {
            header('Location: /index.php?c=home');
        }
        if (VideoManager::videoExist($id)) {
            $video = VideoManager::getVideoById($id);
            VideoManager::deleteVideo($video);
            header('Location: /index.php?c=video&a=list-video');
        }
        $this->index();
    }

    /**
     * @param int $id
     * @return void
     */
    public function editVideo(int $id)
    {
        $this->redirectIfNotConnected();
        if(!self::verifyRole()) {
            header('Location: /index.php?c=home');
        }

        if (isset($_POST['save']) && VideoManager::videoExist($id)) {
            $title = $this->dataClean($this->getFormField('title'));
            $content = $this->dataCleanHtmlContent($this->getFormField('content'));
            $video = $this->getFormFieldVideo('video');

            if (!$video) {
                $video = null;
            }

            VideoManager::editVideo($id, $title, $content, $video);
            header('Location: /index.php?c=video&a=list-video');
        }
        $this->render('video/edit-video', [
            'video' => VideoManager::getVideoById($id)
        ]);
    }
}
