# 🚀 Deployment Guide - InfinityFree

## 📋 Credential InfinityFree Anda

```
MySQL Database Name: if0_40767466_wedding_db
MySQL Username:      if0_40767466
MySQL Password:      Mbsa0717
MySQL Hostname:      sql207.infinityfree.com
```

---

## ✅ Langkah 1: Setup Database Configuration (SUDAH SIAP!)

File `config/database.php` sudah dikonfigurasi untuk auto-detect environment:
- ✅ **Localhost (XAMPP)**: Guna `localhost`, `root`, no password
- ✅ **Production (InfinityFree)**: Guna credentials InfinityFree anda

**Sistem akan auto switch!** Tak perlu ubah apa-apa.

---

## 📤 Langkah 2: Export Database dari Localhost

### **A. Export Database**

1. Buka **phpMyAdmin** di localhost: `http://localhost/phpmyadmin`
2. Pilih database `wedding_db`
3. Click tab **Export**
4. Pilih **Quick** export method
5. Format: **SQL**
6. Click **Go** untuk download file `.sql`

**File akan download sebagai**: `wedding_db.sql`

---

## 🌐 Langkah 3: Upload Files ke InfinityFree

### **A. Login ke InfinityFree**

1. Pergi ke: https://infinityfree.com
2. Login dengan account anda
3. Pergi ke **Control Panel** (cPanel)

### **B. Upload Files via File Manager**

1. Di cPanel, buka **File Manager**
2. Navigate ke folder **htdocs** (atau **public_html**)
3. **DELETE** semua file default yang ada (index.html, dll)
4. Click **Upload** button
5. Upload **SEMUA** file dari folder `wedding-invitation` anda:

**Files yang perlu upload:**
```
✅ admin/          (folder + semua contents)
✅ assets/         (folder + semua contents)
✅ auth/           (folder + semua contents)
✅ config/         (folder + semua contents)
✅ database/       (folder + semua contents)
✅ includes/       (folder + semua contents)
✅ index.php
✅ rsvp.php
✅ rsvp-submit.php
✅ thank-you.php
✅ .htaccess
```

**JANGAN upload:**
```
❌ .git/
❌ *.md files (documentation)
❌ .env (if any)
```

### **C. Alternative: Upload via FTP (Lebih Cepat)**

**Recommended FTP Client**: FileZilla

**FTP Credentials** (dapat dari InfinityFree cPanel):
```
FTP Hostname: ftpupload.net (atau check di cPanel)
FTP Username: epiz_XXXXXXXX (check di cPanel)
FTP Password: [your password]
FTP Port: 21
```

**Steps:**
1. Download FileZilla: https://filezilla-project.org/
2. Connect dengan credentials di atas
3. Navigate ke folder `htdocs`
4. Drag & drop semua files dari `wedding-invitation` folder

---

## 💾 Langkah 4: Import Database ke InfinityFree

### **A. Access phpMyAdmin**

1. Di InfinityFree cPanel, cari **MySQL Databases**
2. Click **Manage** pada database: `if0_40767466_wedding_db`
3. Click **phpMyAdmin** button

### **B. Import SQL File**

1. Dalam phpMyAdmin, pilih database `if0_40767466_wedding_db`
2. Click tab **Import**
3. Click **Choose File**
4. Pilih file `wedding_db.sql` yang anda export tadi
5. Scroll ke bawah, click **Go**
6. Tunggu sehingga selesai (akan ada success message)

**⚠️ PENTING**: Jika file terlalu besar (>10MB), anda perlu:
- Compress file SQL (zip/gzip)
- Atau import table by table
- Atau guna BigDump script

---

## 🔧 Langkah 5: Verify & Test

### **A. Check File Permissions**

Ensure these folders have write permissions (755 or 777):
```
assets/uploads/
database/
```

**Set permissions via File Manager:**
1. Right-click folder
2. Click **Change Permissions**
3. Set to **755** (or 777 if needed)

### **B. Test Website**

1. Buka URL anda: `http://your-domain.infinityfree.com`
2. Test pages:
   - ✅ Landing page loads
   - ✅ RSVP form works
   - ✅ Admin login works
   - ✅ Images display correctly

### **C. Test Admin Panel**

