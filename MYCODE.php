<?php
$apiKey = "SptHMRiTTlwvVq1xidt1Kvpv1W1apliG";
$bucketName = "unievent-media-assignment1-2026";
$apiUrl = "https://app.ticketmaster.com/discovery/v2/events.json?classificationName=university&apikey=" . $apiKey;

$uploadMsg = "";

/* -----------------------------
   FILE UPLOAD TO S3
------------------------------*/
if (isset($_FILES['student_poster'])) {
    $temp = $_FILES['student_poster']['tmp_name'];
    $dest = "s3://$bucketName/student_uploads/" . time() . "_" . basename($_FILES['student_poster']['name']);

    exec("aws s3 cp $temp $dest 2>&1", $out, $rc);

    $uploadMsg = ($rc === 0)
        ? "<p style='color:green;'><b>✔ Poster Uploaded to S3!</b></p>"
        : "<p style='color:red;'><b>✘ Upload Failed.</b></p>";
}

/* -----------------------------
   FETCH EVENTS FROM API
------------------------------*/
$json = file_get_contents($apiUrl);
$data = json_decode($json, true);

/* Save API data to S3 */
$ts = date("Y-m-d_H-i-s");
$tmpFile = "/tmp/events_$ts.json";
file_put_contents($tmpFile, $json);

exec("aws s3 cp $tmpFile s3://$bucketName/fetched_data/");

/* -----------------------------
   HTML OUTPUT
------------------------------*/
echo "<html><body style='font-family:Arial; padding:40px; background:#f4f7f6;'>";
echo "<h1 style='color:#2c3e50;'>🎓 Official UniEvent Portal</h1>";
echo "<h3>Student ID: 2023085</h3>";

echo "<div style='background:white;padding:20px;border-radius:10px;margin-bottom:20px;'>";
echo "<form method='POST' enctype='multipart/form-data'>";
echo "Upload Poster: <input type='file' name='student_poster' required> ";
echo "<input type='submit' value='Upload to S3'>";
echo "</form>";
echo $uploadMsg;
echo "</div>";

/* -----------------------------
   DISPLAY EVENTS
------------------------------*/
if (isset($data['_embedded']['events'])) {
    foreach ($data['_embedded']['events'] as $e) {

        $img = $e['images'][0]['url'] ?? '';

        echo "<div style='background:white;margin:10px;padding:15px;border-radius:10px;display:flex;align-items:center;'>";
        echo "<img src='$img' width='120' style='margin-right:15px;border-radius:8px;'>";
        echo "<div>";
        echo "<h3>".$e['name']."</h3>";
        echo "<p>Venue: ".$e['_embedded']['venues'][0]['name']."</p>";
        echo "<button onclick='alert(\"Registered!\")' style='padding:8px 12px;background:green;color:white;border:none;border-radius:5px;'>Register</button>";
        echo "</div></div>";
    }
}

echo "</body></html>";
?>