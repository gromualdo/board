<?php
/**
 * Class Controller
 */
class ReplyController extends AppController 
{
    public static $disabled = null;   
    public static $placeholder = null; 
    /**
     * View all replies with pagination
     * form for adding replies
     */
    public function view() 
    {
        is_logged_in('user_session');
        $session = $_SESSION['user_session'];
        $user_id = $session['user_id'];

        $encrypted_topic_id = Param::get('topic_id');
        $topic_id = base64_decode($encrypted_topic_id);
        $topic = Topic::get($topic_id);

        $user = new User();
        $infos = $user->getUpdatedProfile($user_id);
        $username = $infos->username; 
        $user_grade_level = $infos->grade_level;
           
        if ($user_grade_level < $topic->grade_level) {
            ReplyController::$placeholder = "You are not allowed to reply on this Topic";
            ReplyController::$disabled = "disabled";
        }

        // start paginated replies 
        $total_rows = Reply::count($topic_id);
        $page = Pagination::pageValidator($total_rows);
        $replies = Reply::getRepliesByTopicId($page, $topic_id);
        $paged = new Pagination(
            $total_rows, 
            $page, 
            array("topic_id=$encrypted_topic_id"));
        // end paginated replies  

        $reply = new Reply();
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

    /**
     * Delete own Comment
     */
    public function delete()
    {
        $topic_id = Param::get('topic_id');
        $reply_id = base64_decode(Param::get('reply_id'));
        $reply = new Reply;
        $user_id = $_SESSION['user_session']['user_id'];
        $reply->delete($reply_id, $user_id);
        $confirmation = "Your Reply has been Deleted";
        redirect("/reply/view?topic_id=$topic_id&m=$confirmation");
        $this->set(get_defined_vars());
    }
}