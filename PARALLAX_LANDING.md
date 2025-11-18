# Parallax Landing Page Implementation

## 📋 Overview

Landing page dengan efek parallax yang smooth dan modern untuk Buku Tamu Digital SMK TI Airlangga.

## 🎨 Fitur Utama

### 1. **Hero Section dengan Multi-Layer Parallax**
- 4 layer dengan kecepatan berbeda (data-speed: 0.2, 0.5, 0.8, 1.2)
- Animated floating circles dengan blur effect
- Grid pattern background
- Floating particles
- Glass morphism effects
- 3D card dengan mouse parallax
- Counter animation untuk statistik

### 2. **Features Section**
- 6 kartu fitur dengan hover effects
- 3D tilt effect saat hover
- Scroll reveal animation
- Gradient backgrounds

### 3. **Timeline Section**
- 3 langkah pengajuan kunjungan
- Alternating layout (kiri-kanan)
- Icon dengan badge
- Hover effects

### 4. **Animasi & Effects**
- Smooth parallax scrolling
- Fade in animations
- Floating animations
- Scale & rotate effects
- Counter animation
- Scroll reveal
- Mouse parallax (3D)
- Card tilt effects

## 📁 Struktur File

```
buku-tamu-digital/
├── public/
│   ├── css/
│   │   └── landing.css          # Style utama landing page
│   └── js/
│       └── parallax.js          # JavaScript parallax controller
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── public.blade.php # Layout dengan navbar & footer
│       └── public/
│           └── landing.blade.php # Landing page content
```

## 🚀 Cara Menggunakan

### 1. Pastikan File Sudah Ada

Cek file-file berikut sudah tersedia:
- `public/css/landing.css`
- `public/js/parallax.js`
- `resources/views/public/landing.blade.php`

### 2. Integrasi di Blade

```blade
@extends('layouts.public')

@section('title', 'Beranda')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

@section('content')
<!-- Hero dengan parallax layers -->
<section id="hero">
    <div class="parallax-layer" data-speed="0.5">
        <!-- Konten parallax -->
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/parallax.js') }}"></script>
@endpush
```

### 3. Struktur Parallax Layer

```html
<!-- Parallax Layer -->
<div class="parallax-layer" data-speed="0.5">
    <div class="floating-element"></div>
</div>
```

**Data Speed:**
- `0.2` = Paling lambat (background)
- `0.5` = Medium
- `0.8` = Cepat
- `1.2` = Paling cepat (foreground)

### 4. Scroll Reveal

```html
<div class="scroll-reveal" style="animation-delay: 0.2s;">
    <!-- Konten akan fade in saat scroll -->
</div>
```

### 5. Counter Animation

```html
<div class="counter" data-target="1000" data-suffix="+">0</div>
```

### 6. Mouse Parallax (3D Effect)

```html
<div class="parallax-mouse" data-depth="1.5">
    <!-- Elemen akan bergerak mengikuti mouse -->
</div>
```

## 🎯 JavaScript Classes

### ParallaxController
Mengatur parallax scrolling dengan `requestAnimationFrame` untuk performa optimal.

```javascript
new ParallaxController();
```

**Methods:**
- `setupParallaxLayers()` - Parallax scroll effect
- `setupScrollReveal()` - Fade in saat scroll
- `setupCounters()` - Animasi counter angka
- `setupSmoothScroll()` - Smooth scroll untuk anchor links
- `setupFloatingAnimations()` - Floating animations
- `setupMouseParallax()` - 3D mouse tracking

### NavbarController
Mengatur navbar scroll effects.

```javascript
new NavbarController();
```

### CardTiltEffect
3D tilt effect untuk kartu saat hover.

```javascript
new CardTiltEffect();
```

### LazyLoader
Lazy load gambar untuk performa.

```javascript
new LazyLoader();
```

## 🎨 CSS Classes

### Animasi

| Class | Deskripsi |
|-------|-----------|
| `.animate-fade-in` | Fade in dari opacity 0 |
| `.animate-fade-in-up` | Fade in dari bawah |
| `.animate-float` | Floating effect (naik-turun) |
| `.floating` | Floating dengan rotasi |
| `.animate-pulse` | Pulse effect |
| `.animate-bounce` | Bounce effect |
| `.scroll-reveal` | Reveal saat scroll |

### Effects

| Class | Deskripsi |
|-------|-----------|
| `.glass` | Glassmorphism effect |
| `.gradient-primary` | Gradient biru-ungu |
| `.gradient-text` | Text dengan gradient |
| `.parallax-layer` | Layer untuk parallax |
| `.feature-card` | Kartu fitur dengan hover |

