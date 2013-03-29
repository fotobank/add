<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 29.03.13
 * Time: 2:26
 * To change this template use File | Settings | File Templates.
 */
// Сам скрипт "pages.php"


$FirstPage = '<a class="next" href="'.$PageVarName.'=1#home">«  1 </a>&nbsp;&nbsp;...&nbsp;&nbsp;&nbsp';
$lastPage = '...&nbsp;&nbsp <a class="next" href="'.$PageVarName.'='.$SLPages.'"> '.$SLPages.'</a>&nbsp;&nbsp;';
function Forvard($PageTemp, $PageVarName)
    {
    return '<a class="PageArrow" href="'.$PageVarName.'='.$PageTemp.'">&rarr;</a>';
    }
function Backward($PageTemp, $PageVarName)
    {
    return '<a class="PageArrow" href="'.$PageVarName.'='.$PageTemp.'">&larr;</a>&nbsp;&nbsp;&nbsp;';
    }
function WriteNumbers($SLPage, $CurentPage,$PageVarName)
    {
    if ($SLPage == ($CurentPage - 1))
        {
            echo '<span class="CurPageSpan"><b> '.$CurentPage.' </b>&nbsp;&nbsp;</span>';
        }
    else
        {
            echo '<a class="PageNumber" href="'.$PageVarName.'='.$CurentPage.'"> '.$CurentPage.' </a>&nbsp;&nbsp;';
        }
    }
?><p class="PagesBody"><?


    if ($record_count > $CountToShow)
        {
            $AbsRows = $record_count - $record_count % $CountToShow;
            $StayRows = $record_count - $AbsRows;
            $AbsPages = floor($record_count / $CountToShow);
            $SLPages = $AbsPages;
            if ($StayRows) $SLPages++;

            //    ------------- $record_count = Общее количество элементов.
            //    ------------- $AbsRows = Количество элементов, на полностью заполненых страницах.
            //    ------------- $StayRows = Количество элементов на "поледней" странице.
            //    ------------- $AbsPages = Общее количество страниц, полностью заполненых элементами.
            //    ------------- $SLPages = Общее количество страниц.
            $SLPage = $CurPage; //    ------------- = Номер текущей страницы.
            if (!$SLPage)
                {
                    $SLPage = 1;
                }
            if ($StayRows == 0)
                {
                    $SLBegin = Round($AbsRows / $AbsPages * ($SLPage - 1));
                }
            else
                {
                    if ($SLPage > $AbsPages)
                        {
                            $SLBegin = $record_count - $StayRows;
                        }
                    else
                        {
                            $SLBegin = Round($AbsRows / $AbsPages * ($SLPage - 1));
                        }
                }
        }
    else
        {
            $SLBegin = 0;
        }
    $SLPageBegin = $SLBegin;

    $CurentPage++;

    $PageTemp = $_REQUEST[$PageVarName];
    if (!$PageTemp) $PageTemp = 1;
    $SLPage = $PageTemp - 1;
    if ($PageTemp > 1)
        {
            $PageTemp--;
            echo Backward($PageTemp, $PageVarName);
        }
    if (($SLPages > 10) && ($SLPage > 6))
        {
            echo $FirstPage;
        }
    $PageTemp = $SLPages - 3;
    if ($SLPages > 10)
        {
            if ($SLPage <= 5)
                {
                    for ($i = 1; $i < 11; $i++) WriteNumbers($SLPage, $i, $SLEdit, $PageVarName);
                }
            elseif (($SLPage < $PageTemp) && ($SLPage > 5))
                {
                    for ($i = $SLPage - 5; $i < $SLPage + 5; $i++) WriteNumbers($SLPage, $i, $SLEdit, $PageVarName);
                }
            else
                {
                    for ($i = $SLPages - 5; $i < $SLPages + 1; $i++) WriteNumbers($SLPage, $i, $SLEdit, $PageVarName);
                }
        }
    else
        {
            for ($i = 1; $i < $SLPages + 1; $i++) WriteNumbers($SLPage, $i, $SLEdit, $PageVarName);
        }

    if (($SLPages > 10) && ($SLPage < $PageTemp - 1))
        {
            echo $lastPage;
        }

    $PageTemp = $_REQUEST[$PageVarName];
    if (!$PageTemp) $PageTemp = 1;
    if ($SLPage < ($SLPages - 1))
        {
            $PageTemp++;
            echo Forvard($PageTemp, $PageVarName);
        }
    ?>
</p>