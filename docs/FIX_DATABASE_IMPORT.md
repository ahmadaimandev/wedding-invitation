# 🔧 FIX: InfinityFree Database Import Error

## ❌ Error Yang Anda Dapat:
```
#1044 - Access denied for user 'if0_40767466'@'192.168.%' to database 'wedding_db'
```

## 🎯 Punca Masalah:
InfinityFree **SUDAH create database** untuk anda: `if0_40767466_wedding_db`

Anda **TAK BOLEH** create database baru di InfinityFree (free hosting limitation).

---

## ✅ SOLUTION: Guna SQL File Yang Betul

### **Step 1: Guna File SQL Yang Baru**

Saya sudah create file baru untuk anda:
📁 **`database/wedding_infinityfree.sql`**

File ini **TIDAK ada** command `CREATE DATABASE` - hanya create tables sahaja.

### **Step 2: Import Ke InfinityFree**

1. **Login** ke InfinityFree cPanel
2. Click **MySQL Databases**
3. Click **Manage** pada database: `if0_40767466_wedding_db`
4. Click **phpMyAdmin**
5. **PASTIKAN** database `if0_40767466_wedding_db` sudah selected (check kat sebelah kiri)
6. Click tab **Import**
7. Click **Choose File**
8. Pilih file: **`wedding_infinityfree.sql`** (yang baru!)
9. Scroll bawah, click **Go**
10. Tunggu success message ✅

---

## 📋 Alternative: Manual Import (Jika Ada Data Existing)

### **Option A: Export dari Localhost (Jika Ada Data)**

Jika anda sudah ada data dalam localhost (RSVP, gallery, etc):

1. **Buka phpMyAdmin** di localhost: `http://localhost/phpmyadmin`
2. **Pilih** database `wedding_db`
3. Click tab **Export**
4. **IMPORTANT**: Click **Custom** (bukan Quick)
5. Dalam **Object creation options**, **UNCHECK**:
   - ❌ `CREATE DATABASE / USE statement`
6. Click **Go**
7. Save file (contoh: `wedding_data.sql`)
8. **Import** file ni ke InfinityFree

### **Option B: Fresh Install (Tanpa Data)**

Jika anda nak start fresh tanpa data existing:

**Guna file**: `wedding_infinityfree.sql` (yang saya baru create)

---

## 🔍 Verify Import Success

Selepas import, check dalam phpMyAdmin:

**Tables yang MESTI ada:**
- ✅ `users` (dengan 1 admin user)
- ✅ `rsvp` (boleh kosong)
- ✅ `gallery` (boleh kosong)
- ✅ `site_settings` (dengan default settings)

**Check Data:**
```sql
-- Check admin user
SELECT * FROM users;

-- Check settings
SELECT * FROM site_settings;
```

---

## 🎯 Quick Steps Summary

1. ✅ **Guna file**: `wedding_infinityfree.sql` (BUKAN `wedding.sql`)
2. ✅ **Pastikan** database `if0_40767466_wedding_db` selected
3. ✅ **Import** file SQL
4. ✅ **Verify** tables created
5. ✅ **Test** website!

---

## 🆘 Jika Masih Ada Error

### **Error: Table already exists**
**Solution**: 
- Drop tables yang existing dulu
- Atau edit SQL file, remove `IF NOT EXISTS`

### **Error: Syntax error**
**Solution**:
- Check SQL file encoding (UTF-8)
- Try import table by table

### **Error: Max execution time**
**Solution**:
- File terlalu besar
- Import table by table
- Atau split SQL file

---

## 📝 Important Notes

**InfinityFree Limitations:**
- ❌ Cannot CREATE DATABASE
- ❌ Cannot DROP DATABASE
- ✅ Can CREATE/DROP TABLES
- ✅ Can INSERT/UPDATE/DELETE data

**Your Database:**
- Name: `if0_40767466_wedding_db`
- User: `if0_40767466`
- Host: `sql207.infinityfree.com`
- Pass: `Mbsa0717`

---

## ✅ After Successful Import

1. **Test Connection**:
   - Buka website: `http://your-domain.infinityfree.com`
   - Should load without database error

2. **Test Admin Login**:
   - URL: `http://your-domain.infinityfree.com/admin/`
   - Username: `admin`
   - Password: `admin123`

3. **Change Password**:
   - Login admin panel
   - Change password immediately!

---

## 🎉 Done!

Lepas import successful, website anda akan fully functional!

**Selamat mencuba!** 🚀

Jika masih ada masalah, beritahu saya! 😊
