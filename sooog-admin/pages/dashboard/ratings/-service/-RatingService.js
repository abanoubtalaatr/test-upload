import ApplicationService from '@/services/ApplicationService'

class RatingService extends ApplicationService{
  resource = '/admin/ratings'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async toggleStatus (id, data = {}) {
    return await this.put(`${this.resource}/${id}/toggle-status`, data)
  }
  //* **************************************************** *//
}
export default new RatingService
