<?php 
class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'is_between', 1, 30,
                ),
            ),
        );

    /**
     * Displays the Thread selected by the 
     * SQL query
     * @param $id
     * @return new obj
     */
    public static function getThread($id)
    {
        $db = DB::conn();
        $row = $db->row("SELECT * FROM thread 
            WHERE id = ? 
            ORDER BY id", 
            array($id)
            );
        if (!$row) {
            throw new DCException("Cannot find Thread_ID $thread_id");           //will be redirected to pagenotfound if $row=0
        }
        return new self($row);
    }

    /**
     * Displays all threads with Limit and Offsets
     * in descending order
     * @param $currentpage
     * @param $rowsperpage
     * @return $threads array
     */
    public static function getAllThreads($currentpage, $rowsperpage)
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

    /**
     * Displays all the comments on a
     * specific thread with Limits and Offsets
     * in descending order
     * @param $currentpage
     * @param $rowsperpage
     * @param $thread_id
     * @return $comments array
     */
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

    /**
     * Insert new comment
     * @param $comment Object
     */
    public function write(Comment $comment)
    {
        if (!$comment->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $db->begin();
        $params = array(
            'thread_id' => $this->id, 
            'username'  => $comment->username, 
            'body'      => $comment->body
            );
        $db->insert("comment", $params);
        $db->commit();
        
    }

        //redirect to 404 page if thread id is not found

    /**
     * Create new Thread
     * @param $comment Object
     */
    public function createThread(Comment $comment)
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

    /**
     * Returns the number of rows
     * of thread table
     * @return $numrows
     */
    public static function countThreads()
    {
        $db = DB::conn();
        $sqlrowcount = $db->row(
            "SELECT COUNT(*) AS num FROM thread"
            );
        $numrows = $sqlrowcount['num'];
        return $numrows;
    }

    /**
     * Returns the number of rows
     * of comment table
     * @return $numrows
     */
    public static function countComments($thread_id)
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