<html>

<head>
  <title>Nth Rank Students</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
    }

    form {
      background-color: #fff;
      padding: 20px;
      margin: 20px auto;
      max-width: 500px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }

    h1 {
      text-align: center;
      margin-top: 50px;
      font-size: 36px;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 10px;
      color: #333;
      font-size: 18px;
    }

    input[type="text"],
    input[type="number"],
    input[type="submit"] {
      display: block;
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    input[type="submit"] {
      background-color: #333;
      color: #fff;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #555;
    }
  </style>
</head>

<body>
  <form method="post" action="">
    <label>Subject Name:</label>
    <input type="text" name="subject" value="<?= $_POST['subject'] ?? '' ?>" required><br><br>
    <label>Nth Rank:</label>
    <input type="number" name="rank" value="<?= $_POST['rank'] ?? '' ?>" min="1" required><br><br>
    <span><?= $error ?? '' ?></span>
    <label>Number of Students:</label>
    <input type="number" name="num_students" value="<?= $_POST['num_students'] ?? '' ?>" min="1" required><br><br>
    <?php
    if (isset($_POST['enter_data'])) {
      $rank = $_POST['rank'];
      $num_students = $_POST['num_students'];
      if ($rank > $num_students) {
        $error = "Rank must be less than or equal to total number of students";
      }
      if (empty($error)) {
        for ($i = 1; $i <= $num_students; $i++) {
          echo "<label>Enter Student $i Name:</label>";
          echo "<input type='text' name='name$i' required>";
          echo "<label>Enter Student $i Marks:</label>";
          echo "<input type='number' name='marks$i' min='0' max='100' required><br><br>";
        }
      }
    }
    ?>
    <input type="submit" name="submit" value="Find Nth Rank">
    <input type="submit" name="enter_data" value="Enter Data">
  </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
  $subject = $_POST['subject'];
  $rank = $_POST['rank'];
  $num_students = $_POST['num_students'];

  // initialize array to store student names and marks
  $students = array();

  // loop to read input data and store in array
  for ($i = 1; $i <= $num_students; $i++) {
    $name = $_POST["name$i"];
    $marks = $_POST["marks$i"];

    // check for invalid input
    if ($name == "" || !is_numeric($marks) || $marks < 0 || $marks > 100) {
      echo "Invalid input!";
      exit();
    }

    // add data to array
    $students[$name] = $marks;
  }

  // sort the array in descending order of marks
  arsort($students);

  // loop through the array and find the nth rank student
  $count = 1;
  $nth_rank_student = [];
  $sameRankStudents = array_count_values($students);

  foreach ($students as $name => $marks) {
    if ($count == $rank) {
      $nthRankMarks = $marks;
    }
    $count++;
  }
  if (isset($nthRankMarks)) {
    foreach ($sameRankStudents as $mark => $sameRankStudent) {
      if ($sameRankStudent > 1) {
        if ($nthRankMarks == $mark) {
          foreach ($students as $name => $marks) {
            if ($marks == $mark) {
              $nth_rank_student[] = $name;
            }
          }
        }
      }
    }
  }

  // display the nth rank student
  foreach ($nth_rank_student as $key => $studentInfo) {
    echo "The $rank<sup>th</sup> rank student in $subject is " . $studentInfo . "<br>";
  }
}
?>
