/**
 *
 * Lightbox
 *
 * Interface.Plugins.Lightbox page content scripts. Initialized from scripts.js file.
 *
 *
 */

class Lightbox {
  constructor() {
    // Initialization of the page plugins
    if (typeof baguetteBox !== 'undefined') {
      this._initLightboxes();
    } else {
      console.error('[CS] baguetteBox is undefined.');
    }
  }

  // Lightboxes initialize
  _initLightboxes() {
    baguetteBox.run('.gallery');
    baguetteBox.run('.lightbox');
    baguetteBox.run('.gallery-fadeIn', {animation: 'fadeIn'});
  }
}
