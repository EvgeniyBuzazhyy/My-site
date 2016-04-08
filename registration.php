<?php
$status = true;
$existingLoginOrPassword = 0;

$setLogin;
$getLogin;
$idPassword;

$answ;

if(isset($_GET) && !empty($_GET['registration']))
 {
    $data = json_decode($_GET['registration'], true); // преобразование строки в формате json в ассоциативный массив 
    $email = $data['email']; // ваш искомый id
    $login = $data['login'];
    $password = $data['pass'];
/*      
echo '***';
echo $email;
echo '***';
echo $login;
echo '***';
echo $password;
echo '***';*/


    $host='mysql.cba.pl'; // имя хоста (уточняется у провайдера)
    $database='vic_zzz_com_ua'; // имя базы данных, которую вы должны создать
    $user='fistedrt256272'; // заданное вами имя пользователя, либо определенное провайдером
    $pswd='526272victor'; // заданный вами пароль

    $dbh = mysql_connect($host, $user, $pswd) or die("dont connect to  MySQL.");
    mysql_select_db($database) or die("do noy con.");
     
    $setLogin = $login;
    //------------------------- Проверяем Есть ли в базе пользователь с таким же Логином 
    $queryIfAddedLogin = "SELECT `login` FROM `enter` WHERE `login`= '".$login."';";
    $queryAddedLogin = mysql_query($queryIfAddedLogin); 
    
      while($row = mysql_fetch_array($queryAddedLogin))
       {
       //echo "This Login exist: ".$row['0']."<br>\n";
      // echo '***+++';   
       $existingLoginOrPassword = 1;
       }    
    //------------------------- Проверяем на существование email
    $queryInspectionForEmail = "SELECT `email` FROM `enter` WHERE `email`= '".$email."';";
    $queryInspectionEm = mysql_query( $queryInspectionForEmail); 
    
      while($row = mysql_fetch_array($queryInspectionEm))
       {
       //echo "This Email exist: ".$row['0']."<br>\n";
       //echo '***+++';   
       $existingLoginOrPassword = 2;
       }    
       
       //------ если мы не встретили похожих логинов и паролей то записываем нового пользователя
       if ($existingLoginOrPassword == 0)
       {
        //------------------После всех проверок добавляем пользователя 
        $queryAddUser = "INSERT INTO `vic_zzz_com_ua`.`enter` (`id`, `login`, `pass`, `email`) VALUES (NULL, '".$login."', '".$password."', '".$email."');"; 
        $addNewUser = mysql_query($queryAddUser); 

        //проверка на затронутость строк 
        $queryAddedLogin = mysql_query($queryIfAddedLogin); 
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

          while($row = mysql_fetch_array($queryAddedLogin))
           {
           //echo "ID Login OK: ".$row['0']."<br>\n";
           $getLogin = $row['0'];
          // echo '***+++';   

           $status = false;
           }    

           //проверка на корректность нахождения логина и пароля в одной строки в базе
           if ($setLogin == $getLogin)
           {
               //echo 'User added!!!';
           
           }else{$status=true;}
       }
       else 
       {
          // --- если у нас есть совпадение то выводим что именно совпало
          if($existingLoginOrPassword == 1)
          {
              $answ = "loginExist";
              post($answ);
             // echo 'Login has olredy existed!!!';
          }
          else 
          {
              $answ = "emailExist";
              post($answ);
              //echo 'Email has olredy existed!!!';
          }
       }
      
    //закрытие соединение (рекомендуется)
    mysql_close($db);

    // Функция выхода
    die();
}

function post($answ)
       {
       $cart = array(

          "registration" => array(
           array(
              "success" => "$answ"
              ) )
             );


        echo json_encode($cart);
       }
?>

