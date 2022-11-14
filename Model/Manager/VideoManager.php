<?php

namespace App\Model\Manager;

use App\Model\Entity\Commentary;
use App\Model\Entity\Video;
use Connect;

class VideoManager {
    public const TABLE = 'mdf58_video';

    /**
     * @param int|null $limit
     * @return array
     */
    public static function findAll(int $limit = null): array
    {
        $videos = [];
        $limitQuery = $limit !== null ? " LIMIT $limit" : '';
        $query = Connect::dbConnect()->query("SELECT * FROM " . self::TABLE . " ORDER BY id DESC" . $limitQuery);
        if ($query) {
            foreach ($query->fetchAll() as $videoData) {
                $videos[] = (new Video())
                    ->setId($videoData['id'])
                    ->setTitle($videoData['title'])
                    ->setContent($videoData['content'])
                    ->setUser(UserManager::getUserById($videoData['user_fk']));
            }
        }
        return $videos;
    }

    /**
     * @param Video $video
     * @return bool
     */
    public static function addNewVideo(Video &$video): bool
    {
        $stmt = Connect::dbConnect()->prepare("
            INSERT INTO ". self::TABLE ." (title, content, user_fk)
                VALUES (:title, :content, :user_fk)
        ");

        $stmt->bindValue(':title', $video->getTitle());
        $stmt->bindValue(':content', $video->getContent());
        $stmt->bindValue(':user_fk', $video->getUser()->getId());

        $result = $stmt->execute();
        $video->setId(\Connect::dbConnect()->lastInsertId());
        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function videoExist(int $id): bool
    {
        $result = Connect::dbConnect()->query("SELECT count(*) as cnt FROM " . self::TABLE . " WHERE id = $id");
        return $result ? $result->fetch()['cnt'] : 0;
    }

    /**
     * @param int $id
     * @return Video|null
     */
    public static function getVideoById(int $id): ?Video
    {
        $result = Connect::dbConnect()->query("SELECT * FROM " . self::TABLE . " WHERE id = $id");
        return $result ? self::makeVideo($result->fetch()) : null;
    }

    /**
     * @param array $data
     * @return Video
     */
    private static function makeVideo(array $data): Video
    {
        return (new Video())
            ->setId($data['id'])
            ->setTitle($data['title'])
            ->setContent($data['content'])
            ->setUser(UserManager::getUserById($data['user_fk']));
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $content
     * @param string|null $video
     * @return void
     */
    public static function editVideo(int $id, string $title, string $content, string $video = null)
    {
        $videoSql = $video ? ", video = :video" : '';
        $stmt = Connect::dbConnect()->prepare("
            UPDATE " . self::TABLE . "SET title = :title, content = :content " . $videoSql . " WHERE id = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);

        if ($video) {
            $stmt->bindParam(':video', $video);
        }
        $stmt->execute();
    }

    /**
     * @param Video|null $video
     * @return false|int
     */
    public static function deleteVideo(?Video $video)
    {
        if (self::videoExist($video->getId())) {
            return Connect::dbConnect()->exec("
                DELETE FROM " . self::TABLE ." WHERE id = {$video->getId()}
            ");
        }
        return false;
    }
}
