<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Artworks</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="../src/output.css" />
</head>
<body class="bg-white text-gray-800 min-h-screen px-6 py-16">
  <h1 class="text-3xl font-bold text-center mb-10">Add New Artworks</h1>

  <form action="add-art.php" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto space-y-4">
    <input type="file" name="images[]" accept="image/*" multiple required
      class="block w-full border border-gray-300 rounded px-4 py-2">

    <input type="text" name="title" placeholder="Artwork Title"
      class="w-full border border-gray-300 rounded px-4 py-2" required>

    <button type="submit"
      class="bg-gray-900 text-white px-6 py-2 rounded w-full hover:bg-gray-700 transition">
      Upload to Gallery
    </button>

    <p class="text-center text-sm text-gray-500 mt-4">Images will be saved to the <code>/img</code> folder</p>
  </form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $uploadDir = 'img/';
  $title = htmlspecialchars($_POST['title']);
  $date = date("d M Y H:i:s");
  $artworksFile = 'data/artworks.json';

  // Ensure data folder exists
  if (!file_exists('data')) {
    mkdir('data', 0777, true);
  }

  if (!file_exists($artworksFile)) {
    file_put_contents($artworksFile, json_encode([]));
  }

  $artworks = json_decode(file_get_contents($artworksFile), true);

  foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
    $originalName = basename($_FILES['images']['name'][$index]);
    $targetFile = $uploadDir . time() . '_' . $originalName;

    if (move_uploaded_file($tmpName, $targetFile)) {
      $artworks[] = [
        'title' => $title,
        'date' => $date,
        'file' => $targetFile
      ];
    }
  }

  file_put_contents($artworksFile, json_encode($artworks, JSON_PRETTY_PRINT));
  echo '<p class="text-green-600 text-center mt-4">Upload successful!</p>';
}
?>
</body>
</html>
