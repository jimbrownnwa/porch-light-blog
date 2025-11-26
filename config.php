<?php
// Blog Configuration

// Load local secrets if available (for development)
if (file_exists(__DIR__ . '/config.local.php')) {
    require_once __DIR__ . '/config.local.php';
}

// Claude API
define('CLAUDE_API_KEY', getenv('CLAUDE_API_KEY') !== false ? getenv('CLAUDE_API_KEY') : '');
define('CLAUDE_MODEL', 'claude-sonnet-4-5-20250929');

// Amazon Affiliate
define('AMAZON_AFFILIATE_TAG', getenv('AMAZON_AFFILIATE_TAG') !== false ? getenv('AMAZON_AFFILIATE_TAG') : '');

// Cron job security token (32 hex characters)
define('CRON_TOKEN', getenv('CRON_TOKEN') !== false ? getenv('CRON_TOKEN') : '');

// Blog Settings
define('BLOG_TITLE', 'Porch Light Blog');
define('BLOG_DESCRIPTION', 'Proven Strategies & Frameworks for Direct Mail Success');
define('POSTS_PER_PAGE', 10);

// Database - use mounted volume in production, local dir in development
$dbDir = is_dir('/app/data') ? '/app/data' : __DIR__;
define('DB_PATH', $dbDir . '/blog.db');

// Testing mode (5 min interval) vs Production (daily)
define('TESTING_MODE', true);

