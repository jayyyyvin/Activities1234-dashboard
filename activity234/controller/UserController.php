<?php 

include '../database/db.php';
header('Content-type: application/json');
class UserController extends Database
{
    public function insert($params)
    {
        $array = ['fname','lname','gender','age'];

        foreach($array as $key)
        {
            if(empty($params[$key]))
            {
                return json_encode([
                    'code' => 401,
                    'message' => "$key is required"
                ]);
            }
        }
            $fname = $params['fname'];
            $lname = $params['lname'];
            $gender = $params['gender'];
            $age = $params['age'];
        

            $statement = $this->conn->prepare("INSERT INTO user(fname, lname, gender, age) VALUES(?, ?, ?, ?)");
            $statement->bind_param("ssss", $fname, $lname, $gender, $age);

            $isInserted = $statement->execute();

            if($isInserted)
            {
                return json_encode([
                    'code' => 200,
                    'message' => 'inserted successfully'
                ]);
            } else {
                return json_encode([
                    'message' => 'error'
                ]);
            }
        
    }

    public function getAll()
    {
        $data = $this->conn->query('SELECT * FROM user');
        $result = $data->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function search($search)
    {
        if(empty($search['gender']))
        {
            return json_encode([
                'code' => 422,
                'message' => 'please put gender  first'
            ]);
        }

        $gender = $search['gender'] ?? '';
        $statement = $this->conn->prepare("SELECT * FROM user WHERE gender LIKE ?");
        $genderSearch = "%$gender%";
        $statement->bind_param("s", $genderSearch);
        $statement->execute();

        $data = $statement->get_result();
        if($data->num_rows > 0)
        {
            $result = $data->fetch_all(MYSQLI_ASSOC);
            return $result;
        } else {
            return json_encode([
                'message' => 'error'
            ]);
        }
    }
}

?>