import os
import re

auth_dir = r"c:/xampp/htdocs/final_restaurant_project/final_restaurant_project/auth"
files = [os.path.join(auth_dir, "login.php"), os.path.join(auth_dir, "register.php")]

for file_path in files:
    if not os.path.exists(file_path):
        continue
        
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()
    
    # Replace background gradients
    content = re.sub(r'background:linear-gradient\(135deg, #f5f7fa 0%, #c3cfe2 100%\);', 'background-color:var(--color-bg);background-image:radial-gradient(at 0% 0%, hsla(43,74%,49%,0.05) 0px, transparent 50%), radial-gradient(at 100% 100%, hsla(40,30%,75%,0.03) 0px, transparent 50%);', content)
    
    # Auth card
    content = re.sub(r'\.auth-card\{background:#fff;', '.auth-card{background:var(--color-surface);border:1px solid var(--color-border);', content)
    
    # Header gradient to gold
    content = re.sub(r'background:linear-gradient\(135deg, #667eea 0%, #764ba2 100%\);', 'background:linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);', content)
    
    # Typography
    content = re.sub(r'color:#333;', 'color:var(--color-text);', content)
    content = re.sub(r'color:#667eea;', 'color:var(--color-primary);', content)
    
    # Inputs
    content = re.sub(r'\.form-group input\{width:100%;padding:15px;border:2px solid #e1e5e9;border-radius:8px;font-size:16px;\}', '.form-group input{width:100%;padding:15px;border:2px solid var(--color-border);border-radius:8px;font-size:16px;background:var(--color-surface);color:var(--color-text);}', content)
    content = re.sub(r'\.form-group input:focus\{border-color:#667eea;outline:none;\}', '.form-group input:focus{border-color:var(--color-primary);outline:none;}', content)
    
    # Button hover
    content = re.sub(r'\.btn-full:hover\{background:linear-gradient\(135deg, #5a67d8 0%, #6b46c1 100%\);\}', '.btn-full:hover{background:linear-gradient(135deg, var(--color-primary-light) 0%, var(--color-primary) 100%);}', content)
    
    # Footer
    content = re.sub(r'\.auth-footer\{text-align:center;padding:30px 40px 40px;border-top:1px solid #f0f0f0;background:#fafbfc;\}', '.auth-footer{text-align:center;padding:30px 40px 40px;border-top:1px solid var(--color-border);background:var(--color-surface-soft);}', content)
    
    with open(file_path, "w", encoding="utf-8") as f:
        f.write(content)
        
    print(f"Updated {file_path}")
