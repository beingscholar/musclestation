(function () {
  'use strict';
  /**
   * Defines the Hustle Object
   *
   * @type {{define, getModules, get, modules}}
   */

  window.Hustle = function ($, doc, win) {
    var currentModules = {},
        _modules = {},
        _TemplateOptions = {
      evaluate: /<#([\s\S]+?)#>/g,
      interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
      escape: /\{\{([^\}]+?)\}\}(?!\})/g
    };

    var define = function define(moduleName, module) {
      var splits = moduleName.split('.');

      if (splits.length) {
        // if module_name has more than one object name, then add the module definition recursively
        var recursive = function recursive(incomingModuleName, modules) {
          var arr = incomingModuleName.split('.'),
              _moduleName = arr.splice(0, 1)[0];
          var invoked;

          if (!_moduleName) {
            return;
          }

          if (!arr.length) {
            invoked = module.call(null, $, doc, win);
            modules[_moduleName] = _.isFunction(invoked) || 'undefined' === typeof invoked ? invoked : _.extend(modules[_moduleName] || {}, invoked);
          } else {
            modules[_moduleName] = modules[_moduleName] || {};
          }

          if (arr.length && _moduleName) {
            recursive(arr.join('.'), modules[_moduleName]);
          }
        };

        recursive(moduleName, _modules);
      } else {
        var m = _modules[moduleName] || {};
        _modules[moduleName] = _.extend(m, module.call(null, $, doc, win));
      }
    },
        get = function get(moduleName) {
      var module, _recursive;

      if (moduleName.split('.').length) {
        // recursively fetch the module
        module = false;

        _recursive = function recursive(incomingModuleName, modules) {
          var arr = incomingModuleName.split('.'),
              _moduleName = arr.splice(0, 1)[0];
          module = modules[_moduleName];

          if (arr.length) {
            _recursive(arr.join('.'), modules[_moduleName]);
          }
        };

        _recursive(moduleName, _modules);

        return module;
      }

      return _modules[moduleName] || false;
    },
        Events = _.extend({}, Backbone.Events),
        View = Backbone.View.extend({
      initialize: function initialize() {
        if (_.isFunction(this.initMix)) {
          this.initMix.apply(this, arguments);
        }

        if (this.render) {
          this.render = _.wrap(this.render, function (render) {
            this.trigger('before_render');
            render.call(this);
            Events.trigger('view.rendered', this);
            this.trigger('rendered');
          });
        }

        if (_.isFunction(this.init)) {
          this.init.apply(this, arguments);
        }
      }
    }),
        template = _.memoize(function (id) {
      var compiled;
      return function (data) {
        compiled = compiled || _.template(document.getElementById(id).innerHTML, null, _TemplateOptions);
        return compiled(data).replace('/*<![CDATA[*/', '').replace('/*]]>*/', '');
      };
    }),
        createTemplate = _.memoize(function (str) {
      var cache;
      return function (data) {
        cache = cache || _.template(str, null, _TemplateOptions);
        return cache(data);
      };
    }),
        getTemplateOptions = function getTemplateOptions() {
      return $.extend(true, {}, _TemplateOptions);
    },
        setModule = function setModule(moduleId, moduleView) {
      currentModules[moduleId] = moduleView;
    },
        getModules = function getModules() {
      return currentModules;
    },
        getModule = function getModule(moduleId) {
      return currentModules[moduleId];
    },
        consts = function () {
      return {
        ModuleShowCount: 'hustle_module_show_count-'
      };
    }();

    return {
      define: define,
      setModule: setModule,
      getModules: getModules,
      getModule: getModule,
      get: get,
      Events: Events,
      View: View,
      template: template,
      createTemplate: createTemplate,
      getTemplateOptions: getTemplateOptions,
      consts: consts
    };
  }(jQuery, document, window);
})(jQuery);
var Optin = window.Optin || {};
Optin.Models = {};

