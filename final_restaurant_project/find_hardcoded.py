import os
import glob

project_dir = r"c:/xampp/htdocs/final_restaurant_project/final_restaurant_project"
files = glob.glob(os.path.join(project_dir, "**", "*.php"), recursive=True)

for file in files:
    if "test_" in file:
        continue
    with open(file, "r", encoding="utf-8", errors="ignore") as f:
        content = f.read()
    if "/final_restaurant_project/" in content:
        print(file)
