<?php
/**
 * Class Controller
 */
class TopicController extends AppController 
{
    /**
     * Display all topics with pagination
     */
    public function topics() 
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        }
        $session = $_SESSION['user_session'];

        // start paginated topics 
        $total_rows = Topic::count();
        $page = Pagination::pageValidator($total_rows);
        $topics = Topic::getAll($page);
        $paged = new Pagination($total_rows, $page);
        // end paginated topics        

        $this->set(get_defined_vars());
    }

    /**
     * Creating new topic
     */
    public function create() 
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        }

        $session = $_SESSION['user_session'];
        $user_id = $session['user_id'];

        $topic = new Topic();
        $page = Param::get('page_next', 'create');

        switch ($page) {
            case 'create':
                break;
            case 'create_end':
                $topic->user_id = Param::get('user_id');
                $topic->topic_name = Param::get('title');
                $topic->grade_level = Param::get('grade_level');
                $topic->question = Param::get('questions');
                $topic->subject_category = Param::get('course_subject');
                try {
                    $topic->create();
                } catch (ValidationException $e) {
                    $page = 'create';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    /**
     * Search Topic Title
     */
    public function search()
    {
        $session = $_SESSION['user_session'];
        $search_item = Param::get('searchbar');
        $topic = new Topic();
        if(!$search_item) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            if($topic->countSearchResults($search_item) > 0)
            {
                //pagination of search results
                $total_rows = $topic->countSearchResults($search_item);
                $page = Pagination::pageValidator($total_rows);
                $results = $topic->search($page, $search_item);
                $paged = new Pagination(
                    $total_rows, 
                    $page, 
                    array("searchbar=$search_item"));
            }
        }
        $this->set(get_defined_vars());
    }

    /**
     * Delete TopicController
     */
    public function delete()
    {
        $topic_id = base64_decode(Param::get('topic_id'));
        $user_id = $_SESSION['user_session']['user_id'];
        $topic = new Topic();
        $topic->delete($topic_id, $user_id);
        $confirmation = "Your Topic has been Deleted";
        redirect("/topic/topics?m=$confirmation");
        $this->set(get_defined_vars());
    }

    /**
     * Catch page when user types in invalid URL
     */
    public function pageNotFound() 
    {
        $err_msg = Param::get('error_msg');
        $this->set(get_defined_vars());
    }
}