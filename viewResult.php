<?php

require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

$servername = "localhost";
$username = "bhanuka";
$password = "mysql";
$dbname = "gpacalc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function checkDepartment($dept, $batch) {
    global $conn;
    $results = [];

    if (($dept == 'ict') || ($dept == 'ICT')) {
        $sql = "SELECT filedata, credits FROM itcresults WHERE batch = ?";
    } else if (($dept == 'egt') || ($dept == 'EGT')) {
        $sql = "SELECT filedata, credits FROM etcresults WHERE batch = ?";
    } else if (($dept == 'bst') || ($dept == 'BST')) {
        $sql = "SELECT filedata, credits FROM btcresults WHERE batch = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $batch);
    $stmt->execute();
    $stmt->bind_result($pdfBlob, $credits);

    while ($stmt->fetch()) {
        $results[] = ['pdfBlob' => $pdfBlob, 'credits' => $credits];
    }

    $stmt->close();

    return $results;
}

function findDept($username) {
    $pattern = '/[A-z]{3}/';
    preg_match_all($pattern, $username, $matches);
    return $matches[0][0];
}

function findBatch($username) {
    $pattern = '/\d{2}/';
    preg_match_all($pattern, $username, $matches);
    return $matches[0][0];
}

function calculateGradePoint($grade) {
    switch ($grade) {
        case 'A+':
        case 'A':
            return 4.0;
        case 'A-':
            return 3.7;
        case 'B+':
            return 3.3;
        case 'B':
            return 3.0;
        case 'B-':
            return 2.7;
        case 'C+':
            return 2.3;
        case 'C':
            return 2.0;    
        case 'C-':
            return 1.7;
        case 'D+':
            return 1.3;
        case 'D':
            return 1.0;
        case 'E':
            return 0.0;
        default:
            return 'fail';
    }
}

// Extracting department and batch
$uname = $_POST['uname'];
$department = findDept($uname);
$batch = findBatch($uname);

echo "Department: $department<br>Batch: $batch<br>";

$results = checkDepartment($department, $batch);

if (empty($results)) {
    die("No PDF data found.");
}

echo "Number of PDFs found: " . count($results) . "<br>";

$parser = new Parser();
$gradePoints = [];
$totalCredits = 0;

foreach ($results as $index => $result) {
    echo "Processing Grade Sheet " . ($index + 1) . "<br>";

    $pdf = $parser->parseContent($result['pdfBlob']);
    $text = $pdf->getText();

    $pattern = '/\b([A-Z]{3}\/\d{2}\/\d{3})\s+([A-E][+-]?|AB\(ESA\)|E\(ESA\)|E\(CA & ESA\))/';
    preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
        if ($match[1] == $uname) {
            $gradePoint = calculateGradePoint($match[2]);
            if ($gradePoint !== 'fail') {
                $gradePoints[] = $gradePoint * $result['credits'];
                $totalCredits += $result['credits'];
            }
        }
    }
}

if (empty($gradePoints)) {
    echo "No grades found for the username.";
} else {
    $gpa = array_sum($gradePoints) / $totalCredits;
    echo "GPA: " . number_format($gpa, 2);
}

?>
