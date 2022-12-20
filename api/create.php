<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/database.php';
    include_once '../config/utilities.php';
    include_once '../class/employees.php';
    
    $database = new Database();
    $db = $database->getConnection();

    $employee = new Employee($db);

     

    $data = json_decode(file_get_contents("php://input"));

    $employee->name = cleanData($data->name);
    $employee->email = cleanData($data->email);
    $employee->age = cleanData($data->age);
    $employee->designation = cleanData($data->designation);

    // Check for any empty field
    if(empty($employee->name) || empty($employee->email) || empty($employee->age) || empty($employee->designation)){

        http_response_code(400);
        echo json_encode(['status'=> 0, 'message'=>'Please fill all fields.']) ;
        exit;

    }


    // Check if email is already in use
    $stmt = $employee->getEmployees();
    $all_employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['output'=>$all_employees]);






    // if($employee->createEmployee()){

    //     http_response_code(201);
    //     echo json_encode(['status'=> 1, 'message'=>'Employee created successfully.']) ;
    //     exit;
    
    // } else{

    //     http_response_code(400);
    //     echo json_encode(['status'=> 0, 'message'=>'Employee creation FAILED.']) ;
    //     exit;

    // }
    
?>