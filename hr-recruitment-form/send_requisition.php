<?php
header('Content-Type: application/json');

define('SMTP_HOST',            'smtp.gmail.com');
define('SMTP_PORT',            587);
define('SMTP_SECURE',          'tls');
define('SMTP_USER',            'shams.haqyar786@gmail.com');
define('SMTP_PASS',            'gwit wqwc wvph jirf');
define('FROM_EMAIL',           'shams.haqyar786@gmail.com');
define('FROM_NAME',            'Lapis Group HR System');
define('HR_EMAIL',             'Zalmay.Akbar@Lapis-group.com');
define('HR_NAME',              'HR Department');
define('SEND_COPY_TO_MANAGER', true);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

function clean($key) {
    return htmlspecialchars(trim($_POST[$key] ?? ''), ENT_QUOTES, 'UTF-8');
}

$f = [
    'job_title'         => clean('job_title'),
    'department'        => clean('department'),
    'prime_contract'    => clean('prime_contract'),
    'budgeted_salary'   => clean('budgeted_salary'),
    'employment_type'   => clean('employment_type'),
    'contract_start'    => clean('contract_start'),
    'contract_end'      => clean('contract_end'),
    'start_date'        => clean('start_date'),
    'num_positions'     => clean('num_positions'),
    'position_type'     => clean('position_type'),
    'justification'     => clean('justification'),
    'role_summary'      => clean('role_summary'),
    'responsibilities'  => clean('responsibilities'),
    'qualifications'    => clean('qualifications'),
    'preferred_skills'  => clean('preferred_skills'),
    'manager_name'      => clean('manager_name'),
    'manager_email'     => clean('manager_email'),
    'manager_signature' => clean('manager_signature'),
    'request_date'      => clean('request_date'),
    'notes'             => clean('notes'),
];

$required = ['job_title','department','employment_type','start_date','justification','role_summary','manager_name','manager_email','request_date'];
foreach ($required as $key) {
    if (empty($f[$key])) {
        echo json_encode(['success' => false, 'message' => "Missing required field: $key"]);
        exit;
    }
}

$contract_duration = (!empty($f['contract_start']) && !empty($f['contract_end']))
    ? $f['contract_start'] . ' to ' . $f['contract_end'] : 'N/A';

// GENERATE PDF — loaded outside any if/class block
$pdf_string   = null;
$pdf_filename = 'Recruitment_' . preg_replace('/[^a-zA-Z0-9]/', '_', $f['job_title']) . '_' . date('Ymd') . '.pdf';

$fpdf_path = __DIR__ . '/fpdf/fpdf.php';

