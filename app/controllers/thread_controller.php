<?php

class ThreadController extends AppController{
     public function threads()
    {
        if(session_shield($_SESSION['user'])){
            header("location: /");
        }
        $session = $_SESSION['user'];

        ####### start paginated threads ##########
        $rowsperpage= 5;
        $totalrows 	= Thread::threadsrows();
        $page = pagination::pagevalidator($totalrows, $rowsperpage);
        $threads = Thread::getAll($page, $rowsperpage);
		$paged = new pagination($totalrows, $rowsperpage, $page);
		####### end paginated threads  ###########
		
		$this->set(get_defined_vars());
    }

    public function view()
    {
        if(session_shield($_SESSION['user'])){
            header("location: /");
        }
        $thread_id 	= Param::get('thread_id');
        $thread 	= Thread::get($thread_id);
        if(!$thread)
        {
        	header("location: /thread/pagenotfound");
        }

        ####### start paginated comments ##########
        $rowsperpage= 5;
        $session 	= $_SESSION['user'];
        $username	= $session[0]['username'];        
        $totalrows 	= Thread::commentsrows($thread_id);
        $page 		= pagination::pagevalidator($totalrows, $rowsperpage);
        $comments 	= Thread::getComments($page, $rowsperpage, $thread_id);
        $paged 		= new pagination($totalrows, $rowsperpage, $page, array("thread_id=$thread_id"));
        ####### end paginated comments  ###########

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
    public function pagenotfound()
    {
    }
}