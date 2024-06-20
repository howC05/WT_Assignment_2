<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../config.php';

// Helper function to get input data 
function get_input_data()
{
    return json_decode(file_get_contents('php://input'), true);
}

// Connect to the database 
$conn = getDbConnection();

// Parse the request URL to determine the resource and ID
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
$path = trim($request_uri[0], '/');
$segments = explode('/', $path);
$resource = $segments[2] ?? null;
$id = $segments[3] ?? null;

// Check if the email already exists
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'users' && isset($_GET['email'])) {
    $email = $conn->real_escape_string($_GET['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(null);
    }
    exit();
}

// Register a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'users') {
    $input = get_input_data();
    $name = $conn->real_escape_string($input['name']);
    $email = $conn->real_escape_string($input['email']);
    $password = $conn->real_escape_string($input['password']); // Consider hashing the password
    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password','user')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User created successfully", "id" => $conn->insert_id]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error: " . $conn->error]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'loginUser') {
    $input = get_input_data();
    $email = $conn->real_escape_string($input['email']);
    $password = $conn->real_escape_string($input['password']); // Consider hashing the password and comparing hashes
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(["message" => "Login successful", "email" => $user['email']]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Invalid email or password"]);
    }
    exit();
}

// Fetch all users 
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'users' && !$id) {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    echo json_encode($users);
}

// Fetch a specific user 
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'users' && $id) {
    $id = intval($id);
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["message" => "User not found"]);
    }
}

// Insert a new user 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'users') {
    $input = get_input_data();
    $name = $conn->real_escape_string($input['name']);
    $email = $conn->real_escape_string($input['email']);
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User created successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}
// Update a user 
//complete the code here 
if ($_SERVER['REQUEST_METHOD'] == 'PUT' && $resource == 'users' && $id) {
    $input = get_input_data();
    $name = $conn->real_escape_string($input['name']);
    $sql = "UPDATE users SET name ='$name' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User updated successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}
// patch a user 
//complete the code here
if ($_SERVER['REQUEST_METHOD'] == 'PATCH' && $resource == 'users') {
    $input = get_input_data();
    $name = $conn->real_escape_string($input['name']);
    $email = $conn->real_escape_string($input['email']);
    $sql = "UPDATE users SET name ='$name' WHERE email = '$email'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User patched successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

// Delete a user 
//complete the code here
if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $resource == 'users' && $id) {
    $input = get_input_data();
    $id = intval($id);
    $sql = "DELETE FROM users WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User patched successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

// Course Materials CRUD Operations
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'course-materials' && !$id) {
    $sql = "SELECT * FROM coursematerials";
    $result = $conn->query($sql);
    $materials = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $materials[] = $row;
        }
    }
    echo json_encode($materials);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'course-materials' && $id) {
    $id = intval($id);
    $sql = "SELECT * FROM coursematerials WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["message" => "Course material not found"]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'course-materials') {
    $input = get_input_data();
    $title = $conn->real_escape_string($input['title']);
    $description = $conn->real_escape_string($input['description']);
    $link = $conn->real_escape_string($input['link']);
    $sql = "INSERT INTO coursematerials (title, description, link) VALUES ('$title', '$description', '$link')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Course material created successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT' && $resource == 'course-materials' && $id) {
    $input = get_input_data();
    $title = $conn->real_escape_string($input['title']);
    $description = $conn->real_escape_string($input['description']);
    $link = $conn->real_escape_string($input['link']);
    $sql = "UPDATE coursematerials SET title = '$title', description = '$description', link = '$link' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Course material updated successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $resource == 'course-materials' && $id) {
    $id = intval($id);
    $sql = "DELETE FROM coursematerials WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Course material deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

// Assessments CRUD Operations
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'assessments' && !$id) {
    $sql = "SELECT * FROM assessments";
    $result = $conn->query($sql);
    $assessments = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $assessments[] = $row;
        }
    }
    echo json_encode($assessments);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $resource == 'assessments' && $id) {
    $id = intval($id);
    $sql = "SELECT * FROM assessments WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["message" => "Assessment not found"]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $resource == 'assessments') {
    $input = get_input_data();
    $title = $conn->real_escape_string($input['title']);
    $description = $conn->real_escape_string($input['description']);
    $dueDate = $conn->real_escape_string($input['dueDate']);
    $sql = "INSERT INTO assessments (title, description, dueDate) VALUES ('$title', '$description', '$dueDate')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Assessment created successfully", "id" => $conn->insert_id]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT' && $resource == 'assessments' && $id) {
    $input = get_input_data();
    $title = $conn->real_escape_string($input['title']);
    $description = $conn->real_escape_string($input['description']);
    $dueDate = $conn->real_escape_string($input['dueDate']);
    $sql = "UPDATE assessments SET title = '$title', description = '$description', dueDate='$dueDate' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Assessment updated successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $resource == 'assessments' && $id) {
    $id = intval($id);
    $sql = "DELETE FROM assessments WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Assessment deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $conn->error]);
    }
}

$conn->close();
?>