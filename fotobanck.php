<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

include  ('inc/head.php');
include  ('inc/get-ip.php');
include  ('inc/ip-ban.php');
$ip = getip(); // Ip ������������

//���������� ����� �� ��������

define('PHOTOS_ON_PAGE', 21);

if (isset($_GET['album_id']))
    {
        $_SESSION['current_album'] = intval($_GET['album_id']);
       // check($ip, $ipLog, $timeout);
    }
if (isset($_GET['back_to_albums']))
    {
        unset($_SESSION['current_album']);
    }
if (isset($_GET['chenge_cat']))
    {
        unset($_SESSION['current_album']);
        $_SESSION['current_cat'] = intval($_GET['chenge_cat']);
    }
if (isset($_GET['unchenge_cat']))
    {
        unset($_SESSION['current_album']);
        unset($_SESSION['current_cat']);
    }

?>
<form name=vote_price>
<?
  $vote_price = floatval(get_param('vote_price'));
?>
<input type=hidden name=id1 value="<?= htmlspecialchars($vote_price);?>">
</form>


<div id="main">
<script type="text/javascript" src="/js/photo-prev.js"></script>


<!-- ���� ������ -->
<div class="modal-scrolable" style="z-index: 150;">
<div id="static" class="modal hide fade in animated fadeInDown" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="false">
    <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>-->
        <h3 style="color: #444444">���� ������:</h3>
    </div>
    <div class="modal-body">
        <div id="err-modal1" class="err_msg" style="display: none; float: left; margin-left: 90px; margin-bottom: 10px;"> ������ ������������, ������ �����������!</div>
        <div style="clear: both;"></div>
        <div style="ttext_white">
            �� ������ ������ ���������� ������. ���� �� ������ ������ ��� �����, ���������� ��������� � ���������� ����� email � �������
            <a href="kontakty.php"><span class="ttext_blue">"��������"</span>.</a>
        </div>
        <br/>
        <form action="fotobanck.php" method="post">
                <label class="ttext_red" style="float: left; margin-right: 10px;">������: </label>
                <input id="inputError" type="text" name="album_pass" value="" maxlength="20" />
                <input class="btn-small btn-primary" type="submit" value="����"/>
        </form>
    </div>
    <div class="modal-footer">
        <p id="err-modal2" style="float: left;"></p>
        <button type="button" data-dismiss="modal" class="btn" onClick="JavaScript: window.document.location.href='/fotobanck.php?back_to_albums'">� �� ����</button>
    </div>
</div>
</div>



<!-- ������ -->
<div id="error_inf" class="modal hide fade" tabindex="-1" data-replace="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 style="color:red">������������ ������.</h3>
    </div>
    <div class="modal-body">
        <div>
            <a href="kontakty.php"><span class="ttext_blue">������ ������?</span></a>
        </div>
    </div>
</div>


<!-- ������ ������� � ������� -->
<div id="zapret" class="modal hide fade" tabindex="-1" data-replace="true" style=" margin-top: -180px;">
    <div class="err_msg">
        <div class="modal-header">
            <h3 style="color:#fd0001">������ � ������� "<?=$_SESSION['album_name'][$_SESSION['current_album']]?>" ������������!</h3>
        </div>
        <div class="modal-body">
            <div style="color:black">�� ������������ 5 ������� ����� ������.� ����� ������, ��� IP ������������ �� 30
                �����.
            </div>
            <br> <? check($ip, $ipLog, $timeout); ?> <br><br> <a href="kontakty.php"><span class="ttext_blue">�������������� ������</span></a>
            <a style="float:right" class="btn btn-danger" data-dismiss="fotobanck.php" href="fotobanck.php?back_to_albums">�������</a>
        </div>
    </div>
</div>

<?

