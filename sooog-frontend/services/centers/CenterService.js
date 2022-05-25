import ApplicationService from '@/services/ApplicationService'

class CenterService extends ApplicationService{
  resource = '/centers'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  //* **************************************************** *//
}
export default new CenterService
