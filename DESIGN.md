# Nhat Duong — Style Reference
> Green & Gold corporate canvas

**Theme:** light

Nhat Duong presents a bright, professional interface with a focus on trust and energy. A clean base of white and soft grays provides an expansive canvas, punctuated by two vibrant brand colors: a fresh forest green (#0b7f42) for primary actions and trust, and a warm golden yellow (#fbb116) for secondary emphasis and highlights. These complementary colors create a balanced, natural aesthetic that conveys growth, prosperity, and reliability. Components favor soft, rounded corners and subtle shadows, maintaining a modern yet approachable look.

## Tokens — Colors

| Name | Value | Token | Role |
|------|-------|-------|------|
| Canvas White | `#ffffff` | `--color-canvas-white` | Page backgrounds, elevated card surfaces, main panel fills |
| Subtle Ash | `#f0f4f1` | `--color-subtle-ash` | Subtle background for navigation elements, muted card backgrounds, and very light borders |
| Ghost Fog | `#f8fdf9` | `--color-ghost-fog` | Lightest background for cards and secondary badges, creating a slight visual separation with green tint |
| Slate Text | `#2c3e36` | `--color-slate-text` | Primary body text, neutral action borders, general UI elements |
| Forest Deep | `#062d1c` | `--color-forest-deep` | Dominant text for headlines, strong accents, and footer backgrounds — signifying brand presence and authority |
| Muted Gray | `#5a6c62` | `--color-muted-gray` | Secondary text, navigation links, ghost button text and borders — used for less prominent information |
| Input Border | `#d1ddd5` | `--color-input-border` | Input field borders, divider lines, subtle button borders |
| Brand Green | `#0b7f42` | `--color-brand-green` | Primary call-to-action buttons, active states, key interactive icons — the company's main brand color |
| Brand Gold | `#fbb116` | `--color-brand-gold` | Secondary call-to-action, highlights, promotional elements — the company's secondary brand color |
| Soft Green | `#d4f4e2` | `--color-soft-green` | Soft accent in card backgrounds and decorative borders, suggesting growth and nature |
| Deep Green Accent | `#085d32` | `--color-deep-green-accent` | Darker accent for badge text and outlines, providing deep contrast against lighter backgrounds |
| Hint Gray | `#8a9c92` | `--color-hint-gray` | Placeholder text in input fields, supporting detail text |
| Success Green Text | `#0a3d23` | `--color-success-green-text` | Text for success badges |
| Light Gold | `#fef3d7` | `--color-light-gold` | Light background for promotional elements and highlights |
| Green Hover | `#096b39` | `--color-green-hover` | Hover state for primary green buttons |
| Soft Green Background | `#e8f8ef` | `--color-soft-green-background` | Background for success badges and info cards |
| Gold Text | `#8a6300` | `--color-gold-text` | Text on gold backgrounds for optimal contrast |
| Gold Hover | `#e19f14` | `--color-gold-hover` | Hover state for secondary gold buttons |
| Green Gradient | `linear-gradient(135deg, rgb(11, 127, 66), rgb(8, 93, 50) 100%)` | `--gradient-brand-green` | Gradient using brand green shades for hero sections |
| Gold Gradient | `linear-gradient(135deg, rgb(251, 177, 22), rgb(225, 159, 20) 100%)` | `--gradient-brand-gold` | Gradient using brand gold shades for accents |

## Tokens — Typography

### Inter — Modern system sans-serif for all text. Its clean, readable forms contribute to a professional, trustworthy feel. · `--font-inter`
- **Weights:** 400, 500, 600, 700
- **Sizes:** 12px, 14px, 15px, 16px, 18px, 20px, 28px, 40px, 56px, 72px
- **Line height:** 1.20, 1.40, 1.43, 1.50, 1.60
- **Letter spacing:** -0.02em at large sizes, 0em at body sizes
- **Role:** Modern system sans-serif for all text. Its clean, readable forms contribute to a professional, trustworthy feel.

### Type Scale

| Role | Size | Line Height | Letter Spacing | Token |
|------|------|-------------|----------------|-------|
| caption | 12px | 1.5 | 0px | `--text-caption` |
| body-sm | 14px | 1.43 | 0px | `--text-body-sm` |
| body | 16px | 1.5 | 0px | `--text-body` |
| subheading | 18px | 1.44 | -0.18px | `--text-subheading` |
| heading-sm | 20px | 1.4 | -0.4px | `--text-heading-sm` |
| heading | 28px | 1.2 | -0.56px | `--text-heading` |
| heading-lg | 40px | 1.2 | -0.8px | `--text-heading-lg` |
| display | 56px | 1.1 | -1.12px | `--text-display` |
| display-xl | 72px | 1.05 | -1.44px | `--text-display-xl` |

## Tokens — Spacing & Shapes

**Base unit:** 8px

**Density:** comfortable

### Spacing Scale

| Name | Value | Token |
|------|-------|-------|
| 8 | 8px | `--spacing-8` |
| 16 | 16px | `--spacing-16` |
| 24 | 24px | `--spacing-24` |
| 32 | 32px | `--spacing-32` |
| 40 | 40px | `--spacing-40` |
| 48 | 48px | `--spacing-48` |
| 56 | 56px | `--spacing-56` |
| 64 | 64px | `--spacing-64` |
| 72 | 72px | `--spacing-72` |
| 80 | 80px | `--spacing-80` |
| 96 | 96px | `--spacing-96` |
| 144 | 144px | `--spacing-144` |
| 168 | 168px | `--spacing-168` |
| 224 | 224px | `--spacing-224` |

### Border Radius

| Element | Value |
|---------|-------|
| cards | 16px |
| badges | 999px |
| inputs | 8px |
| buttons | 8px |
| smallComponents | 12px |

### Shadows

| Name | Value | Token |
|------|-------|-------|
| sm | `rgba(11, 127, 66, 0.05) 0px 1px 2px 0px` | `--shadow-sm` |
| md | `rgba(11, 127, 66, 0.08) 0px 2px 8px 0px` | `--shadow-md` |
| lg | `rgba(11, 127, 66, 0.10) 0px 4px 16px 0px` | `--shadow-lg` |
| xl | `rgba(11, 127, 66, 0.12) 0px 8px 24px 0px` | `--shadow-xl` |

### Layout

- **Page max-width:** 1200px
- **Section gap:** 64px
- **Card padding:** 32px
- **Element gap:** 24px

## Components

### Primary Filled Button (Green)
**Role:** Main call-to-action button, signaling primary interactions.

Background: Brand Green (#0b7f42), Text: Canvas White (#ffffff), Border Radius: 8px, Padding: 14px vertical, 28px horizontal. Typography: Inter, 16px, weight 600. Hover: Green Hover (#096b39).

### Secondary Filled Button (Gold)
**Role:** Secondary call-to-action, promotional actions.

Background: Brand Gold (#fbb116), Text: Gold Text (#8a6300), Border Radius: 8px, Padding: 14px vertical, 28px horizontal. Typography: Inter, 16px, weight 600. Hover: Gold Hover (#e19f14).

### Outlined Button
**Role:** Subtle alternative actions, often paired with a primary button.

Background: Canvas White (#ffffff), Text: Brand Green (#0b7f42), Border: 2px solid Brand Green (#0b7f42), Border Radius: 8px, Padding: 12px vertical, 26px horizontal. Typography: Inter, 16px, weight 500.

### Ghost Link Button
**Role:** Discreet, text-based actions found in navigation or inline.

Background: transparent, Text: Muted Gray (#5a6c62), Border: none, Border Radius: 0px, Padding: 0px. Typography: Inter, 14px, weight 400. Hover: Brand Green (#0b7f42).

### Elevated Card
**Role:** Content container that gently floats above the page background, drawing attention.

Background: Canvas White (#ffffff), Border Radius: 16px, Padding: 32px, Shadow: rgba(11, 127, 66, 0.10) 0px 4px 16px 0px.

### Subtle Background Card
**Role:** Content container with a soft background, used for grouping related information.

Background: Ghost Fog (#f8fdf9), Border Radius: 12px, Padding: 24px. No shadow.

### Text Input Field
**Role:** Standard input for user data.

Background: Canvas White (#ffffff), Text: Slate Text (#2c3e36), Placeholder: Hint Gray (#8a9c92), Border: 1px solid Input Border (#d1ddd5), Border Radius: 8px, Padding: 12px vertical, 16px horizontal. Focus: 2px solid Brand Green (#0b7f42).

### Success Badge
**Role:** Indicates positive status or categorization.

Background: Soft Green Background (#e8f8ef), Text: Success Green Text (#0a3d23), Border Radius: 999px (pill-shaped), Padding: 4px vertical, 12px horizontal. Typography: Inter, 12px, weight 600.

### Promotional Badge
**Role:** Highlights features or special states.

Background: Light Gold (#fef3d7), Text: Gold Text (#8a6300), Border Radius: 999px (pill-shaped), Padding: 4px vertical, 12px horizontal. Typography: Inter, 12px, weight 600.

## Do's and Don'ts

### Do
- Prioritize Canvas White (#ffffff) and Ghost Fog (#f8fdf9) for large background areas to maintain a bright, open feel.
- Use Brand Green (#0b7f42) for primary calls-to-action and Brand Gold (#fbb116) for secondary emphasis to create visual hierarchy.
- Apply an 8px border radius for buttons and input fields, and 16px for main content cards to achieve a consistent modern look.
- Reserve Forest Deep (#062d1c), 72px for display headlines to create a bold, commanding presence.
- Implement the rgba(11, 127, 66, 0.10) 0px 4px 16px 0px shadow for elevated cards to provide subtle depth.
- Maintain a clear hierarchy with Slate Text (#2c3e36) for main body content and Muted Gray (#5a6c62) for secondary information.
- Ensure generous spacing, using 24px as the primary element gap and 64px for section spacing to enhance readability.
- Use green for trust, growth, and primary actions; use gold for highlights, promotions, and secondary actions.

### Don't
- Do not introduce new primary colors beyond Brand Green (#0b7f42) and Brand Gold (#fbb116); these are the core brand colors.
- Avoid sharp corners; all interactive and content-holding components should have rounded corners (min. 8px radius).
- Do not use heavy, opaque shadow layers; stick to the light, green-tinted shadows provided for elevation.
- Refrain from using thin fonts for body copy; ensure sufficient weight (400 or higher) and contrast for readability.
- Do not overcrowd sections; maintain the generous 64px section gap to provide breathing room.
- Avoid overusing gold; it should complement green, not dominate the interface.
- Do not deviate from Inter font family; its character is central to the brand's professional identity.
- Avoid placing gold text directly on green backgrounds or vice versa without proper contrast checking.

## Surfaces

| Level | Name | Value | Purpose |
|-------|------|-------|---------|
| 0 | Canvas White | `#ffffff` | Primary page background and base for most content sections. |
| 1 | Ghost Fog | `#f8fdf9` | Slightly elevated background for cards and secondary panels, offering subtle differentiation with a green tint. |
| 2 | Canvas White Elevated | `#ffffff` | Card surfaces and modal backgrounds that receive a distinct shadow for elevation. |

## Elevation

- **Card:** `rgba(11, 127, 66, 0.10) 0px 4px 16px 0px`
- **Interactive Element:** `rgba(11, 127, 66, 0.08) 0px 2px 8px 0px`
- **Button Hover:** `rgba(11, 127, 66, 0.12) 0px 8px 24px 0px`

## Imagery

Imagery style is professional and natural, featuring high-quality photographs that convey trust, growth, and prosperity. Photography often includes natural elements, green spaces, business contexts, and people in professional settings. Images are well-lit with natural lighting when possible. Icons use a duotone style with green and gold accents. Product photography is clean and presented on white or subtle green-tinted backgrounds. All imagery maintains a high level of polish and professionalism, reinforcing brand values of reliability and growth.

## Layout

The page adheres to a max-width contained layout, typically centered at 1200px. The hero section is full-bleed, often featuring the brand green gradient background with a centered headline and description, highlighting the primary call to action. Section rhythm is consistent, with generous vertical spacing (64px between sections) and alternating white/subtle green backgrounds to visually break up content. Content arrangement frequently uses alternating text-left/image-right layouts for features, and 3-column card grids for services or benefits. Overall density is comfortable, providing ample breathing room. Navigation is a sticky top bar with a clear brand logo, primary navigation links, and distinct green primary button for key actions.

## Agent Prompt Guide

Quick Color Reference:
- text: #2c3e36
- background: #ffffff
- border: #d1ddd5
- primary action: #0b7f42 (green)
- secondary action: #fbb116 (gold)

Example Component Prompts:
1. Create a hero section: full-width green gradient background (linear-gradient(135deg, rgb(11, 127, 66), rgb(8, 93, 50) 100%)). Headline 'Growing Together Towards Success' in Inter, 72px, weight 700, #ffffff, letter-spacing -1.44px. Subtext 'Trusted partner for sustainable business growth' in Inter, 20px, weight 400, #d4f4e2. A primary button 'Get Started' with background #0b7f42, text #ffffff, 8px radius, 14px 28px padding. A secondary button 'Learn More' with background #fbb116, text #8a6300, 8px radius, 14px 28px padding.
2. Create a feature card: background #f8fdf9, 16px radius, 32px padding on all sides. Headline 'Sustainable Solutions' in Inter, 28px, weight 600, #062d1c, letter-spacing -0.56px. Body text 'We provide eco-friendly business solutions that drive growth.' in Inter, 16px, weight 400, #2c3e36.
3. Create an input field for email: background #ffffff, border 1px solid #d1ddd5, 8px radius, 12px 16px padding. Placeholder text 'Enter your email' in Inter, 16px, weight 400, #8a9c92. Label above 'Email Address' in Inter, 14px, weight 500, #2c3e36. Focus state: 2px solid #0b7f42.
4. Create a success badge: background #e8f8ef, text #0a3d23, 999px radius, 4px 12px padding. Text: 'Active' in Inter, 12px, weight 600.
5. Create a promotional banner: background linear-gradient(90deg, #fef3d7, #fbb116), text #8a6300, 12px radius, 16px 24px padding. Text: 'Special Offer - 20% Off' in Inter, 16px, weight 600.

## Similar Brands

- **Grab** — Southeast Asian brand using green as primary color for trust and growth, paired with clean UI and professional typography.
- **Spotify** — Uses a bold single color (green) as primary brand identity with strong contrast against dark and light backgrounds.
- **Shopee** — Orange/gold accent for energy and promotions, creating excitement and urgency in e-commerce contexts.
- **Gojek** — Bold green for primary actions with professional, modern interface design focused on service and reliability.

## Quick Start

### CSS Custom Properties

```css
:root {
  /* Brand Colors */
  --color-brand-green: #0b7f42;
  --color-brand-gold: #fbb116;
  --color-green-hover: #096b39;
  --color-gold-hover: #e19f14;
  
  /* Base Colors */
  --color-canvas-white: #ffffff;
  --color-subtle-ash: #f0f4f1;
  --color-ghost-fog: #f8fdf9;
  --color-slate-text: #2c3e36;
  --color-forest-deep: #062d1c;
  --color-muted-gray: #5a6c62;
  --color-input-border: #d1ddd5;
  --color-hint-gray: #8a9c92;
  
  /* Accent Colors */
  --color-soft-green: #d4f4e2;
  --color-deep-green-accent: #085d32;
  --color-success-green-text: #0a3d23;
  --color-soft-green-background: #e8f8ef;
  --color-light-gold: #fef3d7;
  --color-gold-text: #8a6300;
  
  /* Gradients */
  --gradient-brand-green: linear-gradient(135deg, rgb(11, 127, 66), rgb(8, 93, 50) 100%);
  --gradient-brand-gold: linear-gradient(135deg, rgb(251, 177, 22), rgb(225, 159, 20) 100%);

  /* Typography — Font Families */
  --font-inter: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;

  /* Typography — Scale */
  --text-caption: 12px;
  --leading-caption: 1.5;
  --tracking-caption: 0px;
  --text-body-sm: 14px;
  --leading-body-sm: 1.43;
  --tracking-body-sm: 0px;
  --text-body: 16px;
  --leading-body: 1.5;
  --tracking-body: 0px;
  --text-subheading: 18px;
  --leading-subheading: 1.44;
  --tracking-subheading: -0.18px;
  --text-heading-sm: 20px;
  --leading-heading-sm: 1.4;
  --tracking-heading-sm: -0.4px;
  --text-heading: 28px;
  --leading-heading: 1.2;
  --tracking-heading: -0.56px;
  --text-heading-lg: 40px;
  --leading-heading-lg: 1.2;
  --tracking-heading-lg: -0.8px;
  --text-display: 56px;
  --leading-display: 1.1;
  --tracking-display: -1.12px;
  --text-display-xl: 72px;
  --leading-display-xl: 1.05;
  --tracking-display-xl: -1.44px;

  /* Typography — Weights */
  --font-weight-regular: 400;
  --font-weight-medium: 500;
  --font-weight-semibold: 600;
  --font-weight-bold: 700;

  /* Spacing */
  --spacing-unit: 8px;
  --spacing-8: 8px;
  --spacing-16: 16px;
  --spacing-24: 24px;
  --spacing-32: 32px;
  --spacing-40: 40px;
  --spacing-48: 48px;
  --spacing-56: 56px;
  --spacing-64: 64px;
  --spacing-72: 72px;
  --spacing-80: 80px;
  --spacing-96: 96px;
  --spacing-144: 144px;
  --spacing-168: 168px;
  --spacing-224: 224px;

  /* Layout */
  --page-max-width: 1200px;
  --section-gap: 64px;
  --card-padding: 32px;
  --element-gap: 24px;

  /* Border Radius */
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 16px;
  --radius-xl: 24px;
  --radius-full: 999px;

  /* Named Radii */
  --radius-cards: 16px;
  --radius-badges: 999px;
  --radius-inputs: 8px;
  --radius-buttons: 8px;
  --radius-smallcomponents: 12px;

  /* Shadows */
  --shadow-sm: rgba(11, 127, 66, 0.05) 0px 1px 2px 0px;
  --shadow-md: rgba(11, 127, 66, 0.08) 0px 2px 8px 0px;
  --shadow-lg: rgba(11, 127, 66, 0.10) 0px 4px 16px 0px;
  --shadow-xl: rgba(11, 127, 66, 0.12) 0px 8px 24px 0px;

  /* Surfaces */
  --surface-canvas-white: #ffffff;
  --surface-ghost-fog: #f8fdf9;
  --surface-canvas-white-elevated: #ffffff;
}
```

### Tailwind v4

```css
@theme {
  /* Brand Colors */
  --color-brand-green: #0b7f42;
  --color-brand-gold: #fbb116;
  --color-green-hover: #096b39;
  --color-gold-hover: #e19f14;
  
  /* Base Colors */
  --color-canvas-white: #ffffff;
  --color-subtle-ash: #f0f4f1;
  --color-ghost-fog: #f8fdf9;
  --color-slate-text: #2c3e36;
  --color-forest-deep: #062d1c;
  --color-muted-gray: #5a6c62;
  --color-input-border: #d1ddd5;
  --color-hint-gray: #8a9c92;
  
  /* Accent Colors */
  --color-soft-green: #d4f4e2;
  --color-deep-green-accent: #085d32;
  --color-success-green-text: #0a3d23;
  --color-soft-green-background: #e8f8ef;
  --color-light-gold: #fef3d7;
  --color-gold-text: #8a6300;

  /* Typography */
  --font-inter: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;

  /* Typography — Scale */
  --text-caption: 12px;
  --leading-caption: 1.5;
  --tracking-caption: 0px;
  --text-body-sm: 14px;
  --leading-body-sm: 1.43;
  --tracking-body-sm: 0px;
  --text-body: 16px;
  --leading-body: 1.5;
  --tracking-body: 0px;
  --text-subheading: 18px;
  --leading-subheading: 1.44;
  --tracking-subheading: -0.18px;
  --text-heading-sm: 20px;
  --leading-heading-sm: 1.4;
  --tracking-heading-sm: -0.4px;
  --text-heading: 28px;
  --leading-heading: 1.2;
  --tracking-heading: -0.56px;
  --text-heading-lg: 40px;
  --leading-heading-lg: 1.2;
  --tracking-heading-lg: -0.8px;
  --text-display: 56px;
  --leading-display: 1.1;
  --tracking-display: -1.12px;
  --text-display-xl: 72px;
  --leading-display-xl: 1.05;
  --tracking-display-xl: -1.44px;

  /* Spacing */
  --spacing-8: 8px;
  --spacing-16: 16px;
  --spacing-24: 24px;
  --spacing-32: 32px;
  --spacing-40: 40px;
  --spacing-48: 48px;
  --spacing-56: 56px;
  --spacing-64: 64px;
  --spacing-72: 72px;
  --spacing-80: 80px;
  --spacing-96: 96px;
  --spacing-144: 144px;
  --spacing-168: 168px;
  --spacing-224: 224px;

  /* Border Radius */
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 16px;
  --radius-xl: 24px;
  --radius-full: 999px;

  /* Shadows */
  --shadow-sm: rgba(11, 127, 66, 0.05) 0px 1px 2px 0px;
  --shadow-md: rgba(11, 127, 66, 0.08) 0px 2px 8px 0px;
  --shadow-lg: rgba(11, 127, 66, 0.10) 0px 4px 16px 0px;
  --shadow-xl: rgba(11, 127, 66, 0.12) 0px 8px 24px 0px;
}
```