if (file_exists($fpdf_path)) { try {
    require_once $fpdf_path;

    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->SetMargins(14, 14, 14);
    $pdf->SetAutoPageBreak(true, 18);
    $pdf->AddPage();

    // ── Header bar ──────────────────────────────
    $pdf->SetFillColor(10, 22, 40);
    $pdf->Rect(0, 0, 210, 36, 'F');
    $pdf->SetFillColor(0, 119, 204);
    $pdf->Rect(0, 36, 210, 1.5, 'F');
    $pdf->SetFont('Helvetica', 'B', 8);
    $pdf->SetTextColor(0, 170, 255);
    $pdf->SetXY(14, 9);
    $pdf->Cell(0, 5, 'LAPIS GROUP  |  HUMAN RESOURCES', 0, 1, 'L');
    $pdf->SetFont('Helvetica', 'B', 17);
    $pdf->SetTextColor(232, 244, 255);
    $pdf->SetXY(14, 16);
    $pdf->Cell(0, 10, 'Recruitment Requisition Form', 0, 1, 'L');
    $pdf->SetY(42);

    // ── Meta bar ────────────────────────────────
    $pdf->SetFillColor(240, 247, 255);
    $pdf->SetFont('Helvetica', '', 8);
    $pdf->SetTextColor(80, 110, 140);
    $pdf->SetX(14);
    $pdf->Cell(92, 6, 'Submitted by: ' . $f['manager_name'] . '  <' . $f['manager_email'] . '>', 0, 0, 'L', true);
    $pdf->Cell(90, 6, 'Date: ' . $f['request_date'], 0, 1, 'R', true);
    $pdf->Ln(4);

    // ── Helper: section header ───────────────────
    $sec = function($title) use ($pdf) {
        $pdf->SetFillColor(10, 22, 40);
        $pdf->SetTextColor(0, 170, 255);
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetX(14);
        $pdf->Cell(182, 7, '  ' . strtoupper($title), 0, 1, 'L', true);
        $pdf->SetFillColor(0, 119, 204);
        $pdf->Rect(14, $pdf->GetY(), 182, 0.4, 'F');
        $pdf->Ln(2);
    };

    // ── Helper: field row ────────────────────────
    $row = function($label, $value, $multi = false) use ($pdf) {
        if (empty($value)) return;
        $lw = 50; $vw = 132;
        if ($multi) {
            $pdf->SetX(14);
            $pdf->SetFillColor(235, 243, 252);
            $pdf->SetTextColor(60, 90, 120);
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->Cell($lw, 7, $label, 0, 0, 'L', true);
            $pdf->SetFillColor(252, 253, 255);
            $pdf->SetTextColor(10, 22, 40);
            $pdf->SetFont('Helvetica', '', 9);
            $pdf->MultiCell($vw, 5, $value, 0, 'L', true);
        } else {
            $pdf->SetX(14);
            $pdf->SetFillColor(235, 243, 252);
            $pdf->SetTextColor(60, 90, 120);
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->Cell($lw, 7, $label, 0, 0, 'L', true);
            $pdf->SetFillColor(252, 253, 255);
            $pdf->SetTextColor(10, 22, 40);
            $pdf->SetFont('Helvetica', '', 9);
            $pdf->Cell($vw, 7, $value, 0, 1, 'L', true);
        }
        $pdf->SetDrawColor(200, 220, 240);
        $pdf->Line(14, $pdf->GetY(), 196, $pdf->GetY());
        $pdf->Ln(1);
    };

    $sec('01  Position Details');
    $row('Job Title',        $f['job_title']);
    $row('Department',       $f['department']);
    $row('Prime Contract',   $f['prime_contract'] ?: 'N/A');
    $row('Budgeted Salary',  $f['budgeted_salary'] ?: 'N/A');
    $row('No. of Positions', $f['num_positions'] ?: '1');
    $pdf->Ln(3);

    $sec('02  Employment Type');
    $row('Employment Type',    $f['employment_type']);
    $row('Contract Duration',  $contract_duration);
    $row('Expected Start Date',$f['start_date']);
    $row('Position Type',      $f['position_type'] ?: 'N/A');
    $pdf->Ln(3);

    $sec('03  Justification');
    $row('Justification', $f['justification'], true);
    $pdf->Ln(3);

    $sec('04  Job Profile');
    $row('Role Summary',        $f['role_summary'], true);
    if (!empty($f['responsibilities'])) $row('Key Responsibilities', $f['responsibilities'], true);
    if (!empty($f['qualifications']))   $row('Qualifications',       $f['qualifications'],   true);
    if (!empty($f['preferred_skills'])) $row('Preferred Skills',     $f['preferred_skills'], true);
    $pdf->Ln(3);

    $sec('05  Requested By');
    $row('Line Manager', $f['manager_name']);
    $row('Email',        $f['manager_email']);
    $row('Signature',    $f['manager_signature'] ?: $f['manager_name']);
    $row('Date',         $f['request_date']);
    $pdf->Ln(3);

    if (!empty($f['notes'])) {
        $sec('06  Additional Notes');
        $row('Notes', $f['notes'], true);
        $pdf->Ln(3);
    }

    // ── Signature boxes ──────────────────────────
    $pdf->Ln(6);
    $pdf->SetFillColor(240, 247, 255);
    $pdf->SetDrawColor(0, 119, 204);
    $pdf->SetX(14);
    $pdf->Cell(56, 16, '', 1, 0, 'C', true);
    $pdf->Cell(7,  16, '', 0, 0);
    $pdf->Cell(56, 16, '', 1, 0, 'C', true);
    $pdf->Cell(7,  16, '', 0, 0);
    $pdf->Cell(52, 16, '', 1, 1, 'C', true);
    $pdf->SetX(14);
    $pdf->SetFont('Helvetica', '', 7);
    $pdf->SetTextColor(100, 140, 180);
    $pdf->Cell(56, 5, 'Requested By (Signature)', 0, 0, 'C');
    $pdf->Cell(7,  5, '', 0, 0);
    $pdf->Cell(56, 5, 'Approved By', 0, 0, 'C');
    $pdf->Cell(7,  5, '', 0, 0);
    $pdf->Cell(52, 5, 'HR Received', 0, 1, 'C');

    // ── Footer ───────────────────────────────────
    $pdf->SetY(-13);
    $pdf->SetFillColor(10, 22, 40);
    $pdf->Rect(0, $pdf->GetY(), 210, 20, 'F');
    $pdf->SetFont('Helvetica', '', 8);
    $pdf->SetTextColor(100, 140, 180);
    $pdf->Cell(0, 8, 'Lapis Group HR System  |  Confidential  |  Page 1', 0, 0, 'C');

    $pdf_string = $pdf->Output('S');
} catch (\Throwable $e) { $pdf_string = null; } }

