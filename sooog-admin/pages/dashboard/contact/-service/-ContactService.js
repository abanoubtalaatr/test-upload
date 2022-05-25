import ApplicationService from '@/services/ApplicationService'

class ContactService extends ApplicationService{
  resource = '/admin/contact-us'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async create (data) {
    return await this.post(`${this.resource}`, data)
  }

  async show (id) {
    return await this.get(`${this.resource}/${id}`)
  }

  async update (data, id) {
    return await this.put(`${this.resource}/${id}`, data)
  }

  async destroy (id) {
    return await this.delete(`${this.resource}/${id}`)
  }

  async excelExport (queryParam = {}) {
    return await this.get(`${this.resource}/export-to-excel${queryParam}`, {}, {responseType: 'arraybuffer'})
  }
  //* **************************************************** *//
}
export default new ContactService
