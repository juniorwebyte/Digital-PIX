/**
 *
 * Players
 *
 * Interface.Plugins.Player page content scripts. Initialized from scripts.js file.
 *
 *
 */

class Players {
  constructor() {
    // Initialization of the page plugins
    if (typeof Plyr === 'undefined') {
      console.log('notify is null!');
      return;
    }

    this._initPlayer();
    this._initModal();
  }

  // Basic class initialization of players
  _initPlayer() {
    document.querySelectorAll('.player').forEach((el) => {
      new Plyr(el);
    });
  }

  // Video in a modal
  _initModal() {
    const modalVideo = new Plyr('#modalVideo');
    var myModalEl = document.getElementById('videoPlayerModal');
    if (myModalEl) {
      myModalEl.addEventListener('shown.bs.modal', function (event) {
        modalVideo.play();
      });
      myModalEl.addEventListener('hidden.bs.modal', function (event) {
        modalVideo.pause();
      });
    }
  }
}
