# Quick Device Testing Reference

## 🔍 How to Test Responsive Design

### Method 1: Browser DevTools (Recommended)

#### **Chrome/Edge**
1. Press `F12` to open DevTools
2. Press `Ctrl + Shift + M` (or click device icon)
3. Select device from dropdown or enter custom dimensions

#### **Firefox**
1. Press `F12` to open DevTools
2. Press `Ctrl + Shift + M` for Responsive Design Mode
3. Choose device or enter custom size

### Method 2: Resize Browser Window
Simply resize your browser window to different widths and watch the layout adapt!

---

## 📱 Device Presets to Test

### **Copy these dimensions into DevTools:**

#### **Foldable Devices**
```
Samsung Galaxy Fold (Folded): 280 x 653
Samsung Galaxy Fold (Unfolded): 717 x 512
```

#### **Small Phones**
```
iPhone SE: 375 x 667
Samsung Galaxy S8: 360 x 740
```

#### **Standard Phones**
```
iPhone 12/13/14: 390 x 844
iPhone 14 Pro: 393 x 852
iPhone 14 Pro Max: 430 x 932
Google Pixel 7: 412 x 915
Samsung Galaxy S21: 360 x 800
```

#### **Tablets**
```
iPad: 768 x 1024
iPad Air: 820 x 1180
iPad Pro 11": 834 x 1194
iPad Pro 12.9": 1024 x 1366
Surface Pro 7: 912 x 1368
```

#### **Desktop**
```
Laptop: 1366 x 768
Desktop: 1920 x 1080
Large Monitor: 2560 x 1440
```

---

## ✅ Testing Checklist

### **Landing Page (index.php)**
- [ ] Hero section displays properly
- [ ] Navigation menu collapses on mobile
- [ ] Couple images scale correctly
- [ ] Countdown is readable
- [ ] Story timeline stacks on mobile
- [ ] Event cards stack properly
- [ ] Gallery carousel works
- [ ] Wishes section displays
- [ ] Footer is readable
- [ ] No horizontal scroll

### **RSVP Page (rsvp.php)**
- [ ] Form container fits screen
- [ ] All inputs are tappable (44px min)
- [ ] Labels are readable
- [ ] Radio buttons work well
- [ ] Submit button is accessible
- [ ] No horizontal scroll
- [ ] Keyboard doesn't overlap inputs

### **Admin Login (admin/index.php)**
- [ ] Login card is centered
- [ ] Logo displays properly
- [ ] Input fields are tappable
- [ ] Login button works
- [ ] No horizontal scroll

### **Admin Dashboard**
- [ ] Sidebar is accessible (hamburger on mobile)
- [ ] KPI cards stack on mobile
- [ ] Charts display correctly
- [ ] Tables are readable/scrollable
- [ ] Action buttons are tappable
- [ ] Forms work properly
- [ ] No horizontal scroll

---

## 🎯 Quick Test URLs

```
Landing Page:
http://localhost/wedding-invitation/index.php

RSVP Form:
http://localhost/wedding-invitation/rsvp.php

Thank You:
http://localhost/wedding-invitation/thank-you.php

Admin Login:
http://localhost/wedding-invitation/admin/index.php

Admin Dashboard:
http://localhost/wedding-invitation/admin/dashboard.php
```

---

## 🔄 Test Both Orientations

### **Portrait Mode**
- Default vertical orientation
- Most common for phones

### **Landscape Mode**
- Rotate device icon in DevTools
- Or manually enter dimensions (swap width/height)
- Example: 844 x 390 (iPhone landscape)

---

## 🐛 Common Issues to Check

1. **Text too small?** → Should be minimum 16px on mobile
2. **Buttons hard to tap?** → Should be minimum 44x44px
3. **Horizontal scroll?** → Should never happen
4. **Images overflow?** → Should scale to container
5. **Menu not working?** → Check hamburger icon on mobile
6. **Content cut off?** → Check padding and margins

---

## 💻 Keyboard Shortcuts

| Action | Chrome/Edge | Firefox |
|--------|-------------|---------|
| Open DevTools | F12 | F12 |
| Toggle Device Mode | Ctrl+Shift+M | Ctrl+Shift+M |
| Reload Page | Ctrl+R | Ctrl+R |
| Hard Reload | Ctrl+Shift+R | Ctrl+Shift+R |
| Zoom In | Ctrl + Plus | Ctrl + Plus |
| Zoom Out | Ctrl + Minus | Ctrl + Minus |
| Reset Zoom | Ctrl + 0 | Ctrl + 0 |

---

## 📊 Breakpoint Reference

| Breakpoint | Device Type | What Changes |
|-----------|-------------|--------------|
| 1200px+ | Desktop | Full layout, large text |
| 992-1199px | Large Tablet | Slightly smaller |
| 768-991px | Tablet | Medium sizing |
| 577-767px | Large Phone | Stacked layout |
| 376-576px | Phone | Mobile optimized |
| 320-375px | Small Phone | Compact layout |
| <320px | Foldable | Ultra compact |

---

## 🎨 Visual Indicators

### **What to Look For:**
✅ **Good**: Text is readable, buttons are tappable, no scrolling issues  
❌ **Bad**: Text too small, buttons tiny, horizontal scroll appears

### **Navigation:**
- **Desktop**: Horizontal menu bar
- **Tablet**: Horizontal menu (may wrap)
- **Mobile**: Hamburger icon (☰)

### **Layout:**
- **Desktop**: Multi-column
- **Tablet**: 2 columns
- **Mobile**: Single column (stacked)

---

## 🚀 Quick Start Testing

1. **Open your site** in Chrome/Edge
2. **Press F12** to open DevTools
3. **Press Ctrl+Shift+M** for device mode
4. **Select "iPhone 12 Pro"** from dropdown
5. **Scroll through the page** - everything should look good!
6. **Try "iPad"** - should also look great
7. **Try "Samsung Galaxy Fold"** - even foldables work!

---

## 📱 Real Device Testing

If you have access to real devices:

1. **Connect to same network** as your computer
2. **Find your computer's IP** (ipconfig on Windows)
3. **Open browser on device**
4. **Navigate to**: `http://YOUR_IP/wedding-invitation/`
5. **Test all pages**

Example: `http://192.168.1.100/wedding-invitation/`

---

## ✨ Pro Tips

1. **Test in both orientations** (portrait and landscape)
2. **Try different zoom levels** (Ctrl + Plus/Minus)
3. **Test with DevTools open** to see breakpoints
4. **Use throttling** to simulate slow networks
5. **Test touch interactions** if you have a touchscreen

---

**Happy Testing! 🎉**

Your wedding invitation is now responsive on ALL devices!
