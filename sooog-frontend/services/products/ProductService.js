import ApplicationService from '@/services/ApplicationService'

class ProductService extends ApplicationService{
  resource = '/products'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async getOffers (queryParam = {}) {
    return await this.get(`/offers${queryParam}`)
  }

  //* **************************************************** *//
}
export default new ProductService
