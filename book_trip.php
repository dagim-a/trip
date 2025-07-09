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
    // Decrease available travelers
    $update = $conn->prepare("UPDATE Trip SET Number_of_Travelers = Number_of_Travelers - 1 WHERE Id = ? AND Number_of_Travelers > 0");
    $update->bind_param("i", $tripId);
    $update->execute();

    // Check if Number_of_Travelers is now zero, and close the trip if so
    $check = $conn->prepare("SELECT Number_of_Travelers FROM Trip WHERE Id = ?");
    $check->bind_param("i", $tripId);
    $check->execute();
    $check->bind_result($num_travelers);
    $check->fetch();
    $check->close();
    if ($num_travelers == 0) {
      $close = $conn->prepare("UPDATE Trip SET status = 'closed' WHERE Id = ?");
      $close->bind_param("i", $tripId);
      $close->execute();
    }

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