if (isset($_SESSION['current_album'])):


        $rs = mysql_query('select * from albums where id = '.intval($_SESSION['current_album']));
        $may_view = false;
        $album_data = false;
        if (mysql_num_rows($rs) == 0)
            {
                unset($_SESSION['current_album']);
            }
        else
            {
                $album_data = mysql_fetch_assoc($rs);
            }
        if ($album_data)
            {
                $may_view = true;
                if (!isset($_SESSION['album_name']) || !is_array($_SESSION['album_name']))
                    {
                        $_SESSION['album_name'] = array();
                    }
                $_SESSION['album_name'][$_SESSION['current_album']] = $album_data['nm'];
                if ($album_data['pass'] != '')
                    {
                        ?>
                        <div style="display:none;"><? check($ip, $ipLog, $timeout); ?></div><?
                        if (isset($_POST['album_pass']) && $_POST['album_pass'] != "")
                            {
                                if (!isset($_SESSION['album_pass']) || !is_array($_SESSION['album_pass']))
                                    {
                                        $_SESSION['album_pass'] = array();
                                    }
                                $_SESSION['album_pass'][$album_data['id']] = $_POST['album_pass'];
                                if (isset($_SESSION['album_pass'][$album_data['id']]) && $_SESSION['album_pass'][$album_data['id']] != $album_data['pass'] && $_SESSION['popitka'][$_SESSION['current_album']] != 0
                                )
                                    {
                                        /*echo "<script type='text/javascript'>
                                              window.onload = function(){ alert('�� ����� �������� ������!');}
                                              </script>";*/
                                        /*
                                        echo "<script type='text/javascript'>
                                        $(document).ready(function(){
                                        $('#error_inf').modal('show');
                                        });
                                        function gloze() {
                                        $('#error_inf').modal('hide');
                                        };
                                        setTimeout('gloze()', 3000);
                                        </script>";
                                        */
                                        ?>
                                        echo "<script type='text/javascript'>
                                        var InfDok = document.getElementById('err-modal1');
                                        if(InfDok)
                                        {
                                        InfDok.style.display = 'block';
                                        }
                                        </script>";
                                        <?
                                    }

                                if ($_SESSION['popitka'][$_SESSION['current_album']] > -5)
                                    {
                                        //  $_SESSION['popitka'][$_SESSION['current_album']]--;
                                    }
                            }
                        $may_view = (isset($_SESSION['album_pass']) && is_array($_SESSION['album_pass']) && isset($_SESSION['album_pass'][$album_data['id']]) && $_SESSION['album_pass'][$album_data['id']] == $album_data['pass']); // ���������� ������
                    }
                else
                    {
                        unset($_SESSION['popitka'][$_SESSION['current_album']]);
                    }
            }
        if (!$may_view)
            {

                if ($_SESSION['popitka'][$_SESSION['current_album']] > 0 && $_SESSION['popitka'][$_SESSION['current_album']] <= 5
                )
                    {
                        echo "<script type='text/javascript'>
                             $(document).ready(function load() {
                             $('#static').modal('show');
                             });

                             </script>";
                    }
                if ($_SESSION['popitka'][$_SESSION['current_album']] <= 0 && $_SESSION['popitka'][$_SESSION['current_album']] != -10
                )
                    {
                        echo "<script type='text/javascript'>
                             $(document).ready(function(){
                             $('#zapret').modal('show');
                             });
                             function gloze() {
                             $('#zapret').modal('hide');
                             location='fotobanck.php?back_to_albums';
                             }
                             setTimeout('gloze()', 10000);
                             </script>";
                        $_SESSION['popitka'][$_SESSION['current_album']] = 5;
                        record($ip, $ipLog, $goHere); //��� �� Ip
                    }

                if ($_SESSION['popitka'][$_SESSION['current_album']] >= 0 && isset($_POST['album_pass']) && $_POST['album_pass'] != ""
                  || $_SESSION['popitka'][$_SESSION['current_album']] >= 0 && isset($_POST['album_pass']) && $_POST['album_pass'] == NULL)
                    {
                        $_SESSION['popitka'][$_SESSION['current_album']]--;
                    }


                if ($_SESSION['popitka'][$_SESSION['current_album']] == 4)
                    {
                        $ostal = '� ��� �������� ';
                        $popitka = '�������';
                    }
                elseif ($_SESSION['popitka'][$_SESSION['current_album']] == 5)
                    {
                        $popitka = '';
                    }
                elseif ($_SESSION['popitka'][$_SESSION['current_album']] == 0)
                    {
                        $popitka = '��������� �������';
                    }
                else
                    {
                        $ostal = '� ��� �������� ���';
                        $popitka = '�������';
                    }

                if ($_SESSION['popitka'][$_SESSION['current_album']] != 0 && $_SESSION['popitka'][$_SESSION['current_album']] != 5)
                    {
                        $popitka = ($ostal.' '.($_SESSION['popitka'][$_SESSION['current_album']] + 1).' '.$popitka);
                    }

                    echo "<script type='text/javascript'>
                        var InfDok = document.getElementById('err-modal2');
                        var SummDok = '$popitka';
                        InfDok.innerHTML = SummDok;
                        </script>";
            }

                if (!isset($_SESSION['current_cat']))
                    {
                        echo "<script>window.document.location.href='/fotobanck.php?back_to_albums'</script>";
                    }

                 $razdel = mysql_result(mysql_query('select nm from categories where id = '.$_SESSION['current_cat']), 0);
    // <!-- ����������� - �������� ������ ����� ������� -->
        if (!$may_view)
            {
        ?>
        <div class="row">
           <div class="page">
                <a class="next" href="fotobanck.php?back_to_albums">� �����</a>
                <a class="next" href="fotobanck.php">� ����������� ��� ���</a>
            </div>
                <img style="margin: 50px 0 0 40px;" src="/img/stop2.jpg" width="615px" height="615px" />
                   <!-- <h3><span style="color: #ffa500">������ � ������� ������������ �������.  <? //check($ip, $ipLog, $timeout);?></span></h3>-->
                    <?
                    if ($_SESSION['popitka'][$_SESSION['current_album']] == -10) // �������� � ����� ������� ����
                        {
                            echo "<script type='text/javascript'>
                                             $(document).ready(function(){
                                             $('#zapret').modal('show');
                                             });
                                             function gloze() {
                                             $('#zapret').modal('hide');
                                             location='/fotobanck.php?back_to_albums';
                                             };
                                             setTimeout('gloze()', 10000);
                                             </script>";
                            $_SESSION['popitka'][$_SESSION['current_album']] = 5;
                        }
                }
            ?>

        </div>

        <?
