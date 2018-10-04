<?
    $page = $_GET['page'];
    $pnumber = 30;
    if(empty($pnumber)) $pnumber = 30;
    if(empty($page)) $page = 1;
    $begin = ($page - 1)*$pnumber;
    $end =$begin+$pnumber;

    $page_link = 4;
    $number = (int)($total/$pnumber);
    if((float)($total/$pnumber) - $number != 0) $number++;
    echo "<table  width=80% align=center class=pager><tr><td colspan=5><div><p>";
    // Проверяем есть ли ссылки слева
    if($page - $page_link > 1)
    {
      echo "<a class=linkip href=$_SERVER[PHP_SELF]?page=1><nobr>[1-$pnumber]</nobr></a>&nbsp;<em><nobr>&nbsp;...&nbsp;</nobr> </em>";
      // Есть
      for($i = $page - $page_link; $i<$page; $i++)
      {
          echo "&nbsp;<a class=linkip href=$_SERVER[PHP_SELF]?page=".$i."><nobr>[".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]</nobr></a>&nbsp;";
      }
    }
    else
    {
      // Нет
      for($i = 1; $i<$page; $i++)
      {
          echo "&nbsp;<a class=linkip href=$_SERVER[PHP_SELF]?page=".$i."><nobr>[".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]</nobr></a>&nbsp;";
      }
    }
    // Проверяем есть ли ссылки справа
    if($page + $page_link < $number)
    {
      // Есть
      for($i = $page; $i<=$page + $page_link; $i++)
      {
        if($page == $i)
          echo "<em><nobr>&nbsp;[".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]&nbsp;</nobr> </em>";
        else
          echo "&nbsp;<a class=linkip href=$_SERVER[PHP_SELF]?page=".$i."><nobr>[".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]</nobr></a>&nbsp;";
      }
      echo "<eme><nobr>&nbsp;...&nbsp;</nobr> </em>&nbsp;<a class=linkip href=$_SERVER[PHP_SELF]?page=$number><nobr>[".(($number - 1)*$pnumber + 1)."-$total]</nobr></a>&nbsp;";
    }
    else
    {
      // Нет
      for($i = $page; $i<=$number; $i++)
      {
        if($number == $i)
        {
          if($page == $i)
            echo "<em><nobr>&nbsp;[".(($i - 1)*$pnumber + 1)."-$total]&nbsp;</nobr></em>";
          else
            echo "&nbsp;<a class=linkip href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$pnumber + 1)."-$total]</a>&nbsp;";
        }
        else
        {
          if($page == $i)
            echo "<em><nobr>&nbsp;[".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]&nbsp;</nobr> </em>";
          else
            echo "&nbsp;<a class=linkip href=$_SERVER[PHP_SELF]?page=".$i."><nobr>[".(($i - 1)*$pnumber + 1)."-".$i*$pnumber."]</nobr></a>&nbsp;";
        }
      }
    }
echo"</td></tr></table>";
    ?>
    