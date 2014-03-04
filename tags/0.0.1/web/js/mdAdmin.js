// Preload images
imageObj = new Image();
imgs = ["/images/toggle.gif", "/images/ajaxLoader.gif", "/images/prev.gif", "/images/next.gif"];
for (i = 0; i < imgs.length; i++) imageObj.src = imgs[i];

  // Administry object setup
  if (!Administry) var Administry = {}

  // scrollToTop() - scroll window to the top
  Administry.scrollToTop = function (e) {
      $(e).hide().removeAttr("href");
      if ($(window).scrollTop() != "0") {
          $(e).fadeIn("slow")
      }
      var scrollDiv = $(e);
      $(window).scroll(function () {
          if ($(window).scrollTop() == "0") {
              $(scrollDiv).fadeOut("slow")
          } else {
              $(scrollDiv).fadeIn("slow")
          }
      });
      $(e).click(function () {
          $("html, body").animate({
              scrollTop: 0
          }, "slow")
      })
  }

  // setup() - Administry init and setup
  Administry.setup = function () {
      // Open an external link in a new window
      $('a[href^="http://"]').filter(function () {
          return this.hostname && this.hostname !== location.hostname;
      }).attr('target', '_blank');

      // build animated dropdown navigation
          $('#menu ul').supersubs({ 
                  minWidth:    12,   // minimum width of sub-menus in em units 
                  maxWidth:    27,   // maximum width of sub-menus in em units 
                  extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
                                                     // due to slight rounding differences and font-family 
          }).superfish(); 

      // build an animated footer
      $('#animated').each(function () {
          $(this).hover(function () {
              $(this).stop().animate({
                  opacity: 0.9
              }, 400);
          }, function () {
              $(this).stop().animate({
                  opacity: 0.0
              }, 200);
          });
      });

      // scroll to top on request
      if ($("a#totop").length) Administry.scrollToTop("a#totop");

      // setup content boxes
      if ($(".content-box").length) {
          $(".content-box header").css({
              "cursor": "s-resize"
          });
          // Give the header in content-box a different cursor	
          $(".content-box header").click(
          function () {
              $(this).parent().find('section').toggle(); // Toggle the content
              $(this).parent().toggleClass("content-box-closed"); // Toggle the class "content-box-closed" on the content
          });
      }
      
      // custom tooltips to replace the default browser tooltips for <a title=""> <div title=""> and <span title="">
      //$("a[title], div[title], span[title]").tipTip();
  }

  // expandableRows() - expandable table rows
  Administry.expandableRows = function () {
      var titles_total = $('td.title').length;
      if (titles_total) { /* setting z-index for IE7 */
          $('td.title').each(function (i, e) {
              $(e).children('div').css('z-index', String(titles_total - i));
          });

          $('td.title').find('a').click(function () {
              // hide previously opened containers
              $('.opened').hide();
              // remove highlighted class from rows
              $('td.highlighted').removeClass('highlighted');

              // locate the row we clicked onto
              var tr = $(this).parents("tr");
              var div = $(this).parent().find('.listingDetails');

              if (!$(div).hasClass('opened')) {
                  $(div).addClass('opened').width($(tr).width() - 2).show();
                  $(tr).find('td').addClass('highlighted');
              } else {
                  $(div).removeClass('opened');
                  $(tr).find('td').removeClass('highlighted');
              }
              return false;
          });
      }
  }
