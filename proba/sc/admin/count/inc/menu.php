<table width=100% bgcolor=#999999>
<tr align=center>
   <td><a href=index.php  <? if($menu_id ==0) { echo" class=menuid"; } else{ echo" class=menu"; } ?>>Главная</a></td>
   <td><a href=host_hit.php  <? if($menu_id ==1) { echo" class=menuid"; } else{ echo" class=menu"; } ?>>Хосты и хиты</a></td>
   <td><a href=syst_broz.php   <? if($menu_id ==2) { echo" class=menuid"; } else{ echo" class=menu"; } ?>>Системы и браузеры</a></td>
   <td><a href=ip.php   <? if($menu_id ==3) { echo" class=menuid"; } else{ echo" class=menu"; } ?>>ip-адреса</a></td>
   <td><a href=search.php   <? if($menu_id ==4) { echo" class=menuid"; } else{ echo" class=menu"; } ?>>Поисковики</a></td>
   <td><a href=zapros.php   <? if($menu_id ==5) { echo" class=menuid"; } else{ echo" class=menu"; } ?>>Поисковые запросы</a></td>
   <td><a href=reff.php   <? if($menu_id ==6) { echo" class=menuid"; } else{ echo" class=menu"; } ?>>Рефферы</a></td>
   <td><a href=ban_list.php  <? if($menu_id ==7) { echo" class=menuid"; } else{ echo" class=menu"; } ?>>Бан-лист</a></td>
</tr>
</table>