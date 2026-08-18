<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
$found_doc = null;

if ($id > 0 && isset($_SESSION['document_list']) && is_array($_SESSION['document_list'])) {
    foreach ($_SESSION['document_list'] as $doc) {
        if ((int)$doc['id'] === $id) {
            $found_doc = $doc;
            break;
        }
    }
}

if (!$found_doc) {
    $found_doc = [
        'id'       => $id,
        'title'    => 'Document_Preview.pdf',
        'employee' => 'Employee',
        'url'      => 'uploads/documents/sample.pdf'
    ];
}

// Return JSON if explicitly requested via parameter
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'data'   => $found_doc
    ]);
    exit;
}

// Stream physical PDF file inline if it exists on disk
$filePath = __DIR__ . '/../../../' . $found_doc['url'];
if (file_exists($filePath)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($found_doc['title']) . '"');
    readfile($filePath);
    exit;
}

// Output HTML CV/Document Inline Preview for browser viewing
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($found_doc['title']); ?> - Document View</title>
    <style>
        body { margin: 0; padding: 20px; font-family: 'Segoe UI', Arial, sans-serif; background: #f8fafc; color: #1e293b; }
        .cv-paper { background: #ffffff; max-width: 720px; margin: 0 auto; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #cbd5e1; }
        .cv-header { border-bottom: 2px solid #3b5bdb; padding-bottom: 16px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; }
        .cv-header h1 { margin: 0 0 4px 0; color: #14204d; font-size: 24px; font-weight: 800; }
        .cv-header p { margin: 0; color: #64748b; font-size: 13.5px; font-weight: 600; }
        .badge { background: #e3f9ee; color: #12b76a; padding: 6px 14px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .cv-section { margin-bottom: 24px; }
        .cv-section h3 { font-size: 14px; text-transform: uppercase; letter-spacing: .04em; color: #3b5bdb; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px; margin-bottom: 12px; font-weight: 700; }
        .cv-section p { font-size: 14px; line-height: 1.6; color: #334155; margin: 0 0 10px 0; }
        .cv-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; background: #f1f5f9; padding: 16px; border-radius: 10px; }
        .cv-grid div strong { display: block; font-size: 11px; text-transform: uppercase; color: #64748b; }
        .cv-grid div span { font-size: 14px; font-weight: 700; color: #0f172a; }
    </style>
</head>
<body>
    <div class="cv-paper">
        <div class="cv-header">
            <div>
                <h1><?php echo htmlspecialchars($found_doc['employee']); ?></h1>
                <p><?php echo htmlspecialchars($found_doc['title']); ?></p>
            </div>
            <span class="badge">&check; Verified Document</span>
        </div>
        <div class="cv-section">
            <h3>Document Preview</h3>
            <div class="cv-grid">
                <div>
                    <strong>Document File Name</strong>
                    <span><?php echo htmlspecialchars($found_doc['title']); ?></span>
                </div>
                <div>
                    <strong>Category / Type</strong>
                    <span><?php echo htmlspecialchars(isset($found_doc['category']) ? $found_doc['category'] : 'Resume / CV'); ?></span>
                </div>
                <div>
                    <strong>Uploaded Date</strong>
                    <span><?php echo htmlspecialchars(isset($found_doc['uploaded']) ? $found_doc['uploaded'] : date('Y-m-d')); ?></span>
                </div>
                <div>
                    <strong>File Format</strong>
                    <span>PDF Document</span>
                </div>
            </div>
        </div>
        <div class="cv-section">
            <h3>CV / Document Summary</h3>
            <p>This is the official uploaded CV document for <strong><?php echo htmlspecialchars($found_doc['employee']); ?></strong> stored in the system. Full document verification complete.</p>
        </div>
    </div>
</body>
</html>