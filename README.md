# Top Info Bar FREE (m4p_barinfofree)

A free PrestaShop module that displays a customizable information bar at the top of your storefront — perfect for announcements, promotions, free-shipping notices, or holiday messages.

> 🇵🇱 Moduł PrestaShop dodający konfigurowalny pasek informacyjny na górze sklepu — idealny do ogłoszeń i promocji.

![PrestaShop](https://img.shields.io/badge/PrestaShop-1.7%20%E2%80%93%208.1-blue)
![PHP](https://img.shields.io/badge/PHP-7.3%2B-777bb4)
![Version](https://img.shields.io/badge/version-1.1.8-green)

## Features

- 📢 Display a custom text message in a bar fixed to the top of every page
- 🎨 Configure bar background color and text color (hex color picker)
- 🔠 Adjustable font size (in pixels)
- ❌ Optional close button — visitors can dismiss the bar (remembered for 7 days via a cookie)
- 🌍 Multilanguage-ready back office (English + Polish translations included)
- 🛒 Compatible with PrestaShop 1.7.x – 8.1.x, including the Warehouse theme

## Installation

1. Download the latest release as a ZIP archive (the folder inside must be named `m4p_barinfofree`).
2. In your PrestaShop back office go to **Modules → Module Manager → Upload a module** and upload the ZIP.
   - Alternatively, extract the archive into the `modules/` directory of your shop.
3. Find **Top info bar FREE** in the module list and click **Install**.
4. Click **Configure** to set up the bar.

## Configuration

| Setting | Description |
|---|---|
| Text | The message displayed in the top bar |
| Font size | Text size in pixels |
| Text color | Hex color of the message text |
| Bar color | Hex background color of the bar |
| Allow closing | Shows a close (×) button; the choice is stored in a functional cookie for 7 days |

> **GDPR note:** the close feature stores a functional cookie named `m4p_barinfofree`. Remember to list it in your cookie policy under functional cookies.

## Requirements

- PrestaShop **1.7.0 – 8.1.x**
- PHP **7.3+**

## PRO version

Need scheduling, multiple bars, links/buttons in the bar, or per-page targeting? Check out the [PRO version](https://modules4presta.io).

## Project structure

```
m4p_barinfofree/
├── m4p_barinfofree.php      # Main module class (hooks, configuration form)
├── classes/                  # Helper class (requirements check, marketplace ads)
├── translations/pl.php       # Polish translations
└── views/
    ├── css/main.css          # Front-office bar styles
    ├── js/main.js            # Close-button + cookie logic
    └── templates/
        ├── front/topbar.tpl  # Bar markup
        └── admin/            # Back-office panels
```

## Author

**Modules4Presta.io** — [https://modules4presta.io](https://modules4presta.io)

## License

Proprietary — all rights reserved. See the file headers for details.