if ($may_view):

   ?>

        <!-- �������� �������  -->

        <div class="zagol2"><h2><span style="color: #ffa500">���������� ������� "<?=$album_data['nm']?>"</span></h2></div>
        <div class="page">
        <a class="next" href="fotobanck.php?back_to_albums">� �����</a>
        <a class="next" href="fotobanck.php?unchenge_cat">� ������ "<?=$razdel?>"</a>
        <a class="next" href="fotobanck.php?back_to_albums">� ������ "<?=$album_data['nm']?>"</a>
        </div>  <!-- ������ ����� -->
        <div style="clear: both;"></div>
        <div class="span13 offset0">


            <div class="accordion" id="accordion2">
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">�����
                            ����������:</a>
                    </div>
                    <div id="collapseOne" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <p><span style="font-size:11.0pt;">����������, �������������� � ������� <strong>"<?=$album_data['nm']?>
                                        "</strong>, ������ ��������������� ������ ��������� � ��������� ������������ � ������ � ������� 13x18�� 300Dpi � ��������� ��������� � ����������� ������������ �������. ��������! � ����� �������� ����� �� ������� � ������ �������� ���������, �������������� �� ��������, ������ ����� � ������������� ������ ��� ������ ������������� � ���������� (���������, �����, ����������, �������� �����, ����� ����� � �.� ). ��� ������� ���������� �� ��� email,��������� ��� �����������, ������ ������ ��� ���������� ����� ���������� � ���������� <code>13x18��
                                        300Dpi</code> ��� <code>IP</code> - ������ � <code>��������
                                        �����</code>. ����������� ���������� �� ������ ����� ������������� � ����� ����������. ��� ������������� ���������� � ��������� ��� ������������ ����� ��������� � ����������.
                                            </span></p>
                        </div>
                    </div>
                </div>

                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                            ����������� ������� �����������: </a>
                    </div>
                    <div id="collapseTwo" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <p><span style="font-size:11.0pt;">�� ������ ������������� �� ������������� ��� ����������, ������� �� �������. ���� ����������, ��������� ������������ ���������� ������, ���������� � ������ ������� � ������ ������� � ��������� ������.
                                            </span></p>
                        </div>
                    </div>
                </div>

                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                            ����������� �� ������ ����� � ������: </a>
                    </div>
                    <div id="collapseThree" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <p><span style="font-size:11.0pt;">����������, ��������� ������ 5 ��������� � ��������, ��������������� ��� ���������� ���������.
                                            </span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- �������� -->






          <!--/*������� ���������� - ��������� �������*/ -->
                    <div id="alb_opis">
                        <div class="alb_logo">
                            <div id="fb_alb_fotoP">
                                <img src="album_id.php?num=<?= substr(($album_data['img']), 2, -4) ?>" width="130px" height="124px" alt="-"/>
                            </div>
                            <div id="fb_alb_nameP">

                            </div>
                        </div>
                        <?=$album_data['descr']?>
                    </div>
            <!-- ����� ��� 5  -->


                    <?
                    if ($may_view)
                        {
                            ?>

                            <h3>
                                <div style="text-align: center;">
                                    <span> ��� 5 �������:</span>
                                </div>
                            </h3>

<!-- 1 --><hr class="style-one"/>

                            <?
                            $rs = mysql_query('select * from photos where id_album = '.intval($_SESSION['current_album']).' order by votes desc, id desc limit 0, 5');
                            $foto_folder = mysql_result(mysql_query('select foto_folder from albums where id = '.intval($_SESSION['current_album']).'  '), 0);
                            if (mysql_num_rows($rs) > 0)
                                {
                                    $pos_num = 1;
                                    while ($ln = mysql_fetch_assoc($rs))
                                        {
                                            $source = $_SERVER['DOCUMENT_ROOT'].$foto_folder.$ln['id_album'].'/'.$ln['img'];
                                            $sz = getimagesize($source);
                                            if (intval($sz[0]) > intval($sz[1])) /*  ������ ��� 5 */
                                                {
                                                    $sz_string = 'width="170px"';
                                                }
                                            else
                                                {
                                                    $sz_string = 'height="195px"';
                                                }
                                            ?>

                                            <div  class="span1 offset1" >
                                                <figure class="ramka" onClick="JavaScript: preview(<?= $ln['id'] ?>);">
                                                    <span class="top_pos" style="opacity: 0;"><?=$pos_num?></span>
                                                    <img src="dir.php?num=<?= substr(trim($ln['img']), 2, -4) ?>" alt="<?= $ln['nm'] ?>" title="������� ��� ���������" <?=$sz_string?> />
                                                    <figcaption><span style="font-size: x-small; font-family: Times, serif; ">� <?=$ln['nm']?>
                                                            �������:<span class="badge badge-warning"> <span style="font-size: x-small; font-family: 'Open Sans', sans-serif; "><?=$ln['votes']?></span>
                                                                    </span><br>�������: <?echo str_repeat('<img src="img/reyt.png"/>', floor($ln['votes'] / 5));?>
                                                        </span></figcaption>
                                                </figure>
                                            </div>
                                            </div>

                                            <?
                                            $pos_num++;
                                        }
                                }
?><!-- 2 --><div style="clear: both"></div>
                            <hr class="style-one" style="clear: both; margin-top: 100px; margin-bottom: -20px;"><?
                        }
                    ?>



            <!-- ����� ���� � ������ -->
            <div id=foto-ajax>
                    <?
                    if ($may_view)
                        {
                            $current_page = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
                            if ($current_page < 1)
                                {
                                    $current_page = 1;
                                }
                            $start = ($current_page - 1) * PHOTOS_ON_PAGE;
                            $rs = mysql_query('select SQL_CALC_FOUND_ROWS p.* from photos p where id_album = '.intval($_SESSION['current_album']).' order by img ASC, id asc limit '.$start.','.PHOTOS_ON_PAGE);
                            $record_count = intval(mysql_result(mysql_query('select FOUND_ROWS() as cnt'), 0));
                            $foto_folder = mysql_result(mysql_query('select foto_folder from albums where id = '.intval($_SESSION['current_album']).'  '), 0);
                            if (mysql_num_rows($rs) > 0)
                                {
                                        ?>

<!-- 3 --><hr class="style-one" style="margin-top: -10px; margin-bottom: -40px;">
                                        <?

                                    while ($ln = mysql_fetch_assoc($rs))
                                        {
                                            $source = ($_SERVER['DOCUMENT_ROOT'].$foto_folder.$ln['id_album'].'/'.$ln['img']);
                                            $sz = getimagesize($source);
                                            /* ������ ��������� */
                                            if (intval($sz[0]) > intval($sz[1]))
                                                {
                                                    $sz_string = 'width="155px"';
                                                }
                                            else
                                                {
                                                    $sz_string = 'height="170px"';
                                                }
                                            ?>

                                            <div class="podlogka">
                                                <figure class="ramka" onClick="JavaScript: preview(<?= $ln['id'] ?>);">
                                                    <img src="dir.php?num=<?= substr(trim($ln['img']), 2, -4) ?>" title="�� ���������� ������������� <?= $ln['votes'] ?> �������. ������� ��� ���������." <?=$sz_string?> />


                                                
                                                    <figcaption>� <?=$ln['nm']?></figcaption>
                                                </figure>
                                            </div>

                                        <?
                                        }
                                }
                        }
                    ?>

          </div>



         <!-- ���� -->
