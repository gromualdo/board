<?php

class ThreadController extends AppController{
    public function index()
    {

    }

    public function threads()
    {
        if(session_shield($_SESSION['user'])){
            header("location: /");
        }
        $session = $_SESSION['user'];

        ################## start pagination try 1.1 ###########################
        $threadobj = new Thread();
        $totalpages = $threadobj->threadsrows();
        

		if(isset($_GET['currentpage']) && is_numeric($_GET['currentpage']))
		{
			$currentpage = (int) $_GET['currentpage'];
		}
		else
		{
			$currentpage = 1;
		}

		if($currentpage > $totalpages)
		{
			$currentpage = $totalpages;
		}
		if($currentpage < 1)
		{
			$currentpage = 1;
		}
		$rowsperpage = 5;
        $threads = Thread::getAll($currentpage, $rowsperpage);
     
		$paged = new pagination($totalpages, $rowsperpage, $currentpage);
		$this->set(get_defined_vars());
		
		############### end pagination try 1.1 #####################3

    }
    public function view()
    {
        if(session_shield($_SESSION['user'])){
            header("location: /");
        }
        $session = $_SESSION['user'];
        $username = $session[0]['username'];

        $thread = Thread::get(Param::get('thread_id'));
        $comments = $thread->getComments();

        // print("<pre>");
        // print_r($comments);
        // print("</pre>");


        $this->set(get_defined_vars());
    }
    public function write()
    {
        if(session_shield($_SESSION['user'])){
            header("location: /");
        }
        $session = $_SESSION['user'];

        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
        $page = Param::get('page_next', 'write');

        switch($page){
            case 'write';
                break;
            case 'write_end';
                $comment->username = Param::get('username');
                $comment->body = Param::get('body');
                try{
                    $thread->write($comment);
                } catch(ValidationException $e) {
                    $page = 'write';
                }
                break;
                $thread->write($comment);
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function create()
    {
        if(session_shield($_SESSION['user'])){
            header("location: /");
        }
        $session = $_SESSION['user'];
        $username = $session[0]['username'];
        
        $thread = new Thread;
        $comment = new Comment;
        $page = Param::get('page_next', 'create');

        switch ($page) {
        case 'create':
            break;
        case 'create_end':
            $thread->title = Param::get('title');
            $comment->username = Param::get('username');
            $comment->body = Param::get('body');
            try {
                $thread->create($comment);
            } catch (ValidationException $e){
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

}