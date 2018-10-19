<?php

       include __DIR__.'/alex/fotobank/Framework/Boot/config.php';
       ob_start();
       $hach = $_POST['id'];
       $status = 'ERR';
       $msg = 'File not found!';
       $balans = null;
       $votes = null;
       $vote = [];
       $id = null;
       if (!$session->has('logged')) {
              $msg =
                     'Голосование доступно только загегистрированным пользователям. Пожалуйста, зарегистрируйтесь и войдите на сайт под своим именем!';
       }
       elseif ($hach) {
              $ini = include __DIR__.'/classes/md5/md5_ini.php'; // подключть настройки md5 class
              $id = go::call('md5_loader', $ini)->idImg(['query' => $hach]); // восстановить номер фотографии из хеша
              $id_album = go\DB\query('select id_album from photos where id = ?i', [$id], 'el');
              if ($id_album) {
                     $balans =
                            (float)go\DB\query('select balans from users where id = ?i', [$_SESSION['userid']], 'el');
                     $vote = go\DB\query('select vote_price, vote_time, vote_time_on from albums where id = ?i',
                            [$id_album], 'row');
                     $golos_time =
                            go\DB\query('select  golos_time from votes where id_user = ?i and id_photo = ?i ORDER BY golos_time desc limit 1',
                                   [$_SESSION['userid'], $id], 'el');
                     $time_zone = 60; // поправка на временную зону
                     $time_ost =
                            (strtotime($golos_time) - strtotime('-'.($vote['vote_time'] + $time_zone).' minutes')) / 60;
                     if ($vote['vote_time_on'] == '1' && $time_ost > 0) {
                            $msg =
                                   'Вы уже голосовали за эту фотографию!<br>Следующее голосование будет возможно через '.
                                   showPeriod($time_ost).' минут!';
                     }
                     elseif ((float)$vote['vote_price'] <= $balans) {
                            go\DB\query('insert into votes (id_user, id_photo) values (?i,?i)',
                                   [$_SESSION['userid'], $id]);
                            go\DB\query('update photos set votes = votes + 1 where id = ?i', [$id]);
                            go\DB\query('update users set balans = balans - ?f where id = ?i',
                                   [$vote['vote_price'], $_SESSION['userid']]);
                            $votes = go\DB\query('select `votes` from `photos` where `id` = ?i', [$id], 'el');
                            $balans =
                                   (float)go\DB\query('select balans from users where id = ?i', [$_SESSION['userid']],
                                          'el');
                            $status = 'OK';
                            $msg = 'Ваш голос добавлен !';
                     }
                     else {
                            $msg = 'На Вашем счете недостаточно денег !';
                     }
              }
       }
       ob_end_clean();
       echo json_encode(['status' => $status, 'msg' => $msg, 'balans' => $balans, 'votpr' => $vote['vote_price'],
                         'votes'  => $votes, 'idPhoto' => $id]);
       go\DB\Storage::getInstance()->get()->close(true);
