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

    public static function pagevalidator($totalrows, $rowsperpage)
    {
        $totalpages = ceil($totalrows/$rowsperpage);
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
        $pages = $currentpage;
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
        $pagectrl = "<div  class='pagination pagination-centered'><ul>";
        if($this->currentpage > 1)
        {
            $pagectrl .= " <li><a href='?currentpage=1{$addedquery}' title='Go to First Page' class='btn btn-mini  ''> << </a></li>";
            $prevpage = $this->currentpage - 1;
            $pagectrl .= " <li><a href='?currentpage=$prevpage{$addedquery}' title='Go to Previous Page' class='btn btn-mini  '> < </a></li> "; 
            }
 
        for($i = ($this->currentpage - $pagerange); $i <= ($this->currentpage + $pagerange); $i++)
        {
            if(($i > 0) && ($i <= $this->pagecount))
            {
                if($i == $this->currentpage)
                {
                    $pagectrl .= "<li class='disabled'><a class='btn btn-mini ' href=#>$i</a></li>";
                }
                else
                {
                    $pagectrl .= " <li><a href='?currentpage=$i{$addedquery}' class='btn btn-mini '>$i</a></li> ";
                }
            }       
        }

        if($this->currentpage != $this->pagecount)
        {
            $nextpage = $this->currentpage + 1;
            $pagectrl .= "<li><li><a href='?currentpage=$nextpage{$addedquery}' title='Go to Next Page' class='btn btn-mini  '> > </a></li> </li>";
            $pagectrl .= "<li><a href='?currentpage=$this->pagecount{$addedquery}' title='Go to Last Page' class='btn btn-mini  '> >> </a></li> ";
        }
    $pagectrl .="</ul></div>";
    return $pagectrl;
    }
}