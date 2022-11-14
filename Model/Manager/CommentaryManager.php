<?php

namespace App\Model\Manager;

use App\Model\Entity\Commentary;
use App\Model\Entity\User;
use App\Model\Entity\Video;
use Connect;

class CommentaryManager
{
    public const TABLE = 'mdf58_commentary';

    /**
     * @return array
     */
    public static function findAll(): array
    {
        $comments = [];

        $query = Connect::dbConnect()->query("SELECT * FROM " . self::TABLE . " ORDER BY id DESC");

        if ($query) {
            foreach ($query->fetchAll() as $commentary) {
                $comments[] = (new Commentary())
                    ->setId($commentary['id'])
                    ->setContent($commentary['content'])
                    ->setUser(UserManager::getUserById($commentary['user_fk']))
                    ->setVideo(VideoManager::getVideoById($commentary['video_fk']));

            }
        }
        return $comments;
    }

    /**
     * @param int $id
     * @return int|mixed
     */
    public static function commentaryExist(int $id)
    {
        $result = Connect::dbConnect()->query("SELECT count(*) as cnt FROM " . self::TABLE);
        return $result ? $result->fetch()['cnt'] : 0;
    }

    /**
     * @param string $content
     * @param int $user_fk
     * @param int $video_fk
     * @return void
     */
    public static function addCommentary(string $content, int $user_fk, int $video_fk)
    {
        $stmt = Connect::dbConnect()->prepare("
            INSERT INTO " . self::TABLE. " (content, user_fk, video_fk)
                VALUES( :content, :user_fk, :video_fk)
        ");

        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];

            /* @var User $user */
            $user_fk = $user->getId();
        }

        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':user_fk', $user_fk);
        $stmt->bindParam(':video_fk', $video_fk);

        $stmt->execute();
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function deleteCommentary(int $id): bool
    {
        $query = Connect::dbConnect()->exec("
            DELETE FROM " . self::TABLE ." WHERE id = $id
        ");
        if ($query) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @param Video $video
     * @return array
     */
    public static function getCommentaryByVideo(Video $video): array
    {
        $comments = [];
        $query = Connect::dbConnect()->query("
            SELECT * FROM ". self::TABLE . " WHERE video_fk = " . $video->getId() ." ORDER BY id DESC 
        ");

        if ($query) {
            foreach ($query->fetchAll() as $commentaryData) {
                $comments[] = (new Commentary())
                    ->setId($commentaryData['id'])
                    ->setContent($commentaryData['content'])
                    ->setUser(UserManager::getUserById($commentaryData['user_fk']))
                    ->setVideo(VideoManager::getVideoById($commentaryData['video_fk']));
            }
        }
        return $comments;
    }

    /**
     * @param int $id
     * @return Commentary|null
     */
    public static function getCommentary(int $id): ?Commentary
    {
        $query = Connect::dbConnect()->prepare("SELECT * FROM " . self::TABLE . " WHERE id =:id");
        $query->bindParam(':id',$id);

        if ($query->execute() && $commentary = $query->fetch()) {
            return (new Commentary())
                ->setId($commentary['id'])
                ->setContent($commentary['content'])
                ->setUser(UserManager::getUserById($commentary['user_fk']))
                ->setVideo(VideoManager::getVideoById($commentary['video_fk']));
        }
        return null;
    }
}
