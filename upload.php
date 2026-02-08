<?php
$roll = $_GET['roll'] ?? 'unknown';

$baseDir = __DIR__ . "/students/$roll";
$webPath = "/students/$roll";

if (!is_dir($baseDir)) {
    mkdir($baseDir, 0755, true);
}

/* Handle upload */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {

    if ($_FILES['file']['error'] === 0) {

        $allowedExt = ['pdf', 'ppt', 'pptx'];
        $fileName  = basename($_FILES['file']['name']);
        $ext       = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $filePath  = "$baseDir/$fileName";

        if (in_array($ext, $allowedExt)) {

            move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
            chmod($filePath, 0644);

            /* 🔥 AUTO-CONVERT PPT/PPTX → PDF */
            if ($ext === 'ppt' || $ext === 'pptx') {

                $cmd = "soffice --headless --convert-to pdf " .
                       escapeshellarg($filePath) .
                       " --outdir " . escapeshellarg($baseDir);

                exec($cmd);
            }
        }
    }
}

/* Read files */
$files = [];
if (is_dir($baseDir)) {
    $files = array_values(array_diff(scandir($baseDir), ['.', '..']));
}

/* Build base URL */
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$baseUrl = $protocol . "://" . $host . $webPath;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload File</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
/* ✅ STYLES UNCHANGED */
html,body{margin:0;min-height:100%;display:grid;place-content:center;font-family:Arial,sans-serif;background:radial-gradient(hsl(220 10% 50% / .18) 1px, transparent 0),linear-gradient(160deg,#f7f8fa,#ebf2fa);background-size:30px 30px,cover;}
.container{width:620px;padding:36px;border-radius:30px;background:#ffffff;position:relative;z-index:1;}
.container::before{content:"";position:absolute;inset:-24px;border-radius:inherit;background:radial-gradient(circle at 20% 20%, rgba(120,160,255,.7), transparent 55%),radial-gradient(circle at 80% 80%, rgba(190,140,255,.7), transparent 55%),radial-gradient(circle at 50% 100%, rgba(120,200,255,.5), transparent 60%);filter:blur(32px);opacity:.9;z-index:-1;animation:glowPulse 6s ease-in-out infinite;}
@keyframes glowPulse{0%{filter:blur(28px);opacity:.75;}50%{filter:blur(36px);opacity:1;}100%{filter:blur(28px);opacity:.75;}}
h2{text-align:center;color:#3c5a80;margin:0 0 28px;}
.upload-box{padding:24px;border-radius:22px;border:1px dashed #b7c7de;background:#f6f9ff;}
.file-row{display:flex;align-items:center;gap:16px;flex-wrap:wrap;}
input[type=file]{display:none}
.file-picker{display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:999px;background:#ffffff;border:1px solid #dbe3f3;box-shadow:0 6px 16px rgba(60,90,160,.15);flex:1;min-width:260px;}
.choose-btn{padding:8px 16px;border-radius:999px;cursor:pointer;font-size:14px;color:#3c5a80;background:#eef3ff;border:1px solid #d7e0f5;}
.file-name{font-size:14px;color:#6c84a6;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.upload-btn,.btn{padding:11px 24px;border-radius:999px;border:none;cursor:pointer;font-size:15px;color:#3c5a80;background:#ffffff;box-shadow:0 8px 20px rgba(60,90,160,.2);transition:.25s;}
.upload-btn:hover,.btn:hover{box-shadow:0 12px 30px rgba(60,90,160,.35);}
.files{margin-top:38px;}
.files-title{font-size:20px;font-weight:700;color:#3c5a80;margin-bottom:16px;}
.file-card{display:flex;justify-content:space-between;align-items:center;padding:16px 20px;border-radius:20px;background:#f9fbff;border:1px solid #e2e8f5;margin-bottom:14px;}
.file-name-text{font-weight:600;color:#3c5a80;word-break:break-all;}
.actions a{margin-left:12px}
.no-files{text-align:center;color:#6c84a6;padding:20px 0;}
.back{display:inline-block;margin-top:22px;color:#3c5a80;font-weight:600;text-decoration:none;}
footer{margin-top:28px;text-align:center;font-size:14px;color:#6c84a6;}
footer span{font-weight:600;color:#5b7cff;}
</style>
</head>

<body>
<div class="container">

<h2>Upload File</h2>

<div class="upload-box">
<form method="POST" enctype="multipart/form-data">
<div class="file-row">
<div class="file-picker">
<label for="file" class="choose-btn">Choose File</label>
<span class="file-name" id="file-name">No file selected</span>
</div>
<button type="submit" class="upload-btn">Upload</button>
<input type="file" id="file" name="file" accept=".pdf,.ppt,.pptx" required>
</div>
</form>
</div>

<div class="files">
<div class="files-title">Files</div>

<?php if (!empty($files)): ?>
<?php foreach ($files as $f): ?>
<?php
$ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
$encoded = rawurlencode($f);
$fileUrl = $baseUrl . "/" . $encoded;

/* View logic */
if ($ext === 'pdf') {
    $viewUrl = $fileUrl;
} elseif ($ext === 'ppt' || $ext === 'pptx') {
    $pdfName = pathinfo($f, PATHINFO_FILENAME) . ".pdf";
    $pdfPath = "$baseDir/$pdfName";
    $viewUrl = file_exists($pdfPath)
        ? $baseUrl . "/" . rawurlencode($pdfName)
        : $fileUrl;
} else {
    $viewUrl = $fileUrl;
}
?>
<div class="file-card">
<div class="file-name-text"><?= htmlspecialchars($f) ?></div>
<div class="actions">
<a class="btn" href="<?= $viewUrl ?>" target="_blank">View</a>
<a class="btn" href="<?= $fileUrl ?>" download>Download</a>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="no-files">No files uploaded yet</div>
<?php endif; ?>
</div>

<a class="back" href="index.php">⬅ Back</a>
</div>

<footer>
Developed by <span>Manesh Katthi</span>
</footer>

<script>
const input = document.getElementById('file');
const label = document.getElementById('file-name');
input.addEventListener('change', () => {
label.textContent = input.files.length ? input.files[0].name : 'No file selected';
});
</script>

</body>
</html>
