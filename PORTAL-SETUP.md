# Portal Setup Instructions

## Creating the Portal Pages

### 1. Create Parent Portal Pages (Containers)

Create two parent pages in WordPress - these are just containers with no content:

1. **LO**
   - Title: `LO`
   - Slug: `lo`
   - Content: (leave empty - this is just a container)

2. **RE**
   - Title: `RE`
   - Slug: `re`
   - Content: (leave empty - this is just a container)

### 2. Create Real Pages (Subpages)

For each portal, create the following pages with actual content:

#### LO Pages (Parent: LO)
- **Welcome** - Slug: `welcome` - Content: `[lrh_content_welcome]`
- **Profile** - Slug: `profile` - Content: `[lrh_content_profile]`
- **Marketing** - Slug: `marketing` - Content: `[lrh_content_marketing]`
- **Marketing Calendar** - Slug: `marketing-calendar` - Content: `[lrh_content_calendar]`
- **Landing Pages** - Slug: `landing-pages` - Content: `[lrh_content_landing_pages]`
- **Email Campaigns** - Slug: `email-campaigns` - Content: `[lrh_content_email_campaigns]`
- **Local SEO** - Slug: `local-seo` - Content: `[lrh_content_local_seo]`
- **Brand Guide** - Slug: `brand-guide` - Content: `[lrh_content_brand_guide]`
- **Orders** - Slug: `orders` - Content: `[lrh_content_orders]`
- **Lead Tracking** - Slug: `lead-tracking` - Content: `[lrh_content_lead_tracking]`
- **Tools** - Slug: `tools` - Content: `[lrh_content_tools]`
- **Settings** - Slug: `settings` - Content: `[lrh_content_settings]`
- **Notifications** - Slug: `notifications` - Content: `[lrh_content_notifications]`

#### RE Pages (Parent: RE)
Same pages as above, but set parent to "RE"

### 3. How It Works

- When you visit any portal page or its subpage, the portal frame will automatically activate
- The frame includes:
  - Black logo section at the top
  - White top bar with page title
  - Sidebar on the left (will show portal-specific menu)
  - Content area where the page content displays

### 4. Sidebar Menu

The sidebar will show different menu items based on the portal type:
- **Lenders Portal**: Loan officer specific items
- **Realtor Portal**: Realtor specific items
- **Member Profiles**: Profile-specific items

## Notes

- All pages must be created with the correct slugs
- Subpages must have their parent set to either "Lenders Portal" or "Realtor Portal"
- The portal frame automatically hides the Blocksy header
- Content from frs-lrg plugin will load via shortcode