<!-- 4 --><hr class="style-one" style="clear: both; margin-bottom: -30px;"/>


        <!--����� ��������� ������� -->
        <?
        /** @var $record_count  ���������� ���������� � ������� */
        if (isset($record_count))
            {
                if ($may_view && $record_count > PHOTOS_ON_PAGE)
                    {
                        $page_count = ceil($record_count / PHOTOS_ON_PAGE);
                        ?>
                        <!-- ������������ �������� -->
                        <h4><a id="home"  style="float: left">�������� <?=$current_page?></a></h4>
                        <div class="pagination" align="center">

                        <?
                    if ($current_page == 1)
                    {
                        ?>
                        <span class="disabled">� </span>
                        <span class="disabled">� ����������</span>
                        <?

                    } else {

                        ?>
                         <a class="next" href="fotobanck.php?album_id=<?= intval($_SESSION['current_album'])?>&amp;pg=1#home">� </a>
                         <a class="next" href="fotobanck.php?album_id=<?= intval($_SESSION['current_album'])?>&amp;pg=<?=($current_page-1)?>#home">� ����������</a>
                        <?
                    }

                            for ($i = 1; $i <= $page_count; $i++)
                                {

                                    if ($i == $current_page)
                                        {
                                            //������� ��������
                                            ?>
                                            <span class="current"><?=$i?></span>

                                        <?
                                        }
                                    else
                                        {
                                            //������ �� ������ ��������
                                            ?>
                                            <a href="fotobanck.php? album_id=<?= intval($_SESSION['current_album']) ?> &amp; pg=<?= $i ?>#home"><?=$i?></a>
                                        <?
                                        }
                                }

                                    if ($current_page == $page_count)
                                        {
                                            ?>
                                            <span class="disabled">��������� �</span>
                                            <span class="disabled">����. �</span>
                                        <?

                                        }
                                    if ($current_page < $page_count)
                                        {
                                        ?>
                                        <a class="next" href="fotobanck.php?album_id=<?= intval($_SESSION['current_album'])?>&amp;pg=<?=($current_page + 1)?>#home">��������� �</a>
                                        <a class="next" href="fotobanck.php?album_id=<?= intval($_SESSION['current_album'])?>&amp;pg=<?=($page_count)?>#home"> �</a>
                                        <?
                                         }
                            ?>

                        </div>
                        <h4><a id="home" style="float: right">����� - <?=$record_count?> ��.</a></h4><div style="clear: both;"></div>
                    <?
                    }
            }

        //<!--� ��������� ����� ����� �� ���� ���������� ����������-->

    endif;


