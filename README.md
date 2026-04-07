# HR Recruitment Requisition Form

<!-- Header Banner -->
<p align="center">
  <img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=2,12,24&height=200&section=header&text=HR%20Recruitment%20Form&fontSize=52&fontAlignY=35&animation=fadeIn&desc=Online%20Requisition%20%7C%20Auto%20Email%20%7C%20PDF%20Attachment&descSize=18&descAlignY=55" alt="Header"/>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-Live%20%26%20Active-success?style=for-the-badge" alt="Status"/>
  <img src="https://img.shields.io/badge/Backend-PHP%20%2B%20PHPMailer-777BB4?style=for-the-badge" alt="Backend"/>
  <img src="https://img.shields.io/badge/PDF-FPDF%201.86-red?style=for-the-badge" alt="PDF"/>
</p>

<p align="center">
  <img src="https://readme-typing-svg.herokuapp.com?font=Fira+Code&pause=1000&color=0099FF&center=true&vCenter=true&width=600&lines=Online+Recruitment+Requisition+Form;Formatted+HTML+Email+to+HR;Auto+PDF+Attachment+on+Submit;No+Database+%7C+No+Framework+%7C+Pure+PHP" alt="Typing SVG"/>
</p>

---

## 📖 About

A lightweight web-based recruitment requisition form that replaces manual Word document submissions. Managers fill out the form online, click Submit, and HR instantly receives a formatted email with a branded PDF attachment — no database, no framework, no manual follow-up.

---

## ✨ Key Features

```
┌─────────────────────────────────────────────────────────────────┐
│  📋 FORM CAPABILITIES                                           │
├─────────────────────────────────────────────────────────────────┤
│  ✓ Clean branded web form — no login required                   │
│  ✓ Formatted HTML email sent to HR on submission                │
│  ✓ Branded PDF generated and attached automatically             │
│  ✓ CC copy sent to the requesting manager                       │
│  ✓ Server-side validation                                       │
│  ✓ Works on any PHP shared hosting (Hostinger, cPanel, etc.)    │
│  ✓ No database or framework required                            │
│  ✓ Mobile friendly                                              │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔄 How It Works

```
Manager opens form
       ↓
Fills in position details, employment type, justification, job profile
       ↓
Clicks Submit
       ↓
PHP backend processes the form
       ↓
FPDF generates a branded PDF
       ↓
PHPMailer sends email via SMTP
       ↓
HR receives formatted HTML email + PDF attachment
Manager receives a CC copy
```

---

## 📋 Form Sections

<details>
<summary><b>📌 Position Details</b></summary>

- Job Title
- Department / Project
- Prime Contract
- Budgeted Salary
- Number of Positions

</details>

<details>
<summary><b>📅 Employment Type</b></summary>

- Full-Time / Part-Time / Contract / Consultancy
- Contract Start & End Date
- Expected Start Date
- New Position / Replacement / Expansion

</details>

<details>
<summary><b>📝 Job Profile</b></summary>

- Justification for Recruitment
- Role Summary
- Key Responsibilities
- Required Qualifications
- Preferred Skills

</details>

<details>
<summary><b>✍️ Requested By</b></summary>

- Line Manager Name & Email
- Signature
- Date
- Additional Notes

</details>

---

## 🧰 Tech Stack

<p align="center">
  <img src="https://skillicons.dev/icons?i=html,css,js,php,github" alt="Tech Stack"/>
</p>

### Frontend
![HTML](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

### Backend & Libraries
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![PHPMailer](https://img.shields.io/badge/PHPMailer-SMTP-orange?style=for-the-badge)
![FPDF](https://img.shields.io/badge/FPDF-1.86-red?style=for-the-badge)

### Typography
![Google Fonts](https://img.shields.io/badge/Rajdhani-000000?style=for-the-badge)
![Google Fonts](https://img.shields.io/badge/Inter-000000?style=for-the-badge)

---

## 📁 Directory Structure

```
hr-recruitment-form/
├── recruitment.html          # The online form
├── send_requisition.php      # Backend — processes & sends email + PDF
├── PHPMailer/
│   ├── PHPMailer.php
│   ├── SMTP.php
│   └── Exception.php
├── fpdf/
│   └── fpdf.php
└── README.md
```

---

## ⚙️ Setup

### 1. Upload files
Upload all files to your hosting directory (e.g. `public_html/hire/`).

### 2. Download dependencies
- **PHPMailer** — [github.com/PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer) → copy `PHPMailer.php`, `SMTP.php`, `Exception.php` into `PHPMailer/`
- **FPDF** — [fpdf.org](http://www.fpdf.org) → place `fpdf.php` into `fpdf/`

### 3. Configure `send_requisition.php`

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

### 4. Visit the form
```
yourdomain.com/hire/recruitment.html
```

---

## 🗺️ Roadmap

- [x] Online form with full requisition fields
- [x] Formatted HTML email to HR
- [x] PDF attachment generation
- [x] CC copy to requesting manager
- [x] Server-side validation
- [x] Brand colors and typography
- [ ] Approval workflow (HR approves/rejects → notifies manager)
- [ ] Admin dashboard to view all submissions
- [ ] Multi-language support (Dari/Pashto)
- [ ] Email delivery to inbox (DKIM/SPF setup)

---

## 📬 Contact

<p align="center">
  <a href="https://www.linkedin.com/in/shams-haqyar-373020136/"><img src="https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white"/></a>
  <a href="https://github.com/shamsulhaqHaqyar"><img src="https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white"/></a>
</p>

---

<p align="center">
  <img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=2,12,24&height=100&section=footer" alt="Footer"/>
</p>
