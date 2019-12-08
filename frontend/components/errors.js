import Vue from 'vue'

export default class {
  constructor () {
    this.errors = {}
  }

  has (field) {
    return this.errors.hasOwnProperty(field)
  }

  any () {
    return Object.keys(this.errors).length > 0
  }

  all (fields = []) {
    const errors = []
    for (const field in this.errors) {
      if (fields.length && !fields.includes(field)) {
        continue
      }
      errors.push(this.get(field))
    }
    return errors.filter((item, index, array) => array.indexOf(item) === index) // remove duplicates
  }

  get (field) {
    if (this.errors[field]) {
      return this.errors[field][0]
    }
  }

  record (errors) {
    Vue.set(this, 'errors', errors)
  }

  clear (field) {
    if (field) {
      Vue.delete(this.errors, field)

      return
    }

    this.errors = {}
  }
}
