import ApplicationService from '@/services/ApplicationService'

class FavouriteService extends ApplicationService{
  resource = '/favourites'

  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async create (data) {
    return await this.post(`${this.resource}`, data)
  }

  async destroy (data) {
    return await this.delete(`${this.resource}`, data)
  }

  //* **************************************************** *//
}
export default new FavouriteService
