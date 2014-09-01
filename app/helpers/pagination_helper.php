<?php
class pagination
{
    public $rowcount;
    public $rowsperpage;
    public $currentpage;
    public $pagecount;
    public $addedquery;

    public function __construct ($rowcount = null, $rowsperpage = null, $currentpage = null, array $querystrings = null)
    {
        if(!is_null($rowcount) && !is_null($rowsperpage) && !is_null($currentpage))
        {
            $this->rowcount     = $rowcount;
            $this->rowsperpage  = $rowsperpage;
            $this->currentpage  = $currentpage;
            $this->querystrings = $querystrings;
            $this->run();
        }
    }

    public function run()
    {
        $this->pagecount    = ceil($this->rowcount / $this->rowsperpage);
        $this->currentpage  = max($this->currentpage, 1);
        $this->currentpage  = min($this->currentpage, $this->pagecount);
    }

    public static function pagevalidator($totalpages)
    {

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
        $pages['totalpages']    = $totalpages;
        $pages['currentpage']   = $currentpage;
        return $pages;
    }

    public function __toString()
    {
        $addedquery = "";
        foreach((array) $this->querystrings as $querystring)
        {
            $addedquery .= "&{$querystring}";
        }

        $pagerange =2;
        $pagectrl = "";
        if($this->currentpage > 1)
        {
            $pagectrl .= " <a href='?currentpage=1{$addedquery}' title='Go to First Page' class='btn btn-mini btn-inverse ''> << </a>";
            $prevpage = $this->currentpage - 1;
            $pagectrl .= " <a href='?currentpage=$prevpage{$addedquery}' title='Go to Previous Page' class='btn btn-mini btn-inverse '> < </a> "; 
            }
 
        for($i = ($this->currentpage - $pagerange); $i <= ($this->currentpage + $pagerange); $i++)
        {
            if(($i > 0) && ($i <= $this->pagecount))
            {
                if($i == $this->currentpage)
                {
                    $pagectrl .= "<font class='btn-mini btn-inverse'>$i</font>";
                }
                else
                {
                    $pagectrl .= " <a href='?currentpage=$i{$addedquery}' class='btn btn-mini btn-inverse'>$i</a> ";
                }
            }       
        }

        if($this->currentpage != $this->pagecount)
        {
            $nextpage = $this->currentpage + 1;
            $pagectrl .= "<a href='?currentpage=$nextpage{$addedquery}' title='Go to Next Page' class='btn btn-mini btn-inverse '> > </a> ";
            $pagectrl .= "<a href='?currentpage=$this->pagecount{$addedquery}' title='Go to Last Page' class='btn btn-mini btn-inverse '> >> </a> ";
        }
    return $pagectrl;
    }
}