// Predefined Topics for Blog Posts
$TOPICS = [
    // Direct Mail Fundamentals
    "The 40-40-20 Rule: List, Offer, and Creative in Direct Mail Success",
    "Response Rates Explained: What to Expect from Different Mail Formats",
    "Cost Per Acquisition: Calculating True Direct Mail ROI",
    "Lifetime Value Analysis: Justifying Higher Acquisition Costs",
    "Direct Mail vs Digital: When Physical Mail Outperforms Email",

    // List Management & Targeting
    "RFM Analysis: Recency, Frequency, Monetary Value for List Segmentation",
    "NCOA Processing: Keeping Your Mailing List Current and Deliverable",
    "Compiled vs Response Lists: Understanding List Sources and Quality",
    "Merge-Purge Techniques: Eliminating Duplicates and Reducing Waste",
    "Demographic Overlays: Enhancing Customer Data for Better Targeting",
    "Lookalike Modeling: Finding New Prospects Similar to Your Best Customers",
    "Suppression Files: Protecting Reputation and Reducing Complaints",
    "ZIP+4 and Carrier Route Targeting: Geographic Precision in Direct Mail",

    // Creative & Design
    "The Johnson Box: Capturing Attention with Classic Direct Mail Design",
    "Personalization Beyond Names: Variable Data Printing for Relevance",
    "Envelope Teaser Copy: Improving Open Rates with Strategic Messaging",
    "The Fold Test: Optimizing Letter Layout for Immediate Impact",
    "Color Psychology in Direct Mail: Choosing Colors That Drive Response",
    "White Space Strategy: Using Breathing Room to Guide the Eye",
    "Testimonials and Social Proof: Building Trust Through Customer Stories",
    "Call-to-Action Design: Making the Next Step Crystal Clear",

    // Copywriting & Messaging
    "The AIDA Formula: Attention, Interest, Desire, Action in Direct Mail",
    "Benefit-Driven Copy: Features Tell, Benefits Sell",
    "The Pre-Head Strategy: Setting Context Before the Main Headline",
    "P.S. Power: Why Postscripts Get Read and Drive Response",
    "Scarcity and Urgency: Ethical Tactics to Motivate Immediate Action",
    "Storytelling in Sales Letters: Emotional Engagement Through Narrative",
    "Long Copy vs Short Copy: Matching Length to Offer Complexity",
    "The Lift Letter: Adding a Second Voice for Credibility",

    // Testing & Optimization
    "A/B Testing Fundamentals: Statistical Significance in Direct Mail",
    "Champion-Challenger Strategy: Continuous Improvement Through Testing",
    "Multivariate Testing: Testing Multiple Variables Simultaneously",
    "Test Cell Sizing: How Many Pieces to Mail for Valid Results",
    "Offer Testing: Price Points, Premiums, and Payment Terms",
    "Format Testing: Postcards vs Letters vs Self-Mailers",
    "Timing Tests: Day of Week and Season Impact on Response",
    "Package Testing: Control vs Creative Testing Methodology",

    // Response Mechanisms
    "PURL Strategy: Personalized URLs for Tracking and Conversion",
    "QR Codes in Direct Mail: Bridging Physical and Digital Experience",
    "BRE Design: Business Reply Envelopes That Get Returned",
    "Toll-Free Numbers: Tracking and Staffing for Inbound Response",
    "Landing Page Best Practices: Matching Digital to Direct Mail Messaging",
    "Multi-Step Conversion: Lead Generation vs Direct Sale Offers",
    "Response Device Design: Making It Easy to Say Yes",

    // Economics & ROI
    "Break-Even Analysis: Understanding Your Required Response Rate",
    "Back-End Value: Why Customer Lifetime Value Matters More Than CPA",
    "Allowable Cost Per Acquisition: Setting Profitability Targets",
    "Contribution Margin: Calculating Profitability at the Piece Level",
    "Test Budget Allocation: How Much to Spend Before Scaling",
    "Postal Discounts: USPS Worksharing and Presort Savings",
    "In-Home Date Targeting: Optimizing Arrival for Maximum Impact",

    // Compliance & Legal
    "CAN-SPAM and Direct Mail: Understanding the Rules",
    "Do Not Mail Lists: Respecting Consumer Preferences",
    "TCPA Compliance: Phone Number Use in Direct Mail Campaigns",
    "FTC Endorsement Guidelines: Proper Use of Testimonials",
    "ADA Compliance: Accessibility in Direct Mail Marketing",
    "Sweepstakes Regulations: Legal Requirements for Prize Promotions",
    "Privacy Laws and Direct Mail: GDPR, CCPA, and Data Protection",

    // Integration with Digital
    "Omnichannel Sequencing: Timing Email Follow-Up to Direct Mail",
    "Retargeting Mail Recipients: Digital Display After Physical Touch",
    "Social Media Integration: Driving Mail Recipients to Online Communities",
    "Direct Mail + SMS: Text Message Follow-Up Strategies",
    "Match-Back Analysis: Connecting Offline Mail to Online Conversions",
    "Triggered Direct Mail: Automated Mailings Based on Digital Behavior",

    // Production & Fulfillment
    "EDDM Explained: Every Door Direct Mail for Local Targeting",
    "Intelligent Mail Barcode: Tracking and Automation with IMb",
    "First Class vs Standard Mail: Speed and Cost Trade-Offs",
    "Inkjet Addressing vs Labels: Quality and Cost Considerations",
    "Mail House Selection: Evaluating Production Partners",
    "Print-on-Demand: Small Batch Direct Mail Economics",
    "Bindery and Finishing: Folding, Perforating, and Special Treatments",

    // Data & Analytics
    "Match Rates Explained: Measuring List Quality and Overlap",
    "Response Attribution: Single-Touch vs Multi-Touch Modeling",
    "Cohort Analysis: Tracking Performance Over Customer Lifetime",
    "Holdout Groups: Measuring Incremental Lift from Direct Mail",
    "Response Curves: Understanding When Responses Peak and Decline",
    "Source Code Tracking: Systematic Campaign Performance Measurement",

    // Campaign Types
    "Acquisition Mailings: Strategies for New Customer Growth",
    "Winback Campaigns: Re-Engaging Lapsed Customers",
    "Upsell and Cross-Sell: Mining Your House File for Revenue",
    "Welcome Series: Onboarding New Customers Through Direct Mail",
    "Anniversary and Birthday Mail: Leveraging Special Occasions",
    "Reactivation Campaigns: Bringing Back Inactive Subscribers",
    "VIP Programs: Direct Mail for High-Value Customer Retention",

    // Psychology & Persuasion
    "Cialdini's Principles: Influence and Persuasion in Direct Mail",
    "Loss Aversion: Why 'Don't Miss Out' Outperforms 'Get This Deal'",
    "The Decoy Effect: Pricing Strategy with Three-Tier Offers",
    "Social Proof Hierarchy: Which Testimonials Matter Most",
    "Authority Signals: Credentials, Awards, and Trust Markers",
    "Reciprocity in Direct Mail: Free Samples and Gifts That Convert",
    "Commitment and Consistency: Multi-Step Offers That Build Engagement"
];
