<?php
class Comment extends AppModel
{
    public $validation = array(
        'body' => array(
            'length' => array(
                'is_between', 1, 500,
            ),
        ),
    );

    /**
     * Returns the number of rows
     * of comment table
     * @return $numrows
     */
    public static function count($thread_id)
    {
        $db = DB::conn();
        return (int) $db->value("SELECT COUNT(*) FROM comment WHERE thread_id = ?", array($thread_id));
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
    public static function getCommentsByThreadId($currentpage, $rowsperpage, $thread_id)
    {
        $comments = array();
        $db = DB::conn();
        $lowerlimit = ($currentpage - 1) * $rowsperpage;
        $limitrows = $db->search("comment",
            "thread_id = ?", array($thread_id), 
            "id DESC", 
            "$lowerlimit, $rowsperpage"
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
    public function write($thread_id)
    {
        if (!$this->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        // $db->begin();
        $params = array(
            'thread_id' => $thread_id, 
            'username' => $this->username, 
            'body' => $this->body,
            );
        $db->insert("comment", $params);
        // $db->commit();
        
    }

}