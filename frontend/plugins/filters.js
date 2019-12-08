import Vue from 'vue'
import moment from 'moment-timezone'

Vue.filter('from_now', function (date) {
  if (!date) {
    return ''
  }

  return moment(date)
    .tz(moment.tz.guess())
    .fromNow()
})
