import re

# 1. Update UserManagementController
file_ctrl = 'app/Http/Controllers/UserManagementController.php'
with open(file_ctrl, 'r') as f:
    ctrl_content = f.read()

ctrl_content = ctrl_content.replace("'orang_tua'", "'ortu'")

with open(file_ctrl, 'w') as f:
    f.write(ctrl_content)

# 2. Update User Model
file_model = 'app/Models/User.php'
with open(file_model, 'r') as f:
    model_content = f.read()

model_content = model_content.replace("'orang_tua'", "'ortu'")

with open(file_model, 'w') as f:
    f.write(model_content)

# 3. Update index.blade.php
file_view = 'resources/views/dashboard/users/index.blade.php'
with open(file_view, 'r', encoding='utf-8') as f:
    view_content = f.read()

view_content = view_content.replace("'orang_tua'", "'ortu'")
view_content = view_content.replace('"orang_tua"', '"ortu"')
view_content = view_content.replace("role === 'ortu' ? 'Ortu'", "role === 'ortu' ? 'Orang Tua'")

# Fix printing 'Ortu' in the table list properly
# Currently it is: {{ $user->role === 'dinkes' ? 'Dinas Kesehatan' : ucwords(str_replace('_', ' ', $user->role)) }}
# I will change it to: {{ $user->role === 'dinkes' ? 'Dinas Kesehatan' : ($user->role === 'ortu' ? 'Orang Tua' : ucwords(str_replace('_', ' ', $user->role))) }}
view_content = view_content.replace(
    "{{ $user->role === 'dinkes' ? 'Dinas Kesehatan' : ucwords(str_replace('_', ' ', $user->role)) }}",
    "{{ $user->role === 'dinkes' ? 'Dinas Kesehatan' : ($user->role === 'ortu' ? 'Orang Tua' : ucwords(str_replace('_', ' ', $user->role))) }}"
)

with open(file_view, 'w', encoding='utf-8') as f:
    f.write(view_content)

print('Selesai memperbaiki ortu!')
