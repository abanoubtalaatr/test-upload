import ApplicationService from '@/services/ApplicationService'

class BrandService extends ApplicationService{
  resource = '/brands'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  //* **************************************************** *//
}
export default new BrandService