// BUILD HTML EMAIL
function erow($label, $value) {
    if (empty($value)) return '';
    $v = nl2br(htmlspecialchars($value));
    return "<tr>
      <td style='padding:9px 14px;background:#eef4fb;width:170px;font-size:11px;font-weight:700;color:#4a6480;vertical-align:top;border-bottom:1px solid #dce8f5;'>{$label}</td>
      <td style='padding:9px 14px;font-size:12px;color:#0a1628;vertical-align:top;border-bottom:1px solid #dce8f5;'>{$v}</td>
    </tr>";
}
function esec($title) {
    return "<tr><td colspan='2' style='background:#0a1628;color:#00aaff;padding:8px 14px;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;'>{$title}</td></tr>";
}

$html  = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head>';
$html .= '<body style="font-family:Arial,sans-serif;background:#e8f0f8;margin:0;padding:24px 16px;">';
$html .= '<div style="max-width:640px;margin:0 auto;background:#fff;border:1px solid #c5d5e8;">';
$html .= '<div style="background:#0a1628;padding:24px 28px;">';
$html .= '<p style="font-size:9px;letter-spacing:4px;color:#00aaff;margin:0 0 8px;font-weight:700;">LAPIS GROUP &middot; HUMAN RESOURCES</p>';
$html .= '<h1 style="color:#e8f4ff;font-size:20px;margin:0 0 6px;">Recruitment Requisition</h1>';
$html .= '<p style="color:rgba(200,230,255,0.6);font-size:11px;margin:0;">Submitted on ' . date('d F Y', strtotime($f['request_date'] ?: 'today')) . ' &nbsp;&bull;&nbsp; ' . $f['manager_name'] . '</p>';
$html .= '</div>';
if ($pdf_string) {
    $html .= '<div style="background:#eef6ff;padding:11px 20px;border-bottom:1px solid #c5d5e8;font-size:12px;color:#0a5a8c;">&#128206; A formatted PDF of this requisition is attached.</div>';
}
$html .= '<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">';
$html .= esec('01 &middot; Position Details');
$html .= erow('Job Title',          $f['job_title']);
$html .= erow('Department',         $f['department']);
$html .= erow('Prime Contract',     $f['prime_contract'] ?: 'N/A');
$html .= erow('Budgeted Salary',    $f['budgeted_salary'] ?: 'N/A');
$html .= erow('No. of Positions',   $f['num_positions'] ?: '1');
$html .= esec('02 &middot; Employment Type');
$html .= erow('Employment Type',    $f['employment_type']);
$html .= erow('Contract Duration',  $contract_duration);
$html .= erow('Expected Start Date',$f['start_date']);
$html .= erow('Position Type',      $f['position_type'] ?: 'N/A');
$html .= esec('03 &middot; Justification');
$html .= erow('Justification',      $f['justification']);
$html .= esec('04 &middot; Job Profile');
$html .= erow('Role Summary',       $f['role_summary']);
$html .= erow('Key Responsibilities',$f['responsibilities'] ?: 'N/A');
$html .= erow('Qualifications',     $f['qualifications'] ?: 'N/A');
$html .= erow('Preferred Skills',   $f['preferred_skills'] ?: 'N/A');
$html .= esec('05 &middot; Requested By');
$html .= erow('Line Manager',       $f['manager_name']);
$html .= erow('Email',              $f['manager_email']);
$html .= erow('Signature',          $f['manager_signature'] ?: $f['manager_name']);
$html .= erow('Date',               $f['request_date']);
if (!empty($f['notes'])) {
    $html .= esec('06 &middot; Additional Notes');
    $html .= erow('Notes', $f['notes']);
}
$html .= '</table>';
$html .= '<div style="background:#eef4fb;padding:14px 20px;border-top:2px solid #0077cc;">';
$html .= '</div></div></body></html>';

