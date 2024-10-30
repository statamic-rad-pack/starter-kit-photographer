<!-- statamic:hide --><p align="center"><img src="https://statamic.com/assets/branding/Statamic-Logo-Rad.png" width="100" alt="Statamic Logo" /></p>
<h1 align="center">
    Statamic Starter Kit: Photographer
</h1>
<!-- /statamic:hide -->

## Features
- Show your work with the galleries collection
- Share photos with private galleries
- Categorize galleries with the categories taxonomy
- Interactive categories filter linking to the taxonomy term page
- Responsive and lazy-loaded images for fast load times
- Build trust with client testimonials
- Page builder with blocks for galleries, bio, testimonials, forms, and more
- Pricing cards
- Inquiry form
- Clean & modern design
- Beautifully responsive
- Built with [Livewire](https://livewire.laravel.com/), [Alpine.js](https://github.com/alpinejs/alpine), and [TailwindCSS](https://tailwindcss.com)

### Private Galleries
- Password protection with gallery-aware login page
- Image processing with options for watermark and low-res images
- Download and like individual images
- Download a zip of all images or a selection thereof
- Gallery zoom

## Quick Start

### 1. Create a new site

You can create a new site using the [Statamic CLI Tool](https://github.com/statamic/cli):

```
statamic new your-site statamic-rad-pack/starter-kit-photographer
```

Or you can install manually into a fresh [Statamic installation](https://statamic.dev/installation) by running:

```
php please starter-kit:install statamic-rad-pack/starter-kit-photographer --clear-site
```

### 2. Make a new user

The above installers should prompt you to make a user, but you can also run `php please make:user`. You'll want it to be a `super` so you have access to everything.

### 3. Recompile the CSS and JS (optional)

This starter kit comes with precompiled CSS and JS. If you want to modify anything, just recompile it.

```
npm i && npm run dev
```

To compile for production again:

```
npm run build
```

### 4. Do your thing!

If you're using [Laravel Herd](https://herd.laravel.com/) (or similar), your site should be available at `http://your-site.test`. You can access the control panel at `http://your-site.test/cp` and login with your new user. Open up the source code, follow along with the [Statamic docs](https://statamic.dev), and enjoy!

## Image Processing Guidelines

Depending on how you use this site, you may find yourself process a _lot_ of images. It uses Spatie's [Responsive Images](https://statamic.com/addons/spatie/responsive-images) addon to generate multiple image variations to optimize load time for your visitors.

Resizing images is very memory intensive, and so we'd like to make a few recommendations for the smoothest experience possible:

- We highly recommend using a [Queue](https://laravel.com/docs/queues) to process the images and reduce the amount of work done in any single request. [Laravel Horizon](https://laravel.com/docs/11.x/horizon) makes this very easy, especially if you're using Laravel Forge to manage your server.
- Down-sample your images before uploading into public galleries — if possible. Setting the width to `1200px` will ensure that they're never bigger than they need to be, thus reducing the memory needed to resize.
- You can generate less (or more if you prefer) responsive image variations by editing the `config/statamic/responsive-images/dimension_calculator_threshold` setting. The higher the number, the more variations you'll generate for each image.
- We recommend having at least 2GB of memory on your server, and be sure to allocate it to php by updating your php.ini file (or equivalent).

## Credit

This Starter Kit was commissioned by the Statamic Team and designed/hand-built by [Michael Aerni](https://statamic.com/partners/michael-aerni). He went not just the extra mile, but two.

## Contributing

Contributions are always welcome, no matter how large or small. Before contributing, please read the [code of conduct](https://github.com/statamic/cms/wiki/Code-of-Conduct).
