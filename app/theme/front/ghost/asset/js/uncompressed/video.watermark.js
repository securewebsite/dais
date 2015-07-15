(function() {
  var defaults = {
        file: 'watermark.png',
        xpos: 0,
        ypos: 0,
        xrepeat: 0,
        opacity: 0.5,
    },
    extend = function() {
      var args, target, i, object, property;
      args = Array.prototype.slice.call(arguments);
      target = args.shift() || {};
      for (i in args) {
        object = args[i];
        for (property in object) {
          if (object.hasOwnProperty(property)) {
            if (typeof object[property] === 'object') {
              target[property] = extend(target[property], object[property]);
            } else {
              target[property] = object[property];
            }
          }
        }
      }
      return target;
    };

  /**
   * register the thubmnails plugin
   */
  videojs.plugin('watermark', function(options) {
    
    var settings, video, div, img;
    settings = extend(defaults, options);

    /* Grab the necessary DOM elements */
    video = this.el();

    // create the watermark element
    div = document.createElement('div');
    img = document.createElement('img');
    div.appendChild(img);
    div.className = 'vjs-watermark';
    img.className = 'img-responsive';

    img.src = options.file;
    
    if ((options.ypos == 0) && (options.xpos == 0)) { // Top left
      div.style.top = "0";
      div.style.left = "0";
    } else if ((options.ypos == 0) && (options.xpos == 100)) { // Top right
      div.style.top = "0";
      div.style.right = "0";
    } else if ((options.ypos == 100) && (options.xpos == 100)) { // Bottom right
      div.style.bottom = "0";
      div.style.right = "0";
    } else if ((options.ypos == 100) && (options.xpos == 0)) { // Bottom left
      div.style.bottom = "0";
      div.style.left = "0";
    } else if ((options.ypos == 50) && (options.xpos == 50)) { // Center
      div.style.top = (this.height()/2)+"px";
      div.style.left = (this.width()/2)+"px";
    }
    
    img.style.opacity = options.opacity;

    // add the watermark to the player
    video.appendChild(div);
  });
})();