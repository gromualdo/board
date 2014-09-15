<?php
/**
 * Class Controller
 */
class ReplyController extends AppController 
{
        /**
     * View all replies with pagination
     * form for adding replies
     */
    public function view() 
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        }

        $topic_id = base64_decode(Param::get('topic_id'));
        $topic = Topic::get($topic_id);
        $encrypted_topic_id = base64_encode($topic_id);
        // start paginated replies 
        $session = $_SESSION['user_session'];
        $username = $session['username'];    
        $user_id = $session['user_id'];
        $total_rows = Reply::count($topic_id);
        $page = Pagination::pageValidator($total_rows);
        $replies = Reply::getRepliesByTopicId($page, $topic_id);
        $paged = new Pagination($total_rows, $page, 
            array("topic_id=$encrypted_topic_id"));
        // end paginated replies  

        $reply = new Reply;
        $page = Param::get('page_next', 'view');

        switch ($page) {
        case 'view';
            break;
        case 'write_end';
            $reply->user_id = $user_id;
            $reply->username = Param::get('username');
            $reply->body = Param::get('body');
            try {
                $reply->write($topic_id);
                
                echo $encrypted_topic_id;
                redirect("/reply/view?topic_id=$encrypted_topic_id");
            } catch (ValidationException $e) {
                $page = 'view';
            }
            break;
        default:
            throw new NotFoundException("{$page} is not found");
            break;
        }
        $this->set(get_defined_vars());
    }

    public function delete()
    {
        $topic_id = Param::get('topic_id');
        $reply_id = base64_decode(Param::get('reply_id'));
        $reply = new Reply;
        $reply->delete($reply_id);
        $this->set(get_defined_vars());
        $confirmation = "Your Reply has been Deleted";
        redirect("/reply/view?topic_id=$topic_id&m=$confirmation");
    }
}