# Claude AI Prompt for Porch Light Blog

Write a comprehensive, SEO-optimized blog post about: "{{TOPIC}}"

Target audience: Direct mail marketers, marketing directors, small business owners, and entrepreneurs who use or want to use direct mail as a marketing channel.

Requirements:
1. Write 800-1200 words
2. Use clear, actionable language with direct mail industry terminology
3. Include practical examples relevant to direct mail campaigns (response rates, testing strategies, real-world campaign scenarios)
4. Structure with H2 and H3 headings for SEO
5. Include a compelling introduction that hooks the reader with a relevant direct mail challenge or opportunity
6. End with actionable takeaways that readers can implement in their next campaign
7. Reference industry benchmarks, postal regulations, or testing methodologies where relevant
8. Focus on ROI, measurability, and proven direct mail tactics
9. IMPORTANT: End the content with this exact CTA section (as HTML):
   <div class="cta-box">
   <h3>Ready to Get Started with Direct Mail?</h3>
   <p>Want an affordable way to reach thousands of homes? Our shared community postcards put your business on a large, glossy card with other trusted local businesses.</p>
   <p><a href="https://porchlightmail.com" class="cta-button">→ Check Shared Card Availability</a></p>
   </div>

Format your response as JSON with this exact structure:
{
    "title": "SEO-optimized title (may differ slightly from topic)",
    "meta_description": "150-160 character meta description for SEO",
    "content": "Full HTML content with <h2>, <h3>, <p>, <ul>, <li> tags. No <h1> tag.",
    "books": [
        {
            "title": "Book Title",
            "author": "Author Name",
            "amazon_search": "exact search terms for Amazon",
            "description": "One sentence why this book is relevant"
        },
        {
            "title": "Book Title 2",
            "author": "Author Name",
            "amazon_search": "exact search terms for Amazon",
            "description": "One sentence why this book is relevant"
        },
        {
            "title": "Book Title 3",
            "author": "Author Name",
            "amazon_search": "exact search terms for Amazon",
            "description": "One sentence why this book is relevant"
        }
    ]
}

Select 3 highly relevant, well-regarded books about direct mail marketing, copywriting, response marketing, or related disciplines. Prioritize classic direct marketing books (Dan Kennedy, Robert Collier, Claude Hopkins, Drayton Bird, etc.) and modern direct mail references. Choose books that direct mail practitioners would find genuinely useful.

Return ONLY valid JSON, no markdown code blocks or other text.
