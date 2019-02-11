<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Телефонный справочник</title>
</head>
<body>
	<h1>Телефонный справочник</h1>
	<form action="index.php" name="phonebook" method="POST" >
		<label>ФИО:</label><br><input type="text" name="fio" placeholder="ФИО" ><br><br>
		<label>Телефон:</label><br><input type="text" name="number"  placeholder="Телефон"><br><br>
		<label>Адрес:</label><br><input type="text" name="address" placeholder="Адрес"><br><br>
		<input type="submit" value="Добавить" name="add"style="width:  75px;">
		<input type="submit" value="Удалить" name="delete"style="width:  75px;"><br><br>
		<input type="submit" value="Поиск" name="search" style="width:  75px;">
		<input type="submit" value="Изменить" name="change"style="width:  75px;"><br><br>	
	</form>
</body>
</html>

<?php

	$mysqli = new mysqli ("localhost", "root", "", "phonebook");
	$mysqli->query ("SET NAMES 'utf8'");

	//поиск
	if (isset($_POST['search'])) {
			$fio = $_POST["fio"];
			$number = $_POST["number"];
			$address = $_POST["address"];
		if ($_POST["fio"] != "") {
			$result_set = $mysqli->query("SELECT * FROM `users` WHERE `fio` LIKE '%$fio%'");
			echo "<b>Результат поиска: </b>$fio<br>";
			 echo "<b>Найдено :</b> ".$result_set->num_rows."<br>";
			 printResult($result_set);
			echo "<br><br><br>";
		}
		elseif ($_POST["number"] != "") {
			$result_set = $mysqli->query("SELECT * FROM `users` WHERE `number` LIKE '%$number%'");
			echo "<b>Результат поиска:  </b>$number<br>";
			echo "Найдено количетсво записей: ".$result_set->num_rows."<br>";
			 printResult($result_set);
		}
		elseif ($_POST["address"] != "") {
			$result_set = $mysqli->query("SELECT * FROM `users` WHERE `address` LIKE '%$address%'");
			echo "<b>Результат поиска:  </b>$address<br>";
			echo "Найдено количетсво записей: ".$result_set->num_rows."<br>";
			 printResult($result_set);
		}
		else {
			echo "Введите ФИО/адрес/номер чтобы  <b>найти</b>  запись. <a href ='/'>Исправить</a> <br><br>";
		}
	}

	//добавить
	if (isset($_POST['add'])) {
			$fio = preg_replace('#(.*)\s+(.).*\s+(.).*#usi', '$1 $2.$3.', $fio = mb_strtoupper($fio = $_POST["fio"]));
			$number = $_POST["number"];
			$address = $_POST["address"];
		if ($_POST["fio"] == "" || $_POST["number"] == ""||$_POST["address"] == "")  {
			echo "Введите данные чтобы <b>добавить</b> запись. <a href ='/'>Исправить</a> <br><br>";
		} 
		else {
			$mysqli->query("INSERT INTO `users` (`fio`,`number`,`address`) VALUES ('$fio','$number','$address');");
			echo "Запись <b>$fio</b> добавлена. <br><br>";	
		}	
	}

	//удалить
	if (isset($_POST['delete'])) {
			$fio = $_POST["fio"];
			$number = $_POST["number"];
			$address = $_POST["address"];
		if ($_POST["fio"] != "") {
			$mysqli->query ("DELETE FROM `users` WHERE `users`.`fio` = '$fio'");
			echo "Запись <b>$fio</b>  удалена.<br><br>";
		} 
		elseif ($_POST["number"] != "") {
			$mysqli->query ("DELETE FROM `users` WHERE `users`.`number` = '$number'");
			echo "Запись c номером телефона <b>$number</b>  удалена.<br><br>";
		}
		elseif ($_POST["address"] != "") {
			$mysqli->query ("DELETE FROM `users` WHERE `users`.`address` = '$address'");
			echo "Запись c адресом <b>$address</b>  удалена.<br><br> ";
		}
		else {
			echo "Введите ФИО/адрес/номер чтобы  <b>удалить</b>  запись. <a href ='/'>Исправить</a> <br><br>";
		}
					
	}

	//изменить
	if (isset($_POST['change'])) {
		$fio = $_POST["fio"]; 
		$number = $_POST["number"]; 
		$address = $_POST["address"];
		if ($_POST["address"] != "") {
				$mysqli->query ("UPDATE `users` SET `address` = '$address' WHERE `users`.`fio` = '$fio';");
				echo "Адрес <b>$fio</b>  изменен. <br><br>";
			}
			elseif ($_POST["number"] != "") {
				$mysqli->query ("UPDATE `users` SET `number` = '$number' WHERE `users`.`fio` = '$fio';");
				echo "Номер телефона <b>$fio</b>  изменен. <br><br>";
			}
			else{
				echo "Введите ФИО , затем адрес/номер на который хотите  <b>изменить</b>. <a href ='/'>Исправить</a> <br><br>";
			}		
	}

	//Вывод 
		$result_set = $mysqli->query("SELECT * FROM  `users` ");
		echo "<b>Кoличecтвo записей:</b> ".$result_set->num_rows."<br>";
			printResult ($result_set);

				function printResult ($result_set) {
						while ($row = mysqli_fetch_assoc($result_set))  
						{	
							echo '<b>№</b>  '.$row["id"]."<br>"	.' <b>ФИО:</b> '.$row["fio"]."<br>".' <b>Номер телефона:</b> '.$row["number"]."<br>".' <b>Адрес:</b> '.$row["address"].'<br>';
							echo "-------------------------------------------------<br><br>";
						}
			}
	$mysqli->close ();
?>
