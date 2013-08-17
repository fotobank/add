<?
 if (!isset($_SESSION['admin_logged'])) die();

  if(isset($_GET['nid'])) {

	 $_GET['nid'] = abs(intval($_GET['nid']));

	 if($db->query('SELECT COUNT(*) FROM `news` WHERE `id`=?i',array($_GET['nid']),'el')==0)
		{
		  echo '<div class="title2">Извините ,данная новость не существует
	           <br/><a href="index.php">К новостям</a></div>';exit;
		}
	 $db->query('UPDATE `news` SET `pros`=`pros`+1 WHERE id=?i',array($_GET['nid']));

	 $news = $db->query('SELECT * FROM `news` WHERE id=?i',array($_GET['nid']),'row');

	 include 'sys/bb.php';

//вывод новости

	 echo '<div class="title2">'.htmlspecialchars(stripslashes($news['name']));
	 $str='  <a href="newsadm.php?act=newsdel&amp;id='.$_GET['nid'].'">[del]</a>
<a href="newsadm.php?act=newsedit&amp;id='.$_GET['nid'].'">[edit]</a>'; echo if_adm($str);
	 echo '</div><div class="content">'.bb(htmlspecialchars(stripslashes($news['head']))).'</div><div class="title">';

	 if($db->query('SELECT COUNT(*) FROM `config` WHERE common=?i',array(1),'el')==1 && $news['komm']==1){
		echo '<a href="news/komm.php?nid='.$_GET['nid'].'">Прокомментировать</a> ['.$db->query('SELECT COUNT(*) FROM `komments` WHERE `news_id`=?i',array($_GET['nid']),'el').']<br/>';}
	 echo 'Просмотров: '.$news['pros'].'<br/>
  Дата добавления: '.$news['date'].'</div>';
  }