<?php
       // error_reporting(E_ALL);
       // ini_set('display_errors', 1);
       define('BASEPATH', realpath(__DIR__).'/', true);
       error_reporting(0);
       include(BASEPATH.'inc/config.php');
       include(BASEPATH.'inc/func.php');
       ob_start();
       $hаch   = $_POST['id'];
       $status = 'ERR';
       $msg    = 'File not found!';
       $balans = NULL;;
       $votes = NULL;
       $vote  = array();
       $id    = NULL;
       if (!$session->has("logged")) {
              $msg = 'Голосование доступно только загегистрированным пользователям. Пожалуйста, зарегистрируйтесь и войдите на сайт под своим именем!';
       } else {
              if ($hаch) {

                     include(__DIR__.'/classes/md5/md5_ini.php'); // подключть настройки md5 class
                     $id = go::call('md5_loader', $ini)->idImg(array("query" => $hаch)); // восстановить номер фотографии из хеша
                     $id_album = go\DB\query('select id_album from photos where id = ?i', array($id), 'el');
                     if ($id_album) {
                            $balans     = floatval(go\DB\query('select balans from users where id = ?i', array($_SESSION['userid']), 'el'));
                            $vote       = go\DB\query('select vote_price, vote_time, vote_time_on from albums where id = ?i', array($id_album), 'row');
                            $golos_time = go\DB\query('select  golos_time from votes where id_user = ?i and id_photo = ?i ORDER BY golos_time desc limit 1',
                                   array($_SESSION['userid'], $id), 'el');
                            $time_zone  = 60; // поправка на временную зону
                            $time_ost   = (strtotime($golos_time) - strtotime("-".($vote['vote_time'] + $time_zone)." minutes")) / 60;
                            if ($vote['vote_time_on'] == '1' && $time_ost > 0) {
                                   $msg = 'Вы уже голосовали за эту фотографию!<br>Следующее голосование будет возможно через '.showPeriod($time_ost).' минут!';
                            } elseif (floatval($vote['vote_price']) <= $balans) {
                                   go\DB\query('insert into votes (id_user, id_photo) values (?i,?i)', array($_SESSION['userid'], $id));
                                   go\DB\query('update photos set votes = votes + 1 where id = ?i', array($id));
                                   go\DB\query('update users set balans = balans - ?f where id = ?i', array($vote['vote_price'], $_SESSION['userid']));
                                   $votes  = go\DB\query('select `votes` from `photos` where `id` = ?i', array($id), 'el');
                                   $balans = floatval(go\DB\query('select balans from users where id = ?i', array($_SESSION['userid']), 'el'));
                                   $status = 'OK';
                                   $msg    = 'Ваш голос добавлен !';
                            } else {
                                   $msg = 'На Вашем счете недостаточно денег !';
                            }
                     }
              }
       }
       ob_end_clean();
       echo json_encode(array('status' => $status, 'msg' => $msg, 'balans' => $balans, 'votpr' => $vote['vote_price'], 'votes' => $votes, 'idPhoto' => $id));
       go\DB\Storage::getInstance()->get()->close(true);
?>