(function ($) {
  'use strict';

  Optin.NEVER_SEE_PREFIX = 'inc_optin_never_see_again-';
  Optin.COOKIE_PREFIX = 'inc_optin_long_hidden-';
  Optin.POPUP_COOKIE_PREFIX = 'inc_optin_popup_long_hidden-';
  Optin.SLIDE_IN_COOKIE_PREFIX = 'inc_optin_slide_in_long_hidden-';
  Optin.EMBEDDED_COOKIE_PREFIX = 'inc_optin_embedded_long_hidden-';
  Optin.template = _.memoize(function (id) {
    var compiled;
    var options = {
      evaluate: /<#([\s\S]+?)#>/g,
      interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
      escape: /\{\{([^\}]+?)\}\}(?!\})/g
    };
    return function (data) {
      compiled = compiled || _.template($('#' + id).html(), null, options);
      return compiled(data).replace('/*<![CDATA[*/', '').replace('/*]]>*/', '');
    };
  });
  /**
   * Compatibility with other plugin/theme e.g. upfront
   *
   */

  Optin.templateCompat = _.memoize(function (id) {
    var compiled;
    return function (data) {
      compiled = compiled || _.template($('#' + id).html());
      return compiled(data).replace('/*<![CDATA[*/', '').replace('/*]]>*/', '');
    };
  });
  Optin.cookie = {
    // Get a cookie value.
    get: function get(name) {
      var c;
      var cookiesArray = document.cookie.split(';'),
          cookiesArrayLength = cookiesArray.length,
          cookieName = name + '=';

      for (var i = 0; i < cookiesArrayLength; i += 1) {
        c = cookiesArray[i];

        while (' ' === c.charAt(0)) {
          c = c.substring(1, c.length);
        }

        if (0 === c.indexOf(cookieName)) {
          var _val = c.substring(cookieName.length, c.length);

          return _val ? JSON.parse(_val) : _val;
        }
      }

      return null;
    },
    // Saves the value into a cookie.
    set: function set(name, value, days) {
      var date, expires;
      value = $.isArray(value) || $.isPlainObject(value) ? JSON.stringify(value) : value;

      if (!isNaN(days)) {
        date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = '; expires=' + date.toGMTString();
      } else {
        expires = '';
      }

      document.cookie = name + '=' + value + expires + '; path=/';
    }
  };
  Optin.Mixins = {
    _mixins: {},
    _servicesMixins: {},
    _desingMixins: {},
    _displayMixins: {},
    add: function add(id, obj) {
      this._mixins[id] = obj;
    },
    getMixins: function getMixins() {
      return this._mixins;
    },
    addServicesMixin: function addServicesMixin(id, obj) {
      this._servicesMixins[id] = obj;
    },
    getServicesMixins: function getServicesMixins() {
      return this._servicesMixins;
    }
  };
})(jQuery);
(function ($) {
  'use strict';

  Hustle.Events.on('view.rendered', function (view) {
    if (view instanceof Backbone.View) {
      var accessibleHide = function accessibleHide($elements) {
        $elements.hide();
        $elements.prop('tabindex', '-1');
        $elements.prop('hidden', true);
      },
          accessibleShow = function accessibleShow($elements) {
        $elements.show();
        $elements.prop('tabindex', '0');
        $elements.removeProp('hidden');
      }; // Init select


      view.$('select:not([multiple])').each(function () {
        SUI.suiSelect(this);
      }); // Init select2

      view.$('.sui-select:not(.hustle-select-ajax)').SUIselect2({
        dropdownCssClass: 'sui-select-dropdown'
      }); // Init accordion

      view.$('.sui-accordion').each(function () {
        SUI.suiAccordion(this);
      }); // Init tabs (old markup)

      SUI.suiTabs(); // Init tabs (new markup)

      SUI.tabs({
        callback: function callback(tab, panel) {
          // eslint-disable-line no-unused-vars
          var wrapper = tab.closest('.sui-tabs'); // Handlers for "CTA Helper Text" options.

          var ctaHelperEnable = 'cta-helper-enable',
              ctaHelperDisable = 'cta-helper-disable';

          if ('tab-' + ctaHelperEnable === tab.attr('id')) {
            wrapper.find('#input-' + ctaHelperEnable).click();
          } else if ('tab-' + ctaHelperDisable === tab.attr('id')) {
            wrapper.find('#input-' + ctaHelperDisable).click();
          } // Handlers for "Set Schedule" modal.


          var scheduleEveryday = 'schedule-everyday',
              scheduleSomedays = 'schedule-somedays',
              scheduleServer = 'timezone-server',
              scheduleCustom = 'timezone-custom';

          if ('tab-' + scheduleEveryday === tab.attr('id')) {
            wrapper.find('#input-' + scheduleEveryday).click();
          }

          if ('tab-' + scheduleSomedays === tab.attr('id')) {
            wrapper.find('#input-' + scheduleSomedays).click();
          }

          if ('tab-' + scheduleServer === tab.attr('id')) {
            wrapper.find('#input-' + scheduleServer).click();
          }

          if ('tab-' + scheduleCustom === tab.attr('id')) {
            wrapper.find('#input-' + scheduleCustom).click();
          }
        }
      }); // Init float input

      SUI.floatInput();
      /**
       * Hides and shows the content of the settings using sui-side-tabs.
       * For us, non-designers: sui-side-tabs are the "buttons" that work as labels for radio inputs.
       *
       * @todo TO BE REMOVED.
       * @since 4.0.0
       * @since 4.3.0 Handle added for tabs using buttons instead of inputs.
       */

      view.$('.sui-side-tabs').each(function () {
        var $this = $(this); // Show or hide dependent content based on the selected settings.
        // Only working for old tabs not using buttons but inputs.

        var $inputs = $this.find('.sui-tabs-menu .sui-tab-item input');

        if (!$inputs.length) {
          return;
        }

        var handleTabs = function handleTabs() {
          // This holds the dependency name of the selected input.
          // It's used to avoid hiding a container that should be shown
          // when two or more tabs share the same container.
          var shownDep = '';
          $.each($inputs, function () {
            var $input = $(this),
                $label = $input.parent('label'),
                dependencyName = $input.data('tab-menu'),
                $tabContent = $(".sui-tabs-content [data-tab-content=\"".concat(dependencyName, "\"]")),
                $tabDependent = $("[data-tab-dependent=\"".concat(dependencyName, "\"]"));

            if ($input[0].checked) {
              $label.addClass('active');

              if (dependencyName) {
                shownDep = dependencyName;
                $tabContent.addClass('active');
                accessibleShow($tabDependent);
              }
            } else {
              $label.removeClass('active');

              if (dependencyName !== shownDep) {
                $tabContent.removeClass('active');
                accessibleHide($tabDependent);
              }
            }
          });
        }; // Do it on load.


        handleTabs(); // And do it on change.

        $inputs.on('change', function () {
          return handleTabs();
        }); // Probably to be handled by SUI in the future.
        // Handle new tabs using buttons instead of radios and labels.

        var $buttons = $this.find('button.sui-tab-item');
        $buttons.on('click', function () {
          var $button = $(this),
              $buttonRadio = $('#' + $button.data('label-for'));

          if ($buttonRadio.length) {
            $buttonRadio.trigger('click').trigger('change');
          }
        }); // Make buttons selected on load.

        var $selected = $this.children('.hustle-tabs-option:checked');

        if ($selected.length) {
          var id = $selected.prop('id'),
              $button = $this.find("button[data-label-for=\"".concat(id, "\"]"));
          $button.trigger('click');
        }
      }); // Same as the one above but for the tabs markup in the new component files.

      view.$('.sui-side-tabs').each(function () {
        var $sideTabsContainer = $(this); // Show or hide dependent content based on the selected settings.

        var $inputs = $sideTabsContainer.children('.hustle-tabs-option');

        if (!$inputs.length) {
          return;
        }

        var handleTabs = function handleTabs() {
          // Used to avoid hiding a container that should be shown
          // when two or more tabs share the same container.
          var shownDep = '';
          $.each($inputs, function () {
            var $input = $(this),
                inputId = $input.attr('id'),
                $button = $sideTabsContainer.find("button[data-label-for=\"".concat(inputId, "\"]")),
                dependencyId = $button.attr('aria-controls'),
                //// Use this instead in 4.4 with new multiple-triggers in place. $tabDependent = $( `#${ dependencyId }` );
            $tabDependent = $("div[id=\"".concat(dependencyId, "\"]"));

            if ($input[0].checked) {
              $button.addClass('active');

              if (dependencyId) {
                shownDep = dependencyId;
                accessibleShow($tabDependent);
              }
            } else {
              $button.removeClass('active');

              if (dependencyId !== shownDep) {
                accessibleHide($tabDependent);
              }
            }
          });
        }; // Do it on load.


        handleTabs(); // And do it on change.

        $inputs.on('change', function () {
          return handleTabs();
        });
        var $buttons = $sideTabsContainer.children('.sui-tabs-menu').find('button.sui-tab-item');
        $buttons.on('click', function () {
          var $button = $(this),
              // Use this instead in 4.4 with new multiple-triggers in place. $( '#' + $button.data( 'label-for' ) );
          $buttonRadio = $('input[id="' + $button.data('label-for') + '"]');

          if ($buttonRadio.length) {
            $buttonRadio.trigger('click').trigger('change');
          }
        });
      });
      view.$('.select-content-switcher-wrapper').each(function () {
        var $this = $(this),
            $select = $this.find('.select-content-switcher'),
            $options = $select.find('option'),
            switchContent = function switchContent() {
          var $selected = $select.find(':selected'),
              dependencyName = $selected.data('switcher-menu'),
              $selectedTabContent = $this.find(".select-switcher-content[data-switcher-content=\"".concat(dependencyName, "\"]"));
          $.each($options, function () {
            var $option = $(this);

            if ($option.data('switcher-menu') === dependencyName) {
              accessibleShow($selectedTabContent);
            } else {
              var $tabContent = $this.find(".select-switcher-content[data-switcher-content=\"".concat($option.data('switcher-menu'), "\"]"));
              accessibleHide($tabContent);
            }
          });
        }; // Do it on load.


        switchContent(); // And do it on change.

        $select.on('change', function () {
          return switchContent();
        });
      });
      /**
       * Hides and shows the container dependent on toggles
       * on view load and on change.
       * Used in wizards and global settings page.
       *
       * @since 4.0.3
       */

      view.$('.hustle-toggle-with-container').each(function () {
        var $this = $(this),
            $checkbox = $this.find('input[type=checkbox]'),
            $containersOn = $("[data-toggle-content=\"".concat($this.data('toggle-on'), "\"]")),
            $containersOff = $("[data-toggle-content=\"".concat($this.data('toggle-off'), "\"]")),
            doToggle = function doToggle() {
          if ($checkbox[0].checked) {
            Module.Utils.accessibleShow($containersOn);
            Module.Utils.accessibleHide($containersOff);
          } else {
            Module.Utils.accessibleShow($containersOff);
            Module.Utils.accessibleHide($containersOn);
          }
        }; // Do it on load.


        doToggle(); // And do it on change.

        $checkbox.on('change', doToggle);
      });
      /**
       * Toggles the 'disabled' property from the field dependent to a radio
       * based on the selected value.
       * Used in wizards.
       *
       * @since 4.3.0
       */

      view.$('.hustle-radio-with-dependency-to-disable').each(function () {
        var $radio = $(this),
            relationName = $radio.data('disable'),
            $dependentField = $("[data-disable-content=\"".concat(relationName, "\"]")),
            disableOff = $dependentField.data('disable-off'),
            disableOn = $dependentField.data('disable-on');

        var toggleDisabled = function toggleDisabled() {
          if (!$radio.is(':checked')) {
            return;
          }

          if (disableOff) {
            if (disableOff === $radio.val()) {
              $dependentField.prop('disabled', false);
            } else {
              $dependentField.prop('disabled', true);
            }

            return;
          }

          if (disableOn) {
            if (disableOn === $radio.val()) {
              $dependentField.prop('disabled', true);
            } else {
              $dependentField.prop('disabled', false);
            }
          }
        };

        toggleDisabled();
        $radio.on('change', toggleDisabled);
      });
      /**
       * Toggles the 'disabled' property from the field dependent to a select
       * based on the selected value.
       * Used in wizards.
       *
       * @since 4.3.0
       */

      view.$('.hustle-select-with-dependency-to-disable').each(function () {
        var $select = $(this),
            relationName = $select.data('disable'),
            $dependentField = $("[data-disable-content=\"".concat(relationName, "\"]")),
            disableOff = $dependentField.data('disable-off'),
            disableOn = $dependentField.data('disable-on');

        var toggleDisabled = function toggleDisabled() {
          if (disableOff) {
            if (disableOff === $select.val()) {
              $dependentField.prop('disabled', false);
            } else {
              $dependentField.prop('disabled', true);
            }

            return;
          }

          if (disableOn) {
            if (disableOn === $select.val()) {
              $dependentField.prop('disabled', true);
            } else {
              $dependentField.prop('disabled', false);
            }
          }
        };

        toggleDisabled();
        $select.on('change', toggleDisabled);
      });
      Module.Utils.showHideDependencyOnSelectChange(view.$el);
    }
  }); // TODO: probably move this to the view where it's actually used.

  $(document).ready(function () {
    if ($('#hustle-email-day').length) {
      $('#hustle-email-day').datepicker({
        beforeShow: function beforeShow() {
          $('#ui-datepicker-div').addClass('sui-calendar');
        },
        dateFormat: 'MM dd, yy'
      });
    }

    if ($('#hustle-email-time').length) {
      $('#hustle-email-time').timepicker({
        timeFormat: 'h:mm p',
        interval: '1',
        minTime: '0',
        maxTime: '11:59pm',
        defaultTime: null,
        startTime: '00:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true,
        change: function change() {
          $('#hustle-email-time').trigger('change');
        }
      });
    } // Makes the 'copy' button work.


    $('.hustle-copy-shortcode-button').on('click', function (e) {
      e.preventDefault();
      var $button = $(e.target),
          shortcode = $button.data('shortcode'),
          $inputWrapper = $button.closest('.sui-with-button-inside');

      if ('undefined' !== typeof shortcode) {
        // Actions in listing pages.
        var $temp = $('<input />');
        $('body').append($temp);
        $temp.val(shortcode).select();
        document.execCommand('copy');
        $temp.remove();
        Module.Notification.open('success', optinVars.messages.shortcode_copied);
      } else if ($inputWrapper.length) {
        // Copy shortcode in wizard pages.
        var $inputWithCopy = $inputWrapper.find('input[type="text"]');
        $inputWithCopy.select();
        document.execCommand('copy');
      }
    }); // Dismiss for all the notices using the template from Hustle_Notifications::show_notice().

    $('.hustle-dismissible-admin-notice .notice-dismiss, .hustle-dismissible-admin-notice .dismiss-notice').on('click', function (e) {
      e.preventDefault();
      var $container = $(e.currentTarget).closest('.hustle-dismissible-admin-notice');
      $.post(ajaxurl, {
        action: 'hustle_dismiss_notification',
        name: $container.data('name'),
        _ajax_nonce: $container.data('nonce')
      }).always($container.fadeOut());
    }); // Opens the confirmation modal for dismissing the tracking migration notice.

    $('#hustle-tracking-migration-notice .hustle-notice-dismiss').on('click', function (e) {
      e.preventDefault();
      $('#hustle-dismiss-modal-button').on('click', function (ev) {
        ev.preventDefault();
        $.post(ajaxurl, {
          action: 'hustle_dismiss_notification',
          name: $(ev.currentTarget).data('name'),
          _ajax_nonce: $(ev.currentTarget).data('nonce')
        }).always(function () {
          return location.reload();
        });
      });
      SUI.openModal('hustle-dialog--migrate-dismiss-confirmation', $('.sui-header-title'));
    });

    if ($('.sui-form-field input[type=number]').length) {
      $('.sui-form-field input[type=number]').on('keydown', function (e) {
        if ($(this)[0].hasAttribute('min') && 0 <= $(this).attr('min')) {
          var char = e.originalEvent.key.replace(/[^0-9^.^,]/, '');

          if (0 === char.length && !(e.originalEvent.ctrlKey || e.originalEvent.metaKey)) {
            e.preventDefault();
          }
        }
      });
    }

    setTimeout(function () {
      if ($('.hustle-scroll-to').length) {
        $('html, body').animate({
          scrollTop: $('.hustle-scroll-to').offset().top
        }, 'slow');
      }
    }, 100); //table checkboxes

    $('.hustle-check-all').on('click', function (e) {
      var $this = $(e.target),
          $list = $this.parents('.sui-wrap-hustle').find('.hustle-list'),
          allChecked = $this.is(':checked');
      $list.find('.hustle-listing-checkbox').prop('checked', allChecked);
      $this.parents('.sui-wrap-hustle').find('.hustle-check-all').prop('checked', allChecked);
      $('.hustle-bulk-apply-button').prop('disabled', !allChecked);
    });
    $('.hustle-list .hustle-listing-checkbox').on('click', function (e) {
      var $this = $(e.target),
          $list = $this.parents('.sui-wrap-hustle').find('.hustle-list'),
          allChecked = $this.is(':checked') && !$list.find('.hustle-listing-checkbox:not(:checked)').length,
          count = $list.find('.hustle-listing-checkbox:checked').length,
          disabled = 0 === count;
      $('.hustle-check-all').prop('checked', allChecked);
      $('.hustle-bulk-apply-button').prop('disabled', disabled);
    });
    $('.hustle-bulk-apply-button').on('click', function (e) {
      var $this = $(e.target),
          value = $('select option:selected', $this.closest('.hui-bulk-actions')).val(),
          elements = $('.hustle-list .hustle-listing-checkbox:checked');

      if (0 === elements.length || 'undefined' === value) {
        return false;
      }

      var ids = [];
      $.each(elements, function () {
        ids.push($(this).val());
      });

      if ('delete-all' === value) {
        var data = {
          ids: ids.join(','),
          nonce: $this.siblings('input[name="hustle_nonce"]').val(),
          title: $this.data('title'),
          description: $this.data('description'),
          action: value
        };
        Module.deleteModal.open(data, $this[0]);
        return false;
      }
    });
  });
})(jQuery);
Hustle.define('Modals.Migration', function ($) {
  'use strict';

  var migrationModalView = Backbone.View.extend({
    el: '#hustle-dialog--migrate',
    data: {},
    events: {
      'click #hustle-migrate-start': 'migrateStart',
      'click #hustle-create-new-module': 'createModule',
      'click .sui-box-selector': 'enableContinue',
      'click .hustle-dialog-migrate-skip': 'dismissModal',
      'click .sui-dialog-overlay': 'dismissModal'
    },
    initialize: function initialize() {
      if (!this.$el.length) {
        return;
      }

      var currentSlide = '',
          focusOnOpen = '';

      if (0 === this.$el.data('isFirst')) {
        currentSlide = '#hustle-dialog--migrate-slide-2';
        focusOnOpen = 'hustle-migrate-start';
      } else {
        currentSlide = '#hustle-dialog--migrate-slide-1';
        focusOnOpen = 'hustle-migrate-get-started';
      }

      this.$(currentSlide).addClass('sui-active sui-loaded');
      setTimeout(function () {
        return SUI.openModal('hustle-dialog--migrate', focusOnOpen, $('.sui-wrap-hustle')[0], false);
      }, 100);
      this.$progressBar = this.$el.find('.sui-progress .sui-progress-bar span');
      this.$progressText = this.$el.find('.sui-progress .sui-progress-text span');
      this.$partialRows = this.$el.find('#hustle-partial-rows');
    },
    migrateStart: function migrateStart(e) {
      var me = this;
      var button = $(e.target);
      var $container = this.$el,
          $dialog = $container.find('#hustle-dialog--migrate-slide-2'),
          $description = $dialog.find('#hustle-dialog--migrate-slide-2-description'); // On load button

      button.addClass('sui-button-onload'); // Remove skip migration link

      $dialog.find('.hustle-dialog-migrate-skip').remove();
      $description.text($description.data('migrate-text'));
      Module.Utils.accessibleHide($dialog.find('div[data-migrate-start]'));
      Module.Utils.accessibleHide($dialog.find('div[data-migrate-failed]'));
      Module.Utils.accessibleShow($dialog.find('div[data-migrate-progress]'));
      SUI.closeNotice('hustle-dialog--migrate-error-notice');
      me.migrateTracking(e);
      button.removeClass('sui-button-onload');
      e.preventDefault();
    },
    migrateComplete: function migrateComplete() {
      var slide = this.$('#hustle-dialog--migrate-slide-2'),
          self = this;
      var title = slide.find('#hustle-dialog--migrate-slide-2-title');
      var description = slide.find('#hustle-dialog--migrate-slide-2-description');
      this.$el.find('sui-button-onload').removeClass('sui-button-onload');
      title.text(title.data('done-text'));
      description.text(description.data('done-text'));
      Module.Utils.accessibleHide(slide.find('div[data-migrate-progress]'));
      Module.Utils.accessibleShow(slide.find('div[data-migrate-done]'));
      this.$el.closest('.sui-modal').on('click', function (e) {
        return self.closeDialog(e);
      });
    },
    migrateFailed: function migrateFailed() {
      var slide = this.$el.find('#hustle-dialog--migrate-slide-2'),
          description = slide.find('#dialogDescription');
      description.text('');
      Module.Utils.accessibleHide(slide.find('div[data-migrate-start]'));
      Module.Utils.accessibleShow(slide.find('div[data-migrate-failed]'));
      Module.Utils.accessibleHide(slide.find('div[data-migrate-progress]'));
      var noticeId = 'hustle-dialog--migrate-error-notice',
          $notice = $('#' + noticeId),
          message = $notice.data('message');
      Module.Notification.open('error', message, false, noticeId, false);
    },
    updateProgress: function updateProgress(migratedRows, rowsPercentage, totalRows) {
      if ('undefined' === typeof this.totalRows) {
        this.totalRows = totalRows;
        this.$el.find('#hustle-total-rows').text(totalRows);
      }

      this.$partialRows.text(migratedRows);
      var width = rowsPercentage + '%';
      this.$progressBar.css('width', width);

      if (100 >= rowsPercentage) {
        this.$progressText.text(rowsPercentage + '%');
      }
    },
    migrateTracking: function migrateTracking(e) {
      e.preventDefault();
      var self = this,
          $button = $(e.currentTarget),
          nonce = $button.data('nonce'),
          data = {
        action: 'hustle_migrate_tracking',
        _ajax_nonce: nonce
      };
      $.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: data,
        success: function success(res) {
          if (res.success) {
            var migratedRows = res.data.migrated_rows,
                migratedPercentage = res.data.migrated_percentage,
                totalRows = res.data.total_entries || '0';

            if ('done' !== res.data.current_meta) {
              self.updateProgress(migratedRows, migratedPercentage, totalRows);
              self.migrateTracking(e);
            } else {
              self.updateProgress(migratedRows, migratedPercentage, totalRows); // Set a small delay so the users can see the progress update in front before moving
              // forward and they don't think some rows were not migrated.

              setTimeout(function () {
                return self.migrateComplete();
              }, 500);
            }
          } else {
            self.migrateFailed();
          }
        },
        error: function error() {
          self.migrateFailed();
        }
      });
      return false;
    },
    createModule: function createModule(e) {
      var button = $(e.target),
          $selection = this.$el.find('.sui-box-selector input:checked');

      if ($selection.length) {
        this.dismissModal();
        button.addClass('sui-button-onload');
        var moduleType = $selection.val(),
            page = 'undefined' !== typeof optinVars.module_page[moduleType] ? optinVars.module_page[moduleType] : optinVars.module_page.popup;
        window.location = "?page=".concat(page, "&create-module=true");
      } else {// Show an error message or something?
      }

      e.preventDefault();
    },
    closeDialog: function closeDialog(e) {
      SUI.closeModal();
      e.preventDefault();
      e.stopPropagation();
    },
    enableContinue: function enableContinue() {
      this.$el.find('#hustle-create-new-module').prop('disabled', false);
    },
    dismissModal: function dismissModal(e) {
      if (e) {
        e.preventDefault();
      }

      $.post(ajaxurl, {
        action: 'hustle_dismiss_notification',
        name: 'migrate_modal',
        _ajax_nonce: this.$el.data('nonce')
      });
    }
  });
  new migrationModalView();
});
Hustle.define('Modals.Preview', function ($) {
  'use strict';

  return Backbone.View.extend({
    el: '#hustle-dialog--preview',
    iframeWindow: null,
    events: {
      'click .hustle-modal-close': 'close',
      'click .hustle-preview-device-button': 'previewDeviceSelected',
      'click #hustle-preview-reload-module-button': 'reloadModuleClicked'
    },
    open: function open(moduleId, moduleType, $button) {
      var previewData = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
      this.displayModuleName(previewData);
      this.maybeHideReloadButton(moduleType);
      SUI.openModal('hustle-dialog--preview', $button, null, false, false);
      var data = {
        action: 'open',
        moduleId: moduleId,
        moduleType: moduleType,
        previewData: previewData
      };
      this.initiateIframe(data);
    },
    displayModuleName: function displayModuleName(previewData) {
      if (previewData) {
        this.$('#hustle-dialog--preview-description').html(previewData.module_name);
      }
    },
    maybeHideReloadButton: function maybeHideReloadButton(moduleType) {
      var $reloadButton = this.$('#hustle-preview-reload-module-button');

      if ('embedded' === moduleType) {
        $reloadButton.addClass('sui-hidden-important');
      } else {
        $reloadButton.removeClass('sui-hidden-important');
      }
    },
    initiateIframe: function initiateIframe(data) {
      var _this = this;

      var $iframe = this.$('#hustle-preview-iframe'); // Load the iframe the first time it's opened only.

      if ('undefined' === typeof $iframe.attr('src')) {
        $iframe[0].src = $iframe.data('src');
        $iframe.on('load', function () {
          var $previewContainer = _this.$('#hustle-preview-iframe-container'); // Remove the "loading" container after the iframe's page loads and show the iframe.


          $previewContainer.show();
          $previewContainer.removeAttr('aria-hidden');

          _this.$('#hustle-preview-loader').remove();

          _this.iframeWindow = $iframe[0].contentWindow;

          _this.talkToIframe(data);
        });
      } else {
        // Prevent the "finished loading" message from being read each time the modal is opened.
        this.$('#hustle-sr-text-preview-loaded').remove();
        this.talkToIframe(data);
      }
    },
    close: function close() {
      var _this2 = this;

      // Delay this a bit so the modal is closed before emptying the preview containers.
      setTimeout(function () {
        return _this2.talkToIframe({
          action: 'close'
        });
      }, 500);
    },
    reloadModuleClicked: function reloadModuleClicked() {
      this.talkToIframe({
        action: 'reload'
      });
    },
    previewDeviceSelected: function previewDeviceSelected(e) {
      var $button = $(e.currentTarget),
          device = $button.data('device');
      this.$('.hustle-preview-device-button').removeClass('sui-active');
      $button.addClass('sui-active');
      this.$('#hustle-sr-text-preview-selected-device').html($button.data('selected'));

      if ('desktop' === device) {
        this.$el.removeClass('hustle-preview-mobile');
        this.$el.addClass('hustle-preview-desktop');
      } else if ('mobile' === device) {
        this.$el.removeClass('hustle-preview-desktop');
        this.$el.addClass('hustle-preview-mobile');
      }
    },
    talkToIframe: function talkToIframe(message) {
      // Avoid sending messages if the iframe isn't initialized.
      if (this.iframeWindow) {
        this.iframeWindow.postMessage(message, window.location);
      }
    }
  });
});
Hustle.define('Modals.ReleaseHighlight', function ($) {
  'use strict';

  var welcomeModalView = Backbone.View.extend({
    el: '#hustle-dialog--release-highlight',
    // TODO: replace these by 'on modal open' action when upgrading SUI.
    events: {
      'click #hustle-release-highlight-action-button': 'actionButtonClicked',
      'click [data-modal-close]': 'dismissModal',
      keyup: 'maybeDismissModal'
    },
    initialize: function initialize() {
      var _this = this;

      if (!this.$el.length) {
        return;
      }

      setTimeout(function () {
        return _this.show();
      }, 100);
    },
    show: function show() {
      var _this2 = this;

      if ('undefined' === typeof SUI) {
        setTimeout(function () {
          return _this2.show();
        }, 100);
        return;
      }

      SUI.openModal('hustle-dialog--release-highlight', $('.sui-header-title')[0], this.$('.hustle-modal-close'), true);
      this.$el.siblings('.sui-modal-overlay').on('click', function () {
        return _this2.dismissModal();
      });
    },
    actionButtonClicked: function actionButtonClicked(e) {
      e.preventDefault();
      this.dismissModal();
      SUI.closeModal();
    },
    maybeDismissModal: function maybeDismissModal(e) {
      var key = e.which || e.keyCode;

      if (27 === key) {
        this.dismissModal();
      }
    },
    dismissModal: function dismissModal(e) {
      if (e) {
        e.preventDefault();
      }

      return $.post(ajaxurl, {
        action: 'hustle_dismiss_notification',
        name: 'release_highlight_modal_431',
        _ajax_nonce: this.$el.data('nonce')
      });
    }
  });
  new welcomeModalView();
});
Hustle.define('Modals.ReviewConditions', function ($) {
  'use strict';

  var ReviewConditionsModalView = Backbone.View.extend({
    el: '#hustle-dialog--review_conditions',
    events: {
      'click .hustle-review-conditions-dismiss': 'dismissModal'
    },
    initialize: function initialize() {
      if (!this.$el.length) {
        return;
      }

      setTimeout(this.show, 100, this);
    },
    show: function show(reviewConditions) {
      if ('undefined' === typeof SUI || 'undefined' === typeof SUI.openModal) {
        setTimeout(reviewConditions.show, 100, reviewConditions);
        return;
      }

      SUI.openModal('hustle-dialog--review_conditions', $('.sui-header-title'));
    },
    dismissModal: function dismissModal() {
      $.post(ajaxurl, {
        action: 'hustle_dismiss_notification',
        name: '41_visibility_behavior_update',
        _ajax_nonce: this.$el.data('nonce')
      });
    }
  });
  new ReviewConditionsModalView();
});
Hustle.define('Upgrade_Modal', function () {
  'use strict';

  return Backbone.View.extend({
    el: '#wph-upgrade-modal',
    opts: {},
    events: {
      'click .wpmudev-i_close': 'close'
    },
    initialize: function initialize(options) {
      this.opts = _.extend({}, this.opts, options);
    },
    close: function close(e) {
      e.preventDefault();
      e.stopPropagation();
      this.$el.removeClass('wpmudev-modal-active');
    }
  });
});
Hustle.define('Modals.Welcome', function ($) {
  'use strict';

  var welcomeModalView = Backbone.View.extend({
    el: '#hustle-dialog--welcome',
    events: {
      'click #hustle-new-create-module': 'createModule',
      'click .sui-box-selector': 'enableContinue',
      'click #getStarted': 'dismissModal',
      'click .sui-modal-skip': 'dismissModal',
      'click .hustle-button-dismiss-welcome': 'dismissModal'
    },
    initialize: function initialize() {
      if (!this.$el.length) {
        return;
      }

      setTimeout(this.show, 100, this);
    },
    show: function show(self) {
      if ('undefined' === typeof SUI) {
        setTimeout(self.show, 100, self);
        return;
      }

      SUI.openModal('hustle-dialog--welcome', $('.sui-header-title')[0], self.$('#hustle-dialog--welcome-first .sui-button-icon.hustle-button-dismiss-welcome'), true);
      SUI.slideModal('hustle-dialog--welcome-first');
    },
    createModule: function createModule(e) {
      var button = $(e.target),
          $selection = this.$el.find('.sui-box-selector input:checked');

      if ($selection.length) {
        button.addClass('sui-button-onload');
        var moduleType = $selection.val(),
            page = 'undefined' !== typeof optinVars.module_page[moduleType] ? optinVars.module_page[moduleType] : optinVars.module_page.popup;
        window.location = "?page=".concat(page, "&create-module=true");
      }

      e.preventDefault();
    },
    enableContinue: function enableContinue() {
      this.$el.find('#hustle-new-create-module').prop('disabled', false);
    },
    dismissModal: function dismissModal(e) {
      if (e) {
        e.preventDefault();
      }

      $.post(ajaxurl, {
        action: 'hustle_dismiss_notification',
        name: 'welcome_modal',
        _ajax_nonce: this.$el.data('nonce')
      });
    }
  });
  new welcomeModalView();
});
Hustle.define('imageUploader', function () {
  'use strict';

  return Backbone.View.extend({
    events: {
      'click .hustle-image-uploader-browse': 'open',
      'click .hustle-image-uploader-clear': 'clear'
    },
    mediaFrame: false,
    initialize: function initialize(options) {
      this.attribute = options.attribute;

      if (!this.model || !this.attribute) {
        throw new Error('Undefined model or attribute.');
      }

      this.render();
    },
    render: function render() {
      this.defineMediaFrame();
      return this;
    },
    // If no image is set, show the upload button. Display the selected image otherwise.
    showImagePreviewOrButton: function showImagePreviewOrButton() {
      var selectedImage = this.model.get(this.attribute);

      if ('' === selectedImage || 'undefined' === typeof selectedImage) {
        this.$el.removeClass('sui-has_file');
      } else {
        this.$el.addClass('sui-has_file');
      }
    },
    defineMediaFrame: function defineMediaFrame() {
      var self = this;
      this.mediaFrame = wp.media({
        title: optinVars.media_uploader.select_or_upload,
        button: {
          text: optinVars.media_uploader.use_this_image
        },
        multiple: false
      }).on('select', function () {
        var media = self.mediaFrame.state().get('selection').first().toJSON();
        var imageSrc, imageThumbnail;

        if (media && media.url) {
          imageSrc = media.url;
          imageThumbnail = '';
          self.model.set(self.attribute, imageSrc);

          if (media.sizes && media.sizes.thumbnail && media.sizes.thumbnail.url) {
            imageThumbnail = media.sizes.thumbnail.url;
          }

          self.$el.find('.sui-upload-file .hustle-upload-file-url').text(imageSrc);
          self.$el.find('.sui-image-preview').css('background-image', 'url( ' + imageThumbnail + ' )');
          self.showImagePreviewOrButton();
        }
      });
    },
    open: function open(e) {
      e.preventDefault();
      this.mediaFrame.open();
    },
    clear: function clear(e) {
      e.preventDefault();
      this.model.set(this.attribute, '');
      this.$el.find('.sui-upload-file .hustle-upload-file-url').text('');
      this.$el.find('.sui-image-preview').css('background-image', 'url()');
      this.showImagePreviewOrButton();
    }
  });
});
/* global tinyMCE */
Hustle.define('Modals.Edit_Field', function ($) {
  'use strict';

  return Backbone.View.extend({
    el: '#hustle-dialog--edit-field',
    events: {
      'click .sui-modal-overlay': 'closeModal',
      'click .hustle-modal-close': 'closeModal',
      'change input[name="time_format"]': 'changeTimeFormat',
      'click #hustle-apply-changes': 'applyChanges',
      'blur input[name="name"]': 'trimName',
      'change input': 'fieldUpdated',
      'click input[type="radio"]': 'fieldUpdated',
      'change select': 'fieldUpdated',
      'change input[name="version"]': 'handleCaptchaSave'
    },
    initialize: function initialize(options) {
      var _this = this;

      this.field = options.field;
      this.changed = {}; // Same as this.field, but with the values for the field's view. Won't be stored.

      this.fieldData = options.fieldData;
      this.model = options.model;
      this.render(); // TODO: Use SUI close action when we update SUI.

      setTimeout(function () {
        _this.$el.siblings('.sui-modal-overlay').on('click', function () {
          return _this.closeModal();
        });
      }, 500);
      this.$el.on('keyup', function (e) {
        var key = e.which || e.keyCode;

        if (27 === key) {
          _this.closeModal();
        }
      });
    },
    render: function render() {
      this.renderHeader();
      this.renderLabels();
      this.renderSettings();
      this.renderStyling();
      this.handleCaptchaSave(); //select the first tab

      this.$('.hustle-data-pane').first().trigger('click'); // Make the search box work within the modal.

      this.$('.sui-select').SUIselect2({
        dropdownParent: $('#hustle-dialog--edit-field .sui-box'),
        dropdownCssClass: 'sui-select-dropdown'
      });
    },
    renderHeader: function renderHeader() {
      var $tagContainer = this.$('.hustle-field-tag-container');

      if (!$tagContainer.length) {
        this.$('.sui-box-header').append('<div class="sui-actions-left hustle-field-tag-container"><span class="sui-tag"></span></div>');
      }

      this.$('.sui-box-header .sui-tag').text(this.field.type);
    },
    renderLabels: function renderLabels() {
      if (-1 !== $.inArray(this.field.type, ['recaptcha', 'gdpr', 'submit'])) {
        this.$('#hustle-data-tab--labels').removeClass('hustle-data-pane').addClass('sui-hidden');
        this.$('#hustle-data-pane--labels').addClass('sui-hidden');
        return;
      }

      this.$('#hustle-data-tab--labels').removeClass('sui-hidden').addClass('hustle-data-pane');
      this.$('#hustle-data-pane--labels').removeClass('sui-hidden'); // Check if a specific template for this field exists.

      var templateId = 'hustle-' + this.field.type + '-field-labels-tpl'; // If a specific template doesn't exist, use the common template.

      if (!$('#' + templateId).length) {
        templateId = 'hustle-common-field-labels-tpl';
      }

      var template = Optin.template(templateId);
      this.$('#hustle-data-pane--labels').html(template(this.fieldData));
      Hustle.Events.trigger('view.rendered', this);
    },
    renderSettings: function renderSettings() {
      if ('hidden' === this.field.type) {
        this.$('#hustle-data-tab--settings').removeClass('hustle-data-pane').addClass('sui-hidden');
        this.$('#hustle-data-pane--settings').addClass('sui-hidden');
        Module.Utils.accessibleHide(this.$('[data-tabs]'));
        return;
      }

      Module.Utils.accessibleShow(this.$('[data-tabs]'));
      this.$('#hustle-data-tab--settings').removeClass('sui-hidden').addClass('hustle-data-pane');
      this.$('#hustle-data-pane--settings').removeClass('sui-hidden'); // Fixes a bug caused by tinyMCE used in a popup.

      $(document).on('focusin', function (e) {
        if ($(e.target).closest('.wp-link-input').length) {
          e.stopImmediatePropagation();
        }
      }); // Check if a specific template for this field exists.

      var templateId = 'hustle-' + this.field.type + '-field-settings-tpl'; // If a specific template doesn't exist, use the common template.

      if (!$('#' + templateId).length) {
        templateId = 'hustle-common-field-settings-tpl';
      }

      var template = Optin.template(templateId);
      this.$('#hustle-data-pane--settings').html(template(this.fieldData));
      Hustle.Events.trigger('view.rendered', this);

      if ('gdpr' === this.field.type) {
        // These only allow inline elements.
        var editorSettings = {
          tinymce: {
            wpautop: false,
            toolbar1: 'bold,italic,strikethrough,link',
            valid_elements: 'a[href|target=_blank],strong/b,i,u,s,em,del',
            // eslint-disable-line camelcase
            forced_root_block: '' // eslint-disable-line camelcase

          },
          quicktags: {
            buttons: 'strong,em,del,link'
          }
        };
        wp.editor.remove('gdpr_message');
        wp.editor.initialize('gdpr_message', editorSettings);
      } else if ('recaptcha' === this.field.type) {
        var _editorSettings = {
          tinymce: {
            toolbar: ['bold italic link alignleft aligncenter alignright']
          },
          quicktags: true
        };
        wp.editor.remove('v3_recaptcha_badge_replacement');
        wp.editor.initialize('v3_recaptcha_badge_replacement', _editorSettings);
        wp.editor.remove('v2_invisible_badge_replacement');
        wp.editor.initialize('v2_invisible_badge_replacement', _editorSettings);
      }
    },
    renderStyling: function renderStyling() {
      if ('hidden' === this.field.type) {
        this.$('#hustle-data-tab--styling').removeClass('hustle-data-pane').addClass('sui-hidden');
        this.$('#hustle-data-pane--styling').addClass('sui-hidden');
        return;
      }

      this.$('#hustle-data-tab--styling').removeClass('sui-hidden').addClass('hustle-data-pane');
      this.$('#hustle-data-pane--styling').removeClass('sui-hidden'); // Check if a specific template for this field exists.

      var templateId = 'hustle-' + this.field.type + '-field-styling-tpl'; // If a specific template doesn't exist, use the common template.

      if (!$('#' + templateId).length) {
        templateId = 'hustle-common-field-styling-tpl';
      }

      var template = Optin.template(templateId);
      this.$('#hustle-data-pane--styling').html(template(this.fieldData));
    },
    fieldUpdated: function fieldUpdated(e) {
      var $this = $(e.target),
          dataName = $this.attr('name'),
          dataValue = $this.is(':checkbox') ? $this.is(':checked') : $this.val();
      this.changed[dataName] = dataValue;
    },
    closeModal: function closeModal() {
      this.undelegateEvents();
      this.stopListening();
    },
    changeTimeFormat: function changeTimeFormat(e) {
      var $this = $(e.target),
          dataValue = $this.val();

      if ('12' === dataValue) {
        $('#hustle-date-format').closest('.sui-form-field').show();
        $('input[name="time_hours"]').prop('min', 1).prop('max', 12);
      } else {
        $('#hustle-date-format').closest('.sui-form-field').hide();
        $('input[name="time_hours"]').prop('min', 0).prop('max', 23);
      }
    },
    handleCaptchaSave: function handleCaptchaSave() {
      if ('recaptcha' !== this.field.type) {
        return;
      }

      var avaiableCaptcha = $('#available_recaptchas').val();

      if (avaiableCaptcha) {
        avaiableCaptcha = avaiableCaptcha.split(',');
        var version = $('input[name="version"]:checked').val();

        if (-1 === _.indexOf(avaiableCaptcha, version)) {
          $('#hustle-dialog--edit-field').find('#hustle-apply-changes').attr('disabled', 'disabled');
        } else {
          $('#hustle-dialog--edit-field').find('#hustle-apply-changes').attr('disabled', false);
        }
      } else {
        $('#hustle-dialog--edit-field').find('#hustle-apply-changes').attr('disabled', 'disabled');
      }
    },

    /**
     * Trim and replace spaces in field name.
     *
     * @since 4.0.0
     * @param {Object} e
     */
    trimName: function trimName(e) {
      var $input = this.$(e.target),
          newVal = $.trim($input.val()).replace(/ /g, '_');
      $input.val(newVal);
    },

    /**
     * Add the saved settings to the model.
     *
     * @since 4.0.0
     * @param {Object} e
     */
    applyChanges: function applyChanges(e) {
      // TODO: do validation
      // TODO: keep consistency with how stuff is saved in visibility conditions
      var self = this,
          $button = this.$(e.target),
          formFields = Object.assign({}, this.model.get('form_elements')); // if gdpr message

      if ('gdpr' === this.field.type && 'undefined' !== typeof tinyMCE) {
        // gdpr_message editor
        var gdprMessageEditor = tinyMCE.get('gdpr_message'),
            $gdprMessageTextarea = this.$('textarea#gdpr_message'),
            gdprMessage = 'true' === $gdprMessageTextarea.attr('aria-hidden') ? gdprMessageEditor.getContent() : $gdprMessageTextarea.val();
        this.changed.gdpr_message = gdprMessage; // eslint-disable-line camelcase
      } else if ('recaptcha' === this.field.type && 'undefined' !== typeof tinyMCE) {
        // v3 recaptcha badge editor.
        var v3messageEditor = tinyMCE.get('v3_recaptcha_badge_replacement'),
            $v3messageTextarea = this.$('textarea#v3_recaptcha_badge_replacement'),
            v3message = 'true' === $v3messageTextarea.attr('aria-hidden') ? v3messageEditor.getContent() : $v3messageTextarea.val();
        this.changed.v3_recaptcha_badge_replacement = v3message; // eslint-disable-line camelcase
        // v2 invisible badge editor.

        var v2messageEditor = tinyMCE.get('v2_invisible_badge_replacement'),
            $v2messageTextarea = this.$('textarea#v2_invisible_badge_replacement'),
            v2message = 'true' === $v2messageTextarea.attr('aria-hidden') ? v2messageEditor.getContent() : $v2messageTextarea.val();
        this.changed.v2_invisible_badge_replacement = v2message; // eslint-disable-line camelcase
      } // If there were changes.


      if (Object.keys(this.changed).length) {
        var oldField = _.extend({}, this.field);

        _.extend(this.field, this.changed); // Don't allow to override Email field created by default
        // and prevent field's names from being empty.


        if ('name' in this.changed && 'email' !== oldField.name && 'email' === this.field.name || 'name' in this.changed && !this.field.name.trim().length) {
          this.field.name = oldField.name;
          delete this.changed.name;
        } // "Name" is the unique identifier. If it changed, return and let the callback handle it.


        if (!('name' in this.changed) && 'email' !== oldField.name) {
          // Update this field.
          formFields[this.field.name] = this.field; // Alternative to deep cloning the formFields object to trigger 'change' in the model.

          this.model.unset('form_elements', {
            silent: true
          });
          this.model.set('form_elements', formFields);
        } else if ('email' === oldField.name) {
          this.field.name = 'email';
          delete this.changed.name;
        }

        this.trigger('field:updated', this.field, this.changed, oldField);
      }

      $button.addClass('sui-button-onload');
      setTimeout(function () {
        self.closeModal();
        $button.removeClass('sui-button-onload');
      }, 300);
    }
  });
});
/* global moment */
Hustle.define('Modals.EditSchedule', function ($) {
  'use strict';

  return Backbone.View.extend({
    el: '#hustle-schedule-dialog-content',
    dialogId: 'hustle-dialog--add-schedule',
    events: {
      'click #hustle-schedule-save': 'saveSchedule',
      'click .hustle-schedule-cancel': 'cancel',
      'click .hustle-schedule-delete': 'openDeleteModal',
      // Change events.
      'change .hustle-checkbox-with-dependencies input[type="checkbox"]': 'checkboxWithDependenciesChanged',
      'change select[name="custom_timezone"]': 'customTimezoneChanged'
    },
    initialize: function initialize(opts) {
      this.model = opts.model;
    },
    open: function open() {
      var modalId = this.dialogId;
      var focusAfterClosed = 'hustle-schedule-focus';
      var focusWhenOpen = undefined;
      var hasOverlayMask = false;
      this.renderContent();
      $('.hustle-datepicker-field').datepicker({
        beforeShow: function beforeShow() {
          $('#ui-datepicker-div').addClass('sui-calendar');
        },
        dateFormat: 'm/d/yy'
      }); // Make the search box work within the modal.

      this.$('.sui-select').SUIselect2({
        dropdownParent: $("#".concat(this.dialogId, " .sui-box")),
        dropdownCssClass: 'sui-select-dropdown'
      });
      SUI.openModal(modalId, focusAfterClosed, focusWhenOpen, hasOverlayMask);
    },
    renderContent: function renderContent() {
      var template = Optin.template('hustle-schedule-dialog-content-tpl'),
          $container = $('#hustle-schedule-dialog-content'),
          data = Object.assign({}, this.model.get('schedule'));
      data.is_schedule = this.model.get('is_schedule'); // eslint-disable-line camelcase

      data.serverCurrentTime = this.getTimeToDisplay('server');
      data.customCurrentTime = this.getTimeToDisplay('custom');
      this.setElement(template(data));
      $container.html(this.$el); // Bind SUI elements again.

      Hustle.Events.trigger('view.rendered', this); // We hide/show some elements on change, so keep the view displaying what it should when re-rendering the modal.

      this.refreshViewOnRender(data);
    },
    refreshViewOnRender: function refreshViewOnRender(data) {
      // Hide/show dependent elements.
      this.$('.hustle-checkbox-with-dependencies input').each(function () {
        $(this).trigger('change');
      }); // Display the correct tab.

      if ('server' === data.time_to_use) {
        $('#tab-timezone-server').click();
      } else {
        $('#tab-timezone-custom').click();
      } // Display the correct tab.


      if ('all' === data.active_days) {
        $('#tab-schedule-everyday').click();
      } else {
        $('#tab-schedule-somedays').click();
      } // Comparing the model's value with the value selected in the "select" element.


      var timezoneSelectValue = this.$('select[name="custom_timezone"]').val(),
          timezoneModelValue = data.custom_timezone; // We're retrieving the timezone options from a wp function, so we can't
      // update its selected value on js render as we do with other selects.

      if (timezoneModelValue !== timezoneSelectValue) {
        this.$('select[name="custom_timezone"]').val(timezoneModelValue).trigger('change');
      }
    },
    getTimeToDisplay: function getTimeToDisplay(source) {
      var timezone = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      var settings = this.model.get('schedule');
      var utcOffset = false,
          currentTime = false;

      if ('server' === source) {
        utcOffset = optinVars.schedule.wp_gmt_offset || 0;
      } else {
        var customTimezone = timezone || settings.custom_timezone;

        if (customTimezone.includes('UTC')) {
          var selectedOffset = customTimezone.replace('UTC', ''); // There's a timezone with the value "UTC".

          utcOffset = selectedOffset.length ? parseFloat(selectedOffset) : 0;
        } else {
          var endMoment = moment().tz(customTimezone);
          currentTime = endMoment.format('hh:mm a');
        }
      } // Calculate the time with the manual offset.
      // Moment.js doesn't support manual offsets with decimals, so not using it here.


      if (false === currentTime && false !== utcOffset) {
        // This isn't the correct timestamp for the given offset.
        // We just want to display the time for reference.
        var timestamp = Date.now() + utcOffset * 3600 * 1000,
            _endMoment = moment.utc(timestamp);

        currentTime = _endMoment.format('hh:mm a');
      }

      return currentTime;
    },
    saveSchedule: function saveSchedule(e) {
      var $button = $(e.currentTarget),
          data = this.processFormForSave(),
          wasScheduled = '1' === this.model.get('is_schedule');
      $button.addClass('sui-button-onload');
      $button.prop('disabled', true);
      setTimeout(function () {
        $button.removeClass('sui-button-onload');
        $button.prop('disabled', false);
      }, 500);
      this.model.set('is_schedule', '1');
      this.model.set('schedule', data);
      this.model.userHasChange();
      this.closeModal(); // Display a notification only when the schedule wasn't set, but now it is.

      if (!wasScheduled) {
        Module.Notification.open('success', optinVars.schedule.new_schedule_set, false);
      }

      this.trigger('schedule:updated');
    },
    processFormForSave: function processFormForSave() {
      var $form = $('#hustle-edit-schedule-form');
      var data = Module.Utils.serializeObject($form);
      return data;
    },
    cancel: function cancel() {
      this.renderContent();
      this.closeModal();
    },
    openDeleteModal: function openDeleteModal(e) {
      var dialogId = 'hustle-dialog--delete-schedule',
          template = Optin.template('hustle-delete-schedule-dialog-content-tpl'),
          $this = $(e.currentTarget),
          data = {
        id: $this.data('id'),
        title: $this.data('title'),
        description: $this.data('description'),
        action: 'delete',
        actionClass: 'hustle-button-delete'
      },
          newFocusAfterClosed = 'hustle-schedule-notice',
          newFocusFirst = undefined,
          hasOverlayMask = true,
          content = template(data),
          footer = $('#' + dialogId + ' #hustle-delete-schedule-dialog-content'),
          deleteButton = footer.find('button.hustle-delete-confirm'); // Add the templated content to the modal.

      if (!deleteButton.length) {
        footer.append(content);
      } // Add the title to the modal.


      $('#' + dialogId + ' #hustle-dialog--delete-schedule-title').html(data.title);
      $('#' + dialogId + ' #hustle-dialog--delete-schedule-description').html(data.description);
      SUI.replaceModal(dialogId, newFocusAfterClosed, newFocusFirst, hasOverlayMask);
      $('#hustle-delete-schedule-dialog-content').off('submit').on('submit', $.proxy(this.deactivateSchedule, this));
    },
    deactivateSchedule: function deactivateSchedule(e) {
      e.preventDefault();
      this.closeModal();
      this.model.set('is_schedule', '0');
      this.model.userHasChange();
      this.trigger('schedule:updated');
    },
    checkboxWithDependenciesChanged: function checkboxWithDependenciesChanged(e) {
      var $this = $(e.currentTarget),
          disableWhenOn = $this.data('disable-on'),
          hideWhenOn = $this.data('hide-on');

      if (disableWhenOn) {
        var $dependencies = this.$("[data-checkbox-content=\"".concat(disableWhenOn, "\"]"));

        if ($this.is(':checked')) {
          $dependencies.addClass('sui-disabled');
          $dependencies.prop('disabled', true);

          if ($dependencies.parent().hasClass('select-container')) {
            $dependencies.parent().addClass('sui-disabled');
          }
        } else {
          $dependencies.removeClass('sui-disabled');
          $dependencies.prop('disabled', false);

          if ($dependencies.parent().hasClass('select-container')) {
            $dependencies.parent().removeClass('sui-disabled');
          }
        }
      }

      if (hideWhenOn) {
        var _$dependencies = this.$("[data-checkbox-content=\"".concat(hideWhenOn, "\"]"));

        if ($this.is(':checked')) {
          Module.Utils.accessibleHide(_$dependencies);
        } else {
          Module.Utils.accessibleShow(_$dependencies);
        }
      }
    },
    customTimezoneChanged: function customTimezoneChanged(e) {
      var value = $(e.currentTarget).val(),
          timeContainer = this.$('#hustle-custom-timezone-current-time'),
          currentTime = this.getTimeToDisplay('custom', value);
      timeContainer.text(currentTime);
    },
    closeModal: function closeModal() {
      $('.hustle-datepicker-field').datepicker('destroy');
      SUI.closeModal();
    }
  });
});
Hustle.define('Modals.Optin_Fields', function () {
  'use strict';

  return Backbone.View.extend({
    el: '#hustle-dialog--optin-fields',
    model: {},
    selectedFields: [],
    events: {
      'click .sui-box-selector input': 'selectFields',
      'click .hustle-modal-close': 'closeModalActions',
      'click #hustle-insert-fields': 'insertFields'
    },
    initialize: function initialize(options) {
      var _this = this;

      this.model = options.model;
      this.selectedFields = []; // The overlay is outside the view, but we need to do some actions on close.

      this.$el.siblings('.sui-modal-overlay').on('click', function () {
        return _this.closeModalActions();
      });
    },
    // TODO: don't make them selected on click, but on "Insert fields".
    selectFields: function selectFields(e) {
      var $input = this.$(e.target),
          value = $input.val(),
          $selectorLabel = this.$el.find('label[for="' + $input.attr('id') + '"]');
      $selectorLabel.toggleClass('selected');

      if ($input.prop('checked')) {
        this.selectedFields.push(value);
      } else {
        this.selectedFields = _.without(this.selectedFields, value);
      }
    },
    insertFields: function insertFields(e) {
      var self = this,
          $button = this.$(e.target);
      $button.addClass('sui-button-onload');
      this.trigger('fields:added', this.selectedFields);
      setTimeout(function () {
        $button.removeClass('sui-button-onload');
        self.closeModalActions();
        SUI.closeModal();
      }, 500);
    },
    closeModalActions: function closeModalActions() {
      this.undelegateEvents();
      this.stopListening();
      var selectedFieldsNames = Object.keys(this.model.get('form_elements'));
      var selector = '.sui-box-selector'; // Don't deselect reCAPTCHA if it's added.

      if (selectedFieldsNames.includes('recaptcha')) {
        selector += ':not(.hustle-optin-insert-field-label--recaptcha)';
      } // Don't deselect GDPR if it's added.


      if (selectedFieldsNames.includes('gdpr')) {
        selector += ':not(.hustle-optin-insert-field-label--gdpr)';
      }

      var $label = this.$el.find(selector),
          $input = $label.find('input');
      setTimeout(function () {
        // Uncheck options
        $label.removeClass('selected');
        $input.prop('checked', false);
        $input[0].checked = false;
      }, 200);
    }
  });
});
Hustle.define('Modals.PublishFlow', function ($) {
  'use strict';

  return Backbone.View.extend({
    el: '#hustle-dialog--publish-flow',
    initialize: function initialize() {},
    open: function open() {
      var $icon = this.$('#hustle-dialog--publish-flow-icon'); // We're adding this via js to be able to use the php template, which isn't handling icons like this as of now.

      if (!$icon.length) {
        $icon = $('<span id="hustle-dialog--publish-flow-icon" class="sui-lg" aria-hidden="true" style="margin-bottom: 20px;"></span>');
        $icon.insertBefore('#hustle-dialog--publish-flow-title');
      }

      this.setLoading(); // Remove max-height from bottom image.

      this.$('.sui-box').find('.sui-image').css('max-height', '');
      SUI.openModal('hustle-dialog--publish-flow', $('.hustle-publish-button')[0], this.$('.hustle-modal-close')[0], true);
    },
    setLoading: function setLoading() {
      var $icon = this.$('#hustle-dialog--publish-flow-icon'),
          $content = this.$('.sui-box'),
          $closeButton = this.$('.sui-box-header .hustle-modal-close'),
          $title = this.$('#hustle-dialog--publish-flow-title'),
          $desc = this.$('#hustle-dialog--publish-flow-description'),
          $scheduleNotice = this.$('#hustle-published-notice-with-schedule-end');
      $icon.removeClass('sui-icon-' + $content.data('ready-icon'));
      $icon.addClass('sui-icon-' + $content.data('loading-icon'));

      if ('loader' === $content.attr('data-loading-icon')) {
        $icon.addClass('sui-loading');
      }

      $title.text($content.data('loading-title'));
      $desc.text($content.data('loading-desc'));
      $scheduleNotice.hide();
      $closeButton.hide();
    },
    setPublished: function setPublished(isScheduled, hasEnd) {
      var $icon = this.$('#hustle-dialog--publish-flow-icon'),
          $content = this.$('.sui-box'),
          $closeButton = this.$('.sui-box-header .hustle-modal-close'),
          $title = this.$('#hustle-dialog--publish-flow-title'),
          $desc = this.$('#hustle-dialog--publish-flow-description'),
          $scheduleNotice = this.$('#hustle-published-notice-with-schedule-end'),
          descText = !isScheduled ? $content.data('ready-desc') : $content.data('ready-desc-alt');
      $icon.removeClass('sui-icon-' + $content.data('loading-icon'));
      $icon.addClass('sui-icon-' + $content.data('ready-icon'));

      if ('loader' === $content.attr('data-loading-icon')) {
        $icon.removeClass('sui-loading');
      } // Display the notice for when the schedule has an end.


      if (isScheduled && hasEnd) {
        $content.find('.sui-image').css('max-height', '120px');
        $scheduleNotice.show();
      } else {
        $scheduleNotice.hide();
      }

      $title.text($content.data('ready-title'));
      $desc.text(descText); // Focus ready title
      // This will help screen readers know when module has been published

      $title.focus();
      $closeButton.show();
    }
  });
});
function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

