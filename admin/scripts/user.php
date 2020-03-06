<?php


function createUser($fname, $username, $email){

    $pdo = Database::getInstance()->getConnection();

     // check user existance
     $check_email_query = 'SELECT COUNT(user_name) AS num FROM tbl_user WHERE user_name = :username'; 
     $user_set = $pdo->prepare($check_email_query);
     $user_set->execute(
         array(
             ':username'=>$username
         )
     );
 /// ASK PAN //////
     $row = $user_set->fetch(PDO::FETCH_ASSOC);


     // will check to see if email already exists
     if($row['num'] > 0){
        $message = 'username is already registered';
    }else{
        
        //random password generated
        $password = md5(rand(0,1000)); 

        // Pan guided me to use this function -> necessary for email validation
        // used smtp/gmail
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure='ssl';
        $mail->Port = 587;
        $mail->SMTPAuth=true;

        $mail->Username='lmastroianni98@gmail.com';
        $mail->Password='Luckydouble7'; 

        $mail->addAddress($email);
        $mail->setFrom('lmastroianni98@gmail.com');
        

        $mail->isHTML(true);
        $mail->Subject='Created User!'; 
        $mail->Body='
        Thanks for signing up!<br><br>
        Your account has been Created!
        <br><br><br>
        Here is your login info!<br>
        Email: '.$username.'<br>
        Password: '.$password.'<br><br>
        Login at http://localhost:8888/movies_cms/admin/admin_login.php <br>
        
        ';

        if(!$mail->send()){
            $message= $mail->ErrorInfo;
            return 'user creation did not got through';
        }else{
            //creating user sql query from form details
            $create_user_query = "INSERT INTO tbl_user (user_id, f_name, user_name, user_email, user_pass, user_ip) VALUES (NULL, :fname, :username, :email, :password, 'no');";

            $user_signup = $pdo->prepare($create_user_query);
            $user_signup->execute(
                array(
                    ':fname'=>$fname,
                    ':username'=>$username,
                    ':email'=>$email,
                    ':password'=>$password
                )
            );
            
            redirect_to('index.php');
            $message = 'created user';
        }
    }
}

function getSingleUser($id){
    $pdo = Database::getInstance()->getConnection();
    //To Do: execute proper SQL query to fetch user data whose user_id = $id
    $get_user_query = 'SELECT * FROM tbl_user WHERE user_id = :id';
    $get_user_set = $pdo->prepare($get_user_query);
    $get_user_result = $get_user_set->execute(
        array(
            ':id'=>$id
        )
        );



    // To do: if the execution is successful, return the user data
    // otherwise, return an error message
    if($get_user_set){
        return $get_user_set;
    }else{
        return 'There was a problem accessing the user';
    }
}
   
function editUser($id, $fname, $username, $password, $email){
    //set up db connection
    $pdo = Database::getInstance()->getConnection();

    //run proper sql query to update tbl_user with proper values
    $update_user_query = 'UPDATE tbl_user SET user_fname = :fname, user_name = :username, user_pass= :password, user_email = :email, verified = 1 WHERE user_id = :id';
    $update_user_set = $pdo->prepare($update_user_query);
    $update_user_result = $update_user_set->execute(
        array(
            ':fname'=>$fname,
            ':username'=>$username,
            ':password'=>$password,
            ':email'=>$email,
            ':id'=>$id
            
        )
    );

    // echo $update_user_set->debugDumpParams();
    // exit;

    // redirect user to index.php (if it works)
    //otherwise return error message
    if($update_user_result){
        redirect_to('index.php');
    }else{
        return 'Guess you got canned...';
    }

    }
    


