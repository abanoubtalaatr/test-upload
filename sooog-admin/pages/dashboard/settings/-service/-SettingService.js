import ApplicationService from '@/services/ApplicationService'

class SettingService extends ApplicationService{
  resource = '/admin/settings'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async update (data) {
    return await this.post(`${this.resource}`, data)
  }
  //* **************************************************** *//
}
export default new SettingService
