<?php
// add_vehicle.php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please login first']);
        exit;
    }

    $owner_id = $_SESSION['user_id'];
    $vehicle_type = mysqli_real_escape_string($conn, $_POST['vehicleType']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $license_plate = mysqli_real_escape_string($conn, $_POST['licensePlate']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $features = mysqli_real_escape_string($conn, $_POST['features']);

    $sql = "INSERT INTO vehicles (owner_id, vehicle_type, model, year, color, price, 
            license_plate, description, features) 
            VALUES ('$owner_id', '$vehicle_type', '$model', '$year', '$color', 
            '$price', '$license_plate', '$description', '$features')";

    if(mysqli_query($conn, $sql)){
        $vehicle_id = mysqli_insert_id($conn);
        
        // Handle image uploads
        if(isset($_FILES['vehiclePhotos'])){
            $total_files = count($_FILES['vehiclePhotos']['name']);
            
            for($i = 0; $i < $total_files; $i++){
                $file_name = time() . '_' . $_FILES['vehiclePhotos']['name'][$i];
                $target_dir = "uploads/vehicles/";
                $target_file = $target_dir . $file_name;
                
                if(move_uploaded_file($_FILES['vehiclePhotos']['tmp_name'][$i], $target_file)){
                    $sql = "INSERT INTO vehicle_images (vehicle_id, image_path) 
                            VALUES ('$vehicle_id', '$target_file')";
                    mysqli_query($conn, $sql);
                }
            }
        }
        
        echo json_encode(['status' => 'success', 'message' => 'Vehicle added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add vehicle']);
    }
}
?>

<?php
// book_ride.php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please login first']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $vehicle_id = mysqli_real_escape_string($conn, $_POST['carType']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $pickup_location = mysqli_real_escape_string($conn, $_POST['pickupLocation']);
    $dropoff_location = mysqli_real_escape_string($conn, $_POST['dropoffLocation']);
    $passengers = mysqli_real_escape_string($conn, $_POST['passengers']);
    $total_price = mysqli_real_escape_string($conn, $_POST['price']);

    $sql = "INSERT INTO bookings (vehicle_id, user_id, booking_date, booking_time, 
            pickup_location, dropoff_location, passengers, total_price) 
            VALUES ('$vehicle_id', '$user_id', '$date', '$time', '$pickup_location', 
            '$dropoff_location', '$passengers', '$total_price')";

    if(mysqli_query($conn, $sql)){
        // Update vehicle status
        $update_sql = "UPDATE vehicles SET status = 'booked' WHERE id = '$vehicle_id'";
        mysqli_query($conn, $update_sql);
        
        echo json_encode(['status' => 'success', 'message' => 'Booking confirmed']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Booking failed']);
    }
}
?>