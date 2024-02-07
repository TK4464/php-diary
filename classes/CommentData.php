<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Comment.php';
require_once __DIR__ . '/Diary.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/UserData.php';


class CommentData
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function save(Comment $comment)
    {
        $sql = <<<SQL
            INSERT INTO comments
            (comment, author, diary)
            VALUES (:comment, :author, :diary)
        SQL;
        $state = $this->pdo->prepare($sql);
        $state->execute([
            'comment' => $comment->getCommentBody(),
            'author' => $comment->getAuthor()->getId(),
            'diary' => $comment->getDiary()->getId(),
        ]);
    }


    public function update(Comment $comment)
    {
        $sql = <<<SQL
            UPDATE comments
            -- sqlの変数が入るところは:をつける
            SET comment = :comment
            WHERE id = :id
        SQL;
        $state = $this->pdo->prepare($sql);
        $state->execute([
            'comment' => $comment->getCommentBody(),
            'id' => $comment->getId(),
        ]);
    }



    public function delete(Comment $comment)
    {
        $sql = <<<SQL
            DELETE FROM comments
            WHERE id = :id
        SQL;
        $state = $this->pdo->prepare($sql);
        $state->execute([
            'id' => $comment->getId(),
        ]);
    }

    /**
     * @return Comment[]
     */
    public function getAll(): array
    {
        $sql = <<<SQL
            SELECT * FROM comments
        SQL;
        $state = $this->pdo->query($sql);


        $comments = [];
        foreach ($state as $record) {
            $comment = new Comment();
            $comment->setId($record['id']);
            $comment->setCommentBody($record['comment']);


            $userId = $record['author'];
            $userData = new UserData();
            $user = $userData->get($userId);
            $comment->setAuthor($user);

            $diaryId = $record['diary'];
            $diaryData = new DiaryData();
            $diary = $diaryData->get($diaryId);
            $comment->setDiary($diary);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function get(string|int $id): ?Comment
    {
        $comments = $this->getAll();
        foreach ($comments as $comment) {
            if (intval($comment->getId()) === intval($id)) {
                return $comment;
            }
        }

        return null;
    }




}