Hustle.define('Modals.Visibility_Conditions', function ($) {
  'use strict';

  return Backbone.View.extend({
    el: '#hustle-dialog--visibility-options',
    selectedConditions: [],
    opts: {
      groupId: 0,
      conditions: []
    },
    events: {
      'click .sui-box-selector input': 'selectConditions'
    },
    initialize: function initialize(options) {
      $('#hustle-add-conditions').off('click').on('click', $.proxy(this.addConditions, this));
      this.opts = _.extend({}, this.opts, options);
      this.selectedConditions = this.opts.conditions;
      this.$('.hustle-visibility-condition-option').prop('checked', false).prop('disabled', false);

      var _iterator = _createForOfIteratorHelper(this.selectedConditions),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var conditionId = _step.value;
          this.$('#hustle-condition--' + conditionId).prop('checked', true).prop('disabled', true);
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }
    },
    selectConditions: function selectConditions(e) {
      var $input = this.$(e.target),
          $selectorLabel = this.$el.find('label[for="' + $input.attr('id') + '"]'),
          value = $input.val();
      $selectorLabel.toggleClass('selected');

      if ($input.prop('checked')) {
        this.selectedConditions.push(value);
      } else {
        this.selectedConditions = _.without(this.selectedConditions, value);
      }
    },
    addConditions: function addConditions(e) {
      var me = this,
          $button = this.$(e.target);
      $button.addClass('sui-button-onload');
      this.trigger('conditions:added', {
        groupId: this.opts.groupId,
        conditions: this.selectedConditions
      });
      setTimeout(function () {
        // Hide dialog
        SUI.closeModal();
        $button.removeClass('sui-button-onload');
        me.undelegateEvents();
      }, 500);
    }
  });
});
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/* global Chart */
(function ($) {
  'use strict';

  Optin.listingBase = Hustle.View.extend({
    el: '.sui-wrap-hustle',
    logShown: false,
    moduleType: '',
    singleModuleActionNonce: '',
    previewView: null,
    _events: {
      // Modals.
      'click .hustle-create-module': 'openCreateModal',
      'click .hustle-delete-module-button': 'openDeleteModal',
      'click .hustle-module-tracking-reset-button': 'openResetTrackingModal',
      'click .hustle-manage-tracking-button': 'openManageTrackingModal',
      'click .hustle-import-module-button': 'openImportModal',
      'click .hustle-upgrade-modal-button': 'openUpgradeModal',
      // Modules' actions.
      'click .hustle-single-module-button-action': 'handleSingleModuleAction',
      'click .hustle-preview-module-button': 'previewModule',
      // Bulk actions.
      'click form.sui-bulk-actions .hustle-bulk-apply-button': 'bulkActionCheck',
      'click #hustle-dialog--delete .hustle-delete': 'bulkActionSend',
      'click #hustle-bulk-action-reset-tracking-confirmation .hustle-delete': 'bulkActionSend',
      // Utilities.
      'click .sui-accordion-item-action .hustle-onload-icon-action': 'addLoadingIconToActionsButton'
    },
    initialize: function initialize(opts) {
      this.events = $.extend(true, {}, this.events, this._events);
      this.delegateEvents();
      this.moduleType = opts.moduleType;
      this.singleModuleActionNonce = optinVars.single_module_action_nonce;
      var newModuleModal = Hustle.get('Modals.New_Module'),
          importModal = Hustle.get('Modals.ImportModule');
      this.newModuleModal = new newModuleModal({
        moduleType: this.moduleType
      });
      this.ImportModal = new importModal(); // Why this doesn't work when added in events

      $('.sui-accordion-item-header').on('click', $.proxy(this.openTrackingChart, this)); // Open the tracking chart when the class is present. Used when coming from 'view tracking' in Dashboard.

      if ($('.hustle-display-chart').length) {
        this.openTrackingChart($('.hustle-display-chart'));
      }

      this.doActionsBasedOnUrl();
    },
    doActionsBasedOnUrl: function doActionsBasedOnUrl() {
      // Display the "Create module" dialog.
      if ('true' === Module.Utils.getUrlParam('create-module')) {
        setTimeout(function () {
          $('.hustle-create-module').trigger('click');
        }, 100);
      } // Display "Upgrade modal".


      if ('true' === Module.Utils.getUrlParam('requires-pro')) {
        var self = this;
        setTimeout(function () {
          return self.openUpgradeModal();
        }, 100);
      } // Display notice based on URL parameters.


      if (Module.Utils.getUrlParam('show-notice')) {
        var status = 'success' === Module.Utils.getUrlParam('show-notice') ? 'success' : 'error',
            notice = Module.Utils.getUrlParam('notice'),
            message = notice && 'undefined' !== optinVars.messages[notice] ? optinVars.messages[notice] : Module.Utils.getUrlParam('notice-message'),
            closeTimeParam = Module.Utils.getUrlParam('notice-close', null),
            closeTime = 'false' === closeTimeParam ? false : closeTimeParam;

        if ('undefined' !== typeof message && message.length) {
          Module.Notification.open(status, message, closeTime);
        }
      }
    },
    handleSingleModuleAction: function handleSingleModuleAction(e) {
      this.addLoadingIcon(e);
      Module.handleActions.initAction(e, 'listing', this);
    },
    previewModule: function previewModule(e) {
      e.preventDefault();
      var $button = $(e.currentTarget);
      this.getPreviewView().open($button.data('id'), $button.data('type'), $button, {
        module_name: $button.data('name')
      });
    },
    getPreviewView: function getPreviewView() {
      if (!this.previewView) {
        var previewView = Hustle.get('Modals.Preview');
        this.previewView = new previewView();
      }

      return this.previewView;
    },
    openTrackingChart: function openTrackingChart(e) {
      var flexHeader = '';

      if (e.target) {
        if ($(e.target).closest('.sui-accordion-item-action').length) {
          return true;
        }

        e.preventDefault();
        e.stopPropagation();
        flexHeader = $(e.currentTarget);
      } else {
        flexHeader = e;
      }

      var self = this,
          flexItem = flexHeader.parent();
      var flexChart = flexItem.find('.sui-chartjs-animated');

      if (flexItem.hasClass('sui-accordion-item--disabled')) {
        flexItem.removeClass('sui-accordion-item--open');
      } else if (flexItem.hasClass('sui-accordion-item--open')) {
        flexItem.removeClass('sui-accordion-item--open');
      } else {
        flexItem.addClass('sui-accordion-item--open');
      }

      flexItem.find('.sui-accordion-item-data').addClass('sui-onload');
      flexChart.removeClass('sui-chartjs-loaded');

      if (flexItem.hasClass('sui-accordion-item--open')) {
        var id = flexHeader.data('id'),
            nonce = flexHeader.data('nonce'),
            data = {
          id: id,
          _ajax_nonce: nonce,
          action: 'hustle_tracking_data'
        };
        $.ajax({
          url: ajaxurl,
          type: 'POST',
          data: data,
          success: function success(resp) {
            if (resp.success && resp.data) {
              flexItem.find('.sui-accordion-item-body').html(resp.data.html);
              self.trackingChart.init(flexItem, resp.data.charts_data);
              flexChart = flexItem.find('.sui-chartjs-animated'); // Init tabs

              SUI.suiTabs();
            }

            flexItem.find('.sui-accordion-item-data').removeClass('sui-onload');
            flexChart.addClass('sui-chartjs-loaded');
          },
          error: function error() {
            flexItem.find('.sui-accordion-item-data').removeClass('sui-onload');
            flexChart.addClass('sui-chartjs-loaded');
          }
        });
      }
    },
    getChecked: function getChecked(type) {
      var query = '.sui-wrap-hustle .sui-accordion-item-title input[type=checkbox]';

      if ('checked' === type) {
        query += ':checked';
      }

      return $(query);
    },
    bulkActionCheck: function bulkActionCheck(e) {
      var $this = $(e.target),
          value = $this.closest('.hustle-bulk-actions-container').find('select[name="hustle_action"] option:selected').val(),
          //$( 'select option:selected', $this.closest( '.sui-box' ) ).val(),
      elements = this.getChecked('checked');

      if (0 === elements.length || 'undefined' === value) {
        return false;
      }

      if ('delete' === value) {
        var data = {
          actionClass: 'hustle-delete',
          action: 'delete',
          title: $this.data('delete-title'),
          description: $this.data('delete-description')
        };
        Module.deleteModal.open(data, $this[0]);
        return false;
      } else if ('reset-tracking' === value) {
        var _data = {
          actionClass: 'hustle-delete',
          action: 'reset-tracking',
          title: $this.data('reset-title'),
          description: $this.data('reset-description')
        };
        Module.deleteModal.open(_data, $this[0]);
        return false;
      }

      this.bulkActionSend(e, value);
    },
    bulkActionSend: function bulkActionSend(e, action) {
      e.preventDefault();
      this.addLoadingIcon(e);
      var value = action ? action : $(e.target).data('hustle-action'),
          elements = this.getChecked('checked');

      if (0 === elements.length) {
        return false;
      }

      var ids = [];
      $.each(elements, function () {
        ids.push($(this).val());
      });
      var button = $('.sui-bulk-actions .hustle-bulk-apply-button'),
          data = {
        ids: ids,
        hustle: value,
        type: button.data('type'),
        _ajax_nonce: button.data('nonce'),
        action: 'hustle_listing_bulk'
      };
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: data,
        success: function success(resp) {
          if (resp.success) {
            location.reload();
          } else {
            SUI.closeModal(); //show error notice
          }
        }
      });
    },
    addLoadingIcon: function addLoadingIcon(e) {
      var $button = $(e.currentTarget);

      if ($button.hasClass('sui-button')) {
        $button.addClass('sui-button-onload');
      }
    },
    addLoadingIconToActionsButton: function addLoadingIconToActionsButton(e) {
      var $actionButton = $(e.currentTarget),
          $mainButton = $actionButton.closest('.sui-accordion-item-action').find('.sui-dropdown-anchor');
      $mainButton.addClass('sui-button-onload');
    },
    // ===================================
    // Modals
    // ===================================
    openCreateModal: function openCreateModal(e) {
      if (false === $(e.currentTarget).data('enabled')) {
        this.openUpgradeModal();
      } else {
        this.newModuleModal.open();
      }
    },
    openUpgradeModal: function openUpgradeModal(e) {
      var focusOnClose = this.$('#hustle-create-new-module')[0];

      if (e) {
        e.preventDefault();
        e.stopPropagation();
        focusOnClose = e.currentTarget;
      }

      $('.sui-button-onload').removeClass('sui-button-onload');

      if (!$('#hustle-modal--upgrade-to-pro').length) {
        return;
      }

      SUI.openModal('hustle-modal--upgrade-to-pro', focusOnClose, 'hustle-button--upgrade-to-pro', true);
    },
    openDeleteModal: function openDeleteModal(e) {
      e.preventDefault();
      var $this = $(e.currentTarget),
          data = {
        id: $this.data('id'),
        nonce: $this.data('nonce'),
        action: 'delete',
        title: $this.data('title'),
        description: $this.data('description'),
        actionClass: 'hustle-single-module-button-action'
      };
      Module.deleteModal.open(data, $this[0]);
    },
    openImportModal: function openImportModal(e) {
      var $this = $(e.currentTarget);

      if (false === $this.data('enabled')) {
        this.openUpgradeModal();
      } else {
        this.ImportModal.open(e);
      }
    },

    /**
     * The "are you sure?" modal from before resetting the tracking data of modules.
     *
     * @since 4.0.0
     * @param {Event} e Event.
     */
    openResetTrackingModal: function openResetTrackingModal(e) {
      e.preventDefault();
      var $this = $(e.target),
          data = {
        id: $this.data('module-id'),
        nonce: this.singleModuleActionNonce,
        action: 'reset-tracking',
        title: $this.data('title'),
        description: $this.data('description'),
        actionClass: 'hustle-single-module-button-action'
      };
      Module.deleteModal.open(data, $this[0]);
    },
    openManageTrackingModal: function openManageTrackingModal(e) {
      var template = Optin.template('hustle-manage-tracking-form-tpl'),
          $modal = $('#hustle-dialog--manage-tracking'),
          $button = $(e.currentTarget),
          moduleId = $button.data('module-id'),
          data = {
        //moduleID: $button.data( 'module-id' ),
        enabledTrackings: $button.data('tracking-types').split(',')
      };
      $modal.find('#hustle-manage-tracking-form-container').html(template(data));
      $modal.find('#hustle-button-toggle-tracking-types').data('module-id', moduleId);
      SUI.openModal('hustle-dialog--manage-tracking', $button, 'hustle-module-tracking--inline', true);
    },
    // ===================================
    // Tracking charts
    // ===================================

    /**
     * Renders the module's charts in the listing pages.
     * It also handles the view when the 'conversions type' select changes.
     *
     * @since 4.0.4
     */
    trackingChart: {
      chartsData: {},
      theCharts: {},
      init: function init($container, chartsData) {
        var _this = this;

        $container.find('select.hustle-conversion-type').each(function (i, el) {
          SUI.suiSelect(el);
          $(el).on('change.select2', function (e) {
            return _this.conversionTypeChanged(e, $container);
          });
        });
        this.chartsData = chartsData;
        Object.values(chartsData).forEach(function (chart) {
          return _this.updateChart(chart);
        });
      },
      conversionTypeChanged: function conversionTypeChanged(e, $container) {
        var $select = $(e.currentTarget),
            conversionType = $select.val(),
            moduleSubType = $select.data('moduleType'),
            subTypeChart = this.chartsData[moduleSubType],
            $conversionsCount = $container.find(".hustle-tracking-".concat(moduleSubType, "-conversions-count")),
            $conversionsRate = $container.find(".hustle-tracking-".concat(moduleSubType, "-conversions-rate")); // Update the number for the conversions count and conversion rate at the top of the chart.

        $conversionsCount.text(subTypeChart[conversionType].conversions_count);
        $conversionsRate.text(subTypeChart[conversionType].conversion_rate + '%');
        this.updateChart(subTypeChart, conversionType, false);
      },
      updateChart: function updateChart(chart) {
        var conversionType = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'all';
        var render = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
        var views = chart.views,
            submissions = chart[conversionType].conversions,
            datasets = [{
          label: 'Submissions',
          data: submissions,
          backgroundColor: ['#E1F6FF'],
          borderColor: ['#17A8E3'],
          borderWidth: 2,
          pointRadius: 0,
          pointHitRadius: 20,
          pointHoverRadius: 5,
          pointHoverBorderColor: '#17A8E3',
          pointHoverBackgroundColor: '#17A8E3'
        }, {
          label: 'Views',
          data: views,
          backgroundColor: ['#F8F8F8'],
          borderColor: ['#DDDDDD'],
          borderWidth: 2,
          pointRadius: 0,
          pointHitRadius: 20,
          pointHoverRadius: 5,
          pointHoverBorderColor: '#DDDDDD',
          pointHoverBackgroundColor: '#DDDDDD'
        }]; // The chart was already created. Update it.

        if ('undefined' !== typeof this.theCharts[chart.id]) {
          // The container has been re-rendered, so render the chart again.
          if (render) {
            this.theCharts[chart.id].destroy();
            this.createNewChart(chart, datasets);
          } else {
            // Just update the chart otherwise.
            this.theCharts[chart.id].data.datasets = datasets;
            this.theCharts[chart.id].update();
          }
        } else {
          this.createNewChart(chart, datasets);
        }
      },
      createNewChart: function createNewChart(chart, datasets) {
        var yAxesHeight = Math.max.apply(Math, _toConsumableArray(chart.views)) + 2;
        var chartContainer = document.getElementById(chart.id);

        if (Math.max.apply(Math, _toConsumableArray(chart.views)) < Math.max.apply(Math, _toConsumableArray(chart.conversions))) {
          yAxesHeight = Math.max.apply(Math, _toConsumableArray(chart.conversions)) + 2;
        }

        if (!chartContainer) {
          return;
        }

        var days = chart.days,
            chartData = {
          labels: days,
          datasets: datasets
        };
        var chartOptions = {
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              display: false,
              gridLines: {
                color: 'rgba(0, 0, 0, 0)'
              }
            }],
            yAxes: [{
              display: false,
              gridLines: {
                color: 'rgba(0, 0, 0, 0)'
              },
              ticks: {
                beginAtZero: false,
                min: 0,
                max: yAxesHeight,
                stepSize: 1
              }
            }]
          },
          elements: {
            line: {
              tension: 0
            },
            point: {
              radius: 0.5
            }
          },
          tooltips: {
            custom: function custom(tooltip) {
              if (!tooltip) {
                return;
              } // Disable displaying the color box


              tooltip.displayColors = false;
            },
            callbacks: {
              title: function title(tooltipItem) {
                if (0 === tooltipItem[0].datasetIndex) {
                  return optinVars.labels.submissions.replace('%d', tooltipItem[0].yLabel); // + ' Submissions';
                } else if (1 === tooltipItem[0].datasetIndex) {
                  return optinVars.labels.views.replace('%d', tooltipItem[0].yLabel); //+ ' Views';
                }
              },
              label: function label(tooltipItem) {
                return tooltipItem.xLabel;
              },
              // Set label text color
              labelTextColor: function labelTextColor() {
                return '#AAAAAA';
              }
            }
          }
        };
        this.theCharts[chart.id] = new Chart(chartContainer, {
          type: 'line',
          fill: 'start',
          data: chartData,
          options: chartOptions
        });
      }
    }
  });
})(jQuery);
Hustle.define('Modals.New_Module', function ($) {
  'use strict';

  return Backbone.View.extend({
    el: '#hustle-dialog--create-new-module',
    moduleType: '',
    moduleName: false,
    moduleMode: 'optin',
    moduleTemplate: 'none',
    $moveForwardButton: null,
    data: {},
    mainDialogLabelId: 'hustle-create-new-module-dialog-label',
    mainDialogDescriptionId: 'hustle-create-new-module-dialog-description',
    events: {
      'keydown input[name="name"]': 'nameChanged',
      'click #hustle-create-module': 'createModule',
      'change input[name="mode"]': 'modeChanged',
      'click #hustle-go-to-templates-button': 'goToTemplatesStep',
      'click .hustle-template-select-button': 'createNonSshare',
      'click .hustle-modal-go-back': 'goToStepOne'
    },
    initialize: function initialize(args) {
      this.moduleType = args.moduleType;
      var nextButtonSelector = 'social_sharing' !== this.moduleType ? '#hustle-go-to-templates-button' : '#hustle-create-module';
      this.$moveForwardButton = this.$(nextButtonSelector);
    },
    open: function open() {
      SUI.openModal('hustle-dialog--create-new-module', 'hustle-create-new-module', 'hustle-module-name');

      if ('social_sharing' !== this.moduleType) {
        this.goToStepOne();
      }
    },
    nameChanged: function nameChanged(e) {
      var _this = this;

      setTimeout(function () {
        _this.$('.sui-error-message').hide();

        var value = $(e.currentTarget).val().trim();

        if (0 === value.length) {
          _this.moduleName = false;

          _this.$moveForwardButton.prop('disabled', true);

          _this.$('#error-empty-name').closest('.sui-form-field').addClass('sui-form-field-error');

          _this.$('#error-empty-name').show();
        } else {
          _this.moduleName = value;

          _this.$moveForwardButton.prop('disabled', false);

          _this.$('#error-empty-name').closest('.sui-form-field').removeClass('sui-form-field-error');

          _this.$('#error-empty-name').hide();
        }
      }, 300);
    },
    modeChanged: function modeChanged(e) {
      var value = $(e.currentTarget).val();
      this.moduleMode = value;
    },
    goToStepOne: function goToStepOne(e) {
      var animation = e ? 'back' : null;
      this.$el.attr('aria-labelledby', this.mainDialogLabelId);
      this.$el.attr('aria-describedby', this.mainDialogDescriptionId);
      SUI.slideModal('hustle-create-new-module-step-1', 'hustle-module-name', animation);
    },
    goToTemplatesStep: function goToTemplatesStep(e) {
      e.preventDefault();

      if (this.isNameValid() && this.isModeValid()) {
        var stepId = 'optin' === this.moduleMode ? 'optin-templates' : 'informational-templates',
            stepLabelId = "hustle-create-new-module-dialog-step-".concat(stepId, "-label"),
            stepDescriptionId = "hustle-create-new-module-dialog-step-".concat(stepId, "-description");
        this.$el.attr('aria-labelledby', stepLabelId);
        this.$el.attr('aria-describedby', stepDescriptionId);
        SUI.slideModal("hustle-create-new-module-step-".concat(stepId), this.$el.find("#hustle-create-new-module-step-".concat(stepId, " .hustle-template-option--none"))[0], 'next');
      }
    },
    isNameValid: function isNameValid() {
      return false !== this.moduleName;
    },
    isModeValid: function isModeValid() {
      return 'optin' === this.moduleMode || 'informational' === this.moduleMode;
    },
    createNonSshare: function createNonSshare(e) {
      var selectedTemplate = $(e.currentTarget).data('template');
      this.moduleTemplate = selectedTemplate;
      this.createModule(e);
    },
    createModule: function createModule(e) {
      var nonce = this.$el.data('nonce'),
          errorMessage = this.$el.data('error-message'),
          $button = $(e.currentTarget),
          data = {
        module_name: this.moduleName,
        module_type: this.moduleType,
        module_mode: this.moduleMode,
        module_template: this.moduleTemplate,
        action: 'hustle_create_new_module',
        _ajax_nonce: nonce
      };
      $button.addClass('sui-button-onload');
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: data
      }).done(function (res) {
        // Go to the wizard of this type of module on success, or listing page if limits were reached.
        if (res && res.data && res.data.redirect_url) {
          window.location.replace(res.data.redirect_url);
        } else {
          $button.removeClass('sui-button-onload');
          Module.Notification.open('error', errorMessage, false);
        }
      }).fail(function () {
        $button.removeClass('sui-button-onload');
        Module.Notification.open('error', errorMessage, false);
      });
    }
  });
});
Hustle.define('Modals.ImportModule', function ($) {
  'use strict';

  return Backbone.View.extend({
    el: '#hustle-dialog--import',
    events: {
      'change #hustle-import-file-input': 'selectUploadFile',
      'click .sui-upload-file': 'changeFile',
      'click .sui-upload-file button': 'resetUploadFile',
      'click .hustle-import-check-all-checkbox': 'checkAll',
      'change .hustle-module-meta-checkbox': 'uncheckAllOption'
    },
    initialize: function initialize() {},
    open: function open(e) {
      var $this = $(e.currentTarget),
          moduleId = $this.data('module-id'),
          template = Optin.template('hustle-import-modal-options-tpl'),
          $importDialog = $('#hustle-dialog--import'),
          $submitButton = $importDialog.find('#hustle-import-module-submit-button'),
          isNew = 'undefined' === typeof moduleId,
          templateData = {
        isNew: isNew,
        isOptin: 'optin' === $this.data('module-mode') // Always "false" when importing into a new module.

      };
      $importDialog.find('#hustle-import-modal-options').html(template(templateData));

      if (isNew) {
        $submitButton.removeAttr('data-module-id'); // Bind the tabs again with their SUI actions.
        // Only the modal for importing a new module has tabs.

        SUI.tabs();
        $importDialog.find('.sui-tab-item').on('click', function () {
          var $tab = $(this),
              $radio = $('#' + $tab.data('label-for'));
          $radio.click();
        });
      } else {
        $submitButton.attr('data-module-id', moduleId);
      }

      SUI.openModal('hustle-dialog--import', e.currentTarget, this.$el.find('.hustle-modal-close')[0], true);
    },
    selectUploadFile: function selectUploadFile(e) {
      e.preventDefault();
      var $this = $(e.target),
          value = $this.val().replace(/C:\\fakepath\\/i, ''); // Hide previous error.

      SUI.closeNotice('hustle-dialog--import-error-notice');

      if (value) {
        $('.sui-upload-file span:first').text(value);
        $('.sui-upload').addClass('sui-has_file');
        $('#hustle-import-module-submit-button').prop('disabled', false);
      } else {
        $('.sui-upload').removeClass('sui-has_file');
        $('.sui-upload-file span:first').text('');
        $('#hustle-import-module-submit-button').prop('disabled', true);
      }
    },
    resetUploadFile: function resetUploadFile(e) {
      e.stopPropagation();
      $('#hustle-import-file-input').val('').trigger('change');
    },
    changeFile: function changeFile() {
      $('#hustle-import-file-input').trigger('click');
    },
    checkAll: function checkAll(e) {
      var $this = $(e.currentTarget),
          value = $this.is(':checked'),
          $container = $this.closest('.hui-inputs-list'),
          $checkboxes = $container.find('input.hustle-module-meta-checkbox:not(.hustle-import-check-all-checkbox)');
      $checkboxes.prop('checked', value);
    },
    uncheckAllOption: function uncheckAllOption(e) {
      var $this = $(e.currentTarget),
          $container = $this.closest('.hui-inputs-list'),
          $allCheckbox = $container.find('.hustle-import-check-all-checkbox'),
          isAllChecked = $allCheckbox.is(':checked');

      if (!isAllChecked) {
        return;
      }

      $allCheckbox.prop('checked', false);
    }
  });
});
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

