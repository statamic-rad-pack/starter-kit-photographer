<!-- statamic:hide --><p align="center"><img src="https://statamic.com/assets/branding/Statamic-Logo-Rad.png" width="100" alt="Statamic Logo" /></p>
<h1 align="center">
    Statamic Starter Kit: Photography
</h1>
<!-- /statamic:hide -->

## Features
- Galleries collection to show off your work
- Private galleries to share photo-sessions with your clients
- Categorize your galleries with the categories taxonomy
- Interactive categories filter linking to the taxonomy term page
- Responsive images for fast load times
- Page builder with blocks for galleries, bio, forms, and more
- Pricing cards
- Inquiry form
- Clean & modern design
- Beautifully responsive
- Built with [Livewire](https://livewire.laravel.com/), [Alpine.js](https://github.com/alpinejs/alpine), and [TailwindCSS](https://tailwindcss.com)

### Private Galleries
- Password protection
- Download and like individual images
- Download a zip of all images or a selection of thereof
- Zoom

## Quick Start

### 1. Create a new site

You can create a new site using the [Statamic CLI Tool](https://github.com/statamic/cli):

```
statamic new your-site statamic-rad-pack/starter-kit-photography
```

Or you can install manually into a fresh [Statamic installation](https://statamic.dev/installation) by running:

```
php please starter-kit:install statamic-rad-pack/starter-kit-photography --clear-site
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

## Contributing

Contributions are always welcome, no matter how large or small. Before contributing, please read the [code of conduct](https://github.com/statamic/cms/wiki/Code-of-Conduct).
