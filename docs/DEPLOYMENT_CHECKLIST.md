# ✅ Quick Deployment Checklist

## Sebelum Deploy

- [x] Database config updated (AUTO - sudah siap!)
- [ ] Test localhost masih berfungsi
- [ ] Backup database
- [ ] Backup files

---

## Step 1: Export Database (5 minit)

- [ ] Buka phpMyAdmin: `http://localhost/phpmyadmin`
- [ ] Pilih database `wedding_db`
- [ ] Click **Export** tab
- [ ] Click **Go**
- [ ] Save file `wedding_db.sql`

---

## Step 2: Upload Files (10-15 minit)

### Via File Manager (Mudah):
- [ ] Login InfinityFree cPanel
- [ ] Buka **File Manager**
- [ ] Navigate ke `htdocs`
- [ ] Delete semua file default
- [ ] Upload semua files dari `wedding-invitation` folder

### Via FTP (Lebih Cepat):
- [ ] Download FileZilla
- [ ] Connect dengan FTP credentials
- [ ] Upload semua files ke `htdocs`

**Files yang MESTI upload:**
```
✅ admin/
✅ assets/
✅ auth/
✅ config/
✅ database/
✅ includes/
✅ index.php
✅ rsvp.php
✅ rsvp-submit.php
✅ thank-you.php
✅ .htaccess
```

---

## Step 3: Import Database (5 minit)

- [ ] Login InfinityFree cPanel
- [ ] Click **MySQL Databases**
- [ ] Click **Manage** pada `if0_40767466_wedding_db`
- [ ] Click **phpMyAdmin**
- [ ] Pilih database `if0_40767466_wedding_db`
- [ ] Click **Import** tab
- [ ] Choose file `wedding_db.sql`
- [ ] Click **Go**
- [ ] Tunggu success message

---

## Step 4: Set Permissions (2 minit)

- [ ] Di File Manager, set permissions untuk:
  - `assets/uploads/` → 755 atau 777
  - `database/` → 755

---

## Step 5: Test Website (5 minit)

- [ ] Buka: `http://your-domain.infinityfree.com`
- [ ] Landing page loads? ✅
- [ ] Images display? ✅
- [ ] RSVP form works? ✅
- [ ] Submit RSVP test ✅

---

## Step 6: Test Admin Panel (5 minit)

- [ ] Buka: `http://your-domain.infinityfree.com/admin/`
- [ ] Login dengan admin credentials
- [ ] Dashboard loads? ✅
- [ ] RSVP list shows? ✅
- [ ] Gallery works? ✅
- [ ] Settings works? ✅

---

## Step 7: Security (3 minit)

- [ ] Change admin password
- [ ] Test new password works
- [ ] Delete any test data

---

## Step 8: Final Check (5 minit)

- [ ] Test on mobile phone
- [ ] Test RSVP submission
- [ ] Check email notifications (if setup)
- [ ] Share link dengan kawan untuk test

---

## 🎉 DONE!

Total Time: ~40-50 minit

**Your wedding invitation is now LIVE!** 🚀💒

---

## 📝 Important Notes

**Database Connection:**
- ✅ AUTO-DETECT sudah setup
- Localhost: guna `localhost`, `root`
- Production: guna InfinityFree credentials
- **TAK PERLU ubah apa-apa!**

**Your Credentials:**
```
MySQL Host: sql207.infinityfree.com
Database:   if0_40767466_wedding_db
Username:   if0_40767466
Password:   Mbsa0717
```

---

## 🆘 Jika Ada Masalah

**Database Error?**
- Check database imported
- Check credentials betul
- Check hostname: `sql207.infinityfree.com`

**404 Error?**
- Check files uploaded ke `htdocs`
- Check `.htaccess` ada
- Check `index.php` ada

**Images Tak Keluar?**
- Check folder permissions (755/777)
- Re-upload images
- Check paths dalam database

**Admin Tak Boleh Login?**
- Check database imported
- Reset password via phpMyAdmin
- Check `admin` table ada data

---

## 📞 Need Help?

Beritahu saya jika ada masalah! 😊

**Selamat Deploy!** 🎊
