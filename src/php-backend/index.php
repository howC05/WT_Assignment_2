<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once './config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

// switch ($action) {
//     case 'getUsers':
//         getUsers();
//         break;
//     case 'getUserById':
//         getUserById();
//         break;
//     case 'createUser':
//         createUser();
//         break;
//     case 'updateUser':
//         updateUser();
//         break;
//     case 'deleteUser':
//         deleteUser();
//         break;
//     default:
//         echo json_encode(["error" => "Invalid action"]);
//         break;
// }

switch ($type) {
    case 'user':
        handleUserActions($action);
        break;
    case 'courseMaterial':
        handleCourseMaterialActions($action);
        break;
    case 'assessment':
        handleAssessmentActions($action);
        break;
    default:
        echo json_encode(["error" => "Invalid type"]);
        break;
}

function handleUserActions($action)
{
    switch ($action) {
        case 'getUsers':
            getUsers();
            break;
        case 'getUserById':
            getUserById();
            break;
        case 'createUser':
            createUser();
            break;
        case 'updateUser':
            updateUser();
            break;
        case 'deleteUser':
            deleteUser();
            break;
        case 'loginUser':
            loginUser();
            break;
        default:
            echo json_encode(["error" => "Invalid action"]);
            break;
    }
}

function handleCourseMaterialActions($action)
{
    switch ($action) {
        case 'getCourseMaterials':
            getCourseMaterials();
            break;
        case 'getCourseMaterialById':
            getCourseMaterialById();
            break;
        case 'createCourseMaterial':
            createCourseMaterial();
            break;
        case 'updateCourseMaterial':
            updateCourseMaterial();
            break;
        case 'deleteCourseMaterial':
            deleteCourseMaterial();
            break;
        default:
            echo json_encode(["error" => "Invalid action"]);
            break;
    }
}

function handleAssessmentActions($action)
{
    switch ($action) {
        case 'getAssessments':
            getAssessments();
            break;
        case 'getAssessmentById':
            getAssessmentById();
            break;
        case 'createAssessment':
            createAssessment();
            break;
        case 'updateAssessment':
            updateAssessment();
            break;
        case 'deleteAssessment':
            deleteAssessment();
            break;
        default:
            echo json_encode(["error" => "Invalid action"]);
            break;
    }
}

function getUsers()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $sql = "SELECT * FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        echo json_encode($result);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function getUserById()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            echo json_encode($user);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
        $conn = null;
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}

function getUserByEmail()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $email = $_GET['email'];
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            echo json_encode($user);
        } else {
            echo json_encode([]);
        }
        $conn = null;
    } catch (PDOException $e) {
        echo json_encode(["error" => "SQL Error: " . $e->getMessage()]);
    }
}

function createUser()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $data['email']);
        $stmt->execute();
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existingUser) {
            http_response_code(409); // Conflict
            echo json_encode(["error" => "Email already exists. Please log in."]);
            return;
        }

        $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', $data['password']);
        $stmt->bindValue(':role', 'user');
        $stmt->execute();
        http_response_code(201); // Created
        echo json_encode(["message" => "User registered successfully"]);
        $conn = null;
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "SQL Error: " . $e->getMessage()]);
    }
}

function loginUser()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        $email = $data['email'];
        $password = $data['password'];

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['password'] === $password) {
            echo json_encode($user);
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "Invalid email or password"]);
        }
        $conn = null;
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "SQL Error: " . $e->getMessage()]);
    }
}

function updateUser()
{
    //pls complete
    try {
        $db = new db();
        $conn = $db->connect();
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        $name = $data['name'];
        $id = $data['id'];
        $sql = "UPDATE users SET name = :name WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);
        $stmt->execute();
        http_response_code(200); // OK
        echo json_encode(["message" => "User updated successfully"]);
        $conn = null;
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "SQL Error: " . $e->getMessage()]);
    }
}
// function patchUser()
// {
//     //pls complete 
// }
function deleteUser()
{
    //pls complete
    try {
        $db = new db();
        $conn = $db->connect();
        $id = $_GET['id'];
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        echo json_encode(["message" => "User deleted successfully"]);
        $conn = null;
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error deleting user: " . $e->getMessage()]);
    }
}

