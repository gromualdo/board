<?php
class Reply extends AppModel
{
    public $validation = array(
        'body' => array(
            'length' => array(
                'is_between', 1, 1000,
            ),
            'valid_reply' => array(
                'has_space_at_beginning'
            ),
        ),
    );

    /**
     * Returns the number of rows
     * of reply table
     * @return $numrows
     */
    public static function count($topic_id)
    {
        $db = DB::conn();
        return (int) $db->value(
            "SELECT COUNT(*) FROM replies 
            WHERE topic_id = ?", array($topic_id)
        );
    }

    /**
     * Displays all the replies on a
     * specific thread with Limits and Offsets
     * in descending order
     * @param $currentpage
     * @param $topic_id
     * @return $replies array
     */
    public static function getRepliesByTopicId($currentpage, $topic_id)
    {
        $replies = array();
        $db = DB::conn();
        $lowerlimit = ($currentpage - 1) * ROWS_PER_PAGE;
        $limit = "LIMIT $lowerlimit,".ROWS_PER_PAGE;
        $limitrows = $db->rows(
            "SELECT * FROM replies, users 
            WHERE topic_id = ? AND replies.user_id = users.user_id
            ORDER BY reply_id DESC
            $limit",
            array($topic_id)
        );
        foreach($limitrows as $limitrow) {
            $replies[] = new Topic($limitrow);
        }
        return $replies; 
    }

    /**
     * Insert new reply
     * @param @topic_id
     */
    public function write($topic_id)
    {
        if (!$this->validate()) {
            throw new ValidationException('invalid reply');
        }
        $db = DB::conn();
        $params = array(
            'topic_id' => $topic_id, 
            'user_id' => $this->user_id,
            'reply' => $this->body,
        );
        $db->insert("replies", $params);
        
    }

    /**
     * Delete Reply
     * @param $string
     */
    public function delete($reply_id, $user_id)
    {
        $db = DB::conn();
        $db->query(
            "DELETE FROM replies WHERE reply_id = ? AND user_id =?",
            array($reply_id, $user_id)
        );
    }

}