Hustle.define('Mixins.Model_Updater', function ($) {
  'use strict';

  return {
    initMix: function initMix() {
      this.events = _.extend({}, this.events, this._events);
      this.delegateEvents();
    },
    _events: {
      'change textarea': '_updateText',
      'change input[type="text"]': '_updateText',
      'change input[type="url"]': '_updateText',
      'change input[type="hidden"]': '_updateText',
      'change input[type="number"]': '_updateText',
      'change input[type="checkbox"]': '_updateCheckbox',
      'change input[type=radio]': '_updateRadios',
      'change select': '_updateSelect'
    },
    _updateText: function _updateText(e) {
      var $this = $(e.target),
          attr = $this.data('attribute'),
          model = this[$this.data('model') || 'model'],
          opts = _.isTrue($this.data('silent')) ? {
        silent: true
      } : {};

      if (model && attr) {
        e.stopPropagation();
        model.set.call(model, attr, e.target.value, opts);
      }
    },
    _updateCheckbox: function _updateCheckbox(e) {
      var $this = $(e.target),
          attr = $this.data('attribute'),
          value = $this.val(),
          model = this[$this.data('model') || 'model'],
          opts = _.isTrue($this.data('silent')) ? {
        silent: true
      } : {};

      if (model && attr) {
        e.stopPropagation(); // If the checkboxes values should behave as an array, instead of as an on/off toggle.

        if ('on' !== value) {
          var newValue = [];
          var current = model.get.call(model, attr);

          if ($this.is(':checked')) {
            newValue = _toConsumableArray(current);
            newValue.push(value);
          } else {
            newValue = _.without(current, value);
          }

          model.set.call(model, attr, newValue, opts);
        } else {
          model.set.call(model, attr, $this.is(':checked') ? '1' : '0', opts);
        }
      }
    },
    _updateRadios: function _updateRadios(e) {
      var $this = $(e.target),
          attribute = $this.data('attribute'),
          model = this[$this.data('model') || 'model'],
          opts = _.isTrue($this.data('silent')) ? {
        silent: true
      } : {};

      if (model && attribute) {
        e.stopPropagation();
        model.set.call(model, attribute, e.target.value, opts);
      }
    },
    _updateSelect: function _updateSelect(e) {
      var $this = $(e.target),
          attr = $this.data('attribute'),
          model = this[$this.data('model') || 'model'],
          opts = _.isTrue($this.data('silent')) ? {
        silent: true
      } : {};

      if (model && attr) {
        e.stopPropagation();
        model.set.call(model, attr, $this.val(), opts);
      }
    }
  };
});
/* global moment, sprintf */
Hustle.define('Mixins.Module_Settings', function ($) {
  'use strict';

  return _.extend({}, Hustle.get('Mixins.Model_Updater'), {
    el: '#hustle-wizard-behaviour',
    events: {},
    triggersModel: null,
    init: function init(opts) {
      var self = this,
          Model = opts.BaseModel.extend({
        defaults: {},
        initialize: function initialize(data) {
          _.extend(this, data);

          var Triggers = Hustle.get('Models.Trigger');

          if (!(this.get('triggers') instanceof Backbone.Model)) {
            this.set('triggers', new Triggers(this.triggers), {
              silent: true
            });
            self.triggersModel = this.get('triggers');
          }
        }
      });
      this.model = new Model(optinVars.current.settings || {});
      this.moduleType = optinVars.current.data.module_type;
      var EditScheduleModalView = Hustle.get('Modals.EditSchedule');
      this.editScheduleView = new EditScheduleModalView({
        model: this.model
      });
      this.listenTo(this.model, 'change', this.viewChanged);

      if ('embedded' !== this.moduleType) {
        this.listenTo(this.model.get('triggers'), 'change', this.triggersViewChanged);
      } // Called just to trigger the "view.rendered" action.


      this.render();
    },
    render: function render() {
      this.renderScheduleSection();
      this.editScheduleView.on('schedule:updated', $.proxy(this.renderScheduleSection, this));
    },
    renderScheduleSection: function renderScheduleSection() {
      var _this = this;

      var template = Optin.template('hustle-schedule-row-tpl'),
          $container = $('#hustle-schedule-row'),
          scheduleSettings = this.model.get('schedule'),
          data = Object.assign({}, scheduleSettings),
          strings = {
        startDate: '',
        startTime: '',
        endDate: '',
        endTime: '',
        activeDays: '',
        activeTime: ''
      };
      var hasFinished = false;
      data.is_schedule = this.model.get('is_schedule'); // eslint-disable-line camelcase
      // Here we'll build the strings dependent on the selected settings. Skip if scheduling is disabled.

      if (data.is_schedule) {
        // Translated months and 'AM/PM' strings.
        var months = Object.assign({}, optinVars.schedule.months),
            meridiem = optinVars.schedule.meridiem; // Schedule start string. Skip if disabled.

        if ('0' === data.not_schedule_start) {
          var stringDate = data.start_date.split('/'),
              month = months[stringDate[0] - 1],
              ampm = meridiem[data.start_meridiem_offset];
          strings.startDate = "".concat(stringDate[1], " ").concat(month, " ").concat(stringDate[2]);
          strings.startTime = "(".concat(data.start_hour, ":").concat(data.start_minute, " ").concat(ampm, ")");
        } // Schedule end string. Skip if disabled.


        if ('0' === data.not_schedule_end) {
          var _stringDate = data.end_date.split('/'),
              _month = months[_stringDate[0] - 1],
              _ampm = meridiem[data.end_meridiem_offset];

          strings.endDate = "".concat(_stringDate[1], " ").concat(_month, " ").concat(_stringDate[2]);
          strings.endTime = "(".concat(data.end_hour, ":").concat(data.end_minute, " ").concat(_ampm, ")");
          hasFinished = this.isScheduleFinished(data);
        } // Selected weekdays string. Skip if 'every day' is selected.


        if ('week_days' === data.active_days) {
          var weekDays = optinVars.schedule.week_days,
              days = data.week_days.map(function (day) {
            return weekDays[day].toUpperCase();
          });
          strings.activeDays = days.join(', ');
        } // Per day start and end string. Skip if 'during all day' is enabled.


        if ('0' === data.is_active_all_day) {
          var startAmpm = meridiem[data.day_start_meridiem_offset],
              endAmpm = meridiem[data.day_end_meridiem_offset],
              dayStart = "".concat(data.day_start_hour, ":").concat(data.day_start_minute, " ").concat(startAmpm),
              dayEnd = "".concat(data.day_end_hour, ":").concat(data.day_end_minute, " ").concat(endAmpm);
          strings.activeTime = dayStart + ' - ' + dayEnd;
        }
      }

      data.strings = strings;
      data.hasFinished = hasFinished;
      $container.html(template(data));
      $container.find('.hustle-button-open-schedule-dialog').on('click', function () {
        return _this.editScheduleView.open();
      });
    },
    isScheduleFinished: function isScheduleFinished(settings) {
      var currentTime = new Date().getTime();
      var timeToUse = settings.time_to_use,
          date = settings.end_date,
          hour = settings.end_hour,
          minute = settings.end_minute,
          ampm = settings.end_meridiem_offset,
          dateString = "".concat(date, " ").concat(hour, ":").concat(minute, " ").concat(ampm);
      var endTimestamp = false,
          utcOffset = false;

      if ('server' === timeToUse) {
        utcOffset = optinVars.schedule.wp_gmt_offset;
      } else {
        var customTimezone = settings.custom_timezone; // It's using a manual UTC offset.

        if (customTimezone.includes('UTC')) {
          var selectedOffset = customTimezone.replace('UTC', ''); // There's a timezone with the value "UTC".

          utcOffset = selectedOffset.length ? parseFloat(selectedOffset) : 0;
        } else {
          var endMoment = moment.tz(dateString, 'MM/DD/YYYY hh:mm aa', customTimezone);
          endTimestamp = endMoment.format('x');
        }
      } // Calculate the timestamp with the manual offset.


      if (false === endTimestamp && false !== utcOffset) {
        var offset = 60 * utcOffset,
            sign = 0 < offset ? '+' : '-',
            abs = Math.abs(offset),
            formattedOffset = sprintf('%s%02d:%02d', sign, abs / 60, abs % 60);

        var _endMoment = moment.parseZone(dateString + ' ' + formattedOffset, 'MM/DD/YYYY hh:mm a Z');

        endTimestamp = _endMoment.format('x');
      } // Check if the end time already passed.


      if (currentTime > endTimestamp) {
        return true;
      }

      return false;
    },
    viewChanged: function viewChanged(model) {
      var changed = model.changed;

      if ('on_submit' in changed) {
        var $toggleDiv = this.$('#hustle-on-submit-delay-wrapper');

        if ($toggleDiv.length) {
          if ('nothing' !== changed.on_submit) {
            $toggleDiv.removeClass('sui-hidden');
          } else {
            $toggleDiv.addClass('sui-hidden');
          }
        }
      }
    },
    triggersViewChanged: function triggersViewChanged(model) {
      var changed = model.changed;

      if ('on_scroll' in changed) {
        var $scrolledContentDiv = this.$('#hustle-on-scroll--scrolled-toggle-wrapper'),
            $selectorContentDiv = this.$('#hustle-on-scroll--selector-toggle-wrapper');

        if ($scrolledContentDiv.length || $selectorContentDiv.length) {
          if ('scrolled' === changed.on_scroll) {
            $scrolledContentDiv.removeClass('sui-hidden');
            $selectorContentDiv.addClass('sui-hidden');
          } else {
            $selectorContentDiv.removeClass('sui-hidden');
            $scrolledContentDiv.addClass('sui-hidden');
          }
        }
      }
    }
  });
});
Hustle.define('Mixins.Module_Content', function () {
  'use strict';

  return _.extend({}, Hustle.get('Mixins.Model_Updater'), {
    el: '#hustle-wizard-content',
    events: {},
    init: function init(opts) {
      this.model = new opts.BaseModel(optinVars.current.content || {});
      this.moduleType = optinVars.current.data.module_type;
      this.listenTo(this.model, 'change', this.modelUpdated);
      this.render();
    },
    render: function render() {
      this.initImageUploaders();

      if ('true' === Module.Utils.getUrlParam('new')) {
        Module.Notification.open('success', optinVars.messages.module_created, 10000);
      }
    },
    initImageUploaders: function initImageUploaders() {
      var MediaHolder = Hustle.get('imageUploader'),
          attrsWithImageUpload = ['feature_image', 'background_image'];

      for (var _i = 0, _attrsWithImageUpload = attrsWithImageUpload; _i < _attrsWithImageUpload.length; _i++) {
        var attribute = _attrsWithImageUpload[_i];
        var $wrapper = this.$('#hustle-choose-' + attribute);

        if ($wrapper.length) {
          new MediaHolder({
            el: $wrapper,
            model: this.model,
            attribute: attribute,
            moduleType: this.moduleType
          });
        }
      }
    },
    modelUpdated: function modelUpdated(model) {
      Hustle.Events.trigger('modules.view.contentUpdate', model.changed);
    }
  });
});
function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/* global ace */
Hustle.define('Mixins.Module_Design', function ($) {
  'use strict';

  return _.extend({}, Hustle.get('Mixins.Model_Updater'), {
    el: '#hustle-wizard-appearance',
    cssEditor: false,
    fontFamilies: {},
    fontFamiliesOptions: [],

    /**
     * Keeps track of the updated properties.
     * It allows us to submit only the updated props during the AJAX save
     * and to avoid save issues with max_input_vars set on 1000.
     *
     * @since 4.3.0
     */
    updatedProperties: {},

    /**
     * Keeps track of which elements are shown.
     *
     * @since 4.3.0
     */
    contentPropIsShown: {
      title: true,
      sub_title: true,
      main_content: true,
      feature_image: true,
      background_image: true,
      show_never_see_link: true,
      show_cta: true
    },
    events: {
      'click .hustle-css-stylable': 'insertSelector',
      'click .hustle-reset-settings-block > button': 'resetSettingsBlock',
      'change [data-link-fields]': 'linkFieldsChanged',
      'change [data-linked-fields]': 'linkedFieldsChanged',
      'change .hustle-font-family-select': 'fontFamilyUpdated',
      'change select[name="feature_image_width_option"]': 'updateFeatureImageWidth',
      'click .sui-accordion-item': 'initiateFontFamilySelectOnAccordionClick',
      'click .hustle-button-apply-global-font': 'applyGlobalFontClicked',
      'change .hustle-required-field': 'requiredFieldChanged'
    },
    init: function init(opts) {
      this.model = new opts.BaseModel(optinVars.current.design || {});
      this.beforeRender();
      this.render();
    },
    beforeRender: function beforeRender() {
      var _this = this;

      this.listenTo(this.model, 'change', this.modelUpdated);
      Hustle.Events.on('modules.view.contentUpdate', function (changed) {
        return _this.contentModelUpdated(changed);
      });
      Hustle.Events.on('modules.view.emailsUpdate', function (changed) {
        return _this.emailsModelUpdated(changed);
      });
      Hustle.Events.on('modules.view.integrationsUpdate', function (changed) {
        return _this.integrationsModelUpdate(changed);
      });
      this.setFontFamilyOptions();
      this.setVisibilityOnRender();
    },
    render: function render() {
      this.toggleDeviceTabs();
      this.toggleCtaButtonsTextAlignment();
      this.setImageAligmentOptions();
      this.toggleFeatureImageSizeSettingRow();
      this.toggleFeatureImageSizeRows();
      this.createPickers();
      this.addCreatePalettesLink();
      this.cssEditor = this.createEditor('hustle_custom_css');
      this.setVanillaThemeVisibility(); // Hide other Options for Mobile Feature Image.

      this.hideOtherOptionsInAcordionItem('feature_image_hide_on_mobile', '1' === this.model.get('feature_image_hide_on_mobile'));
      this.hideOtherOptionsInAcordionItem('feature_image_position', !this.contentPropIsShown.feature_image);

      if (optinVars.current.is_optin) {
        this.setSucccessfulMessageOptionVisibility(optinVars.current.emails);
        this.formFieldsUpdated(optinVars.current.emails);
        this.updateMailchimpRelatedAccordions(optinVars.current.integrations_settings);
      } else {
        this.handleStyleChange();
      }

      var self = this;
      $.each(['title', 'sub_title', 'feature_image', 'background_image', 'show_cta', 'show_never_see_link', 'main_content'], function (index, key) {
        self.updateElementsRow(key);
      });
    },
    // ============================================================
    // Font-family.
    setFontFamilyOptions: function setFontFamilyOptions() {
      var _this2 = this;

      var optionsPromise = this.fetchFontFamilyOptions();
      optionsPromise.done(function (res) {
        _this2.fontFamilies = res.data;
        $.each(_this2.fontFamilies, function (id, data) {
          _this2.fontFamiliesOptions.push({
            id: id,
            text: data.label
          });
        });

        var $globalFontFamilySelect = _this2.$('.hustle-font-family-select[name="global_font_family"]');

        _this2.initiateFontFamilySelects($globalFontFamilySelect, true);

        _this2.toggleCustomFontInput($globalFontFamilySelect);
      });
    },
    fetchFontFamilyOptions: function fetchFontFamilyOptions() {
      var data = {
        action: 'hustle_fetch_font_families',
        _ajax_nonce: optinVars.typography.fetch_nonce
      };
      return $.post({
        url: ajaxurl,
        type: 'post',
        data: data
      });
    },
    initiateFontFamilySelectOnAccordionClick: function initiateFontFamilySelectOnAccordionClick(e) {
      var self = this;
      $(e.currentTarget).find('.hustle-font-family-select').each(function () {
        self.initiateFontFamilySelects($(this));
        self.toggleCustomFontInput($(this));
      });
    },
    initiateFontFamilySelects: function initiateFontFamilySelects($selects) {
      var force = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

      if ($selects.data('fonts-loaded') === false || force) {
        $selects.SUIselect2('destroy');
        $selects.SUIselect2({
          dropdownCssClass: 'sui-select-dropdown',
          data: this.fontFamiliesOptions
        });
        $selects.removeClass('sui-disabled');
        $selects.removeProp('disabled');
        $selects.data('fonts-loaded', true);
      }
    },
    fontFamilyUpdated: function fontFamilyUpdated(e) {
      var $select = $(e.currentTarget),
          weightName = $select.data('weight'),
          $weightSelect = this.$("[name=\"".concat(weightName, "\"]")),
          $weightSelectMobile = this.$("[name=\"".concat(weightName, "_mobile\"]")),
          selectedFamily = $select.val(),
          weightSelectOptions = [];
      var availableVariants;

      if (!!selectedFamily) {
        availableVariants = this.fontFamilies[selectedFamily].variants;
      }

      var selected = true;

      if ('undefined' !== typeof availableVariants) {
        var _iterator = _createForOfIteratorHelper(availableVariants),
            _step;

        try {
          for (_iterator.s(); !(_step = _iterator.n()).done;) {
            var variant = _step.value;
            weightSelectOptions.push({
              id: variant,
              text: variant,
              selected: selected
            });

            if (selected === true) {
              selected = false;
            }
          }
        } catch (err) {
          _iterator.e(err);
        } finally {
          _iterator.f();
        }

        $weightSelect.html(weightSelectOptions);
        $weightSelect.SUIselect2('destroy');
        $weightSelect.SUIselect2({
          dropdownCssClass: 'sui-select-dropdown',
          data: weightSelectOptions
        });
        $weightSelectMobile.html(weightSelectOptions);
        $weightSelectMobile.SUIselect2('destroy');
        $weightSelectMobile.SUIselect2({
          dropdownCssClass: 'sui-select-dropdown',
          data: weightSelectOptions
        });
      }

      this.toggleCustomFontInput($select);
    },
    applyGlobalFontClicked: function applyGlobalFontClicked(e) {
      var _this3 = this;

      var $applyButton = $(e.currentTarget);
      $applyButton.addClass('sui-button-onload');
      setTimeout(function () {
        _this3.applyGlobalFont();

        $applyButton.removeClass('sui-button-onload');
        Module.Notification.open('success', optinVars.typography.global_font_applied, 4000);
      }, 0);
    },
    applyGlobalFont: function applyGlobalFont() {
      var self = this,
          $selects = this.$('.hustle-font-family-select:not([name="global_font_family"])'),
          globalFont = this.model.get('global_font_family'),
          isCustom = 'custom' === globalFont,
          customGlobalFont = this.model.get('global_custom_font_family');
      var option;
      $selects.each(function () {
        var $select = $(this);

        if ($select.find('option[value="' + globalFont + '"]').length === 0) {
          option = new Option(globalFont, globalFont, true, false);
          $select.empty().val(null).append(option);
        } else {
          $select.val(globalFont);
        }

        $select.trigger('change');

        if (isCustom) {
          var customName = $select.data('custom'),
              $customField = self.$("input[name=\"".concat(customName, "\"]"));
          $customField.val(customGlobalFont).trigger('change');
        }

        self.toggleCustomFontInput($select);
      });
      this.globalFontVariantsUpdated(globalFont);
    },
    globalFontVariantsUpdated: function globalFontVariantsUpdated(fontFamily) {
      var $weightSelect = this.$('.hustle-font-weight'),
          availableVariants = this.fontFamilies[fontFamily].variants,
          weightSelectOptions = [];
      var selected = true;

      if ('undefined' !== typeof availableVariants) {
        var _iterator2 = _createForOfIteratorHelper(availableVariants),
            _step2;

        try {
          for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
            var variant = _step2.value;
            weightSelectOptions.push({
              id: variant,
              text: variant,
              selected: selected
            });

            if (selected === true) {
              selected = false;
            }
          }
        } catch (err) {
          _iterator2.e(err);
        } finally {
          _iterator2.f();
        }

        $weightSelect.html(weightSelectOptions);
        $weightSelect.SUIselect2('destroy');
        $weightSelect.SUIselect2({
          dropdownCssClass: 'sui-select-dropdown',
          data: weightSelectOptions
        });
      }
    },
    toggleCustomFontInput: function toggleCustomFontInput($select) {
      var selectedFamily = $select.val(),
          customName = $select.data('custom'),
          $customFieldWrapper = this.$("input[name=\"".concat(customName, "\"]")).closest('.sui-form-field');

      if ('custom' === selectedFamily) {
        Module.Utils.accessibleShow($customFieldWrapper);
      } else {
        Module.Utils.accessibleHide($customFieldWrapper);
      }
    },
    toggleDeviceTabs: function toggleDeviceTabs() {
      var $deviceTabsMenu = this.$('#hustle-device_settings-tabs > .sui-tabs-menu'),
          $deviceTabsContent = this.$('#hustle-device_settings-tabs > .sui-tabs-content'),
          $deviceTabs = this.$('#hustle-device_settings-tabs'),
          isMobileEnabled = '1' === this.model.get('enable_mobile_settings');

      if (!isMobileEnabled) {
        $deviceTabs.removeClass('hustle-mobile-enabled');
        $deviceTabsMenu.find('#tab-device_settings-desktop').trigger('click');
        $deviceTabsMenu.attr('aria-hidden', true);
        $deviceTabsMenu.attr('hidden', true);
        $deviceTabsContent.find('#tab-content-device_settings-desktop').removeAttr('role');
        $deviceTabsContent.find('#tab-content-device_settings-mobile').attr('aria-hidden', true);
      } else {
        $deviceTabs.addClass('hustle-mobile-enabled');
        $deviceTabsMenu.removeAttr('aria-hidden');
        $deviceTabsMenu.removeAttr('hidden');
        $deviceTabsContent.find('#tab-content-device_settings-desktop').attr('role', 'tabpanel');
        $deviceTabsContent.find('#tab-content-device_settings-mobile').removeAttr('aria-hidden');
      }
    },
    // ============================================================
    // Color Pickers
    createPickers: function createPickers() {
      var self = this,
          $suiPickerInputs = this.$('.sui-colorpicker-input');
      $suiPickerInputs.wpColorPicker({
        change: function change(event, ui) {
          var $this = $(this); // Prevent the model from being marked as changed on load.

          if ($this.val() !== ui.color.toCSS()) {
            $this.val(ui.color.toCSS()).trigger('change');
          }
        },
        palettes: ['#333333', '#FFFFFF', '#17A8E3', '#E1F6FF', '#666666', '#AAAAAA', '#E6E6E6']
      });

      if ($suiPickerInputs.hasClass('wp-color-picker')) {
        $suiPickerInputs.each(function () {
          var $suiPickerType = 'hex';
          var $suiPickerInput = $(this),
              $wpPicker = $suiPickerInput.closest('.wp-picker-container'),
              $wpPickerButton = $wpPicker.find('.wp-color-result'),
              $wpPickerAlpha = $wpPickerButton.find('.color-alpha'),
              $suiPicker = $suiPickerInput.closest('.sui-colorpicker-wrap'),
              $suiPickerColor = $suiPicker.find('.sui-colorpicker-value span[role=button]'),
              $suiPickerValue = $suiPicker.find('.sui-colorpicker-value'),
              $suiPickerClear = $suiPickerValue.find('button'),
              $shownInput = $suiPickerValue.find('.hustle-colorpicker-input'); // Check if alpha exists

          if (true === $suiPickerInput.data('alpha')) {
            $suiPickerType = 'rgba'; // Listen to color change

            $suiPickerInput.on('change', function (e, data) {
              // Change color preview
              $suiPickerColor.find('span').css({
                'background-color': $wpPickerAlpha.css('background')
              }); // We trigger this 'change' manually when the shown input changes.
              // Don't update its value again if this is the case.

              if ('undefined' === typeof data) {
                // Change color value
                $shownInput.val($suiPickerInput.val());
              }
            });
          } else {
            // Listen to color change
            $suiPickerInput.on('change', function (e, data) {
              // Change color preview
              $suiPickerColor.find('span').css({
                'background-color': $wpPickerButton.css('background-color')
              }); // We trigger this 'change' manually when the shown input changes.
              // Don't update its value again if this is the case.

              if ('undefined' === typeof data) {
                // Change color value
                $shownInput.val($suiPickerInput.val());
              }
            });
          } // Allow updating the colors without having to open the colorpicker.


          $shownInput.on('change', function () {
            // Change color value
            $suiPickerInput.val($shownInput.val());
            $suiPickerInput.trigger('change', [{
              triggeredByUs: true
            }]);
          }); // Add picker type class

          $suiPicker.find('.sui-colorpicker').addClass('sui-colorpicker-' + $suiPickerType); // Open iris picker

          $suiPicker.find('.sui-button, span[role=button]').on('click', function (e) {
            $wpPickerButton.click();
            e.preventDefault();
            e.stopPropagation();
          }); // Clear color value

          $suiPickerClear.on('click', function (e) {
            return self.colorPickerCleared(e, $suiPickerInput, self);
          });
        });
      }
    },
    colorPickerCleared: function colorPickerCleared(e, parentSuiPickerInput, parentSelf) {
      var inputName = parentSuiPickerInput.data('attribute'),
          selectedStyle = parentSelf.model.get('color_palette'),
          resetValue = optinVars.palettes[selectedStyle][inputName],
          $suiPicker = parentSuiPickerInput.closest('.sui-colorpicker-wrap'),
          $suiPickerValue = $suiPicker.find('.sui-colorpicker-value'),
          $suiPickerColor = $suiPicker.find('.sui-colorpicker-value span[role=button]'),
          $wpPicker = parentSuiPickerInput.closest('.wp-picker-container'),
          $wpPickerClear = $wpPicker.find('.wp-picker-clear');
      $wpPickerClear.click();
      $suiPickerValue.find('input').val(resetValue);
      parentSuiPickerInput.val(resetValue).trigger('change');
      $suiPickerColor.find('span').css({
        'background-color': resetValue
      });
      e.preventDefault();
      e.stopPropagation();
    },
    updatePickers: function updatePickers(selectedStyle) {
      var self = this;

      if ('undefined' !== typeof optinVars.palettes[selectedStyle]) {
        var colors = optinVars.palettes[selectedStyle]; // update color palettes

        _.each(colors, function (color, key) {
          self.$('input[data-attribute="' + key + '"]').val(color).trigger('change');
        });
      } // TODO: else, display an error message.

    },
    resetSettingsBlock: function resetSettingsBlock(e) {
      var $el = $(e.target);
      $el.addClass('sui-button-onload').prop('disabled', true);

      if ($el.closest('#hustle-color-palette').length) {
        // Reset Pickers
        var style = $('select[data-attribute="color_palette"]').val();
        this.updatePickers(style);
      } else {
        // Reset other block types
        var parent = $el.closest('.sui-accordion');
        var ev = jQuery.Event("click");
        ev.currentTarget = parent;
        this.initiateFontFamilySelectOnAccordionClick(ev);
        var settings = parent.find('[data-attribute]');
        settings.each(function () {
          var $field = $(this);
          var fieldName = $field.attr('name');

          if ('undefined' !== typeof optinVars.defaults[fieldName]) {
            var value = optinVars.defaults[fieldName],
                suiTabs = $field.parent('.sui-tabs');
            $field.val(value);

            if ('radio' !== $field.prop('type') || !$field.parent('.sui-tabs')) {
              // other cases
              $field.trigger('sui:change').trigger('change');
            } else {
              // changing SUI tabs
              $('#tab-' + fieldName + '-' + value, suiTabs).trigger('click');
            }
          }
        });
      }

      setTimeout(function () {
        $el.removeClass('sui-button-onload').prop('disabled', false);
      }, 500);
    },

    /**
     * Add the "Create custom palette button" to the existing palettes dropdown.
     *
     * @since 4.0.3
     */
    addCreatePalettesLink: function addCreatePalettesLink() {
      var $link = this.$('#hustle-create-palette-link'),
          $selectPaletteContainer = this.$('.select-container.hui-select-palette .list-results'),
          $selectButton = $selectPaletteContainer.find('.hui-button');

      if (!$selectButton.length) {
        $selectPaletteContainer.append($link);
      }
    },
    // ============================================================
    // CSS Editor
    createEditor: function createEditor(id) {
      var cssEditor = ace.edit(id);
      cssEditor.getSession().setMode('ace/mode/css');
      cssEditor.$blockScrolling = Infinity;
      cssEditor.setTheme('ace/theme/sui');
      cssEditor.getSession().setUseWrapMode(true);
      cssEditor.getSession().setUseWorker(false);
      cssEditor.setShowPrintMargin(false);
      cssEditor.renderer.setShowGutter(true);
      cssEditor.setHighlightActiveLine(true);
      return cssEditor;
    },
    updateCustomCss: function updateCustomCss() {
      if (this.cssEditor) {
        this.model.set('custom_css', this.cssEditor.getValue());
      }
    },
    insertSelector: function insertSelector(e) {
      var $el = $(e.target),
          stylable = $el.data('stylable') + '{}',
          cssEditor = this.cssEditor;
      cssEditor.navigateFileEnd();
      cssEditor.insert(stylable);
      cssEditor.navigateLeft(1);
      cssEditor.focus();
      e.preventDefault();
    },
    // ============================================================
    // Adjust the view when the Design model is updated.
    modelUpdated: function modelUpdated() {
      this.addUpdatedProperty();
      this.updateViewOnModelUpdate();
    },
    addUpdatedProperty: function addUpdatedProperty() {
      _.extend(this.updatedProperties, this.model.changed);
    },
    updateViewOnModelUpdate: function updateViewOnModelUpdate() {
      var model = this.model,
          //changed = model.changed,
      changedkey = Object.keys(model.changed)[0],
          actionToDo = this.getActionOnModelUpdated(changedkey);

      if ('undefined' !== typeof actionToDo) {
        actionToDo(changedkey);
      }
    },
    getActionOnModelUpdated: function getActionOnModelUpdated(changedKey) {
      var _this4 = this;

      var functions = {
        color_palette: function color_palette() {
          return _this4.updatePickers(_this4.model.changed.color_palette);
        },
        cta_buttons_alignment: function cta_buttons_alignment() {
          return _this4.toggleCtaButtonsTextAlignment();
        },
        cta_buttons_alignment_mobile: function cta_buttons_alignment_mobile() {
          return _this4.toggleCtaButtonsTextAlignment();
        },
        enable_mobile_settings: function enable_mobile_settings() {
          return _this4.toggleDeviceTabs();
        },
        feature_image_hide_on_mobile: function feature_image_hide_on_mobile(prop) {
          return _this4.hideOtherOptionsInAcordionItem(prop, '1' === _this4.model.get(prop));
        },
        feature_image_fit: function feature_image_fit(prop) {
          return _this4.toggleFeatureImageSizeSettingRow(prop);
        },
        // Hide other Options for Mobile Feature Image.
        feature_image_fit_mobile: function feature_image_fit_mobile(prop) {
          return _this4.toggleFeatureImageSizeSettingRow(prop);
        },
        feature_image_position: function feature_image_position() {
          return _this4.toggleFeatureImageSizeRows();
        },
        form_layout: function form_layout() {
          _this4.setImageAligmentOptions();

          _this4.toggleFeatureImageSizeRows();
        },
        style: function style() {
          return _this4.handleStyleChange();
        },
        use_vanilla: function use_vanilla() {
          return _this4.setVanillaThemeVisibility();
        }
      };
      return functions[changedKey];
    },
    toggleCtaButtonsTextAlignment: function toggleCtaButtonsTextAlignment() {
      var $ctaTypographyAccordionDesktop = this.$('#hustle-cta_alignment-form-field'),
          $ctaTypographyAccordionMobile = this.$('#hustle-cta_alignment_mobile-form-field');

      if ('full' === this.model.get('cta_buttons_alignment')) {
        Module.Utils.accessibleShow($ctaTypographyAccordionDesktop);
      } else {
        Module.Utils.accessibleHide($ctaTypographyAccordionDesktop);
      }

      if ('full' === this.model.get('cta_buttons_alignment_mobile')) {
        Module.Utils.accessibleShow($ctaTypographyAccordionMobile);
      } else {
        Module.Utils.accessibleHide($ctaTypographyAccordionMobile);
      }
    },
    hideOtherOptionsInAcordionItem: function hideOtherOptionsInAcordionItem(inputName, hide) {
      var $this = this.$('[name="' + inputName + '"]'),
          $parent = $this.closest('.sui-box'),
          $parentRow = $parent.find('.sui-box-settings-row').slice(0, 1),
          $nextRows = $parent.find('.sui-box-settings-row').slice(1);

      if (!hide) {
        $nextRows.removeClass('sui-hidden-important');
        $parentRow.removeClass('hustle-no-bottom-line');
      } else {
        $nextRows.addClass('sui-hidden-important');
        $parentRow.addClass('hustle-no-bottom-line');
      }
    },
    toggleFeatureImageSizeSettingRow: function toggleFeatureImageSizeSettingRow() {
      var changedKey = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

      if (!changedKey || 'feature_image_fit' === changedKey) {
        var $sizeRow = this.$('#hustle-feature-image-size-settings-row'),
            value = this.model.get('feature_image_fit');

        if ('none' !== value) {
          $sizeRow.show();
        } else {
          $sizeRow.hide();
        }
      }

      if (!changedKey || 'feature_image_fit_mobile' === changedKey) {
        var _$sizeRow = this.$('#hustle-feature-image-size-mobile-settings-row'),
            _value = this.model.get('feature_image_fit_mobile');

        if ('none' !== _value) {
          _$sizeRow.show();
        } else {
          _$sizeRow.hide();
        }
      }
    },
    handleStyleChange: function handleStyleChange() {
      var style = this.model.get('style'),
          $layoutMain = this.$('[data-name="module_cont"]'),
          $layoutHeader = this.$('[data-name="layout_header"]'),
          $layoutContent = this.$('[data-name="layout_content"]'),
          $layoutFooter = this.$('[data-name="layout_footer"]'); // Replace "Main Layout" classname on note field.

      if ('cabriolet' === style) {
        $layoutMain.find('.sui-accordion-item-title .sui-accordion-note').text('.hustle-layout-body');
      } else {
        $layoutMain.find('.sui-accordion-item-title .sui-accordion-note').text('.hustle-layout');
      } // Hide "Layout Content" and show "Layout Footer" row for Default (minimal) style.


      if ('minimal' !== style) {
        Module.Utils.accessibleHide($layoutContent);
        Module.Utils.accessibleHide($layoutFooter);
      } else {
        Module.Utils.accessibleShow($layoutContent);
        Module.Utils.accessibleShow($layoutFooter);
      } // Hide the "Layout Header" row for Compact (simple) layout.


      if ('simple' !== style) {
        Module.Utils.accessibleShow($layoutHeader);
      } else {
        Module.Utils.accessibleHide($layoutHeader);
      }
    },
    setVanillaThemeVisibility: function setVanillaThemeVisibility() {
      var vanillaElements = this.$('[data-toggle-content="use-vanilla"]'),
          $nonVanillaElements = this.$('[data-toggle-content="not-use-vanilla"]');

      if (this.model.get('use_vanilla') === '0') {
        Module.Utils.accessibleShow(vanillaElements, true);
        Module.Utils.accessibleHide($nonVanillaElements, true);
      } else {
        Module.Utils.accessibleHide(vanillaElements, true);
        Module.Utils.accessibleShow($nonVanillaElements, true);
      }
    },
    // Update linked fields values when re-linked.
    linkFieldsChanged: function linkFieldsChanged(e) {
      var $input = $(e.currentTarget); // Fields were unlinked. No need to do anything.

      if ('0' === $input.val()) {
        return;
      } // Fields were linked. Update their values using the first field's value.


      var linkName = $input.attr('name'),
          $linkedFields = this.$("[data-linked-fields=".concat(linkName, "]")),
          firstFieldVal = $linkedFields[0].value;
      $linkedFields.val(firstFieldVal).trigger('change', {
        updatedByUs: true
      });
    },
    // Keep linked fields linked on change.
    linkedFieldsChanged: function linkedFieldsChanged(e, data) {
      // The fields were updated manually by us. Bail out and don't trigger that infinite loop.
      if (data) {
        return;
      }

      var $input = $(e.currentTarget),
          linkName = $input.data('linked-fields'); // The fields are unlinked. Nothing to do here.

      if ('1' !== this.model.get(linkName)) {
        return;
      }

      var $linkedFields = this.$("[data-linked-fields=".concat(linkName, "]"));
      $linkedFields.val($input.val()).trigger('change', {
        updatedByUs: true
      });
    },
    requiredFieldChanged: function requiredFieldChanged(e) {
      var $field = $(e.currentTarget),
          isEmpty = 0 === $field.val().trim().length;

      if (isEmpty) {
        var fieldName = $field.attr('name');

        if ('undefined' !== typeof optinVars.defaults[fieldName]) {
          $field.val(optinVars.defaults[fieldName]);
        }
      }
    },
    // Show or hide the positions available for each form layout.
    setImageAligmentOptions: function setImageAligmentOptions() {
      var $targetAbove = this.$('#tab-feature_image_position-alignment-above'),
          $targetBelow = this.$('#tab-feature_image_position-alignment-below');

      if ('one' === this.model.get('form_layout')) {
        Module.Utils.accessibleShow($targetAbove, true);
        Module.Utils.accessibleShow($targetBelow, true);
      } else {
        var imgPosition = this.model.get('feature_image_position');

        if ('left' !== imgPosition && 'right' !== imgPosition) {
          this.$('#tab-feature_image_position-alignment-left').trigger('click'); // The model's isn't triggering a change of feature_image_position for some reason.
          // TODO: Find and fix that. Then remove this function call.

          this.toggleFeatureImageSizeRows();
        }

        Module.Utils.accessibleHide($targetAbove, true);
        Module.Utils.accessibleHide($targetBelow, true);
      }
    },
    toggleFeatureImageSizeRows: function toggleFeatureImageSizeRows() {
      var $widthRow = this.$('#hustle-feature_image_width-row'),
          $widthDescription = this.$('#hustle-feature-image-desktop-width-description'),
          $heightRow = this.$('#hustle-feature_image_height-row'),
          $heightDescription = this.$('#hustle-feature-image-desktop-height-description'),
          contentDependentProps = ['title', 'sub_title', 'show_cta', 'main_content'],
          formLayout = this.model.get('form_layout');

      var showHeight = function showHeight() {
        $heightRow.show();
        $heightDescription.show();
        $widthRow.hide();
        $widthDescription.hide();
      },
          showWidth = function showWidth() {
        $heightRow.hide();
        $heightDescription.hide();
        $widthRow.show();
        $widthDescription.show();
      },
          showBoth = function showBoth() {
        $heightRow.show();
        $heightDescription.hide();
        $widthRow.show();
        $widthDescription.show();
      }; // Use only the height field when there's no title, subtitle, cta, nor main content.


      var isFeatureImageOnly = true;

      for (var _i = 0, _contentDependentProp = contentDependentProps; _i < _contentDependentProp.length; _i++) {
        var prop = _contentDependentProp[_i];

        if (this.contentPropIsShown[prop]) {
          isFeatureImageOnly = false;
        }
      }

      if (isFeatureImageOnly && 'two' !== formLayout && 'four' !== formLayout) {
        showHeight();
        return;
      } // Informational modules never use the height other than in the case above.


      if (!optinVars.current.is_optin) {
        showWidth();
        return;
      }

      if ('three' === formLayout) {
        showHeight();
        return;
      }

      if ('four' === formLayout) {
        if (isFeatureImageOnly) {
          showWidth();
        } else {
          showBoth();
        }

        return;
      }

      var imageAlignment = this.model.get('feature_image_position');

      if ('below' === imageAlignment || 'above' === imageAlignment) {
        showHeight();
      } else {
        showWidth();
      }
    },
    updateFeatureImageWidth: function updateFeatureImageWidth(e) {
      var $predefinedSelect = $(e.currentTarget),
          predefinedValue = $predefinedSelect.val(),
          $widthValueInput = this.$('input[name="feature_image_width"]'); // TODO: implement the global handler for disable/enable.

      if ('custom' !== predefinedValue) {
        var $widthUnitSelect = this.$('select[name="feature_image_width_unit"]');
        $widthUnitSelect.val('%').trigger('sui:change').trigger('change');
        $widthValueInput.prop('disabled', true);
        $widthValueInput.val(predefinedValue).trigger('change');
      } else {
        $widthValueInput.prop('disabled', false);
      }
    },
    // ============================================================
    // Adjust the view according to the Content model.
    contentModelUpdated: function contentModelUpdated(changed) {
      var changedKey = Object.keys(changed)[0],
          actionToDo = this.getActionOnContentModelUpdated(changedKey);

      if ('undefined' !== typeof actionToDo) {
        actionToDo(changed, changedKey);
        this.toggleFeatureImageSizeRows();
        this.updateElementsRow(changedKey);
      }
    },
    setVisibilityOnRender: function setVisibilityOnRender() {
      this.contentPropIsShown.feature_image = '' !== optinVars.current.content.feature_image;
      this.contentPropIsShown.background_image = '' !== optinVars.current.content.background_image;
      this.contentPropIsShown.show_cta = '0' !== optinVars.current.content.show_cta;
      this.contentPropIsShown.title = '' !== optinVars.current.content.title;
      this.contentPropIsShown.sub_title = '' !== optinVars.current.content.sub_title;
      this.contentPropIsShown.show_never_see_link = '0' !== optinVars.current.content.show_never_see_link;
      this.contentPropIsShown.optin_form = optinVars.current.is_optin;
      this.contentPropIsShown.main_content = '' !== optinVars.current.content.main_content;
    },
    getActionOnContentModelUpdated: function getActionOnContentModelUpdated(changedKey) {
      var _this5 = this;

      var functions = {
        // Uploading a featured image makes the "Featured Image settings" show up in the "Appearance" tab.
        background_image: function background_image(changed) {
          return _this5.contentPropIsShown.background_image = '' !== changed.background_image;
        },
        // Update this view when "Feature image" is changed in the Content tab.
        feature_image: function feature_image(changed) {
          _this5.contentPropIsShown.feature_image = '' !== changed.feature_image;

          _this5.hideOtherOptionsInAcordionItem('feature_image_position', !_this5.contentPropIsShown.feature_image);
        },
        main_content: function main_content(changed) {
          return _this5.contentPropIsShown.main_content = '' !== changed.main_content;
        },
        show_cta: function show_cta(changed) {
          return _this5.contentPropIsShown.show_cta = '0' !== changed.show_cta;
        },
        show_never_see_link: function show_never_see_link(changed) {
          return _this5.contentPropIsShown.show_never_see_link = '0' !== changed.show_never_see_link;
        },
        sub_title: function sub_title(changed) {
          return _this5.contentPropIsShown.sub_title = '' !== changed.sub_title;
        },
        title: function title(changed) {
          return _this5.contentPropIsShown.title = '' !== changed.title;
        }
      };
      return functions[changedKey];
    },
    updateElementsRow: function updateElementsRow(changedKey) {
      var $row = this.$('#hustle-wizard-appearance-desktop, #hustle-wizard-appearance-mobiles');
      var $accordion = $row.find(".sui-accordion-item[data-name=\"".concat(changedKey, "\"]")),
          doShow = this.contentPropIsShown[changedKey];

      if (doShow) {
        $accordion.show();
      } else {
        $accordion.hide();
      } // The Advanced and Typography rows (the ones checked in the function)
      // always remain displayed for optin modules.


      if (!optinVars.current.is_optin) {
        this.updateRow(changedKey);
      } else {
        this.handleTypographyTabs(changedKey);
      }
    },
    updateRow: function updateRow(changedKey) {
      var rows = {
        'hustle-typography-elements-row': ['show_cta', 'title', 'sub_title', 'main_content'],
        'hustle-appearance-customize-elements-row': ['feature_image', 'background_image', 'show_cta']
      };
      var self = this;
      $.each(rows, function (rowClass, dependentProps) {
        if (dependentProps.includes(changedKey)) {
          var doShowRow = false;

          var _iterator3 = _createForOfIteratorHelper(dependentProps),
              _step3;

          try {
            for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
              var prop = _step3.value;

              if (self.contentPropIsShown[prop]) {
                doShowRow = true;
              }
            }
          } catch (err) {
            _iterator3.e(err);
          } finally {
            _iterator3.f();
          }

          if (doShowRow) {
            $('.' + rowClass).show();
          } else {
            $('.' + rowClass).hide();
          }
        }
      });
    },
    handleTypographyTabs: function handleTypographyTabs(changedKey) {
      var dependentProps = ['show_cta', 'title', 'sub_title', 'main_content'];

      if ('embedded' !== optinVars.current.data.module_type) {
        dependentProps.push('show_never_see_link');
      }

      if (dependentProps.includes(changedKey)) {
        var $tabs = this.$('.hustle-typography-tabs'),
            $tabsMenu = $tabs.find('.sui-tabs-menu');
        var doShowGeneralTab = false;

        var _iterator4 = _createForOfIteratorHelper(dependentProps),
            _step4;

        try {
          for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
            var prop = _step4.value;

            if (this.contentPropIsShown[prop]) {
              doShowGeneralTab = true;
            }
          }
        } catch (err) {
          _iterator4.e(err);
        } finally {
          _iterator4.f();
        }

        if (doShowGeneralTab) {
          Module.Utils.accessibleShow($tabsMenu);
        } else {
          Module.Utils.accessibleHide($tabsMenu);
          $tabs.find('#tab-custom-typography-optin').trigger('click');
          $tabs.find('#tab-custom-typography_mobile-optin').trigger('click');
        }
      }
    },
    // ============================================================
    // Adjust the view according to the Emails model.
    emailsModelUpdated: function emailsModelUpdated(changed) {
      var changedKey = Object.keys(changed)[0],
          actionToDo = this.getActionOnEmailsModelUpdated(changedKey);

      if ('undefined' !== typeof actionToDo) {
        actionToDo(changed, changedKey); //this.updateElementsRow( changedKey );
      }
    },
    getActionOnEmailsModelUpdated: function getActionOnEmailsModelUpdated(changedKey) {
      var _this6 = this;

      var functions = {
        form_elements: function form_elements(changed) {
          return _this6.formFieldsUpdated(changed);
        },
        after_successful_submission: function after_successful_submission(changed) {
          return _this6.setSucccessfulMessageOptionVisibility(changed);
        }
      };
      return functions[changedKey];
    },
    // TODO: Fix not working for colors.
    setSucccessfulMessageOptionVisibility: function setSucccessfulMessageOptionVisibility(model) {
      var $divSettings = this.$('[data-name="success_message"]');

      if ($divSettings.length > 0) {
        if ('show_success' === model.after_successful_submission) {
          $divSettings.show();
        } else {
          $divSettings.hide();
        }
      }
    },
    formFieldsUpdated: function formFieldsUpdated(model) {
      this.handleRecaptcha(model.form_elements);
      this.handleGdpr(model.form_elements);
      this.handleCalendar(model.form_elements);
    },

    /**
     * Triggered when 'form_elements' in the emails model is updated.
     *
     * @since 4.3.0
     *
     * @param {Object} formFields Current form field elements.
     */
    handleRecaptcha: function handleRecaptcha(formFields) {
      var $recaptchaSettings = this.$('[data-name="recaptcha"]');
      var recaptcha = false;

      if ('undefined' !== typeof formFields.recaptcha) {
        recaptcha = 'v3_recaptcha' === formFields.recaptcha.version && '0' === formFields.recaptcha.v3_recaptcha_show_badge || 'v2_invisible' === formFields.recaptcha.version && '0' === formFields.recaptcha.v2_invisible_show_badge;
      }

      if (recaptcha) {
        $recaptchaSettings.show();
      } else {
        $recaptchaSettings.hide();
      }
    },
    handleGdpr: function handleGdpr(formFields) {
      var $gdprSettings = this.$('[data-name="gdpr"]');

      if ('undefined' !== typeof formFields.gdpr) {
        $gdprSettings.show();
      } else {
        $gdprSettings.hide();
      }
    },
    handleCalendar: function handleCalendar(formFields) {
      var hasCalendar = false;

      for (var fieldSlug in formFields) {
        var field = formFields[fieldSlug];

        if ('calendar' === field.type) {
          hasCalendar = true;
          break;
        }
      }

      if (hasCalendar) {
        this.$('[data-name="calendar"]').show();
      } else {
        this.$('[data-name="calendar"]').hide();
      }
    },
    // ============================================================
    // Adjust the view according to the Integrations model.
    integrationsModelUpdate: function integrationsModelUpdate(model) {
      if ('active_integrations' in model.changed) {
        this.updateMailchimpRelatedAccordions(model.changed);
      }
    },
    updateMailchimpRelatedAccordions: function updateMailchimpRelatedAccordions(model) {
      var activeIntegrations = model.active_integrations.split(','),
          hasMailchimp = activeIntegrations.includes('mailchimp'),
          dependentProps = ['form_extras', 'checkbox', 'dropdown', 'select'];

      for (var _i2 = 0, _dependentProps = dependentProps; _i2 < _dependentProps.length; _i2++) {
        var prop = _dependentProps[_i2];

        if (hasMailchimp) {
          this.$("[data-name=\"".concat(prop, "\"]")).show();
        } else {
          this.$("[data-name=\"".concat(prop, "\"]")).hide();
        }
      }
    }
  });
});
Hustle.define('Mixins.Module_Display', function () {
  'use strict';

  return _.extend({}, Hustle.get('Mixins.Model_Updater'), {
    el: '#hustle-wizard-display',
    events: {},
    init: function init(opts) {
      this.model = new opts.BaseModel(optinVars.current.display || {});
      this.moduleType = optinVars.current.data.module_type;
      this.listenTo(this.model, 'change', this.viewChanged); // Called just to trigger the "view.rendered" action.

      this.render();
    },
    render: function render() {},
    viewChanged: function viewChanged() {}
  });
});
function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

