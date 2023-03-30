function googleTranslateElementInit() {
    //setCookie('googtrans', '/en/en',1);
    new google.translate.TranslateElement(
      {
        includedLanguages: "en,hi",
      },
      "google_translate_element"
    );
  }
  jQuery(document).ready(function ($) {
    console.log($(".external_link").find("a"));
  
    function setCookie(key, value, expiry) {
      // var expires = new Date();
      // expires.setTime(expires.getTime() + expiry * 24 * 60 * 60 * 1000);
      // document.cookie =
      //   key +
      //   "=" +
      //   value +
      //   "; path=/wp-content/plugins/seqfast-plugin/googletrans ; expires=" +
      //   "; tagname = test;secure";
  
          //  $.cookie(key,value,{
          //     expires: 1,
          //     path: "/wp-content/plugins/seqfast-plugin/googletrans",
          //     secure: true,
          //  });
  
  
          if (expiry === 0) {
            expiry = '';
          } else {
              var d = new Date();
              d.setTime(d.getTime() + (expiry * 24 * 60 * 60 * 1000));
              expiry = "expires=" + d.toGMTString();
          }
  
          var  path = '/wp-content/plugins/seqfast-plugin/googletrans;'
          var domain = (typeof domain === "undefined") ? '' : "; domain="+domain;
          document.cookie = key + "=" + value + "; " + expiry + "path=" + path + domain;
  
  
    }
  
    function readCookie(name) {
      
      var c = document.cookie.split("; "),
        cookies = {},
        i,
        C;
  
  
      for (i = c.length - 1; i >= 0; i--) {
        C = c[i].split("=");
        cookies[C[0]] = C[1];
      }
      return cookies[name];
    }
  
    let cookietextdata = readCookie("googtrans");
  
    if (cookietextdata != null) {
      let arrayData = cookietextdata.split("/");
      console.log(arrayData);
      if (arrayData[2] == "hi") {
        // $('#titledata').('title', '');
        $(".english").css("display", "block");
        $(".hindi").css("display", "none");
      }
  
      if (arrayData[2] == "en") {
        $(".hindi").css("display", "block");
        $(".english").css("display", "none");
      }
    } else {
      setCookie("googtrans", "/auto/en", 1);
    }
  
    $(".changeLanguageByButtonClick").on("click", function () {
      var language = $(this).attr("data-lang");
  
      console.log(language);
  
      if (language == "hi") {
        $(".english").css("display", "block");
        $(".hindi").css("display", "none");
      }
      if (language == "en") {
        $(".hindi").css("display", "block");
        $(".english").css("display", "none");
      }
  
      var selectField = document.querySelector(
        "#google_translate_element select"
      );
      console.log(selectField);
  
      // if (language == 'hi') {
      //     $.cookie('googtrans','/auto/hi',{
      //         expires: 1,
      //     });
      // }
  
      // if (language == 'en') {
      //     $.cookie('googtrans','/auto/en',{
      //         expires: 1,
      //     });
  
      // }
  
      for (var i = 0; i < selectField.children.length; i++) {
        var option = selectField.children[i];
        // find desired langauge and change the former language of the hidden selection-field
        if (option.value == language) {
          selectField.selectedIndex = i;
          // trigger change event afterwards to make google-lib translate this side
          selectField.dispatchEvent(new Event("change"));
          // setCookie("googtrans",settingValue,1);
  
          //     if (language == 'hi') {
          //   $.cookie('googtrans','/auto/hi',{
          //       expires: 1,
          //   });
          // }
  
          // if (language == "en") {
          //   setCookie('googtrans', '/en/en', 0, '.viajoasalta.com');
          //   setCookie('googtrans', '', 0, '/');
          //   location.reload();
          // }
  
          //location.reload();
          break;
        }
      }
    });
  
    $.fn.getStyleObject = function () {
      var dom = this.get(0);
      var style;
      var returns = {};
      if (window.getComputedStyle) {
        var camelize = function (a, b) {
          return b.toUpperCase();
        };
        style = window.getComputedStyle(dom, null);
        for (var i = 0, l = style.length; i < l; i++) {
          var prop = style[i];
          var camel = prop.replace(/\-([a-z])/g, camelize);
          var val = style.getPropertyValue(prop);
          returns[camel] = val;
        }
        return returns;
      }
      if ((style = dom.currentStyle)) {
        for (var prop in style) {
          returns[prop] = style[prop];
        }
        return returns;
      }
      return this.css();
    };
  
    $("#btnPrint").click(function () {
      $("#wpadminbar").addClass("print");
      $("#main-header").addClass("print");
      $("img").addClass("print");
      $(".whats-new-bx").addClass("print");
      $(".a2a_modal").addClass("print");
      //$(".bx-3").addClass('no-print');
  
      $(".breadcrumb").addClass("print");
  
      $("#et_top_search").addClass("print");
      $(".a2a_default_style").addClass("print");
      $(".fluid-width-video-wrapper").addClass("print");
      $("#extModal").addClass("print");
      $(".wp-tsas-popup-wrp").addClass("print");
      $("#a2a_share_save_widget-2").addClass("print");
      $(".et_pb_video").addClass("print");
      $(".wp-video").addClass("print");
  
      var contents = $("body").clone();
      $(contents).removeAttr("svg");
      //console.log(contents.);
      //$(".breadcrumb").addClass('print');
      //   console.log(contents.html());
      contents.find(".breadcrumb").addClass("print");
  
      var frame1 = $("<iframe />");
      console.log(frame1);
      frame1[0].name = "frame1";
      frame1.css({ position: "absolute", top: "-1000000px" });
      $("body").append(frame1);
      var frameDoc = frame1[0].contentWindow
        ? frame1[0].contentWindow
        : frame1[0].contentDocument.document
        ? frame1[0].contentDocument.document
        : frame1[0].contentDocument;
      frameDoc.document.open();
      //Create a new HTML document.
      frameDoc.document.write(
        "<html><head><title>NCVET – National Council for Vocational Education and Training</title>"
      );
      frameDoc.document.write("</head><body>");
      var cssUrl = $("#print_css_id").attr("data-value");
      frameDoc.document.write(
        '<link href="' + cssUrl + '" rel="stylesheet" type="text/css" />'
      );
      frameDoc.document.write(contents.html());
      frameDoc.document.write("</body></html>");
      frameDoc.document.close();
      setTimeout(function () {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        frame1.remove();
      }, 1000);
    });
  });
  
  //Font Change Jquery
  jQuery(document).ready(function ($) {
    //font Increment
    let count = 0;
    let fontCount = 0;
    //var $affectedElements = $("body,p,li,td,div,span");
    var $affectedElements = $(
      "body,div,span,font,p,h1, h2, h3, h4, h5, h6,td,li"
    );
    //REMOVE achor tag in afftectedElements
    $affectedElements.each(function () {
      var $this = $(this);
      $this.data("orig-size", $this.css("font-size"));
    });
  
    function changeFontSize(direction) {
      $affectedElements.each(function () {
        var $this = $(this);
        $this.css("font-size", parseInt($this.css("font-size")) + direction);
      });
    }
  
    $(".fontIncre").on("click", function () {
      if (localStorage.count < 2) {
        localStorage.count = ++count;
  
        // if (localStorage.count == 0) {
        //     ResizeActualFont();
        // }
  
        $.cookie("Resize", "FontIncre", {
          expires: 1,
          path: "/wp-content/plugins/seqfast-plugin;SameSite=Lax",
          secure: true,
        });
  
        if (localStorage.count == 1) {
          ResizeActualFont();
          changeFontSize(1);
        }
  
        if (localStorage.count != 1) {
          changeFontSize(1);
        }
  
        // changeFontSize(1);
      }
    });
  
    //font decrement
    $(".fontdecre").on("click", function () {
      if (localStorage.count > -2) {
        localStorage.count = --count;
  
        // if (localStorage.count == 0) {
        //     ResizeActualFont();
        // }
  
        $.cookie("Resize", "FontDecre", {
          expires: 1,
          path: "/wp-content/plugins/seqfast-plugin;SameSite=Lax",
          secure: true,
        });
  
        changeFontSize(-1);
      }
    });
  
    //font Acutal Size
  
    $(".fontActual").on("click", function () {
      count = 0;
  
      localStorage.count = count;
      ResizeActualFont();
  
      $.cookie("Resize", "Original", {
        expires: 1,
        path: "/wp-content/plugins/seqfast-plugin;SameSite=Lax",
        secure: true,
      });
    });
  
    function ResizeActualFont() {
      $affectedElements.each(function () {
        var $this = $(this);
        $this.css("font-size", $this.data("orig-size"));
      });
    }
  
    let cookieDataDiv = $.cookie("Resize");
  
    if (cookieDataDiv != null) {
      if (cookieDataDiv == "Original") {
        ResizeActualFont();
      }
  
      if (cookieDataDiv == "FontDecre") {
        let DescVal = "";
        if (localStorage.count == -2) {
          DescVal = 2;
        }
        if (localStorage.count == -1) {
          DescVal = 1;
        }
        if (localStorage.count == 0) {
          ResizeActualFont();
        }
  
        if (localStorage.count == 1) {
          ResizeActualFont();
          changeFontSize(1);
        }
  
        if (DescVal > 0) {
          ResizeActualFont();
          for (let index = 0; index < DescVal; ++index) {
            changeFontSize(-1);
          }
        }
      }
  
      if (cookieDataDiv == "FontIncre") {
        let AddVal = "";
        if (localStorage.count == 2) {
          AddVal = 2;
        }
        if (localStorage.count == 1) {
          AddVal = 1;
        }
        if (localStorage.count == 0) {
          ResizeActualFont();
        }
  
        if (localStorage.count == -1) {
          ResizeActualFont();
          changeFontSize(-1);
        }
  
        if (AddVal > 0) {
          // $(window).load(function() {
          ResizeActualFont();
          for (let index = 0; index < AddVal; index++) {
            changeFontSize(1);
          }
          // });
        }
      }
    } else {
      localStorage.count = count;
      $.cookie("Resize", "Original", {
        expires: 1,
        path: "/wp-content/plugins/seqfast-plugin;SameSite=Lax",
        secure: true,
      });
    }
  });
  
  jQuery(document).ready(function ($) {
    $(document).on("click", ".contact_sector_data", function () {
      let SkillSectorId = $(this).attr("data-id");
      // alert(SkillSectorId);
      // alert(skillSector_object.ajax_url);
  
      $.ajax({
        url: skillSector_object.ajax_url, // this is the object instantiated in wp_localize_script function
        type: "post",
        data: {
          action: "so_wp_ajax",
          id: SkillSectorId,
        },
        success: function (response) {
          //Do something with the result from server
          var result = jQuery.parseJSON(response);
          if (result.code == 200) {
            let html = "";
            if (result.msg.length > 0) {
              for (let index = 0; index < result.msg.length; index++) {
                html += `
                                  <div>
                                      <label>Name :</label>
                                      <span>${result.msg[index].name}</span>
                                  </div>
                                  <div>
                                      <label>Email :</label>
                                      <span>${result.msg[index].email}</span>
                                  </div>
                                 <div>
                                      <label>Contact Number :</label>
                                      <span>${result.msg[index].contact_no}</span>
                                  </div>
                                 <div>
                                      <label>Address :</label>
                                      <span>${result.msg[index].address}</span>
                                  </div>
                                 `;
              }
            }
            $(".sectorTableContact").html(html);
          }
  
          $("body").addClass("modalon");
  
          let css_property = {
            display: "block",
          };
          $("#sector_contact").css(css_property);
        },
      });
    });
  
    $(document).on("click", ".CloseContact", function () {
      $("#sector_contact").css("display", "none");
      $("body").removeClass("modalon");
    });
  });
  