//<!-- ����� �������� � �������� -->
 else:

    if (isset($_SESSION['current_cat']))
        {
            $current_cat = intval($_SESSION['current_cat']);
        }
    else
        {
            $current_cat = -1;
        }
    if ($current_cat > 0)
        {
/* <!--������� ���� nm �� �� � ����� --> */
          if (isset($_SESSION['current_cat']))  $razdel = mysql_result(mysql_query('select nm from categories where id = '.$_SESSION['current_cat']), 0);
       ?><div class="zagol2"><h2><span style="color: #ffa500">������ ��������� - "<?=$razdel;?>"</span></h2></div>
 <!-- ������ ����� -->

            <div class="page">
                <a class="next" href="fotobanck.php?unchenge_cat">� �����</a>
                <a class="next" href="fotobanck.php?unchenge_cat">� ������ "<?=$razdel;?>"</a>
            </div>
         <div style="clear: both"></div>

 <!-- ���������� ������ �������� �� �������� ��������   -->
            <?
            $rs = mysql_query('select * from albums where id_category = '.$current_cat.' order by order_field asc');
            /*  ����� ��������� ���������� �� �������� ��������  */
            echo mysql_result(mysql_query('select txt from categories where id = '.$current_cat.'  '), 0);
            // ������ ��������
    if (mysql_num_rows($rs) > 0)
       {
                    $i = 0;
                    $h = 0;

                    while ($ln = mysql_fetch_assoc($rs))
                        {
                            $top = $h * 1 + 20;
                            $left = $i * 250;
                            ?>
                            <div class="div_tab">
                                <div class="div_t">
                                <div class="div_fb3" style="top:<?= $top ?>px; left:<?= $left ?>px;">
                                    <a href="fotobanck.php?album_id=<?= $ln['id'] ?>">
                                    <img src="album_id.php?num=<?= substr(($ln['img']), 2, -4) ?>" id="album_<?= $ln['id'] ?>_2" alt="<?= $ln['nm'] ?>" title="��������" class="img3"/>
                                    </a>
                                    <br>
                                    <span class="prev_name"><?=$ln['nm']?></span>
                                </div>
                                </div>
                            </div>
                            <?
                            $i++;
                            if ($i > 4)
                                {
                                    $h++;
                                    $i = 0;
                                    ?>
                                    <table border="0" width="100%" HEIGHT="250">
                                        <tr>
                                            <td>
                                                <HR SIZE=2>
                                                <br><br><br>
                                                <HR SIZE=2 WIDTH=100%>
                                                <br>
                                            </td>
                                        </tr>
                                    </table>
                                <?
                                }
                        }
                    if ($i != 0)
                        {
                            ?>
                            <table border="0" width="100%" HEIGHT="250">
                                <tr>
                                    <td>
                                        <HR SIZE=2>
                                        <br><br><br>
                                        <HR SIZE=2 WIDTH=100%>  <!--����� �������� -->
                                        <br>
                                    </td>
                                </tr>
                            </table>

                        <?
                        }
                }
        }
    else
        {
            ?>
            <br>

            <h2><span style="color: #ffa500">����� ���������</span></h2><br>
            <table>
                <tr>
                    <td>

                        <?
                        $rs = mysql_query('select * from categories order by id asc');
                        while ($ln = mysql_fetch_assoc($rs))
                            {
                            // ������ ��������
                                ?>
                                <a class="button gray" href="fotobanck.php?chenge_cat=<?= $ln['id'] ?>"><?=$ln['nm']?> </a>
                            <?
                            }
                        ?>

                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="cont_fb"></div>
                    </td>
                </tr>
            </table>

       <?
      }
endif; ?>


</div>
<div class="end_content">


</div></div>

<?php include ('inc/footer.php');
?>
