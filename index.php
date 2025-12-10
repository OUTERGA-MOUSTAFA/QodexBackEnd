
<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "users";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $request = "SELECT * FROM utilisateurs";
  $users = $conn->query($request);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Table</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">User List</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($user['id']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($user['nom']); ?> 
                            </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php  
      // Close connection
      mysqli_close($conn); 
    ?>
</body>
</html>