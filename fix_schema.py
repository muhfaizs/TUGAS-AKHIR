import re

# Fix Controller
file_ctrl = 'app/Http/Controllers/UserManagementController.php'
with open(file_ctrl, 'r') as f:
    ctrl_content = f.read()

ctrl_content = ctrl_content.replace('nama_lengkap', 'name')
ctrl_content = ctrl_content.replace('nomor_kontak', 'phone')
ctrl_content = ctrl_content.replace('nik_ortu', 'nik')
ctrl_content = ctrl_content.replace('nip_bidan', 'nip')
ctrl_content = ctrl_content.replace('alamat_domisili', 'address')

ctrl_content = re.sub(
    r"'is_active' => \['nullable', 'boolean'\],",
    r"'status' => ['nullable', 'boolean'],",
    ctrl_content
)

ctrl_content = ctrl_content.replace("if (! isset($validated['is_active'])) {", "if (! isset($validated['status'])) {")
ctrl_content = ctrl_content.replace("$validated['is_active'] = false;\n        }", "$validated['status'] = 'nonaktif';\n        } else {\n            $validated['status'] = $validated['status'] ? 'aktif' : 'nonaktif';\n        }")

ctrl_content = ctrl_content.replace("is_active", "status")

with open(file_ctrl, 'w') as f:
    f.write(ctrl_content)

# Fix View
file_view = 'resources/views/dashboard/users/index.blade.php'
with open(file_view, 'r', encoding='utf-8') as f:
    view_content = f.read()

view_content = view_content.replace('nama_lengkap', 'name')
view_content = view_content.replace('nomor_kontak', 'phone')
view_content = view_content.replace('nik_ortu', 'nik')
view_content = view_content.replace('nip_bidan', 'nip')
view_content = view_content.replace('alamat_domisili', 'address')

view_content = view_content.replace("@if($user->is_active)", "@if($user->status === 'aktif')")
view_content = view_content.replace("form.is_active", "form.status")
view_content = view_content.replace("data.is_active", "data.status")
view_content = view_content.replace("is_active: true", "status: true")
view_content = view_content.replace("'is_active'", "'status'")
view_content = view_content.replace("old('is_active'", "old('status'")
view_content = view_content.replace("is_active:", "status:")
view_content = view_content.replace("data.status === undefined", "data.status === 'aktif'")

with open(file_view, 'w', encoding='utf-8') as f:
    f.write(view_content)
