import axios from 'axios'
import Form from './form'

export default class {
  constructor () {
    this.files = []
    this.file = null
    this.states = {
      PENDING: 'PENDING',
      UPLOADING: 'UPLOADING',
      PROCESSING: 'PROCESSING',
      COMPLETED: 'COMPLETED',
      FAILED: 'FAILED'
    }
    this.resetState()
  }

  get pending () {
    return this.status === this.states.PENDING
  }
  get uploading () {
    return this.status === this.states.UPLOADING
  }
  get processing () {
    return this.status === this.states.PROCESSING
  }
  get completed () {
    return this.status === this.states.COMPLETED
  }
  get failed () {
    return this.status === this.states.FAILED
  }

  resetState () {
    this.percentage = 0
    this.status = this.states.PENDING
    this.error = null
  }

  setFile (file) {
    this.file = file

    return this
  }

  async uploadTo (url, fieldName = 'file') {
    try {
      this.resetState()
      this.status = this.states.UPLOADING
      const form = new Form({ [fieldName]: this.file }, 'multipart')

      const response = await axios.post(url, form.multipartData(), {
        onUploadProgress: this.onUploadProgress.bind(this)
      })

      this.status = this.states.COMPLETED

      return response
    } catch (error) {
      this.status = this.states.FAILED
      this.error = error
    }
  }

  onUploadProgress (progressEvent) {
    this.percentage = Math.round(
      (progressEvent.loaded * 100) / progressEvent.total
    )
    if (this.percentage === 100) {
      this.status = this.states.PROCESSING
    }
  }
}
