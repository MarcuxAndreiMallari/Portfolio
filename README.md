# Mallari Portfolio

A personal portfolio website by Marcux Andrei C. Mallari, an IT student who builds web systems and enjoys photography and photo editing. It brings together his skills, projects, photography, and certifications in one single-page site.

Live site: <https://marcux-andrei-c-mallari.onrender.com/>

---

## Features

- Six sections: Home, Skillset, Projects, Visual Content, Certifications and Contact
- Intro animation and a twinkling starfield background
- Dark and light themes, remembered between visits
- Skillset grouped into Familiar and Proficient
- Projects with a hover image slideshow, a zoom viewer, a short code preview, and a Details window listing each system's description, roles and features
- Visual Content as a full-width depth-of-field carousel with category filters (Photography and Edited Work)
- Certifications that open a full-size view of each certificate
- Contact options that open a ready-made message in the visitor's email app or Gmail, plus links to social platforms
- Responsive from phones to large desktop screens
- Accessible: keyboard navigation, a skip-to-content link, and reduced-motion support

## Built with

1. Back end | PHP, which builds the page from one content file
2. Front end | HTML, CSS and vanilla JavaScript
3. Fonts | Space Grotesk and Inter Tight
4. Hosting | Render, using Docker (PHP and Apache)

---

## Required software installed
1. PHP 8.3 or newer
2. XAMPP (includes Apache and PHP) download here: [apachefriends.org](https://www.apachefriends.org) or [php.net/downloads](https://www.php.net/downloads)
3. A web browser: To view the site (Chrome, Edge, Firefox or Safari)

---

## Getting started

### Run it on your computer

**Option A: XAMPP**

1. Put the project folder in `C:\xampp\htdocs\Portfolio`. Or put the project folder in `C:\xampp\htdocs\**YourFolderName**`.
2. Start **Apache** in the XAMPP Control Panel.
3. Open <http://localhost/Portfolio/> or Open <http://localhost/YourFolderName/>.

**Option B: PHP's built-in server**

1. Open a terminal in the project folder.
2. Run `php -S localhost:8000`.
3. Open <http://localhost:8000/>.

### View it online

Open <https://marcux-andrei-c-mallari.onrender.com/> in any web browser.

---

## Project structure

```
Portfolio/
├── index.php                       page frame (head, header, menus, footer) and the Home text at the top
├── data/
│   ├── content.php                 all the text: menu, skills, projects, photos, certifications, contact
│   └── code/                       short code excerpts shown in each project's "View Code"
├── includes/
│   └── sections/                   one layout file per section
├── assets/
│   ├── css/style.css               all the styles
│   ├── js/app.js                   all the scripts
│   └── img/                        projects/, photography/ and certificates/ pictures
        └── projects
            └── DigiLearn           pictures of DigiLearn system
            └── KahitSaan           pictures of KahitSaan system
            └── LockerSystem        pictures of LockerSystem system
            └── ZannieRiceStore     pictures of ZannieRiceStore system
        └── photography
        └── certificates
├── Dockerfile                      used by Render to run the site (PHP and Apache)
└── .dockerignore                   files Docker should leave out
```

---

## Changing the assets

### Pictures (`assets/img/`)

All pictures live in three folders inside `assets/img/`:

| Folder | Used by |
|---|---|
| `projects/` | the Projects section (you can use one sub-folder per project) |
| `photography/` | the Visual Content carousel |
| `certificates/` | the Certifications list |

A picture only shows on the site when it has an entry in `data/content.php`, and the file name in that entry must match the file exactly, including capital letters and the ending (`.jpg`, `.png`). Putting a file in the folder is not enough on its own.

**Add a picture**

1. Copy the file into the right folder.
2. Add an entry for it in `data/content.php`:

Photo or edited work (`photography` block). The category must be `Photography` or `Edited Work`, spelled the same every time:

```php
['file' => 'MyPhoto.jpg', 'title' => 'My Photo', 'category' => 'Photography'],
```

Certification (`certificates` block):

```php
[
    'name'   => 'Course name',
    'issuer' => 'Who issued it',
    'date'   => 'November 2026',
    'image'  => 'MyCertificate.png',
],
```

Project (`projects` block). The first image is the card's thumbnail and is the one shown first. With more than one image, the card also gets a hover slideshow and an image count. An optional `thumb` line picks a different thumbnail:

```php
'images' => ['MyProject/Landing.png', 'MyProject/Dashboard.png'],
'thumb'  => 'MyProject/Landing.png',
```

The files for that example go in `assets/img/projects/MyProject/`. Use `/` between folder and file names, never `\`.

**Replace a picture**

- Overwrite the file with a new one that has the **same name**, or
- add the new file and change the name in its entry in `data/content.php`.

After replacing, hard refresh the site with **Ctrl + Shift + R** so the browser does not show the old picture.

**Remove a picture**

Delete its entry in `data/content.php` first, then delete the file. If you delete only the file, the site shows an empty placeholder in its place.

### Styles and scripts

|To change|To edit|
|---|---|
| Fonts, colors, text sizes, page width | the top of `assets/css/style.css` |
| Carousel size, blur and fading | `assets/css/style.css` (search for `Depth-of-field`) and `assets/js/app.js` (search for `VISUAL CONTENT`) |
| Intro animation timing | `assets/css/style.css` (search for `intro`) |

To use a different font, change `--font-head` or `--font-body` at the top of `style.css` and the Google Fonts link in the `<head>` of `index.php`.

## Author

**Marcux Andrei C. Mallari**

- GitHub: [MarcuxAndreiMallari](https://github.com/MarcuxAndreiMallari)
- LinkedIn: [marcux-andrei-mallari](https://www.linkedin.com/in/marcux-andrei-mallari)
