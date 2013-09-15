<?php

/**
 * разница между двумя датами
*/

error_reporting(E_ALL);
header("content-type: text/html; charset=windows-1251");

if(function_exists('date_default_timezone_set'))
{
    date_default_timezone_set('Europe/Kiev');
}

class dtimediff
{
    // set data
    function setdata($status, $autorev, $showsec, $showday, $df, $dt, $mess)
    {
        $this->status = $status;
        $this->autorev = $autorev;
        $this->showsec = $showsec;
        $this->showday = $showday;
        ($df != '') ? $this->data_from = $df : $this->data_from = date('Y-m-d H:i:s');
        ($dt != '') ? $this->data_to = $dt : $this->data_to = date('Y-m-d H:i:s');
        $this->font = 'font-family:verdana; color:black; font-size:13px; font-weight:normal;';
        $this->mess = $mess;
    }
    // manipulation data
    function diff()
    {
        if ($this->status != false)
        {
            $this->tc = $this->data_to;
            if (strlen($this->data_to) == 19)
                $this->data_to = $this->data_to;
            else    
                $this->data_to = $this->data_to.' 00:00:00';  
                          
            if (!is_int($this->data_from)) 
            {
                $this->sdata_from = strtotime($this->data_from);
            }

            if (!is_int($this->data_to)) 
            {
                $this->sdata_to = strtotime($this->data_to);
            }

            $gd_from = getdate($this->sdata_from);
            $gd_to = getdate($this->sdata_to);
            $this->sumdays = round(abs(mktime(0, 0, 0, $gd_from['mon'], $gd_from['mday'], $gd_from['year']) - mktime(0, 0, 0, $gd_to['mon'], $gd_to['mday'], $gd_to['year'])) / 86400);

            if ($this->sdata_from > $this->sdata_to and $this->autorev == true) 
            {
                $this->ttime = $this->sdata_from;
                $this->sdata_from = $this->sdata_to;
                $this->sdata_to = $this->ttime;
            }
          
            $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');
            $diffs = array();

            foreach ($intervals as $interval) 
            {
                $diffs[$interval] = 0;
                $this->ttime = strtotime('+1 '.$interval, $this->sdata_from);
                while ($this->sdata_to >= $this->ttime) 
                {
                    $this->sdata_from = $this->ttime;
                    $diffs[$interval]++;
                    $this->ttime = strtotime('+1 '.$interval, $this->sdata_from);
                }
            }
    
            $this->years = ($diffs['year'] < 10) ? '0'.$diffs['year'] : $diffs['year'];
            $this->months = ($diffs['month'] < 10) ? '0'.$diffs['month'] : $diffs['month'];
            $this->days = ($diffs['day'] < 10) ? '0'.$diffs['day'] : $diffs['day'];
            $this->hours = ($diffs['hour'] < 10) ? '0'.$diffs['hour'] : $diffs['hour'];
            $this->minuts = ($diffs['minute'] < 10) ? '0'.$diffs['minute'] : $diffs['minute'];
            $this->seconds = ($diffs['second'] < 10) ? '0'.$diffs['second'] : $diffs['second'];

            if ($this->years == 0)
                $this->tyears = '';
            else if ($this->years == 1)
            	$this->tyears = 'год';
            else if ((($this->years > 1) && ($this->years < 5)) || (($this->years > 20) && (($this->years % 10 > 1) && ($this->years % 10 < 5))))
            	$this->tyears = 'lata';
            else
            	$this->tyears = 'lat';
        }
        else
        {
            // no reaction
        }
    }
    // show data
    function display()
    {   
        if ($this->status != false) 
        {
            if (strtotime('now') < strtotime($this->tc) and $this->autorev != true)
            {
                echo ($this->days > 1) ? '<font style="'.$this->font.'"><strong>'.$this->mess['1'].'</strong>'.(($this->years > 0) ? '<strong>'.$this->years.'</strong>' : '').'<small> '.$this->tyears.' </small>'.(($this->months > 0) ? '<strong>'.$this->months.'</strong>' : '').(($this->months > 0) ? ' <small>мес. </small> ' : '').(($this->days > 0) ? '<strong>'.$this->days.'</strong><small>'.(($this->days == 1) ? ' dzien' : ' дней').'</small>' : '').' '.(($this->hours > 0) ? '<strong>'.$this->hours.'</strong>' : '').(($this->hours > 0) ? ' <small> час. </small> ' : '').(($this->minuts > 0) ? '<strong>'.$this->minuts.'</strong>' : '').(($this->minuts > 0) ? ' <small> мин. </small> ' : '').(($this->showsec == true) ? (($this->seconds > 0) ? '<strong>'.$this->seconds.'</strong>' : '').(($this->seconds > 0) ? ' <small> сек. </small> ' : '') : '').(($this->showday == 1) ? '(<strong>'.$this->sumdays.'</strong>'.(($this->sumdays > 1) ? ' дней' : ' dzien').')' : '').'</font>' : '<font style="'.$this->font.'"><strong>'.$this->mess['2'].'</strong>'.(($this->years > 0) ? '<strong>'.$this->years.'</strong>' : '').'<small> '.$this->tyears.' </small>'.(($this->months > 0) ? '<strong>'.$this->months.'</strong>' : '').(($this->months > 0) ? ' <small>мес. </small> ' : '').(($this->days > 0) ? '<strong>'.$this->days.'</strong><small>'.(($this->days == 1) ? ' dzien' : ' дней').'</small>' : '').' '.(($this->hours > 0) ? '<strong>'.$this->hours.'</strong>' : '').(($this->hours > 0) ? ' <small> час. </small> ' : '').(($this->minuts > 0) ? '<strong>'.$this->minuts.'</strong>' : '').(($this->minuts > 0) ? ' <small>мин. </small> ' : '').(($this->showsec == true) ? (($this->seconds > 0) ? '<strong>'.$this->seconds.'</strong>' : '').(($this->seconds > 0) ? ' <small> сек. </small> ' : '') : '').(($this->showday == 1) ? '(<strong>'.$this->sumdays.'</strong>'.(($this->sumdays > 1) ? ' дней' : ' dzien').')' : '').'<strong>'.$this->mess['3'].'</strong>'.'</font>';
            }
            else if (strtotime('now') > strtotime($this->tc) and $this->autorev == true)
            {
                echo ($this->days > 1) ? '<font style="'.$this->font.'"><strong>'.$this->mess['5'].'</strong>'.(($this->years > 0) ? '<strong>'.$this->years.'</strong>' : '').'<small> '.$this->tyears.' </small>'.(($this->months > 0) ? '<strong>'.$this->months.'</strong>' : '').(($this->months > 0) ? ' <small>мес. </small> ' : '').(($this->days > 0) ? '<strong>'.$this->days.'</strong><small>'.(($this->days == 1) ? ' dzien' : ' дней').'</small>' : '').' '.(($this->hours > 0) ? '<strong>'.$this->hours.'</strong>' : '').(($this->hours > 0) ? ' <small> час. </small> ' : '').(($this->minuts > 0) ? '<strong>'.$this->minuts.'</strong>' : '').(($this->minuts > 0) ? ' <small>мин. </small> ' : '').(($this->showsec == true) ? (($this->seconds > 0) ? '<strong>'.$this->seconds.'</strong>' : '').(($this->seconds > 0) ? ' <small> сек. </small> ' : '') : '').(($this->showday == 1) ? '(<strong>'.$this->sumdays.'</strong>'.(($this->sumdays > 1) ? ' дней' : ' dzien').')' : '').'</font>' : '<font style="'.$this->font.'"><strong>'.$this->mess['5'].'</strong>'.(($this->years > 0) ? '<strong>'.$this->years.'</strong>' : '').'<small> '.$this->tyears.' </small>'.(($this->months > 0) ? '<strong>'.$this->months.'</strong>' : '').(($this->months > 0) ? ' <small>мес. </small> ' : '').(($this->days > 0) ? '<strong>'.$this->days.'</strong><small>'.(($this->days == 1) ? ' dzien' : ' дней').'</small>' : '').' '.(($this->hours > 0) ? '<strong>'.$this->hours.'</strong>' : '').(($this->hours > 0) ? ' <small> час. </small> ' : '').(($this->minuts > 0) ? '<strong>'.$this->minuts.'</strong>' : '').(($this->minuts > 0) ? ' <small>мин. </small> ' : '').(($this->showsec == true) ? (($this->seconds > 0) ? '<strong>'.$this->seconds.'</strong>' : '').(($this->секonds > 0) ? ' <small> сек. </small> ' : '') : '').(($this->showday == 1) ? '(<strong>'.$this->sumdays.'</strong>'.(($this->sumdays > 1) ? ' дней' : ' dzien').')' : '').'<strong>'.$this->mess['6'].'</strong>'.'</font>';
            }
            else
            {
                echo '<font style="'.$this->font.'"><strong>'.$this->mess['4'].'</strong>'.'</font>';
            }
        }
        else
        {
            // нет реакции
        }
    } 
}

$t = new dtimediff();
// статус, автореверс, показать секунды, показать дни, начало, конец, название события (массив)
$t->setdata(1, 0, 1, 1, date('Y-m-d H:i:s'), '2014-04-12 00:00:00', array('', 'осталось : ', 'оставил : ', ' для событий', 'конец отсчета', 'прошло : ', ' событий'));
$t->diff();
$t->display();

?>