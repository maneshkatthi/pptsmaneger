<?php
$roll = $_GET['roll'] ?? 'unknown';

$allowedExt = ['pdf', 'ppt', 'pptx'];

$baseDir = __DIR__ . "/students/$roll";
$webPath = "/students/$roll";

if (!is_dir($baseDir)) {
    mkdir($baseDir, 0755, true);
}

/* ---------- HANDLE UPLOAD ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {

    if ($_FILES['file']['error'] === 0) {

        $fileName = basename($_FILES['file']['name']);
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($ext, $allowedExt)) {
            $filePath = "$baseDir/$fileName";
            move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
            chmod($filePath, 0644);
        }
    }
}

/* ---------- HANDLE DELETE ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {

    $deleteFile = basename($_POST['delete_file']);
    $ext = strtolower(pathinfo($deleteFile, PATHINFO_EXTENSION));

    if (in_array($ext, $allowedExt)) {
        $deletePath = "$baseDir/$deleteFile";
        if (file_exists($deletePath)) {
            unlink($deletePath);
        }
    }

    header("Location: ".$_SERVER['PHP_SELF']."?roll=".$roll);
    exit;
}

/* ---------- READ FILES (FILTERED) ---------- */
$files = [];
if (is_dir($baseDir)) {
    foreach (scandir($baseDir) as $file) {
        if ($file === '.' || $file === '..') continue;
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $allowedExt)) {
            $files[] = $file;
        }
    }
}

/* ---------- BASE URL ---------- */
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
html,body{
    margin:0;
    min-height:100%;
    display:grid;
    place-content:center;
    font-family:Arial,sans-serif;
    background:
        radial-gradient(hsl(220 10% 50% / .18) 1px, transparent 0),
        linear-gradient(160deg,#f7f8fa,#ebf2fa);
    background-size:30px 30px,cover;
}
.container{
    width:620px;
    padding:36px;
    border-radius:30px;
    background:#ffffff;
    position:relative;
}
.container::before{
    content:"";
    position:absolute;
    inset:-24px;
    border-radius:inherit;
    background:
        radial-gradient(circle at 20% 20%, rgba(120,160,255,.7), transparent 55%),
        radial-gradient(circle at 80% 80%, rgba(190,140,255,.7), transparent 55%);
    filter:blur(32px);
    z-index:-1;
}
h2{text-align:center;color:#3c5a80;margin-bottom:28px}
.upload-box{padding:24px;border-radius:22px;border:1px dashed #b7c7de;background:#f6f9ff;}
.file-row{display:flex;gap:16px;align-items:center;flex-wrap:wrap}
input[type=file]{display:none}
.file-picker{display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:999px;background:#fff;border:1px solid #dbe3f3;flex:1}
.choose-btn{padding:8px 16px;border-radius:999px;cursor:pointer;background:#eef3ff;border:1px solid #d7e0f5;color:#3c5a80}
.file-name{font-size:14px;color:#6c84a6}
.btn{padding:11px 24px;border-radius:999px;border:none;cursor:pointer;font-size:15px;background:#ffffff;color:#3c5a80;box-shadow:0 8px 20px rgba(60,90,160,.2);transition:.25s}
.btn:hover{box-shadow:0 12px 30px rgba(60,90,160,.35)}
.files{margin-top:36px}
.file-card{display:flex;justify-content:space-between;align-items:center;padding:16px 20px;border-radius:20px;background:#f9fbff;border:1px solid #e2e8f5;margin-bottom:14px}
.actions{display:flex;gap:10px}

/* MODAL */
.modal{position:fixed;inset:0;display:none;place-items:center;background:rgba(0,0,0,.35)}
.modal-box{width:420px;padding:30px;border-radius:26px;background:#ffffff;position:relative}
.modal-box::before{content:"";position:absolute;inset:-20px;border-radius:inherit;background:radial-gradient(circle at 30% 30%, rgba(255,140,140,.6), transparent 60%),radial-gradient(circle at 70% 70%, rgba(255,200,200,.6), transparent 60%);filter:blur(28px);z-index:-1}
.modal h3{text-align:center;color:#a94442}
.modal p{text-align:center;color:#5a6b85}
.modal-actions{margin-top:24px;display:flex;justify-content:center;gap:14px}
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
<button class="btn">Upload</button>
<input type="file" id="file" name="file" accept=".pdf,.ppt,.pptx" required>
</div>
</form>
</div>

<div class="files">
<h3 style="color:#3c5a80">Files</h3>

<?php foreach ($files as $f):
$ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
$fileUrl = $baseUrl."/".rawurlencode($f);
$viewUrl = ($ext === 'pdf')
    ? $fileUrl
    : "https://view.officeapps.live.com/op/view.aspx?src=".urlencode($fileUrl);
?>
<div class="file-card">
<div><?= htmlspecialchars($f) ?></div>
<div class="actions">
<a class="btn" href="<?= $viewUrl ?>" target="_blank">View</a>
<a class="btn" href="<?= $fileUrl ?>" download>Download</a>
<button class="btn" onclick="openDelete('<?= htmlspecialchars($f) ?>')">Delete</button>
</div>
</div>
<?php endforeach; ?>
</div>
</div>

<!-- DELETE MODAL -->
<div class="modal" id="deleteModal">
<div class="modal-box">
<h3>⚠ Are you sure?</h3>
<p>This file will be permanently deleted.</p>
<form method="POST">
<input type="hidden" name="delete_file" id="deleteFile">
<div class="modal-actions">
<button type="submit" name="confirm_delete" class="btn">Yes, Delete</button>
<button type="button" class="btn" onclick="closeDelete()">Cancel</button>
</div>
</form>
</div>
</div>

<script>
const input = document.getElementById('file');
const label = document.getElementById('file-name');
input.onchange = () => label.textContent = input.files[0]?.name || 'No file selected';

function openDelete(file){
    document.getElementById('deleteFile').value = file;
    document.getElementById('deleteModal').style.display='grid';
}
function closeDelete(){
    document.getElementById('deleteModal').style.display='none';
}
</script>

</body>
</html>
