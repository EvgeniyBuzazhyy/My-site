<?php
$status = true;
$idLogin;
$idPassword;
$answ;

if(isset($_GET) && !empty($_GET['answer']))
 {
    $data = json_decode($_GET['answer'], true); // преобразование строки в формате json в ассоциативный массив 
    $email = $data['email']; // ваш искомый id
    $location = $data['location'];
    $question1 = $data['question1'];
    $question2 = $data['question2'];
    $question3 = $data['question3'];
    $question4 = $data['question4'];
    $question5 = $data['question5'];
    $question6 = $data['question6'];
    $question7 = $data['question7'];
    $question8 = $data['question8'];
    $question9 = $data['question9'];
    $question10 = $data['question10'];
      
/*
echo '***';
echo $email;
echo '***';
echo $location;
echo '***';
echo $question1;
echo '***';
echo $question2;
echo '***';
*/


    $host='mysql.cba.pl'; // имя хоста (уточняется у провайдера)
    $database='vic_zzz_com_ua'; // имя базы данных, которую вы должны создать
    $user='fistedrt256272'; // заданное вами имя пользователя, либо определенное провайдером
    $pswd='526272victor'; // заданный вами пароль

     $dbh = mysql_connect($host, $user, $pswd) or die("dont connect to  MySQL.");
     mysql_select_db($database) or die("do noy con.");
     
     $queryToAddAnswer = "INSERT INTO `vic_zzz_com_ua`.`answers` (`id`, `email`, `location`, `question1`, `question2`,`question3`,`question4`,`question5`,`question6`,`question7`,`question8`,`question9`,`question10`)"
     . " VALUES (NULL, '".$email."', '".$location."', '".$question1."', '".$question2."',".$question3.",'".$question4."','".$question5."','".$question6."','".$question7."','".$question8."','".$question9."','".$question10."');";
     
     //$queryToAddAnswer = "INSERT INTO `vic_zzz_com_ua`.`data` (`id`, `email`, `location`, `qustion1`, `question2`) VALUES (NULL, '".$email."', '".$location."', '".$question1."', '".$question2."');";
     
     //$queryToAddAnswer = "INSERT INTO `vic_zzz_com_ua`.`data` (`id`, `email`, `location`, `qustion1`, `question2`) VALUES (NULL, 'mk@mail.ru', 'Kiev', '3', '5');";
     
     $AddAnswer = mysql_query($queryToAddAnswer);  
     
     //проверка на затронутость строк       
        if (mysql_affected_rows()==1)
        {
             $answ = 'add';
             post($answ);
            // echo '---- ZATRONYTA 1 STROKA ---';
         }
         else 
         {
             $answ = 'error';
             post($answ);
            // echo '---- ZATRONYTA 0 STROK ---';
         }
     /*
      while($row = mysql_fetch_array($idAndLogin))
       {
       echo "ID Login OK: ".$row['0']."<br>\n";
       $idLogin = $row['0'];
       echo '***+++';   
       echo "Login OK: ".$row['1']."<br>\n";
      
       $status = false;
       }    
       
       $idAndPassword = mysql_query($queryIdAndPassword);
       while($row = mysql_fetch_array($idAndPassword))
       {
       echo "ID Password OK: ".$row['0']."<br>\n";
       $idPassword = $row['0'];
       echo '***+++';   
       echo "Password OK: ".$row['1']."<br>\n";
       $status = false;
       }    
       //проверка на корректность нахождения логина и пароля в одной строки в базе
       if ($idLogin == $idPassword)
       {echo 'Login and Password Correct!!!';}else{$status=true;}

       if ($status)
       {echo 'Login or Password is not Correct!!!';}
  
       */
      //закрытие соединение (рекомендуется)
    mysql_close($db);

    // Функция выхода
    die();
}
// отправка Json файла на телефон
function post($answ)
       {
       $cart = array(

          "answer" => array(
           array(
              "success" => "$answ"
              ) )
             );


        echo json_encode($cart);
       }
?>

