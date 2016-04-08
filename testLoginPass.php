<?php
$statusLogin = true;
$statusPassword = true;
$idLogin;
$idPassword;
$exist;
$answ = '';
$answEmail = '';

if(isset($_GET) && !empty($_GET['login']))
 {
    $data = json_decode($_GET['login'], true); // преобразование строки в формате json в ассоциативный массив 
    $login = $data['login']; // ваш искомый id
    $password = $data['pass'];
      
// Отображаем переменные которые пришли
/*
echo '***';
echo $login;
echo '***';
echo $password;
echo '***';*/
    // Переменные доступа к базе данных 
    $host='mysql.cba.pl'; // имя хоста (уточняется у провайдера)
    $database='vic_zzz_com_ua'; // имя базы данных, которую вы должны создать
    $user='fistedrt256272'; // заданное вами имя пользователя, либо определенное провайдером
    $pswd='526272victor'; // заданный вами пароль
    // Само подключение к базе 
     $dbh = mysql_connect($host, $user, $pswd) or die("dont connect to  MySQL.");
     mysql_select_db($database) or die("do noy con.");
     
     //----------- запросы на существование логина и пароля с одинаковыми ID
     $queryIdAndLogin = "SELECT `id`,`login` FROM `enter` WHERE `login`= '".$login."';";
     $queryIdAndPassword = "SELECT `id`,`pass` FROM `enter` WHERE `pass`= '".$password."';";
     
     // --- обработка запроса на существование Логина и его ID
       $idAndLogin = mysql_query($queryIdAndLogin);  
       while($row = mysql_fetch_array($idAndLogin))
       {
           //echo "ID Login OK: ".$row['0'];
           // Запись id логина для дальнейшей сверки
           $idLogin = $row['0'];
           //echo '***+++';   
           //echo "Login OK: ".$row['1'];
           $statusLogin = false;
       } 
       //Если логин не подошел то проверяем на наличие email
       if ($statusLogin)
       {
         $queryIdAndEmail =  "SELECT `id`,`email` FROM `enter` WHERE `email`= '".$login."';";
         // --- обработка запроса на существование Emaila и его ID
           $idAndEmail = mysql_query($queryIdAndEmail);  
           while($rows = mysql_fetch_array($idAndEmail))
           {
              // echo "ID Email OK: ".$rows['0']."<br>\n";
               // Запись id логина для дальнейшей сверки
               $idLogin = $rows['0'];
               //echo '***+++ COUNT >'.count($rows);   
               //echo "Email OK: ".$rows['1']."<br>\n";
               $statusLogin = false;
           } 
       }
     // --- Обработка запроса на существование пароля и также его ID 
       $idAndPassword = mysql_query($queryIdAndPassword);
       while($row = mysql_fetch_array($idAndPassword))
       {
           //echo "ID Password OK: ".$row['0']."<br>\n";
           $idPassword = $row['0'];

           // --- проверка на подходящий id
           if ($idLogin == $idPassword)
           { 
               //echo "Find identical Password : ".$idPassword."<br>\n";
               $answ = 'correct';
               //
               //echo'correct';
               $statusLogin = false;
               // ----- Получение ЕМАЙЛА для отправки на телефон
               $queryGetEm = "SELECT `email` FROM `enter` WHERE `id`= '".$idPassword."';";
               $getEmailAn = mysql_query($queryGetEm);  
                   while($rows = mysql_fetch_array($getEmailAn))
                   {
                       // Получение емайла для отправки на телефон
                       $answEmail = $rows['0'];
                   } 
                //--------------------------------------------------------------
               post($answ,$answEmail);
               return;
           }
          

           //echo '***+++';   
           // Отображение самого пароля 
           //echo "Password OK: ".$row['1']."<br>\n";
           //echo '***+++'; 
           //Заглушка работает как 
           $statusPassword = false;
           $statusLogin = true;
       }    
       
  
       if ($statusLogin || $statusPassword)
       {
           //echo'incorect';
           $answ = 'incorect';
           post($answ);
       }
       
       //--------  Отсылка массива ответа JSONa
      
      
  
      //закрытие соединение (рекомендуется)
    mysql_close($db);

    // Функция выхода
    die();
}
 function post($answ, $answEmail)
       {
       $cart = array(

          "login" => array(
           array(
              "success" => "$answ",
               "email" => "$answEmail",
              ) )
             );


        echo json_encode($cart);
       }
?>