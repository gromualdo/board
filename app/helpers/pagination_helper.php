<?php
class pagination 
{
    public $rowcount;
    public $rowsperpage;
    public $currentpage;
    public $pagecount;
    public $qs;
    const PAGE_RANGE = 2;

    public function __construct ($rowcount = null, $rowsperpage = null, 
        $currentpage = null, array $querystrings = null)
    {
        if (!is_null($rowcount) && !is_null($rowsperpage) && !is_null($currentpage)) {
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

    //validates the user input via GET method
    public static function pageValidator($totalrows, $rowsperpage)
    {
        $totalpages = ceil($totalrows/$rowsperpage);
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $currentpage = (int) $_GET['page'];
        } else {
            $currentpage = 1;
        }

        if ($currentpage > $totalpages) {
            $currentpage = $totalpages;
        }

        if ($currentpage < 1) {
            $currentpage = 1;
        }

        $pages = $currentpage;
        return $pages;
    }

    //outputs the pagination control buttons
    public function __toString()
    {
        $qs = "";       //additional querystring
        foreach((array) $this->querystrings as $querystring) {
            $qs .= "&{$querystring}";
        }
        $pagectrl = "<div class='pagination pagination-centered'><ul>";
        if ($this->currentpage > 1) {
            $pagectrl .= "<li><a href='?page=1{$qs}' class='btn '> << </a></li>";
            $prevpage = $this->currentpage - 1;
            $pagectrl .= "<li><a href='?page=$prevpage{$qs}' class='btn '> < </a></li> "; 
        }
 
        for($i = ($this->currentpage - self::PAGE_RANGE); $i <= ($this->currentpage + self::PAGE_RANGE); $i++) {
            if (($i > 0) && ($i <= $this->pagecount)) {
                if ($i == $this->currentpage) {
                    $pagectrl .= "<li class='disabled'><a class='btn '>$i</a></li>";
                } else {
                    $pagectrl .= "<li><a href='?page=$i{$qs}' class='btn '>$i</a></li> ";
                }
            }       
        }
        if ($this->currentpage != $this->pagecount) {
            $nextpage = $this->currentpage + 1;
            $pagectrl .= "<li><a href='?page=$nextpage{$qs}' class='btn '> > </a></li>";
            $pagectrl .= "<li><a href='?page=$this->pagecount{$qs}' class='btn '> >> </a></li>";
        }
    $pagectrl .="</ul></div>";
    return $pagectrl;
    }
}