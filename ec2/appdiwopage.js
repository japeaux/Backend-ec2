
(function() {
  var app = {
    launchApp: function() {
      window.location.replace("appdiwo://");
      this.timer = setTimeout(this.openWebApp, 1000);
    },

    openWebApp: function() {
      window.location.replace("https://play.google.com/store/apps/details?id=com.ionicframework.invitta391892");
    }
  };

  app.launchApp();
})();


