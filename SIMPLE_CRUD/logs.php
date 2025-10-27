<?php
include 'db.php';
$result = $conn->query("
    SELECT logs.*, users.username 
    FROM logs 
    LEFT JOIN users ON logs.user_id = users.id 
    ORDER BY logs.id DESC
");
?>

<h2>Activity Logs</h2>
<table border="1" cellpadding="5" cellspacing="0">
<tr>
    <th>ID</th>
    <th>User</th>
    <th>Action</th>
    <th>IP Address</th>
    <th>Time</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['username'] ?? 'Guest'; ?></td>
    <td><?= $row['action']; ?></td>
    <td><?= $row['ip_address']; ?></td>
    <td><?= $row['created_at']; ?></td>
</tr>
<?php endwhile; ?>
</table>
