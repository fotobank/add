<?PHP
$act_url = $_SERVER['PHP_SELF'];
//�������
if ($act_url == '/index.php') {
			$title       = "���� � ���������� � ������ Creative line studio";
			$description = 'Creative line studio ���������������� ���� � ����������� � ������';
			$keywords    = "����,�����,������,�,������";
			//��������
} elseif ($act_url == '/fotobanck_adw.php') {
			$title       = "����-���� ������� ������ ���������� Creative line studio";
			$description = "������� ���� ������ Creative line studio";
			$keywords    = "������,�������,����,�,������";
			//������
} elseif ($act_url == '/uslugi.php') {
			$title       = "������ ��������� � ����� ��������� � ������ Creative line studio";
			$description = "������ ������������������ ��������� � �������������� � ������ Creative line studio";
			$keywords    = "��������,�������������,����,�����,�,������";
			//����
} elseif ($act_url == '/ceny.php') {
			$title       = "���� �� ������ ��������� � �������������� � ������ Creative line studio";
			$description = "������ ������������������ ��������� � ��������������, ���� � ������������ � ������ Creative line studio";
			$keywords    = "����,������,����������,�����������,��������,�������������,����,�����,�,������";
			//��������
} elseif ($act_url == '/kontakty.php') {
			$title       = "�������� Creative line studio";
			$description = "�������� ������������������ ��������� � ��������������, ���� � ������������ � ������ Creative line studio";
			$keywords    = "��������,����,������,����������,�����������,��������,�������������,����,�����,�,������";
			//��������
} elseif ($act_url == '/gb/index.php') {
			$title       = "�������� Creative line studio";
			$description = "������ �������� Creative line studio";
			$keywords    = "��������,����,������,����������,�����������,��������,�������������,����,�����,�,������";
			//����� �����������
} elseif ($act_url == '/registr.php') {
			$title       = "����������� �� ����� Creative line studio";
			$description = "����������� ���������� ��� ����������� � ������� ���������� � ���������";
			$keywords    = "�����������,�����,������,�����������,��������,�����,�����";
			//�������� ������������
} elseif ($act_url == '/page.php') {
			$title       = "�������� ������������ �� ����� Creative line studio";
			$description = "����������, ��������� � �������� ������� ������ ������������, ���������� ��������� ����������, �������� �������� ����� �����������";
			$keywords    = "����������, ���������, ��������,  �������, ������, ����������, ����������";
} else {
			$title       = "���� � ���������� � ������ Creative line studio";
			$description = "Creative line studio ���������������� ���� � ����������� � ������";
			$keywords    = "����,�����,������,�,������";
}