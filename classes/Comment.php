<?php

require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Diary.php';

class Comment
{
    // 属性（プロパティ）
    private $id;
    private $commentBody;
    private User $author;
    private Diary $diary;
    private $created_At;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCommentBody($commentBody)
    {
        $this->commentBody = $commentBody;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function setDiary(Diary $diary)
    {
        $this->diary = $diary;
    }

    public function setCreatedAt($created_At)
    {
        $this->created_At = $created_At;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getCommentBody()
    {
        return $this->commentBody;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getDiary(): Diary
    {
        return $this->diary;
    }

    public function getCreatedAt()
    {
        return $this->created_At;
    }

}
