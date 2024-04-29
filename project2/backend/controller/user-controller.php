<?php
include '../database/db.php';

header('Content-type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
class UserController extends Database
{
    public function registered($register)
    {
        $arr = ['full_name', 'email', 'password'];

        foreach($arr as $items)
        {
            if(empty($register[$items]))
            {
                return json_encode([
                    'message' => "$items is required"
                ]);
            }
        } 

        $full_name = $register['full_name'] ?? '';
        $email = $register['email'] ?? '';
        $password = $register['password'] ?? '';

        $email1 = $this->conn->prepare('SELECT * FROM user where email = ?');
        $email1->bind_param('s',$email);
        $email1->execute();
        $isEmail = $email1->get_result();

        if($isEmail->num_rows > 0)
        {
            return json_encode([
                'message' => 'Email has already been used'
            ]);
        }
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $register = $this->conn->prepare("INSERT INTO user(full_name, email, password) VALUES(?,?,?)");
        $register->bind_param('sss', $full_name, $email, $hashPassword);
        $isRegister = $register->execute();

        if($isRegister)
        {
            return json_encode([
                'message' => 'Registration compete'
            ]);
        }else{
            ([
                'message' => 'Registration failed'
            ]);
        }
    }

    public function login($login)
    {
            if(empty($login['email']) || empty($login['password']))
            {
                return json_encode([
                    'message' => 'Please fill the fields'
                ]);
            }
        

        $email = $login['email'] ?? '';
        $password = $login['password'] ?? '';

        $stmt = $this->conn->prepare('SELECT * FROM user where email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result && $result ->num_rows > 0)
        {
            $user = $result->fetch_assoc();
            $hashPassword = $user['password'];

            if(password_verify($password, $hashPassword))
            {
                return json_encode([
                    'message' => 'login successfully'
                ]);
            }else{
                return json_encode([
                    'message' => 'login failed'
                ]);
            }
            }else{
            return json_encode([
                'message' => 'Invaled Email or Password'
            ]);
        }
    }

    public function getAll()
    {
        $data = $this->conn->query("SELECT * FROM user");
        if($data->num_rows > 0)
        {
            $result = $data->fetch_all(MYSQLI_ASSOC);
            return $result;
        }
    }
    
}
?>