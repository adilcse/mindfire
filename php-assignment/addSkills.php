<?php
include('databaseConnect.php');
$sql="
INSERT INTO `skills` ( `skill`) VALUES
('HTML'),
('CSS'),
('JAVA'),
('C'),
('PYTHON'),
('JAVASCRIPT')
";
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
?>