1. Login ke admin: `http://your-domain.infinityfree.com/admin/`
2. Username: `admin` (atau yang anda setup)
3. Password: [your admin password]
4. Check:
   - ✅ Dashboard loads
   - ✅ RSVP list shows
   - ✅ Gallery upload works
   - ✅ Settings can be updated

---

## 🐛 Troubleshooting

### **Problem 1: Database Connection Error**

**Solution:**
1. Check database credentials di `config/database.php`
2. Pastikan database sudah di-import
3. Check MySQL hostname betul: `sql207.infinityfree.com`

### **Problem 2: Images Not Showing**

**Solution:**
1. Check folder `assets/uploads/` ada dan writable
2. Re-upload images
3. Check file paths dalam database

### **Problem 3: 404 Error**

**Solution:**
1. Check `.htaccess` file uploaded
2. Pastikan `index.php` ada di root folder
3. Check file permissions

### **Problem 4: Admin Can't Login**

**Solution:**
1. Check database imported correctly
2. Check `admin` table ada users
3. Reset password via phpMyAdmin if needed

### **Problem 5: Slow Loading**

**InfinityFree Limitations:**
- Free hosting ada resource limits
- Slow during peak hours
- Consider upgrade jika perlu

---

## 📝 Post-Deployment Checklist

- [ ] Database connection working
- [ ] Landing page loads correctly
- [ ] RSVP form submits successfully
- [ ] Admin login works
- [ ] Dashboard displays data
- [ ] Images upload and display
- [ ] Gallery works
- [ ] Wishes display
- [ ] Settings can be updated
- [ ] Mobile responsive working
- [ ] All links working

---

## 🔒 Security Recommendations

### **1. Change Default Admin Password**
```sql
-- Via phpMyAdmin, run this query:
UPDATE admin SET password = MD5('NewSecurePassword123') WHERE username = 'admin';
```

### **2. Protect Admin Folder**

Add this to `admin/.htaccess`:
```apache
# Protect admin directory
AuthType Basic
AuthName "Restricted Area"
AuthUserFile /path/to/.htpasswd
Require valid-user
```

### **3. Hide Database Credentials**

Database credentials sudah protected dalam `config/database.php`

---

## 📊 InfinityFree Limits (Free Plan)

- **Disk Space**: 5GB
- **Bandwidth**: Unlimited
- **MySQL Databases**: Unlimited
- **Email Accounts**: Unlimited
- **FTP Accounts**: Unlimited
- **Subdomains**: Unlimited

**Limitations:**
- ⚠️ Slow during peak hours
- ⚠️ No cron jobs
- ⚠️ Limited CPU/RAM
- ⚠️ Ads on free subdomain (remove with custom domain)

---

## 🎯 Next Steps

### **1. Get Custom Domain (Optional)**

**Free Options:**
- Freenom: .tk, .ml, .ga, .cf, .gq domains
- InfinityFree: Free subdomain

**Paid Options:**
- Namecheap: ~$10/year
- GoDaddy: ~$12/year

### **2. Setup Email (Optional)**

InfinityFree provides free email accounts:
1. Go to cPanel
2. Click **Email Accounts**
3. Create: `rsvp@yourdomain.com`

### **3. Enable SSL (HTTPS)**

InfinityFree provides free SSL:
1. Go to cPanel
2. Click **SSL/TLS**
3. Enable SSL for your domain
4. Wait 24-48 hours for activation

---

## 📞 Support

**InfinityFree Support:**
- Forum: https://forum.infinityfree.com
- Knowledge Base: https://infinityfree.com/support

**Common Issues:**
- Check forum first
- Most issues already answered
- Community very helpful

---

## ✅ Deployment Summary

**What You Need to Do:**

1. ✅ **Export** database dari localhost
2. ✅ **Upload** files via File Manager atau FTP
3. ✅ **Import** database ke InfinityFree
4. ✅ **Test** website functionality
5. ✅ **Update** admin password
6. ✅ **Share** link dengan guests!

**Database Config**: ✅ Already configured automatically!

---

## 🎉 Congratulations!

Lepas ikut semua steps ni, wedding invitation anda akan live di internet dan boleh diakses dari mana-mana!

**Your Website Will Be:**
- ✅ Accessible 24/7
- ✅ Mobile responsive
- ✅ Professional looking
- ✅ Ready for guests

---

**Good luck dengan deployment! 🚀💒**

Jika ada masalah, beritahu saya dan saya akan bantu troubleshoot!
