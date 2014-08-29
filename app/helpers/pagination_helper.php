<?php
function pagination($rowcount, $rowsperpage)
{
    ##################          START  MODEL                    #########################
    // $sql = "SELECT COUNT(*) FROM comment";
    // $result = mysql_query($sql);
    // $r = mysql_fetch_row($result);
    // $numrows = $rowcount[0];
    ##################           END   MODEL                    #########################
    $pagectrl = "";


    // $rowsperpage = 5;
    $totalpages = ceil($rowcount / $rowsperpage);


    if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage']))
    {
        $currentpage = (int) $_GET['currentpage'];
    }
    else
    {
        $currentpage = 1;
    }

    if ($currentpage > $totalpages)
    {
        $currentpage = $totalpages;
    }

    if ($currentpage < 1)
    {
        $currentpage = 1;
    }


    ##################          START  MODEL                    #########################
    // $lowerlimit = ($currentpage - 1) * $rowsperpage;
    // $sql = "SELECT * FROM comment ORDER BY id DESC LIMIT $lowerlimit, $rowsperpage";
    // $result = mysql_query($sql);
    // if(mysql_num_rows($result)>0)
    // {
    //     while ($rows = mysql_fetch_array($result))
    //     {
    //         $id             = $rows['id'];
    //         $uname          = $rows['username'] ;
    //         $body           = $rows['body'];
    //         $datecreated    = $rows['created'];

    //         $lists[]    = "$id - $uname - $datecreated";
    //     }
    // }
    ##################           END   MODEL                    #########################


    $range = 2;
    if ($currentpage > 1)
    {
    $pagectrl .= " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'> First</a>";
    $prevpage = $currentpage - 1;
    $pagectrl .= " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'> Previous</a> ";
    }

    for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++)
    {
        if (($x > 0) && ($x <= $totalpages))
        {
            if ($x == $currentpage)
            {
                $pagectrl .= "$x ";
            }
            else
            {
                $pagectrl .= "<a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
            } 
        } 
    } 

    if ($currentpage != $totalpages)
    {
        $nextpage = $currentpage + 1;
        $pagectrl .= "<a href='?currentpage=$nextpage'>Next</a> ";
        $pagectrl .= "<a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>Last</a> ";
    }

    return $pagectrl;
}

function getvalidator()
{
    
}