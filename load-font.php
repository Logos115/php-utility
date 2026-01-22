<?php
// Fixed standalone version - no Laravel helpers needed. Run with: php load-font.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "Step 1: Starting script...\n";

require_once __DIR__ . '/vendor/autoload.php';
echo "Step 2: Autoload loaded successfully.\n";

use Dompdf\Adapter\CPDF;
use Dompdf\Exception\FontException;
use Dompdf\FontMetrics;

echo "Step 3: Classes imported.\n";

    // Use relative paths (assuming script is in project root, where 'storage/' is a sibling)
    $fontDir = __DIR__ . '/storage/fonts';  // Plain PHP path
    $fontFile = $fontDir . '/OCRAStd.otf';
    $familyName = 'ocrb';

    echo "Step 4: Font dir: $fontDir\n";
    echo "Step 5: Font file path: $fontFile\n";

    if (!file_exists($fontFile)) {
        throw new Exception("Font file not found: $fontFile. Make sure OCRAStd.otf is in storage/fonts/.");
    }
    echo "Step 6: Font file exists and is readable.\n";

    echo "Step 7: Creating FontMetrics...\n";
    $fontMetrics = new FontMetrics($fontDir, $fontDir);
    echo "Step 8: FontMetrics created.\n";

    echo "Step 9: Loading font...\n";
    $fontMetrics->loadFont($fontFile, $familyName);
    echo "Step 10: Font loaded successfully!\n";

    echo "Success! Font '$familyName' loaded.\n";
    echo "Check " . $fontDir . " for new files like ocrb.ufm.json, ocrb.afm.json.\n";
    echo "You can now update your config/dompdf.php and test the PDF.\n";

?>