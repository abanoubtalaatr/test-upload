import ApplicationService from '@/services/ApplicationService'

class CartService extends ApplicationService{
  resource = '/cart'

  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async create (data) {
    return await this.post(`${this.resource}`, data)
  }

  async update (data) {
    return await this.put(`${this.resource}`, data)
  }

  async destroy (data) {
    debugger
    return await this.delete(`${this.resource}`, data)
  }

  //* **************************************************** *//
}
export default new CartService
