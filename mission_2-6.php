<?php
session_start();//�ҏW�̂��߂Ƀf�[�^���󂯓n���K�v������
?>

<title>�����Ƀ^�C�g��������܂�</title>
<h1>�����Ƀ^�C�g��������܂�</h1>

<?php 
$filename="out2-6.txt";//�o�͐�
$fp=fopen($filename,"a+");
$array=file($filename);
$numofarray=count($array);//�f�[�^�s��
if($numofarray>0){
	$divide=explode("<>",$array[$numofarray-1]);
	$last=$divide[0];
$val3=$_SESSION["comnum"];
$val4=$_SESSION["arraynum"];
}
$last++;//�����܂ł�txt�t�@�C�����̍ŏI�s�̓��e�ԍ��擾
if (isset($_POST["button1"])){//�ǉ��܂��͕ҏW�̂Ƃ�
	$name=$_POST["name"];
	$comment=$_POST["comment"];
	$pass=$_POST["pass"];
	$time=date("Y/n/j G:i:s");//�N/��/�� ��:��:�b
	$com=$_POST["comnum"];
	if($_POST["comnum"]==null){ //�ǉ��̂Ƃ�
		fwrite($fp,"$last<>$name<>$comment<>$time<>$pass<>".PHP_EOL);
	}else{ //�ҏW�̂Ƃ�
		$divide=explode("<>",$array[$val4]);
		if($divide[4]==$pass){
			ftruncate($fp,0);
			for($out=0;$out<$val4;$out++) fwrite($fp,$array[$out]);
			fwrite($fp,"$val3<>$name<>$comment<>$time<>$pass<>".PHP_EOL);
			for($out=$val4+1;$out<$numofarray;$out++) fwrite($fp,$array[$out]);
		}else{
			echo "</br>Incorrect password.</br></br>";
		}
		unset($_SESSION["comnum"]);
		unset($_SESSION["prevcom"]);
		unset($_SESSION["prevname"]);
		unset($_SESSION["arraynum"]);
		}

} else if (isset($_POST["button2"])){//�폜�̂Ƃ�
	$delete=$_POST["delete"];
	$delpass=$_POST["delpass"];
	$num=0;
	foreach($array as $data){
		$divide=explode("<>",$data);
		if($divide[0]==$delete) $delnum=$num;//�폜�ԍ����s�ԍ��ɕϊ�
		$num++;
	}
	if(!isset($delnum)){
		echo "</br>Comment No.$delete doesn't exist.</br>";
	}else{
		$divide=explode("<>",$array[$delnum]);
		if($delpass==$divide[4]){
			ftruncate($fp,0);//�t�@�C���𔒎���
			for($out=0;$out<$delnum;$out++) fwrite($fp,$array[$out]);
			for($out=$delnum+1;$out<$numofarray;$out++)fwrite($fp,$array[$out]);
			echo "deleted No.$delete.";//��
		}else {
			echo "</br>Incorrect password.</br></br>";
		}
	}
}else if (isset($_POST["button3"])){//�ҏW�w�肳�ꂽ�R�����g���t�H�[���ɕԂ�
	$enum=$_POST["enum"];//�ҏW����ԍ����󂯎��
	$num=0;
	if(isset($enum)){
		foreach($array as $data){
			$divide=explode("<>",$data);
			if ($divide[0]==$enum){
				$_SESSION["prevname"]=$divide[1];//���O��Ԃ�
				$_SESSION["prevcom"]=$divide[2];//�R�����g��Ԃ�
				$_SESSION["arraynum"]=$num;//�ҏW�������R�����g�����s�ڂ���Ԃ�
				$_SESSION["comnum"]=$enum;//�ҏW�������R�����g�̔ԍ���Ԃ�
			}
			$num++;
		}
		if(!isset($_SESSION["arraynum"])) echo "</br>Comment No.$enum doesn't exist.</br></br>";
	}else {
		echo "</br>Input edit number.</br></br>";
	}
}
$val1=null;//�ҏW���铊�e�̖��O���󂯎�锠
$val2=null;//�ҏW����R�����g���󂯎�锠
$val3=null;//�ҏW����R�����g�̓��e�ԍ����󂯎�锠
$val4=null;//�ҏW����R�����g�̃e�L�X�g�t�@�C�����̍s�ԍ����󂯎�锠
if (isset($_SESSION["prevname"]))$val1=$_SESSION["prevname"];//prev�ɂ͕ҏW����R�����g�̃f�[�^������
if (isset($_SESSION["prevcom"]))$val2=$_SESSION["prevcom"];
if (isset($_SESSION["comnum"]))$val3=$_SESSION["comnum"];
if (isset($_SESSION["arraynum"]))$val4=$_SESSION["arraynum"];
?>

<form action="mission_2-6.php" method="post" />
<p><label>���O:<input type="text" name="name" size=10 value="<?php echo $val1; ?>" /></label> <!--���O-->
&nbsp;&nbsp;&nbsp;

<label>�R�����g:<input type="text" name="comment" size=40 value="<?php echo $val2; ?>" /></label><!--�R�����g-->
&nbsp;&nbsp;&nbsp;

<label>�p�X���[�h:<input type="password" name="pass" size=20 /></label> <!--���e���p�X���[�h-->

&nbsp;<button type="submit" name="button1" style="WIDTH:60px;HEIGHT:20px">add</button></p> <!--���e�{�^��-->

<p><label>�폜�������ԍ������:<input type="text" name="delete" size=5 /></label><!--�폜-->
&nbsp;&nbsp;&nbsp;<label>�p�X���[�h:<input type="password" name="delpass" size=20 /></label><!--�폜�p�X���[�h-->
&nbsp;<button type="submit" name="button2" style="WIDTH:60px;HEIGHT:20px">delete</button></p>

<p><label>�ҏW�������ԍ������:<input type="text" name="enum" size=5 /></label><!--�ҏW-->
&nbsp;<button type="submit" name="button3" style="WIDTH:60px;HEIGHT:20px">edit</button></p>

<input type="hidden" name="comnum" value="<?php echo $val3 ?>" /> <!--�ҏW���铊�e�ԍ�-->
<input type="hidden" name="arraynum" value="<?php echo $val4 ?>" /> <!--�ҏW���铊�e�̃��������ł̍s�ԍ�-->
<?php

$array=file($filename);
foreach($array as $data){
	$divide=explode("<>",$data);
	echo "$divide[0] : $divide[1] : $divide[2] : $divide[3]<br/>";//�ԍ����O�R�����g���Ԃ̏��ɏo��
}

fclose($fp);
?>