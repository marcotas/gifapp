import axios from 'axios'

const tenor = axios.create({
  baseURL: process.env.TENOR_BASE_URL
})

tenor.interceptors.request.use(function (request) {
  request.params = request.params || {}
  request.params.key = process.env.TENOR_API_KEY
  request.params.media_filter = 'basic'
  return request
})

export default (context, inject) => {
  context.$tenor = tenor
  inject('tenor', tenor)
}
