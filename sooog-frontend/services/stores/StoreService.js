import ApplicationService from '@/services/ApplicationService'

class StoreService extends ApplicationService{
  resource = '/stores'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }
  async register (data) {
    return await this.post(`${this.resource}`,data)
  }

  //* **************************************************** *//
}
export default new StoreService
