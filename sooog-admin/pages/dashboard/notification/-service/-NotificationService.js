import ApplicationService from '@/services/ApplicationService'

class NotificationService extends ApplicationService{
  resource = '/admin/notifications'
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

  async destroy (id) {
    return await this.delete(`${this.resource}/${id}`)
  }

  async excelExport (queryParam = {}) {
    return await this.get(`${this.resource}/exports${queryParam}`, {}, {responseType: 'arraybuffer'})
  }
  //* **************************************************** *//
}
export default new NotificationService
