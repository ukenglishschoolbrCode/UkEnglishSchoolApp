(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);throw new Error("Cannot find module '"+o+"'")}var f=n[o]={exports:{}};t[o][0].call(f.exports,function(e){var n=t[o][1][e];return s(n?n:e)},f,f.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

(function ($) {
  $(document).ready(function () {
    $('[data-vue]').each(function () {
      var $this = $(this);
      var data_var = $this.attr('data-vue');
      var data_source = $this.attr('data-source');
      new Vue({
        el: $(this)[0],
        data: function data() {
          return {
            loading: false,
            data: '',
            settings_alert: {
              status: false,
              success: true
            }
          };
        },
        mounted: function mounted() {
          this.getSettings();
          this.clearEmptyGroups();
        },
        methods: {
          initSubmenu: function initSubmenu() {
            Vue.nextTick().then(function () {
              (function ($) {
                /*Hide all fields in submenu*/
                var submenu_tab_fields = $('.wpcfto-tab.has-submenu-items [data-field], .wpcfto-tab.has-submenu-items .wpcfto_group_started');
                submenu_tab_fields.css({
                  display: 'none'
                });
                var $sub_menu = $('.wpcfto-submenus .active');
                var sub_menu_section = $sub_menu.attr('data-submenu');
                var $submenu_section = $('.' + sub_menu_section);
                $submenu_section.removeAttr('style');
                submenu_tab_fields.parents('.wpcfto_group_started').css({
                  display: 'none'
                });
                $submenu_section.parents('.wpcfto_group_started').removeAttr('style');
              })(jQuery);
            });
          },
          changeTabFromAnchor: function changeTabFromAnchor() {
            var _this = this;

            var hash = window.location.hash;
            var hashParts = hash.split('#');

            if (typeof hashParts[1] !== 'undefined') {
              Vue.nextTick(function () {
                _this.changeTab(hashParts[1]);
              });
            }
          },
          changeTab: function changeTab(tab) {
            var $tab = $('#' + tab);
            $tab.closest('.stm_metaboxes_grid__inner').find('.wpcfto-tab').removeClass('active');
            $tab.addClass('active');
            var $section = $('div[data-section="' + tab + '"]');
            $tab.closest('.wpcfto-settings').find('.wpcfto-nav').removeClass('active');
            $tab.closest('.stm_metaboxes_grid__inner').find('.wpcfto-nav').removeClass('active');
            $section.closest('.wpcfto-nav').addClass('active');
            history.pushState(null, null, '#' + tab);
            /*if has submenu*/

            if ($section.closest('.wpcfto-nav').hasClass('has-submenu')) {
              var $submenu = $section.closest('.wpcfto-nav').find('.wpcfto-submenus [data-submenu]').eq(0);
              this.changeSubMenu($submenu.attr('data-submenu'));
            }
            /*Scroll top*/


            $("html, body").animate({
              scrollTop: $tab.closest('.stm_metaboxes_grid__inner').offset().top - 100
            }, "fast");
          },
          changeSubMenu: function changeSubMenu(sub_menu) {
            var $submenu = $('[data-submenu="' + sub_menu + '"]');
            $('[data-submenu]').removeClass('active');
            $submenu.addClass('active');
            this.initSubmenu();
          },
          getSettings: function getSettings() {
            var _this = this;

            _this.loading = true;
            this.$http.get(stm_wpcfto_ajaxurl + '?action=stm_wpcfto_get_settings&source=' + data_source + '&name=' + data_var + '&nonce=' + wpcfto_global_settings['nonce']).then(function (r) {
              _this.$set(_this, 'data', r.body);

              _this.loading = false;
              this.changeTabFromAnchor();
              this.initSubmenu();
            });
          },
          saveSettings: function saveSettings(id) {
            var vm = this;
            vm.loading = true;
            this.$http.post(stm_wpcfto_ajaxurl + '?action=wpcfto_save_settings&nonce=' + stm_wpcfto_nonces['wpcfto_save_settings'] + '&name=' + id, JSON.stringify(vm.data)).then(function (response) {
              var _response$body;

              vm.loading = false;
              vm.settings_alert = {
                success: response.status === 200,
                status: true
              };
              setTimeout(function () {
                vm.settings_alert.status = false;
              }, 1500);
              if (((_response$body = response.body) === null || _response$body === void 0 ? void 0 : _response$body.reload) === true) location.reload();
            });
          },
          initOpen: function initOpen(field) {
            if (typeof field.opened === 'undefined') {
              this.$set(field, 'opened', !!field.value);
            }
          },
          openField: function openField(field) {
            var opened = !field.opened;
            this.$set(field, 'opened', opened);

            if (!field.opened) {
              this.$set(field, 'value', '');
            }
          },
          enableAddon: function enableAddon($event, option) {
            var _this = this;

            Vue.nextTick(function () {
              (function ($) {
                var currentItem = $($event.target);
                currentItem.addClass('loading');
                var url = stm_wpcfto_ajaxurl + '?action=stm_lms_enable_addon&addon=' + option;

                _this.$http.get(url).then(function (response) {
                  currentItem.removeClass('loading');
                  var $container = $('.stm_lms_addon_group_settings_' + option);
                  $container.each(function () {
                    var $this = $(this);
                    $this.removeClass('is_pro is_pro_in_addon');
                    $this.find('.field_overlay').remove();
                    $this.find('.pro-notice').remove();
                  });
                });
              })(jQuery);
            });
          },
          clearEmptyGroups: function clearEmptyGroups() {
            Vue.nextTick().then(function () {
              (function ($) {
                $('.wpcfto_group_started').each(function () {
                  var $group = $(this);
                  var $childs = $group.find('.wpcfto-box-child');

                  if (!$childs.length) {
                    $group.addClass('no-childs-visible');
                  } else {
                    $group.removeClass('no-childs-visible');
                  }
                });
              })(jQuery);
            });
          }
        },
        watch: {
          data: {
            deep: true,
            handler: function handler() {
              var _this = this;

              setTimeout(function () {
                _this.clearEmptyGroups();

                _this.initSubmenu();
              }, 100);
            }
          }
        }
      });
    });
  });
})(jQuery);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsImVhY2giLCIkdGhpcyIsImRhdGFfdmFyIiwiYXR0ciIsImRhdGFfc291cmNlIiwiVnVlIiwiZWwiLCJkYXRhIiwibG9hZGluZyIsInNldHRpbmdzX2FsZXJ0Iiwic3RhdHVzIiwic3VjY2VzcyIsIm1vdW50ZWQiLCJnZXRTZXR0aW5ncyIsImNsZWFyRW1wdHlHcm91cHMiLCJtZXRob2RzIiwiaW5pdFN1Ym1lbnUiLCJuZXh0VGljayIsInRoZW4iLCJzdWJtZW51X3RhYl9maWVsZHMiLCJjc3MiLCJkaXNwbGF5IiwiJHN1Yl9tZW51Iiwic3ViX21lbnVfc2VjdGlvbiIsIiRzdWJtZW51X3NlY3Rpb24iLCJyZW1vdmVBdHRyIiwicGFyZW50cyIsImpRdWVyeSIsImNoYW5nZVRhYkZyb21BbmNob3IiLCJfdGhpcyIsImhhc2giLCJ3aW5kb3ciLCJsb2NhdGlvbiIsImhhc2hQYXJ0cyIsInNwbGl0IiwiY2hhbmdlVGFiIiwidGFiIiwiJHRhYiIsImNsb3Nlc3QiLCJmaW5kIiwicmVtb3ZlQ2xhc3MiLCJhZGRDbGFzcyIsIiRzZWN0aW9uIiwiaGlzdG9yeSIsInB1c2hTdGF0ZSIsImhhc0NsYXNzIiwiJHN1Ym1lbnUiLCJlcSIsImNoYW5nZVN1Yk1lbnUiLCJhbmltYXRlIiwic2Nyb2xsVG9wIiwib2Zmc2V0IiwidG9wIiwic3ViX21lbnUiLCIkaHR0cCIsImdldCIsInN0bV93cGNmdG9fYWpheHVybCIsInIiLCIkc2V0IiwiYm9keSIsInNhdmVTZXR0aW5ncyIsImlkIiwidm0iLCJwb3N0Iiwic3RtX3dwY2Z0b19ub25jZXMiLCJKU09OIiwic3RyaW5naWZ5IiwicmVzcG9uc2UiLCJfcmVzcG9uc2UkYm9keSIsInNldFRpbWVvdXQiLCJyZWxvYWQiLCJpbml0T3BlbiIsImZpZWxkIiwib3BlbmVkIiwidmFsdWUiLCJvcGVuRmllbGQiLCJlbmFibGVBZGRvbiIsIiRldmVudCIsIm9wdGlvbiIsImN1cnJlbnRJdGVtIiwidGFyZ2V0IiwidXJsIiwiJGNvbnRhaW5lciIsInJlbW92ZSIsIiRncm91cCIsIiRjaGlsZHMiLCJsZW5ndGgiLCJ3YXRjaCIsImRlZXAiLCJoYW5kbGVyIl0sInNvdXJjZXMiOlsiZmFrZV83ZGM4MWZlOC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcblxuKGZ1bmN0aW9uICgkKSB7XG4gICQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uICgpIHtcbiAgICAkKCdbZGF0YS12dWVdJykuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xuICAgICAgdmFyIGRhdGFfdmFyID0gJHRoaXMuYXR0cignZGF0YS12dWUnKTtcbiAgICAgIHZhciBkYXRhX3NvdXJjZSA9ICR0aGlzLmF0dHIoJ2RhdGEtc291cmNlJyk7XG4gICAgICBuZXcgVnVlKHtcbiAgICAgICAgZWw6ICQodGhpcylbMF0sXG4gICAgICAgIGRhdGE6IGZ1bmN0aW9uIGRhdGEoKSB7XG4gICAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgIGxvYWRpbmc6IGZhbHNlLFxuICAgICAgICAgICAgZGF0YTogJycsXG4gICAgICAgICAgICBzZXR0aW5nc19hbGVydDoge1xuICAgICAgICAgICAgICBzdGF0dXM6IGZhbHNlLFxuICAgICAgICAgICAgICBzdWNjZXNzOiB0cnVlXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfTtcbiAgICAgICAgfSxcbiAgICAgICAgbW91bnRlZDogZnVuY3Rpb24gbW91bnRlZCgpIHtcbiAgICAgICAgICB0aGlzLmdldFNldHRpbmdzKCk7XG4gICAgICAgICAgdGhpcy5jbGVhckVtcHR5R3JvdXBzKCk7XG4gICAgICAgIH0sXG4gICAgICAgIG1ldGhvZHM6IHtcbiAgICAgICAgICBpbml0U3VibWVudTogZnVuY3Rpb24gaW5pdFN1Ym1lbnUoKSB7XG4gICAgICAgICAgICBWdWUubmV4dFRpY2soKS50aGVuKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgKGZ1bmN0aW9uICgkKSB7XG4gICAgICAgICAgICAgICAgLypIaWRlIGFsbCBmaWVsZHMgaW4gc3VibWVudSovXG4gICAgICAgICAgICAgICAgdmFyIHN1Ym1lbnVfdGFiX2ZpZWxkcyA9ICQoJy53cGNmdG8tdGFiLmhhcy1zdWJtZW51LWl0ZW1zIFtkYXRhLWZpZWxkXSwgLndwY2Z0by10YWIuaGFzLXN1Ym1lbnUtaXRlbXMgLndwY2Z0b19ncm91cF9zdGFydGVkJyk7XG4gICAgICAgICAgICAgICAgc3VibWVudV90YWJfZmllbGRzLmNzcyh7XG4gICAgICAgICAgICAgICAgICBkaXNwbGF5OiAnbm9uZSdcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICB2YXIgJHN1Yl9tZW51ID0gJCgnLndwY2Z0by1zdWJtZW51cyAuYWN0aXZlJyk7XG4gICAgICAgICAgICAgICAgdmFyIHN1Yl9tZW51X3NlY3Rpb24gPSAkc3ViX21lbnUuYXR0cignZGF0YS1zdWJtZW51Jyk7XG4gICAgICAgICAgICAgICAgdmFyICRzdWJtZW51X3NlY3Rpb24gPSAkKCcuJyArIHN1Yl9tZW51X3NlY3Rpb24pO1xuICAgICAgICAgICAgICAgICRzdWJtZW51X3NlY3Rpb24ucmVtb3ZlQXR0cignc3R5bGUnKTtcbiAgICAgICAgICAgICAgICBzdWJtZW51X3RhYl9maWVsZHMucGFyZW50cygnLndwY2Z0b19ncm91cF9zdGFydGVkJykuY3NzKHtcbiAgICAgICAgICAgICAgICAgIGRpc3BsYXk6ICdub25lJ1xuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICRzdWJtZW51X3NlY3Rpb24ucGFyZW50cygnLndwY2Z0b19ncm91cF9zdGFydGVkJykucmVtb3ZlQXR0cignc3R5bGUnKTtcbiAgICAgICAgICAgICAgfSkoalF1ZXJ5KTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgIH0sXG4gICAgICAgICAgY2hhbmdlVGFiRnJvbUFuY2hvcjogZnVuY3Rpb24gY2hhbmdlVGFiRnJvbUFuY2hvcigpIHtcbiAgICAgICAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG5cbiAgICAgICAgICAgIHZhciBoYXNoID0gd2luZG93LmxvY2F0aW9uLmhhc2g7XG4gICAgICAgICAgICB2YXIgaGFzaFBhcnRzID0gaGFzaC5zcGxpdCgnIycpO1xuXG4gICAgICAgICAgICBpZiAodHlwZW9mIGhhc2hQYXJ0c1sxXSAhPT0gJ3VuZGVmaW5lZCcpIHtcbiAgICAgICAgICAgICAgVnVlLm5leHRUaWNrKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICBfdGhpcy5jaGFuZ2VUYWIoaGFzaFBhcnRzWzFdKTtcbiAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgfSxcbiAgICAgICAgICBjaGFuZ2VUYWI6IGZ1bmN0aW9uIGNoYW5nZVRhYih0YWIpIHtcbiAgICAgICAgICAgIHZhciAkdGFiID0gJCgnIycgKyB0YWIpO1xuICAgICAgICAgICAgJHRhYi5jbG9zZXN0KCcuc3RtX21ldGFib3hlc19ncmlkX19pbm5lcicpLmZpbmQoJy53cGNmdG8tdGFiJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAgICAgJHRhYi5hZGRDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICAgICB2YXIgJHNlY3Rpb24gPSAkKCdkaXZbZGF0YS1zZWN0aW9uPVwiJyArIHRhYiArICdcIl0nKTtcbiAgICAgICAgICAgICR0YWIuY2xvc2VzdCgnLndwY2Z0by1zZXR0aW5ncycpLmZpbmQoJy53cGNmdG8tbmF2JykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAgICAgJHRhYi5jbG9zZXN0KCcuc3RtX21ldGFib3hlc19ncmlkX19pbm5lcicpLmZpbmQoJy53cGNmdG8tbmF2JykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAgICAgJHNlY3Rpb24uY2xvc2VzdCgnLndwY2Z0by1uYXYnKS5hZGRDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICAgICBoaXN0b3J5LnB1c2hTdGF0ZShudWxsLCBudWxsLCAnIycgKyB0YWIpO1xuICAgICAgICAgICAgLyppZiBoYXMgc3VibWVudSovXG5cbiAgICAgICAgICAgIGlmICgkc2VjdGlvbi5jbG9zZXN0KCcud3BjZnRvLW5hdicpLmhhc0NsYXNzKCdoYXMtc3VibWVudScpKSB7XG4gICAgICAgICAgICAgIHZhciAkc3VibWVudSA9ICRzZWN0aW9uLmNsb3Nlc3QoJy53cGNmdG8tbmF2JykuZmluZCgnLndwY2Z0by1zdWJtZW51cyBbZGF0YS1zdWJtZW51XScpLmVxKDApO1xuICAgICAgICAgICAgICB0aGlzLmNoYW5nZVN1Yk1lbnUoJHN1Ym1lbnUuYXR0cignZGF0YS1zdWJtZW51JykpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgLypTY3JvbGwgdG9wKi9cblxuXG4gICAgICAgICAgICAkKFwiaHRtbCwgYm9keVwiKS5hbmltYXRlKHtcbiAgICAgICAgICAgICAgc2Nyb2xsVG9wOiAkdGFiLmNsb3Nlc3QoJy5zdG1fbWV0YWJveGVzX2dyaWRfX2lubmVyJykub2Zmc2V0KCkudG9wIC0gMTAwXG4gICAgICAgICAgICB9LCBcImZhc3RcIik7XG4gICAgICAgICAgfSxcbiAgICAgICAgICBjaGFuZ2VTdWJNZW51OiBmdW5jdGlvbiBjaGFuZ2VTdWJNZW51KHN1Yl9tZW51KSB7XG4gICAgICAgICAgICB2YXIgJHN1Ym1lbnUgPSAkKCdbZGF0YS1zdWJtZW51PVwiJyArIHN1Yl9tZW51ICsgJ1wiXScpO1xuICAgICAgICAgICAgJCgnW2RhdGEtc3VibWVudV0nKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICAgICAkc3VibWVudS5hZGRDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICAgICB0aGlzLmluaXRTdWJtZW51KCk7XG4gICAgICAgICAgfSxcbiAgICAgICAgICBnZXRTZXR0aW5nczogZnVuY3Rpb24gZ2V0U2V0dGluZ3MoKSB7XG4gICAgICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuXG4gICAgICAgICAgICBfdGhpcy5sb2FkaW5nID0gdHJ1ZTtcbiAgICAgICAgICAgIHRoaXMuJGh0dHAuZ2V0KHN0bV93cGNmdG9fYWpheHVybCArICc/YWN0aW9uPXN0bV93cGNmdG9fZ2V0X3NldHRpbmdzJnNvdXJjZT0nICsgZGF0YV9zb3VyY2UgKyAnJm5hbWU9JyArIGRhdGFfdmFyKS50aGVuKGZ1bmN0aW9uIChyKSB7XG4gICAgICAgICAgICAgIF90aGlzLiRzZXQoX3RoaXMsICdkYXRhJywgci5ib2R5KTtcblxuICAgICAgICAgICAgICBfdGhpcy5sb2FkaW5nID0gZmFsc2U7XG4gICAgICAgICAgICAgIHRoaXMuY2hhbmdlVGFiRnJvbUFuY2hvcigpO1xuICAgICAgICAgICAgICB0aGlzLmluaXRTdWJtZW51KCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICB9LFxuICAgICAgICAgIHNhdmVTZXR0aW5nczogZnVuY3Rpb24gc2F2ZVNldHRpbmdzKGlkKSB7XG4gICAgICAgICAgICB2YXIgdm0gPSB0aGlzO1xuICAgICAgICAgICAgdm0ubG9hZGluZyA9IHRydWU7XG4gICAgICAgICAgICB0aGlzLiRodHRwLnBvc3Qoc3RtX3dwY2Z0b19hamF4dXJsICsgJz9hY3Rpb249d3BjZnRvX3NhdmVfc2V0dGluZ3Mmbm9uY2U9JyArIHN0bV93cGNmdG9fbm9uY2VzWyd3cGNmdG9fc2F2ZV9zZXR0aW5ncyddICsgJyZuYW1lPScgKyBpZCwgSlNPTi5zdHJpbmdpZnkodm0uZGF0YSkpLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgICAgICAgIHZhciBfcmVzcG9uc2UkYm9keTtcblxuICAgICAgICAgICAgICB2bS5sb2FkaW5nID0gZmFsc2U7XG4gICAgICAgICAgICAgIHZtLnNldHRpbmdzX2FsZXJ0ID0ge1xuICAgICAgICAgICAgICAgIHN1Y2Nlc3M6IHJlc3BvbnNlLnN0YXR1cyA9PT0gMjAwLFxuICAgICAgICAgICAgICAgIHN0YXR1czogdHJ1ZVxuICAgICAgICAgICAgICB9O1xuICAgICAgICAgICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICB2bS5zZXR0aW5nc19hbGVydC5zdGF0dXMgPSBmYWxzZTtcbiAgICAgICAgICAgICAgfSwgMTUwMCk7XG4gICAgICAgICAgICAgIGlmICgoKF9yZXNwb25zZSRib2R5ID0gcmVzcG9uc2UuYm9keSkgPT09IG51bGwgfHwgX3Jlc3BvbnNlJGJvZHkgPT09IHZvaWQgMCA/IHZvaWQgMCA6IF9yZXNwb25zZSRib2R5LnJlbG9hZCkgPT09IHRydWUpIGxvY2F0aW9uLnJlbG9hZCgpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgfSxcbiAgICAgICAgICBpbml0T3BlbjogZnVuY3Rpb24gaW5pdE9wZW4oZmllbGQpIHtcbiAgICAgICAgICAgIGlmICh0eXBlb2YgZmllbGQub3BlbmVkID09PSAndW5kZWZpbmVkJykge1xuICAgICAgICAgICAgICB0aGlzLiRzZXQoZmllbGQsICdvcGVuZWQnLCAhIWZpZWxkLnZhbHVlKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9LFxuICAgICAgICAgIG9wZW5GaWVsZDogZnVuY3Rpb24gb3BlbkZpZWxkKGZpZWxkKSB7XG4gICAgICAgICAgICB2YXIgb3BlbmVkID0gIWZpZWxkLm9wZW5lZDtcbiAgICAgICAgICAgIHRoaXMuJHNldChmaWVsZCwgJ29wZW5lZCcsIG9wZW5lZCk7XG5cbiAgICAgICAgICAgIGlmICghZmllbGQub3BlbmVkKSB7XG4gICAgICAgICAgICAgIHRoaXMuJHNldChmaWVsZCwgJ3ZhbHVlJywgJycpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgIH0sXG4gICAgICAgICAgZW5hYmxlQWRkb246IGZ1bmN0aW9uIGVuYWJsZUFkZG9uKCRldmVudCwgb3B0aW9uKSB7XG4gICAgICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuXG4gICAgICAgICAgICBWdWUubmV4dFRpY2soZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAoZnVuY3Rpb24gKCQpIHtcbiAgICAgICAgICAgICAgICB2YXIgY3VycmVudEl0ZW0gPSAkKCRldmVudC50YXJnZXQpO1xuICAgICAgICAgICAgICAgIGN1cnJlbnRJdGVtLmFkZENsYXNzKCdsb2FkaW5nJyk7XG4gICAgICAgICAgICAgICAgdmFyIHVybCA9IHN0bV93cGNmdG9fYWpheHVybCArICc/YWN0aW9uPXN0bV9sbXNfZW5hYmxlX2FkZG9uJmFkZG9uPScgKyBvcHRpb247XG5cbiAgICAgICAgICAgICAgICBfdGhpcy4kaHR0cC5nZXQodXJsKS50aGVuKGZ1bmN0aW9uIChyZXNwb25zZSkge1xuICAgICAgICAgICAgICAgICAgY3VycmVudEl0ZW0ucmVtb3ZlQ2xhc3MoJ2xvYWRpbmcnKTtcbiAgICAgICAgICAgICAgICAgIHZhciAkY29udGFpbmVyID0gJCgnLnN0bV9sbXNfYWRkb25fZ3JvdXBfc2V0dGluZ3NfJyArIG9wdGlvbik7XG4gICAgICAgICAgICAgICAgICAkY29udGFpbmVyLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xuICAgICAgICAgICAgICAgICAgICAkdGhpcy5yZW1vdmVDbGFzcygnaXNfcHJvIGlzX3Byb19pbl9hZGRvbicpO1xuICAgICAgICAgICAgICAgICAgICAkdGhpcy5maW5kKCcuZmllbGRfb3ZlcmxheScpLnJlbW92ZSgpO1xuICAgICAgICAgICAgICAgICAgICAkdGhpcy5maW5kKCcucHJvLW5vdGljZScpLnJlbW92ZSgpO1xuICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgIH0pKGpRdWVyeSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICB9LFxuICAgICAgICAgIGNsZWFyRW1wdHlHcm91cHM6IGZ1bmN0aW9uIGNsZWFyRW1wdHlHcm91cHMoKSB7XG4gICAgICAgICAgICBWdWUubmV4dFRpY2soKS50aGVuKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgKGZ1bmN0aW9uICgkKSB7XG4gICAgICAgICAgICAgICAgJCgnLndwY2Z0b19ncm91cF9zdGFydGVkJykuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgICB2YXIgJGdyb3VwID0gJCh0aGlzKTtcbiAgICAgICAgICAgICAgICAgIHZhciAkY2hpbGRzID0gJGdyb3VwLmZpbmQoJy53cGNmdG8tYm94LWNoaWxkJyk7XG5cbiAgICAgICAgICAgICAgICAgIGlmICghJGNoaWxkcy5sZW5ndGgpIHtcbiAgICAgICAgICAgICAgICAgICAgJGdyb3VwLmFkZENsYXNzKCduby1jaGlsZHMtdmlzaWJsZScpO1xuICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgJGdyb3VwLnJlbW92ZUNsYXNzKCduby1jaGlsZHMtdmlzaWJsZScpO1xuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICB9KShqUXVlcnkpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgfVxuICAgICAgICB9LFxuICAgICAgICB3YXRjaDoge1xuICAgICAgICAgIGRhdGE6IHtcbiAgICAgICAgICAgIGRlZXA6IHRydWUsXG4gICAgICAgICAgICBoYW5kbGVyOiBmdW5jdGlvbiBoYW5kbGVyKCkge1xuICAgICAgICAgICAgICB2YXIgX3RoaXMgPSB0aGlzO1xuXG4gICAgICAgICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgIF90aGlzLmNsZWFyRW1wdHlHcm91cHMoKTtcblxuICAgICAgICAgICAgICAgIF90aGlzLmluaXRTdWJtZW51KCk7XG4gICAgICAgICAgICAgIH0sIDEwMCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9KTtcbiAgICB9KTtcbiAgfSk7XG59KShqUXVlcnkpOyJdLCJtYXBwaW5ncyI6IkFBQUE7O0FBRUEsQ0FBQyxVQUFVQSxDQUFWLEVB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
},{}]},{},[1])