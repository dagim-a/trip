<?php
include('cmsql.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $tripId = $_POST['tripId'];

    $sql = "INSERT INTO Booking (userId, TripId)
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $tripId);

    if ($stmt->execute()) {
        echo "<script>
                alert('🎉 You have successfully booked this trip!');
                window.location.href = 'Suggestion.php';
              </script>";
    } else {
        echo "<script>
                alert('Booking failed. Please try again!');
                window.history.back();
              </script>";
    }
}
?>
