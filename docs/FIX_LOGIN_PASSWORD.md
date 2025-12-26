# 🔐 FIX: Admin Login Password Error

## ❌ Error Yang Anda Dapat:
```
Access Denied
Invalid password.
```

## 💡 Sebab:
InfinityFree mungkin tak fully support bcrypt password hashing. Kita guna MD5 untuk better compatibility.

---

## ✅ SOLUTION - 2 Steps

### **Step 1: Drop & Re-import Database**

#### **A. Drop Table `users` (Dalam InfinityFree phpMyAdmin)**

```sql
DROP TABLE IF EXISTS users;
```

#### **B. Import SQL File Baru**

1. **File**: `database/wedding_infinityfree.sql` (sudah updated dengan MD5)
2. **Import** ke database `if0_40767466_wedding_db`
3. **Verify** table `users` created dengan MD5 password

**Check password hash:**
```sql
SELECT username, password, LENGTH(password) as hash_length FROM users;
```

**Result should be:**
- Username: `admin`
- Password: `0192023a7bbd73250516f069df18b500` (32 characters - MD5)
- Hash Length: `32`

---

### **Step 2: Upload Updated Login File**

File `auth/login-process.php` sudah saya update untuk support:
- ✅ MD5 password (InfinityFree)
- ✅ Bcrypt password (Localhost)

**Upload file ini ke InfinityFree:**
- 📁 `auth/login-process.php`

---

## 🎯 Login Credentials

**After import:**
```
URL:      http://your-domain.infinityfree.com/admin/
Username: admin
Password: admin123
```

---

## 🔍 Verify Setup

### **Test 1: Check Database**

Di InfinityFree phpMyAdmin:
```sql
-- Check user exists
SELECT * FROM users WHERE username = 'admin';

-- Should return:
-- id: 1
-- username: admin
-- password: 0192023a7bbd73250516f069df18b500 (MD5 hash)
-- full_name: System Administrator
-- status: active
```

### **Test 2: Test Login**

1. Buka: `http://your-domain.infinityfree.com/admin/`
2. Username: `admin`
3. Password: `admin123`
4. Click **Unlock Dashboard**
5. Should redirect to dashboard ✅

---

## 📋 Complete Steps Summary

1. ✅ **Drop table** `users` di InfinityFree phpMyAdmin
2. ✅ **Import** file `wedding_infinityfree.sql` (updated version)
3. ✅ **Upload** file `auth/login-process.php` ke InfinityFree
4. ✅ **Test** login dengan `admin` / `admin123`
5. ✅ **Change** password selepas login!

---

## 🔒 Change Password After Login

### **Method 1: Via phpMyAdmin (Recommended)**

```sql
-- Change to new password (example: NewPass123)
UPDATE users 
SET password = MD5('NewPass123') 
WHERE username = 'admin';
```

### **Method 2: Via Admin Panel**

Jika ada settings page untuk change password, guna tu.

---

## 🆘 Jika Masih Tak Boleh Login

### **Option 1: Reset Password Manually**

Di phpMyAdmin:
```sql
-- Reset to default password: admin123
UPDATE users 
SET password = MD5('admin123') 
WHERE username = 'admin';
```

### **Option 2: Create New Admin**

```sql
-- Create new admin user
INSERT INTO users (username, password, full_name, status) 
VALUES ('newadmin', MD5('newpass123'), 'New Admin', 'active');
```

Then login dengan:
- Username: `newadmin`
- Password: `newpass123`

---

## 📝 Important Notes

**Password Hashing:**
- **Localhost**: Guna bcrypt (lebih secure)
- **InfinityFree**: Guna MD5 (compatibility)
- **Login script**: Auto-detect which hash to use

**Security:**
- MD5 kurang secure dari bcrypt
- **CHANGE PASSWORD** selepas first login!
- Guna strong password (min 8 characters, mix of letters/numbers/symbols)

---

## ✅ Files Updated

1. ✅ `database/wedding_infinityfree.sql` - MD5 password hash
2. ✅ `auth/login-process.php` - Support both MD5 & bcrypt

---

## 🎉 After Successful Login

1. **Change Password** immediately
2. **Update Site Settings** (couple names, date, venue, etc)
3. **Upload Gallery** images
4. **Test RSVP** form
5. **Share** link dengan guests!

---

**Cuba sekarang! Login should work dengan `admin` / `admin123`** 🚀

Beritahu saya jika berjaya! 😊
