# HR Recruitment Requisition Form

An online recruitment request form for internal use. Replaces manual Word document submissions with a clean web form that automatically emails HR with a formatted summary and PDF attachment.

---

## Features

- Web-based form hosted on any PHP shared hosting (Hostinger, cPanel, etc.)
- Sends a formatted HTML email to HR on submission
- Attaches a branded PDF copy of the requisition
- CC copy sent automatically to the requesting manager
- No database required — fully stateless
- Mobile friendly

---

## Tech Stack

- **Frontend:** HTML, CSS, JavaScript (vanilla)
- **Backend:** PHP
- **Email:** PHPMailer via SMTP
- **PDF Generation:** FPDF 1.86

---

## Directory Structure

```
hr-recruitment-form/
├── recruitment.html       # The online form
├── send_requisition.php   # Backend — processes form and sends email
├── PHPMailer/
│   ├── PHPMailer.php
│   ├── SMTP.php
│   └── Exception.php
├── fpdf/
│   └── fpdf.php
└── README.md
```

---

## Setup

### 1. Upload files
Upload all files to your hosting directory (e.g. `public_html/hire/`).

### 2. Download dependencies
- **PHPMailer** — download from [github.com/PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer), copy `PHPMailer.php`, `SMTP.php`, `Exception.php` into the `PHPMailer/` folder
- **FPDF** — download from [fpdf.org](http://www.fpdf.org), place `fpdf.php` into the `fpdf/` folder

### 3. Configure `send_requisition.php`
Edit the CONFIG block at the top of `send_requisition.php`:

```php
define('SMTP_HOST',  'smtp.yourprovider.com');
define('SMTP_PORT',  587);
define('SMTP_USER',  'sender@yourdomain.com');
define('SMTP_PASS',  'your_password');
define('FROM_EMAIL', 'sender@yourdomain.com');
define('FROM_NAME',  'HR System');
define('HR_EMAIL',   'hr@yourdomain.com');
```

> For Gmail SMTP, use `smtp.gmail.com` with an [App Password](https://support.google.com/accounts/answer/185833).

### 4. Access the form
Visit `yourdomain.com/hire/recruitment.html`

---

## Email Deliverability

To prevent emails landing in junk/spam:
- Set up **SPF** and **DKIM** DNS records for your sending domain
- Ideally use a domain email (not Gmail) as the sender

---

## Form Fields

| Section | Fields |
|---|---|
| Position Details | Job Title, Department, Prime Contract, Budgeted Salary, No. of Positions |
| Employment Type | Type, Contract Duration, Start Date, New/Replacement |
| Justification | Free text |
| Job Profile | Role Summary, Responsibilities, Qualifications, Preferred Skills |
| Requested By | Manager Name, Email, Signature, Date |
| Additional Notes | Free text |

---

## License

MIT
