<?php

namespace App\Model\Entity;

use AbstractEntity;

class Commentary extends AbstractEntity
{
    private string $content;
    private User $user;
    private Video $video;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Video
     */
    public function getVideo(): Video
    {
        return $this->video;
    }

    /**
     * @param Video $video
     */
    public function setVideo(Video $video): self
    {
        $this->video = $video;
        return $this;
    }
}