// Course Material Functions
function getCourseMaterials()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $sql = "SELECT * FROM courseMaterials";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        echo json_encode($result);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function getCourseMaterialById()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $id = $_GET['id'];
        $sql = "SELECT * FROM courseMaterials WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $courseMaterial = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($courseMaterial) {
            echo json_encode($courseMaterial);
        } else {
            echo json_encode(["error" => "Course material not found"]);
        }
        $conn = null;
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}

function createCourseMaterial()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if (!isset($data['title']) || !isset($data['description']) || !isset($data['link'])) {
            throw new Exception("Title, description, and link are required.");
        }
        $title = $data['title'];
        $description = $data['description'];
        $link = $data['link'];
        $sql = "INSERT INTO courseMaterials (title, description, link) VALUES (:title, :description, :link)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':link', $link);
        $stmt->execute();
        echo json_encode(["message" => "Course material created successfully"]);
        $conn = null;
    } catch (Exception $e) {
        echo json_encode(["error" => "Error creating course material: " . $e->getMessage()]);
    }
}

function updateCourseMaterial()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if (!isset($data['id']) || !isset($data['title']) || !isset($data['description']) || !isset($data['link'])) {
            throw new Exception("ID, title, description, and link are required.");
        }
        $id = $data['id'];
        $title = $data['title'];
        $description = $data['description'];
        $link = $data['link'];
        $sql = "UPDATE courseMaterials SET title = :title, description = :description, link = :link WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':link', $link);
        $stmt->execute();
        echo json_encode(["message" => "Course material updated successfully"]);
        $conn = null;
    } catch (Exception $e) {
        echo json_encode(["error" => "Error updating course material: " . $e->getMessage()]);
    }
}

function deleteCourseMaterial()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $id = $_GET['id'];
        $sql = "DELETE FROM courseMaterials WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        echo json_encode(["message" => "Course material deleted successfully"]);
        $conn = null;
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error deleting course material: " . $e->getMessage()]);
    }
}

// Assessment Functions
function getAssessments()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $sql = "SELECT * FROM assessments";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        echo json_encode($result);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function getAssessmentById()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $id = $_GET['id'];
        $sql = "SELECT * FROM assessments WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $assessment = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($assessment) {
            echo json_encode($assessment);
        } else {
            echo json_encode(["error" => "Assessment not found"]);
        }
        $conn = null;
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}

function createAssessment()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if (!isset($data['title']) || !isset($data['description']) || !isset($data['dueDate'])) {
            throw new Exception("Title, description, and dueDate are required.");
        }
        $title = $data['title'];
        $description = $data['description'];
        $dueDate = $data['dueDate'];
        $sql = "INSERT INTO assessments (title, description, dueDate) VALUES (:title, :description, :dueDate)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':dueDate', $dueDate);
        $stmt->execute();
        echo json_encode(["message" => "Assessment created successfully"]);
        $conn = null;
    } catch (Exception $e) {
        echo json_encode(["error" => "Error creating assessment: " . $e->getMessage()]);
    }
}

function updateAssessment()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if (!isset($data['id']) || !isset($data['title']) || !isset($data['description']) || !isset($data['dueDate'])) {
            throw new Exception("ID, title, description, and dueDate are required.");
        }
        $id = $data['id'];
        $title = $data['title'];
        $description = $data['description'];
        $dueDate = $data['dueDate'];
        $sql = "UPDATE assessments SET title = :title, description = :description, dueDate = :dueDate WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':dueDate', $dueDate);
        $stmt->execute();
        echo json_encode(["message" => "Assessment updated successfully"]);
        $conn = null;
    } catch (Exception $e) {
        echo json_encode(["error" => "Error updating assessment: " . $e->getMessage()]);
    }
}

function deleteAssessment()
{
    try {
        $db = new db();
        $conn = $db->connect();
        $id = $_GET['id'];
        $sql = "DELETE FROM assessments WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        echo json_encode(["message" => "Assessment deleted successfully"]);
        $conn = null;
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error deleting assessment: " . $e->getMessage()]);
    }
}
?>