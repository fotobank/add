<?php
			$id = (isset($argv[0])) ? $argv[0] : 404;
			$id = abs(intval($id));
			if (!$id)	{
						$id = 404;
			}
			// ������������� ������ ����� � ��������
			$a[401] = "��������� �����������!";
			$a[403] = "������������ �� ������ ��������������, ������ ��������!";
			$a[404] = "�������� �� �������! <br> <p style='font-size: 24px; color: #10109c;'>�������� ��� ���� �������, ���� �� ������� �������� �����.</p>";
			$a[500] = "���������� ������ �������!";
			$a[400] = "������������ ������!";
			// ��� ���������� �������� ���� ���������
			$body = <<<END

<div style='text-align: right;'>
    <img src='/img/_404.png' alt='404'>
</div>

END;
			if (isset($HTTP_REFERER))	{
						$body .= "�� ������ �� ��������: <b>$HTTP_REFERER</b><br />\n";
			}
			$renderData['block']            = 'error';
			$renderData['aId']              = $a[$id];
			$renderData['Id']               = $id;
			$renderData['SERVER_SIGNATURE'] = isset($GLOBALS['SERVER_SIGNATURE']) ? $GLOBALS['SERVER_SIGNATURE'] : '';
			$renderData['body']             = $body;