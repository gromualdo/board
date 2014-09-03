<?php 
class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', 1, 30,
                ),
            ),
        );

    public static function get($id)
    {
        $db = DB::conn();
        $row = $db->row("SELECT * FROM thread 
            WHERE id = ? 
            ORDER BY id", 
            array($id)
            );
        if (!$row) {
            return false;           //will be redirected to pagenotfound if $row=0
        }
        return new self($row);
    }

    public static function getAll($currentpage, $rowsperpage)
    {
        $threads = array();
        $db = DB::conn();
        $lowerlimit = ($currentpage - 1) * $rowsperpage;
        $rows = $db->rows("SELECT * FROM thread 
            ORDER BY id DESC 
            LIMIT $lowerlimit, $rowsperpage"
            );
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }
        return $threads;
    }
    public static function getComments($currentpage, $rowsperpage, $thread_id)
    {
        $comments = array();
        $db = DB::conn();
        $lowerlimit = ($currentpage - 1) * $rowsperpage;
        $limitrows= $db->rows("SELECT * FROM comment 
            WHERE thread_id = ? 
            ORDER BY id DESC 
            LIMIT $lowerlimit, $rowsperpage",
            array($thread_id)
            );
        foreach($limitrows as $limitrow) {
            $comments[] = new Thread($limitrow);
        }
        return $comments; 
    }

    public function write(Comment $comment)
    {
        if (!$comment->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $params = array(
            'thread_id' => $this->id, 
            'username'  => $comment->username, 
            'body'      => $comment->body
            );
        $db->insert("comment", $params);
        $db->commit();
        
    }

    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();
        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('invalid thread or comment');
        }
        $db = DB::conn();
        $db->begin();
        $params = array(
            'title' => $this->title
            );
        $db->insert("thread", $params);
        $this->id = $db->lastInsertId();
        $this->write($comment);     
        $db->commit();
    }

    public static function threadsrows()
    {
        $db = DB::conn();
        $sqlrowcount = $db->row(
            "SELECT COUNT(*) AS num FROM thread"
            );
        $numrows = $sqlrowcount['num'];
        return $numrows;
    }

    public static function commentsrows($thread_id)
    {
        $db = DB::conn();
        $sqlrowcount = $db->row("SELECT COUNT(*) AS num FROM comment 
            WHERE thread_id = ?", 
            array($thread_id)
            );
        $numrows = $sqlrowcount['num'];
        return $numrows;
    }
}