Hustle.define('Mixins.Module_Emails', function ($) {
  'use strict';

  return _.extend({}, Hustle.get('Mixins.Model_Updater'), {
    el: '#hustle-wizard-emails',
    events: {
      'click .hustle-optin-field--add': 'addFields',
      'click .hustle-optin-field--edit': 'editField',
      'click .sui-builder-field': 'maybeEditField',
      'click .hustle-optin-field--delete': 'deleteFieldOnClick',
      'click ul.list-results li': 'setFieldOption',
      'click .hustle-optin-field--copy': 'duplicateField'
    },
    init: function init(opts) {
      this.model = new opts.BaseModel(optinVars.current.emails || {});
      this.listenTo(this.model, 'change', this.modelUpdated);
      this.render();
    },
    render: function render() {
      var self = this,
          formElements = this.model.get('form_elements'); // Add the already stored form fields to the panel.

      for (var fieldId in formElements) {
        var field = formElements[fieldId]; // Assign the defaults for the field, in case there's anything missing.

        formElements[fieldId] = _.extend({}, this.getFieldDefaults(field.type), field); // Submit is already at the bottom of the panel. We don't want to add it again.

        if ('submit' === fieldId) {
          continue;
        }

        self.addFieldToPanel(formElements[fieldId]);
      } // update form_elements for having default properties if they were lost for some reason


      this.model.set('form_elements', formElements, {
        silent: true
      }); // Initiate the sortable functionality to sort form fields' order.

      var sortableContainer = this.$('#hustle-form-fields-container').sortable({
        axis: 'y',
        containment: '.sui-box-builder'
      });
      sortableContainer.on('sortupdate', $.proxy(self.fieldsOrderChanged, self, sortableContainer));
      this.updateDynamicValueFields();
      return this;
    },

    /**
     * Handle the changes in the view when the model is updated.
     *
     * @since 4.3.0
     *
     * @param {Object} model The model for this view.
     */
    modelUpdated: function modelUpdated(model) {
      var changed = model.changed,
          changedKey = Object.keys(changed)[0],
          actionToDo = this.getActionOnModelUpdated(changedKey);

      if ('undefined' !== typeof actionToDo) {
        actionToDo(changed);
      }

      Hustle.Events.trigger('modules.view.emailsUpdate', changed);
    },

    /**
     * Launches events when some actions are made.
     *
     * @since 4.3.0
     *
     * @param {string} changedKey Action name.
     */
    getActionOnModelUpdated: function getActionOnModelUpdated(changedKey) {
      var _this = this;

      var functions = {
        auto_close_success_message: function auto_close_success_message() {
          return _this.autoCloseSuccessMessageUpdated();
        },
        form_elements: function form_elements() {
          return _this.updateDynamicValueFields();
        }
      };
      return functions[changedKey];
    },
    autoCloseSuccessMessageUpdated: function autoCloseSuccessMessageUpdated() {
      var $targetDiv = this.$('#section-auto-close-success-message .sui-row');

      if ('1' === this.model.get('auto_close_success_message')) {
        $targetDiv.removeClass('sui-hidden');
      } else {
        $targetDiv.addClass('sui-hidden');
      }
    },
    //reset all field selects
    resetDynamicValueFieldsPlaceholders: function resetDynamicValueFieldsPlaceholders() {
      this.$('select.hustle-field-options').html('');

      if (this.$('.hustle-fields-placeholders-options').length) {
        this.$('.hustle-fields-placeholders-options').html('');
      }
    },
    //update all field selects
    updateDynamicValueFields: function updateDynamicValueFields() {
      var formElements = this.model.get('form_elements');
      this.resetDynamicValueFieldsPlaceholders();

      for (var fieldId in formElements) {
        if ('submit' === fieldId || 'recaptcha' === fieldId || 'gdpr' === fieldId) {
          continue;
        }

        this.addFieldToDynamicValueFields(formElements[fieldId]);
        this.$('select.hustle-field-options').trigger('sui:change');
      } //set info notice for empty dynamic fields select


      this.$('div.select-list-container .list-results:empty').each(function () {
        var fieldType = $(this).closest('.select-container').find('select.hustle-field-options').data('type');
        $(this).html('<li style="cursor: default; pointer-events: none;">' + optinVars.form_fields.no_fields_of_type_notice.replace('{field_type}', fieldType) + '</li>');
      });
    },

    /**
     * Assign the new field order to the model. Triggered when the fields are sorted.
     *
     * @since 4.0.0
     * @param {Object} sortable jQuery sortable object.
     */
    fieldsOrderChanged: function fieldsOrderChanged(sortable) {
      var formElements = this.model.get('form_elements'),
          newOrder = sortable.sortable('toArray', {
        attribute: 'data-field-id'
      });
      var orderedFields = {};

      var _iterator = _createForOfIteratorHelper(newOrder),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var id = _step.value;
          orderedFields[id] = formElements[id];
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }

      orderedFields = _.extend({}, orderedFields, formElements);
      this.model.set('form_elements', orderedFields);
    },

    /**
     * Open the "Add new fields" modal.
     *
     * @since 4.0
     * @param {Event} e Event.
     */
    addFields: function addFields(e) {
      // Show dialog
      SUI.openModal('hustle-dialog--optin-fields', $(e.currentTarget)[0], this.$('#hustle-dialog--optin-fields .sui-box-header .sui-button-icon')[0], true);
      var OptinFieldsModalView = Hustle.get('Modals.Optin_Fields'),
          newFieldModal = new OptinFieldsModalView({
        model: this.model
      }); // Create the fields and append them to panel.

      newFieldModal.on('fields:added', $.proxy(this.addNewFields, this));
    },
    maybeEditField: function maybeEditField(e) {
      var $ct = $(e.target);

      if (!$ct.closest('.sui-dropdown').length) {
        this.editField(e);
      }
    },

    /**
     * Open the "edit field" modal.
     *
     * @since 4.0.0
     * @param {event} e Event.
     */
    editField: function editField(e) {
      var $button = $(e.target),
          fieldId = $button.closest('.sui-builder-field').data('field-id'),
          existingFields = this.model.get('form_elements'),
          field = existingFields[fieldId],
          fieldData = Object.assign({}, this.getFieldViewDefaults(field.type), field),
          EditFieldModalView = Hustle.get('Modals.Edit_Field'),
          editModalView = new EditFieldModalView({
        field: field,
        fieldData: fieldData,
        model: this.model
      });
      editModalView.on('field:updated', $.proxy(this.formFieldUpdated, this)); // Show dialog.

      SUI.openModal('hustle-dialog--edit-field', $button[0], this.$('#hustle-dialog--edit-field .sui-box-header .sui-button-icon')[0], true);
    },

    /**
     * Update the appearance of the form field row of the field that was updated.
     *
     * @since 4.0.0
     *
     * @param {Object} updatedField Field properties after the update.
     * @param {Object} changed Field properties that were updated.
     * @param {Object} oldField Field properties before the update.
     */
    formFieldUpdated: function formFieldUpdated(updatedField, changed, oldField) {
      if (!Object.keys(changed).length) {
        return;
      } // Name is the unique identifier.
      // If it changed, update the existing fields removing the old one and creating a new one.


      if ('name' in changed) {
        this.addNewFields(updatedField.type, updatedField, oldField.name);
        this.deleteField(oldField.name);
        return;
      }

      var $fieldRow = this.$('#hustle-optin-field--' + updatedField.name);

      if ('required' in changed) {
        var $requiredTag = $fieldRow.find('.sui-error'),
            isRequired = updatedField.required; // Show the "required" asterisk to this field's row.

        if (_.isTrue(isRequired)) {
          $requiredTag.show();
        } else if (_.isFalse(isRequired)) {
          // Hide the "required" asterisk to this field's row.
          $requiredTag.hide();
        }
      }

      if ('label' in changed) {
        this.updateDynamicValueFields();
        var $labelWrapper = $fieldRow.find('.hustle-field-label-text');
        $labelWrapper.text(updatedField.label);
      }
    },
    deleteFieldOnClick: function deleteFieldOnClick(e) {
      var $button = $(e.target),
          fieldName = $button.closest('.sui-builder-field').data('field-id');
      this.deleteField(fieldName);
    },
    setFieldOption: function setFieldOption(e) {
      var $li = $(e.target),
          val = $li.find('span:eq(1)').text(),
          $input = $li.closest('.sui-insert-variables').find('input[type="text"]');
      $input.val(val).trigger('change');
    },
    deleteField: function deleteField(fieldName) {
      var $fieldRow = this.$('#hustle-optin-field--' + fieldName),
          formElements = Object.assign({}, this.model.get('form_elements'));
      delete formElements[fieldName];
      this.model.set('form_elements', formElements);

      if (-1 !== jQuery.inArray(fieldName, ['gdpr', 'recaptcha'])) {
        $fieldRow.addClass('sui-hidden');
        $('#hustle-optin-insert-field--' + fieldName).prop('disabled', false).prop('checked', false);
      } else {
        $fieldRow.remove();
      }
    },
    duplicateField: function duplicateField(e) {
      var $button = $(e.target),
          fieldId = $button.closest('.sui-builder-field').data('field-id'),
          formElements = Object.assign({}, this.model.get('form_elements')),
          duplicatedField = Object.assign({}, formElements[fieldId]); // Remove 'name' because it should be an unique identifier. Will be added in 'add_new_fields'.

      delete duplicatedField.name; // Make the field deletable because it can't be deleted otherwise, and you'll have it stuck forevah.

      duplicatedField.can_delete = true; // eslint-disable-line camelcase

      this.addNewFields(duplicatedField.type, duplicatedField);
    },

    /**
     * Used to add new fields.
     *	When using form_fields, make sure only 1 type of each field is added.
     *	In other words, use field.type as an unique identifier.
     *
     * @since 4.0.0
     *
     * @param {Array|string} formFields Field or set of fields to add.
     * @param {Object} formFieldsData Field data to include in the new field.
     * @param {string|null} oldFieldName Field name before the update.
     */
    addNewFields: function addNewFields(formFields, formFieldsData) {
      var oldFieldName = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
      var self = this;
      var existingFields = Object.assign({}, this.model.get('form_elements'));

      if (Array.isArray(formFields)) {
        var _iterator2 = _createForOfIteratorHelper(formFields),
            _step2;

        try {
          for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
            var field = _step2.value;
            var fieldData = self.getFieldDefaults(field);

            if (formFieldsData && field in formFieldsData) {
              _.extend(fieldData, formFieldsData[field]);
            }

            self.addFieldToPanel(fieldData);
            existingFields[fieldData.name] = fieldData;
          }
        } catch (err) {
          _iterator2.e(err);
        } finally {
          _iterator2.f();
        }
      } else {
        var _fieldData = self.getFieldDefaults(formFields);

        if (formFieldsData) {
          _.extend(_fieldData, formFieldsData);
        }

        self.addFieldToPanel(_fieldData, oldFieldName);

        if (null === oldFieldName) {
          existingFields[_fieldData.name] = _fieldData;
        } else {
          var reorderExistingFields = [];
          jQuery.each(existingFields, function (index, data) {
            reorderExistingFields[index] = data;

            if (index === oldFieldName) {
              reorderExistingFields[_fieldData.name] = _fieldData;
            }
          });
          existingFields = reorderExistingFields;
        }
      }

      this.model.set('form_elements', existingFields);
    },

    /**
     * Add a field to the fields with dynamic values for the automated emails.
     * The field object must have all its core prop assigned. The views prop are assigned here.
     *
     * @since 4.0
     * @param {Object} field Properties of the field.
     */
    addFieldToDynamicValueFields: function addFieldToDynamicValueFields(field) {
      var option = $('<option/>', {
        value: field.name,
        'data-content': '{' + field.name + '}'
      }).text(field.label),
          listOption = "<li><button value=\"{".concat(field.name, "}\">").concat(field.label, "</button></li>");
      this.$('select.hustle-field-options:not([data-type]), select.hustle-field-options[data-type="' + field.type + '"]').append(option);

      if (this.$('.hustle-fields-placeholders-options').length) {
        this.$('.hustle-fields-placeholders-options').append(listOption);
      }
    },

    /**
     * Add a field to the fields pannel.
     * The field object must have all its core prop assigned. The views prop are assigned here.
     *
     * @since 4.0.0
     *
     * @param {Object} field Field properties to add.
     * @param {string|null} oldFieldName Old field name if we're updating a field's name.
     */
    addFieldToPanel: function addFieldToPanel(field) {
      var oldFieldName = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      var template = Optin.template('hustle-form-field-row-tpl'),
          $fieldsContainer = this.$('#hustle-form-fields-container');
      field = _.extend({}, this.getFieldViewDefaults(field.type), field);

      if (-1 !== jQuery.inArray(field.type, ['gdpr', 'recaptcha'])) {
        this.$('#hustle-optin-field--' + field.type).removeClass('sui-hidden');
        $('#hustle-optin-insert-field--' + field.type).prop('checked', true).prop('disabled', true);
      } else if (null === oldFieldName) {
        $fieldsContainer.append(template(field));
      } else {
        var $el = this.$('#hustle-optin-field--' + oldFieldName);

        if (0 < $el.length) {
          $el.after(template(field));
        } else {
          $fieldsContainer.append(template(field));
        }
      }
    },
    getNewFieldId: function getNewFieldId(fieldName) {
      var existingFields = Object.assign({}, this.model.get('form_elements'));
      var fieldId = fieldName;

      while (fieldId in existingFields && -1 === jQuery.inArray(fieldId, ['gdpr', 'recaptcha', 'submit'])) {
        fieldId = fieldName + '-' + Math.floor(Math.random() * 99);
      }

      return fieldId;
    },

    /**
     * Retrieve the default settings for each field type.
     * These are going to be stored.
     *
     * @since 4.0.0
     *
     * @param {string} fieldType The type of the field we're getting the defaults for.
     */
    getFieldDefaults: function getFieldDefaults(fieldType) {
      var fieldId = this.getNewFieldId(fieldType),
          defaults = {
        label: optinVars.form_fields.label[fieldType + '_label'],
        required: 'false',
        css_classes: '',
        type: fieldType,
        name: fieldId,
        required_error_message: optinVars.form_fields.required_error_message.replace('{field}', fieldType),
        validation_message: optinVars.form_fields.validation_message.replace('{field}', fieldType),
        placeholder: ''
      };

      switch (fieldType) {
        case 'timepicker':
          defaults.time_format = '12'; // eslint-disable-line camelcase

          defaults.time_hours = '9'; // eslint-disable-line camelcase

          defaults.time_minutes = '30'; // eslint-disable-line camelcase

          defaults.time_period = 'am'; // eslint-disable-line camelcase

          defaults.validation_message = optinVars.form_fields.time_validation_message; // eslint-disable-line camelcase

          defaults.required_error_message = optinVars.form_fields.is_required.replace('{field}', defaults.label); // eslint-disable-line camelcase

          defaults.validate = 'false';
          break;

        case 'datepicker':
          defaults.date_format = 'mm/dd/yy'; // eslint-disable-line camelcase

          defaults.validation_message = optinVars.form_fields.date_validation_message; // eslint-disable-line camelcase

          defaults.required_error_message = optinVars.form_fields.is_required.replace('{field}', defaults.label); // eslint-disable-line camelcase

          defaults.validate = 'false';
          break;

        case 'recaptcha':
          defaults.threshold = '0.5'; // eslint-disable-line camelcase

          defaults.version = 'v2_checkbox'; // eslint-disable-line camelcase

          defaults.recaptcha_type = 'compact'; // eslint-disable-line camelcase

          defaults.recaptcha_theme = 'light'; // eslint-disable-line camelcase

          defaults.v2_invisible_theme = 'light'; // eslint-disable-line camelcase

          defaults.recaptcha_language = 'automatic'; // eslint-disable-line camelcase

          defaults.v2_invisible_show_badge = '1'; // eslint-disable-line camelcase

          defaults.v2_invisible_badge_replacement = optinVars.form_fields.recaptcha_badge_replacement; // eslint-disable-line camelcase

          defaults.v3_recaptcha_show_badge = '1'; // eslint-disable-line camelcase

          defaults.v3_recaptcha_badge_replacement = optinVars.form_fields.recaptcha_badge_replacement; // eslint-disable-line camelcase

          defaults.validation_message = optinVars.form_fields.recaptcha_validation_message; // eslint-disable-line camelcase

          defaults.error_message = optinVars.form_fields.recaptcha_error_message; // eslint-disable-line camelcase

          break;

        case 'gdpr':
          defaults.gdpr_message = optinVars.form_fields.gdpr_message; // eslint-disable-line camelcase

          defaults.required = 'true';
          defaults.required_error_message = optinVars.form_fields.gdpr_required_error_message; // eslint-disable-line camelcase

          break;

        case 'email':
          defaults.validate = 'true';
          break;

        case 'url':
          defaults.required_error_message = optinVars.form_fields.url_required_error_message; // eslint-disable-line camelcase

          defaults.validate = 'true';
          break;

        case 'phone':
          defaults.validate = 'false';
          break;

        case 'hidden':
          defaults.default_value = 'user_ip'; // eslint-disable-line camelcase

          defaults.custom_value = ''; // eslint-disable-line camelcase

          break;

        case 'number':
        case 'text':
          defaults.required_error_message = optinVars.form_fields.cant_empty; // eslint-disable-line camelcase

          break;
      }

      return defaults;
    },

    /**
     * Retrieve the defaults for each field type's setting view.
     * These settings are intended to display the proper content of each field
     * in the wizard settings. These won't be stored.
     *
     * @since 4.0.0
     * @param {string} fieldType The field type.
     */
    getFieldViewDefaults: function getFieldViewDefaults(fieldType) {
      var defaults = {
        required: 'false',
        validated: 'false',
        placeholder_placeholder: optinVars.form_fields.label.placeholder,
        label_placeholder: '',
        name_placeholder: '',
        icon: 'send',
        css_classes: '',
        type: fieldType,
        name: fieldType,
        placeholder: optinVars.form_fields.label[fieldType + '_placeholder'],
        can_delete: true,
        fieldId: this.getNewFieldId(fieldType)
      };

      switch (fieldType) {
        case 'email':
          defaults.icon = 'mail';
          break;

        case 'name':
          defaults.icon = 'profile-male';
          break;

        case 'phone':
          defaults.icon = 'phone';
          break;

        case 'address':
          defaults.icon = 'pin';
          break;

        case 'url':
          defaults.icon = 'web-globe-world';
          break;

        case 'text':
          defaults.icon = 'style-type';
          break;

        case 'number':
          defaults.icon = 'element-number';
          break;

        case 'timepicker':
          defaults.icon = 'clock';
          break;

        case 'datepicker':
          defaults.icon = 'calendar';
          break;

        case 'recaptcha':
          defaults.icon = 'recaptcha';
          break;

        case 'gdpr':
          defaults.icon = 'gdpr';
          break;

        case 'hidden':
          defaults.icon = 'eye-hide';
          break;
      }

      return defaults;
    }
  });
});
Hustle.define('Module.IntegrationsView', function ($) {
  'use strict';

  var integrationsView = Hustle.View.extend(_.extend({}, Hustle.get('Mixins.Model_Updater'), {
    el: '#hustle-box-section-integrations',
    events: {
      'click .connect-integration': 'connectIntegration',
      'keypress .connect-integration': 'preventEnterKeyFromDoingThings'
    },
    init: function init(opts) {
      this.model = new opts.BaseModel(optinVars.current.integrations_settings || {});
      this.moduleId = optinVars.current.data.module_id;
      this.listenTo(this.model, 'change', function (model) {
        return Hustle.Events.trigger('modules.view.integrationsUpdate', model);
      });
      this.listenTo(Hustle.Events, 'hustle:providers:reload', this.renderProvidersTables);
      this.render();
    },
    render: function render() {
      var $notConnectedWrapper = this.$el.find('#hustle-not-connected-providers-section'),
          $connectedWrapper = this.$el.find('#hustle-connected-providers-section');

      if (0 < $notConnectedWrapper.length && 0 < $connectedWrapper.length) {
        this.renderProvidersTables();
      }
    },
    renderProvidersTables: function renderProvidersTables() {
      var self = this,
          data = {}; // Add preloader.

      this.$el.find('.hustle-integrations-display').html("<div class=\"sui-notice hustle-integration-loading-notice\">\n\t\t\t\t\t\t<div class=\"sui-notice-content\">\n\t\t\t\t\t\t\t<div class=\"sui-notice-message\">\n\n\t\t\t\t\t\t\t\t<span class=\"sui-notice-icon sui-icon-loader sui-loading sui-md\" aria-hidden=\"true\"></span>\n\t\t\t\t\t\t\t\t<p>".concat(optinVars.integrations.fetching_list, "</p>\n\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>"));
      data.action = 'hustle_provider_get_form_providers';
      data._ajax_nonce = optinVars.integrations.action_nonce; // eslint-disable-line camelcase

      data.data = {
        moduleId: this.moduleId
      };
      var ajax = $.post({
        url: ajaxurl,
        type: 'post',
        data: data
      }).done(function (result) {
        if (result && result.success) {
          var $activeIntegrationsInput = self.$el.find('#hustle-integrations-active-integrations'),
              $activeIntegrationsCount = self.$el.find('#hustle-integrations-active-count');
          self.$el.find('#hustle-not-connected-providers-section').html(result.data.not_connected);
          self.$el.find('#hustle-connected-providers-section').html(result.data.connected); // Prevent marking the model as changed on load.

          if ($activeIntegrationsInput.val() !== result.data.list_connected) {
            $activeIntegrationsInput.val(result.data.list_connected).trigger('change');
          } // Prevent marking the model as changed on load.


          if ($activeIntegrationsCount.val() !== String(result.data.list_connected_total)) {
            $activeIntegrationsCount.val(result.data.list_connected_total).trigger('change');
          }
        }
      }); // Remove preloader

      ajax.always(function () {
        self.$el.find('.sui-box-body').removeClass('sui-block-content-center');
        self.$el.find('.hustle-integration-loading-notice').remove();
      });
    },
    // Prevent the enter key from opening integrations modals and breaking the page.
    preventEnterKeyFromDoingThings: function preventEnterKeyFromDoingThings(e) {
      if (13 === e.which) {
        // the enter key code
        e.preventDefault();
      }
    },
    connectIntegration: function connectIntegration(e) {
      Module.integrationsModal.open(e);
    }
  }));
  return integrationsView;
});
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

