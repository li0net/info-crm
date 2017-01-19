Vue.component('picker', {
  template: '<div class="input-group date">' +
    '<input type="text" class="form-control" id="dp" v-model="vvv"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>' +
    //'<div id="dp"></div>' +
    '</div>',
  props: {
    vvv: {
      twoWay: true
    }
  },
  data: function() {
    return {};
  },
  ready: function() {
    console.log('jopa');
    // $(this.$el).children('input').first().datepicker({
    //   format: 'dd/mm/yyyy',
    //   autoclose: true
    // });
  },
});