## ⚙️ Konfigurasi

### Kecepatan Parallax

Edit di `parallax.js`:

```javascript
const speed = layer.dataset.speed || 0.5;
const yPos = -(scrolled * speed);
```

### Counter Speed

Edit di `parallax.js`:

```javascript
const speed = 200; // Semakin kecil semakin cepat
```

### Intersection Observer Threshold

```javascript
const revealObserver = new IntersectionObserver((entries) => {
    // ...
}, {
    threshold: 0.1,  // 10% element terlihat
    rootMargin: '0px 0px -50px 0px'
});
```

## 🎨 Customization

### Mengubah Warna Gradient

Edit di `landing.css`:

```css
:root {
    --gradient-primary: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    --gradient-hero: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

### Menambah Layer Parallax Baru

```html
<div class="parallax-layer" data-speed="0.7">
    <div class="absolute top-40 left-20 w-80 h-80 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full opacity-20 blur-3xl animate-float"></div>
</div>
```

### Menambah Kartu Fitur Baru

```html
<div class="group feature-card scroll-reveal" style="animation-delay: 0.7s;">
    <div class="relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
        <!-- Gradient Background -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full opacity-10 -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
        
        <!-- Icon -->
        <div class="relative mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                <i class="fas fa-icon text-3xl text-white"></i>
            </div>
        </div>
        
        <!-- Content -->
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Judul Fitur</h3>
        <p class="text-gray-600 leading-relaxed mb-4">Deskripsi fitur...</p>
        
        <!-- Link -->
        <div class="flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition-transform">
            <span>Pelajari lebih lanjut</span>
            <i class="fas fa-arrow-right ml-2"></i>
        </div>
    </div>
</div>
```

## 📱 Responsive Design

Landing page sudah responsive dengan breakpoints:

- **Mobile**: < 640px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

### Mobile Adjustments

- Hero section menjadi single column
- Left decorative section disembunyikan
- Font size lebih kecil
- Card grid menjadi 1 kolom

## 🔧 Troubleshooting

### 1. Parallax tidak berjalan smooth

**Solusi:**
- Pastikan `will-change: transform` ada di `.parallax-layer`
- Gunakan `transform: translate3d()` untuk GPU acceleration
- Cek console untuk error JavaScript

### 2. Counter tidak animate

**Solusi:**
- Pastikan element ada attribute `data-target`
- Cek Intersection Observer support di browser
- Scroll element ke viewport

### 3. Scroll reveal tidak muncul

**Solusi:**
- Pastikan class `.scroll-reveal` ada
- Cek threshold Intersection Observer
- Pastikan JavaScript sudah load

### 4. Performance issues

**Solusi:**
- Kurangi jumlah parallax layers
- Gunakan `will-change` dengan bijak
- Lazy load images
- Minify CSS & JS

## 📊 Performance Optimization

### 1. Use RequestAnimationFrame

```javascript
window.requestAnimationFrame(() => {
    // Update parallax
});
```

### 2. Debounce Scroll Events

```javascript
let ticking = false;
window.addEventListener('scroll', () => {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            // Update
            ticking = false;
        });
        ticking = true;
    }
});
```

### 3. Use CSS Transform

```css
/* Good */
transform: translateY(-20px);

/* Bad */
top: -20px;
```

### 4. Lazy Load Assets

```javascript
new LazyLoader(); // Auto lazy load images
```

## 🌟 Best Practices

1. **Gunakan transform untuk animasi** (bukan top/left)
2. **Batasi parallax layers** (maksimal 4-5 layer)
3. **Optimize images** (compress, webp format)
4. **Use will-change dengan bijak** (hanya saat hover/scroll)
5. **Test di berbagai device** (mobile, tablet, desktop)
6. **Monitor performance** (Chrome DevTools)

## 📝 Changelog

### v1.0.0 (2024)
- ✅ Multi-layer parallax scrolling
- ✅ Scroll reveal animations
- ✅ Counter animations
- ✅ Mouse parallax (3D)
- ✅ Card tilt effects
- ✅ Floating animations
- ✅ Responsive design
- ✅ Performance optimizations

## 🤝 Contributing

Untuk menambah fitur atau memperbaiki bug:

1. Test di berbagai browser
2. Pastikan responsive
3. Check performance
4. Update dokumentasi

## 📞 Support

Jika ada masalah atau pertanyaan, hubungi tim development.

---

**Made with ❤️ for SMK TI Airlangga**