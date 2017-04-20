import $ from 'jquery';

global.App = {
  // es5
  initHotelPage: function() {
    $(document).ready(function() {
      var $modalTemplate = $('#hotel-booking-template');
      var $modals = $('#hotel-booking-modals');
      $('.hotel-options').each(function() {
        var $component = $(this);
        $component.find('.order[data-option-id]').each(function() {
          var $button = $(this);
          $button.on('click', function() {
            var optionId = $button.attr('data-option-id');
            // try existing modal
            var $modal = $modals.find('[data-option-id="'+optionId+'"]');
            if (!$modal.length) {
              // instantiate a new one from the template
              $modal = $modalTemplate.clone(true);
              $modal.removeAttr('id');
              $modal.attr('data-option-id', optionId);
              $modal.find('form').append('<input type="hidden" name="option-id" value="'+optionId+'">');
              $modal.appendTo($modals);
            }
            // defined in mockup/js/script.js
            global._openModal($modal);
          });
        });
      });
    });
  }
};
