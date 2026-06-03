import os
import glob
import re

admin_dir = r"c:/xampp/htdocs/final_restaurant_project/final_restaurant_project/admin"
files = glob.glob(os.path.join(admin_dir, "*.php"))

font_link = '<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">'

for file_path in files:
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()
    
    original_content = content
    
    # Insert fonts
    if "Cormorant" not in content and "<head>" in content:
        content = content.replace("</title>", f"</title>\n    {font_link}")
        
    # Replace background gradients
    content = re.sub(r'background:\s*linear-gradient\(135deg,\s*#f5f7fa\s*0%,\s*#c3cfe2\s*100%\);', 'background-color: var(--color-bg); background-image: radial-gradient(at 0% 0%, hsla(43,74%,49%,0.05) 0px, transparent 50%), radial-gradient(at 100% 100%, hsla(40,30%,75%,0.03) 0px, transparent 50%);', content)
    content = re.sub(r'background:\s*#f8f9fa;', 'background: var(--color-surface-soft);', content)
    content = re.sub(r'background:\s*#fff;', 'background: var(--color-surface);', content)
    content = re.sub(r'color:\s*#2d3748;', 'color: var(--color-text);', content)
    content = re.sub(r'color:\s*#718096;', 'color: var(--color-text-muted);', content)
    content = re.sub(r'border-bottom:\s*1px\s*solid\s*#f1f5f9;', 'border-bottom: 1px solid var(--color-border);', content)
    content = re.sub(r'background:\s*linear-gradient\(135deg,\s*#f8fafc\s*0%,\s*#f1f5f9\s*50%\);', 'background: var(--color-surface-soft);', content)
    content = re.sub(r'font-family:\s*\'Segoe UI\'[^;]+;', 'font-family: var(--font-sans);', content)
    
    # Primary gradients (purple/blue) -> gold
    content = re.sub(r'background:\s*linear-gradient\(135deg,\s*rgba\(102,126,234,0\.8\),\s*rgba\(118,75,162,0\.8\)\);', 'background: linear-gradient(135deg, rgba(212,175,55,0.8), rgba(212,175,55,0.6));', content)
    content = re.sub(r'background:\s*linear-gradient\(135deg,\s*#667eea,\s*#764ba2\);', 'background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));', content)
    content = re.sub(r'background:\s*linear-gradient\(135deg,\s*#667eea\s*0%,\s*#764ba2\s*100%\);', 'background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);', content)
    
    # Secondary/Success (green) -> gold/silver
    content = re.sub(r'background:\s*linear-gradient\(135deg,\s*rgba\(40,167,69,0\.9\),\s*rgba\(32,201,151,0\.9\)\);', 'background: linear-gradient(135deg, var(--color-secondary), var(--color-secondary-light));', content)
    content = re.sub(r'background:\s*linear-gradient\(135deg,\s*#28a745,\s*#20c997\);', 'background: linear-gradient(135deg, var(--color-secondary), var(--color-secondary-light));', content)
    content = re.sub(r'box-shadow:\s*0\s*4px\s*15px\s*rgba\(40,167,69,0\.3\);', 'box-shadow: 0 4px 15px rgba(212,175,55,0.3);', content)
    content = re.sub(r'box-shadow:\s*0\s*8px\s*25px\s*rgba\(40,167,69,0\.4\);', 'box-shadow: 0 8px 25px rgba(212,175,55,0.4);', content)

    # General specific colors
    content = re.sub(r'color:\s*#28a745;', 'color: var(--color-primary);', content)
    content = re.sub(r'color:\s*#64748b;', 'color: var(--color-text-muted);', content)
    content = re.sub(r'color:\s*#94a3b8;', 'color: var(--color-text-muted);', content)
    content = re.sub(r'background:\s*linear-gradient\(135deg,\s*#f8fafc\s*0%,\s*#f1f5f9\s*100%\);', 'background: var(--color-surface-soft);', content)
    content = re.sub(r'background:\s*linear-gradient\(135deg,\s*#f1f5f9\s*0%,\s*#e2e8f0\s*100%\);', 'background: var(--color-surface-soft);', content)
    content = re.sub(r'border:\s*1px\s*solid\s*#e2e8f0;', 'border: 1px solid var(--color-border);', content)
    content = re.sub(r'border:\s*2px\s*solid\s*#f1f5f9;', 'border: 2px solid var(--color-border);', content)
    
    # Specific elements
    content = re.sub(r'h1\s*{\s*font-size', 'h1 { font-family: var(--font-heading); font-size', content)
    content = re.sub(r'h2\s*{\s*margin', 'h2 { font-family: var(--font-heading); margin', content)

    if content != original_content:
        with open(file_path, "w", encoding="utf-8") as f:
            f.write(content)
        print(f"Updated {file_path}")
