/**
 *
 * Carousels
 *
 * Interface.Plugins.Carousel page content scripts. Initialized from scripts.js file.
 *
 *
 */

class Carousels {
  constructor() {
    // Initialization of the page plugins
    if (typeof GlideCustom === 'undefined') {
      console.log('GlideCustom is undefined!');
      return;
    }
    this._initBasicCarousel();
    this._initNoControls();
    this._initCenter();
    this._initSingle();
    this._initSmall();
    this._initAuto();
    this._initFlow();
    this._initGallery();
    this._initBoxedGallery();
    this._initHalfBoxedGallery();
  }

  // Basic carousel
  _initBasicCarousel() {
    if (document.querySelector('#glideBasic')) {
      new GlideCustom(
        document.querySelector('#glideBasic'),
        {
          gap: 0,
          rewind: false,
          bound: true,
          perView: 6,
          breakpoints: {
            400: {perView: 1},
            1000: {perView: 2},
            1400: {perView: 3},
            1900: {perView: 5},
            3840: {perView: 6},
          },
        },
        true,
      ).mount();
    }
  }

  // Basic carousel without controls
  _initNoControls() {
    if (document.querySelector('#glideNoControls')) {
      new GlideCustom(
        document.querySelector('#glideNoControls'),
        {
          gap: 0,
          rewind: false,
          bound: true,
          perView: 6,
          breakpoints: {
            400: {perView: 1},
            1000: {perView: 2},
            1400: {perView: 3},
            1900: {perView: 5},
            3840: {perView: 6},
          },
        },
        true,
      ).mount();
    }
  }

  // Peek carousel
  _initCenter() {
    if (document.querySelector('#glideCenter')) {
      new GlideCustom(
        document.querySelector('#glideCenter'),
        {
          gap: 0,
          type: 'carousel',
          perView: 6,
          peek: {before: 50, after: 50},
          breakpoints: {
            600: {perView: 1},
            1000: {perView: 2},
            1400: {perView: 3},
            1900: {perView: 5},
            3840: {perView: 6},
          },
        },
        true,
      ).mount();
    }
  }

  // Single item carousel
  _initSingle() {
    if (document.querySelector('#glideSingle')) {
      new GlideCustom(
        document.querySelector('#glideSingle'),
        {
          gap: 0,
          perView: 1,
        },
        true,
      ).mount();
    }
  }

  // Carousel with small gutters. Working via "row gx-2" class.
  _initSmall() {
    if (document.querySelector('#glideSmall')) {
      new GlideCustom(
        document.querySelector('#glideSmall'),
        {
          gap: 0,
          rewind: false,
          bound: true,
          perView: 6,
          breakpoints: {
            400: {perView: 1},
            600: {perView: 2},
            1400: {perView: 3},
            1600: {perView: 4},
            1900: {perView: 5},
            3840: {perView: 6},
          },
        },
        true,
      ).mount();
    }
  }

  // Auto play carousel
  _initAuto() {
    if (document.querySelector('#glideAuto')) {
      new GlideCustom(
        document.querySelector('#glideAuto'),
        {
          gap: 0,
          rewind: false,
          type: 'carousel',
          autoplay: 1000,
          perView: 6,
          breakpoints: {
            400: {perView: 1},
            600: {perView: 2},
            1400: {perView: 3},
            1600: {perView: 4},
            1900: {perView: 5},
            3840: {perView: 6},
          },
        },
        true,
      ).mount();
    }
  }

  // Auto flow carousel
  _initFlow() {
    if (document.querySelector('#glideFlow')) {
      new GlideCustom(
        document.querySelector('#glideFlow'),
        {
          gap: 0,
          rewind: false,
          type: 'carousel',
          autoplay: 3000,
          hoverpause: false,
          animationDuration: 3000,
          animationTimingFunc: 'linear',
          perView: 8,
          breakpoints: {
            400: {perView: 1},
            600: {perView: 3},
            1400: {perView: 4},
            1600: {perView: 5},
            1900: {perView: 6},
            3840: {perView: 8},
          },
        },
        true,
      ).mount();
    }
  }

  // Gallery boxed in a card
  _initBoxedGallery() {
    if (document.querySelector('#glideGalleryBoxed')) {
      const el = document.querySelector('#glideGalleryBoxed');
      const glideLength = el.querySelector('.glide-large .glide__slides').children.length;
      const perView = Math.min(5, glideLength);
      new GlideGallery(
        el.querySelector('.glide-large'),
        el.querySelector('.glide-thumb'),
        {
          bound: true,
          rewind: false,
          focusAt: 0,
          perView: 1,
          startAt: 0,
        },
        {
          bound: true,
          rewind: false,
          perView: perView,
          perTouch: 1,
          focusAt: 0,
          startAt: 0,
          breakpoints: {
            1600: {
              perView: Math.min(4, glideLength),
            },
            576: {
              perView: Math.min(3, glideLength),
            },
            420: {
              perView: Math.min(2, glideLength),
            },
          },
        },
        glideLength,
        perView,
        70,
      );
    }
  }

  // Gallery boxed in a card with card image style
  _initHalfBoxedGallery() {
    if (document.querySelector('#glideGalleryHalfBoxed')) {
      const el = document.querySelector('#glideGalleryHalfBoxed');
      const glideLength = el.querySelector('.glide-large .glide__slides').children.length;
      const perView = Math.min(5, glideLength);
      new GlideGallery(
        el.querySelector('.glide-large'),
        el.querySelector('.glide-thumb'),
        {
          bound: true,
          rewind: false,
          focusAt: 0,
          perView: 1,
          startAt: 0,
        },
        {
          bound: true,
          rewind: false,
          perView: perView,
          perTouch: 1,
          focusAt: 0,
          startAt: 0,
          breakpoints: {
            1600: {
              perView: Math.min(4, glideLength),
            },
            576: {
              perView: Math.min(3, glideLength),
            },
            420: {
              perView: Math.min(2, glideLength),
            },
          },
        },
        glideLength,
        perView,
        70,
      );
    }
  }

  // Overlay gallery
  _initGallery() {
    if (document.querySelector('#glideGallery')) {
      const el = document.querySelector('#glideGallery');
      const glideLength = el.querySelector('.glide-large .glide__slides').children.length;
      const perView = Math.min(5, glideLength);
      new GlideGallery(
        el.querySelector('.glide-large'),
        el.querySelector('.glide-thumb'),
        {
          bound: true,
          rewind: false,
          focusAt: 0,
          perView: 1,
          startAt: 0,
        },
        {
          bound: true,
          rewind: false,
          perView: perView,
          perTouch: 1,
          focusAt: 0,
          startAt: 0,
          breakpoints: {
            1600: {
              perView: Math.min(4, glideLength),
            },
            576: {
              perView: Math.min(3, glideLength),
            },
            420: {
              perView: Math.min(2, glideLength),
            },
          },
        },
        glideLength,
        perView,
        70,
      );
    }
  }
}
