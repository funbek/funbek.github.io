<?
// ������ �� �����������
header("Expires: Mon, 23 May 1995 02:00:00 GTM");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GTM");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
//****

$log =="";
$error="no"; //���� ������� ������

require_once 'JsHttpRequest.php';
$JsHttpRequest =& new JsHttpRequest("windows-1251");

//�������� ����� ���������� � ������� �������� img_title
$comtext = trim($_POST['comtext']);
$email = trim($_POST['email']);
$name = trim($_POST['name']);


//�������� ������������ �����    
    if(!$name || strlen($name)>20 || strlen($name)<3)
    {
      $log.="<li>����������� ��������� ���� \"���� ���\" (3-15 ��������)!</li>";
      $eierr="yes";
    }




//�������� email ������
 
function isEmail($email)
            {
                return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i"
                        ,$email));
            } 
			
if($email == '')
                {
	$log .= "<li>����������, ������� ��� email!</li>";
	$error = "yes";
                  
                }			

else if(!isEmail($email))
                {
                   
	$log .= "<li>�� ����� ������������ e-mail. ����������, ��������� ���!</li>";
	$error = "yes";
                }


//�������� ������� ���������� ������ �����������
if (empty($comtext))
{
	$log .= "<li>���������� ������� ����� ���������!</li>";
	$error = "yes";
}
//****

//�������� ����� ������ �����������
if(strlen($comtext)>1010)
{
	$log .= "<li>������� ������� �����, � ����� ������������ 1000 ��������!</li>";
	$error = "yes";
}
//****	
	 
//�������� �� ������� ������� ����
$mas = preg_split("/[\s]+/",$comtext);
foreach($mas as $index => $val)
{
  if (strlen($val)>60)
  {
	$log .= "<li>������� ������� ����� (����� 60 ��������) � ������ ������!</li>";
	$error = "yes";
	break;
  }
}
//****
	
//������� ���� ���� ���� ������ �� ������� �����
$spam=1;  

for($i=0;$i<strlen($comtext);$i++)
{
	if((ord($comtext[$i])>=192) && (ord($comtext[$i])<=255)){$spam=0;break;}
}

if ($spam == 1)
{
	$log .= "<li>� ����������� ��� �� ����� ������� �����. �� �����������!</li>";
	$error = "yes";    
} 
//**** 
	
	
//������������� � �������������� ������� ��������
if (!get_magic_quotes_gpc())
{
$comtext = addslashes($comtext);
$email = addslashes($email);
$name = addslashes($name);
}

$comtext = htmlspecialchars($comtext);
$email = htmlspecialchars($email);
$name = htmlspecialchars($name);
//****

//���� ��� ������ ���������� email  
if($error=="no")
{
$prov = 0;
	
//�������� ������ ������ � ����� �����������
$emailadmin = 'admin@admin.com';//e-mail ������
$mes = "������� �� ����� $name �������� ��������� �� ����� �������� �����: $comtext";

$from = $email;
$to = $emailadmin;
$sub = '=?windows-1251?B?'.base64_encode('����� ���������').'?=';
$headers = 'From: '.$from.'
';
$headers .= 'MIME-Version: 1.0
';
$headers .= 'Content-type: text/plain; charset=windows-1251
';

mail($to, $sub, $mes, $headers);
//****

$ok ="<p style='font-family:Verdana; font-size:12px; border:2px solid #0c7f00; padding:10px; margin:20px; background-color:#ffffff;'><strong>�������,$name! ���� ��������� ����������!</strong></p>";

     
// ����������� Enter � ������� ������
$comtext=str_replace("\n","<br>\n",$comtext);
//****

//�������� ��������� � ������
$GLOBALS['_RESULT'] = array(
'error' => 'no',
'text' => $comtext,
'ok' => $ok
);
//****
}
else//���� ������ ����
{ 
$log = "<p><font color=#cc0000><strong>������</strong></font></p><ul style='font-family:Verdana; font-size:12px; border:2px solid #cc0000; padding:10px; margin:20px;'>".$log."</ul>";

//���������� ��������� � ������
$GLOBALS['_RESULT'] = array(
'error' => 'yes',      
'er_mess' => $log);
}  
?>