$plain  = "RECRUITMENT REQUISITION\n";
$plain .= "Submitted by: {$f['manager_name']} <{$f['manager_email']}> on {$f['request_date']}\n\n";
$plain .= "JOB TITLE: {$f['job_title']}\nDEPARTMENT: {$f['department']}\n";
$plain .= "EMPLOYMENT TYPE: {$f['employment_type']}\nSTART DATE: {$f['start_date']}\n\n";
$plain .= "JUSTIFICATION:\n{$f['justification']}\n\nROLE SUMMARY:\n{$f['role_summary']}\n";

// ─────────────────────────────────────────────
// LOAD PHPMAILER AND SEND
// ─────────────────────────────────────────────
$loaded = false;
if (file_exists(__DIR__ . '/PHPMailer/PHPMailer.php')) {
    require __DIR__ . '/PHPMailer/Exception.php';
    require __DIR__ . '/PHPMailer/PHPMailer.php';
    require __DIR__ . '/PHPMailer/SMTP.php';
    $loaded = true;
} elseif (file_exists(__DIR__ . '/PHPMailer/src/PHPMailer.php')) {
    require __DIR__ . '/PHPMailer/src/Exception.php';
    require __DIR__ . '/PHPMailer/src/PHPMailer.php';
    require __DIR__ . '/PHPMailer/src/SMTP.php';
    $loaded = true;
}

if (!$loaded) {
    echo json_encode(['success' => false, 'message' => 'PHPMailer not found.']);
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = SMTP_PORT;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom(FROM_EMAIL, FROM_NAME);
    $mail->addAddress(HR_EMAIL, HR_NAME);

    if (SEND_COPY_TO_MANAGER && !empty($f['manager_email'])) {
        $mail->addCC($f['manager_email'], $f['manager_name']);
    }
    if (!empty($f['manager_email'])) {
        $mail->addReplyTo($f['manager_email'], $f['manager_name']);
    }

    $mail->Subject = 'Recruitment Requisition: ' . $f['job_title'] . ' - ' . $f['department'];
    $mail->isHTML(true);
    $mail->Body    = $html;
    $mail->AltBody = $plain;

    if ($pdf_string) {
        $mail->addStringAttachment($pdf_string, $pdf_filename, 'base64', 'application/pdf');
    }

    $mail->send();
    echo json_encode(['success' => true, 'message' => 'Requisition sent to HR successfully.' . ($pdf_string ? ' PDF attached.' : '')]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
}
