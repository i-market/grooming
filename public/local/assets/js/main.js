import $ from 'jquery';

global.App = {
  init: ($scope) => {
    $scope.find('.phone-mask').mask('+9 (999) 999-99-99');
  },
  initTaxiPage: () => {
    $(document).ready(() => {
      const $input = $('#taxi-request').find('input[name=option-id]');
      $('.taxi_tarif').each(function() {
        const $component = $(this);
        $component.find('.item').each(function() {
          const $item = $(this);
          const optionId = $item.attr('data-option-id');
          $item.find('.order').on('click', () => {
            $input.val(optionId);
          });
        });
      });
    });
  }
};

App.initHotelPage = () => {
  $(document).ready(() => {
    const $modalTemplate = $('#hotel-booking-template');
    const $modals = $('#hotel-booking-modals');
    $('.hotel-options').each(function() {
      const $component = $(this);
      $component.find('.order[data-option-id]').each(function() {
        const $button = $(this);
        $button.on('click', function() {
          const optionId = $button.attr('data-option-id');
          // try existing modal
          let $modal = $modals.find('[data-option-id="'+optionId+'"]');
          if (!$modal.length) {
            // instantiate a new one from the template
            $modal = $modalTemplate.clone(true);
            const $form = $modal.find('form');
            $modal.removeAttr('id');
            $modal.attr('data-option-id', optionId);
            $form.append('<input type="hidden" name="option-id" value="'+optionId+'">');
            $form.attr('ic-post-to', $modalTemplate.find('form').attr('data-post-to'));
            global.Intercooler.processNodes($form);
            // hacky
            App.init($form);
            $modal.appendTo($modals);
          }
          // defined in mockup/js/script.js
          global._openModal($modal);
        });
      });
    });
  });
};

$(document).ready(() => App.init($('body')));
Intercooler.ready(App.init);
