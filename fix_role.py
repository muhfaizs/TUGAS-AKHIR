import re

file_ctrl = 'app/Http/Controllers/UserManagementController.php'
with open(file_ctrl, 'r') as f:
    ctrl_content = f.read()

ctrl_content = ctrl_content.replace("'super admin'", "'super_admin'")
ctrl_content = ctrl_content.replace("'orang tua'", "'orang_tua'")

with open(file_ctrl, 'w') as f:
    f.write(ctrl_content)

file_view = 'resources/views/dashboard/users/index.blade.php'
with open(file_view, 'r', encoding='utf-8') as f:
    view_content = f.read()

view_content = view_content.replace("'super admin'", "'super_admin'")
view_content = view_content.replace("\"super admin\"", "\"super_admin\"")
view_content = view_content.replace("'orang tua'", "'orang_tua'")
view_content = view_content.replace("\"orang tua\"", "\"orang_tua\"")

with open(file_view, 'w', encoding='utf-8') as f:
    f.write(view_content)
