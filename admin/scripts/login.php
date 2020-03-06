<?php 

function login($username, $password, $ip){
    //Debug
    // $message = sprintf('You are trying to login with username %s and password %s', $username, $password);

    $pdo = Database::getInstance()->getConnection();

    // check user existance
    $check_exist_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name= :username'; // sanitation
    $user_set = $pdo->prepare($check_exist_query);
    $user_set->execute( 
        array(
            ':username' => $username,
        )
    );

    if($user_set->fetchColumn()>0){
        //user exist
        $get_user_query = 'SELECT * FROM tbl_user WHERE user_name = :username';
        $get_user_query .= ' AND user_pass = :password';
        $user_check = $pdo->prepare($get_user_query);
        $user_check->execute(
            array(
                ':username'=>$username,
                ':password'=>$password
        
            )

        );
    //       echo $user_check->debugDumpParams();
    // exit;

    while($found_user = $user_check->fetch(PDO::FETCH_ASSOC)){
        $id = $found_user['user_id'];

        // login successful
        $message = 'logged in successfully!';
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $found_user['first_name'];
        // updating database
        $update_query = 'UPDATE tbl_user SET user_ip = :ip WHERE user_id = :id';
        $update_set = $pdo->prepare($update_query);
        $update_set->execute(
                array(
                    ':ip'=>$ip,
                    ':id'=>$id
                )

        );
    }

    if(isset($id)){
        redirect_to('index.php');
    }

    }else{
        //user doesn't exit
        return 'user doesnt exist';
    }
}

function confirm_logged_in(){
    if(!isset($_SESSION['user_id'])){
        redirect_to('admin_login.php');
    }
}

function logout(){
    session_destroy();
    redirect_to('admin_login.php');
}

function verify_user(){
    // connecting to db
    $pdo = Database::getInstance()->getConnection(); //necessary for anything that goes back to db
    //grabbing unique user id
    $id = $_SESSION['user_id'];

    //SELECTING VERIFIED COLUMN
    $query = 'SELECT verified FROM tbl_user WHERE user_id = :id'; // sanitation
    $verify_user_set = $pdo->prepare($query);
    $verify_user_set->execute( 
        array(
            ':id' => $id,
        )
    );
    //result
    $verify_user = $verify_user_set->fetch(PDO::FETCH_ASSOC); //executes (makes everything true)

    if($verify_user['verified'] == 0){
        redirect_to('admin_edituser.php');
    }
}

// function set_time_limit( int $seconds) : bool 


