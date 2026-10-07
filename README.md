# M4P Top Info Bar for PrestaShop 8 & 9

**Say the one thing every visitor should know — free shipping over an amount, a holiday closure, a price list change — across the top of every page.**

> **Meta description (147 chars):** Add an information bar at the top of your PrestaShop shop. Set the text, the colours and whether visitors can close it. Free MIT module.

---

## Why a bar and not a banner

An announcement buried in a CMS page reaches nobody. A bar across the top is seen on every page,
by everyone, without taking space from the product:

- **Answers the question before it is asked** — the shipping threshold, the cut-off hour, the holiday
- **One place to change it** — not a banner to re-cut and a template to edit
- **Dismissible when you want** — let visitors close it, or keep it up
- **Matches the shop** — background and text colours are yours to set

## What the module does

You write the text, pick the bar and text colours, set the font size and decide whether a visitor
may close the bar. It then appears at the top of every page in the front office. Closing it is
remembered in a cookie for that visitor.

### Key features

- **Any message, any colours** — hex values for background and text, size in pixels
- **Optional close button** — switch it off for a message that has to stay up
- **Remembers the dismissal** — a closed bar does not come back for that visitor
- **Nothing on the page when empty** — clear the text and the bar disappears completely
- **No external services** — nothing is loaded from anybody's server

### What it does not do

The module shows one bar with one message, on every page, to everyone. No scheduling, no targeting
by page or country, no rotation between messages. For a scheduled campaign with a button, use
`m4p_advancedpopup` instead.

## Compatibility

| | |
|---|---|
| PrestaShop | 1.7.6 – 9.x |
| PHP | 7.2.5+ |
| Requirements | none |
| Multistore | Settings are shared across shops |
| Themes | Needs a theme that renders `displayHeader` (every theme does) |

The module performs no core overrides and adds no database tables — it stores five settings.

## Installation

1. Upload and install the module from **Modules → Module Manager**.
2. Open the module configuration and write the bar text.
3. Set the colours and the font size, and decide whether visitors may close the bar.
4. Open the shop — the bar is at the top of the page.

## Configuration options

| Setting | Description |
|---|---|
| **Bar text** | The message. Leave it empty to hide the bar entirely. |
| **Bar colour**, **Text colour** | Hex codes, validated before saving. |
| **Font size** | In pixels. |
| **Let visitors close the bar** | Adds a close button. The choice is remembered in a cookie. |

## Frequently asked questions

**How do I turn the bar off?**
Clear the text. The module then renders nothing at all — no empty strip, no markup.

**Does the closing cookie need a mention in my cookie policy?**
Yes, if you let visitors close the bar. It is a functional cookie; list the module among them.

**Can I use HTML in the message?**
The text is escaped before it is printed, so it appears exactly as typed. That is deliberate — a bar
on every page is the wrong place for arbitrary markup.

**Can I show different bars in different languages?**
Not in this version; the text is one value for the whole shop.

**What happens to the settings when I uninstall the module?**
All five are deleted.

---

**Keywords:** PrestaShop top bar, information bar, announcement bar, free shipping bar, shop notice,
header message.

## License

MIT — see [LICENSE](LICENSE). Free to use commercially, fork and modify; keep the copyright notice.

## Contributing

Bug reports and pull requests are welcome — see [CONTRIBUTING.md](CONTRIBUTING.md). For security
issues, follow [SECURITY.md](SECURITY.md) instead of opening a public issue.

---

Built by [Nice Code](https://nice-code.com/pl/oferta/moduly-prestashop) — we build and maintain PrestaShop stores.

© Nice Code sp. z o.o. (Modules4Presta) — released under the MIT license.
