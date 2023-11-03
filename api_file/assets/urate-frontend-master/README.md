# Prinsip Penulisan CSS yang Konsisten

Dokumen dibawah ini menjelaskan petunjuk umum dalam pengembangan CSS dan panduan kolaborasi menggunakan GIT.


## Daftar Isi

1. [Prinsip Umum](#general-principles)
2. [Whitespace](#whitespace)
3. [Komentar](#comments)
4. [Format](#format)
5. [GIT](#git)
6. [Grouping Tasks](#grouping)
7. [Assets](#assets)


<a name="general-principles"></a>
## 1. Prinsip Umum

> "Semua kode harus tampak seperti ditulis oleh satu orang, walaupun ada banyak orang yang berpartisipasi."



<a name="whitespace"></a>
## 2. Whitespace

Anda disarankan menggunakan satu pola dalam seluruh kode. Harap konsisten
dengan penggunaan whitespace pada kode. Gunakan Whitespace untuk memudahkan
pembacaan kode.

Gunakan File [EditorConfig](http://editorconfig.org) untuk membantu pengaturan Whitespace yang anda gunakan pada kode anda.


<a name="comments"></a>
## 3. Komentar

Kode yang dikomentari dengan baik sangatlah penting. Sisihkan waktu untuk
menjelaskan komponen, bagaimana mereka bekerja, dan cara penggunaannya. Jangan
membiarkan staf di Tim anda untuk menduga-duga atau menebak-nebak karena kode
yang kurang jelas.

Pola Komentar harus sederhana dan konsisten di setiap kode anda.

* Tempatkan Komentar di atas subjeknya.
* Anda bebas untuk menentukan Komentar sebagai pemecah kode CSS menjadi
  beberapa bagian.

Tip: Buat snippet pada Editor anda sebagai shortcut untuk Komentar yang akan
anda gunakan.

Contoh:
```css
/* ==========================================================================
   Blok Bagian
   ========================================================================== */

/* Blok Sub-Bagian
   ========================================================================== */

/**
 * Kalimat pertama dari Deskripsi Detail dimulai di sini dan berlanjut di baris
 * selanjutnya hingga sampai kepada kesimpulan pada akhir paragraf.
 *
 * Deskripsi Detail sangat ideal untuk Penjelasan yang lebih lengkap dan
 * sebagai Dokumentasi. Disini anda dapat memasukkan contoh HTML, URL, atau
 * informas-informasi lain yang berguna untuk penjelasan.
 *
 * @todo Ini adalah Statemen Todo yang mendeskripsikan tugas-tugas yang harus
 *   anda selesaikan di waktu yang akan datang. Bagian ini memilik panjang
 *   maksimal 80 karakter dan baris dibawahnya di indentasi menggunakan 2 spasi
 */

/* Komentar standar */
```


<a name="format"></a>
## 4. Format

Format kode yang anda gunakan harus memastikan bahwa kode tersebut: mudah
dibaca; mudah di-Komentari; meminimalkan kemungkinan kesalahan penggunaan.

Selebihnya bisa mengikuti panduan yang sudah dibuat oleh frontend developer dari Google: [Google HTML/CSS Style Guide](https://google.github.io/styleguide/htmlcssguide.html)


<a name="git"></a>
## 5. GIT

Untuk menghindari konflik di GIT ketika mengubah file oleh beberapa orang, maka CSS bisa dipecah sesuai komponen yang ada dan dibagi sesuai jumlah developer frontend yang terlibat.

Jika masing-masing sudah selesai dengan komponen yang di-assign, maka langsung membantu tim lain yang belum selesai dengan terlebih dulu konfirmasi ke developer yang ingin dibantu sehingga komponen bisa dibagi dan dikerjakan lebih dari satu orang.

Contoh:
```html
<link href="assets/css/layout.css" rel="stylesheet">
<link href="assets/css/tipografi.css" rel="stylesheet">
<link href="assets/css/forms.css" rel="stylesheet">
<link href="assets/css/table.css" rel="stylesheet">
<link href="assets/css/widget.css" rel="stylesheet">
<link href="assets/css/stats.css" rel="stylesheet">
<link href="assets/css/modal.css" rel="stylesheet">
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/table.js"></script>
<script src="assets/js/widget.js"></script>
```


<a name="grouping"></a>
## 6. Grouping Tasks

1 | @gabysatria
--- | ---
- Z0 | Header
- Z0 | Sidebar
- HT | Page title
- HT | Stats
- HT | Table (Table styling)
- HT | Pop up alert
- HT | Button skunder
- HL | Alert notif
- Z0 | Standar konvensi (Form styling, Modal styling, Button styling, Pannel styling)

2 | @sirio
--- | ---
- HT | Bar chart Widget
- HT | Pie chart widget
- HT | Line chart widget
- HT | Line chart widget
- HT | Graphic widget
- HT | Button Export
- HT | Action button
- HT | Create new widget button
- HT | Create new widget modal
- HT | Checkbox selected widget


3 | bagas
--- | ---
- HL | Dropdown menu
- HL | Grid & list button
- HL | Box profile
- HL | Tag Component
- HL | Tag ouline box
- HL | Search bar
- HL | Button action
- HL | Tree box function
- HL | Favorite function
- HL | Scrollbar
- HL | Combine profile modal
- VB | New profile modal

4 | @putraridho
--- | ---
- VB | Dataset
- VB | Data picker
- VB | Time picker
- VB | New daypart modal
- VB | Result tab
- VB | Radio button
- VB | Layout setting dropdown
- VB | Progress animation
- VB | Compare Button
- VB | Result chart
- VB | Interval function
- VB | Result chart bar
- VB | Result table

5 | @permanayu
--- | ---
- MP | Result summary
- MP | Summary table
- MP | Paggination
- PB | Play button
- PB | Download button
- PB | Play video modal
- TVRL | TV channel thumbnail
- TVRL | Live chat
- Z0 | Integrating

<a name="assets"></a>
## 7. Assets

* [File Desain Terbaru URate](https://drive.google.com/drive/folders/0B47U4QYny2Y0cG1HNUFnQlVJUEU)

Demo via MarvelApp (Tidak update dengan desain terbaru di atas) :
* [TV Program](https://marvelapp.com/h734fhg)
* [Audience Analysis](https://marvelapp.com/8hc95j4)
* [Media Planning](https://marvelapp.com/8hceib4)