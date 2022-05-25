import ApplicationService from '@/services/ApplicationService'

class RatingService extends ApplicationService{
  resource = '/ratings'

  //* **************************************************** *//
  async getAll (id, queryParam = {}) {
    return await this.get(`/products/${id}/ratings${queryParam}`)
  }

  async create (data) {
    return await this.post(`${this.resource}`, data)
  }

  async destroy (data) {
    return await this.delete(`${this.resource}`, data)
  }

  //* **************************************************** *//
}
export default new RatingService
