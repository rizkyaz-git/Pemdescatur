---
name: Civic Clarity
colors:
  surface: '#f7f9fb'
  surface-dim: '#d8dadc'
  surface-bright: '#f7f9fb'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f4f6'
  surface-container: '#eceef0'
  surface-container-high: '#e6e8ea'
  surface-container-highest: '#e0e3e5'
  on-surface: '#191c1e'
  on-surface-variant: '#44474e'
  inverse-surface: '#2d3133'
  inverse-on-surface: '#eff1f3'
  outline: '#75777e'
  outline-variant: '#c5c6ce'
  surface-tint: '#4e5e7f'
  primary: '#031633'
  on-primary: '#ffffff'
  primary-container: '#1a2b49'
  on-primary-container: '#8293b6'
  inverse-primary: '#b6c7ec'
  secondary: '#00677d'
  on-secondary: '#ffffff'
  secondary-container: '#63dbfe'
  on-secondary-container: '#005e73'
  tertiary: '#241300'
  on-tertiary: '#ffffff'
  tertiary-container: '#3f2500'
  on-tertiary-container: '#cc8200'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d7e2ff'
  primary-fixed-dim: '#b6c7ec'
  on-primary-fixed: '#081b38'
  on-primary-fixed-variant: '#364766'
  secondary-fixed: '#b3ebff'
  secondary-fixed-dim: '#5cd5f8'
  on-secondary-fixed: '#001f27'
  on-secondary-fixed-variant: '#004e5f'
  tertiary-fixed: '#ffddb8'
  tertiary-fixed-dim: '#ffb95f'
  on-tertiary-fixed: '#2a1700'
  on-tertiary-fixed-variant: '#653e00'
  background: '#f7f9fb'
  on-background: '#191c1e'
  surface-variant: '#e0e3e5'
typography:
  display-lg:
    fontFamily: Public Sans
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Public Sans
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Public Sans
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
  title-md:
    fontFamily: Public Sans
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-lg:
    fontFamily: Public Sans
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Public Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
    letterSpacing: 0.01em
  caption:
    fontFamily: Public Sans
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 16px
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  base: 8px
  container-max: 1280px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 40px
---

## Brand & Style

The design system is anchored in the principles of **Modern Institutionalism**. It prioritizes trust, transparency, and administrative efficiency through a clean, professional aesthetic that avoids unnecessary decoration. The target audience is the general public, requiring a UI that feels authoritative yet approachable and highly inclusive.

The style is **Modern Corporate Minimalism**. It utilizes generous whitespace to reduce cognitive load, ensuring that critical public services are easily discoverable. Visual hierarchy is established through clear typographic scaling and a disciplined color palette, evoking a sense of calm and organized governance.

## Colors

The palette is designed for high legibility and professional rigor, utilizing a fidelity-based approach to ensure brand colors remain consistent across UI states.

*   **Primary (Deep Government Blue):** Used for headers, primary navigation, and foundational brand elements to signal authority and stability.
*   **Secondary (Bright Teal):** Used for interactive elements, progress indicators, and subtle accents to inject a sense of modern efficiency.
*   **Neutral:** A range of cool grays (Slate) provides the structural scaffolding. The background is a crisp white/off-white (#f8fafc) to maximize contrast.
*   **Accent (Soft Gold):** Reserved exclusively for high-priority notifications, urgent alerts, or "Call to Action" elements that require immediate attention without causing alarm.

## Typography

This design system uses **Public Sans** for its systematic, neutral, and highly legible characteristics across most UI tiers, including headlines and body text. Public Sans is a government-standard typeface designed for clarity in administrative contexts. To maintain functional distinction, **Inter** is utilized for labels and small data points, ensuring maximum character differentiation for UI-specific elements.

Text contrast must always meet WCAG 2.1 AA standards. Headlines should use a heavier weight and tighter letter-spacing to maintain a structured, authoritative appearance. Body text maintains a generous line height (1.5x) to facilitate comfortable reading of long-form legislative or service-related content.

## Layout & Spacing

The layout follows a **Service-First Fluid Grid**. It utilizes a 12-column system on desktop to allow for complex data layouts (like service directories) while collapsing gracefully to a single column on mobile.

*   **Rhythm:** An 8px linear scale governs all margins and padding. 
*   **Breakpoints:** Mobile (<600px), Tablet (600px - 1024px), and Desktop (>1024px).
*   **Safe Areas:** Large page headers and service cards use generous internal padding (32px+) to signify their importance and provide a "breathable" interface.

## Elevation & Depth

Depth is communicated through **Tonal Layers** rather than heavy shadows. This maintains a clean, flat aesthetic that feels modern and fast-loading.

*   **Level 0 (Surface):** The main background color (#f8fafc).
*   **Level 1 (Cards/Containers):** Pure white (#FFFFFF) with a very subtle, light-gray border (1px). 
*   **Level 2 (Interaction):** A soft, diffused ambient shadow (Blur 12px, 5% opacity) is applied only when an element is hovered or active to provide tactile feedback.
*   **Overlays:** High-contrast Scrims are used for modals to ensure focus remains entirely on the task at hand.

## Shapes

The design system adopts a **"Soft" shape language**. This provides a 0.25rem (4px) base radius for standard elements like input fields and buttons, while larger components like service cards or hero sections use 0.5rem (8px). 

This subtle rounding strikes a balance between the "strict" sharp corners of traditional bureaucracy and the "overly casual" fully rounded corners of social apps, projecting an image of a government that is modern and user-friendly but still firm and dependable.

## Components

*   **Buttons:** Primary buttons use the Deep Government Blue (#1a2b49) with white text. Secondary buttons use a Teal outline. All buttons have a minimum height of 44px to ensure touch-target accessibility.
*   **Service Cards:** Large white containers with a 1px border. They feature a prominent icon (Secondary color) and a clear "Title-md" headline followed by a short description.
*   **Input Fields:** Clean, rectangular fields with a subtle 1px border. Focus states are clearly indicated with a 2px Teal ring. Labels always sit above the field for clarity.
*   **Alerts/Banners:** Full-width banners. Critical alerts use the Soft Gold background with dark text to ensure visibility without appearing hostile.
*   **Progress Indicators:** Stepper components are used extensively for multi-step public service applications, guiding the user through processes with clear "Current," "Completed," and "Pending" states.
*   **Iconography:** Use a consistent line-style icon set (e.g., Lucide or Phosphor) with a 2px stroke weight to match the professional tone of the typography.