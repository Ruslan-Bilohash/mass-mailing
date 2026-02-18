# What's New in Mass Mailing 1.0

## Version 1.0 (Initial Release - February 18, 2026)
- **Core Functionality**: Introduced mass email sending with strict consent requirements (no spam, 18+ confirmation).
- **Multilingual Support**: Added 8 languages: English, Russian, Ukrainian, Lithuanian, Polish, Georgian, Norwegian, German.
- **Input Methods**: Manual email entry, file uploads (TXT, JSON, PHP) for recipients.
- **Attachments**: Support for multiple file attachments in emails.
- **SMTP Configuration**: Editable via `settings.php` or dedicated settings page.
- **Mail Methods**: Choice between SMTP (PHPMailer) and PHP `mail()` function.
- **Error Handling**: Improved logging for failed sends; displays "Sent 0 emails" with failure message if applicable.
- **CAPTCHA**: Added simple math CAPTCHA to feedback form to prevent spam.
- **Email Template**: Beautiful HTML template for emails with header (app name, description), content, and footer (developer info, links to GitHub and other projects like https://edukvam.com/).
- **Anti-Spam Measures**: Enhanced headers (Reply-To, Return-Path) to reduce spam flagging; advice on SPF/DKIM/DMARC.
- **UI Improvements**: Icons (Bootstrap Icons) throughout the interface; responsive design; updated colors (e.g., green accents in email template).
- **Additional Pages**: About, Feedback (with CAPTCHA), Terms, Donate (multiple methods), Settings.
- **Security**: Content Security Policy (CSP) headers; session-based CAPTCHA.
- **Footer Enhancements**: Added more links in app footer and email footer, including to https://edukvam.com/.
- **Documentation**: Updated README.md with multilingual descriptions, installation steps, screenshots.

For full details, check the [GitHub Repository](https://github.com/Ruslan-Bilohash/mass-mailing).  
Developed by [Ruslan Bilohash](https://mapsme.no/bilohash.php). Other projects: [Edukvam](https://edukvam.com/).