Hustle.define('Mixins.Module_Visibility', function ($) {
  'use strict';

  return _.extend({}, Hustle.get('Mixins.Model_Updater'), {
    el: '#hustle-conditions-group',
    events: {
      'click .hustle-add-new-visibility-group': 'addNewGroup',
      'click .hustle-choose-conditions': 'openConditionsModal',
      'click .hustle-remove-visibility-group': 'removeGroup',
      'change .visibility-group-filter-type': 'updateAttribute',
      'change .visibility-group-show-hide': 'updateAttribute',
      'change .visibility-group-apply-on': 'updateGroupApplyOn'
    },
    init: function init(opts) {
      var Model = opts.BaseModel.extend({
        defaults: {
          conditions: ''
        },
        initialize: function initialize(data) {
          _.extend(this, data);

          if (!(this.get('conditions') instanceof Backbone.Model)) {
            /**
             * Make sure conditions is not an array
             */
            if (_.isEmpty(this.get('conditions')) && _.isArray(this.get('conditions'))) {
              this.conditions = {};
            }

            var hModel = Hustle.get('Model');
            this.set('conditions', new hModel(this.conditions), {
              silent: true
            });
          }
        }
      });
      this.model = new Model(optinVars.current.visibility || {});
      this.moduleType = optinVars.current.data.module_type;
      this.activeConditions = {};
      this.render();
      $('#hustle-general-conditions').on('click', $.proxy(this.switchConditions, this));
      $('#hustle-wc-conditions').on('click', $.proxy(this.switchConditions, this));
      this.groupId = '';
    },
    render: function render() {
      var self = this,
          groups = this.model.get('conditions').toJSON();

      if (!$.isEmptyObject(groups)) {
        for (var groupId in groups) {
          var group = this.model.get('conditions.' + groupId);

          if (!(group instanceof Backbone.Model)) {
            // Make sure it's not an array
            if (_.isEmpty(group) && _.isArray(group)) {
              group = {};
            }

            group = this.getConditionsGroupModel(group);
            self.model.set('conditions.' + groupId, group, {
              silent: true
            });
          }

          this.addGroupToPanel(group, 'render');
        }

        this.maybeToggleGroupsBin();
      } else {
        this.addNewGroup();
      }
    },
    afterRender: function afterRender() {
      this.bindRemoveConditions();
    },
    bindRemoveConditions: function bindRemoveConditions() {
      // Remove condition
      $('#hustle-conditions-group .hustle-remove-visibility-condition').off('click').on('click', $.proxy(this.removeCondition, this));
    },
    openConditionsModal: function openConditionsModal(e) {
      var self = this,
          $this = $(e.currentTarget),
          groupId = $this.data('group-id'),
          savedConditions = this.model.get('conditions.' + groupId),
          groupConditions = 'undefined' !== typeof savedConditions ? Object.keys(savedConditions.toJSON()) : [],
          VisibilityModalView = Hustle.get('Modals.Visibility_Conditions'),
          visibilityModal = new VisibilityModalView({
        groupId: groupId,
        conditions: groupConditions
      });
      visibilityModal.on('conditions:added', $.proxy(self.addNewConditions, self));
      this.groupId = groupId; // Show dialog.

      SUI.openModal('hustle-dialog--visibility-options', $this[0], this.$('#hustle-dialog--visibility-options .sui-box-header .sui-button-icon')[0], true);
    },
    addNewConditions: function addNewConditions(args) {
      var self = this,
          groupId = args.groupId,
          conditions = args.conditions,
          group = this.model.get('conditions.' + groupId);
      $.each(conditions, function (i, id) {
        if (group.get(id)) {
          // If this condition is already set for this group, abort. Prevent duplicated conditions in a group.
          return true;
        }

        self.addConditionToPanel(id, {}, groupId, group, 'new');
      });
      this.bindRemoveConditions();
      Hustle.Events.trigger('view.rendered', this);
    },
    addGroupToPanel: function addGroupToPanel(group, source) {
      // Render this group container.
      var groupId = group.get('group_id'),
          targetContainer = $('#hustle-visibility-conditions-box'),
          _template = Optin.template('hustle-visibility-group-box-tpl'),
          html = _template(_.extend({}, {
        groupId: groupId,
        apply_on_floating: group.get('apply_on_floating'),
        // eslint-disable-line camelcase
        apply_on_inline: group.get('apply_on_inline'),
        // eslint-disable-line camelcase
        apply_on_widget: group.get('apply_on_widget'),
        // eslint-disable-line camelcase
        apply_on_shortcode: group.get('apply_on_shortcode'),
        // eslint-disable-line camelcase
        show_or_hide_conditions: group.get('show_or_hide_conditions'),
        // eslint-disable-line camelcase
        filter_type: group.get('filter_type') // eslint-disable-line camelcase

      }));

      $(html).insertBefore(targetContainer.find('.hustle-add-new-visibility-group'));
      this.activeConditions[groupId] = {}; // Render each of this group's conditions.

      var self = this,
          conditions = group.toJSON();
      $.each(conditions, function (id, condition) {
        if ('object' !== _typeof(condition)) {
          // If this property is not an actual condition, like "group_id", or "filter_type",
          // continue. Check the next property as this isn't the condition we want to render.
          return true;
        }

        self.addConditionToPanel(id, condition, groupId, group, source);
      });
    },
    addConditionToPanel: function addConditionToPanel(id, condition, groupId, group, source) {
      if ('undefined' === typeof Optin.View.Conditions[id]) {
        return;
      }

      var thisCondition = new Optin.View.Conditions[id]({
        type: this.moduleType,
        model: group,
        groupId: groupId,
        source: source
      });

      if (!thisCondition) {
        return;
      }

      var $conditionsContainer = this.$('#hustle-visibility-group-' + groupId + ' .sui-box-builder-body'); // If there aren't other conditions rendered within the group, empty it for adding new conditions.

      if (!$conditionsContainer.find('.sui-builder-field').length) {
        $conditionsContainer.find('.sui-box-builder-message-block').hide();
        $conditionsContainer.find('.sui-button-dashed').show();
      }

      if ($.isEmptyObject(condition)) {
        group.set(id, thisCondition.getConfigs());
      } else {
        group.set(id, condition);
      }

      this.activeConditions[groupId][id] = thisCondition;
      $(thisCondition.$el).appendTo($conditionsContainer.find('.sui-builder-fields'));
      return thisCondition;
    },
    addNewGroup: function addNewGroup() {
      var group = this.getConditionsGroupModel(),
          groupId = group.get('group_id');
      this.model.set('conditions.' + groupId, group);
      this.addGroupToPanel(group, 'new');
      this.maybeToggleGroupsBin();
      Hustle.Events.trigger('view.rendered', this);
    },
    switchConditions: function switchConditions(e) {
      e.preventDefault();
      var $this = $(e.currentTarget),
          currentId = $this.prop('id');

      if ('hustle-wc-conditions' === currentId) {
        $('#hustle-dialog--visibility-options .general_condition').hide();
        $('#hustle-dialog--visibility-options .wc_condition').show();
      } else {
        $('#hustle-dialog--visibility-options .wc_condition').hide();
        $('#hustle-dialog--visibility-options .general_condition').show();
      }
    },
    removeGroup: function removeGroup(e) {
      var groupId = $(e.currentTarget).data('group-id'),
          $groupContainer = this.$('#hustle-visibility-group-' + groupId); // Remove the group from the model.

      delete this.activeConditions[groupId];
      this.model.get('conditions').unset(groupId); // Remove the group container from the page.

      $groupContainer.remove(); // If the last group was removed, add a new group so the page is not empty.

      if (!Object.keys(this.activeConditions).length) {
        this.addNewGroup();
      }

      this.maybeToggleGroupsBin();
    },
    removeCondition: function removeCondition(e) {
      var $this = $(e.currentTarget),
          conditionId = $this.data('condition-id'),
          groupId = $this.data('group-id'),
          $conditionsContainer = this.$('#hustle-visibility-group-' + groupId + ' .sui-box-builder-body'),
          thisCondition = this.activeConditions[groupId][conditionId];
      thisCondition.remove();
      delete this.activeConditions[groupId][conditionId];
      this.model.get('conditions.' + groupId).unset(conditionId);

      if (!$conditionsContainer.find('.sui-builder-field').length) {
        $conditionsContainer.find('.sui-box-builder-message-block').show();
      }

      this.bindRemoveConditions();
    },
    updateAttribute: function updateAttribute(e) {
      e.stopPropagation();
      var $this = $(e.target),
          groupId = $this.data('group-id'),
          attribute = $this.data('group-attribute'),
          value = $this.val(),
          group = this.model.get('conditions.' + groupId);
      group.set(attribute, value);
    },
    updateGroupApplyOn: function updateGroupApplyOn(e) {
      e.stopPropagation();
      var $this = $(e.target),
          groupId = $this.data('group-id'),
          attribute = $this.data('property'),
          value = $this.is(':checked'),
          group = this.model.get('conditions.' + groupId);

      if ('embedded' === this.moduleType && -1 !== $.inArray(attribute, ['apply_on_inline', 'apply_on_widget', 'apply_on_shortcode']) || 'social_sharing' === this.moduleType && -1 !== $.inArray(attribute, ['apply_on_floating', 'apply_on_inline', 'apply_on_widget', 'apply_on_shortcode'])) {
        group.set(attribute, value);
      }
    },
    getConditionsGroupModel: function getConditionsGroupModel(group) {
      if (!group) {
        var groupId = new Date().getTime().toString(16);

        if ('undefined' !== typeof this.model.get('conditions.' + groupId)) {// TODO: create another group_id while the group id exists.
        }

        group = {
          group_id: groupId,
          // eslint-disable-line camelcase
          show_or_hide_conditions: 'show',
          // eslint-disable-line camelcase
          filter_type: 'all' // eslint-disable-line camelcase

        };

        if ('embedded' === this.moduleType) {
          group.apply_on_inline = true; // eslint-disable-line camelcase

          group.apply_on_widget = true; // eslint-disable-line camelcase

          group.apply_on_shortcode = false; // eslint-disable-line camelcase
        } else if ('social_sharing' === this.moduleType) {
          group.apply_on_floating = true; // eslint-disable-line camelcase

          group.apply_on_inline = true; // eslint-disable-line camelcase

          group.apply_on_widget = true; // eslint-disable-line camelcase

          group.apply_on_shortcode = false; // eslint-disable-line camelcase
        }
      } else if ('embedded' === this.moduleType && (!group.apply_on_inline || !group.apply_on_widget || !group.apply_on_shortcode)) {
        if (!group.apply_on_inline) {
          group.apply_on_inline = true; // eslint-disable-line camelcase
        }

        if (!group.apply_on_widget) {
          group.apply_on_widget = true; // eslint-disable-line camelcase
        }

        if (!group.apply_on_shortcode) {
          group.apply_on_shortcode = false; // eslint-disable-line camelcase
        }
      } else if ('social_sharing' === this.moduleType && (!group.apply_on_floating || !group.apply_on_inline || !group.apply_on_widget || !group.apply_on_shortcode)) {
        if (!group.apply_on_floating) {
          group.apply_on_floating = true; // eslint-disable-line camelcase
        }

        if (!group.apply_on_inline) {
          group.apply_on_inline = true; // eslint-disable-line camelcase
        }

        if (!group.apply_on_widget) {
          group.apply_on_widget = true; // eslint-disable-line camelcase
        }

        if (!group.apply_on_shortcode) {
          group.apply_on_shortcode = false; // eslint-disable-line camelcase
        }
      }

      var hModel = Hustle.get('Model'),
          groupModel = new hModel(group);
      return groupModel;
    },

    /**
     * Prevent the last standing group from being removable
     * Enable again the "bin" icons to remove if there's more than 1 group.
     *
     * @since 4.1.0
     */
    maybeToggleGroupsBin: function maybeToggleGroupsBin() {
      var groups = this.model.get('conditions'),
          $groupsBin = $('#hustle-conditions-group .sui-box-builder-header .hustle-remove-visibility-group');

      if (1 === Object.keys(groups.toJSON()).length) {
        Module.Utils.accessibleHide($groupsBin);
      } else {
        Module.Utils.accessibleShow($groupsBin);
      }
    }
  });
});
/* global tinyMCE */
Hustle.define('Mixins.Wizard_View', function ($, doc, win) {
  'use strict';

  return {
    moduleType: '',
    el: '.sui-wrap-hustle',
    publishModal: {},
    previewView: null,
    events: {
      'click .sui-sidenav .sui-vertical-tab a': 'sidenav',
      'change select.sui-mobile-nav': 'sidenavMobile',
      'click a.hustle-go-to-tab': 'sidenav',
      'click a.notify-error-tab': 'sidenav',
      'click .hustle-action-save': 'saveChanges',
      'click .wpmudev-button-navigation': 'doButtonNavigation',
      'change #hustle-module-name': 'updateModuleName',
      'click #hustle-preview-module': 'previewModule',
      'blur input.sui-form-control': 'removeErrorMessage'
    },
    // ============================================================
    // Initialize Wizard
    init: function init(opts) {
      var _this = this;

      this.setTabsViews(opts);
      Hustle.Events.on('modules.view.switch_status', function (switchTo) {
        return _this.switchStatusTo(switchTo);
      });
      $(win).off('popstate', $.proxy(this.updateTabOnPopstate, this));
      $(win).on('popstate', $.proxy(this.updateTabOnPopstate, this));
      $(document).off('tinymce-editor-init', $.proxy(this.tinymceReady, this));
      $(document).on('tinymce-editor-init', $.proxy(this.tinymceReady, this));

      if ('undefined' !== typeof this._events) {
        this.events = $.extend(true, {}, this.events, this._events);
        this.delegateEvents();
      }

      var publishModal = Hustle.get('Modals.PublishFlow');
      this.publishModal = new publishModal();
      this.renderTabs();
      return this;
    },

    /**
     * Assign the tabs views to the object.
     * Overridden by social share.
     *
     * @param {Object} opts Views for each tab.
     */
    setTabsViews: function setTabsViews(opts) {
      this.contentView = opts.contentView;
      this.emailsView = opts.emailsView;
      this.designView = opts.designView;
      this.integrationsView = opts.integrationsView;
      this.visibilityView = opts.visibilityView;
      this.settingsView = opts.settingsView;
      this.moduleType = this.model.get('module_type');

      if ('embedded' === this.moduleType) {
        this.displayView = opts.displayView;
      }
    },
    // ============================================================
    // Render content

    /**
     * Render the tabs.
     * Overridden by social share.
     */
    renderTabs: function renderTabs() {
      // Content view
      this.contentView.delegateEvents(); // Emails view

      this.emailsView.delegateEvents(); // Integrations view

      this.integrationsView.d